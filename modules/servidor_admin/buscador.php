<?php require("head_admin.php"); ?>
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
	if($_GET['variavel']=="buscar")
		{
	echo " 	<h1>Buscar Documento</h1>
		<p> Escolha abaixo o tipo de documento a ser encontrado. </p> ";
		}
	else
		{
	echo "	<h1>Editar Rascunho</h1>
		<p> Escolha abaixo o tipo de documento a ser editado. </p> ";
		}
?>

<form action='buscador_lista.php' method='post'>
<table><br>
        <tr><td><select name= 'id_tipo' size = '1'>
		<?php
                $res=pg_query("SELECT id_tipo,nometipo FROM admin_tipo") or die ("N? foi poss?el consultar o banco.");
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

