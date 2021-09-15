<?php
     $conectabd = pg_connect("dbname= teste port=5432 host = 127.0.0.1 user = postgres password = teste");

    

     if ($conectabd) {
    //Caso queira Imprimir na Tela a mensagem, retirar o comentário
    //echo "Conectado com: " . pg_host($conectabd) . "<br/> ";
     }
     else {
          echo pg_last_error($conectabd);
          exit;
     }
?> 
