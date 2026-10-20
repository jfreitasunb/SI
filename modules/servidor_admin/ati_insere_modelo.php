<?php 

require("head_admin.php");

			$tipo_documento=$_POST['id_tipo'];
			$assunto=$_POST['assunto'];
			$anexo=$_POST['anexo'];
			$vocativo=$_POST['vocativo'];
			$mensagem=$_POST['mensagem'];
			$desfecho=$_POST['desfecho'];
			$via=$_POST['via'];
			$destino=$_POST['destino'];

			//setcookie("enviou_ex_ins",$mensagem,time() + 120 );
			$resultado1=db_query("INSERT INTO admin_modelo  (id_modelo,id_tipo,assunto,anexo,vocativo,mensagem,desfecho,via,destino,campo_8,campo_9,campo_10) VALUES(default,?,?,?,?,?,?,?,?,'','','')", array($tipo_documento, $assunto, $anexo, $vocativo, $mensagem, $desfecho, $via, $destino))
			or die ("Não foi possível inserir os dados no banco");
			?>
				<html>
				<header>
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
				<p> O documento foi inserido como modelo!</p>
				<br>
				</body></html>


