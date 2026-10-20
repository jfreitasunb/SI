<?php require("head_admin.php"); 


if(($_POST['acao2']!="Visualizar") and ($_GET['acao2']!="Visualizar"))
{
?>
<html>
<header>
    <script language=javascript src="function_js.js">
    </script>
    <script language=javascript src="formu.js">
    </script>
    <link type="text/css" rel="stylesheet" href="../../global/grafic.css">
  </header>
<body>
<table class=big>
      <tr>
        <td class=header align=center>
          <h1>Departamento de Matem&aacute;tica</h1>
        </td>
      </tr>
      <tr>
        <td align=center>
               <title>Servidor Administrativo</title>
<?php
}
if ($_POST['acao2'] == "Confirmar"){

//	print " Estou no Confirmar do operacao_2";
	$dado=$_POST['dado'];
	//prepara?o para a verifica?o de reenvio de mesmo documento
	if(($dado[0]=="1") || ($dado[0]=="3") || ($dado[0]=="6"))
        	$mensagem=$dado[6];
	else if(($dado[0]=="2"))
        	$mensagem=$dado[5];
	else if(($dado[0]=="4"))
        	$mensagem=$dado[2];
	else if(($dado[0]=="5"))
        	$mensagem=$dado[2];

	if((!isset($_SESSION["verifica_definitivo"])) || strcmp($_SESSION["verifica_definitivo"],$mensagem)){
		$_SESSION["verifica_definitivo"]=$mensagem;
		$data=strftime("%d/%m/%Y");

		/*
		//contador para defini?o do n?ero do documento.
		$resultado=db_query("SELECT id_documentador FROM documentador WHERE id_tipo='$dado[0]'")
		or die ("N\xe3o foi poss\xedvel realizar a consulta ao banco de dados");
		$contador=db_num_rows($resultado) + 1;
		*/

	        // modulo a ser usado quando todos os documentos antigos ja tiverem sido inseridos
		//contagem para defini?o do n?ero do documento. Uso da funcao MAX, que retorna o valor m?imo do campo sugerido.
//		$ano=date("Y");
                $resultado=db_query("SELECT MAX(numerodocumento) FROM admin_documentador WHERE id_tipo=? and data like ?", array($dado[0], '%'.date("Y")));
                $matriz=db_fetch_row($resultado);
		$contador=$matriz[0]+1;
		
/*              para implementar: permite reiniciar a marcacao de documentos ano apos ano: 
		$ano=date("Y");
                $resultado=db_query("SELECT MAX(numerodocumento) FROM admin_documentador WHERE id_tipo='$dado[0]' and data like '%$ano'")
                or die ("N\xe3o foi poss\xedvel realizar a consulta ao banco de dados");
                $matriz=db_fetch_row($resultado);
                $contador=$matriz[0]+1;


		//modulo provisorio para acrescimo na tabela admin_tipo sobre novos documentos
		$resultado=db_query("SELECT novo FROM admin_tipo WHERE id_tipo='$dado[0]'")
                or die ("N\xe3o foi poss\xedvel realizar a consulta ao banco de dados");
                $matriz=db_fetch_row($resultado);
                $contador=$matriz[0]+1;
*/
		//acr?cimo do documento na tabela "documentador".
		if($dado[0]=="1")//memorando
			{
		        $mensagem=mb_convert_encoding( $dado[7], "UTF-8");
			$desfecho=mb_convert_encoding( $dado[8], "UTF-8");
			$assunto=mb_convert_encoding( $dado[4], "UTF-8");
			$anexo=mb_convert_encoding( $dado[5], "UTF-8");
			$vocativo=mb_convert_encoding( $dado[6], "UTF-8");
			$via=mb_convert_encoding( $dado[1], "UTF-8");
			$com_copia=mb_convert_encoding( $dado[2], "UTF-8");
			$resultado_banco=db_query("INSERT INTO admin_documentador
(id_documentador,id_tipo,numerodocumento,id_departamento,mensagem,desfecho,id_assinatura,assunto,anexo,data,vocativo,via,assinante,assinatura2,assinante2,com_copia)
VALUES
(default,?,?,?,?,?,?,?,?,?,?,?,?,'','',?)",
			array($dado[0],$contador,$dado[3],$mensagem,$desfecho,$dado[9],$assunto,$anexo,$data,$vocativo,$via,$dado[10],$com_copia));
			}
		else if(($dado[0]=="3")||($dado[0]=="6"))//of?io interno ou of?io externo
			{
			$mensagem=mb_convert_encoding( $dado[7], "UTF-8");
			$desfecho=mb_convert_encoding( $dado[8], "UTF-8");
			$assunto=mb_convert_encoding( $dado[4], "UTF-8");
			$anexo=mb_convert_encoding( $dado[5], "UTF-8");
			$vocativo=mb_convert_encoding( $dado[6], "UTF-8");
			$via=mb_convert_encoding( $dado[1], "UTF-8");
			$com_copia=mb_convert_encoding( $dado[2], "UTF-8");
			$resultado_banco=db_query("INSERT INTO admin_documentador
(id_documentador,id_tipo,numerodocumento,id_departamento,mensagem,desfecho,id_assinatura,assunto,anexo,data,vocativo,via,
assinante,assinatura2,assinante2,com_copia)
VALUES
(default,?,?,?,?,?,?,?,?,?,?,?,?,'','',?)",
                	array($dado[0],$contador,$dado[3],$mensagem,$desfecho,$dado[9],$assunto,$anexo,$data,$vocativo,$via,$dado[10],$com_copia));
			}
		else if($dado[0]=="2")//circular
			{
			$mensagem=mb_convert_encoding( $dado[7], "UTF-8");
			$desfecho=mb_convert_encoding( $dado[8], "UTF-8");
			$assunto=mb_convert_encoding( $dado[5], "UTF-8");
//			$anexo=mb_convert_encoding( $dado[4], "UTF-8");
			$vocativo=mb_convert_encoding( $dado[6], "UTF-8");
//			$via=mb_convert_encoding( $dado[1], "UTF-8");
			$com_copia=mb_convert_encoding( $dado[4], "UTF-8");
			$resultado_banco=db_query("INSERT INTO admin_documentador
(id_documentador,id_tipo,numerodocumento,id_departamento,mensagem,desfecho,id_assinatura,assunto,anexo,data,vocativo,via,
assinante,assinatura2,assinante2)
VALUES (default,?,?,?,?,?,?,?,'',?,?,'',?,'','')",
                	array($dado[0],$contador,$dado[3],$mensagem,$desfecho,$dado[1],$assunto,$data,$vocativo,$dado[2]));
			}
		else if($dado[0]=="4")//ato
			{
			$mensagem=mb_convert_encoding( $dado[3], "UTF-8");
//			$desfecho=mb_convert_encoding( $dado[7], "UTF-8");
			$assunto=mb_convert_encoding( $dado[1], "UTF-8");
//			$anexo=mb_convert_encoding( $dado[4], "UTF-8");
//			$vocativo=mb_convert_encoding( $dado[5], "UTF-8");
//			$via=mb_convert_encoding( $dado[1], "UTF-8");
			$com_copia=mb_convert_encoding( $dado[2], "UTF-8");
			$resultado_banco=db_query("INSERT INTO admin_documentador
(id_documentador,id_tipo,numerodocumento,id_departamento,mensagem,desfecho,id_assinatura,assunto,anexo,data,vocativo,via,
assinante,assinatura2,assinante2,com_copia)
 VALUES
(default,?,?,'152',?,'',?,?,'',?,'','',?,'','',?)",
                	array($dado[0],$contador,$mensagem,$dado[4],$assunto,$data,$dado[6],$com_copia));
			}
		else if($dado[0]=="5")//ata
			{
			$assunto=mb_convert_encoding( $dado[1], "UTF-8");
			$mensagem=mb_convert_encoding( $dado[2], "UTF-8");
			$resultado_banco=db_query("INSERT INTO admin_documentador
(id_documentador,id_tipo,numerodocumento,id_departamento,mensagem,desfecho,id_assinatura,assunto,anexo,data,vocativo,via,
assinante,assinatura2,assinante2,com_copia)
VALUES
(default,?,?,'152',?,'',?,?,'',?,'','',?,?,?,'')",
                	array($dado[0],$contador,$mensagem,$dado[3],$assunto,$data,$dado[4],$dado[5],$dado[6]));
			}



		//atualizacao do numero do documento na tabela admin_tipo
                $result=db_query("UPDATE admin_tipo SET novo=? WHERE id_tipo=?", array($contador, $dado[0]));


		//armazanamento do "id_documentador" que acabou de ser inserido na vari?el "id_documentador".
		$resultado2=db_query("SELECT id_documentador FROM admin_documentador WHERE numerodocumento = ? and id_tipo = ?", array($contador, $dado[0]));
		$coluna = db_fetch_row($resultado2,0);
		$id_documentador = $coluna[0];

		//dele?o do documento na tabela "rascunho".
		$r_documento=$_POST['r_documento'];
		$resultado=db_query("DELETE FROM admin_rascunho WHERE id_documentador=?", array($r_documento));
		echo"
        	<h1>Servidor Administrativo</h1>
		<p> O documento foi inserido com sucesso. Para que ele possa ser impresso, clique no bot? abaixo . </p><br>

		<form method='post' action='operacao_2.php'>
		<div align='center'>
    			<input name='id_documentador' type='hidden' value='$id_documentador'>
    			<input type='submit' name='acao2' value='Visualizar'>
	 	</div></form>";
		}
	else  {
		echo "
        	<h1>Servidor Administrativo</h1>
        	<p> <b><i>O documento j?foi salvo.</i></b> </p>

		<form method='post' action='operacao_2.php'>
		<div align='center'>
    			<input name='id_documentador' type='hidden' value='$id_documentador'>
    			<input type='submit' name='acao2' value='Visualizar'>
	 	</div></form>";
		}
	}

