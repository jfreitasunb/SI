<?php include("head_account.php");  // busca pela sigla do "tipo de documento"


$resultado0=pg_query("SELECT sigla,nometipo FROM tipos WHERE id_tipo = '$id_tipo'") or die("Não foi possível executar a operação. Contacte a Coordenação de Informática.");
$row= pg_fetch_row($resultado0,$i);

// busca pelo "destino"
$resultado1=pg_query("SELECT nomedepartamento FROM departamentos WHERE id_departamentos = '$id_departamentos'") or die("Não foi possível executar a operação. Contacte a Coordenação de Informática.");
$row1= pg_fetch_row($resultado1,$i);

// busca pelo "nome" e "cargo" de assinatura
$resultado2=pg_query("SELECT nome,cargo FROM assinaturas WHERE id_assinaturas = '$assinatura'") or die("Não foi possível executar a operação. Contacte a Coordenação de Informática.");
$row2= pg_fetch_row($resultado2,$i);

?>
