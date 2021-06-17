<html>
	<meta charset="UTF-8" />
	
	
		<head>
			<title> Licenças e Afastamentos </title>
			<script type="text/javascript" src="http://cdn.mathjax.org/mathjax/latest/MathJax.js?config=TeX-AMS-MML_HTMLorMML">
			</script>
		</head>
	
<body>
		
	
<?php
require("../muda_senha/pgsql.php");
		require_once('funcoes-bancodedados.php'); 
$id_do_get=$_GET['id'];
$id_explodido=explode("__",$id_do_get);
$sql_delete = "update afastamentos set ativo='0' where id='".$id_explodido[1]."'";
			if (inserir($sql_delete))
				{ 	echo "<br> Sugestão excluida com sucesso.";
				}
			else
				{ echo "É possível que você tenha &quot colado &quot ou usado na caixa de texto algum caracter que
						o PHP não gosta muito. Por favor, clique em voltar e verifique se esta é a causa deste erro. 
						Caso contrário salve o texto e faça uma nova tentativa de envio mais tarde. ".mysql_error();}
	

?>

<a href="minhas_sugestoes.php?professor=<?php echo $id_explodido[0];?>"> Visualizar minhas sugestões.</a>
</body>
<?php
pg_close($con);
?>

