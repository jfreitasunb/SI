<?php
require "verifica.php";
require "conexao.php";

if ($acao2 == "Confirmar"){
	if((!isset($_SESSION["verifica_definitivo"])) || strcmp($_SESSION["verifica_definitivo"],$_POST["mensagem"])){
	//setcookie("conf_ins","1",time() + 120);
	$_SESSION["verifica_definitivo"]=$mensagem;
	
//contador para definição do número do documento.
$resultado=pg_query("SELECT * FROM documentador WHERE id_tipo='$id_tipo'") or die ("N\xe3o foi poss\xedvel realizar a consulta ao banco de dados");
$contador=pg_num_rows($resultado) + 1;
	
//acréscimo do documento na tabela "documentador".	
$ins1="INSERT INTO documentador (id_documentador,id_tipo,numerodocumento,id_departamentos,vocativo,mensagem,desfecho,id_assinaturas,assunto,anexo,data) VALUES (default,'$id_tipo','$contador','$id_departamentos','$vocativo','$mensagem','$desfecho','$assinatura','$assunto','$anexo','$data')";
$resultado1=pg_query($ins1) or die("N\xe3o foi poss\xedvel inserir os dados.");

//armazanamento do "id_documentador" que acabou de ser inserido na variável "id_documentador".
$resultado2=pg_query("SELECT id_documentador FROM documentador WHERE numerodocumento = '$contador' and id_tipo = '$id_tipo'") or die("Não foi possível executar a operação. Contacte a Coordenação de Informática.");
$coluna = pg_fetch_row($resultado2,$i);
$id_documentador = $coluna[0];
 
//deleção do documento na tabela "rascunho".       
$resultado=pg_query("DELETE FROM rascunho WHERE id_documentador='$r_documento'") or die ("N\xe3o foi poss\xedvel realizar a consulta ao banco de dados");

echo"	
<head>
<meta http-equiv='content-type' content='text/html; charset=iso-8859-1'>
<title>Servidor Administrativo</title><style type='text/css' media='all'>@import 'style.css';</style></head>
<body>
<div id='Header'></div>
<div id='Content'>
        <h1>Servidor Administrativo</h1>
	<p> O documento foi inserido com sucesso. Para que ele possa ser impresso, clique no botão abaixo . </p><br>

	<form method='post' action='operacaopdf.php'>
	<div align='center'>
    		<input name='id_documentador' type='hidden' value='$id_documentador'>
    		<input type='submit' name='Submit' value='Visualizar para Impressão'>
	 </div></form>";
require "menu.php";
echo"</body></html>";
} 
else  {echo "
<head> 
<meta http-equiv='content-type' content='text/html; charset=iso-8859-1'>
<title>Servidor Administrativo</title><style type='text/css' media='all'>@import 'style.css';</style></head>
<body> 
<div id='Header'></div> 
<div id='Content'> 
        <h1>Servidor Administrativo</h1>
        <p> <b><i>O documento já foi salvo.</i></b> </p><br>";
require "menu.php";
echo"</body></html>";
}}
?>
