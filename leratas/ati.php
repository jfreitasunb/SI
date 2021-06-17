<?php
include("head_admin.php");

include("funcao_escolhe_arquivo.php");

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

$data=strftime("%d/%m/%Y");
////////////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////Visualiza?o do documento em pdf ///////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////////////////

else if ($acao=="Visualizar"){

	$documento=$dado[0];
	$res_SIGLA=pg_query("SELECT sigla FROM admin_tipo WHERE id_tipo= '$documento'")
	or die("N? foi poss?el executar a opera?o. Contacte a Coordena?o de Inform?ica.");
	$sigla= pg_fetch_row($res_SIGLA,0);
	
	$seds[LATEXSIGLA]=$sigla[0];
	$seds[LATEXNUMERO]="XX";
	$seds[LATEXANO]=date("y");
	$seds[LATEXDATA]=$data;
	$com_copia="";
	if (($dado[0]=="1") ) //memorando
        	{
		if (empty($_POST['com_copia'])) $com_copia=""; else $com_copia=$_POST['com_copia'];
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
	if ($com_copia=="") $arquivo="modelo_memorando.tex"; else  $arquivo="modelo_memorandocc.tex";

		}
	else if (($dado[0]=="3") || ($dado[0]=="6")) //oficio interno ou of?io externo
        	{
		if (empty($_POST['com_copia'])) $com_copia=""; else $com_copia=$_POST['com_copia'];
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
        	}
        else if($dado[0]=="2") //circular
        	{
		$assinatura=$dado[1];
		$assinante=$dado[2];
                $destino=$dado[3];
                require "acessorio.php";
		$seds[LATEXDESTINO]=mb_convert_encoding($palavra_destino[0],"ISO-8859-1","UTF-8");
		$seds[LATEXASSUNTO]=mb_convert_encoding($dado[4],"ISO-8859-1","UTF-8");
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
		$arquivo=escolhe_arquivo($data,$dado[0],$com_copia);

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

		if 	($colchete=="LATEXMENSAGEM")
			{
			$seds[$colchete]=str_replace("\n",'',$seds[$colchete]);
			if ($_POST['segunda']!="ok")  $seds[$colchete]=addslashes($seds[$colchete]);
			}
		else
			$seds[$colchete]=str_replace("\n",'',$seds[$colchete]);
		$seds[$colchete]=str_replace("/",'\/',$seds[$colchete]);
               	$seds[$colchete]=str_replace('&','\&',$seds[$colchete]);
               	$seds[$colchete]=str_replace("$",'\$',$seds[$colchete]);
               	$seds[$colchete]=str_replace("%",'\%',$seds[$colchete]);
               	$seds[$colchete]=str_replace("-",'\-',$seds[$colchete]);
		}


	$tmpfname = tempnam("/var/www/si/modules/servidor_admin/Tex/", "LALALA");     			
	exec("cat ./modelo_tex/".$arquivo." > ".$tmpfname.".tex");
	exec(" chmod 777 ".$tmpfname.".tex");
	Header("Content-type: application/pdf");
	foreach($seds as $key => $val )
		{


	$cmd = "sed \" s/".$key."/".$val."/\" ".$tmpfname.".tex > ".$tmpfname.".tex.tmp";	//do Guy
	exec($cmd);										//do Guy
	$cmd2=" mv ".$tmpfname.".tex.tmp  ".$tmpfname.".tex";					//do Guy
	exec($cmd2);										//do Guy
	exec(" chmod 777 ".$tmpfname.".tex");
		}

	exec("cd /var/www/si/modules/servidor_admin/Tex/; pwd; pdflatex ".$tmpfname.".tex");

	if($fp=fopen("".$tmpfname.".pdf","r")){
 		while (!feof($fp))
		{
   		$buffer = fgets($fp, 4096);
 		echo $buffer;
 		}
	   fclose($fp);
//	exec("cd /var/www/si/modules/servidor_admin/Tex/; pwd; /bin/rm -f ".$tmpfname."*");
//	exec("/bin/rm -f ".$tmpfname."*");
	}
}
?>
<?php
  pg_close($idconn);
?>
</table>
</body>
</html>