//imprimir o pdf do documento definitivo
else if(($_POST['acao2']=="Visualizar")||($_GET['acao2']=="Visualizar")){

//	print " Estou no Visualizar do operacao_2";

//	exec('/bin/rm -f ./Tex/ABAB*');
	if(isset($_POST['acao2'])) $id_documentador=$_POST['id_documentador'];
	if(isset($_GET['acao2'])) $id_documentador=$_GET['id_documentador'];

//	print " id_documentador no Visualizar do operacao_2".$id_documentador;

	//busca pelo "documento" na tabela "documentador".
	$resultado=db_query("SELECT * FROM admin_documentador WHERE id_documentador = ?", array($id_documentador));
	$coluna= db_fetch_row($resultado,0);

	//dados para uso do arquivo 'acessorio.php'

	$documento=$coluna[1];

//	if($coluna[1]=="1")
//		{

		$assinatura=$coluna[6];
		$assinante=$coluna[12];
		$destino=$coluna[3];

//		}
//	else if (($coluna[1]=="3")||($coluna[1]=="2")||($coluna[1]=="4"))
//		{
//		$assinatura=$coluna[6];
//		$assinante=$coluna[12];
//		}

      if($coluna[1]=="5")
              {
                $assinatura=$coluna[6];
                $assinante=$coluna[12];
                $assinatura2=$coluna[13];
                $assinante2=$coluna[14];
              }

	require "acessorio.php";



//	$documento=$coluna[1];
//        $res_SIGLA=db_query("SELECT sigla FROM admin_tipo WHERE id_tipo= '$documento'")
//        or die("N?o foi poss?vel executar a opera??o. Contacte a Coordena??o de Inform?tica.");
//        $sigla= db_fetch_row($res_SIGLA,0);

        $seds[LATEXSIGLA]=$palavra_documento[0]; //$sigla[0];

        $seds[LATEXNUMERO]=$coluna[2];
	$seds[LATEXANO]=date("y");
        $seds[LATEXDATA]=$coluna[9];

        $seds[LATEXDESTINO]=mb_convert_encoding($palavra_destino[0],"ISO-8859-1","UTF-8");
        $seds[LATEXVIA]=mb_convert_encoding($coluna[11],"ISO-8859-1","UTF-8");
        $seds[LATEXCOMCOPIA]=mb_convert_encoding($coluna[16],"ISO-8859-1","UTF-8");
        $seds[LATEXASSUNTO]=mb_convert_encoding($coluna[7],"ISO-8859-1","UTF-8");
        $seds[LATEXANEXO]=mb_convert_encoding($coluna[8],"ISO-8859-1","UTF-8");
        $seds[LATEXVOCATIVO]=mb_convert_encoding($coluna[10],"ISO-8859-1","UTF-8");
        $seds[LATEXMENSAGEM]=addslashes(mb_convert_encoding($coluna[4],"ISO-8859-1","UTF-8"));
        $seds[LATEXDESFECHO]=mb_convert_encoding($coluna[5],"ISO-8859-1","UTF-8");
       	$seds[LATEXNASSINATURA]=$palavra_assinatura[3]." ".mb_convert_encoding($palavra_assinatura[0]." ".$palavra_assinatura[1],"ISO-8859-1","UTF-8");
	$seds[LATEXCASSINATURA]=mb_convert_encoding($palavra_assinatura[2],"ISO-8859-1","UTF-8");

        if (($coluna[1]=="1") ) //memorando
                {
/*                $seds[LATEXDESTINO]=mb_convert_encoding($palavra_destino[0],"ISO-8859-1","UTF-8");
                $seds[LATEXVIA]=mb_convert_encoding($coluna[11],"ISO-8859-1","UTF-8");
        $seds[LATEXCOMCOPIA]=mb_convert_encoding($coluna[16],"ISO-8859-1","UTF-8");
                $seds[LATEXASSUNTO]=mb_convert_encoding($coluna[7],"ISO-8859-1","UTF-8");
                $seds[LATEXANEXO]=mb_convert_encoding($coluna[8],"ISO-8859-1","UTF-8");
                $seds[LATEXVOCATIVO]=mb_convert_encoding($coluna[10],"ISO-8859-1","UTF-8");
                $seds[LATEXMENSAGEM]=addslashes(mb_convert_encoding($coluna[4],"ISO-8859-1","UTF-8"));
                $seds[LATEXDESFECHO]=mb_convert_encoding($coluna[5],"ISO-8859-1","UTF-8");
        	$seds[LATEXNASSINATURA]=mb_convert_encoding($palavra_assinatura[0]." ".$palavra_assinatura[1],"ISO-8859-1","UTF-8");
		$seds[LATEXCASSINATURA]=mb_convert_encoding($palavra_assinatura[2],"ISO-8859-1","UTF-8");
*/
                $arquivo="modelo_memorando.tex";
                }
        else if (($coluna[1]=="3") ||($coluna[1]=="6")) //oficio interno ou oficio externo
                {
/*                $seds[LATEXDESTINO]=mb_convert_encoding($palavra_destino[0],"ISO-8859-1","UTF-8");
		$seds[LATEXVIA]=mb_convert_encoding($coluna[11],"ISO-8859-1","UTF-8");
                $seds[LATEXASSUNTO]=mb_convert_encoding($coluna[7],"ISO-8859-1","UTF-8");
                $seds[LATEXANEXO]=mb_convert_encoding($coluna[8],"ISO-8859-1","UTF-8");
                $seds[LATEXVOCATIVO]=mb_convert_encoding($coluna[10],"ISO-8859-1","UTF-8");
                $seds[LATEXMENSAGEM]=addslashes(mb_convert_encoding($coluna[4],"ISO-8859-1","UTF-8"));
        	$seds[LATEXNASSINATURA]=mb_convert_encoding($palavra_assinatura[0]." ".$palavra_assinatura[1],"ISO-8859-1","UTF-8");
		$seds[LATEXCASSINATURA]=mb_convert_encoding($palavra_assinatura[2],"ISO-8859-1","UTF-8");
*/
                $arquivo="modelo_oficio.tex";
                }
        else if($coluna[1]=="2") //circular
                {
/*                $seds[LATEXDESTINO]=mb_convert_encoding($palavra_destino[0],"ISO-8859-1","UTF-8");
		$seds[LATEXVIA]=mb_convert_encoding($coluna[11],"ISO-8859-1","UTF-8");
                $seds[LATEXASSUNTO]=mb_convert_encoding($coluna[7],"ISO-8859-1","UTF-8");
                $seds[LATEXANEXO]=mb_convert_encoding($coluna[8],"ISO-8859-1","UTF-8");
                $seds[LATEXVOCATIVO]=mb_convert_encoding($coluna[10],"ISO-8859-1","UTF-8");
                $seds[LATEXMENSAGEM]=addslashes(mb_convert_encoding($coluna[4],"ISO-8859-1","UTF-8"));
                $seds[LATEXDESFECHO]=mb_convert_encoding($coluna[5],"ISO-8859-1","UTF-8");
        	$seds[LATEXNASSINATURA]=mb_convert_encoding($palavra_assinatura[0]." ".$palavra_assinatura[1],"ISO-8859-1","UTF-8");
		$seds[LATEXCASSINATURA]=mb_convert_encoding($palavra_assinatura[2],"ISO-8859-1","UTF-8");
*/
                $arquivo="modelo_circular.tex";
                }
        else if($coluna[1]=="4") //ato
                {
/*                $seds[LATEXMENSAGEM]=addslashes(mb_convert_encoding($coluna[4],"ISO-8859-1","UTF-8"));
        	$seds[LATEXNASSINATURA]=mb_convert_encoding($palavra_assinatura[0]." ".$palavra_assinatura[1],"ISO-8859-1","UTF-8");
		$seds[LATEXCASSINATURA]=mb_convert_encoding($palavra_assinatura[2],"ISO-8859-1","UTF-8");
*/
                $arquivo="modelo_ato.tex";
                }
        else if ($coluna[1]=="5") //ata
                {
		$seds[LATEXN2ASSINATURA]=$palavra_assinatura2[3]." ".mb_convert_encoding($palavra_assinatura2[0]." ".$palavra_assinatura2[1],"ISO-8859-1","UTF-8");
	        $seds[LATEXC2ASSINATURA]=mb_convert_encoding($palavra_assinatura2[2],"ISO-8859-1","UTF-8");
//                $seds[LATEXMENSAGEM]=addslashes(mb_convert_encoding($coluna[4],"ISO-8859-1","UTF-8"));
                $arquivo="modelo_ata.tex";
                }



	// Gera o PDF sem passar pelo shell (ver global/latex_pdf.php)
	require_once("../../../global/latex_pdf.php");
	$pdf = gera_pdf_latex("./modelo_tex/".$arquivo, $seds);
	if ($pdf === false) die("N\xe3o foi poss\xedvel gerar o documento.");
	Header("Content-type: application/pdf");
	echo $pdf;
}

?>

