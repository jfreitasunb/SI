<?php

require "conexao.php";

//busca pelo "documento" na tabela "rascunho".
$resultado=pg_query("SELECT * FROM rascunho WHERE id_documentador = '$id_documentador'") or die("Não foi possível executar a operação. Contacte a Coordenação de Informática.");
$row= pg_fetch_row($resultado,$i);


//busca pelo "tipo" de documento na tabela "tipos".
$resultado1=pg_query("SELECT nometipo FROM tipos WHERE id_tipo = '$row[1]'") or die("Não foi possível executar a operação. Contacte a Coordenação de Informática.");
$row1= pg_fetch_row($resultado1,$i);


//busca pelo "destino" na tabela "destinos".
$resultado2=pg_query("SELECT nomedepartamento FROM departamentos WHERE id_departamentos = '$row[2]'") or die("Não foi possível executar a operação. Contacte a Coordenação de Informática.");
$row2= pg_fetch_row($resultado2,$i);


//busca pela "assinatura" na tabela "assinaturas".
$resultado3=pg_query("SELECT nome,cargo FROM assinaturas WHERE id_assinaturas = '$row[6]'") or die("Não foi possível executar a operação. Contacte a Coordenação de I
nformática.");
$row3= pg_fetch_row($resultado3,$i);

?>

