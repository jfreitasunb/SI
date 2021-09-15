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
          <h1>Cadastro de Emprestimo</h1>Informa&ccedil;&otilde;es sobre o emprestimo
        </td>
      </tr>
      <tr>
        <td align=center>
               <title>Cadastrar Emprestimo</title>
<?php
if(!isset($_POST["enviar"]))
{
?>
<form method="POST" action="incluir_n.php"><p>
<tr>
        <td align=center>
          <table class=form>
          <tr>
            <td colspan=4 class=header align=center>
              Descria&ccedil;&atilde;o do Emprestimo :
            </td>
          </tr>
          <tr>
            <td> Livro : </td>
	    <td>
              <select size="1" name="id_livro">
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
	<input type="hidden" name="enviar" value="S">
            </td><td> Usuario :</td>
	    <td><select size="1" name="coduser">
	<?php
		// gera a lista de usuarios
		$res = pg_query("SELECT * FROM users");
		while($registro = pg_fetch_row($res))
		{
			$cod = $registro[0];
			$name = $registro [1];
			echo "<option value=\"$cod\">$cod $name</option>\n";
		}
	?>
	</select></td>
            </tr><tr>
	     <td>Data Emprestimo :</td><td><input type="text" name="date_emprunt" size="20" ></td>
             <td>Data Devoluçao:</td><td><input type="text" name="date_retour" size="20" ></td>
            <input type="hidden" name="enviar" value="S">
<?php
}
else   // inclui o emprestimo
{
	$id_livro=$_POST["id_livro"];
	$coduser=$_POST["coduser"];
	$date_emprunt=$_POST["date_emprunt"];
	$date_retour=$_POST["date_retour"];
	$res = pg_query("INSERT INTO emprestimo VALUES('$id_livro','$coduser','$date_emprunt','$date_retour')");
	if(pg_affected_rows($res)>0)
		echo "<p align='center'>Emprestimo cadastrado!</p>";
	else	{
		$erro = pg_last_error();
		echo "<p align='center'>Erro: $erro</p>";
	}
}
?>
</table><br>
<input type="submit" value="Cadastrar Emprestimo" name="incluir">
<input type=button name='rights' value='Devolver Livro' onclick="window.open('devolucao.php?idmod=<?php echo $_GET['idmod'] ?>','pop1','width=600,height=600');"></p>
</form>
</body>
</html>
