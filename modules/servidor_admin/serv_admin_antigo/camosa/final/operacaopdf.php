<?php
require "verifica.php";
require "conexao.php";
 	$id_documentador=$_GET["id_documentador"];
	exec('/bin/rm -f /tmp/oliveira/ABAB*');

        //busca pelo "documento" na tabela "documentador".
        $resultado=pg_query("SELECT * FROM admin_documentador WHERE id_documentador = '$id_documentador'")
        or die("Não foi possível executar a operação. Contacte a Coordenação de Informática.");
        $coluna= pg_fetch_row($resultado,$i);

        //dados para uso do arquivo 'acessorio.php'
        $documento=$coluna[1];
	if($coluna[1]=="1")
                $destino=$coluna[3];
        $assinatura=$coluna[6];

        require "acessorio.php";


        $seds[LATEXNUMERO]=$coluna[2];
        $seds[LATEXDATA]=$coluna[9];

        if (($coluna[1]=="1") ) //memorando
                {
                $seds[LATEXDESTINO]=$palavra_destino[0];
                $seds[LATEXVIA]=$coluna[11];
                $seds[LATEXASSUNTO]=$coluna[7];
                $seds[LATEXANEXO]=$coluna[8];
                $seds[LATEXVOCATIVO]=$coluna[10];
                $seds[LATEXMENSAGEM]=$coluna[4];
                $seds[LATEXDESFECHO]=$coluna[5];
                $seds[LATEXNASSINATURA]=$palavra_assinatura[0];
                $seds[LATEXCASSINATURA]=$palavra_assinatura[1];
                $arquivo="modelo_memorando.tex";
                }
	else if (($coluna[1]=="3")||($coluna[1]=="6")) //oficio interno ou externo
                {
                $seds[LATEXDESTINO]=$coluna[5];
                $seds[LATEXASSUNTO]=$coluna[7];
                $seds[LATEXANEXO]=$coluna[8];
                $seds[LATEXVOCATIVO]=$coluna[10];
                $seds[LATEXMENSAGEM]=$coluna[4];
                $seds[LATEXNASSINATURA]=$palavra_assinatura[0];
                $seds[LATEXCASSINATURA]=$palavra_assinatura[1];
                $arquivo="modelo_oficio.tex";
                }
        else if($coluna[1]=="2") //circular
                {
                $seds[LATEXDESFECHO]=$coluna[5];
                $seds[LATEXASSUNTO]=$coluna[7];
                $seds[LATEXANEXO]=$coluna[8];
                $seds[LATEXVOCATIVO]=$coluna[10];
                $seds[LATEXMENSAGEM]=$coluna[4];
                $seds[LATEXNASSINATURA]=$palavra_assinatura[0];
                $seds[LATEXCASSINATURA]=$palavra_assinatura[1];
                $arquivo="modelo_circular.tex";
                }
        else if($coluna[1]=="4") //ato
                {
                $seds[LATEXMENSAGEM]=$coluna[5];
                $seds[LATEXNASSINATURA]=$palavra_assinatura[0];
                $seds[LATEXCASSINATURA]=$palavra_assinatura[1];
                $arquivo="modelo_ato.tex";
                }
        else if ($coluna[1]=="5") //ata
                {
                $seds[LATEXMENSAGEM]=$coluna[5];
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
        exec('/bin/rm -f '.$tmpfname.'*');
?>
