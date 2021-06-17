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
        </td></tr>
		<tr>
		<td>
		<form name="form_filtro" method="get" action="<?php echo $_SERVER["PHP_SELF"]; ?>">
		Convenio:
              <select size="1" name="convenio">
		<option value=0>TODOS</option>
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
	</select>
	            <td></tr>
			<tr>
			<td>Categoria:
			
              <select size="1" name="categoria">
		<option value=0>TODOS</option>
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
	<input name="cod_conv" type="submit" value="filtrar">
	</form>
	</td>
	      </tr>
      <tr>
        <td align=center>
          <table class=form>
        <table border="1" cellpadding="0" cellspacing="0" width="90%">
    <tr>
      <td width="10%" bgcolor="#EEEEEE" align="center"><p align="center"><b><a href="listar.php?ordem=patrimonio_eq">Patrimonio</a></b></td>
      <td width="25%" bgcolor="#EEEEEE" align="center"><b><a href="listar.php?ordem=nome_eq">Nome</a></b></td>
      <td width="40%" bgcolor="#EEEEEE" align="center"><b><a href="listar.php?ordem=descr_eq">Descri&ccedil;&atilde;o</a></b></td>
      <td width="14%" bgcolor="#EEEEEE" align="center"><b>Convenio</a></b></td>
      <td width="11%" bgcolor="#EEEEEE" align="center"><b>Categoria</a></b></td>
    </tr>
<?php
        if(isset($_GET["ordem"]))
		$ordem = $_GET["ordem"];
	else
		$ordem = "nome_eq";

	if(isset($_GET["categoria"]) && $_GET["categoria"] > 0 )
		$filtro_cat= $_GET["categoria"];

  	else
		$filtro_cat=0;

	if(isset($_GET["convenio"]) && $_GET["convenio"] > 0 )
		$filtro_con= $_GET["convenio"];

  	else
		$filtro_con=0;

	$filtro_sql = "";
	if ($filtro_cat > 0) {
		$filtro_sql = " AND cat.cod_cat = " . $filtro_cat;	
	}	
	
	if ($filtro_con > 0) {
		$filtro_sql .= " AND con.cod_conv = " . $filtro_con;	
	}

		$sql   = "select eq.cod_eq, con.nome_conv, eq.nome_eq, eq.descr_eq, cat.nome_cat, eq.patrimonio_eq from equipamentos eq, categorias cat, convenio con where eq.cod_cat_eq = cat.cod_cat and eq.cod_conv_eq = con.cod_conv" . $filtro_sql ;
		//$sql .=" ORDER by $ordem";
		$sql_comp="select null as convenio, btrim(split_part(maqcod,' ',1)) as numero from computers where btrim(split_part(maqcod,' ',2))='' and codloc='Almoxarifado' union select btrim(split_part(maqcod,' ',1)) as convenio, btrim(split_part(maqcod,' ',2)) as numero  from computers where btrim(split_part(maqcod,' ',2))<>'' and codloc='Almoxarifado'";
		
//  maqcod   |    ipnet     |   codloc    | host  |        mac        | mouse  | keyboard | resolucao | tipo_maquina | status | data_encerramento 
//------------+--------------+-------------+-------+-------------------+--------+----------+-----------+--------------+--------+-------------------
// FUB 243475 | 172.16.39.35 | coord. inf. | 406_5 | 00:14:22:B3:F1:98 | Serial | PS/2     | 1024x768  | Desktop      | 1      | 2030-02-28
// sp_83      | 172.16.39.117 | sala alunos pos | 461_1  | 00:90:F5:56:34:E0 | PS/2   | PS/2     | 1280x1024 | Laptop        | 1      | 2010-04-15

//$maq_exp=explode(" ",$maqcod); 
//if (!empty($maq_exp[0])) 
//{
 //if (!is_numeric($maq_exp[0]) and is_int($maq_exp[1])) {$convenio=$maq_exp[0]; $numero=$maq_exp[1];}
 //if (!is_numeric($maq_exp[1]) and is_int($maq_exp[0])) {$convenio=$maq_exp[1]; $numero=$maq_exp[0];}
//}
//else if (is_int($maq_exp[1])) {$convenio=$maq_exp[0]; $numero=$maq_exp[1];}

		$res = pg_query($sql);

		
	while($registro=pg_fetch_row($res))
	{
		$codigo=$registro[0];
		$convenio=$registro[1];
		$nome=$registro[2];
		$descricao=$registro[3];
		$categoria=$registro[4];
		$patrimonio=$registro[5];
		
	    echo "<tr>";
		echo "<td width='10%'>";
		echo "<p align='center'>$patrimonio</td>";
		echo "<td width='25%'>$nome</td>";
		echo "<td width='45%'>$descricao</td>";
		echo "<td width='15%' align='center'>$convenio</td>";
		echo "<td width='19%' align='center'>$categoria</td>";
		
		echo "</tr>";
	}
	// adiciona dados da computers
	$res_computers = pg_query($sql_comp);
while($registro=pg_fetch_row($res_computers))
	{
		$numero=$registro[1];
		$convenio=$registro[2];
		$nome=$registro[3];
		$descricao=$registro[3];
		$categoria=$registro[4];
		$patrimonio=$registro[5];
		
	    echo "<tr>";
		echo "<td width='10%'>";
		echo "<p align='center'>$numero</td>";
		echo "<td width='25%'>$convenios</td>";
		echo "<td width='45%'>$descricaos</td>";
		echo "<td width='15%' align='center'>$convenio</td>";
		echo "<td width='19%' align='center'>$categorias</td>";
		
		echo "</tr>";
	}

?>
  </table>
  </table>
  </table>
  </center>
</div>
<p align='center'>
<input type='button' value='Voltar' onclick='history.back();' ></p>

</body>
</html>


<table border="0" align="left" cellspacing="1" cellpadding="1">
<tr>
<td> </td>
</tr>
</table><table border="0" align="left" cellspacing="1" cellpadding="1">
<tr>
<td> </td>
<td> </td>
</tr>
<tr>
<td> </td>
<td> </td>
</tr>
</table>
