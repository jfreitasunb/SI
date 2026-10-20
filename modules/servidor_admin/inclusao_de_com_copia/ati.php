<?php
require("head_admin.php");?>
<?php
$dado=$_POST["dado"];                //vari?el que cont? as informa?es do documento
$acao=$_POST["acao"];                //vari?el que cont? a a?o de visualizar ou de salvar no rascunho

if ($acao!="Visualizar"){

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
			$vocativo=mb_convert_encoding( $dado[6], "UTF-8");
			$mensagem=mb_convert_encoding( $dado[7], "UTF-8");
			$desfecho=mb_convert_encoding( $dado[8], "UTF-8");
			$assunto=mb_convert_encoding( $dado[4], "UTF-8");
			$anexo=mb_convert_encoding( $dado[5], "UTF-8");

			$resultado1=db_query("INSERT INTO admin_rascunho (id_documentador,id_tipo,id_departamento,vocativo,mensagem,desfecho,id_assinatura,assunto,anexo,data,via,assinante,assinatura2,assinante2,com_copia) VALUES
(default,?,?,?,?,?,?,?,?,?,?,?,'','',?)",
			array($dado[0],$dado[3],$vocativo,$mensagem,$desfecho,$dado[9],$assunto,$anexo,$data,$dado[1],$dado[10],$dado[2]));
			}
		else if(($dado[0]=="3")|| ($dado[0]=="6"))     //of?io interno ou of?io externo
			{
			$desfecho=mb_convert_encoding( $dado[8], "UTF-8");
			$assunto=mb_convert_encoding( $dado[4], "UTF-8");
			$anexo=mb_convert_encoding( $dado[5], "UTF-8");
			$vocativo=mb_convert_encoding( $dado[6], "UTF-8");
			$mensagem=mb_convert_encoding( $dado[7], "UTF-8");

                        $resultado1=db_query("INSERT INTO admin_rascunho
(id_documentador,id_tipo,id_departamento,vocativo,mensagem,desfecho,id_assinatura,assunto,anexo,data,via,assinante,assinatura2,assinante2,com_copia)
VALUES
(default,?,?,?,?,?,?,?,?,?,?,?,'','',?)",
                      array($dado[0],$dado[3],$vocativo,$mensagem,$desfecho,$dado[9],$assunto,$anexo,$data,$dado[1],$dado[10],$dado[2]));
//(id_documentador,id_tipo,desfecho,assunto,anexo,vocativo,mensagem,id_assinatura,data,via,assinante) 
//VALUES (default,'$dado[0]','$desfecho','$assunto','$anexo','$vocativo','$mensagem','$dado[7]','$data','$dado[1]','$dado[8]')")
  			}
		else if ($dado[0]=="2")	//circular
			{
//			$anexo=mb_convert_encoding( $dado[2], "UTF-8");
			$assunto=mb_convert_encoding( $dado[5], "UTF-8");
			$vocativo=mb_convert_encoding( $dado[6], "UTF-8");
			$mensagem=mb_convert_encoding( $dado[7], "UTF-8");
			$desfecho=mb_convert_encoding( $dado[8], "UTF-8");
			$resultado1=db_query("INSERT INTO admin_rascunho
(id_documentador,id_tipo,id_departamento,vocativo,mensagem,desfecho,id_assinatura,assunto,anexo,data,via,assinante,assinatura2,assinante2,com_copia)
VALUES
(default,?,?,?,?,?,?,?,'',?,'',?,'','','dado[4]')",
                        array($dado[0],$dado[3],$vocativo,$mensagem,$desfecho,$dado[1],$assunto,$data,$dado[2]));
//(id_documentador,id_tipo,id_assinatura,anexo,assunto,vocativo,mensagem,desfecho,data,assinante) 
//VALUES (default,'$dado[0]','$dado[1]','$anexo','$assunto','$vocativo','$mensagem','$desfecho','$data','$dado[2]')")

			}

		else if ($dado[0]=="4")	//ato
			{
//			$anexo=mb_convert_encoding( $dado[3], "UTF-8");
			$assunto=mb_convert_encoding( $dado[1], "UTF-8");
//			$vocativo=mb_convert_encoding( $dado[5], "UTF-8");
			$mensagem=mb_convert_encoding( $dado[3], "UTF-8");
//			$desfecho=mb_convert_encoding( $dado[6], "UTF-8");

			$resultado1=db_query("INSERT INTO admin_rascunho
(id_documentador,id_tipo,id_departamento,vocativo,mensagem,desfecho,id_assinatura,assunto,anexo,data,via,assinante,assinatura2,assinante2,com_copia)
VALUES
(default,?,?,'',?,'',?,?,'',?,'',?,'','',?)",
                        array($dado[0],$dado[6],$mensagem,$dado[4],$assunto,$data,$dado[5],$dado[2]));
//(id_documentador,id_tipo,mensagem,id_assinatura,data,assinante) 
//VALUES (default,'$dado[0]','$mensagem','$dado[2]','$data','$dado[3]')")

			}
		else if ($dado[0]=="5")	//ata
			{
//			$anexo=mb_convert_encoding( $dado[2], "UTF-8");
			$assunto=mb_convert_encoding( $dado[1], "UTF-8");
//			$vocativo=mb_convert_encoding( $dado[4], "UTF-8");
			$mensagem=mb_convert_encoding( $dado[2], "UTF-8");
//			$desfecho=mb_convert_encoding( $dado[6], "UTF-8");

			$resultado1=db_query("INSERT INTO admin_rascunho
(id_documentador,id_tipo,id_departamento,vocativo,mensagem,desfecho,id_assinatura,assunto,anexo,data,via,assinante,assinatura2,assinante2)
VALUES (default,?,'152','',?,'',?,?,'',?,'',?,?,?)",
                        array($dado[0],$mensagem,$dado[3],$assunto,$data,$dado[4],$dado[5],$dado[6]));
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
    				<input name='dado[]' type='hidden' value='$valor'>";
				}
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

		$assunto=mb_convert_encoding( $dado[4], "UTF-8");
		$anexo=mb_convert_encoding( $dado[5], "UTF-8");
		$vocativo=mb_convert_encoding( $dado[6], "UTF-8");
		$mensagem=mb_convert_encoding( $dado[7], "UTF-8");
		$desfecho=mb_convert_encoding( $dado[8], "UTF-8");
