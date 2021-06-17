<?php

require "verifica.php";

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml"><head>
<meta http-equiv="content-type" content="text/html; charset=iso-8859-1">

<title>Servidor Administrativo</title><style type="text/css" media="all">@import "style.css";</style></head>



<body>

<div id="Header"></div>

<div id="Content">
        <h1>Editar Documento</h1>
<p> Os seguintes documentos foram encontrados. Para editá-los clique no link referente.</p>
<br>
<?php

require "conexao.php";

$sel="SELECT id_documentador,id_departamentos,mensagem,id_assinaturas,data  
      FROM rascunho  
      WHERE id_tipo='$id_tipo' 
      ORDER BY id_documentador DESC";

$resultado=pg_query($sel) or die ("Não foi possível realizar a consulta ao banco de dados");


$contador=pg_num_rows($resultado);



if ($contador == 0)
	echo " <p> Não existe nenhum documento.</p>";
else {
		while ($linha=pg_fetch_array($resultado))
			{
			$id_documentador=trim($linha["id_documentador"]);
			$numerodocumento=trim($linha["numerodocumento"]);
			$id_departamentos=trim($linha["id_departamentos"]);
			$mensagem=trim($linha["mensagem"]);
			$id_assinaturas=trim($linha["id_assinaturas"]);
			$data=trim($linha["data"]);	
$most1="SELECT nomedepartamento FROM departamentos WHERE id_departamentos = '$id_departamentos'";

$resultado1=pg_query($most1) or die("Não foi possível executar a operação. Contacte a Coordenação de
 I
nformática.");

$row1= pg_fetch_row($resultado1,$i);



$most2="SELECT nome FROM assinaturas WHERE id_assinaturas = '$id_assinaturas'";

$resultado2=pg_query($most2) or die("Não foi possível executar a operação. Contacte a Coordenação de
 I
nformática.");

$row2= pg_fetch_row($resultado2,$i);



                        
 
	
			echo "<a href='editar.php?id_documentador=$id_documentador'> <p>- Data: <b> $data</b><br>- Destino: <b> $row1[0]</b><br>- Mensagem : <b> $mensagem</b><br>- Assinatura : <b> $row2[0]</b></a></p></font><br><br>";
		}
	}
//pg_close($conn);
?>

<div id="Menu">
	<a><i>Menu</i> Documentos</a><br>	
	<a href="exercicio_insere.php">Gerar</a><br>
        <a href="exercicio_edita.php">Editar</a><br>
	<a href="exercicio_edita_lista.php">Buscar</a><br>
        <a href="sair.php">Sair</a><br>
</div>


</body>
</head>
</html>
