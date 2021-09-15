<?php
include("head_resolucoes.php");

//include("funcao_escolhe_arquivo.php");

$dado=$_POST['dado'];                //vari?el que cont? as informa?es do documento
$acao=$_POST['acao'];                //vari?el que cont? a a?o de visualizar ou de salvar no rascunho

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
$data=strftime("%Y-%m-%d");

if ($acao == "Salvar Rascunho"){
	

	//verifica?o se o documento j?foi inserido anteriormente na mesma se?o
	if((!isset($_SESSION["verifica_reenvio"])) || strcmp($_SESSION["verifica_reenvio"],$valor))
		{
			$_SESSION["verifica_reenvio"]=$valor;

			if ($dado['data_reuniao']!="") $data_reuniao_ex=explode("/",$dado['data_reuniao']); else $data_reuniao_ex=array(date('d'),date('m'),date('Y'));

			$submeter="FALSE"; 
			// print_r($dado);
			// die();
			

			if ($dado['codigo']==0) $pg_linha="insert into admin_resolucoes_colegiado (codigo,data_reuniao,numero_reuniao,assunto_resolucao,texto_resolucao,submetido,data_publicacao,assinante,assinatura) values (default,'".$data_reuniao_ex[2]."-".$data_reuniao_ex[1]."-".$data_reuniao_ex[0]."','".$dado['numero_reuniao']."','".$dado['assunto_resolucao']."','".$dado['texto_resolucao']."','".$submeter."','".$data."','".$dado['assinante']."','".$dado['assinatura']."')";

			
			$query_resolucao=pg_query($pg_linha) or die("problema de conexao 3.0");

		
// AQUI, SE FORMOS PARA O VISUALIZAR VAI DAR CERTO COM LATEX!
		echo "
                	<h1>Servidor Administrativo</h1>
		<p> O documento foi inserido como <i>rascunho</i>. Para que ele possa ser impresso, clique no bot&atilde;o
				abaixo.</p><br>

			<form method='post' action='ati.php'>
			<div align='center'>";
			foreach($dado as $valor)
				{
				echo"
    				<input type='hidden' name='dado[]' value='$valor'>";
				}

    			//echo "<input type='hidden' name='com_copia' value='$com_copia'>";
			echo"
    				<input type='hidden' name='segunda' value='ok'>
				<input type='submit' name='acao' value='Visualizar'>
			</div></form>";
		}
	else
		{
		echo"
        	<h1>Servidor Administrativo</h1>
        	<p> <b><i>O documento j&aacute; foi salvo.</i></b> </p><br>";
		}
	}

///////////////////////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////atualiza?o da tabela rascunho ////////////////////////////////////////////
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////

