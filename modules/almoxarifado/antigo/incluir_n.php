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
          <h1>Inclus&atilde;o de Equipamento</h1>Informa&ccedil;&otilde;es sobre o equipamento
        </td>
      </tr>
      <tr>
        <td align=center>
               <title>Incluir Produtos</title>
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
              Descri&ccedil;&atilde;o da Inclus&atilde;o :
            </td>
          </tr>
          <tr>
            <td> Codigo : </td>
            <td>
              <input type="text" name="codigo" size="20">
            </td>
            <td> Nome :</td>
            <td>
              <input type="text" name="nome" size="20" >
            </td>
          </tr>
          <tr>
             <td>Patrimonio :</td>
             <td>
               <input type="text" name="patrimonio" size="20" >
             </td>
             </tr>
	  <tr>
            <td>Descri&ccedil;&atilde;o :</td>
            <td colspan=3>
              <textarea rows="2" name="descricao" cols="43"></textarea><br>
            </td>
          </tr>
          <tr><td colspan=4><hr></td></tr>
          <tr>
            <td>Categoria :</td>
            <td>
              <select size="1" name="categoria">
	<?php
		// gera a lista de categorias
		$res = pg_query("SELECT * FROM categorias");
		while($registro = pg_fetch_row($res))
		{
			$cod = $registro[0];
			$nome = $registro[1];
			echo "<option value=\"$cod\">$nome</option>\n";
		}
	?>
	</select>
	<input type="hidden" name="enviar" value="S">
<?php
}
else   // inclui o equipamento
{
	$codigo=$_POST["codigo"];
	$nome=$_POST["nome"];
	$descricao=$_POST["descricao"];
	$patrimonio=$_POST["patrimonio"];
	$categoria=$_POST["categoria"];
	$res = pg_query("INSERT INTO produtos VALUES('$codigo','$nome','$descricao','$patrimonio','$categoria')");
	if(pg_affected_rows($res)>0)
		echo "<p align='center'>Equipamento incluido com sucesso!</p>";
	else	{
		$erro = pg_last_error();
		echo "<p align='center'>Erro: $erro</p>";
	}
}
?>
</table><br>
<input type="submit" value="Incluir Equipamento" name="incluir"></p>
</form><p align="center"><a href="javascript:history.back();">Voltar</a></p>
</body>
</html>
