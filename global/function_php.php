<?php

///////////////////////////////////////
////////////  DB_CONNECT  /////////////
///////////////////////////////////////

function db_connect()
{
    // A variável estática mantém a conexão salva na memória durante toda a execução do script
    static $pdo = null;

    // Se já conectou antes, apenas retorna a conexão existente (não abre duas conexões)
    if ($pdo !== null) {
        return $pdo;
    }

    $host = "192.168.122.36";
    $port = "5432";
    $dbname = "si";
    $user = "si";
    $passwd = "estudos";
    
    $dsn = "pgsql:host={$host};port={$port};dbname={$dbname}";
    
    try {
        $pdo = new PDO($dsn, $user, $passwd);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        // Devolve os valores como string, igual às funções pg_* que o código legado usava.
        $pdo->setAttribute(PDO::ATTR_STRINGIFY_FETCHES, true);
        return $pdo;
    } catch (PDOException $e) {
        die("The server ".$host." seems to be have many problem. Please try again in a few time.");
    }
}


///////////////////////////////////////
////////////   DB_QUERY   /////////////
///////////////////////////////////////

// Resultado de uma consulta. Guarda todas as linhas (com chaves numéricas E associativas,
// como o antigo pg_fetch_array) e oferece acesso compatível com o código legado:
//  - métodos estilo PDOStatement: ->fetch($modo), ->fetchAll($modo), ->rowCount()
//  - acesso por índice $res[$i], count($res) e foreach (ArrayAccess/Countable/Iterator)
//  - funções procedurais db_fetch_row(), db_num_rows(), db_result()... (ver abaixo)
class DbResult implements ArrayAccess, Countable, Iterator
{
    public $rows;       // linhas no formato PDO::FETCH_BOTH
    public $affected;   // linhas afetadas (INSERT/UPDATE/DELETE)
    public $pos = 0;    // cursor interno (fetch sequencial)

    public function __construct(PDOStatement $stmt)
    {
        $this->affected = $stmt->rowCount();
        try {
            $this->rows = $stmt->fetchAll(PDO::FETCH_BOTH);
        } catch (PDOException $e) {
            // consultas sem conjunto de resultados (INSERT/UPDATE/DELETE)
            $this->rows = array();
        }
    }

    // Projeta uma linha FETCH_BOTH para o modo pedido.
    private function proj($row, $modo)
    {
        if ($row === null || $row === false) return false;
        if ($modo == PDO::FETCH_NUM) {
            $r = array();
            foreach ($row as $k => $v) if (is_int($k)) $r[] = $v;
            return $r;
        }
        if ($modo == PDO::FETCH_ASSOC) {
            $r = array();
            foreach ($row as $k => $v) if (!is_int($k)) $r[$k] = $v;
            return $r;
        }
        if ($modo == PDO::FETCH_OBJ) {
            return (object)$this->proj($row, PDO::FETCH_ASSOC);
        }
        return $row; // FETCH_BOTH
    }

    // Projeção de uma linha pelo índice (para o acesso aleatório das db_fetch_*).
    public function proj_num($i)   { return isset($this->rows[$i]) ? $this->proj($this->rows[$i], PDO::FETCH_NUM) : false; }
    public function proj_assoc($i) { return isset($this->rows[$i]) ? $this->proj($this->rows[$i], PDO::FETCH_ASSOC) : false; }

    public function fetch($modo = PDO::FETCH_BOTH)
    {
        if (!isset($this->rows[$this->pos])) return false;
        return $this->proj($this->rows[$this->pos++], $modo);
    }

    public function fetchAll($modo = PDO::FETCH_BOTH)
    {
        $out = array();
        foreach ($this->rows as $r) $out[] = $this->proj($r, $modo);
        return $out;
    }

    public function fetchColumn($col = 0)
    {
        $row = $this->fetch(PDO::FETCH_NUM);
        if ($row === false) return false;
        return isset($row[$col]) ? $row[$col] : false;
    }

    public function rowCount() { return count($this->rows) ? count($this->rows) : $this->affected; }

    // ArrayAccess / Countable / Iterator (acesso por índice e foreach)
    public function offsetExists($o) { return isset($this->rows[$o]); }
    public function offsetGet($o) { return isset($this->rows[$o]) ? $this->rows[$o] : null; }
    public function offsetSet($o, $v) { if ($o === null) $this->rows[] = $v; else $this->rows[$o] = $v; }
    public function offsetUnset($o) { unset($this->rows[$o]); }
    public function count() { return count($this->rows); }
    public function current() { return $this->rows[$this->pos]; }
    public function key() { return $this->pos; }
    public function next() { $this->pos++; }
    public function rewind() { $this->pos = 0; }
    public function valid() { return isset($this->rows[$this->pos]); }
}

