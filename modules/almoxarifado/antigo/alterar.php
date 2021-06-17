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
          <h1>Altera&ccedil;&atilde;o de Equipamento</h1>Informa&ccedil;&otilde;es sobre o equipamento
        </td>
      </tr>
      <tr>
        <td align=center>
               <title>Alterar Equipamento</title>
<?php
if(!isset($_POST["codigo"]))	// solicita o código
{
?>
	<form method="POST" action="alterar.php">
		<tr><td align=center>
          <table class=form>
          <tr><td colspan=4 class=header align=center>
	  Codigo do Equipamento :   </td></tr>
          <tr><td> Codigo do equipamento: </td>
              <td><input type="text" name="codigo" size="20"></td>
  	      <td><input type="submit" value="ALTERAR EQUIPAMENTO" name="alterar"></td>
	</form>
<?php
}
elseif(!isset($_POST["enviar"]))		// busca os dados do equipamento
{
	$codigo=$_POST["codigo"];
	$sql = "SELECT * FROM produtos WHERE codigo_produto=$codigo";
	$res = pg_query($sql);
	if(pg_num_rows($res)==0)
		echo "Equipamento não encontrado!";
	else
	{
		$registro=pg_fetch_row($res);
		$nome=$registro[1];
		$descricao=$registro[2];
		$patrimonio=$registro[3];
		$categoria=$registro[4];

?>
		<form method="POST" action="alterar.php">

		<tr>
        <td align=center>
          <table class=form>
          <tr>
            <td colspan=4 class=header align=center>
              Dados do Equipamento :
            </td>
          </tr>
          <tr>
            <td><p>Codigo: <b><?php echo $codigo; ?></b></td>
            <tr><td> Nome :</td>
            <td><input type="text" name="nome" value="<?php echo $nome;?>"> </td></tr>
           <tr> <td>Patrimonio :</td>
             <td><input type="text" name="patrimonio" size="20" value="<?php echo $patrimonio;?>">
             </td></tr>
             <tr><td>Descri&ccedil;&atilde;o :</td>
            <td colspan=3>
              <textarea rows="2" name="descricao" cols="30"><?php echo $descricao;?></textarea>
            </td>
          </tr>
          <tr><td colspan=4><hr></td></tr>
          <tr>
            <td>Categoria :</td>
            <td>
              <select size="1" name="categoria">
	<?php
		$res = pg_query("SELECT * FROM categorias");
			while($registro = pg_fetch_row($res))
			{
				$cod = $registro[0];
				$nomecat = $registro[1];
				echo "<option value=\"$cod\" ";
				if($cod==$codigo)
					echo "selected";
				echo ">$nomecat</option>\n";
			}
	?>
	</select>
	<input type="hidden" name="enviar" value="S">

		  <input type="hidden" name="codigo" value="<?php echo $codigo;?>">
		  <input type="hidden" name="enviar" value="S">
		  <input type="submit" value="Alterar Equipamento" name="alterar"></p>
		</form>
<?php
	}
}
else   // alterar o produto
{
	$codigo=$_POST["codigo"];
	$nome=$_POST["nome"];
	$descricao=$_POST["descricao"];
	$patrimonio=$_POST["patrimonio"];
	$cat=$_POST["categoria"];
		$sql = "UPDATE produtos SET nome_produto='$nome',descricao_produto='$descricao',patrimonio='$patrimonio',cod_categoria=$cat WHERE codigo_produto=$codigo";
		$res = pg_query($sql);
		if(pg_affected_rows($res)>0)
			echo "<p align='center'>Equipamento alterado com sucesso!</p>";
		else
		{
			$erro = pg_last_error();
			echo "<p align='center'>Erro: $erro</p>";
		}
}
?>
</table><p align="center"><a href="javascript:history.back();">Voltar</a></p>
</body>
</html>
