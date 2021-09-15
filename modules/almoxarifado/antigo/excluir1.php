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
          <h1>Retirada de Equipamento</h1>Informa&ccedil;&otilde;es sobre o equipamento
        </td>
      </tr>
      <tr>
        <td align=center>
          <table class=form>
<?php
	if(!isset($_POST["codigo"]))
	{
?>

<form method="POST" action="excluir1.php">
<p>Código do Equipamento:<input name="codigo" size="20">
<input type="submit" value="EXCLUIR PRODUTO" name="exclui"></p>
</form>

<?php
	}
	else
	{
		$codigo=($_POST["codigo"]);
		$res=pg_query("DELETE FROM produtos WHERE codigo=$codigo");
		$result=pg_affected_rows($res);
		if($result>0)
			echo"<p align='center'>Equipamento retirado com sucesso</p>";
		else
			echo"<p align='center'>Equipamento não encontrado!</p>";
	}
	?>
	<p align="center"><a href="excluir1.php">Voltar</a></p>
</table>
</body>
</html>
