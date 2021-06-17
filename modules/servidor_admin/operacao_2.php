<?php include("head_admin.php"); 
include("funcao_escolhe_arquivo.php");

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
<meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
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
	$com_copia=$_POST['com_copia'];
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
		$resultado=pg_query("SELECT id_documentador FROM documentador WHERE id_tipo='$dado[0]'")
		or die ("N\xe3o foi poss\xedvel realizar a consulta ao banco de dados");
		$contador=pg_num_rows($resultado) + 1;
		*/

	        // modulo a ser usado quando todos os documentos antigos ja tiverem sido inseridos
		//contagem para defini?o do n?ero do documento. Uso da funcao MAX, que retorna o valor m?imo do campo sugerido.
//		$ano=date("Y");
		$query_documentador="SELECT MAX(numerodocumento) FROM admin_documentador WHERE id_tipo='".$dado[0]."' and data like '%".date("Y")."'";
                $resultado=pg_query($query_documentador) or die ("N\xe3o foi poss\xedvel realizar a consulta ao banco de dados");
                $matriz=pg_fetch_row($resultado);
		$contador=$matriz[0]+1;
		
/*              para implementar: permite reiniciar a marcacao de documentos ano apos ano: 
		$ano=date("Y");
                $resultado=pg_query("SELECT MAX(numerodocumento) FROM admin_documentador WHERE id_tipo='$dado[0]' and data like '%$ano'")
                or die ("N\xe3o foi poss\xedvel realizar a consulta ao banco de dados");
                $matriz=pg_fetch_row($resultado);
                $contador=$matriz[0]+1;


		//modulo provisorio para acrescimo na tabela admin_tipo sobre novos documentos
		$resultado=pg_query("SELECT novo FROM admin_tipo WHERE id_tipo='$dado[0]'")
                or die ("N\xe3o foi poss\xedvel realizar a consulta ao banco de dados");
                $matriz=pg_fetch_row($resultado);
                $contador=$matriz[0]+1;
*/
		//acr?cimo do documento na tabela "documentador".
		if($dado[0]=="1")//memorando
			{
		        //$mensagem=mb_convert_encoding( $dado[6], "UTF-8");
		        $mensagem=addslashes($dado[6]);
			//$desfecho=mb_convert_encoding( $dado[7], "UTF-8");
			$desfecho=$dado[7];
			//$assunto=mb_convert_encoding( $dado[3], "UTF-8");
			$assunto=$dado[3];
			//$anexo=mb_convert_encoding( $dado[4], "UTF-8");
			$anexo=$dado[4];
			//$vocativo=mb_convert_encoding( $dado[5], "UTF-8");
			$vocativo=$dado[5];
			//$via=mb_convert_encoding( $dado[1], "UTF-8");
			$via=$dado[1];
			//$com_copia=mb_convert_encoding( $_POST['com_copia'], "UTF-8");
//			$com_copia=$_POST['com_copia'];
			$resultado_banco=pg_query("INSERT INTO admin_documentador(id_documentador,id_tipo,numerodocumento,id_departamento,mensagem,desfecho,id_assinatura,assunto,anexo,data,vocativo,via,assinante,assinatura2,assinante2,com_copia) VALUES (default,'$dado[0]','$contador','$dado[2]','$mensagem','$desfecho','$dado[8]','$assunto','$anexo','$data','$vocativo','$via','$dado[9]','','','$com_copia')") or die("N\xe3o foi poss\xedvel inserir os dados.");
			}
		else if(($dado[0]=="3")||($dado[0]=="6"))//of?io interno ou of?io externo
			{
			//$mensagem=mb_convert_encoding( $dado[6], "UTF-8");
			$mensagem=addslashes($dado[6]);
			//$desfecho=mb_convert_encoding( $dado[7], "UTF-8");
			//$assunto=mb_convert_encoding( $dado[3], "UTF-8");
			//$anexo=mb_convert_encoding( $dado[4], "UTF-8");
			//$vocativo=mb_convert_encoding( $dado[5], "UTF-8");
			//$via=mb_convert_encoding( $dado[1], "UTF-8");
			//$com_copia=mb_convert_encoding( $_POST['com_copia'], "UTF-8");
			$desfecho=$dado[7];
			$assunto=$dado[3];
			$anexo=$dado[4];
			$vocativo=$dado[5];
			$via=$dado[1];
//			$com_copia=$_POST['com_copia'];
			$resultado_banco=pg_query("INSERT INTO admin_documentador (id_documentador,id_tipo,numerodocumento,id_departamento,mensagem,desfecho,id_assinatura,assunto,anexo,data,vocativo,via,assinante,assinatura2,assinante2,com_copia) VALUES(default,'$dado[0]','$contador','$dado[2]','$mensagem','$desfecho','$dado[8]','$assunto','$anexo','$data','$vocativo','$via','$dado[9]','','','$com_copia')") or die("N\xe3o foi poss\xedvel inserir os dados.");
			}
		else if($dado[0]=="2")//circular
			{
			//$mensagem=mb_convert_encoding( $dado[6], "UTF-8");
			$mensagem=addslashes($dado[6]);
			//$desfecho=mb_convert_encoding( $dado[7], "UTF-8");
			//$assunto=mb_convert_encoding( $dado[4], "UTF-8");
			$desfecho=$dado[7];
			$assunto=$dado[4];
//			$anexo=mb_convert_encoding( $dado[4], "UTF-8");
			//$vocativo=mb_convert_encoding( $dado[5], "UTF-8");
			$vocativo=$dado[5];
//			$via=mb_convert_encoding( $dado[1], "UTF-8");
			$resultado_banco=pg_query("INSERT INTO admin_documentador (id_documentador,id_tipo,numerodocumento,id_departamento,mensagem,desfecho,id_assinatura,assunto,anexo,data,vocativo,via, assinante,assinatura2,assinante2) VALUES (default,'$dado[0]','$contador','$dado[3]','$mensagem','$desfecho','$dado[1]','$assunto','','$data','$vocativo','','$dado[2]','','')") or die("N\xe3o foi poss\xedvel inserir os dados.");
			}
		else if($dado[0]=="4")//ato
			{
			//$mensagem=mb_convert_encoding( $dado[2], "UTF-8");
			$mensagem=addslashes($dado[2]);
//			$desfecho=mb_convert_encoding( $dado[7], "UTF-8");
			//$assunto=mb_convert_encoding( $dado[1], "UTF-8");
			$assunto=$dado[1];
//			$anexo=mb_convert_encoding( $dado[4], "UTF-8");
//			$vocativo=mb_convert_encoding( $dado[5], "UTF-8");
//			$via=mb_convert_encoding( $dado[1], "UTF-8");
			$resultado_banco=pg_query("INSERT INTO admin_documentador (id_documentador,id_tipo,numerodocumento,id_departamento,mensagem,desfecho,id_assinatura,assunto,anexo,data,vocativo,via, assinante,assinatura2,assinante2)  VALUES (default,'$dado[0]','$contador','152','$mensagem','','$dado[3]','$assunto','','$data','','','$dado[4]','','')") or die("N\xe3o foi poss\xedvel inserir os dados.");
			}
		else if($dado[0]=="5")//ata
			{
			//$assunto=mb_convert_encoding( $dado[1], "UTF-8");
			$assunto=$dado[1];
			//$mensagem=mb_convert_encoding( $dado[2], "UTF-8");
			$mensagem=addslashes($dado[2]);
			$resultado_banco=pg_query("INSERT INTO admin_documentador (id_documentador,id_tipo,numerodocumento,id_departamento,mensagem,desfecho,id_assinatura,assunto,anexo,data,vocativo,via, assinante,assinatura2,assinante2) VALUES (default,'$dado[0]','$contador','152','$mensagem','','$dado[3]','$assunto','','$data','','','$dado[4]','$dado[5]','$dado[6]')") or die("N\xe3o foi poss\xedvel inserir os dados.");
			}



		//atualizacao do numero do documento na tabela admin_tipo
                $result=pg_query("UPDATE admin_tipo SET novo='$contador' WHERE id_tipo='$dado[0]'") or die ("N\xe3o foi poss\xedvel atualizar o campo 'novo' no banco de dados");


		//armazanamento do "id_documentador" que acabou de ser inserido na vari?el "id_documentador".
		$resultado2=pg_query("SELECT id_documentador FROM admin_documentador WHERE numerodocumento = '$contador' and id_tipo = '$dado[0]' and data like '%".date("Y")."'") or die("N? foi poss?el executar a opera?o. Contacte a Coordena?o de Inform?ica.");
		$coluna = pg_fetch_row($resultado2,0);
		$id_documentador = $coluna[0];

		//dele?o do documento na tabela "rascunho".
		$r_documento=$_POST['r_documento'];
		$resultado=pg_query("DELETE FROM admin_rascunho WHERE id_documentador='$r_documento'") or die ("N\xe3o foi poss\xedvel realizar a consulta ao banco de dados");
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
	$resultado=pg_query("SELECT * FROM admin_documentador WHERE id_documentador = '$id_documentador'") or die("N? foi poss?el executar a opera?o. Contacte a Coordena?o de Inform?ica.");
	$coluna= pg_fetch_row($resultado,0);

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
//        $res_SIGLA=pg_query("SELECT sigla FROM admin_tipo WHERE id_tipo= '$documento'")
//        or die("N?o foi poss?vel executar a opera??o. Contacte a Coordena??o de Inform?tica.");
//        $sigla= pg_fetch_row($res_SIGLA,0);

        $seds[LATEXSIGLA]=$palavra_documento[0]; //$sigla[0];

        $seds[LATEXNUMERO]=$coluna[2];
	$latexano=explode("/",$coluna[9]); 
