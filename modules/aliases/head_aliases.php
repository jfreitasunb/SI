<?php
   $idmodule=95;
   include("../../global/header.php");

// The db_connect function allows to connect to the database, an id_connection is returned.

  function connect_pykota()
  {
    $host="127.0.0.1";
    $port="5432";
    $dbname="pykotanovo";
    $user="pykotaadmin";
    $passwd="estudos";
    $str_connection="host=".$host." port=".$port." dbname=".$dbname." user=".$user." password=".$passwd;
    $idconn=pg_connect($str_connection) or die (error("The server ".$host." seems to be have many problem. Please try again in a few time."));
    return $idconn;
  }

//  $conn_pykota=connect_pykota();
?>
