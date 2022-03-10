<?php
require_once '/home/jfreitas/www/si/modules/oferta/funcoes.php';
include("/home/jfreitas/www/si/global/header.php");

    atualiza_rodizio_noturno(1, 2022);
// select u.name||' '||u.firstname as nome,oc.ano,oc.semestre,oc.credito_noturno,dm.nome as disciplina,oc.turma from users u, oferta_horarios_rodizio_noturno_creditos oc, disciplinas_mat dm where u.coduser=oc.coduser and dm.codigo=oc.disciplina order by ano,semestre,nome;
?>
