<?php
// Configura?o do banco de dados postgres
error_reporting(E_ALL ^E_WARNING ^E_NOTICE);
$basededados="si";
$usuario_b="priori";
$host="127.0.0.1";
$porta="5432";
$senha="estudos";

//isso deve estar dentro do connect.php
require_once(dirname(__FILE__)."/../global/function_php.php");

// Conexao PDO; as consultas sao feitas com db_query(..., ..., $con)
try {
   $con = new PDO("pgsql:host=$host;port=$porta;dbname=$basededados", $usuario_b, $senha);
   $con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
   $con->setAttribute(PDO::ATTR_STRINGIFY_FETCHES, true);
} catch (PDOException $e) {
   die("Ocorreu um erro com a conexao com o banco");
}


?>
