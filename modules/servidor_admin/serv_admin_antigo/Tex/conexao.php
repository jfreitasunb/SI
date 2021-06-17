<?php

$conn_string = "host=localhost dbname=MatAdmin user=laura";

$conn = pg_connect($conn_string);

if (!$conn) {
        echo "N\xe3o foi poss\xedvel a conex\xe3o ao banco de dados.\n";
        exit;
        }

?>
