<html>
<meta http-equiv="content-type" content="text/html;charset=utf-8" />
<head>
	<title> Agenda Telefônica </title>
</head>
<h1 align="center"><font color="blue">Agenda Telefônica Na Internet </font> </h1> 
<?php 
//require_once('funcoes-bancodedados.php'); 
require("../muda_senha/pgsql.php");
	if (isset($_POST['enviar']) )
		{
			$nome = $_POST['nome'];
			$telefone = $_POST['telefone'];
			conexao();
			$sql_inserir = "INSERT INTO turma_a (nome,telefone) VALUES ('$nome','$telefone')";
			if (inserir($sql_inserir))
				{ 	echo "<br> Entrada de número: ".mysql_insert_id()." feita com sucesso.";
					unset ($_POST['enviar']);
				}
			else
				{ echo "Erro na tentativa de inserir o dado no banco: ".mysql_error();}
		}


?>

<form method="POST" enctype="multipart/form-data" action ="">
	<table> 
	<tr> <td> Nome: </td> 		<td> <input type="text" name="nome"/> </td> </tr>
	<tr> <td> Telefone: </td> 	<td> <input type="text" name="telefone"/> </td> </tr>
	<tr align="center"> <td colspan="2" > <input type="submit" name = "enviar" value = "cadastrar"/> <td> </tr>
	</table>
</form>

</html>
<?php
pg_close($con);
?>