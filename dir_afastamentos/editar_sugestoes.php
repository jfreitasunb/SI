<html>
<meta charset="UTF-8" />
<head>
	<title> Editar Sugestões </title>
</head>
<body>
<h1 align="center">Editar Sugestões </font> </h1> 
<hr>
<?php 
function ReformatarData($data){
	$rData = explode("-", $data);
	$rData = $rData[2].'/'.$rData[1].'/'.$rData[0];
	return $rData;
   }
 
require("../muda_senha/pgsql.php");   
require_once('funcoes-bancodedados.php'); 
//conexao();

$id_edit=explode("__",$_GET["id"]);
$sql_seleciona = "SELECT * FROM afastamentos WHERE id='$id_edit[1]'";
$resultado_sugestoes = selecionar($sql_seleciona);

//$res = pg_fetch_assoc($resultado_sugestoes);
$res = pg_fetch_array($resultado_sugestoes);

$query_prof=pg_query("select name||' '||firstname from users where coduser='".$res['professor']."'");

echo ("Registro N<sup>o</sup>: ".$res['id']." &#160 &#160 &#160 Professor: ".pg_result($query_prof,0,0));
		$dtFormatada = ReformatarData($res['data']);
		echo ("<br> Atualizado em : ".$dtFormatada." às ".$res['hora']." horas.<p></p>");
?>
<form method="POST" action ="atualiza_sugestoes.php">
	<table> 
		<tr><td>
		<textarea style="background:#F3FFFD" name="sugestao" rows="20" cols="100%"><?php echo $res['sugestao_texto']; ?> 
		</textarea>
		</td></tr>
		<tr>
			<input type=hidden name='id' value="<?php echo ($id_edit[1]); ?>">
			<td align="right"><input  type="submit" name="enviar" value="Atualizar sugestão"></td>
		</tr> 
</form>

</body>
</html>
<?php
pg_close($con);
?>

