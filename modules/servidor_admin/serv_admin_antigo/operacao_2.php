<?php include("head_account.php"); ?>
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

if ($acao2 == "Confirmar"){
	//preparação para a verificação de reenvio de mesmo documento
	if(($dado[0]=="1") || ($dado[0]=="3") || ($dado[0]=="6"))
        	$mensagem=$dado[6];
	else if(($dado[0]=="2"))
        	$mensagem=$dado[5];
	else if(($dado[0]=="4"))
        	$mensagem=$dado[1];
	else if(($dado[0]=="5"))
        	$mensagem=$dado[1];

	if((!isset($_SESSION["verifica_definitivo"])) || strcmp($_SESSION["verifica_definitivo"],$mensagem)){
		$_SESSION["verifica_definitivo"]=$mensagem;
		$data=strftime("%d/%m/%Y");

		/*
		//contador para definição do número do documento.
		$resultado=pg_query("SELECT id_documentador FROM documentador WHERE id_tipo='$dado[0]'")
		or die ("N\xe3o foi poss\xedvel realizar a consulta ao banco de dados");
		$contador=pg_num_rows($resultado) + 1;
		*/

		/* modulo a ser usado quando todos os documentos antigos ja tiverem sido inseridos
		//contagem para definição do número do documento. Uso da funcao MAX, que retorna o valor máximo do campo sugerido.
                $resultado=pg_query("SELECT MAX(numerodocumento) FROM admin_documentador WHERE id_tipo='$dado[0]'")
                or die ("N\xe3o foi poss\xedvel realizar a consulta ao banco de dados");
                $matriz=pg_fetch_row($resultado);
		$contador=$matriz[0]+1;
		*/

		//modulo provisorio para acrescimo na tabela admin_tipo sobre novos documentos
		$resultado=pg_query("SELECT novo FROM admin_tipo WHERE id_tipo='$dado[0]'")
                or die ("N\xe3o foi poss\xedvel realizar a consulta ao banco de dados");
                $matriz=pg_fetch_row($resultado);
                $contador=$matriz[0]+1;



		//acréscimo do documento na tabela "documentador".
		if($dado[0]=="1")//memorando
			$resultado_banco=pg_query("INSERT INTO admin_documentador (id_documentador,id_tipo,numerodocumento,
			id_departamento,vocativo,mensagem,desfecho,id_assinatura,assunto,anexo,data,via)
                	VALUES (default,'$dado[0]','$contador','$dado[2]','$dado[5]','$dado[6]','$dado[7]','$dado[8]',
			'$dado[3]','$dado[4]','$data','$dado[1]')")
			or die("N\xe3o foi poss\xedvel inserir os dados.");
		else if(($dado[0]=="3")||($dado[0]=="6"))//ofício interno ou ofício externo
			$resultado_banco=pg_query("INSERT INTO admin_documentador (id_documentador,id_tipo,numerodocumento,
                	vocativo,mensagem,desfecho,id_assinatura,assunto,anexo,data,via)
                	VALUES (default,'$dado[0]','$contador','$dado[5]','$dado[6]','$dado[2]','$dado[7]','$dado[3]',
                	'$dado[4]','$data','$dado[1]')")
                	or die("N\xe3o foi poss\xedvel inserir os dados.");
		else if($dado[0]=="2")//circular
			$resultado_banco=pg_query("INSERT INTO admin_documentador (id_documentador,id_tipo,numerodocumento,
                	vocativo,mensagem,desfecho,id_assinatura,assunto,anexo,data)
                	VALUES (default,'$dado[0]','$contador','$dado[4]','$dado[5]','$dado[6]','$dado[1]','$dado[3]',
                	'$dado[2]','$data')")
                	or die("N\xe3o foi poss\xedvel inserir os dados.");
		else if($dado[0]=="4")//ato
			$resultado_banco=pg_query("INSERT INTO admin_documentador (id_documentador,id_tipo,numerodocumento,
                	mensagem,id_assinatura,data)
                	VALUES (default,'$dado[0]','$contador','$dado[1]','$dado[2]','$data')")
                	or die("N\xe3o foi poss\xedvel inserir os dados.");
		else if($dado[0]=="5")//ata
			$resultado_banco=pg_query("INSERT INTO admin_documentador (id_documentador,id_tipo,numerodocumento,
                	mensagem,data)
                	VALUES (default,'$dado[0]','$contador','$dado[1]','$data')")
                	or die("N\xe3o foi poss\xedvel inserir os dados.");



		//atualizacao do numero do documento na tabela admin_tipo
                $result=pg_query("UPDATE admin_tipo SET novo='$contador' WHERE id_tipo='$dado[0]'")
                or die ("N\xe3o foi poss\xedvel atualizar o campo 'novo' no banco de dados");


		//armazanamento do "id_documentador" que acabou de ser inserido na variável "id_documentador".
		$resultado2=pg_query("SELECT id_documentador FROM admin_documentador WHERE numerodocumento = '$contador'
		and id_tipo = '$dado[0]'")
		or die("Não foi possível executar a operação. Contacte a Coordenação de Informática.");
		$coluna = pg_fetch_row($resultado2,$i);
		$id_documentador = $coluna[0];

		//deleção do documento na tabela "rascunho".
		$resultado=pg_query("DELETE FROM admin_rascunho WHERE id_documentador='$r_documento'")
		or die ("N\xe3o foi poss\xedvel realizar a consulta ao banco de dados");
		echo"
        	<h1>Servidor Administrativo</h1>
		<p> O documento foi inserido com sucesso. Para que ele possa ser impresso, clique no botão abaixo . </p><br>

		<form method='post' action='operacao_2.php'>
		<div align='center'>
    			<input name='id_documentador' type='hidden' value='$id_documentador'>
    			<input type='submit' name='acao2' value='Visualizar'>
	 	</div></form>";
		}
	else  {
		echo "
        	<h1>Servidor Administrativo</h1>
        	<p> <b><i>O documento já foi salvo.</i></b> </p><br>";
		}
	}

//imprimir o pdf do documento definitivo
else if($acao2=="Visualizar"){
	exec('/bin/rm -f ../Tex/ABAB*');

	//busca pelo "documento" na tabela "documentador".
	$resultado=pg_query("SELECT * FROM admin_documentador WHERE id_documentador = '$id_documentador'")
	or die("Não foi possível executar a operação. Contacte a Coordenação de Informática.");
	$coluna= pg_fetch_row($resultado,$i);

	//dados para uso do arquivo 'acessorio.php'
	$documento=$coluna[1];
	if($coluna[1]=="1"){
		$assinatura=$coluna[6];
		$destino=$coluna[3];
		}
	else if($coluna[1]=="3")
		$assinatura=$coluna[6];
	else if($coluna[1]=="2")
                $assinatura=$coluna[6];
	else if($coluna[1]=="4")
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
        else if (($coluna[1]=="3") ||($coluna[1]=="6")) //oficio interno ou oficio externo
                {
                $seds[LATEXDESTINO]=$coluna[5];
		$seds[LATEXVIA]=$coluna[11];
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
                $seds[LATEXMENSAGEM]=$coluna[4];
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
                        $seds[$colchete]=str_replace("\n",'^M',$seds[$colchete]);
                else
                        $seds[$colchete]=str_replace("\n",'',$seds[$colchete]);
                $seds[$colchete]=str_replace("/",'\/',$seds[$colchete]);
                $seds[$colchete]=str_replace('&','\&',$seds[$colchete]);
                $seds[$colchete]=str_replace("$",'\$',$seds[$colchete]);
                $seds[$colchete]=str_replace("%",'\%',$seds[$colchete]);
                $seds[$colchete]=str_replace("-",'\-',$seds[$colchete]);
                }


        $tmpfname = tempnam("../Tex", "ABAB");
        exec("cat ../modelo_tex/".$arquivo." > ".$tmpfname.".tex");

        Header("Content-type: application/pdf");

        foreach($seds as $key => $val )
                {
exec('sed \'s/'.$key.'./'.$val.'/\' '.$tmpfname.'.tex > '.$tmpfname.'.tex.tmp; mv '.$tmpfname.'.tex.tmp  '.$tmpfname.'.tex');
                }
/*
exec('cd /tmp/oliveira/ ; ./conversor2 '.$tmpfname.'.tex > '.$tmpfname.'.tex.mod ; mv '.$tmpfname.'.tex.mod '.$tmpfname.'.tex;
        /usr/local/bin/pdflatex -interaction nonstopmode '.$tmpfname.'.tex');
*/

	exec('cd ../Tex/ ;/usr/local/bin/pdflatex -interaction nonstopmode '.$tmpfname.'.tex');

        $fp=fopen("".$tmpfname.".pdf","r");
        while (!feof($fp)) {
                $buffer = fgets($fp, 4096);
                echo $buffer;
                }
        fclose($fp);
        exec('/bin/rm -f '.$tmpfname.'*');

}

?>
