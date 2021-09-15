<?php
// Configura?o do banco de dados postgres
error_reporting(E_ALL ^E_WARNING ^E_NOTICE);
$basededados="si";
$usuario="samba";
$host="127.0.0.1";
$porta="5432";
$senha="samba";

//isso deve estar dentro do connect.php
$parametros="dbname=$basededados host=$host port=$porta user=$usuario ";
$parametros.="password=$senha";

if( !$con=pg_connect($parametros))
{
   echo '<font color="red">Ocorreu um erro com a conex? ao banco</font>';

};
?>
