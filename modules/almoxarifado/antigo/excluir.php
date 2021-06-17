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
          <h1>Retirada de Equipamento</h1>Informa&ccedil;&atilde;o sobre o equipamento
        </td>
      </tr>
      <tr>
        <td align=center>
               <title>Retirar Equipamento</title>
<?php
if(!isset($_POST["codigo"]))
{
?>
		<form method="POST" action="excluir.php">
		<p>Código do equipamento: <input type="text" name="codigo" size="20">
		<input type="submit" value="RETIRAR EQUIPAMENTO" name="exclui"></p>
		</form>
<?php
}
else   // excluir o produto
{
	$codigo=$_POST["codigo"];
	$res = pg_query("DELETE FROM produtos WHERE codigo_produto=$codigo");
	if(pg_affected_rows($res)==1)
		echo "<p align='center'>Equipamento retirado com sucesso!</p>";
	else
		echo "<p align='center'>Equipamento não encontrado!</p>";
}
?>
<p align="center"><a href="javascript:history.back();">Voltar</a></p>
</body>
</html>
