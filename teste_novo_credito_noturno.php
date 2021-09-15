<?php
require_once '/home/jfreitas/www/SI/modules/oferta/funcoes.php';
include("/home/jfreitas/www/SI/global/header.php");

for ($i=0; $i < 12; $i++) {
    $ano = 2010 + $i;
    atualiza_rodizio_noturno(1, $ano);
    atualiza_rodizio_noturno(2, $ano);
}
// select u.name||' '||u.firstname as nome,oc.ano,oc.semestre,oc.credito_noturno,dm.nome as disciplina,oc.turma from users u, oferta_horarios_rodizio_noturno_creditos oc, disciplinas_mat dm where u.coduser=oc.coduser and dm.codigo=oc.disciplina order by ano,semestre,nome;
?>
