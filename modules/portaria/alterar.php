<?php
  include("head_account.php");
?>
<html>
<header>
    <script language=javascript src="function_js.js">
    </script>
    <script language=javascript src="formu.js">
    </script>
    <link type="text/css" rel="stylesheet" href="../../global/grafic.css">
  </header>
<body>
<table class=big>
      <tr>
        <td class=header align=center>
          <h1>Consulta a livros</h1>Informa&ccedil;&otilde;es sobre o livro
        </td>
      </tr>
      <tr>
        <td align=center>
               <title>Consultar Livro</title>
<?php
if(!isset($_POST["codigo"]))	// solicita o código
{
?>
	<form method="POST" action="alterar.php">
		<tr><td align=center>
          <table class=form>
          <tr><td colspan=4 class=header align=center>Codigo do livro :   </td></tr>
          <tr><td> Codigo do livro: </td>
          <td>

	  <select size="1" name="codigo">
	<?php
		// gera a lista de livros
		$res = pg_query("SELECT * FROM livros");
		while($registro = pg_fetch_row($res))
		{
			$cod = $registro[0];
			$titulo = $registro[1];
			echo "<option value=\"$cod\">$cod $titulo</option>\n";
		}
	?>
	</select>
	
	  </td>
  	  <td><input type="submit" value="Consultar livro" name="alterar"></td>
	</form>
<?php
}
elseif(!isset($_POST["enviar"]))		// busca os dados do livro
{
 $codigo=$_POST["codigo"];
	$sql = "SELECT * FROM livros WHERE id_livro='$codigo'";
	$res = pg_query($sql);
	if(pg_num_rows($res)==0)
		echo "Livro não encontrado!";
	else
	{
		$registro=pg_fetch_row($res);
		$titulo=$registro[1];
		$autor=$registro[2];
		$tema=$registro[3];
?>
	<form method="POST" action="alterar.php">
		<tr><td align=center>
          		<table class=form>
                                <tr><td colspan=4 class=header align=center>Dados do livro :</td></tr>
          			<tr><td><p>Codigo: <b><?php echo $codigo; ?></b></td>
            			<tr><td> titulo :</td>
            			<td><input type="text" name="titulo" value="<?php echo $titulo;?>"> </td></tr>
           			<tr> <td>autor :</td>
             			<td><input type="text" name="autor" size="20" value="<?php echo $autor;?>">
             			</td>
             			<tr><td> tema :</td>
            			<td><input type="text" name="tema" value="<?php echo $tema;?>"> </td></tr>
    				<input type="hidden" name="codigo" value="<?php echo $codigo;?>">
		  		<input type="hidden" name="enviar" value="S">
        	  	</table>
				<br><input type="submit" value="Alterar Dados" name="alterar">

	</form>
<?php
	}
}
else   // alterar o livro
{
	$codigo=$_POST["codigo"];
	$titulo=$_POST["titulo"];
	$autor=$_POST["autor"];
	$tema=$_POST["tema"];
 		$sql = "UPDATE livros SET titulo='$titulo',autor='$autor',tema='$tema' WHERE id_livro='$codigo'";
		$res = pg_query($sql);
			if(pg_affected_rows($res)>0)
				echo "<p align='center'>livro alterado com sucesso!</p>";
			else
				{
				$erro = pg_last_error();
				echo "<p align='center'>Erro: $erro</p>";
				}
}
?>
</table>
<br><input type=button name='rights' value='Cadastrar Livro' onclick="window.open('cada_livr.php?idmod=<?php echo $_GET['idmod'] ?>','pop1','width=600,height=600');">
</body>
</html>
