<?php
//require "verifica.php";
//$lilo=(!$assunto || !$vocativo || !$mensagem || !$desfecho);
//echo !$lilo;

$dado=$_POST["dado"];
//echo $dado[0];

$acao=$_POST["acao"];
//$id_tipo=$_POST["id_tipo"];
$maior="";
foreach($dado as $preenchido){
	if(!$preenchido){
	echo "
		<head>
		<meta http-equiv='content-type' content='text/html; charset=iso-8859-1'>
		<title>Servidor Administrativo</title><style type='text/css' media='all'>@import 'style.css';</style></head>
		<body>
		<div id='Header'></div>
		<div id='Content'>
        		<h1>Aten??o!</h1>
			<p> ? necess?rio preencher todos os campos, exceto o campo <b>Anexo(s)</b>. Clique no <i>link</i> aba				ixo para retornar. </p>
			<p><a href='javascript:history.back();'> Retornar</a></p><br>";
	require "menu.php";
	echo "</body></html> ";
	exit;
	}
	else if (strlen($preenchido) > strlen($maior)){ 
		$valor=$preenchido;
		$maior=$preenchido;
		}
	}

//$valor=$dado[5];	
//echo $valor;
//	require "conexao.php";
	$data=strftime("%d/%m/%Y");	 
	if ($acao == "Salvar Rascunho"){

		if((!isset($_SESSION["verifica_reenvio"])) || strcmp($_SESSION["verifica_reenvio"],$valor)){
		
		$_SESSION["verifica_reenvio"]=$valor;
		//switch ($dado[0])
		//{
		if(($dado[0]=="1") || ($dado[0]=="3"))	
			$resultado1=pg_query("INSERT INTO rascunho (id_documentador,id_tipo,id_departamentos,vocativo,mensagem,
			desfecho,id_assinaturas,assunto,anexo,data) VALUES (default,'$dado[0]','$dado[1]','$dado[4]',
			'$dado[5]','$dado[6]','$dado[7]','$dado[2]','$dado[3]','$data')") 
			or die ("N?o foi poss?vel inserir os dados no banco");
			//break;

		else if ($dado[0]=="2")	
			$resultado1=pg_query("INSERT INTO rascunho (id_documentador,id_tipo,vocativo,mensagem,
                        desfecho,id_assinaturas,assunto,data) VALUES (default,'$dado[0]','$dado[3]','$dado[4]',
                        '$dado[5]','$dado[1]','$dado[2]','$data')")
                        or die ("N?o foi poss?vel inserir os dados no banco");
                        //break;

		else if ($dado[0]=="4")	
			$resultado1=pg_query("INSERT INTO rascunho (id_documentador,id_tipo,mensagem,
                        id_assinaturas,data) VALUES (default,'$dado[0]','$dado[1]','$dado[2]',
                        '$data')")
                        or die ("N?o foi poss?vel inserir os dados no banco");
                        //break;

		else if ($dado[0]=="5")	
			$resultado1=pg_query("INSERT INTO rascunho (id_documentador,id_tipo,mensagem,
                        data) VALUES (default,'$dado[0]','$dado[1]',
                        '$data')")
                        or die ("N?o foi poss?vel inserir os dados no banco");
                        //break;

		//}


		echo "
			<head> 
                	<meta http-equiv='content-type' content='text/html; charset=iso-8859-1'>
                	<title>Servidor Administrativo</title><style type='text/css' media='all'>@import 'style.css';</style>
                	</head>
                	<body> 
                	<div id='Header'></div>
                	<div id='Content'>
                	<h1>Servidor Administrativo</h1>
				<p> O documento foi inserido como <i>rascunho</i>. Para que ele possa ser impresso, clique no bot?o
				abaixo.</p><br>
			
			<form method='post' action='operacaopdf.php'>
			<div align='center'>
    				<input name='dado' type='hidden' value='$dado'>
    				<input type='submit' name='Submit' value='Visualizar para Impress?o'>
			</div></form>";
			require "menu.php";
			echo"</body></html> ";
			} 
		else 
			{
			echo"
			<head> 
			<meta http-equiv='content-type' content='text/html; charset=iso-8859-1'>
			<title>Servidor Administrativo</title><style type='text/css' media='all'>@import 'style.css';</style></head>
			<body> 
			<div id='Header'></div> 
			<div id='Content'> 
        		<h1>Servidor Administrativo</h1>
        		<p> <b><i>O documento j? foi salvo.</i></b> </p><br>";
			require "menu.php";
			echo"</body></html>";
	}}

	else if ($acao=="Visualizar"){

		function htmlEncodeText ($string)
{
  $pattern = '<([a-zA-Z0-9\. "\'_\/\-=;\(\)?&#%]+)>';
  preg_match_all ('/' . $pattern . '/', $string, $tagMatches, PREG_SET_ORDER);
  $textMatches = preg_split ('/' . $pattern . '/', $string);

  foreach ($textMatches as $key => $value) {
   $textMatches [$key] = htmlentities ($value);
  }

  for ($i = 0; $i < count ($textMatches); $i ++) {
   $textMatches [$i] = $textMatches [$i] . $tagMatches [$i] [0];
  }

  return implode ($textMatches);
} 


		//exec('/bin/rm -f /tmp/MEM*');
		//exec('/usr/local/bin/latex --interaction batchmode  '.$tmpfname.'.tex ; dvips '.$tmpfname.'.dvi ; ps2pdf '.$tmpfna			me.'.ps ');
		//exec('/bin/rm -f /tmp/MEM*');
		//exec('/bin/rm -f '.$tmpfname.'*');

$resultado2=pg_query("SELECT nome,cargo FROM assinaturas WHERE id_assinaturas = '$dado[2]'") or die("N\xe3o.");
$row2= pg_fetch_row($resultado2,$i);



        if (($dado[0]=="1") || ($dado[0]=="3")) //memorando ou oficio
        {
        $seds[LATEXNUMERO]="XX";
        //$seds[LATEXDESTINO]=str_replace$dado[1];
        $seds[LATEXASSUNTO]=$dado[2];
        $seds[LATEXANEXO]=$dado[3];
        $seds[LATEXVOCATIVO]=$dado[4];
        $seds[LATEXMENSAGEM]=$dado[5];
        $seds[LATEXDESFECHO]=$dado[6];
        $seds[LATEXNASSINATURA]=$row2[0];
        $seds[LATEXCASSINATURA]=$row2[1];
        $arquivo="/modelo_tex/modelo_memorando.tex";
        }

        else if($dado[0]=="2") //circular
        {
        $seds[LATEXNUMERO]="XX";
        $seds[LATEXASSUNTO]=$dado[2];
        $seds[LATEXVOCATIVO]=$dado[3];
        $seds[LATEXMENSAGEM]=$dado[4];
        $seds[LATEXDESFECHO]=$dado[5];
        $seds[LATEXNASSINATURA]=$row2[0];
        $arquivo="/modelo_tex/modelo_circular.tex";
        }

	else if($dado[0]=="4") //ato
        {
	//$seds=array("LATEXNUMERO"=>"XX","LATEXMENSAGEM"=>$dado[1],"LATEXNASSINATURA"=>$row2[0],"LATEXCASSINATURA"=>$row2[1]);
        $seds[LATEXNUMERO]='XX';
	//$valvula='Insira aqui a mensagem. \n ser? q funciona?';
	$dadinho=str_replace("\n",'pularlinha',$dado[1]);
	//$seds[LATEXNASSINATURA]="asdf kasjdhf";
	//exec('sed \'s/[[:cntrl:]]//g\' '.$dado[1].' > '.$dadom[1].'');
	//$dado[1]=str_replace("\n",'',$dado[1]);
	$seds['LATEXMENSAGEM']=htmlentities($dadinho);
	$seds['LATEXMENSAGEM']=str_replace("&",'\&',$seds['LATEXMENSAGEM']);
	//$dadom2=str_replace(";",'\;',$dadom);
	//$dadom2=str_replace("\n",'',$dadom2);
	//$dado[1]=str_replace("\n",'\\\\linebreak ',$dado[1]);
	//$a=preg_split('/ \\n | \\r /',$dado[1],-1,PREG_SPLIT_DELIM_CAPTURE);
	//$dadom[1]=implode(" ",$a);
	//echo $dadom[1];	
        //$seds[LATEXMENSAGEM]=$valvula;
        $seds[LATEXNASSINATURA]=$row2[0];
	$seds[LATEXCASSINATURA]=str_replace("/","barranormal",$row2[1]);
        //$arquivo="modelo_ato.tex";
	
        }

        else if ($dado[0]=="5") //ata
        {
        $seds[LATEXNUMERO]="XX";
        $seds[LATEXMENSAGEM]=$dado[1];
        $arquivo="/modelo_tex/modelo_ata.tex";
        }





//$template="/tmp/oliveira/modelo_memorando.tex";
//$seds[LATEXNUMERODOCUMENTO]="ASDASDASDASD";
$time=time();
$tmpfname = tempnam("tmp/", $dado[0].date("H:i:s"););
//$comando = "cat /tmp/oliveira/modelo_memorando.tex > ".$tmpfname.".tex";
exec("cat modelo_tex/modelo_ato.tex > ".$tmpfname.".tex");

//exec("sed -e 
Header("Content-type: application/pdf");
/*
foreach($seds as $key => $val )
{
$toca=htmlentities($val);
//ssthru("sed -e 's/$key/$val/g' /tmp/oliveira/modelo_ato.tex  > ".$tmpfname.".tex.tmp");
//exec("sed s/".$key."/".$val."/ ".$tmpfname.".tex");
// > ".$tmpfname.".tex.tmp; mv -f ".$tmpfname.".tex.tmp ".$tmpfname.".tex"
print "\$seds[$key] => $toca.<br>";
//echo "\n";
}
*/
//$teste="sed s/LATEXMENSAGEM/sera/ ".$tmpname.".tex > ".$tmpfname.".tex.tmp";
//shell_exec($teste);
//exec('sed -e "s/LATEXMENSAGEM/'.$dado[1].'/" '.$tmpname.'.tex > '.$tmpfname.'.tex.tmp');

/*Header("Content-type: application/pdf");
exec("cd /tmp/oliveira; /usr/local/bin/pdflatex ".$tmpfname.".tex");
//echo $errou;

$fp=fopen("".$tmpfname.".pdf","r");

 while (!feof($fp)) {
   $buffer = fgets($fp, 4096);
 echo $buffer;
 }

fclose($fp);
*/
//$vetor[LATEXMENSAGEM]="teste";

foreach($seds as $key => $val )
{
    exec('sed \'s/'.$key.'./'.$val.'/\' '.$tmpfname.'.tex > '.$tmpfname.'.tex.tmp; cat '.$tmpfname.'.tex.tmp > '.$tmpfname.'.tex');
}

exec('cd tmp/ ; ./conversor2 '.$tmpfname.'.tex > '.$tmpfname.'.tex.mod ; mv '.$tmpfname.'.tex.mod '.$tmpfname.'.tex');
exec('cd tmp/ ; /usr/local/bin/pdflatex -interaction nonstopmode '.$tmpfname.'.tex');

$fp=fopen("".$tmpfname.".pdf","r");

 while (!feof($fp)) {
   $buffer = fgets($fp, 4096);
 echo $buffer;
 }
fclose($fp);

//exec('sed \'s/LATEXMENSAGEM/'.$causa.'/\' '.$tmpfname.'.tex > '.$tmpfname.'.tex.tmp; cat '.$tmpfname.'.tex.tmp > '.$tmpfname.'.tex');

//echo $seds[LATEXMENSAGEM][3];
//$data='.$val.'

}

?>