else if($acao=="Rascunho"){   

//	$id_documentador=$_GET["id_documentador"];
	//$id_documentador=$_POST["id_documentador"];

 		$data_reuniao_ex=explode("/",$dado[0]);
		$data_reuniao = $data_reuniao_ex[2]."-".$data_reuniao_ex[1]."-".$data_reuniao_ex[0];
		$numero_reuniao = $dado[1];
		$assunto_resolucao = $dado[2];
		$texto_resolucao = $dado[3];
		$codigo = $dado[6];
		$submeter = $dado[7];
		$assinante = $dado[5];
		$assinatura = $dado[4];
		

		if ($codigo!=0) $pg_linha="update admin_resolucoes_colegiado set data_reuniao='".$data_reuniao."', numero_reuniao='".$numero_reuniao."', assunto_resolucao='".$assunto_resolucao."',texto_resolucao='".$texto_resolucao."',submetido='".$submeter."',data_publicacao='".$data."',assinante='".$assinante."',assinatura='".$assinatura."' where codigo='".$codigo."'";

		// echo $pg_linha;
		// die();
		$query_resolucao=pg_query($pg_linha) or die("problema de conexao 3.0");

	 
// AQUI, SE FORMOS PARA O VISUALIZAR VAI DAR CERTO COM LATEX!
	echo "
        <h1>Servidor Administrativo</h1>
        <p> O documento foi atualizado como <i>rascunho</i>. Para que ele possa ser impresso, clique no
        bot&atilde;o abaixo.</p><br>
                        <form method='post' action='ati.php'>
                        <div align='center'>";
				foreach($dado as $valor){
                                echo"
                                <input type='hidden' name='dado[]' value='$valor'>";
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

	 echo "
         <h1>Confirma&ccedil;&atilde;o</h1>
         <p> Clique abaixo para inserir definitivamente o documento. </p>";
	$documento=$dado[0];
	$assinante=$dado[5];
	$assinatura=$dado[4];
	require "acessorio.php";

		$nome_assinatura=$palavra_assinatura[0];
		$sobrenome_assinatura=$palavra_assinatura[1];
				
		$signature = $nome_assinatura. " ".$sobrenome_assinatura;
                                
				
				require "acessorio.php";
                                echo"
                                <p><a>Tipo de Documento: Resolu&ccedil;&atilde;o do MAT</p>
                                <p><a>Assunto da Resolu&ccedil;&atilde;o: </a>$dado[2]</p>
                                <p><a>Assinante: </a>$signature</p>";

				
echo"
                        <br>
                        <form method='post' action='operacao_2.php'>
                        <div align='center'>";

                        foreach($dado as $valor){
                                echo"
                                <input name='dado[]' type='hidden' value='$valor'>";
                                }

		
		echo"
                         <!--<input name='numero_resolucao' type='hidden' value='$id_documentador'>-->
                         <input type='button' value='Retornar' onclick='history.go(-1)'>
                         <input name='acao2' type='submit' value='Confirmar'>
                        </div></form>";

	}
////////////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////Visualiza?o do documento em pdf ///////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////////////////

else if ($acao=="Visualizar"){


//$dado[3] = addslashes(addslashes($dado[3]));

// print_r($dado);
// die();
$assinante=$dado[5];
$assinatura=$dado[4];

require "acessorio.php";

$nome_assinatura=$palavra_assinatura[0];
$sobrenome_assinatura=$palavra_assinatura[1];

$seds[LATEXDATACOLEGIADO]=$dado[0];

$seds[LATEXNUMCOLEGIADO]=$dado[1];
$seds[LATEXRESUMO]=addslashes(addslashes($dado[2]));
//$seds[LATEXTEXTORESOLUCAO]=$dado[3];
$seds[LATEXNUMERORESOLUCAO] = "XX";
//$texto_tratado = addslashes($dado[3]);
$seds[LATEXTEXTORESOLUCAO]= addslashes(addslashes($dado[3]));
// echo "Texto normal: ".$seds['LATEXTEXTORESOLUCAO']."</br>";
// echo "Texto tratado: ".$texto_tratado."</br>";

// print_r($dado);
// die();


$dia = date('d');
$mes = date('m');
$ano = date('Y');
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

$seds[LATEXDATAPUBLICACAO] = $dia." de ".$mes." de ".$ano;

$seds[LATEXANO]=date("Y");


$seds[LATEXNASSINATURA] = $palavra_assinatura[3]." ".$nome_assinatura." ".$sobrenome_assinatura;
$seds[LATEXCASSINATURA] = $palavra_assinatura[2];


$arquivo="modelo_resolucao.tex";

// #$%&?!*: latex   % \%; & \&; # \#; $ \$;  

        foreach ($seds as $colchete => $valor)
		{
			
                if ($colchete=="LATEXTEXTORESOLUCAO" || $colchete=="LATEXRESUMO"){
                	$seds[$colchete]=str_replace("\n",'',$seds[$colchete]);
                	//$seds[$colchete]=str_replace("\r",'',$seds[$colchete]);
                }
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
                $seds[$colchete]=str_replace("{",'\{',$seds[$colchete]);
                $seds[$colchete]=str_replace("}",'\}',$seds[$colchete]);
                $seds[$colchete]=str_replace("cao",'ção',$seds[$colchete]);
				$seds[$colchete]=str_replace("sem_vinculo",'sem vínculo',$seds[$colchete]);
                }
	

        $tmpfname = tempnam("/var/www/si/modules/servidor_admin/Tex", "MTRJF");
        exec("cat ./modelo_tex/".$arquivo." > ".$tmpfname.".tex");
	exec(" chmod 777 ".$tmpfname.".tex");
// 	foreach($seds as $key => $val )
//                 {
// //exec('sed \'s/'.$key.'./'.$val.'/\' '.$tmpfname.'.tex > '.$tmpfname.'.tex.tmp; mv '.$tmpfname.'.tex.tmp  '.$tmpfname.'.tex');
// 	$cmd = "sed \" s/".$key."/".$val."/\" ".$tmpfname.".tex > ".$tmpfname.".tex.tmp";	//do Guy
// 	echo $cmd."</br>";
// 	exec($cmd);										//do Guy
// 	$cmd2=" mv ".$tmpfname.".tex.tmp  ".$tmpfname.".tex";					//do Guy
// 	exec($cmd2);										//do Guy
// 	exec(" chmod 777 ".$tmpfname.".tex");
//                 }
//     die();
	Header("Content-type: application/pdf");
//	Header("Content-type: application/ps");
        foreach($seds as $key => $val )
                {
//exec('sed \'s/'.$key.'./'.$val.'/\' '.$tmpfname.'.tex > '.$tmpfname.'.tex.tmp; mv '.$tmpfname.'.tex.tmp  '.$tmpfname.'.tex');
	$cmd = "sed \" s/".$key."/".$val."/\" ".$tmpfname.".tex > ".$tmpfname.".tex.tmp";	//do Guy
	//echo $cmd."</br>";
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
<?
  pg_close($idconn);
?>
</table>
</body>
</html>
