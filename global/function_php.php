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

// Executa uma consulta parametrizada (Prepared Statement) e devolve o PDOStatement.
// Os valores vão sempre em $params, nunca concatenados no SQL.
// $pdo permite usar outra conexão (ex.: scripts com usuário de banco próprio).
function db_query($sql, array $params = array(), $pdo = null)
{
    if ($pdo === null) {
        $pdo = db_connect();
    }

    try {
        $stmt = $pdo->prepare($sql);
        $stmt->execute(array_values($params));
        return $stmt;
    } catch (PDOException $e) {
        error_log("db_query: " . $e->getMessage() . " | SQL: " . $sql);
        die(error());
    }
}


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