// Executa uma consulta parametrizada (Prepared Statement) e devolve um DbResult.
// Os valores vão sempre em $params, nunca concatenados no SQL.
// $pdo permite usar outra conexão (ex.: scripts com usuário de banco próprio).
function db_query($sql, array $params = array(), $pdo = null)
{
    if ($pdo === null) {
        $pdo = db_connect();
    }

    // O código legado concatenava os valores no SQL ('".$x."'): null/false viravam '' e true virava '1'.
    // Mantém essa conversão para não mudar o resultado das consultas existentes.
    $valores = array();
    foreach ($params as $valor) {
        if ($valor === null || $valor === false) $valor = '';
        elseif ($valor === true) $valor = '1';
        $valores[] = (string)$valor;
    }

    try {
        $stmt = $pdo->prepare($sql);
        $stmt->execute($valores);
        return new DbResult($stmt);
    } catch (PDOException $e) {
        error_log("db_query: " . $e->getMessage() . " | SQL: " . $sql);
        die(error());
    }
}

// Escapa um valor para ser embutido com segurança numa SQL montada dinamicamente
// (usado só onde placeholders não cabem: WHERE/colunas/tabelas variáveis). Devolve o
// valor JÁ ENTRE ASPAS e com escape do driver. $pdo opcional para outra conexão.
function db_quote($valor, $pdo = null)
{
    if ($pdo === null) $pdo = db_connect();
    if ($valor === null) return 'NULL';
    return $pdo->quote((string)$valor);
}

// Funções compatíveis com as pg_* (para a conversão mecânica do código legado).
function db_num_rows($r)            { return $r === false ? 0 : count($r->rows); }
function db_affected_rows($r)       { return $r === false ? 0 : $r->affected; }
function db_fetch_row($r, $i = null)    { if ($r === false) return false; if ($i === null) return $r->fetch(PDO::FETCH_NUM); return isset($r->rows[$i]) ? $r->proj_num($i) : false; }
function db_fetch_array($r, $i = null)  { if ($r === false) return false; if ($i === null) return $r->fetch(PDO::FETCH_BOTH); return isset($r->rows[$i]) ? $r->rows[$i] : false; }
function db_fetch_assoc($r, $i = null)  { if ($r === false) return false; if ($i === null) return $r->fetch(PDO::FETCH_ASSOC); return isset($r->rows[$i]) ? $r->proj_assoc($i) : false; }
function db_fetch_object($r, $i = null) { if ($r === false) return false; if ($i === null) return $r->fetch(PDO::FETCH_OBJ); return isset($r->rows[$i]) ? (object)$r->proj_assoc($i) : false; }
function db_fetch_all($r)           { return $r === false ? array() : $r->fetchAll(PDO::FETCH_ASSOC); }
function db_result($r, $i, $j = 0)  { if ($r === false || !isset($r->rows[$i])) return false; return isset($r->rows[$i][$j]) ? $r->rows[$i][$j] : false; }
function db_free_result($r)         { return true; }
function db_close($c = null)         { return true; }
function db_last_error($c = null)    { return ''; }


///////////////////////////////////////
////////////     ERROR    /////////////
///////////////////////////////////////

function error($error="")
{
    if (empty($error)) {
        $error = "This maybe come to the server. Please try again in a few minutes and contact an administrator if the probleme go on.";
    }
    
    // Evita XSS (Cross-Site Scripting) na exibição da mensagem
    $safe_error = htmlspecialchars($error, ENT_QUOTES, 'UTF-8');
?>
<html>
  <body>
    <table width="100%" height="100%" bgcolor="#aaaaaa">
    <tr valign="bottom" height="50%">
      <td align="center">
        <h1><b>An error has occured.</b></h1>
      </td>
    </tr>
    <tr valign="top">
      <td align="center">
        <?php echo $safe_error; ?>
      </td>
    </tr>
    </table>
  </body>
</html>
<?php
}


///////////////////////////////////////
////////// VERIF_SESSION_IP ///////////
///////////////////////////////////////

