<?php
require "verifica.php";


$dado=$_POST["dado"]; //variável que contém as informações do documento
$acao=$_POST["acao"]; //variável que contém a ação de visualizar ou de salvar no rascunho


//tratamento para verificação de preenchimento dos campos, a exceção do campo 'anexo' para memorando e ofício
//setagem da chave 'valor' para validação de postagem no banco
/*
if(!isset($_POST["segunda"])){
	$valor="";
	$tratamento="no";
	if(($dado[0]=="1") || ($dado[0]=="3"))
                if(!$dado[5]){
                        $dado[5]="preencheu";
			$tratamento="ok";
			}

	foreach($dado as $preenchido){
		if(!$preenchido){
			require "cabecalho.html";
			echo "
        			<h1>Atenção!</h1>
				<p> É necessário preencher todos os campos em (*). Clique no <i>link</i> abaixo para retornar. </p>
				<p><a href='javascript:history.back(-1);'> Retornar</a></p><br>";
			require "menu.php";
			exit;
			}
		else if ($_POST["origem"]=="gerar") //se a origem veio dos documentos 'gerar'
			if(strlen($preenchido) > strlen($valor)) 
				$valor=$preenchido;
		}
	if($tratamento=="ok")
		$dado[5]="";

	}
*/
//seleção da ação a partir do valor 'ação'
require "conexao.php";
$data=$dado[1];;	 

//inserção na tabela definitivo
if($acao=="Definitivo"){

	$documento=$dado[0];
	//require "acessorio.php";
	require "cabecalho.html"; 
	echo "
                        <h1>Confirmação</h1>
                        <p> Clique abaixo para inserir definitivamente o documento. </p>";

			if($dado[0]=="1"){//memorando
				$assinatura=$dado[9];
				$destino=$dado[3];
				require "acessorio.php";
				echo"
                        	<p><a>Tipo de Documento: </a>$palavra_documento[1]</p>
				<p><a>Via: </a>$dado[2]</p>
				<p><a>Data: </a>$data</p>
                        	<p><a>Destino: </a>$palavra_destino[0]</p>
                        	<p><a>Assunto: </a>$dado[4]</p> 
                        	<p><a>Anexo(s): </a>$dado[5]</p>
                        	<p><a>Vocativo: </a>$dado[6]</p>
                        	<p><a>Mensagem: </a>$dado[7]</p>
                        	<p><a>Desfecho: </a>$dado[8]</p>
                        	<p><a>Assinatura: </a>$palavra_assinatura[0]</p>";
				}
			else if(($dado[0]=="3")||($dado[0]=="6")){//ofício interno ou externo
				$assinatura=$dado[8];
				require "acessorio.php";
				echo"
				<p><a>Tipo de Documento: </a>$palavra_documento[1]</p>
                                <p><a>Via: </a>$dado[2]</p> 
				<p><a>Data: </a>$data</p>
                                <p><a>Destino: </a>$dado[3]</p>
                                <p><a>Assunto: </a>$dado[4]</p> 
                                <p><a>Anexo(s): </a>$dado[5]</p>
                                <p><a>Vocativo: </a>$dado[6]</p>
                                <p><a>Mensagem: </a>$dado[7]</p>
                                <p><a>Assinatura: </a>$palavra_assinatura[0]</p>";
				}
			else if($dado[0]=="2"){//circular
				$assinatura=$dado[2];
				require "acessorio.php"; 
                                echo"
                                <p><a>Tipo de Documento: </a>$palavra_documento[1]</p>
				<p><a>Data: </a>$data</p>
                                <p><a>Remetente: </a>$palavra_assinatura[0]</p>
                                <p><a>Destinatário: </a>$dado[3]</p> 
                                <p><a>Assunto: </a>$dado[4]</p>
                                <p><a>Vocativo: </a>$dado[5]</p>
				<p><a>Mensagem: </a>$dado[6]</p>
                                <p><a>Desfecho: </a>$dado[7]</p>";
				}
			else if($dado[0]=="4"){//ato
				$assinatura=$dado[3];
				require "acessorio.php"; 
                                echo" 
                                <p><a>Tipo de Documento: </a>$palavra_documento[1]</p>
				<p><a>Data: </a>$data</p>
                                <p><a>Mensagem: </a>$dado[2]</p>
				<p><a>Assinatura: </a>$palavra_assinatura[0]</p>"; 
				}
			 else if($dado[0]=="5"){//ata
				require "acessorio.php"; 
                                echo"  
                                <p><a>Tipo de Documento: </a>$palavra_documento[1]</p>
				<p><a>Data: </a>$data</p>
                                <p><a>Descrição da ata: </a>$dado[2]</p>";
				}

		echo"
                        <br>
                        <form method='post' action='ati_antigo.php'>
                        <div align='center'>";
				foreach($dado as $valor){
                                echo" 
                                <input name='dado[]' type='hidden' value='$valor'>";
                                }
		echo"
                         <input type='button' value='Retornar' onclick='history.go(-1)'>
                         <input name='acao' type='submit' value='Confirmar'>
                        </div></form>";
                require "menu.php";

	}
