<?php include("head_account.php"); ?>
<?php
	if ($acao == "Modelo")
		{
			//setcookie("enviou_ex_ins",$mensagem,time() + 120 );
			$resultado1=pg_query("INSERT INTO modelo (id_modelo,campo_1,campo_2,campo_3,campo_4,
			campo_5,campo_6) VALUES (default,'$tipo_documento','$assunto','$anexo',
			'$vocativo','$mensagem','$desfecho')")
			or die ("Não foi possível inserir os dados no banco");

			echo "
			<head>
                	<meta http-equiv='content-type' content='text/html; charset=iso-8859-1'>
                	<title>Servidor Administrativo</title><style type='text/css' media='all'>@import 'style.css';</style>
                	</head>
                	<body>
                	<div id='Header'></div>
                	<div id='Content'>
                	<h1>Servidor Administrativo</h1>
				<p> O documento foi inserido no modelo!</p>
				<br>

			</body></html> ";}
?>
