<?php
require("../muda_senha/pgsql.php");
?>
<html>
	<meta charset="UTF-8" />
	
	
		<head>
			<title> Atualização </title>
			<script type="text/javascript" src="http://cdn.mathjax.org/mathjax/latest/MathJax.js?config=TeX-AMS-MML_HTMLorMML">
			</script>
		</head>
	
<body>
		
	
<?php
		require_once('funcoes-bancodedados.php'); 

		if (isset($_POST['enviar']) )
			{
//				$professor = "Mochileiro das Galaxias";
				$sugestao_atualizada = $_POST['sugestao'];
				$data = date("Y/m/d");
				$hora = date("H:i:s");
				$id_atualizacao = $_POST['id'];
				$query_prof=pg_query("select professor from afastamentos where id='".$id_atualizacao."'");
				//conexao();
				$sql_inserir = "UPDATE afastamentos SET sugestao_texto='$sugestao_atualizada',
													data='$data',
													hora='$hora' 
								 WHERE id = '$id_atualizacao'";
			if (inserir($sql_inserir))
				{ 	echo "<br> Atualização realizada com sucesso em nossos servidores.";
					unset ($_POST['enviar']);
				}
			else
				{ echo "Esta atualização não foi recebida pelo servidor. 
						Por favor, clique em voltar e salve o texto e 
						faça uma nova tentativa de envio mais tarde. ".mysql_error();}
		}

?>

<a href="minhas_sugestoes.php?professor=<?php echo md5(pg_result($query_prof,0,0));?>"> Visualizar Sugestão.</a>
</body>
<?php
pg_close($con);
?>

