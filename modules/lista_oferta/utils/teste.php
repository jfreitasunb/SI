<?php

require_once '/Arquivos/Dropbox/php/vagrant/rivendel/www/UnB-Matematica-SI/modules/oferta/funcoes.php';
require_once '/Arquivos/Dropbox/php/vagrant/rivendel/www/UnB-Matematica-SI/global/function_php.php';
$semester = 1;
$year=2020;
db_connect();
atualiza_rodizio_noturno($semester, $year);

?>