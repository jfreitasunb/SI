<?php
require("head_admin.php");

include("funcao_escolhe_arquivo.php");

$dado=$_POST['dado'];                //vari?el que cont? as informa?es do documento
$acao=$_POST['acao'];                //vari?el que cont? a a?o de visualizar ou de salvar no rascunho
$com_copia=$_POST['com_copia'];

if ($acao!="Visualizar"){

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
          <h1>Departamento de Matematica</h1>
        </td>
      </tr>
      <tr>
        <td align=center>
               <title>Servidor Administrativo</title>

<?php
}

/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////sele?o da a?o a partir do valor 'a?o' ////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
$data=strftime("%d/%m/%Y");
if ($acao == "Salvar Rascunho"){
	//verifica?o se o documento j?foi inserido anteriormente na mesma se?o
	if((!isset($_SESSION["verifica_reenvio"])) || strcmp($_SESSION["verifica_reenvio"],$valor))
		{
		$_SESSION["verifica_reenvio"]=$valor;

		if(($dado[0]=="1"))	//memorando
			{
			$vocativo=$dado[5];
			$mensagem=addslashes($dado[6]);
			$desfecho=$dado[7];
			$assunto=$dado[3];
			$anexo=$dado[4];
//			$com_copia=$_POST['com_copia'];
			$resultado1=pg_query("INSERT INTO admin_rascunho (id_documentador,id_tipo,id_departamento,vocativo,
			mensagem,desfecho,id_assinatura,assunto,anexo,data,via,assinante,assinatura2,assinante2,com_copia) VALUES 
(default,'$dado[0]','$dado[2]','$vocativo','$mensagem','$desfecho','$dado[8]','$assunto','$anexo','$data','$dado[1]','$dado[9]','','','$com_copia')")
			or die ("N? foi poss?el inserir os dados no banco");
			}
		else if(($dado[0]=="3")|| ($dado[0]=="6"))     //of?io interno ou of?io externo
			{
			$desfecho=$dado[7];
			$assunto=$dado[3];
			$anexo=$dado[4];
//			$com_copia=$_POST['com_copia'];
			$vocativo=$dado[5];
			$mensagem=addslashes($dado[6]);

                        $resultado1=pg_query("INSERT INTO admin_rascunho 
(id_documentador,id_tipo,id_departamento,vocativo,mensagem,desfecho,id_assinatura,assunto,anexo,data,via,assinante,assinatura2,assinante2,com_copia)
VALUES 
(default,'$dado[0]','$dado[2]','$vocativo','$mensagem','$desfecho','$dado[8]','$assunto','$anexo','$data','$dado[1]','$dado[9]','','','$com_copia')")
                      or die ("N? foi poss?el inserir os dados no banco");
//(id_documentador,id_tipo,desfecho,assunto,anexo,vocativo,mensagem,id_assinatura,data,via,assinante) 
//VALUES (default,'$dado[0]','$desfecho','$assunto','$anexo','$vocativo','$mensagem','$dado[7]','$data','$dado[1]','$dado[8]')")
  			}
		else if ($dado[0]=="2")	//circular
			{
//			$anexo=$dado[2];
			$assunto=$dado[4];
			$vocativo=$dado[5];
			$mensagem=addslashes($dado[6]);
			$desfecho=$dado[7];

			$resultado1=pg_query("INSERT INTO admin_rascunho 
(id_documentador,id_tipo,id_departamento,vocativo,mensagem,desfecho,id_assinatura,assunto,anexo,data,via,assinante,assinatura2,assinante2)
VALUES (default,'$dado[0]','$dado[3]','$vocativo','$mensagem','$desfecho','$dado[1]','$assunto','','$data','','$dado[2]','','')")
                        or die ("N? foi poss?el inserir os dados no banco");
//(id_documentador,id_tipo,id_assinatura,anexo,assunto,vocativo,mensagem,desfecho,data,assinante) 
//VALUES (default,'$dado[0]','$dado[1]','$anexo','$assunto','$vocativo','$mensagem','$desfecho','$data','$dado[2]')")

			}

		else if ($dado[0]=="4")	//ato
			{
//			$anexo=mb_convert_encoding( $dado[2], "UTF-8");
			$assunto=$dado[1];
//			$vocativo=mb_convert_encoding( $dado[4], "UTF-8");
			$mensagem=addslashes($dado[2]);
//			$desfecho=mb_convert_encoding( $dado[6], "UTF-8");

			$resultado1=pg_query("INSERT INTO admin_rascunho 
(id_documentador,id_tipo,id_departamento,vocativo,mensagem,desfecho,id_assinatura,assunto,anexo,data,via,assinante,assinatura2,assinante2)
VALUES (default,'$dado[0]','$dado[5]','','$mensagem','','$dado[3]','$assunto','','$data','','$dado[4]','','')")
                        or die ("N? foi poss?el inserir os dados no banco");
//(id_documentador,id_tipo,mensagem,id_assinatura,data,assinante) 
//VALUES (default,'$dado[0]','$mensagem','$dado[2]','$data','$dado[3]')")

			}
		else if ($dado[0]=="5")	//ata
			{
//			$anexo=mb_convert_encoding( $dado[2], "UTF-8");
			$assunto=$dado[1];
//			$vocativo=mb_convert_encoding( $dado[4], "UTF-8");
			$mensagem=addslashes($dado[2]);
//			$desfecho=mb_convert_encoding( $dado[6], "UTF-8");

			$resultado1=pg_query("INSERT INTO admin_rascunho 
(id_documentador,id_tipo,id_departamento,vocativo,mensagem,desfecho,id_assinatura,assunto,anexo,data,via,assinante,assinatura2,assinante2)
VALUES (default,'$dado[0]','152','','$mensagem','','$dado[3]','$assunto','','$data','','$dado[4]','$dado[5]','$dado[6]')")
                        or die ("N? foi poss?el inserir os dados no banco");
//(id_documentador,id_tipo,mensagem,data) 
//VALUES (default,'$dado[0]','$mensagem','$data')")

			}
// AQUI, SE FORMOS PARA O VISUALIZAR VAI DAR CERTO COM LATEX!
		echo "
                	<h1>Servidor Administrativo</h1>
		<p> O documento foi inserido como <i>rascunho</i>. Para que ele possa ser impresso, clique no bot?
				abaixo.</p><br>

			<form method='post' action='ati.php'>
			<div align='center'>";
			foreach($dado as $valor)
				{
				echo"
    				<input type='hidden' name='dado[]' value='$valor'>";
				}

    			echo "<input type='hidden' name='com_copia' value='$com_copia'>";
			echo"
    				<input type='hidden' name='segunda' value='ok'>
				<input type='submit' name='acao' value='Visualizar'>
			</div></form>";
		}
	else
		{
		echo"
        	<h1>Servidor Administrativo</h1>
        	<p> <b><i>O documento j?foi salvo.</i></b> </p><br>";
		}
	}

///////////////////////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////atualiza?o da tabela rascunho ////////////////////////////////////////////
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////

else if($acao=="Rascunho"){   

//	$id_documentador=$_GET["id_documentador"];
	$id_documentador=$_POST["id_documentador"];
 if($dado[0]=="1") //memorando
		{

		$assunto=$dado[3];
		$anexo=$dado[4];
//		$com_copia=$_POST['com_copia'];
		$vocativo=$dado[5];
		$mensagem=addslashes($dado[6]);
		//echo $mensagem;
		//die();
		$desfecho=$dado[7];
// 		$resultado1=pg_query("UPDATE admin_rascunho SET id_departamento='$dado[2]',assunto='$assunto',anexo='$anexo',
//                        vocativo='$vocativo',mensagem='$mensagem',desfecho='$desfecho',id_assinatura='$dado[8]',via='$dado[1]',
//                        data='$data', assinante=$dado[9] WHERE id_documentador='$id_documentador'")
//                        or die ("N? foi poss?el inserir os dados no banco");
		$resultado1=pg_query("UPDATE admin_rascunho SET id_tipo='$dado[0]',id_departamento='$dado[2]',vocativo='$vocativo',mensagem='$mensagem',desfecho='$desfecho',id_assinatura='$dado[8]',assunto='$assunto',anexo='$anexo',data='$data',via='$dado[1]',assinante='$dado[9]',com_copia='$com_copia' WHERE id_documentador='$id_documentador'") or die ("N? foi poss?el inserir os dados no banco");
		}
	else if(($dado[0]=="3")||($dado[0]=="6")) //of?io interno e of?io externo
		{
		$assunto=$dado[3];
//		$com_copia=$_POST['com_copia'];
		$anexo=$dado[4];
	        $vocativo=$dado[5];
		$mensagem=addslashes($dado[6]);
		$desfecho=$dado[7];

//                $resultado1=pg_query("UPDATE admin_rascunho SET desfecho='$desfecho',assunto='$assunto',anexo='$anexo',
//                        vocativo='$vocativo',mensagem='$mensagem',id_assinatura='$dado[7]',via='$dado[1]',
//                        data='$data' WHERE id_documentador='$id_documentador'")
//                        or die ("N? foi poss?el inserir os dados no banco");

                        $resultado1=pg_query("UPDATE admin_rascunho SET id_tipo='$dado[0]',id_departamento='$dado[2]',vocativo='$vocativo',mensagem='$mensagem',desfecho='$desfecho',id_assinatura='$dado[8]',assunto='$assunto',anexo='$anexo',data='$data',via='$dado[1]',assinante='$dado[9]',com_copia='$com_copia' WHERE id_documentador='$id_documentador'") or die ("N? foi poss?el inserir os dados no banco");

		}
	else if($dado[0]=="2") //circular
		{
		$assunto=$dado[4];
//		$anexo=$dado[2];
	        $vocativo=$dado[5];
		$mensagem=addslashes($dado[6]);
		$desfecho=$dado[7];

/*                $resultado1=pg_query("UPDATE admin_rascunho SET id_assinatura='$dado[1]',anexo='$anexo',assunto='$assunto',
                        vocativo='$vocativo',mensagem='$mensagem',desfecho='$desfecho',
                        data='$data' WHERE id_documentador='$id_documentador'")
                        or die ("N? foi poss?el inserir os dados no banco");
*/
			$resultado1=pg_query("UPDATE admin_rascunho SET id_tipo='$dado[0]',id_departamento='$dado[3]',vocativo='$vocativo',mensagem='$mensagem',desfecho='$desfecho',id_assinatura='$dado[1]',assunto='$assunto',anexo='',data='$data',via='',assinante='$dado[2]' WHERE id_documentador='$id_documentador'") or die ("N? foi poss?el inserir os dados no banco");
		}
	else if($dado[0]=="4") //ato
		{
		$assunto=$dado[1];
//		$anexo=mb_convert_encoding( $dado[2], "UTF-8");
//	        $vocativo=mb_convert_encoding( $dado[4], "UTF-8");
		$mensagem=addslashes($dado[2]);
//		$desfecho=mb_convert_encoding( $dado[6], "UTF-8");

/*                $resultado1=pg_query("UPDATE admin_rascunho SET mensagem='$mensagem',id_assinatura='$dado[2]',
                        data='$data' WHERE id_documentador='$id_documentador'")
                        or die ("N? foi poss?el inserir os dados no banco");
*/
	$resultado1=pg_query("UPDATE admin_rascunho SET id_tipo='$dado[0]',id_departamento='152',vocativo='',mensagem='$mensagem',desfecho='',id_assinatura='$dado[3]',assunto='$assunto',anexo='',data='$data',via='',assinante='$dado[4]' WHERE id_documentador='$id_documentador'") or die ("N? foi poss?el inserir os dados no banco");
		}
	 else if($dado[0]=="5") //ata
		{
		$assunto=$dado[1];
//		$anexo=mb_convert_encoding( $dado[2], "UTF-8");
//	        $vocativo=mb_convert_encoding( $dado[4], "UTF-8");
		$mensagem=addslashes($dado[2]);
//		$desfecho=mb_convert_encoding( $dado[6], "UTF-8");

/*                $resultado1=pg_query("UPDATE admin_rascunho SET mensagem='$mensagem',
                        data='$data' WHERE id_documentador='$id_documentador'")
                        or die ("N? foi poss?el inserir os dados no banco");
*/
			$resultado1=pg_query("UPDATE admin_rascunho SET id_tipo='$dado[0]',id_departamento='152',vocativo='',mensagem='$mensagem',desfecho='',id_assinatura='$dado[3]',assunto='$assunto',anexo='',data='$data',via='',assinante='$dado[4]', assinatura2='$dado[5]', assinante2='$dado[6]' WHERE id_documentador='$id_documentador'") or die ("N? foi poss?el inserir os dados no banco");

		}
// AQUI, SE FORMOS PARA O VISUALIZAR VAI DAR CERTO COM LATEX!
	echo "
        <h1>Servidor Administrativo</h1>
        <p> O documento foi atualizado como <i>rascunho</i>. Para que ele possa ser impresso, clique no
        bot? abaixo.</p><br>
                        <form method='post' action='ati.php'>
                        <div align='center'>";
				foreach($dado as $valor){
                                echo"
                                <input type='hidden' name='dado[]' value='$valor'>";
                                }

    			echo"	<input type='hidden' name='com_copia' value='$com_copia'>";
                        echo"
                                <input type='hidden' name='segunda' value='ok'>
                                <input type='submit' name='acao' value='Visualizar'>
                        </div></form>";
	}

/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////inser?o na tabela definitivo /////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

else if($acao=="Definitivo"){

//	$id_documentador=$_GET["id_documentador"];
	$id_documentador=$_POST["id_documentador"];
	 echo "
         <h1>Confirma?o</h1>
         <p> Clique abaixo para inserir definitivamente o documento. </p>";
	$documento=$dado[0];
		if($dado[0]=="1") //memorando
			{
//				if (empty($_POST['com_copia'])) $com_copia=""; else $com_copia=$_POST['com_copia'];
				$assinatura=$dado[8];
				$assinante=$dado[9];
		                $destino=$dado[2];
				require "acessorio.php";
				echo"
                        	<p><a>Tipo de Documento: </a>$palavra_documento[1]</p>
				<p><a>Via: </a>$dado[1]</p>
				<p><a>C/C: </a>$com_copia</p>
                        	<p><a>Destino: </a>$palavra_destino[0]</p>
                        	<p><a>Assunto: </a>$dado[3]</p>
                        	<p><a>Anexo(s): </a>$dado[4]</p>
                        	<p><a>Vocativo: </a>$dado[5]</p>
                        	<p><a>Mensagem: </a>$dado[6]</p>
                        	<p><a>Desfecho: </a>$dado[7]</p>
                        	<p><a>Assinante: </a>$palavra_assinatura[0]  $palavra_assinatura[1]</p>;
			  	<p><a>Assinatura: </a>$palavra_assinatura[2]</p>";
				}
			else if(($dado[0]=="3")||($dado[0]=="6")) //of?io interno ou of?io externo
				{
//				if (empty($_POST['com_copia'])) $com_copia=""; else $com_copia=$_POST['com_copia'];
				$assinatura=$dado[8];
				$assinante=$dado[9];
        		        $destino=$dado[2];
  				require "acessorio.php";
				echo"
				<p><a>Tipo de Documento: </a>$palavra_documento[1]</p>
                                <p><a>Via: </a>$dado[1]</p>
				<p><a>C/C: </a>$com_copia</p>
                                <p><a>Destino: </a>$dado[2]</p>
                                <p><a>Assunto: </a>$dado[3]</p>
                                <p><a>Anexo(s): </a>$dado[4]</p>
                                <p><a>Vocativo: </a>$dado[5]</p>
                                <p><a>Mensagem: </a>$dado[6]</p>
                        	<p><a>Desfecho: </a>$dado[7]</p>
                        	<p><a>Assinante: </a>$palavra_assinatura[0]   $palavra_assinatura[1]</p>;
			  	<p><a>Assinatura: </a>$palavra_assinatura[2]</p>";
				}
			else if($dado[0]=="2")  //circular
				{
				$assinatura=$dado[1];
				$assinante=$dado[2];
		                $destino=$dado[3];
				require "acessorio.php";
                                echo"
                                <p><a>Tipo de Documento: </a>$palavra_documento[1]</p>
                                <p><a>Remetente: </a>$palavra_assinatura[0]   $palavra_assinatura[1]</p>
			  	<p><a>Assinatura: </a>$palavra_assinatura[2]</p>;
                                <p><a>Destinat?io: </a>$palavra_destino[0]</p>
                                <p><a>Assunto: </a>$dado[4]</p>
                                <p><a>Vocativo: </a>$dado[5]</p>
				<p><a>Mensagem: </a>$dado[6]</p>
                                <p><a>Desfecho: </a>$dado[7]</p>";
				}
			else if($dado[0]=="4")  //ato
				{
				$assinatura=$dado[3];
				$assinante=$dado[4];
				require "acessorio.php";
                                echo"
                                <p><a>Tipo de Documento: </a>$palavra_documento[1]</p>
                                <p><a>Mensagem: </a>$dado[2]</p>
                        	<p><a>Assinante: </a>$palavra_assinatura[0]    $palavra_assinatura[1]</p>;
			  	<p><a>Assinatura: </a>$palavra_assinatura[2]</p>";
				}
			 else if($dado[0]=="5")    //ata
			 	{
				$assinatura=$dado[3];
                                $assinante=$dado[4];
				$assinatura2=$dado[5];
                                $assinante2=$dado[6];
				require "acessorio.php";
                                echo"
                                <p><a>Tipo de Documento: </a>$palavra_documento[1]</p>
                                <p><a>Descri?o da ata: </a>$dado[1]</p>";
				}

		echo"
                        <br>
                        <form method='post' action='operacao_2.php'>
                        <div align='center'>";
				foreach($dado as $valor){
                                echo"
                                <input name='dado[]' type='hidden' value='$valor'>";
                                }

    		echo"	<input type='hidden' name='com_copia' value='$com_copia'>";
		echo"
                         <input name='r_documento' type='hidden' value='$id_documentador'>
                         <input type='button' value='Retornar' onclick='history.go(-1)'>
                         <input name='acao2' type='submit' value='Confirmar'>
                        </div></form>";

	}
////////////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////Visualiza?o do documento em pdf ///////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////////////////

else if ($acao=="Visualizar"){

//	exec('/bin/rm -f ./Tex/XDLD*'); 	//require "acessorio.php";
//	exec('/bin/rm -f /var/www/si/modules/servidor_admin/Tex/XDLD*'); 	//require "acessorio.php";

	$documento=$dado[0];
	$res_SIGLA=pg_query("SELECT sigla FROM admin_tipo WHERE id_tipo= '$documento'")
	or die("N? foi poss?el executar a opera?o. Contacte a Coordena?o de Inform?ica.");
	$sigla= pg_fetch_row($res_SIGLA,0);
	
	$seds[LATEXSIGLA]=$sigla[0];
	$seds[LATEXNUMERO]="XX";
	$seds[LATEXANO]=date("y");
	$seds[LATEXDATA]=$data;
//	$com_copia="";
	if (($dado[0]=="1") ) //memorando
        	{
//		if (empty($_POST['com_copia'])) $com_copia=""; else $com_copia=$_POST['com_copia'];
		$assinatura=$dado[8];
		$assinante=$dado[9];
                $destino=$dado[2];
		require "acessorio.php";
		$seds[LATEXDESTINO]=mb_convert_encoding($palavra_destino[0],"ISO-8859-1","UTF-8");
		$seds[LATEXVIA]=mb_convert_encoding($dado[1],"ISO-8859-1","UTF-8");
		$seds[LATEXCOMCOPIA]=mb_convert_encoding($com_copia,"ISO-8859-1","UTF-8");
        	$seds[LATEXASSUNTO]=mb_convert_encoding($dado[3],"ISO-8859-1","UTF-8");
        	$seds[LATEXANEXO]=mb_convert_encoding($dado[4],"ISO-8859-1","UTF-8");
        	$seds[LATEXVOCATIVO]=mb_convert_encoding($dado[5],"ISO-8859-1","UTF-8");
        	$seds[LATEXMENSAGEM]=mb_convert_encoding($dado[6],"ISO-8859-1","UTF-8");
        	$seds[LATEXDESFECHO]=mb_convert_encoding($dado[7],"ISO-8859-1","UTF-8");
		$nome_assinatura=$palavra_assinatura[0];
		$sobrenome_assinatura=$palavra_assinatura[1];
//
		$funcao_assinatura=$palavra_assinatura[2];
        	$seds[LATEXNASSINATURA]=mb_convert_encoding($palavra_assinatura[3]." ".$nome_assinatura." ".$sobrenome_assinatura,"ISO-8859-1","UTF-8");
		$seds[LATEXCASSINATURA]=mb_convert_encoding($funcao_assinatura,"ISO-8859-1","UTF-8");
//nova formatacao com matricula: substituido em 06/09/2012
		$seds[LATEXMATRICULA]="Matr. FUB: ".$palavra_assinatura[4];
	if ($com_copia=="") $arquivo="modelo_memorando.tex"; else  $arquivo="modelo_memorandocc.tex";
		}
	else if (($dado[0]=="3") || ($dado[0]=="6")) //oficio interno ou of?io externo
        	{
//		if (empty($_POST['com_copia'])) $com_copia=""; else $com_copia=$_POST['com_copia'];
		$assinatura=$dado[8];
		$assinante=$dado[9];
                $destino=$dado[2];
                require "acessorio.php";
		$seds[LATEXDESTINO]=mb_convert_encoding($palavra_destino[0],"ISO-8859-1","UTF-8");
		$seds[LATEXVIA]=mb_convert_encoding($dado[1],"ISO-8859-1","UTF-8");
		$seds[LATEXCOMCOPIA]=mb_convert_encoding($com_copia,"ISO-8859-1","UTF-8");
        	$seds[LATEXASSUNTO]=mb_convert_encoding($dado[3],"ISO-8859-1","UTF-8");
        	$seds[LATEXANEXO]=mb_convert_encoding($dado[4],"ISO-8859-1","UTF-8");
        	$seds[LATEXVOCATIVO]=mb_convert_encoding($dado[5],"ISO-8859-1","UTF-8");
        	$seds[LATEXMENSAGEM]=mb_convert_encoding($dado[6],"ISO-8859-1","UTF-8");
        	$seds[LATEXDESFECHO]=mb_convert_encoding($dado[7],"ISO-8859-1","UTF-8");
		$nome_assinatura=$palavra_assinatura[0];
		$sobrenome_assinatura=$palavra_assinatura[1];
		$funcao_assinatura=$palavra_assinatura[2];
        	$seds[LATEXNASSINATURA]=mb_convert_encoding($palavra_assinatura[3]." ".$nome_assinatura." ".$sobrenome_assinatura,"ISO-8859-1","UTF-8");
		$seds[LATEXCASSINATURA]=mb_convert_encoding($funcao_assinatura,"ISO-8859-1","UTF-8");
		if ($com_copia=="") $arquivo="modelo_oficio.tex"; else  $arquivo="modelo_oficiocc.tex";
//		if ($dado[0]=="3")
//        		$arquivo="modelo_oficio_interno.tex";
//		else
//			$arquivo="modelo_oficio_externo.tex";
        	}
        else if($dado[0]=="2") //circular
        	{
		$assinatura=$dado[1];
		$assinante=$dado[2];
                $destino=$dado[3];
                require "acessorio.php";
		$seds[LATEXDESTINO]=mb_convert_encoding($palavra_destino[0],"ISO-8859-1","UTF-8");
		$seds[LATEXASSUNTO]=mb_convert_encoding($dado[4],"ISO-8859-1","UTF-8");
//		$seds[LATEXANEXO]=$dado[3];
        	$seds[LATEXVOCATIVO]=mb_convert_encoding($dado[5],"ISO-8859-1","UTF-8");
        	$seds[LATEXMENSAGEM]=mb_convert_encoding($dado[6],"ISO-8859-1","UTF-8");
        	$seds[LATEXDESFECHO]=mb_convert_encoding($dado[7],"ISO-8859-1","UTF-8");
		$nome_assinatura=$palavra_assinatura[0];
		$sobrenome_assinatura=$palavra_assinatura[1];
		$funcao_assinatura=$palavra_assinatura[2];
        	$seds[LATEXNASSINATURA]=mb_convert_encoding($palavra_assinatura[3]." ".$nome_assinatura." ".$sobrenome_assinatura,"ISO-8859-1","UTF-8");
		$seds[LATEXCASSINATURA]=mb_convert_encoding($funcao_assinatura,"ISO-8859-1","UTF-8");
        	$arquivo="modelo_circular.tex";
        	}
	else if($dado[0]=="4") //ato
        	{
		$assinatura=$dado[3];
		$assinante=$dado[4];
                require "acessorio.php";
		$seds[LATEXMENSAGEM]=mb_convert_encoding($dado[2],"ISO-8859-1","UTF-8");
		$nome_assinatura=$palavra_assinatura[0];
		$sobrenome_assinatura=$palavra_assinatura[1];
		$funcao_assinatura=$palavra_assinatura[2];
        	$seds[LATEXNASSINATURA]=mb_convert_encoding($palavra_assinatura[3]." ".$nome_assinatura." ".$sobrenome_assinatura,"ISO-8859-1","UTF-8");
		$seds[LATEXCASSINATURA]=mb_convert_encoding($funcao_assinatura,"ISO-8859-1","UTF-8");
        	$arquivo="modelo_ato.tex";
        	}
        else if ($dado[0]=="5") //ata
        	{
                $assinatura=$dado[3];
                $assinante=$dado[4];
		$assinatura2=$dado[5];
                $assinante2=$dado[6];
		require "acessorio.php";
        	$seds[LATEXMENSAGEM]=mb_convert_encoding($dado[2],"ISO-8859-1","UTF-8");
		$nome_assinatura=$palavra_assinatura[0];
		$sobrenome_assinatura=$palavra_assinatura[1];
		$funcao_assinatura=$palavra_assinatura[2];
		$seds[LATEXNASSINATURA]=mb_convert_encoding($palavra_assinatura[3]." ".$nome_assinatura." ".$sobrenome_assinatura,"ISO-8859-1","UTF-8");
                $seds[LATEXCASSINATURA]=mb_convert_encoding($funcao_assinatura,"ISO-8859-1","UTF-8");
		$nome2_assinatura=$palavra_assinatura2[0];
		$sobrenome2_assinatura=$palavra_assinatura2[1];
		$funcao2_assinatura=$palavra_assinatura2[2];
		$seds[LATEXN2ASSINATURA]=mb_convert_encoding($palavra_assinatura2[3]." ".$nome2_assinatura." ".$sobrenome2_assinatura,"ISO-8859-1","UTF-8");
                $seds[LATEXC2ASSINATURA]=mb_convert_encoding($funcao2_assinatura,"ISO-8859-1","UTF-8");
        	$arquivo="modelo_ata.tex";
        	}
// adicionado em 5/11/2010
		$arquivo=escolhe_arquivo($data,$dado[0],$com_copia);
//echo $arquivo;

	foreach ($seds as $colchete => $valor)
		{
		$seds[$colchete]=str_replace("ê",'\^e',$seds[$colchete]);
		$seds[$colchete]=str_replace("ç",'\c c',$seds[$colchete]);
		$seds[$colchete]=str_replace("?",'?',$seds[$colchete]);
		$seds[$colchete]=str_replace("ó",'\'o',$seds[$colchete]);
		$seds[$colchete]=str_replace("õ",'\~o',$seds[$colchete]);
		$seds[$colchete]=str_replace("ã",'\~a',$seds[$colchete]);
		$seds[$colchete]=str_replace("à",'\`a',$seds[$colchete]);
		$seds[$colchete]=str_replace("á",'\'a',$seds[$colchete]);
		}
//print_r($seds);
//die();
//	print "a array seds ? ".print_r($seds);	

	// Gera o PDF sem passar pelo shell (ver global/latex_pdf.php)
	require_once("../../global/latex_pdf.php");
	$pdf = gera_pdf_latex("./modelo_tex/".$arquivo, $seds);
	if ($pdf === false) die("N\xe3o foi poss\xedvel gerar o documento.");
	Header("Content-type: application/pdf");
	echo $pdf;
}
?>
<?php
  pg_close($idconn);
?>
</table>
</body>
</html>
