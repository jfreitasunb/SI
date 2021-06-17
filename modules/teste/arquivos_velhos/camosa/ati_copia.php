<?php
//visualização do documento em pdf
else if ($acao=="Visualizar"){


	//exec('/bin/rm -f /tmp/oliveira/ABAB*');
	//require "acessorio.php";

	$documento=$dado[0];	
	$seds[LATEXNUMERO]="XX";
	$seds[LATEXDATA]=$data; 
	
	if (($dado[0]=="1") ) //memorando
        	{
		$assinatura=$dado[8];
                $destino=$dado[2];
                require "acessorio.php";
        	$seds[LATEXDESTINO]=$palavra_destino[0];
		$seds[LATEXVIA]=$dado[1];
        	$seds[LATEXASSUNTO]=$dado[3];
        	$seds[LATEXANEXO]=$dado[4];
        	$seds[LATEXVOCATIVO]=$dado[5];
        	$seds[LATEXMENSAGEM]=$dado[6];
        	$seds[LATEXDESFECHO]=$dado[7];
        	$seds[LATEXNASSINATURA]=$palavra_assinatura[0];
        	$seds[LATEXCASSINATURA]=$palavra_assinatura[1];
        	$arquivo="modelo_memorando.tex";
        	}
	else if (($dado[0]=="3") || ($dado[0]=="6")) //oficio interno ou ofício externo
        	{
		$assinatura=$dado[7];
                require "acessorio.php";
        	$seds[LATEXDESTINO]=$dado[2];
		$seds[LATEXVIA]=$dado[1];
        	$seds[LATEXASSUNTO]=$dado[3];
        	$seds[LATEXANEXO]=$dado[4];
        	$seds[LATEXVOCATIVO]=$dado[5];
        	$seds[LATEXMENSAGEM]=$dado[6];
        	$seds[LATEXNASSINATURA]=$palavra_assinatura[0];
        	$seds[LATEXCASSINATURA]=$palavra_assinatura[1];
		if ($dado[0]=="3")
        		$arquivo="modelo_oficio_interno.tex";
		else
			$arquivo="modelo_oficio_externo.tex";
        	}
        else if($dado[0]=="2") //circular
        	{
		$assinatura=$dado[4];
                require "acessorio.php";
        	$seds[LATEXDESTINO]=$dado[1];
		$seds[LATEXASSUNTO]=$dado[2];
		$seds[LATEXANEXO]=$dado[3];
        	$seds[LATEXVOCATIVO]=$dado[4];
        	$seds[LATEXMENSAGEM]=$dado[5];
        	$seds[LATEXNASSINATURA]=$palavra_assinatura[0];
		$seds[LATEXCASSINATURA]=$palavra_assinatura[1];
        	$arquivo="modelo_circular.tex";
        	}
	else if($dado[0]=="4") //ato
        	{
		$assinatura=$dado[2];
                require "acessorio.php";
		$seds[LATEXMENSAGEM]=$dado[1];
        	$seds[LATEXNASSINATURA]=$palavra_assinatura[0];
		$seds[LATEXCASSINATURA]=$palavra_assinatura[1];
        	$arquivo="modelo_ato.tex";
        	}
        else if ($dado[0]=="5") //ata
        	{
         	$seds[LATEXMENSAGEM]=$dado[1];
        	$arquivo="modelo_ata.tex";
        	}

	foreach ($seds as $colchete => $valor){
		if ($colchete=="LATEXMENSAGEM")
			$seds[$colchete]=str_replace("\n",'pularlinha',$seds[$colchete]);
		else
			$seds[$colchete]=str_replace("\n",'',$seds[$colchete]);
		$seds[$colchete]=htmlentities($seds[$colchete]);
		$seds[$colchete]=str_replace("/",'barranormal',$seds[$colchete]);
		$seds[$colchete]=str_replace("&",'\&',$seds[$colchete]);
		$seds[$colchete]=str_replace("$",'simbolocifao',$seds[$colchete]);
		$seds[$colchete]=str_replace("%",'simboloporcentagem',$seds[$colchete]);
		$seds[$colchete]=str_replace("-",'simbolotraco',$seds[$colchete]);
		}


	$tmpfname = tempnam("/tmp/oliveira", "ABAB");
	exec("cat /usr/local/miolo/html/camosa/modelo_tex/".$arquivo." > ".$tmpfname.".tex");

	Header("Content-type: application/pdf");

	foreach($seds as $key => $val )
		{
exec('sed \'s/'.$key.'./'.$val.'/\' '.$tmpfname.'.tex > '.$tmpfname.'.tex.tmp; mv '.$tmpfname.'.tex.tmp  '.$tmpfname.'.tex');
		}

exec('cd /tmp/oliveira/ ; ./conversor2 '.$tmpfname.'.tex > '.$tmpfname.'.tex.mod ; mv '.$tmpfname.'.tex.mod '.$tmpfname.'.tex;
	/usr/local/bin/pdflatex -interaction nonstopmode '.$tmpfname.'.tex');

	$fp=fopen("".$tmpfname.".pdf","r");
 	while (!feof($fp)) {
   		$buffer = fgets($fp, 4096);
 		echo $buffer;
 		}
	fclose($fp);
	//exec('/bin/rm -f '.$tmpfname.'*');

}

?>
