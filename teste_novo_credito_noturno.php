<?php
require_once '/home/jfreitas/www/SI/modules/oferta/funcoes.php';
include("/home/jfreitas/www/SI/global/header.php");

for ($i=0; $i < 12; $i++) {
    $ano = 2010 + $i;
    atualiza_rodizio_noturno(1, $ano);
    atualiza_rodizio_noturno(2, $ano);
}

?>
