<?php
// Configura?o do banco de dados postgres
error_reporting(E_ALL ^E_WARNING ^E_NOTICE);
$basededados="si";
$usuario_b="priori";
$host="127.0.0.1";
$porta="5432";
$senha="estudos";

//isso deve estar dentro do connect.php
$parametros="dbname=$basededados host=$host port=$porta user=$usuario_b ";
$parametros.="password=$senha";

$con=pg_connect($parametros) or die ("Ocorreu um erro com a conexao com o banco");


?>
