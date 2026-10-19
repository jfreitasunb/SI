<?php //require("head_account.php");
if ($documento !=5){
if ($documento!=4){
	$vetor_destino=db_query("SELECT nomedepartamento FROM admin_departamento WHERE id_departamento =?", array($destino));
	$palavra_destino= $vetor_destino->fetch(PDO::FETCH_NUM);
	}
//substituir pelas duas linhas seguintes: substituido em 06/09/2012
//$vetor_assinatura=pg_query("SELECT name, firstname,cargo,titulo FROM users,admin_assinatura WHERE coduser='".$assinante."' and id_assinatura = '".$assinatura."'") or die("N\xe3o.");

 if ($documento==1) $vetor_assinatura=db_query("SELECT name, firstname, cargo,titulo,matricul FROM users,admin_assinatura WHERE coduser=? and id_assinatura = ?", array($assinante, $assinatura));
 else $vetor_assinatura=db_query("SELECT name, firstname,cargo,titulo FROM users,admin_assinatura WHERE coduser=? and id_assinatura = ?", array($assinante, $assinatura));

$palavra_assinatura= $vetor_assinatura->fetch(PDO::FETCH_NUM);
}

if ($documento ==5){
$vetor_assinatura=db_query("SELECT name, firstname,cargo,titulo FROM users,admin_assinatura WHERE coduser=? and id_assinatura = ?", array($assinante, $assinatura));
$palavra_assinatura= $vetor_assinatura->fetch(PDO::FETCH_NUM);
$vetor_assinatura2=db_query("SELECT name, firstname,cargo,titulo FROM users,admin_assinatura WHERE coduser=? and id_assinatura = ?", array($assinante2, $assinatura2));
$palavra_assinatura2= $vetor_assinatura2->fetch(PDO::FETCH_NUM);
}

$vetor_documento=db_query("SELECT sigla,nometipo FROM admin_tipo WHERE id_tipo = ?", array($documento));
$palavra_documento= $vetor_documento->fetch(PDO::FETCH_NUM);
?>
