<?php
 ($acao == "Salvar Rascunho"){
	//verificação se o documento já foi inserido anteriormente na mesma seção
	if((!isset($_SESSION["verifica_reenvio"])) || strcmp($_SESSION["verifica_reenvio"],$valor)){
		$_SESSION["verifica_reenvio"]=$valor;
		if(($dado[0]=="1"))	//memorando
			$resultado1=pg_query("INSERT INTO admin_rascunho (id_documentador,id_tipo,id_departamento,vocativo,
			mensagem,desfecho,id_assinatura,assunto,anexo,data,via) VALUES (default,'$dado[0]','$dado[2]',
			'$dado[5]','$dado[6]','$dado[7]','$dado[8]','$dado[3]','$dado[4]','$data','$dado[1]')")
			or die ("Não foi possível inserir os dados no banco");

		else if ($dado[0]=="2")	//circular
			$resultado1=pg_query("INSERT INTO admin_rascunho (id_documentador,id_tipo,id_assinatura,anexo,
                        assunto,vocativo,mensagem,desfecho,data) VALUES (default,'$dado[0]','$dado[1]','$dado[2]',
                        '$dado[3]','$dado[4]','$dado[5]','$dado[6]','$data')")
                        or die ("Não foi possível inserir os dados no banco");

		else if(($dado[0]=="3")|| ($dado[0]=="6"))     //ofício interno ou ofício externo
                        $resultado1=pg_query("INSERT INTO admin_rascunho (id_documentador,id_tipo,desfecho,assunto,anexo,
                        vocativo,mensagem,id_assinatura,data,via) VALUES (default,'$dado[0]','$dado[2]','$dado[3]',
                        '$dado[4]','$dado[5]','$dado[6]','$dado[7]','$data','$dado[1]')")
                        or die ("Não foi possível inserir os dados no banco");

		else if ($dado[0]=="4")	//ato
			$resultado1=pg_query("INSERT INTO admin_rascunho (id_documentador,id_tipo,mensagem,
                        id_assinatura,data) VALUES (default,'$dado[0]','$dado[1]','$dado[2]',
                        '$data')")
                        or die ("Não foi possível inserir os dados no banco");

		else if ($dado[0]=="5")	//ata
			$resultado1=pg_query("INSERT INTO admin_rascunho (id_documentador,id_tipo,mensagem,
                        data) VALUES (default,'$dado[0]','$dado[1]',
                        '$data')")
                        or die ("Não foi possível inserir os dados no banco");


		require "cabecalho.html";
		echo "<h1>Servidor Administrativo</h1>
		     <p> O documento foi inserido como <i>rascunho</i>. Para que ele possa ser impresso, clique no botão
			abaixo.</p><br>
            		<form method='post' action='ati.php'>
			<div align='center'>";
			foreach($dado as $valor){
				echo"<input name='dado[]' type='hidden' value='$valor'>";
				}
			echo"<input type='hidden' name='segunda' value='ok'>
			     <input type='submit' name='acao' value='Visualizar'>
			</div></form>";
			require "menu.php";
		}
	else
		{
		require "cabecalho.html";
		echo"
        	<h1>Servidor Administrativo</h1>
        	<p> <b><i>O documento já foi salvo.</i></b> </p><br>";
		require "menu.php";
		}
	}

