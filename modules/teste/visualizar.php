<?php
	exec('/pdflatex/rm -f /home/cristian/XDLD*');    //require "acessorio.php";
	$documento=$dado[0];
	$seds[LATEXNUMERO]="XX";
	$seds[LATEXDATA]=$data;

	if (($dado[0]=="1") ) //memorando
        	{
		require "acessorio.php";
		$assinatura=$dado[8];
                $destino=$dado[2];
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

	else if($dado[0]=="2") //circular
        	{     require "acessorio.php";
		$assinatura=$dado[4];
                $seds[LATEXDESTINO]=$dado[1];
		$seds[LATEXASSUNTO]=$dado[2];
		$seds[LATEXANEXO]=$dado[3];
        	$seds[LATEXVOCATIVO]=$dado[4];
        	$seds[LATEXMENSAGEM]=$dado[5];
        	$seds[LATEXNASSINATURA]=$palavra_assinatura[0];
		$seds[LATEXCASSINATURA]=$palavra_assinatura[1];
        	$arquivo="modelo_circular.tex";
        	}

	else if (($dado[0]=="3") || ($dado[0]=="6")) //oficio interno ou of?cio externo
        	{   require "acessorio.php";
		$assinatura=$dado[7];
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

		if ($colchete=="LATEXMENSAGEM") 	$seds[$colchete]=str_replace("\n",'',$seds[$colchete]);
		else 	$seds[$colchete]=str_replace("\n",'',$seds[$colchete]);
			$seds[$colchete]=str_replace("/",'\/',$seds[$colchete]);
                	$seds[$colchete]=str_replace('&','\&',$seds[$colchete]);
                	$seds[$colchete]=str_replace("$",'\$',$seds[$colchete]);
                	$seds[$colchete]=str_replace("%",'\%',$seds[$colchete]);
                	$seds[$colchete]=str_replace("-",'\-',$seds[$colchete]);
						}


	$tmpfname = tempnam("/tmp/cristiano", "XDLD");
	exec("cat /home/cristian/modelos/".$arquivo." > ".$tmpfname.".tex");

	Header("Content-type: application/pdf");

	foreach($seds as $key => $val )
		{
exec('sed \'s/'.$key.'./'.$val.'/\' '.$tmpfname.'.tex > '.$tmpfname.'.tex.tmp; mv '.$tmpfname.'.tex.tmp  '.$tmpfname.'.tex');
		}
exec('cd /tmp/cristiano/ ;/tmp/cristiano/pdflatex -interaction nonstopmode '.$tmpfname.'.tex');

	$fp=fopen("".$tmpfname.".pdf","r");
 	while (!feof($fp)) {
   		$buffer = fgets($fp, 4096);
 		echo $buffer;
 		}
	fclose($fp);
	exec('/pdflatex/rm -f '.$tmpfname.'*');
}
?>
