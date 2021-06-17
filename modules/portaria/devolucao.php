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
          <h1>Devolu&ccedil;&atilde;o de Livro</h1>Informa&ccedil;&atilde;o sobre o livro
        </td>
      </tr>
      <tr>
        <td align=center>
               <title>Devolver o Livro</title>
<?php
if(!isset($_POST["codigo"]))
{
?>
		<form method="POST" action="devolucao.php">
		<p>C?digo do Livro: <input type="text" name="codigo" size="20">
		<input type="submit" value="Devolu&ccedil;&atilde;o" name="exclui"></p>
		</form>
<?php
}
else   // excluir o produto
{
	$codigo=$_POST["codigo"];
	$res = pg_query("DELETE FROM emprestimo WHERE id_livro='$codigo'");
		if(pg_affected_rows($res)==1)
			echo "<p align='center'>Livro devolvido com sucesso!</p>";
		else
			echo "<p align='center'>Emprestimo n?o encontrado!</p>";
}
?>
<p align="center"><a href="javascript:history.back();">Voltar</a></p>
</body>
</html>
