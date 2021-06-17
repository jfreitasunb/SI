<?php
include("head_relatorios_pos.php");


//<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
?>
<html>
	<head>
	<META http-equiv="Content-Type" content="text/html; charset=utf-8">
	<link type="text/css" rel="stylesheet" href="../../global/grafic.css">
	</head>
	

<body>
	<h2 align="center">
		Lista das Inscrições Homologadas.
	</h2>

<?php  
//include_once("../pgsql/pgsql.php"); 


$coduser_lista_homologados = $_POST['homologa'];

echo "<ol>";
foreach ($coduser_lista_homologados as $key => $value){
	echo "<li> id:".$value; 
	$pega_nome = pg_query("select name||''||firstname as nome from inscricao_pos_dados_candidato where id_aluno='".$value."'");
	$nome0= pg_fetch_row($pega_nome);
	$nome = $nome0[0];
	
	echo "&nbsp &nbsp &nbsp &nbsp ".$nome."</li>";
}
echo "</ol>";
?>
</body>
</html>
<?php
pg_close($idconn);
?>

