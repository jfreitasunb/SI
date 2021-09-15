<?php

require "verifica.php";

?>



<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml"><head>
<meta http-equiv="content-type" content="text/html; charset=iso-8859-1">
<title>Servidor Administrativo</title><style type="text/css" media="all">@import "style.css";</style></head>



<body>
<div id="Header"></div>
<div id="Content">
	<h1>Buscar Documento</h1>
<p> Escolha abaixo o tipo de documento a ser encontrado. </p>

<form action='buscar.php' method='post'>
<table><br>
        <tr><td><select name= 'id_tipo' size = '1'>
		<?php
                require "conexao.php";
                $res=pg_query("SELECT id_tipo,nometipo FROM tipos") or die ("Não foi possível consultar o banco.");
                while($registro=pg_fetch_row($res,$i))
                	{
                        $cod=$registro[0];
                        $nome=$registro[1];
                        echo"<option value=$cod>$nome</option>\n";
                	}
        	?>
                        
        </select></td></tr>
</table><br>
<input type='submit' value='Buscar'>
</div>

<div id="Menu">
	<a><i>Menu</i> Documentos</a><br>
        <a href="exercicio_insere.php">Gerar</a><br>
        <a href="exercicio_edita.php">Editar</a><br>
        <a href="exercicio_edita_lista.php">Buscar</a><br>
        <a href="sair.php">Sair</a><br>

</div>
</body></html>
