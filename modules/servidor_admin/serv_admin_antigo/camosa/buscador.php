<?php
require "verifica.php";
require "cabecalho.html";

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
                $res=pg_query("SELECT id_tipo,nometipo FROM admin_tipo") or die ("Não foi possível consultar o banco.");
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