//atualização da tabela rascunho
else if($acao=="Rascunho"){

	$id_documentador=$_GET["id_documentador"];
		if($dado[0]=="1") //memorando
			$resultado1=pg_query("UPDATE admin_rascunho id_departamento='$dado[2]',assunto='$dado[3]',anexo='$dado[4]',vocativo='$dado[5]',mensagem='$dado[6]',desfecho='$dado[7]',id_assinatura='$dado[8]',via='$dado[1]',
                        data='$data' WHERE id_documentador='$id_documentador'")
                        or die ("Não foi possível inserir os dados no banco");

		else if(($dado[0]=="3")||($dado[0]=="6")) //ofício interno e ofício externo
                	$resultado1=pg_query("UPDATE admin_rascunho SET desfecho='$dado[2]',assunto='$dado[3]',anexo='$dado[4]',
                        vocativo='$dado[5]',mensagem='$dado[6]',id_assinatura='$dado[7]',via='$dado[1]',
                        data='$data' WHERE id_documentador='$id_documentador'")
                        or die ("Não foi possível inserir os dados no banco");
		else if($dado[0]=="2") //circular
                	$resultado1=pg_query("UPDATE admin_rascunho SET 				id_assinatura='$dado[1]',anexo='$dado[2]',assunto='$dado[3]',
                        vocativo='$dado[4]',mensagem='$dado[5]',desfecho='$dado[6]',
                        data='$data' WHERE id_documentador='$id_documentador'")
                        or die ("Não foi possível inserir os dados no banco");

		else if($dado[0]=="4") //ato
                	$resultado1=pg_query("UPDATE admin_rascunho SET mensagem='$dado[1]',id_assinatura='$dado[2]',
                        data='$data' WHERE id_documentador='$id_documentador'")
                        or die ("Não foi possível inserir os dados no banco");

	 	else if($dado[0]=="5") //ata
                	$resultado1=pg_query("UPDATE admin_rascunho SET mensagem='$dado[1]',
                        data='$data' WHERE id_documentador='$id_documentador'")
                        or die ("Não foi possível inserir os dados no banco");

	require "cabecalho.html";
	echo "
        <h1>Servidor Administrativo</h1>
        <p> O documento foi atualizado como <i>rascunho</i>. Para que ele possa ser impresso, clique no
        botão abaixo.</p><br>
                        <form method='post' action='ati.php'>
                        <div align='center'>";
				foreach($dado as $valor){
                                echo"<input name='dado[]' type='hidden' value='$valor'>";
                                }
                        	echo"<input type='hidden' name='segunda' value='ok'>
                             	     <input type='submit' name='acao' value='Visualizar'>
                        </div></form>";
                        require "menu.php";

	}


//inserção na tabela definitivo
else if($acao=="Definitivo"){

	$id_documentador=$_GET["id_documentador"];
	//require "acessorio.php";
	require "cabecalho.html";
	 echo "
         <h1>Confirmação</h1>
         <p> Clique abaixo para inserir definitivamente o documento. </p>";
	$documento=$dado[0];
		if($dado[0]=="1"){//memorando
				$assinatura=$dado[8];
				$destino=$dado[2];
				require "acessorio.php";
				echo"
                        	<p><a>Tipo de Documento: </a>$palavra_documento[1]</p>
				<p><a>Via: </a>$dado[1]</p>
                        	<p><a>Destino: </a>$palavra_destino[0]</p>
                        	<p><a>Assunto: </a>$dado[3]</p>
                        	<p><a>Anexo(s): </a>$dado[4]</p>
                        	<p><a>Vocativo: </a>$dado[5]</p>
                        	<p><a>Mensagem: </a>$dado[6]</p>
                        	<p><a>Desfecho: </a>$dado[7]</p>
                        	<p><a>Assinatura: </a>$palavra_assinatura[0]</p>";
				}
			else if(($dado[0]=="3")||($dado[0]=="6")){//ofício interno ou ofício externo
				$assinatura=$dado[7];
				require "acessorio.php";
				echo"
				<p><a>Tipo de Documento: </a>$palavra_documento[1]</p>
                                <p><a>Via: </a>$dado[1]</p>
                                <p><a>Destino: </a>$dado[2]</p>
                                <p><a>Assunto: </a>$dado[3]</p>
                                <p><a>Anexo(s): </a>$dado[4]</p>
                                <p><a>Vocativo: </a>$dado[5]</p>
                                <p><a>Mensagem: </a>$dado[6]</p>
                                <p><a>Assinatura: </a>$palavra_assinatura[0]</p>";
				}
			else if($dado[0]=="2"){//circular
				$assinatura=$dado[4];
				require "acessorio.php";
                                echo"
                                <p><a>Tipo de Documento: </a>$palavra_documento[1]</p>
                                <p><a>Remetente: </a>$palavra_assinatura[0]</p>
                                <p><a>Destinatário: </a>$dado[2]</p>
                                <p><a>Assunto: </a>$dado[3]</p>
                                <p><a>Vocativo: </a>$dado[4]</p>
				<p><a>Mensagem: </a>$dado[5]</p>
                                <p><a>Desfecho: </a>$dado[6]</p>";
				}
			else if($dado[0]=="4"){//ato
				$assinatura=$dado[2];
				require "acessorio.php";
                                echo"
                                <p><a>Tipo de Documento: </a>$palavra_documento[1]</p>
                                <p><a>Mensagem: </a>$dado[1]</p>
				<p><a>Assinatura: </a>$palavra_assinatura[0]</p>";
				}
			 else if($dado[0]=="5"){//ata
				require "acessorio.php";
                                echo"
                                <p><a>Tipo de Documento: </a>$palavra_documento[1]</p>
                                <p><a>Descrição da ata: </a>$dado[1]</p>";
				}

		echo"
                        <br>
                        <form method='post' action='operacao_2.php'>
                        <div align='center'>";
				foreach($dado as $valor){
                                echo"
                                <input name='dado[]' type='hidden' value='$valor'>";
                                }
		echo"
                         <input name='r_documento' type='hidden' value='$id_documentador'>
                         <input type='button' value='Retornar' onclick='history.go(-1)'>
                         <input name='acao2' type='submit' value='Confirmar'>
                        </div></form>";
                require "menu.php";

	}
	?>