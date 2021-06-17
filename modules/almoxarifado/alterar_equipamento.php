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
if(!isset($_POST["codigo"]))	// solicita o c?igo
{
?>
	<form method="POST" action="<?php echo $_SERVER["PHP_SELF"]; ?>">
		<tr><td align=center>
          <table class=form>
          <tr><td> Selecione o equipamento: 
            <td><select size="1" name="codigo">
              <option value=0>Nome  -----    Patrimonio</option>
	<?php
		// gera a lista de convenios
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
  	      <td><input type="submit" value="ALTERAR EQUIPAMENTO" name="alterar"></td>
	</form>
<?php
}
elseif(!isset($_POST["enviar"]))		// busca os dados do equipamento
{
        //include "conecta.php";
	$codigo=$_POST["codigo"];
	$sql = "SELECT * FROM equipamentos WHERE cod_eq='$codigo'";
	$res = pg_query($sql);
	if(pg_num_rows($res)==0)
		echo "Equipamento n? encontrado!";
	else
	{
		$registro=pg_fetch_row($res);
		$nome=$registro[2];
		$descricao=$registro[3];
		$patrimonio=$registro[5];
		$categoria=$registro[4];

?>
		<form method="POST" action="<?php echo $_SERVER["PHP_SELF"]; ?>">

		<tr>
        <td align=center>
          <table class=form>
          <tr>
            <td colspan=4 class=header align=center>
              Dados do Equipamento :
            </td>
          </tr>
          <tr>
            <td><p></b></td>
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
				$cod_cat = $registro[0];
				$nome_cat = $registro[1];
				echo "<option value=\"$cod_cat\" ";
				if($cod==$codigo)
					echo "selected";
				echo ">$nome_cat</option>\n";
			}
	?>
	</select>
	<tr>
            <td>Convenio :</td>
            <td>
              <select size="1" name="convenio">
	<?php
		$res = pg_query("SELECT * FROM convenio");
			while($registro = pg_fetch_row($res))
			{
				$cod_conv = $registro[0];
				$nome_conv = $registro[1];
				echo "<option value=\"$cod_conv\" ";
				if($cod==$codigo)
					echo "selected";
				echo ">$nome_conv</option>\n";
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
      //include "conecta.php";
	$codigo=$_POST["codigo"];
	$nome=$_POST["nome"];
	$descricao=$_POST["descricao"];
	$patrimonio=$_POST["patrimonio"];
	$cat=$_POST["categoria"];
	$conv=$_POST["convenio"];
		$sql = "UPDATE equipamentos SET nome_eq='$nome', descr_eq='$descricao', patrimonio_eq='$patrimonio', cod_cat_eq='$cat', cod_conv_eq='$conv' WHERE cod_eq='$codigo'";
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
</table><p align="center"><input type='button' value='Voltar' onclick='history.back();' ></p>
</body>
</html>
