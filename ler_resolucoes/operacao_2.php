<?php 
include("head_resolucoes.php"); 

session_start();

if (!isset($_SESSION['autenticado']) or !$_SESSION['autenticado']) {
     header("location:http://www.mat.unb.br");
}

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
    
	$submeter="TRUE";
	$codigo = $dado[6];
	$data=strftime("%Y-%m-%d");

    $query_documentador="SELECT MAX(numero_resolucao) FROM admin_resolucoes_colegiado WHERE data_publicacao::text like '%".date("Y")."%'";
    $resultado=pg_query($query_documentador) or die ("N&atilde;o foi poss&iacute;vel realizar a consulta ao banco de dados.");
    
    $matriz=pg_fetch_row($resultado);
    
    $contador=$matriz[0]+1;
    
    $data_temporario = explode("/", $dado[0]);
    $dado[0] = $data_temporario[2]."-".$data_temporario[1]."-".$data_temporario[0];

//Criar tabelas para receber assinante, assinatura, data de publicação



if ($codigo!=0) $pg_linha="update admin_resolucoes_colegiado set data_reuniao='".$dado[0]."', numero_reuniao='".$dado[1]."', assunto_resolucao='".$dado[2]."',texto_resolucao='".$dado[3]."',submetido='".$submeter."',assinatura='".$dado[4]."',assinante='".$dado[5]."',data_publicacao='".$data."',numero_resolucao='".$contador."' where codigo='".$codigo."'";

$query_resolucao=pg_query($pg_linha) or die("problema de conexao 3.0");

		echo"
        	<h1>Servidor Administrativo</h1>
		<p> O documento foi inserido com sucesso. Para que ele possa ser impresso, clique no bot&atilde;o abaixo. </p><br>

		<form method='post' action='operacao_2.php'>
		<div align='center'>
    			<input name='numero_resolucao' type='hidden' value='$contador'>
    			<input type='submit' name='acao2' value='Visualizar'>
	 	</div></form>";
	}

