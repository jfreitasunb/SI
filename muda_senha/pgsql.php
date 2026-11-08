<?php
// Configuracao do banco de dados postgres
error_reporting(E_ALL ^E_WARNING ^E_NOTICE);
require_once(dirname(__FILE__)."/../global/function_php.php");

$basededados="si";
$usuario_bd="si";
$cfg = db_config();
// Por padrao o banco e local (127.0.0.1); um host definido explicitamente em
// global/db_config.php ou SI_DB_HOST tem precedencia (ex.: ambiente Docker).
$host = !empty($cfg['host_explicito']) ? $cfg['host'] : "127.0.0.1";
$porta = !empty($cfg['host_explicito']) ? $cfg['port'] : "5432";

// A SENHA nao fica mais no codigo versionado: vem de SI_DB_PASSWD / global/db_config.php
// (ver db_config()). Se ausente, a conexao falha com mensagem clara.
$cfg = db_config();
$senha_bd = $cfg['passwd'];
if ($senha_bd === null || $senha_bd === '') {
   die('<font color="red">Configuracao do banco ausente: defina a senha em global/db_config.php ou na variavel SI_DB_PASSWD.</font>');
}

// Conexao PDO; as consultas sao feitas com db_query(..., ..., $con)
try {
   $con = new PDO("pgsql:host=$host;port=$porta;dbname=$basededados", $usuario_bd, $senha_bd);
   $con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
   $con->setAttribute(PDO::ATTR_STRINGIFY_FETCHES, true);
} catch (PDOException $e) {
   die('<font color="red">Ocorreu um erro com a conex&atilde;o ao banco</font>');
}
?>