//	$seds[LATEXANO]=date("y");
	$seds[LATEXANO]=$latexano[2];
        $seds[LATEXDATA]=$coluna[9];
	
	//Acrescentado por Jose Antonio, 25/02/2015
	if (strpos($coluna[4],'\\\\') === false) {
    	$coluna[4] = addslashes(addslashes($coluna[4]));
	} else {
    	$coluna[4] = addslashes($coluna[4]);
	}

        $seds[LATEXDESTINO]=mb_convert_encoding($palavra_destino[0],"ISO-8859-1","UTF-8");
        $seds[LATEXVIA]=mb_convert_encoding($coluna[11],"ISO-8859-1","UTF-8");
        $seds[LATEXCOMCOPIA]=mb_convert_encoding($coluna[15],"ISO-8859-1","UTF-8");
        $seds[LATEXASSUNTO]=mb_convert_encoding($coluna[7],"ISO-8859-1","UTF-8");
        $seds[LATEXANEXO]=mb_convert_encoding($coluna[8],"ISO-8859-1","UTF-8");
        $seds[LATEXVOCATIVO]=mb_convert_encoding($coluna[10],"ISO-8859-1","UTF-8");
        $seds[LATEXMENSAGEM]=mb_convert_encoding($coluna[4],"ISO-8859-1","UTF-8");
        $seds[LATEXDESFECHO]=mb_convert_encoding($coluna[5],"ISO-8859-1","UTF-8");
       	$seds[LATEXNASSINATURA]=$palavra_assinatura[3]." ".mb_convert_encoding($palavra_assinatura[0]." ".$palavra_assinatura[1],"ISO-8859-1","UTF-8");
	$seds[LATEXCASSINATURA]=mb_convert_encoding($palavra_assinatura[2],"ISO-8859-1","UTF-8");

        if (($coluna[1]=="1") ) //memorando
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
		$seds[LATEXMATRICULA]="Matr. FUB: ".$palavra_assinatura[4];
		if ($coluna[15]=="") $arquivo="modelo_memorando.tex"; else $arquivo="modelo_memorandocc.tex";
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
                if ($coluna[15]=="") $arquivo="modelo_oficio.tex";else $arquivo="modelo_oficiocc.tex";
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

        foreach ($seds as $colchete => $valor){
                // $seds[$colchete]=addslashes($seds[$colchete]);
                if ($colchete=="LATEXMENSAGEM")
                        $seds[$colchete]=str_replace("\n",'',$seds[$colchete]);
//                        $seds[$colchete]=str_replace("\n",'^M',$seds[$colchete]);
                else
		//linha comentada por Jose Antonio, dia 18/03/2015. Configuracao atual do PHP nao acrescenta backslashes mais. Tem que ser feito manual, pela linha abaixo.
                        //Acrescentado por Jose Antonio, 25/02/2015
                        if (strpos($seds[$colchete],'\\\\') === false) {
                        $seds[$colchete] = addslashes(addslashes($seds[$colchete]));
                        } else {
                        $seds[$colchete] = addslashes($seds[$colchete]);
                        }

                $seds[$colchete]=str_replace("\n",'',$seds[$colchete]);
                $seds[$colchete]=str_replace("/",'\/',$seds[$colchete]);
                $seds[$colchete]=str_replace('&','\&',$seds[$colchete]);
                $seds[$colchete]=str_replace("$",'\$',$seds[$colchete]);
                $seds[$colchete]=str_replace("%",'\%',$seds[$colchete]);
                $seds[$colchete]=str_replace("-",'\-',$seds[$colchete]);
                }
	
	if (empty($coluna[15])) $com_copia=""; else $com_copia=$coluna[15];
	$arquivo=escolhe_arquivo($coluna[9],$coluna[1],$com_copia);

        $tmpfname = tempnam("/var/www/si/modules/servidor_admin/Tex", "ABAB");
        exec("cat ./modelo_tex/".$arquivo." > ".$tmpfname.".tex");
	exec(" chmod 777 ".$tmpfname.".tex");
	Header("Content-type: application/pdf");
        foreach($seds as $key => $val )
                {
//exec('sed \'s/'.$key.'./'.$val.'/\' '.$tmpfname.'.tex > '.$tmpfname.'.tex.tmp; mv '.$tmpfname.'.tex.tmp  '.$tmpfname.'.tex');
	$cmd = "sed \" s/".$key."/".$val."/\" ".$tmpfname.".tex > ".$tmpfname.".tex.tmp";	//do Guy
	exec($cmd);										//do Guy
	$cmd2=" mv ".$tmpfname.".tex.tmp  ".$tmpfname.".tex";					//do Guy
	exec($cmd2);										//do Guy
	exec(" chmod 777 ".$tmpfname.".tex");
                }
/*
exec('cd /tmp/oliveira/ ; ./conversor2 '.$tmpfname.'.tex > '.$tmpfname.'.tex.mod ; mv '.$tmpfname.'.tex.mod '.$tmpfname.'.tex;
        /usr/local/bin/pdflatex -interaction nonstopmode '.$tmpfname.'.tex');
*/

//	exec('cd ../Tex/ ;/usr/local/bin/pdflatex -interaction nonstopmode '.$tmpfname.'.tex');
	exec("cd /var/www/si/modules/servidor_admin/Tex; pwd; pdflatex ".$tmpfname.".tex");

        if($fp=fopen("".$tmpfname.".pdf","r")){
        while (!feof($fp)) {
                $buffer = fgets($fp, 4096);
                echo $buffer;
                }
        fclose($fp);
//        exec('/bin/rm -f '.$tmpfname.'*');
	}
}

?>

