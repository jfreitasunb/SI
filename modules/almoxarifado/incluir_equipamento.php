<?php 
include "head_account.php";
?>
<html>
<header>
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

<form method="POST" action="<?php echo $_SERVER["PHP_SELF"]; ?>"><p>
<tr>
        <td align=center>
          <table class=form>
          <tr>
            <td colspan=4 class=header align=center>
              Descri&ccedil;&atilde;o da Inclus&atilde;o :
            </td>
          </tr>
          <tr>
            <td> Patrim&ocirc;nio: </td>
            <td>
            <select size="1" name="convenio">
              <option value=0>Selecione um Convenio</option>
	<?php
		// gera a lista de convenios
		$res = pg_query("SELECT * FROM convenio ORDER BY cod_conv");
		while($registro = pg_fetch_row($res))
		{
			$cod_conv = $registro[0];
			$nome_conv = $registro[1];
			echo "<option value=\"$cod_conv\">$nome_conv </option>\n";
		}

	?>
	</select>N&ordm;: 
              <input type="text" name="patrimonio" size="20" maxlength="10">
            </td>
            <tr>
            <td>Categoria :</td>
            <td>
              <select size="1" name="categoria">
              <option value=0>Selecione uma Categoria</option>
	<?php
		// gera a lista de categorias
		$res = pg_query("SELECT * FROM categorias ORDER BY cod_cat");
		while($registro = pg_fetch_row($res))
		{
			$cod_cat = $registro[0];
			$nome_cat = $registro[1];
			echo "<option value=\"$cod_cat\">$nome_cat</option>\n";
		}

	?>
	</select>
            </td>
          </tr>
          <tr>
             <td>Nome:</td>
             <td>
               <input type="text" name="nome" size="20" maxlength="34" >
             </td>
             </tr>
	  <tr>
            <td>Descri&ccedil;&atilde;o :</td>
            <td colspan=3>
              <textarea rows="2" name="descricao" cols="43" maxlength="295"></textarea><br>
            </td>
          </tr>
          <tr><td colspan=4><hr></td></tr>
          
	<input type="hidden" name="enviar" value="S">
</table><br>
<input type='submit' value="Incluir Equipamento" name="incluir"></p>
<input type='reset' value='Limpar Campos' >
<?php
}

else   // inclui o equipamento
{
	
	$patrimonio_eq=$_POST["patrimonio"];
	$cod_conv_eq=$_POST["convenio"];
	$nome_eq=$_POST["nome"];
	$descr_eq=$_POST["descricao"];
	$cod_cat_eq=$_POST["categoria"];
	
			
		
	//include "head_account.php";
	$consulta = pg_query("SELECT * FROM equipamentos WHERE patrimonio_eq = '$patrimonio_eq'"); // faz uma consulta na tabela pra saber se o equipamento ja não foi cadastrado

$resultado = pg_num_rows($consulta); 

		if ($resultado == true) 
		{
			echo "<br>Patrimonio j&aacute est&aacute cadastrado! <br><input type='button' value='voltar' onclick='history.back();'>";
			exit;
			
		}
		elseif ($patrimonio_eq == "") // Confere se o campo patrimonio nao vazio
		{
			echo "<br><h1>Voce nao informou o numero do patrimonio! <br><input type='button' value='voltar' onclick='history.back();'>";
			exit;
		}
		elseif ($cod_conv_eq ==0) //Confere se o campo convenio nao ficou vazio
		{
			echo "<br>Voce nao selecionou o convenio! <br><input type='button' value='voltar' onclick='history.back();'>";
			exit;
		}
		elseif ($nome_eq =="") //Confere se o campo nome nao ficou vazio
		{
			echo "<br>Voce nao informou o nome! <br><input type='button' value='voltar' onclick='history.back();'>";
			exit;
		}
		elseif($descr_eq=="")
		{
			echo "<br> Voce nao informou a descriçao do equipamento!<br><input type='button' value='voltar' onclick='history.back();'>";
			exit;
		}
		elseif($cod_cat_eq==0)
		{
			echo "<br> Voce nao selecionou a categoria! <br><input type='button' value='voltar' onclick='history.back();'>";
			exit;
		}
		
	$sql = "INSERT INTO equipamentos (patrimonio_eq, cod_conv_eq, nome_eq, descr_eq, cod_cat_eq)";
	$sql .= "VALUES('$patrimonio_eq', '$cod_conv_eq','$nome_eq','$descr_eq','$cod_cat_eq')";
	
	
	$inclui = pg_query($sql);
		if(pg_affected_rows($inclui)>0)
		echo "<p align='center'>Equipamento incluido com sucesso!</p>";
		else	{
		$erro = pg_last_error();
		//echo "<p align='center'>Erro: $erro</p>";
    }
}

?>
<input type='button' value='Voltar' onclick='history.back();' ></p>
</form>
</body>
</html>



