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
          <h1>Devoluçao de Livro</h1>Informa&ccedil;&otilde;es sobre o Livro
        </td>
      </tr>
      <tr>
        <td align=center>
               <title>Devolver Livro</title>
<?php
if(!isset($_POST["enviar"])) //solicita o codigo do livro
{
?>
<form method="POST" action="cada_livr.php"><p>
	<tr><td align=center>
        <table class=form>
        <tr><td colspan=4 class=header align=center>Codigo do Livro :</td></tr>
          <tr>
            <td> Codigo : </td><td><input type="text" name="codigo" size="20"></td>
            <input type="hidden" name="enviar" value="S">
<?php
}
else   // exclui o emprestimo
{
	$codigo=$_POST["codigo"];
	$res = pg_query("DELETE INTO emprestimo where id_livro='$codigo'");
		if	(pg_affected_rows($res)>0)
			echo "<p align='center'>Livro devolvido!</p>";
		else	{
			$erro = pg_last_error();
			echo "<p align='center'>Erro: $erro</p>";
			}
}
?>
</table><br>
<input type="submit" value="Devolver Livro" name="excluir"></p>
</form>
</body>
</html>
