<?php 

include("head_admin.php"); 
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
	</td>
      </tr>
</table>
</body>
</html>
<?php
}

//imprimir o pdf do documento definitivo
else if(($_POST['acao2']=="Visualizar")||($_GET['acao2']=="Visualizar")){

//	print " Estou no Visualizar do operacao_2";

//	exec('/bin/rm -f ./Tex/ABAB*');
	if(isset($_POST['acao2'])) $id_documentador=$_POST['id_documentador'];
	if(isset($_GET['acao2'])) $id_documentador=$_GET['id_documentador'];

//	print " id_documentador no Visualizar do operacao_2".$id_documentador;

	//busca pelo "documento" na tabela "documentador".
	$resultado=pg_query("SELECT * FROM admin_documentador WHERE id_documentador = '$id_documentador'")
	or die("Nao foi possivel executar a operacao. Contacte a Coordenacao de Informatica.");
	$coluna= pg_fetch_row($resultado,0);

	//dados para uso do arquivo 'acessorio.php'

	$documento=$coluna[1];
	$assinatura=$coluna[6];
	$assinante=$coluna[12];
	$destino=$coluna[3];


      if($coluna[1]=="5")
              {
                $assinatura=$coluna[6];
                $assinante=$coluna[12];
                $assinatura2=$coluna[13];
                $assinante2=$coluna[14];
              }

	require "acessorio.php";


        $seds[LATEXSIGLA]=$palavra_documento[0]; //$sigla[0];

        $seds[LATEXNUMERO]=$coluna[2];
	$latexano=explode("/",$coluna[9]); 
//	$seds[LATEXANO]=date("y");
	$seds[LATEXANO]=$latexano[2];
        $seds[LATEXDATA]=$coluna[9];

        $seds[LATEXDESTINO]=mb_convert_encoding($palavra_destino[0],"ISO-8859-1","UTF-8");
        $seds[LATEXVIA]=mb_convert_encoding($coluna[11],"ISO-8859-1","UTF-8");
        $seds[LATEXCOMCOPIA]=mb_convert_encoding($coluna[15],"ISO-8859-1","UTF-8");
        $seds[LATEXASSUNTO]=mb_convert_encoding($coluna[7],"ISO-8859-1","UTF-8");
        $seds[LATEXANEXO]=mb_convert_encoding($coluna[8],"ISO-8859-1","UTF-8");
        $seds[LATEXVOCATIVO]=mb_convert_encoding($coluna[10],"ISO-8859-1","UTF-8");
        $seds[LATEXMENSAGEM]=addslashes(mb_convert_encoding($coluna[4],"ISO-8859-1","UTF-8"));
        $seds[LATEXDESFECHO]=mb_convert_encoding($coluna[5],"ISO-8859-1","UTF-8");
       	$seds[LATEXNASSINATURA]=$palavra_assinatura[3]." ".mb_convert_encoding($palavra_assinatura[0]." ".$palavra_assinatura[1],"ISO-8859-1","UTF-8");
	$seds[LATEXCASSINATURA]=mb_convert_encoding($palavra_assinatura[2],"ISO-8859-1","UTF-8");

        if (($coluna[1]=="1") ) //memorando
                {
		if (empty($coluna[15])) $arquivo="modelo_memorando.tex"; else $arquivo="modelo_memorandocc.tex";
                }
        else if (($coluna[1]=="3") ||($coluna[1]=="6")) //oficio interno ou oficio externo
                {
                if (empty($coluna[15])) $arquivo="modelo_oficio.tex";else $arquivo="modelo_oficiocc.tex";
                }
        else if($coluna[1]=="2") //circular
                {
                $arquivo="modelo_circular.tex";
                }
        else if($coluna[1]=="4") //ato
                {
                $arquivo="modelo_ato.tex";
                }
        else if ($coluna[1]=="5") //ata
                {
		$seds[LATEXN2ASSINATURA]=$palavra_assinatura2[3]." ".mb_convert_encoding($palavra_assinatura2[0]." ".$palavra_assinatura2[1],"ISO-8859-1","UTF-8");
	        $seds[LATEXC2ASSINATURA]=mb_convert_encoding($palavra_assinatura2[2],"ISO-8859-1","UTF-8");
                $arquivo="modelo_ata.tex";
                }
	 $arquivo=escolhe_arquivo($coluna[9],$coluna[1],$coluna[15]);

        foreach ($seds as $colchete => $valor){
                if ($colchete=="LATEXMENSAGEM")
                        $seds[$colchete]=str_replace("\n",'',$seds[$colchete]);
//                        $seds[$colchete]=str_replace("\n",'^M',$seds[$colchete]);
                else
                        $seds[$colchete]=str_replace("\n",'',$seds[$colchete]);
                $seds[$colchete]=str_replace("/",'\/',$seds[$colchete]);
                $seds[$colchete]=str_replace('&','\&',$seds[$colchete]);
                $seds[$colchete]=str_replace("$",'\$',$seds[$colchete]);
                $seds[$colchete]=str_replace("%",'\%',$seds[$colchete]);
                $seds[$colchete]=str_replace("-",'\-',$seds[$colchete]);
                }


        $tmpfname = tempnam("/var/www/si/modules/servidor_admin/Tex", "LALALA");
        exec("cat ../modules/servidor_admin/modelo_tex/".$arquivo." > ".$tmpfname.".tex");
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

//	exec('cd ../Tex/ ;/usr/local/bin/pdflatex -interaction nonstopmode '.$tmpfname.'.tex');
	exec("cd /var/www/si/modules/servidor_admin/Tex; pwd; pdflatex ".$tmpfname.".tex");

        if($fp=fopen("".$tmpfname.".pdf","r")){
        while (!feof($fp)) {
                $buffer = fgets($fp, 4096);
                echo $buffer;
                }
        fclose($fp);
        exec('/bin/rm -f '.$tmpfname.'*');
	}
}
pg_close($con);
?>