//imprimir o pdf do documento definitivo
else if(($_POST['acao2']=="Visualizar")||($_GET['acao2']=="Visualizar")){

//	print " Estou no Visualizar do operacao_2";

//	exec('/bin/rm -f ./Tex/ABAB*');
	if(isset($_POST['acao2'])) $id_documentador=$_POST['numero_resolucao'];
	if(isset($_GET['acao2'])) $id_documentador=$_GET['numero_resolucao'];
    // echo "id_documentador: ".$id_documentador;
    // die();


//	print " id_documentador no Visualizar do operacao_2".$id_documentador;

	//busca pelo "documento" na tabela "documentador".
	$resultado=pg_query("SELECT * FROM admin_resolucoes_colegiado WHERE numero_resolucao = '$id_documentador'") or die("N&atilde;o foi poss&iacute;vel executar a opera&ccedil;&atilde;o. Contacte a Coordena&ccedil;&atilde;o de Inform&aacute;tica.");
	$coluna= pg_fetch_row($resultado,0);
    // print_r($coluna);
    // die();
	
	$assinatura=$coluna[7];
	$assinante=$coluna[8];
	

	require "acessorio.php";
	$nome_assinatura=$palavra_assinatura[0];
	$sobrenome_assinatura=$palavra_assinatura[1];

	$ano_reuniao=explode("-",$coluna[1]);
	$ano_publicacao=explode("-",$coluna[6]); 

	// print_r($latexano2);
	// die();
	
$seds[LATEXDATACOLEGIADO]=$ano_reuniao[2]."/".$ano_reuniao[1]."/".$ano_reuniao[0];
$seds[LATEXNUMCOLEGIADO]=$coluna[2];
$seds[LATEXRESUMO]=addslashes(addslashes($coluna[3]));
//$texto_resolucao_tratado = str_replace('\\\\\\\\', '\\', $coluna[3]);
$seds[LATEXTEXTORESOLUCAO]=addslashes(addslashes($coluna[4]));

// echo "Texto original: ".$seds['LATEXRESUMO']."</br>";
// echo "Texto tratado: ".$texto_resolucao_tratado."</br>";
// die();

$mes = $ano_publicacao[1];
$ano = $ano_publicacao[0];
//$semana = date('w');

switch ($mes){

case 1: $mes = "Janeiro"; break;
case 2: $mes = "Fevereiro"; break;
case 3: $mes = "Março"; break;
case 4: $mes = "Abril"; break;
case 5: $mes = "Maio"; break;
case 6: $mes = "Junho"; break;
case 7: $mes = "Julho"; break;
case 8: $mes = "Agosto"; break;
case 9: $mes = "Setembro"; break;
case 10: $mes = "Outubro"; break;
case 11: $mes = "Novembro"; break;
case 12: $mes = "Dezembro"; break;

}

$seds[LATEXDATAPUBLICACAO] = $ano_publicacao[2]." de ".$mes." de ".$ano;

//echo ("$cidade, $dia de $mes de $ano");


if ($coluna[9]=="") {
        $seds[LATEXNUMERORESOLUCAO] = "XX";
}else{
        $seds[LATEXNUMERORESOLUCAO]=$coluna[9];
}

$seds[LATEXANO]=date("Y");


$seds[LATEXNASSINATURA] = $palavra_assinatura[3]." ".$nome_assinatura." ".$sobrenome_assinatura;
$seds[LATEXCASSINATURA] = $palavra_assinatura[2];

$arquivo="modelo_resolucao.tex";

// #$%&?!*: latex   % \%; & \&; # \#; $ \$;  

        foreach ($seds as $colchete => $valor)
		{
                if ($colchete=="LATEXMENSAGEM")
                        $seds[$colchete]=str_replace("\n",'',$seds[$colchete]);
                else
                        $seds[$colchete]=str_replace("\n",'',$seds[$colchete]);
                $seds[$colchete]=str_replace("/",'\/',$seds[$colchete]);
                $seds[$colchete]=str_replace('&','\&',$seds[$colchete]);
                $seds[$colchete]=str_replace("$",'\$',$seds[$colchete]);
                $seds[$colchete]=str_replace("%",'\%',$seds[$colchete]);
                $seds[$colchete]=str_replace("#",'\#',$seds[$colchete]);
//                $seds[$colchete]=str_replace("#",'\\#',$seds[$colchete]);
                $seds[$colchete]=str_replace("-",'\-',$seds[$colchete]);
                $seds[$colchete]=str_replace("_",'\_',$seds[$colchete]);
                $seds[$colchete]=str_replace("cao",'ção',$seds[$colchete]);
		$seds[$colchete]=str_replace("sem_vinculo",'sem vínculo',$seds[$colchete]);
                }
	
        $tmpfname = tempnam("/var/www/si/modules/servidor_admin/Tex", "JFMTR");
        exec("cat ./modelo_tex/".$arquivo." > ".$tmpfname.".tex");
	exec(" chmod 777 ".$tmpfname.".tex");
	Header("Content-type: application/pdf");
//	Header("Content-type: application/ps");
        foreach($seds as $key => $val )
                {
//exec('sed \'s/'.$key.'./'.$val.'/\' '.$tmpfname.'.tex > '.$tmpfname.'.tex.tmp; mv '.$tmpfname.'.tex.tmp  '.$tmpfname.'.tex');
	$cmd = "sed \" s/".$key."/".$val."/\" ".$tmpfname.".tex > ".$tmpfname.".tex.tmp";	//do Guy
	exec($cmd);										//do Guy
	$cmd2=" mv ".$tmpfname.".tex.tmp  ".$tmpfname.".tex";					//do Guy
	exec($cmd2);										//do Guy
	exec(" chmod 777 ".$tmpfname.".tex");
                }

	exec("cd /var/www/si/modules/servidor_admin/Tex; pwd; pdflatex ".$tmpfname.".tex");
    if($fp=fopen("".$tmpfname.".pdf","r"))
	{
        while (!feof($fp)) 
	        {
                $buffer = fgets($fp, 4096);
                echo $buffer;
                }
        fclose($fp);
        //exec('/bin/rm -f '.$tmpfname.'*');
	}

}

?>

