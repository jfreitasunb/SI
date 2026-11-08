<?php

// db_config(): ver global/db_config_func.php
require_once __DIR__ . '/db_config_func.php';
// login_bloqueado()/login_falhou()/login_sucesso(): ver global/limite_login.php
require_once __DIR__ . '/limite_login.php';


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

    $cfg = db_config();
    $host   = $cfg['host'];
    $port   = $cfg['port'];
    $dbname = $cfg['dbname'];
    $user   = $cfg['user'];
    $passwd = $cfg['passwd'];

    if ($passwd === null || $passwd === '') {
        die(error("Configuracao do banco ausente: defina a senha em global/db_config.php ou na variavel de ambiente SI_DB_PASSWD."));
    }

    $dsn = "pgsql:host={$host};port={$port};dbname={$dbname}";

    try {
        $pdo = new PDO($dsn, $user, $passwd);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        // Devolve os valores como string, igual às funções pg_* que o código legado usava.
        $pdo->setAttribute(PDO::ATTR_STRINGIFY_FETCHES, true);
        return $pdo;
    } catch (PDOException $e) {
        error_log("db_connect: " . $e->getMessage());
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
    public function offsetExists($o): bool { return isset($this->rows[$o]); }
    #[\ReturnTypeWillChange]
    public function offsetGet($o) { return isset($this->rows[$o]) ? $this->rows[$o] : null; }
    public function offsetSet($o, $v): void { if ($o === null) $this->rows[] = $v; else $this->rows[$o] = $v; }
    public function offsetUnset($o): void { unset($this->rows[$o]); }
    public function count(): int { return count($this->rows); }
    #[\ReturnTypeWillChange]
    public function current() { return $this->rows[$this->pos]; }
    #[\ReturnTypeWillChange]
    public function key() { return $this->pos; }
    public function next(): void { $this->pos++; }
    public function rewind(): void { $this->pos = 0; }
    public function valid(): bool { return isset($this->rows[$this->pos]); }
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

    $query = "SELECT passwd FROM admin WHERE login = :login LIMIT 1";

    try {
        $stmt = $pdo->prepare($query);
        $stmt->execute([':login' => $login]);
        $hash = $stmt->fetchColumn();

        if ($hash === false) {
            return false; // login inexistente
        }

        if (!verifica_senha_app($pass, $hash)) {
            return false;
        }

        // Upgrade transparente de hash legado (MD5) para bcrypt no login bem-sucedido.
        if (precisa_rehash_app($hash)) {
            $novo = hash_senha_app($pass);
            $upd = $pdo->prepare("UPDATE admin SET passwd = :passwd WHERE login = :login");
            $upd->execute([':passwd' => $novo, ':login' => $login]);
        }

        return true;

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
    // Sessao ja autenticada: NAO re-verifica a senha (ela nunca e guardada em
    // sessao). Valida o vinculo de IP/sessao e desliza a janela de validade.
    if (!empty($_SESSION['autenticado']) && isset($_SESSION['login'])) {
        if (!verif_session_ip()) {
            clear_session_ip();
            session_destroy();
            return false;
        }
        record_session_ip(); // renova a janela (sessao deslizante)
        clear_session_ip();
        return verif_permission($idmodule);
    }

    // Login com credenciais (apenas no envio do formulario de login).
    // O limite de tentativas fica no banco (ver limite_login.php), nao na sessao.
    $login = (string)$login;
    $pass  = (string)$pass;
    if ($login !== '' && $pass !== '') {
        if (login_bloqueado($login)) {
            return false; // nem confere a senha enquanto estiver bloqueado
        }
        if (verif_pass_login($login, $pass)) {
            login_sucesso($login);
            // Previne session fixation: novo id apos autenticar.
            session_regenerate_id(true);
            $_SESSION['login'] = $login;
            $_SESSION['autenticado'] = true;
            record_session_ip();
            clear_session_ip();

            return verif_permission($idmodule);
        }
        login_falhou($login);
    }

    // Falha de autenticacao.
    clear_session_ip();
    if (!empty($_SESSION['autenticado'])) {
        session_destroy();
    }
    return false;
}


///////////////////////////////////////
////      VERIF_PERMISSION       //////
///////////////////////////////////////

function verif_permission($idmodule)
{
    $pdo = db_connect(); // Pega a conexão ativa
    
    // Paginas sem idmodule nao tem conceito de permissao: basta estar autenticado.
    if (!isset($idmodule)) {
        return isset($_SESSION['login']);
    }

    if (!isset($_SESSION['login'])) {
        return false;
    }

    $query = "SELECT permission FROM permission WHERE login = :login AND idmodule = :idmodule";

    try {
        $stmt = $pdo->prepare($query);
        $stmt->execute([
            ':login' => $_SESSION['login'],
            ':idmodule' => $idmodule
        ]);

        $array = $stmt->fetch(PDO::FETCH_ASSOC);

        // Nega por padrao (fail-closed): sem linha de permissao ou permissao 0 => acesso negado.
        if (!$array || $array["permission"] == 0) {
            return false;
        }

        $_SESSION['permission'] = $array["permission"];
        return true;

    } catch (PDOException $e) {
        die(error());
    }
}


///////////////////////////////////////
////////   CODUSER_SESSAO    //////////
///////////////////////////////////////
// Resolve o coduser do usuario autenticado a partir da identidade da sessao.
// Deve ser usado para operacoes self-service (trocar a propria senha/cota),
// em vez de confiar em um coduser vindo do cliente (evita IDOR).

function coduser_sessao()
{
    if (!isset($_SESSION['login'])) {
        return null;
    }

    $pdo = db_connect();

    foreach (array('unix', 'admin') as $tabela) {
        try {
            $stmt = $pdo->prepare("SELECT coduser FROM " . $tabela . " WHERE login = :login");
            $stmt->execute([':login' => $_SESSION['login']]);
            $coduser = $stmt->fetchColumn();
            if ($coduser !== false && $coduser !== null) {
                return $coduser;
            }
        } catch (PDOException $e) {
            die(error());
        }
    }

    return null;
}


///////////////////////////////////////
//////////       CSRF        //////////
///////////////////////////////////////
// Protecao contra Cross-Site Request Forgery (synchronizer token pattern).
// O token e emitido por sessao; csrf_injeta() adiciona o campo oculto em todo
// <form method=post> automaticamente; csrf_valida() rejeita POST sem token valido.

function csrf_token()
{
    if (empty($_SESSION['csrf_token'])) {
        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
    }
    return $_SESSION['csrf_token'];
}

function csrf_campo()
{
    return '<input type="hidden" name="csrf_token" value="'
         . htmlspecialchars(csrf_token(), ENT_QUOTES, 'UTF-8') . '">';
}

// Callback de output buffering: injeta o campo oculto logo apos cada <form ...method=post...>.
function csrf_injeta($html)
{
    // Nao mexe em respostas que nao sejam HTML (ex.: PDF, imagens) para nao corromper o binario.
    foreach (headers_list() as $cabecalho) {
        if (stripos($cabecalho, 'Content-Type:') === 0
            && stripos($cabecalho, 'text/html') === false) {
            return $html;
        }
    }

    return preg_replace_callback('/<form\b[^>]*>/i', function ($m) {
        $tag = $m[0];
        // So protege formularios POST (GET sao navegacao/leitura).
        if (preg_match('/method\s*=\s*["\']?\s*post/i', $tag)) {
            return $tag . csrf_campo();
        }
        return $tag;
    }, $html);
}

// Valida o token em requisicoes POST. Deve ser chamada no header, antes de processar.
function csrf_valida()
{
    if (!isset($_SERVER['REQUEST_METHOD']) || strtoupper($_SERVER['REQUEST_METHOD']) !== 'POST') {
        return;
    }

    $esperado = isset($_SESSION['csrf_token']) ? $_SESSION['csrf_token'] : '';

    // Sem token na sessao ainda (ex.: POST de login antes de autenticar): nada a validar.
    if ($esperado === '') {
        return;
    }

    $enviado = isset($_POST['csrf_token']) ? $_POST['csrf_token'] : '';
    if (!is_string($enviado) || !hash_equals($esperado, $enviado)) {
        die(error("Requisicao invalida (CSRF). Recarregue a pagina e tente novamente."));
    }
}


///////////////////////////////////////
////////   HASH DE SENHAS    //////////
///////////////////////////////////////
// Senhas da aplicacao (tabela admin): bcrypt via password_hash(), com suporte
// a hashes legados MD5 (sem salt) e upgrade transparente no proximo login.

function hash_senha_app($senha)
{
    return password_hash($senha, PASSWORD_DEFAULT);
}

// Escape de saida HTML (previne XSS). Usar em toda saida de dados do usuario/banco.
// Charset ISO-8859-1: os caracteres perigosos (< > " ' &) sao ASCII e sao sempre
// escapados; bytes altos (acentos) passam intactos, evitando blanking de strings
// em paginas latin-1 ou com entrada nao-UTF-8.
function h($valor)
{
    return htmlspecialchars((string)$valor, ENT_QUOTES, 'ISO-8859-1');
}

// Sanitizam valores vindos do banco antes de escreve-los em arquivos de
// configuracao de rede (dhcpd.conf, hosts, lts.conf). Impedem injecao de novas
// diretivas/linhas (config injection) removendo quebras de linha e caracteres
// fora do formato esperado de cada campo.
function cfg_host($v)  { return preg_replace('/[^A-Za-z0-9._-]/', '', (string)$v); }
function cfg_mac($v)   { return preg_replace('/[^0-9A-Fa-f:.-]/', '', (string)$v); }
function cfg_ip($v)    { return preg_replace('/[^0-9.]/', '', (string)$v); }
function cfg_texto($v) { return str_replace('"', '', preg_replace('/[\x00-\x1F\x7F]/', '', (string)$v)); }

// Valida que o conteudo real (MIME detectado) do arquivo enviado confere com a
// extensao permitida. Defesa em profundidade: a whitelist de extensao ja barra
// scripts; isto evita um arquivo malicioso disfarcado com extensao permitida.
function upload_mime_ok($tmp_name, $extensao)
{
    if (!is_uploaded_file($tmp_name)) {
        return false;
    }

    $mapa = array(
        'txt'  => array('text/plain'),
        'pdf'  => array('application/pdf'),
        'jpg'  => array('image/jpeg'),
        'jpeg' => array('image/jpeg'),
        'png'  => array('image/png'),
        'gif'  => array('image/gif'),
    );

    $extensao = strtolower($extensao);
    if (!isset($mapa[$extensao])) {
        return false; // extensao fora da whitelist conhecida
    }

    $mime = false;
    if (function_exists('finfo_open')) {
        $fi = finfo_open(FILEINFO_MIME_TYPE);
        if ($fi) {
            $mime = finfo_file($fi, $tmp_name);
            finfo_close($fi);
        }
    }

    if ($mime === false) {
        return true; // sem finfo disponivel: nao bloqueia (extensao ja validada)
    }

    // Arquivos de texto tem deteccao de MIME inconsistente entre ambientes.
    if ($extensao === 'txt') {
        return strpos($mime, 'text/') === 0 || $mime === 'application/octet-stream';
    }

    return in_array($mime, $mapa[$extensao], true);
}

// Verifica $senha contra $hash armazenado. Devolve true/false.
// Se o hash for legado (MD5 de 32 hex), ainda aceita para permitir a transicao.
function verifica_senha_app($senha, $hash)
{
    if (!is_string($hash) || $hash === '') {
        return false;
    }
    // Hash legado: MD5 sem salt (32 caracteres hexadecimais).
    if (preg_match('/^[0-9a-f]{32}$/i', $hash)) {
        return hash_equals(strtolower($hash), md5($senha));
    }
    return password_verify($senha, $hash);
}

// Indica se o hash deve ser reescrito (legado ou parametros desatualizados).
function precisa_rehash_app($hash)
{
    if (!is_string($hash) || $hash === '') {
        return false;
    }
    if (preg_match('/^[0-9a-f]{32}$/i', $hash)) {
        return true; // MD5 legado
    }
    return password_needs_rehash($hash, PASSWORD_DEFAULT);
}

// Senhas de contas UNIX/Samba: precisam continuar em formato crypt() compativel
// com o /etc/shadow do sistema. Usa SHA-512 ($6$) com salt aleatorio, em vez do
// DES default (que trunca em 8 caracteres e usa salt de 2 caracteres).
function cripta_senha_unix($senha)
{
    $alfabeto = './0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz';
    $salt = '';
    for ($i = 0; $i < 16; $i++) {
        $salt .= $alfabeto[random_int(0, 63)];
    }
    return crypt($senha, '$6$' . $salt . '$');
}
?>