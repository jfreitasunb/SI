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

		if (isset($_POST['enviar']) )
			{
				//$professor = "Leandro Martins Cioletti";
				$professor = $_POST['professor'];
				$sugestao_enviada = $_POST['sugestao'];
				$data = date("Y/m/d");
				$hora = date("H:i:s");
				//conexao();
				$sql_inserir = "INSERT INTO afastamentos (id,professor,sugestao_texto,data,hora,ativo) 
										VALUES (default,'".$professor."','".$sugestao_enviada."','".$data."','".$hora."','1')";
			if (inserir($sql_inserir))
				{ 	echo "<br> Sugestão: ".mysql_insert_id()." recebida com sucesso em nossos servidores.";
					unset ($_POST['enviar']);
				}
			else
				{ echo "É possível que você tenha &quot colado &quot ou usado na caixa de texto algum caracter que
						o PHP não gosta muito. Por favor, clique em voltar e verifique se esta é a causa deste erro. 
						Caso contrário salve o texto e faça uma nova tentativa de envio mais tarde. ".mysql_error();}
		}

?>

<a href="minhas_sugestoes.php?professor=<?php echo md5($professor);?>"> Visualizar Sugestão.</a>
</body>
<?php
pg_close($con);
?>

