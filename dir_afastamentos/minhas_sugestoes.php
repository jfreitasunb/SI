<html>
<meta charset="UTF-8" />
<head>
	<title> Minhas Sugestões </title>
	<script type="text/javascript" src="http://cdn.mathjax.org/mathjax/latest/MathJax.js?config=TeX-AMS-MML_HTMLorMML">
	</script>
</head>
<h1 align="center">Minhas Sugestões </font> </h1> 
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
$professor=$_GET['professor'];
//$sql_seleciona = "SELECT * FROM sugestoes WHERE professor='Leandro Doidoletti'";
//$sql_seleciona = "SELECT * FROM sugestoes WHERE professor='".$professor."'";
$sql_seleciona = "SELECT * FROM afastamentos WHERE md5(professor)='".$professor."' and ativo='1'";
$resultado_sugestoes = selecionar($sql_seleciona);
//$num_sugestoes=pg_num_rows($resultado_sugestoes);
echo ("<p> Número de sugestões encontradas: ".pg_num_rows($resultado_sugestoes)."</p> <hr>");
$linha=0;
while ($res = pg_fetch_assoc($resultado_sugestoes))
	{
		$linha=$linha+1;
		$query_prof=pg_query("select name||' '||firstname from users where coduser='".$res['professor']."'");
		echo ("Registro N<sup>o</sup>: ".$linha." &#160 &#160 &#160 Professor: ".pg_result($query_prof,0,0));
		echo nl2br("<p> <b>Sugestão:</b><br> ".$res['sugestao_texto']."</p>");
		$dtFormatada = ReformatarData($res['data']);
		echo ("Data: ".$dtFormatada." &#160 &#160 Hora: ".$res['hora']."<p></p>");
		echo("	 <table>
					<tr>
					<td align='center'>
					<a href='editar_sugestoes.php?id=".$professor."__".$res['id']."'><input type='button' value='Editar' 
					</td>
					<td> &#160 &#160 &#160 </td>
					<td align='center'>
					<a href='excluir.php?id=".$professor."__".$res['id']."'><input type='button' value='Excluir' 
					</td>
					</tr>
				</table>
				<hr>
			");
	}
?>
<br>

<table algin="center" border="0" width="100%">
	<tr>
		<td align="center" width="33%"><a href="main.php?professor=<?php echo $professor;?>">Mandar uma nova sugestão </a></td>
		<!-- <td align="center" width="34%"><a href="todas_sugestoes.php?professor=<?php echo $professor;?>">Ver todas as sugestões</a></td> -->
		<td align="center" width="33%"><a href="logout.php"; title="Logout"><img alt="Logout" src="sair.png" border="0" width="50" /></a></td> 
	</tr>

</table>	
</html>
<?php
pg_close($con);
?>

