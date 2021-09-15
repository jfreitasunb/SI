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
		<form method="POST" action="<?php echo $_SERVER["PHP_SELF"]; ?>">
		<p>Selecione o Equipamento: <select size="1" name="codigo">
              <option value=0>Nome  -----    Patrimonio</option>
	<?php
		// gera a lista de equipamentos
		//include "conecta.php";
		$res = pg_query("SELECT * FROM equipamentos ");
		while($registro = pg_fetch_row($res))
		{
			$cod_eq = $registro[0];
			$nome_eq = $registro[2];
			$patrimonio_eq = $registro[5];
			echo "<option value=\"$cod_eq\">$nome_eq ----- $patrimonio_eq  </option>\n";
		}

	?>
	</select>
		<input type="submit" value="RETIRAR EQUIPAMENTO" name="exclui"></p>
		</form>
<?php
}
else   // excluir o produto
{
	//include "conecta.php";
	$codigo=$_POST["codigo"];
	$res = pg_query("DELETE FROM equipamentos WHERE cod_eq=$codigo");
	if(pg_affected_rows($res)==1)
		echo "<p align='center'>Equipamento retirado com sucesso!</p>";
	else
		echo "<p align='center'>Equipamento n? encontrado!</p>";
}
?>
<p align="center"><input type='button' value='Voltar' onclick='history.back();' ></p>
</body>
</html>