// 		$resultado1=db_query("UPDATE admin_rascunho SET id_departamento='$dado[2]',assunto='$assunto',anexo='$anexo',
//                        vocativo='$vocativo',mensagem='$mensagem',desfecho='$desfecho',id_assinatura='$dado[8]',via='$dado[1]',
//                        data='$data', assinante=$dado[9] WHERE id_documentador='$id_documentador'")
//                        or die ("N? foi poss?el inserir os dados no banco");
		$resultado1=db_query("UPDATE admin_rascunho SET
id_tipo=?,id_departamento=?,vocativo=?,mensagem=?,desfecho=?,id_assinatura=?,assunto=?,anexo=?,data=?,via=?,assinante=?,com_copia=?
WHERE id_documentador=?", array($dado[0],$dado[3],$vocativo,$mensagem,$desfecho,$dado[9],$assunto,$anexo,$data,$dado[1],$dado[10],$dado[2],$id_documentador));
		}
	else if(($dado[0]=="3")||($dado[0]=="6")) //of?io interno e of?io externo
		{
		$assunto=mb_convert_encoding( $dado[4], "UTF-8");
		$anexo=mb_convert_encoding( $dado[5], "UTF-8");
	        $vocativo=mb_convert_encoding( $dado[6], "UTF-8");
		$mensagem=mb_convert_encoding( $dado[7], "UTF-8");
		$desfecho=mb_convert_encoding( $dado[8], "UTF-8");

//                $resultado1=db_query("UPDATE admin_rascunho SET desfecho='$desfecho',assunto='$assunto',anexo='$anexo',
//                        vocativo='$vocativo',mensagem='$mensagem',id_assinatura='$dado[7]',via='$dado[1]',
//                        data='$data' WHERE id_documentador='$id_documentador'")
//                        or die ("N? foi poss?el inserir os dados no banco");

                        $resultado1=db_query("UPDATE admin_rascunho SET
id_tipo=?,id_departamento=?,vocativo=?,mensagem=?,desfecho=?,id_assinatura=?,assunto=?,anexo=?,data=?,via=?,assinante=?,com_copia=?
WHERE id_documentador=?", array($dado[0],$dado[3],$vocativo,$mensagem,$desfecho,$dado[9],$assunto,$anexo,$data,$dado[1],$dado[10],$dado[2],$id_documentador));

		}
	else if($dado[0]=="2") //circular
		{
		$assunto=mb_convert_encoding( $dado[5], "UTF-8");
//		$anexo=mb_convert_encoding( $dado[2], "UTF-8");
	        $vocativo=mb_convert_encoding( $dado[6], "UTF-8");
		$mensagem=mb_convert_encoding( $dado[7], "UTF-8");
		$desfecho=mb_convert_encoding( $dado[8], "UTF-8");

/*                $resultado1=db_query("UPDATE admin_rascunho SET id_assinatura='$dado[1]',anexo='$anexo',assunto='$assunto',
                        vocativo='$vocativo',mensagem='$mensagem',desfecho='$desfecho',
                        data='$data' WHERE id_documentador='$id_documentador'")
                        or die ("N? foi poss?el inserir os dados no banco");
*/
			$resultado1=db_query("UPDATE admin_rascunho SET
id_tipo=?,id_departamento=?,vocativo=?,mensagem=?,desfecho=?,id_assinatura=?,assunto=?,anexo='',data=?,via='',assinante=?,
com_copia=? WHERE id_documentador=?",
                        array($dado[0],$dado[3],$vocativo,$mensagem,$desfecho,$dado[1],$assunto,$data,$dado[2],$dado[4],$id_documentador));
		}
	else if($dado[0]=="4") //ato
		{
		$assunto=mb_convert_encoding( $dado[1], "UTF-8");
//		$anexo=mb_convert_encoding( $dado[2], "UTF-8");
//	        $vocativo=mb_convert_encoding( $dado[4], "UTF-8");
		$mensagem=mb_convert_encoding( $dado[3], "UTF-8");
//		$desfecho=mb_convert_encoding( $dado[6], "UTF-8");

/*                $resultado1=db_query("UPDATE admin_rascunho SET mensagem='$mensagem',id_assinatura='$dado[2]',
                        data='$data' WHERE id_documentador='$id_documentador'")
                        or die ("N? foi poss?el inserir os dados no banco");
*/
	$resultado1=db_query("UPDATE admin_rascunho SET
id_tipo=?,id_departamento='152',vocativo='',mensagem=?,desfecho='',id_assinatura=?,assunto=?,anexo='',data=?,via='',assinante=?,
com_copia=? WHERE id_documentador=?",
                        array($dado[0],$mensagem,$dado[4],$assunto,$data,$dado[5],$dado[2],$id_documentador));
		}
	 else if($dado[0]=="5") //ata
		{
		$assunto=mb_convert_encoding( $dado[1], "UTF-8");
//		$anexo=mb_convert_encoding( $dado[2], "UTF-8");
//	        $vocativo=mb_convert_encoding( $dado[4], "UTF-8");
		$mensagem=mb_convert_encoding( $dado[2], "UTF-8");
//		$desfecho=mb_convert_encoding( $dado[6], "UTF-8");

/*                $resultado1=db_query("UPDATE admin_rascunho SET mensagem='$mensagem',
                        data='$data' WHERE id_documentador='$id_documentador'")
                        or die ("N? foi poss?el inserir os dados no banco");
*/
			$resultado1=db_query("UPDATE admin_rascunho SET
id_tipo=?,id_departamento='152',vocativo='',mensagem=?,desfecho='',id_assinatura=?,assunto=?,anexo='',data=?,via='',assinante=?,
assinatura2=?, assinante2=?
WHERE id_documentador=?",
                        array($dado[0],$mensagem,$dado[3],$assunto,$data,$dado[4],$dado[5],$dado[6],$id_documentador));

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
                                <input name='dado[]' type='hidden' value='$valor'>";
                                }
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
				$assinatura=$dado[9];
				$assinante=$dado[10];
		                $destino=$dado[3];
				require "acessorio.php";
				echo"
                        	<p><a>Tipo de Documento: </a>$palavra_documento[1]</p>
				<p><a>Via: </a>$dado[1]</p>
				<p><a>C/C: </a>$dado[2]</p>
                        	<p><a>Destino: </a>$palavra_destino[0]</p>
                        	<p><a>Assunto: </a>$dado[4]</p>
                        	<p><a>Anexo(s): </a>$dado[5]</p>
                        	<p><a>Vocativo: </a>$dado[6]</p>
                        	<p><a>Mensagem: </a>$dado[7]</p>
                        	<p><a>Desfecho: </a>$dado[8]</p>
                        	<p><a>Assinante: </a>$palavra_assinatura[0]  $palavra_assinatura[1]</p>;
			  	<p><a>Assinatura: </a>$palavra_assinatura[2]</p>";
				}
			else if(($dado[0]=="3")||($dado[0]=="6")) //of?io interno ou of?io externo
				{
				$assinatura=$dado[9];
				$assinante=$dado[10];
        		        $destino=$dado[3];
  				require "acessorio.php";
				echo"
				<p><a>Tipo de Documento: </a>$palavra_documento[1]</p>
                                <p><a>Via: </a>$dado[1]</p>
				<p><a>C/C: </a>$dado[2]</p>
                                <p><a>Destino: </a>$dado[3]</p>
                                <p><a>Assunto: </a>$dado[4]</p>
                                <p><a>Anexo(s): </a>$dado[5]</p>
                                <p><a>Vocativo: </a>$dado[6]</p>
                                <p><a>Mensagem: </a>$dado[7]</p>
                        	<p><a>Desfecho: </a>$dado[8]</p>
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
				<p><a>C/C: </a>$dado[4]</p>
                                <p><a>Assunto: </a>$dado[5]</p>
                                <p><a>Vocativo: </a>$dado[6]</p>
				<p><a>Mensagem: </a>$dado[7]</p>
                                <p><a>Desfecho: </a>$dado[8]</p>";
				}
			else if($dado[0]=="4")  //ato
				{
				$assinatura=$dado[4];
				$assinante=$dado[5];
				require "acessorio.php";
                                echo"
                                <p><a>Tipo de Documento: </a>$palavra_documento[1]</p>
				<p><a>C/C: </a>$dado[2]</p>
                                <p><a>Mensagem: </a>$dado[3]</p>
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
	$res_SIGLA=db_query("SELECT sigla FROM admin_tipo WHERE id_tipo= ?", array($documento));
	$sigla= db_fetch_row($res_SIGLA,0);
	
	$seds[LATEXSIGLA]=$sigla[0];
	$seds[LATEXNUMERO]="XX";
	$seds[LATEXANO]=date("y");
	$seds[LATEXDATA]=$data;

	if (($dado[0]=="1") ) //memorando
        	{
		$assinatura=$dado[9];
		$assinante=$dado[10];
                $destino=$dado[3];
		require "acessorio.php";
		$seds[LATEXDESTINO]=mb_convert_encoding($palavra_destino[0],"ISO-8859-1","UTF-8");
		$seds[LATEXVIA]=$dado[1];
		$seds[LATEXCCOPIA]=$dado[2];
        	$seds[LATEXASSUNTO]=$dado[4];
        	$seds[LATEXANEXO]=$dado[5];
        	$seds[LATEXVOCATIVO]=$dado[6];
        	$seds[LATEXMENSAGEM]=$dado[7];
        	$seds[LATEXDESFECHO]=$dado[7];
		$nome_assinatura=mb_convert_encoding($palavra_assinatura[0],"ISO-8859-1","UTF-8");
		$sobrenome_assinatura=mb_convert_encoding($palavra_assinatura[1],"ISO-8859-1","UTF-8");
		$funcao_assinatura=mb_convert_encoding($palavra_assinatura[2],"ISO-8859-1","UTF-8");
        	$seds[LATEXNASSINATURA]=$palavra_assinatura[3]." ".$nome_assinatura." ".$sobrenome_assinatura;
		$seds[LATEXCASSINATURA]=$funcao_assinatura;
        	$arquivo="modelo_memorando.tex";

		}
	else if (($dado[0]=="3") || ($dado[0]=="6")) //oficio interno ou of?io externo
        	{
		$assinatura=$dado[9];
		$assinante=$dado[10];
                $destino=$dado[3];
                require "acessorio.php";
		$seds[LATEXDESTINO]=mb_convert_encoding($palavra_destino[0],"ISO-8859-1","UTF-8");
		$seds[LATEXVIA]=$dado[1];
		$seds[LATEXCCOPIA]=$dado[2];
        	$seds[LATEXASSUNTO]=$dado[4];
        	$seds[LATEXANEXO]=$dado[5];
        	$seds[LATEXVOCATIVO]=$dado[6];
        	$seds[LATEXMENSAGEM]=$dado[7];
        	$seds[LATEXDESFECHO]=$dado[8];
		$nome_assinatura=mb_convert_encoding($palavra_assinatura[0],"ISO-8859-1","UTF-8");
		$sobrenome_assinatura=mb_convert_encoding($palavra_assinatura[1],"ISO-8859-1","UTF-8");
		$funcao_assinatura=mb_convert_encoding($palavra_assinatura[2],"ISO-8859-1","UTF-8");
        	$seds[LATEXNASSINATURA]=$palavra_assinatura[3]." ".$nome_assinatura." ".$sobrenome_assinatura;
		$seds[LATEXCASSINATURA]=$funcao_assinatura;
       		$arquivo="modelo_oficio.tex";
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
		$seds[LATEXCCOPIA]=$dado[4];
		$seds[LATEXASSUNTO]=$dado[5];
//		$seds[LATEXANEXO]=$dado[3];
        	$seds[LATEXVOCATIVO]=$dado[6];
        	$seds[LATEXMENSAGEM]=$dado[7];
        	$seds[LATEXDESFECHO]=$dado[8];
		$nome_assinatura=mb_convert_encoding($palavra_assinatura[0],"ISO-8859-1","UTF-8");
		$sobrenome_assinatura=mb_convert_encoding($palavra_assinatura[1],"ISO-8859-1","UTF-8");
		$funcao_assinatura=mb_convert_encoding($palavra_assinatura[2],"ISO-8859-1","UTF-8");
        	$seds[LATEXNASSINATURA]=$palavra_assinatura[3]." ".$nome_assinatura." ".$sobrenome_assinatura;
		$seds[LATEXCASSINATURA]=$funcao_assinatura;
        	$arquivo="modelo_circular.tex";
        	}
	else if($dado[0]=="4") //ato
        	{
		$assinatura=$dado[4];
		$assinante=$dado[5];
                require "acessorio.php";
		$seds[LATEXCCOPIA]=$dado[2];
		$seds[LATEXMENSAGEM]=$dado[3];
		$nome_assinatura=mb_convert_encoding($palavra_assinatura[0],"ISO-8859-1","UTF-8");
		$sobrenome_assinatura=mb_convert_encoding($palavra_assinatura[1],"ISO-8859-1","UTF-8");
		$funcao_assinatura=mb_convert_encoding($palavra_assinatura[2],"ISO-8859-1","UTF-8");
        	$seds[LATEXNASSINATURA]=$palavra_assinatura[3]." ".$nome_assinatura." ".$sobrenome_assinatura;
		$seds[LATEXCASSINATURA]=$funcao_assinatura;
        	$arquivo="modelo_ato.tex";
        	}
        else if ($dado[0]=="5") //ata
        	{
                $assinatura=$dado[3];
                $assinante=$dado[4];
		$assinatura2=$dado[5];
                $assinante2=$dado[6];
		require "acessorio.php";
        	$seds[LATEXMENSAGEM]=$dado[2];
		$nome_assinatura=mb_convert_encoding($palavra_assinatura[0],"ISO-8859-1","UTF-8");
		$sobrenome_assinatura=mb_convert_encoding($palavra_assinatura[1],"ISO-8859-1","UTF-8");
		$funcao_assinatura=mb_convert_encoding($palavra_assinatura[2],"ISO-8859-1","UTF-8");
		$seds[LATEXNASSINATURA]=$palavra_assinatura[3]." ".$nome_assinatura." ".$sobrenome_assinatura;
                $seds[LATEXCASSINATURA]=$funcao_assinatura;
		$nome2_assinatura=mb_convert_encoding($palavra_assinatura2[0],"ISO-8859-1","UTF-8");
		$sobrenome2_assinatura=mb_convert_encoding($palavra_assinatura2[1],"ISO-8859-1","UTF-8");
		$funcao2_assinatura=mb_convert_encoding($palavra_assinatura2[2],"ISO-8859-1","UTF-8");
		$seds[LATEXN2ASSINATURA]=$palavra_assinatura2[3]." ".$nome2_assinatura." ".$sobrenome2_assinatura;
                $seds[LATEXC2ASSINATURA]=$funcao2_assinatura;
        	$arquivo="modelo_ata.tex";
        	}



//	print "a array seds ? ".print_r($seds);	

	// Gera o PDF sem passar pelo shell (ver global/latex_pdf.php)
	require_once("../../../global/latex_pdf.php");
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
