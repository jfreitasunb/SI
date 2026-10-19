<?php //require("head_account.php");
if ($documento !=5){
if ($documento!=4){
	$vetor_destino=pg_query("SELECT nomedepartamento FROM admin_departamento WHERE id_departamento ='".$destino."'")
	or die("N\xe3o.");
	$palavra_destino= pg_fetch_row($vetor_destino);
	}
//substituir pelas duas linhas seguintes: substituido em 06/09/2012
//$vetor_assinatura=pg_query("SELECT name, firstname,cargo,titulo FROM users,admin_assinatura WHERE coduser='".$assinante."' and id_assinatura = '".$assinatura."'") or die("N\xe3o.");

 if ($documento==1) $vetor_assinatura=pg_query("SELECT name, firstname, cargo,titulo,matricul FROM users,admin_assinatura WHERE coduser='".$assinante."' and id_assinatura = '".$assinatura."'") or die("N\xe3o.");
 else $vetor_assinatura=pg_query("SELECT name, firstname,cargo,titulo FROM users,admin_assinatura WHERE coduser='".$assinante."' and id_assinatura = '".$assinatura."'") or die("N\xe3o.");

$palavra_assinatura= pg_fetch_row($vetor_assinatura);
}

if ($documento ==5){
$vetor_assinatura=pg_query("SELECT name, firstname,cargo,titulo FROM users,admin_assinatura WHERE coduser='".$assinante."' and id_assinatura = 
'".$assinatura."'");
$palavra_assinatura= pg_fetch_row($vetor_assinatura);
$vetor_assinatura2=pg_query("SELECT name, firstname,cargo,titulo FROM users,admin_assinatura WHERE coduser='".$assinante2."' and id_assinatura =
'".$assinatura2."'");
$palavra_assinatura2= pg_fetch_row($vetor_assinatura2);
}

$vetor_documento=pg_query("SELECT sigla,nometipo FROM admin_tipo WHERE id_tipo = '".$documento."'") or die("N\xe3o.");
$palavra_documento= pg_fetch_row($vetor_documento);
?>