//visualização do documento em pdf
else if ($acao=="Visualizar"){


	exec('/bin/rm -f /tmp/oliveira/ABAB*');
	//require "acessorio.php";

	$documento=$dado[0];	
	$seds[LATEXNUMERO]="XX";
	$seds[LATEXDATA]=$data; 
	
	if (($dado[0]=="1") ) //memorando
        	{
		$assinatura=$dado[9]; 
                $destino=$dado[3]; 
                require "acessorio.php"; 
		$seds[LATEXDATA]=$data;
        	$seds[LATEXDESTINO]=$palavra_destino[0];
		$seds[LATEXVIA]=$dado[2];
        	$seds[LATEXASSUNTO]=$dado[4];
        	$seds[LATEXANEXO]=$dado[5];
        	$seds[LATEXVOCATIVO]=$dado[6];
        	$seds[LATEXMENSAGEM]=$dado[7];
        	$seds[LATEXDESFECHO]=$dado[8];
        	$seds[LATEXNASSINATURA]=$palavra_assinatura[0];
        	$seds[LATEXCASSINATURA]=$palavra_assinatura[1];
        	$arquivo="modelo_memorando.tex";
        	}
	else if (($dado[0]=="3") ||($dado[0]=="6")) //oficio interno ou externo
        	{
		$assinatura=$dado[8];
                require "acessorio.php";
		$seds[LATEXDATA]=$data;
		$seds[LATEXVIA]=$dado[2];
        	$seds[LATEXDESTINO]=$dado[3];
        	$seds[LATEXASSUNTO]=$dado[4];
        	$seds[LATEXANEXO]=$dado[5];
        	$seds[LATEXVOCATIVO]=$dado[6];
        	$seds[LATEXMENSAGEM]=$dado[7];
        	$seds[LATEXNASSINATURA]=$palavra_assinatura[0];
        	$seds[LATEXCASSINATURA]=$palavra_assinatura[1];
        	$arquivo="modelo_oficio.tex";
		if($dado[0]=="3")
			$seds[LATEXSIGLA]="OE";
		else
			$seds[LATEXSIGLA]="OI";
        	}
        else if($dado[0]=="2") //circular
        	{
		 $assinatura=$dado[2];
                 require "acessorio.php";
        	$seds[LATEXDATA]=$data;
		$seds[LATEXASSUNTO]=$dado[4];
		$seds[LATEXANEXO]=$dado[3];
        	$seds[LATEXVOCATIVO]=$dado[5];
        	$seds[LATEXMENSAGEM]=$dado[6];
		$seds[LATEXDESFECHO]=$dado[7];
        	$seds[LATEXNASSINATURA]=$palavra_assinatura[0];
		$seds[LATEXCASSINATURA]=$palavra_assinatura[1];
        	$arquivo="modelo_circular.tex";
        	}
	else if($dado[0]=="4") //ato
        	{
		$assinatura=$dado[3];
                require "acessorio.php";
		$seds[LATEXMENSAGEM]=$dado[2];
        	$seds[LATEXNASSINATURA]=$palavra_assinatura[0];
		$seds[LATEXCASSINATURA]=$palavra_assinatura[1];
        	$arquivo="modelo_ato.tex";
        	}
        else if ($dado[0]=="5") //ata
        	{
        	$seds[LATEXMENSAGEM]=$dado[2];
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


	$tmpfname = tempnam("/tmp/oliveira", "ABAB");
	exec("cat /usr/local/miolo/html/camosa/modelo_tex/".$arquivo." > ".$tmpfname.".tex");

	Header("Content-type: application/pdf");

	foreach($seds as $key => $val )
		{
exec('sed \'s/'.$key.'./'.$val.'/\' '.$tmpfname.'.tex > '.$tmpfname.'.tex.tmp; mv '.$tmpfname.'.tex.tmp  '.$tmpfname.'.tex');
		}

/*
exec('cd /tmp/oliveira/ ; ./conversor2 '.$tmpfname.'.tex > '.$tmpfname.'.tex.mod ; mv '.$tmpfname.'.tex.mod '.$tmpfname.'.tex;
	/usr/local/bin/pdflatex -interaction nonstopmode '.$tmpfname.'.tex');
*/

exec('cd /tmp/oliveira/ ;/usr/local/bin/pdflatex -interaction nonstopmode '.$tmpfname.'.tex');

	$fp=fopen("".$tmpfname.".pdf","r");
 	while (!feof($fp)) {
   		$buffer = fgets($fp, 4096);
 		echo $buffer;
 		}
	fclose($fp);
	exec('/bin/rm -f '.$tmpfname.'*');

}

else if($acao=="Confirmar"){

	$data=$dado[1];
	//preparação para a verificação de reenvio de mesmo documento
        if(($dado[0]=="1") || ($dado[0]=="3"))
                $mensagem=$dado[7];
        else if(($dado[0]=="2"))
                $mensagem=$dado[6];
        else if(($dado[0]=="4"))
                $mensagem=$dado[2];
        else if(($dado[0]=="5"))
                $mensagem=$dado[2];

        if((!isset($_SESSION["verifica_definitivo"])) || strcmp($_SESSION["verifica_definitivo"],$_POST["mensagem"])){
                $_SESSION["verifica_definitivo"]=$mensagem;
                //$data=strftime("%d/%m/%Y");

                //contador para definição do número do documento.
                $resultado=pg_query("SELECT antigo FROM admin_tipo WHERE id_tipo='$dado[0]'")
                or die ("N\xe3o foi poss\xedvel realizar a consulta ao banco de dados");
                $contador0=pg_fetch_row($resultado);
		$contador=$contador0[0]+1;

		//verificacao para ver se documentos antigos ainda podem ser inseridos
		$ver1=pg_query("SELECT parametro FROM admin_tipo WHERE id_tipo='$dado[0]'")
                or die ("N\xe3o foi poss\xedvel realizar a consulta ao banco de dados");
                $ver2=pg_fetch_row($ver1);

		//comparacao entre a variavel contador (antigo) e a variavel ver2[0] (parametro). Se iguais, sair
		if($contador==$ver2[0])
			{
			require "cabecalho.html";
                	echo"   
                	<h1>Servidor Administrativo</h1>
                	<p> Este não é um documento antigo válido. O número do documento já existe . </p><br>";
                	require "menu.php";
			}
		else{

                //acréscimo do documento na tabela "documentador".
                if($dado[0]=="1")//memorando
                        $resultado_banco=pg_query("INSERT INTO admin_documentador (id_documentador,id_tipo,numerodocumento,
                        id_departamento,vocativo,mensagem,desfecho,id_assinatura,assunto,anexo,data,via) 
                        VALUES (default,'$dado[0]','$contador','$dado[3]','$dado[6]','$dado[7]','$dado[8]','$dado[9]',
                        '$dado[4]','$dado[5]','$data','$dado[2]')")
                        or die("N\xe3o foi poss\xedvel inserir os dados.");
                else if(($dado[0]=="3")||($dado[0]=="6"))//ofício interno ou ofício externo
                        $resultado_banco=pg_query("INSERT INTO admin_documentador (id_documentador,id_tipo,numerodocumento,
                        vocativo,mensagem,desfecho,id_assinatura,assunto,anexo,data,via)
                        VALUES (default,'$dado[0]','$contador','$dado[6]','$dado[7]','$dado[3]','$dado[8]','$dado[4]',
                        '$dado[5]','$data','$dado[2]')")
                        or die("N\xe3o foi poss\xedvel inserir os dados.");
                else if($dado[0]=="2")//circular
                        $resultado_banco=pg_query("INSERT INTO admin_documentador (id_documentador,id_tipo,numerodocumento,
			 vocativo,mensagem,desfecho,id_assinatura,assunto,anexo,data)
                        VALUES (default,'$dado[0]','$contador','$dado[5]','$dado[6]','$dado[7]','$dado[2]','$dado[4]',
                        '$dado[3]','$data')")
                        or die("N\xe3o foi poss\xedvel inserir os dados.");
                else if($dado[0]=="4")//ato
                        $resultado_banco=pg_query("INSERT INTO admin_documentador (id_documentador,id_tipo,numerodocumento,
                        mensagem,id_assinatura,data)
                        VALUES (default,'$dado[0]','$contador','$dado[2]','$dado[3]','$data')")
                        or die("N\xe3o foi poss\xedvel inserir os dados.");
                else if($dado[0]=="5")//ata
                        $resultado_banco=pg_query("INSERT INTO admin_documentador (id_documentador,id_tipo,numerodocumento,
                        mensagem,data)
                        VALUES (default,'$dado[0]','$contador','$dado[2]','$data')")
                        or die("N\xe3o foi poss\xedvel inserir os dados.");


		//atualizacao do numero do documento na tabela admin_tipo
		$result=pg_query("UPDATE admin_tipo SET antigo='$contador' WHERE id_tipo='$dado[0]'")
                or die ("N\xe3o foi poss\xedvel atualizar o banco de dados"); 


		//armazanamento do "id_documentador" que acabou de ser inserido na variável "id_documentador".
                $sultado2=pg_query("SELECT id_documentador FROM admin_documentador WHERE numerodocumento = '$contador' 
                and id_tipo = '$dado[0]'")
                or die("Não foi possível executar a operação. Contacte a Coordenação de Informática.");
                $luna = pg_fetch_row($sultado2,$i);
                $id_documentador = $luna[0];


                require "cabecalho.html";
		echo"   
                <h1>Servidor Administrativo</h1>
                <p> O documento foi inserido com sucesso. Para que ele possa ser impresso, clique no botão abaixo . </p><br>
		
			<form method='post' action='operacao_2.php'>
                <div align='center'>
                        <input name='id_documentador' type='hidden' value='$id_documentador'>
                        <input type='submit' name='acao2' value='Visualizar'>
                </div></form>";
                require "menu.php";
                }}
        else  {
                require "cabecalho.html";
		echo "
                <h1>Servidor Administrativo</h1>
                <p> <b><i>O documento já foi salvo.</i></b> </p><br>";
                require "menu.php";
                }
        }


?>
