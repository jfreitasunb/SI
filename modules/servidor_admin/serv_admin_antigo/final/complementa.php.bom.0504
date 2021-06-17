<?php

require "conexao.php";

// busca pela sigla do "tipo de documento"
$most0="SELECT sigla,nometipo FROM tipos WHERE id_tipo = '$id_tipo'";
$resultado0=pg_query($most0) or die("Não foi possível executar a operação. Contacte a Coordenação de I
nformática.");
$row= pg_fetch_row($resultado0,$i);

// busca pelo "destino"
$most1="SELECT nomedepartamento FROM departamentos WHERE id_departamentos = '$id_departamentos'";
$resultado1=pg_query($most1) or die("Não foi possível executar a operação. Contacte a Coordenação de I
nformática.");
$row1= pg_fetch_row($resultado1,$i);

// busca pelo "nome" e "cargo" de assinatura
$most2="SELECT nome,cargo FROM assinaturas WHERE id_assinaturas = '$assinatura'";
$resultado2=pg_query($most2) or die("Não foi possível executar a operação. Contacte a Coordenação de I
nformática.");
$row2= pg_fetch_row($resultado2,$i);

?>
