<?php include("head_account.php"); ?>
<?php
$acao = $_POST ['acao'];


if ($acao){
	if ( !$assunto || !$vocativo || !$mensagem || !$desfecho )
		{

		echo "
		<head>
		<meta http-equiv='content-type' content='text/html; charset=iso-8859-1'>
		<title>Servidor Administrativo</title><style type='text/css' media='all'>@import 'style.css';</style></head>
		<body>
		<div id='Header'></div>
		<div id='Content'>
        		<h1>Atenção!</h1>
			<p> É necessário preencher todos os campos, exceto o campo <b>Anexo(s)</b>. Clique no <i>link</i>
			abaixo para retornar. </p>
			<p><a href='javascript:history.back();'> Retornar</a></p>";
		}
	else if ($acao=="Visualizar")
		{
		require "html2pdf.php";
                require "complementa.php";

                $pdf =& new createPDF(
                        $row[0],
                        "XX",
                        $row1[0],
                        $assunto,
                        $anexo,
                        $vocativo,
                        $mensagem,
                        $desfecho,
                        $data,
                        $row2[0],
                        $row2[1]
                	);
                $pdf->run();
		}
	else
		{
		$data=strftime("%d/%m/%Y");
		require "complementa.php";

		if($acao=="Rascunho")
			{
			if((!isset($_SESSION["verifica_rascunho"])) || strcmp($_SESSION["verifica_rascunho"],$_POST["mensagem"])){
			$_SESSION["verifica_rascunho"]=$mensagem;
			//setcookie("ins_rascunho","1",time() + 120);
			 $resultado1=pg_query("UPDATE rascunho SET id_tipo='$id_tipo',id_departamentos='$id_departamentos',
			id_assinaturas='$assinatura',vocativo='$vocativo',mensagem='$mensagem',desfecho='$desfecho',
                	assunto='$assunto',anexo='$anexo',data='$data' WHERE id_documentador='$id_documentador'")
                	or die ("Não foi possível inserir os dados no banco");

                	echo "
			<head>
               		 <meta http-equiv='content-type' content='text/html; charset=iso-8859-1'>
                <title>Servidor Administrativo</title><style type='text/css' media='all'>@import 'style.css';</style></head>
                <body> 
                <div id='Header'></div>

                        <div id='Content'>
                                <h1>Servidor Administrativo</h1>
                                <p> O documento foi atualizado como <i>rascunho</i>. Para que ele possa ser impresso, clique no 
                                botão abaixo.</p><br>
                         
                        <form method='post' action='operacaopdf.php'>
                        <div align='center'>
                                <input name='id_tipo' type='hidden' value='$id_tipo'>
                                <input name='id_departamentos' type='hidden' value='$id_departamentos'>
                                <input name='assunto' type='hidden' value='$assunto'>
                                <input name='anexo' type='hidden' value='$anexo'>
                                <input name='vocativo' type='hidden' value='$vocativo'>
                                <input name='mensagem' type='hidden' value='$mensagem'>
                                <input name='desfecho' type='hidden' value='$desfecho'>
                                <input name='assinatura' type='hidden' value='$assinatura'>
                                <input name='data' type='hidden' value='$data'>
                                <input type='submit' name='Submit' value='Visualizar para Impressão'>
                        </div></form>";
			}else {
				echo"
				<head>
                		<meta http-equiv='content-type' content='text/html; charset=iso-8859-1'>
                <title>Servidor Administrativo</title><style type='text/css' media='all'>@import 'style.css';</style></head>
                <body> 
                <div id='Header'></div>
		<div id='Content'>
                                <h1>Servidor Administrativo</h1>
                                <p> <b><i>O documento já foi atualizado.</i></b>
                                </p><br>";
				require "menu.php";}}


		else
			{ 
			echo "
			<head>
                                <meta http-equiv='content-type' content='text/html; charset=iso-8859-1'>
                <title>Servidor Administrativo</title><style type='text/css' media='all'>@import 'style.css';</style></head>
                <body> 
                <div id='Header'></div>

			<div id='Content'>
        		<h1>Confirmação</h1>
			<p> Clique abaixo para inserir definitivamente o documento. </p>
      			<p><a>Tipo de Documento: </a>$row[1]</p>
      			<p><a>Destino: </a>$row1[0]</p>
      			<p><a>Assunto: </a>$assunto</p>	
      			<p><a>Anexo(s): </a>$anexo</p>
      			<p><a>Vocativo: </a>$vocativo</p>
      			<p><a>Mensagem: </a>$mensagem</p>
      			<p><a>Desfecho: </a>$desfecho</p>
      			<p><a>Assinatura: </a>$row2[0]</p>
  			<br>
			<form method='post' action='operacao_2.php'>
  			<div align='center'>
    				<input name='id_tipo' type='hidden' value='$id_tipo'>
    				<input name='id_departamentos' type='hidden' value='$id_departamentos'>
    				<input name='assunto' type='hidden' value='$assunto'>
    				<input name='anexo' type='hidden' value='$anexo'>
    				<input name='vocativo' type='hidden' value='$vocativo'>
    				<input name='mensagem' type='hidden' value='$mensagem'>
    				<input name='desfecho' type='hidden' value='$desfecho'>
    				<input name='assinatura' type='hidden' value='$assinatura'>
    				<input name='data' type='hidden' value='$data'>
    				<input name='r_documento' type='hidden' value='$id_documentador'>
				<input type='button' value='Retornar' onclick='history.go(-1)'>
    				<input name='acao2' type='submit' value='Confirmar'>
			</div></form>";
			}
                require "menu.php";
                echo"</body></html> ";

		}		
	}
?>
