<?php
include "head_account.php";
?>
<html>
<header>
<link type="text/css" rel="stylesheet" href="../../global/grafic.css">
</header>
<title> Incluir Categoria</title>
<body>

<?php


//inclui uma categoria
	
	$nome = $_POST["nome"];
	
	//include "conecta.php";
	$consulta = pg_query("SELECT * FROM convenio WHERE nome_conv = '$nome'"); // faz uma consulta na tabela pra saber se o equipamento ja n? foi cadastrado

        $resultado = pg_num_rows($consulta); 

		if ($resultado == true) 
		{
			echo "<br>Convenio j&aacute est&aacute cadastrado! <br><input type='button' value='voltar' onclick='history.back();'>";
			exit;
		}
	
	
	elseif (empty($nome)){
    echo "Informe o nome!";
    echo "<input type='button' value='voltar' onclick='history.back();'>";
	exit;}
	
		
    $pg = "INSERT INTO convenio VALUES (default,'$nome') ";
    
	$insere = pg_query($pg);
	
	//$pg_post = "select * from categorias where nome = ".$_POST['nome']; 
	//$resultado=pg_query($pg_post);
	//$linhas=pg_fetch_array($resultado);
	
    if ($insere == true){
    echo "Convenio $nome cadastrado com sucesso no sistema! <br>";
	echo "<input type='button' value='voltar' onclick='history.back();'>";
	}
	
    else {
	echo "Dados Inv?idos! <input type='button' value='voltar' onclick='history.back();'>";
    }

?>
</body>
</html>

