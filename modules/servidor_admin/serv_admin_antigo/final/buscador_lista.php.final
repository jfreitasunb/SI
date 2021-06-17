<?php
require "verifica.php";
$pagina=$_GET["pagina"];
$xpagina=($pagina)*10;
$paginamenosum=$pagina - 1;
$pagina=$pagina+1;

if ($pagina=="1"){
$busca=$_POST["busca"];
$id_tipo=$_POST["id_tipo"];
}
else{
$busca=$_GET["busca"];
$id_tipo=$_GET["id_tipo"];
}
?>

<head>
<meta http-equiv="content-type" content="text/html; charset=iso-8859-1">
<title>Servidor Administrativo</title><style type="text/css" media="all">@import "style.css";</style></head>
<body>
<div id="Header"></div>
<div id="Content">

<?php

if($busca=="Buscar") {

	$tabela="documentador";
	$arquivo_php="operacaopdf.php";
	$coluna="numerodocumento";
	$item="Número do documento";
	echo "

        	<h1>Buscar Documento</h1>
		<p> Os seguintes documentos foram encontrados. Para visualizar em formato <i>.pdf</i> o documento completo, clique 
		no link referente.</p><br>";
	}
else {
	
	$tabela="rascunho";
	$arquivo_php="editar.php";
	$coluna="data";
	$item="Data";
	echo "
		
		<h1>Editar Documento</h1>
		<p> Os seguintes documentos foram encontrados. Para editá-los clique no link referente.</p><br>";
	}


require "conexao.php";


//busca pelos documentos a partir do "tipo" especificado.
$resultado=pg_query("SELECT id_documentador,$coluna,id_departamentos,mensagem,id_assinaturas  
      FROM $tabela   
      WHERE id_tipo='$id_tipo' 
      ORDER BY id_documentador DESC 
      LIMIT 10 OFFSET $xpagina") or die ("Não foi possível realizar a consulta ao banco de dados");
$contador=pg_num_rows($resultado);

//mostrar na tela o resultado.
if ($contador == 0)
	{
	if($pagina>1)
		echo " <p> <b><i>Observação: pesquisa finalizada. Não há mais documentos registrados.</i></b></p>";
	else
		echo " <p> <b><i>Não há documentos registrados.</i></b></p>";
	echo "<br><p align='center'><a href='javascript:history.back();'>Retornar</a></p>";
	}
else 
	{	
	while ($linha=pg_fetch_array($resultado))
			{
			$id_documentador=trim($linha["id_documentador"]);
			$_coluna=trim($linha[$coluna]);
			$id_departamentos=trim($linha["id_departamentos"]);
			$mensagem=trim($linha["mensagem"]);
			$assinatura=trim($linha["id_assinaturas"]);
				
                      
			// busca pelo "destino"
			$resultado1=pg_query("SELECT nomedepartamento FROM departamentos WHERE id_departamentos = 
			'$id_departamentos'") or die("Não foi possível executar a operação. Contacte a Coordenação de
			 Informática.");	
			$row1= pg_fetch_row($resultado1,$i);

			// busca pelo "nome" e "cargo" de assinatura
			$resultado2=pg_query("SELECT nome FROM assinaturas WHERE id_assinaturas = '$assinatura'") or 
			die("Não foi possível executar a operação. Contacte a Coordenação de Informática.");
			$row2= pg_fetch_row($resultado2,$i);
 
			//impressão na tela	
			echo "<a href='$arquivo_php?id_documentador=$id_documentador'> <p>- Destino: <b> $row1[0]</b><br> 
			- $item :<b> $_coluna</b><br>- Mensagem : <b> $mensagem</b><br>- Assinatura : <b> $row2[0]
			</b></a></p></font><br><br>";
			}

	if($pagina == 1)
		{
		echo "<br><td nowrap align=left>
                <a href='buscador_lista.php?id_tipo=$id_tipo&busca=$busca&pagina=$pagina'><br><span class=b>
                <b>Pr\xf3xima</b></span></a>";
                }
        else
                {
                echo "<td nowrap align=right><a href='buscador_lista.php?id_tipo=$id_tipo&busca=$busca&pagina=$paginamenosum'>
                <br><span class=b><b>Anterior</b></span></a><br>
                <td nowrap align=left>
                <a href='buscador_lista.php?id_tipo=$id_tipo&busca=$busca&pagina=$pagina'><br><span class=b>
                <b>Pr\xf3xima</b></span></a>";
                }

	}
	
?>

<?php require "menu.php"; ?>
</body></head></html>
