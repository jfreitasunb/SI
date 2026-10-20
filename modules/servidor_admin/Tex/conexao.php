<?php

// Senha fora do codigo versionado: definida via variavel de ambiente TEX_DB_PASSWD.
$tex_pwd = (getenv('TEX_DB_PASSWD') !== false) ? getenv('TEX_DB_PASSWD') : "";
$conn_string = "host=localhost dbname=MatAdmin user=laura" . ($tex_pwd !== "" ? " password=".$tex_pwd : "");

$conn = pg_connect($conn_string);

if (!$conn) {
        echo "N\xe3o foi poss\xedvel a conex\xe3o ao banco de dados.\n";
        exit;
        }

?>
