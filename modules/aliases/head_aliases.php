<?php
   $idmodule=95;
   require("../../global/header.php");

// The db_connect function allows to connect to the database, an id_connection is returned.

  function connect_pykota()
  {
    $cfg=db_config();
    $host=$cfg['pykota_host'];
    $port=$cfg['pykota_port'];
    $dbname=$cfg['pykota_dbname'];
    $user=$cfg['pykota_user'];
    $passwd=$cfg['pykota_passwd'];
    if ($passwd===null || $passwd==='') {
        die(error("Configuracao do banco pykota ausente: defina pykota_passwd em global/db_config.php ou PYKOTA_DB_PASSWD."));
    }
    $str_connection="host=".$host." port=".$port." dbname=".$dbname." user=".$user." password=".$passwd;
    $idconn=pg_connect($str_connection) or die (error("The server ".$host." seems to be have many problem. Please try again in a few time."));
    return $idconn;
  }

//  $conn_pykota=connect_pykota();
?>