function verif_session_ip()
{
    $pdo = db_connect(); // Pega a conexão ativa de forma segura
    
    $ip = $_SERVER['REMOTE_ADDR'];
    $id = session_id();
    
    $query = "SELECT 1 FROM ident WHERE ip = :ip AND session = :session LIMIT 1";
    
    try {
        $stmt = $pdo->prepare($query);
        $stmt->execute([
            ':ip' => $ip, 
            ':session' => $id
        ]);
        
        if ($stmt->fetchColumn() !== false) {
            return true;
        }
        return false;
        
    } catch (PDOException $e) {
        die(error());
    }
}


///////////////////////////////////////
////////// VERIF_PASS_LOGIN ///////////
///////////////////////////////////////

function verif_pass_login($login, $pass)
{
    $pdo = db_connect(); // Pega a conexão ativa
    
    $hashed_pass = md5($pass); 
    
    $query = "SELECT 1 FROM admin WHERE login = :login AND passwd = :passwd LIMIT 1";
    
    try {
        $stmt = $pdo->prepare($query);
        $stmt->execute([
            ':login' => $login,
            ':passwd' => $hashed_pass
        ]);
        
        if ($stmt->fetchColumn() !== false) {
            return true;
        }
        return false;
        
    } catch (PDOException $e) {
        die(error());
    }
}


///////////////////////////////////////
////////// CLEAR_SESSION_IP ///////////
///////////////////////////////////////

function clear_session_ip()
{
    $pdo = db_connect(); // Pega a conexão ativa
    
    $limit_datetime = strtotime("-15 minutes");
    $limit_date = date("Y-m-d", $limit_datetime);
    $limit_time = date("H:i:s", $limit_datetime);
    
    $query = "DELETE FROM ident WHERE (date = :date AND time <= :time) OR date < :date2";
    
    try {
        $stmt = $pdo->prepare($query);
        $stmt->execute([
            ':date' => $limit_date,
            ':time' => $limit_time,
            ':date2' => $limit_date
        ]);
    } catch (PDOException $e) {
        die(error());
    }
}


///////////////////////////////////////
/////////  RECORD_SESSION_IP  /////////
///////////////////////////////////////

function record_session_ip()
{
    $pdo = db_connect(); // Pega a conexão ativa
    
    $ip = $_SERVER['REMOTE_ADDR'];
    $session = session_id();
    $fai = gethostbyaddr($ip);
    $date = date("Y-m-d");
    $time = date("H:i:s");
    
    $query = "INSERT INTO ident (session, ip, date, time, fai) VALUES (:session, :ip, :date, :time, :fai)";
    
    try {
        $stmt = $pdo->prepare($query);
        $stmt->execute([
            ':session' => $session,
            ':ip' => $ip,
            ':date' => $date,
            ':time' => $time,
            ':fai' => $fai
        ]);
    } catch (PDOException $e) {
        die(error());
    }
}


///////////////////////////////////////
//////////      SECURE       //////////
///////////////////////////////////////

function secure($login, $pass, $idmodule)
{
    if (!isset($_SESSION['tentatives'])) {
        $_SESSION['tentatives'] = 0;
    }

    if ($_SESSION['tentatives'] > 8) {
        return false;
    }

    if (isset($_SESSION['login']) && isset($_SESSION['passwd']) && !verif_session_ip()) {
        clear_session_ip();
        session_destroy();
        return false;
    }

    if (verif_pass_login($login, $pass)) {
        $_SESSION['login'] = $login;
        $_SESSION['passwd'] = $pass;
        record_session_ip();
        clear_session_ip();
        $_SESSION['tentatives'] = 0;
        
        return verif_permission($idmodule);
    } else {
        clear_session_ip();
        
        if(isset($_SESSION['login']) && isset($_SESSION['passwd'])) {
            session_destroy();
        } else {
            $_SESSION['tentatives']++;
        }
        return false;
    }
}


///////////////////////////////////////
////      VERIF_PERMISSION       //////
///////////////////////////////////////

function verif_permission($idmodule)
{
    $pdo = db_connect(); // Pega a conexão ativa
    
    if (isset($idmodule) && isset($_SESSION['login'])) {
        
        $query = "SELECT permission FROM permission WHERE login = :login AND idmodule = :idmodule";
        
        try {
            $stmt = $pdo->prepare($query);
            $stmt->execute([
                ':login' => $_SESSION['login'],
                ':idmodule' => $idmodule
            ]);
            
            $array = $stmt->fetch(PDO::FETCH_ASSOC);
            
            if ($array && $array["permission"] == 0) {
                return false;
            } else if ($array) {
                $_SESSION['permission'] = $array["permission"];
            }
            
        } catch (PDOException $e) {
            die(error());
        }
    }
    
    return true;
}
?>