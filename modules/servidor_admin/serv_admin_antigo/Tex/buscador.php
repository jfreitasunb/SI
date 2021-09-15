<?php
require "verifica.php";
?>


<head>
<meta http-equiv="content-type" content="text/html; charset=iso-8859-1">
<title>Servidor Administrativo</title><style type="text/css" media="all">@import "style.css";</style></head>
<body>
<div id="Header"></div>
<div id="Content">

<?php

if($_GET['variavel']=="buscar"){
	
	echo "

		<h1>Buscar Documento</h1>
		<p> Escolha abaixo o tipo de documento a ser encontrado. </p> ";
	}

else {

	echo "

		<h1>Editar Documento</h1>
		<p> Escolha abaixo o tipo de documento a ser editado. </p> ";
	}

?>

<form action='buscador_lista.php' method='post'>
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

<?php

if($_GET['variavel']=="buscar")
	echo " <input type='submit' name='busca' value='Buscar'>";
else
	echo " <input type='submit' name='busca' value='Editar'>";

?>
</div>
<?php require "menu.php"; ?>
</body></html>
