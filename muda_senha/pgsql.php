<?php
// Configura?o do banco de dados postgres
error_reporting(E_ALL ^E_WARNING ^E_NOTICE);
require_once(dirname(__FILE__)."/../global/function_php.php");

$basededados="si";
$usuario_bd="si";
$host="127.0.0.1";
$porta="5432";
$senha_bd="estudos";

// Conexao PDO; as consultas sao feitas com db_query(..., ..., $con)
try {
   $con = new PDO("pgsql:host=$host;port=$porta;dbname=$basededados", $usuario_bd, $senha_bd);
   $con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
   $con->setAttribute(PDO::ATTR_STRINGIFY_FETCHES, true);
} catch (PDOException $e) {
   die('<font color="red">Ocorreu um erro com a conex? ao banco</font>');
}
?>
