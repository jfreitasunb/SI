<?php
// Configuracao do banco de dados postgres
error_reporting(E_ALL ^E_WARNING ^E_NOTICE);

//isso deve estar dentro do connect.php
require_once(dirname(__FILE__)."/../global/function_php.php");

$basededados="si";
$usuario_b="priori";
$host="127.0.0.1";
$porta="5432";

// A SENHA nao fica mais no codigo versionado: vem de PRIORI_DB_PASSWD, com fallback
// para a senha padrao do banco (SI_DB_PASSWD / global/db_config.php). Se ausente, falha.
$senha = getenv('PRIORI_DB_PASSWD');
if ($senha === false || $senha === '') {
   $cfg = db_config();
   $senha = $cfg['passwd'];
}
if ($senha === null || $senha === '') {
   die("Configuracao do banco ausente: defina PRIORI_DB_PASSWD, ou a senha em global/db_config.php / SI_DB_PASSWD.");
}

// Conexao PDO; as consultas sao feitas com db_query(..., ..., $con)
try {
   $con = new PDO("pgsql:host=$host;port=$porta;dbname=$basededados", $usuario_b, $senha);
   $con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
   $con->setAttribute(PDO::ATTR_STRINGIFY_FETCHES, true);
} catch (PDOException $e) {
   die("Ocorreu um erro com a conexao com o banco");
}
?>
