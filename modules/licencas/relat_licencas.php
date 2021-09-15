<?php
  include("head_licencas.php");

function relatorio($tipo_licenca,$ano)
{
/*
	$tab_id_licences=array(
				"Apresentacao de seminario/palestra",
				"Colaboracao cientifica",	
				"Participacao em congresso",
				"Participacao em banca de defesa de especializacao",
				"Participacao em banca de defesa de mestrado",
				"Participacao em banca de defesa de doutorado",
				"Participacao em banca de concurso publico para assistente",
				"Participacao em banca de concurso publico para adjunto",
				"Participacao em banca de concurso publico para titular",
				"Pos-doutoramento",
				"Coloquios"
				);
*/
	$query_tipo=pg_query("select tipo from licences_tipo where codigo='".$tipo_licenca."'");
	$tab_id_licences=pg_fetch_result($query_tipo, 0, 0);

	$query="select name, firstname, matricul,date_debut, date_fin, destino, titulo from users us, licences l where id_licence='".$tipo_licenca."' and us.coduser=l.coduser and l.date_debut like '".$ano."%' order by name";
	$result=pg_query($query);
	$retorna=pg_fetch_all($result);
	$linhas=pg_num_rows($result);

	if (!empty($retorna)) 
	{
	?>
	<tr><td>
        <table align=center class=form>
        <tr>
        <td class=header align=center colspan=2> <?php echo mb_convert_encoding($tab_id_licences,"ISO-8859-1","UTF-8")?></td>
        </tr>
	<?php
	for ($i=0; $i< $linhas; $i++)
		{
		$dados=$retorna[$i];
		$inicio=explode("-",$dados['date_debut']);
		$volta=explode("-",$dados['date_fin']);
		$local=explode("/$/",$dados['destino']);
		$titulo=explode("/$/",$dados['titulo']);
		?>
	        <tr><td>Prof(a). <?php echo mb_convert_encoding($dados['name'],"ISO-8859-1","UTF-8")?>  <?php echo mb_convert_encoding($dados['firstname'],"ISO-8859-1","UTF-8")?> (<?php echo $dados['matricul']?>) </td></tr>
	        <tr><td>Per&iacute;odo de <?php echo $inicio[2]?> /<?php echo $inicio[1]?> /<?php echo $inicio[0]?> a  <?php echo $volta[2]?> /<?php echo $volta[1]?> /<?php echo $volta[0]?>  </td></tr>
		<tr><td>Institui&ccedil;&atilde;o: <?php echo mb_convert_encoding($local[0],"ISO-8859-1","UTF-8")?> </td></tr>
		<tr><td>Cidade: <?php echo mb_convert_encoding($local[1],"ISO-8859-1","UTF-8")?> </td> <td> Estado: <?php echo mb_convert_encoding($local[2],"ISO-8859-1","UTF-8")?></td></tr>
		<?php
		if (!empty($titulo[0])) 
			{
			?>
			<tr><td>T&iacute;tulo: <?php echo mb_convert_encoding($titulo[0],"ISO-8859-1","UTF-8") ?> </td></tr>
			<?php
			}
		if (!empty($titulo[1])) 
			{
			?>
			<tr><td>Autor: <?php echo mb_convert_encoding($titulo[1],"ISO-8859-1","UTF-8") ?> </td></tr>
			<?php
			}
		?>
		<tr><td><hr width=30% noshade></td></tr>
		<?php
		}
		?>
	</table>
	<?php
	}
}

if (empty($_POST['ano']) or ($_POST['ano']=="")) 
	{
?>
	<html>
	<link type="text/css" rel="stylesheet" href="../../global/grafic.css">
	<body leftmargin="0">
	<table class=form align=center>
        <tr>
        <td class=header align=center colspan=1><h1>Escolha um ano</h1> </td></tr>
	</table>
	</body>
	</html>
<?php
	}
	else
	{
	$query="select * from licences where date_debut like '".$_POST['ano']."%'";
	$result=pg_query($query);
	$linhas=pg_num_rows($result);
	if ($linhas==0)
		{
?>
		<html>
		<link type="text/css" rel="stylesheet" href="../../global/grafic.css">
		<body leftmargin="0">
		<table class=form align=center>
	        <tr>
	        <td class=header align=center colspan=1><h1>N&atilde;o h&aacute; dados para este ano; escolha outro ano</h1> </td></tr>
		</table>
		</body>
		</html>
<?php
		}
	else
		{
?>
		<html>
		  <header>
		    <link type="text/css" rel="stylesheet" href="../../global/grafic.css">
		    <script language="JavaScript" src="navig_js.js"></script>
		    <script language="javascript" src="formu.js"></script>
		   </header>
		  <body>
		  <table class=big>
		  <tr>
		      <td class=header align=center>
        	<h1>Relat&oacute;rio de Licen&ccedil;as do ano <?php echo $ano ?></h1>
      		</td>
		</tr>

<?php
		for ($i=0; $i<11; $i++)
			{
			relatorio($i,$_POST['ano'])
			?> <br> <?php
			}
?>
		     <table>
		    </body>
		</html>
<?php
		}

	}
  pg_close($idconn);
?>
