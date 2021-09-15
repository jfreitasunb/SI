<?php include "head_test.php";

if ($documento !=5){
if ($documento==1){
$vetor_destino=pg_query("SELECT nomedepartamento FROM admin_departamento WHERE id_departamento ='$destino'") or die("N\xe3o.");
$palavra_destino= pg_fetch_row($vetor_destino);
	}
$vetor_assinatura=pg_query("SELECT nome,cargo FROM admin_assinatura WHERE id_assinatura = '$assinatura'") or die("N\xe3o.");
$palavra_assinatura= pg_fetch_row($vetor_assinatura);
}

$vetor_documento=pg_query("SELECT sigla,nometipo FROM admin_tipo WHERE id_tipo = '$documento'") or die("N\xe3o.");
$palavra_documento= pg_fetch_row($vetor_documento);
?>
