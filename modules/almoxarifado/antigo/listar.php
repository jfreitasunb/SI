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
          <h1>Pesquisar equipamento</h1>Informa&ccedil;&otilde;es sobre o equipamento
        </td>
      </tr>
      <tr>
        <td align=center>
          <table class=form>
        <table border="1" cellpadding="0" cellspacing="0" width="90%">
    <tr>
      <td width="10%" bgcolor="#EEEEEE" align="center"><p align="center"><b><a href="listar.php?ordem=codigo_produto">Código</a></b></td>
      <td width="25%" bgcolor="#EEEEEE" align="center"><b><a href="listar.php?ordem=nome_produto">Nome</a></b></td>
      <td width="40%" bgcolor="#EEEEEE" align="center"><b><a href="listar.php?ordem=descricao_produto">Descrição</a></b></td>
      <td width="14%" bgcolor="#EEEEEE" align="center"><b><a href="listar.php?ordem=patrimonio">Patrimonio</a></b></td>
      <td width="11%" bgcolor="#EEEEEE" align="center"><b><a href="listar.php?ordem=cod_categoria">Categoria</a></b></td>
    </tr>
<?php
        if(isset($_GET["ordem"]))
		$ordem = $_GET["ordem"];
	else
		$ordem = "nome_produto";
		$sql = "SELECT * FROM produtos ORDER BY $ordem";
		$res = pg_query($sql);
	while($registro=pg_fetch_row($res))
	{
		$codigo=$registro[0];
		$nome=$registro[1];
		$descricao=$registro[2];
		$patrimonio=$registro[3];
		$quantidade=$registro[4];
		$categoria=$registro[5];
	    echo "<tr>";
		echo "<td width='10%'>";
		echo "<p align='center'>$codigo</td>";
		echo "<td width='25%'>$nome</td>";
		echo "<td width='40%'>$descricao</td>";
		echo "<td width='14%' align='center'>$patrimonio</td>";
		echo "<td width='12%' align='center'>$quantidade</td>";
		echo "<td width='11%' align='center'>$categoria</td>";
		echo "</tr>";
	}

?>
  </table>
  </table>
  </table>
  </center>
</div>
<p align="center"><a href="listar.php">Voltar</a></p>
</body>
</html>


