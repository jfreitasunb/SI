<?php include("head_account.php"); ?>
<html>
<header>
    <script language=javascript src="function_js.js">
    </script>
    <script language=javascript src="formu.js">
    </script>
    <link type="text/css" rel="stylesheet" href="../../global/grafic.css">
  </header>
<body>
<table class=big>
      <tr>
        <td class=header align=center>
          <h1>Departamento de Matematica</h1>
        </td>
      </tr>
      <tr>
        <td align=center>
               <title>Servidor Administrativo</title>
<?php
$pagina=$_GET["pagina"];
$xpagina=($pagina)*10;
$paginamenosum=$pagina - 1;
$pagina=$pagina+1;
$visual="Visualizar";

if ($pagina=="1"){
$busca=$_POST["busca"];
$id_tipo=$_POST["id_tipo"];
}
else{
$busca=$_GET["busca"];
$id_tipo=$_GET["id_tipo"];
}

if($busca=="Buscar") {

	$tabela="admin_documentador";
	$arquivo_php="operacao_2.php";
	$coluna="numerodocumento";
	$item="Número do documento";
	echo "

        	<h1>Buscar Documento</h1>
		<p> Os seguintes documentos foram encontrados. Para visualizar em formato <i>.pdf</i> o documento completo, clique no link referente.</p><br>";
	}
else {
	$tabela="admin_rascunho";
	$arquivo_php="editar.php";
	$coluna="data";
	$item="Data";
	echo "
		<h1>Editar Documento</h1>
		<p> Os seguintes documentos foram encontrados. Para editá-los clique no link referente.</p><br>";
	}

//busca pelos documentos a partir do "tipo" especificado.
$resultado=pg_query("SELECT id_documentador,$coluna,id_departamento,mensagem,id_assinatura,assunto
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

			if ($id_tipo=="1"){ //memorando, para imprimir o destino
				$id_departamento=trim($linha["id_departamento"]);
				// busca pelo "destino"
                        	$resultado1=pg_query("SELECT nomedepartamento FROM admin_departamento WHERE id_departamento =
                        	'$id_departamento'") or die("Não foi possível executar a operação. Contacte a Coordenação de
                         	Informática.");
                        	$row1= pg_fetch_row($resultado1,$i);
				}

			if ($id_tipo!="5"){ //se não for 'ata', imprimir mensagem e assinatura
				$mensagem=trim($linha["mensagem"]);
				$assinatura=trim($linha["id_assinatura"]);
				// busca pelo "nome" e "cargo" de assinatura
				$resultado2=pg_query("SELECT nome FROM admin_assinatura WHERE id_assinatura = '$assinatura'") or
				die("Não foi possível executar a operação. Contacte a Coordenação de Informática.");
				$row2= pg_fetch_row($resultado2,$i);
				if ($id_tipo!="4") //se não for 'ato', acrescentar assunto
					$assunto=trim($linha["assunto"]);
				}


			//impressão na tela
			if($id_tipo=="1")//memorando
				echo "<a href='$arquivo_php?id_documentador=$id_documentador&acao2=$visual'> <p> - $item :<b>
				$_coluna</b><br>
				- Destino: <b> $row1[0]</b><br>- Assunto : <b> $assunto</b><br>- Mensagem : <b> $mensagem</b><br>
				- Assinatura : <b> $row2[0]
				</b></a></p></font><br><br>";
			else if($id_tipo=="2")//circular
				 echo "<a href='$arquivo_php?id_documentador=$id_documentador&acao2=$visual'> <p> - $item :<b>
				$_coluna</b><br>
                                - Assunto : <b> $assunto</b><br>- Mensagem : <b> $mensagem</b><br>
                                - Rementente : <b> $row2[0]
                                </b></a></p></font><br><br>";
			else if(($id_tipo=="3")||($id_tipo=="6"))//ofício interno ou externo
				 echo "<a href='$arquivo_php?id_documentador=$id_documentador&acao2=$visual'> <p> - $item :<b>
				$_coluna</b><br>
                                - Assunto : <b> $assunto</b><br>- Mensagem : <b> $mensagem</b><br>
                                - Assinatura : <b> $row2[0]
                                </b></a></p></font><br><br>";
			else if($id_tipo=="4")//ato
				 echo "<a href='$arquivo_php?id_documentador=$id_documentador&acao2=$visual'> <p> - $item :<b>
				$_coluna</b><br>
                                - Mensagem : <b> $mensagem</b><br>
                                - Assinatura : <b> $row2[0]
                                </b></a></p></font><br><br>";
			else if($id_tipo=="5")//ata
				 echo "<a href='$arquivo_php?id_documentador=$id_documentador&acao2=$visual'> <p> - $item :<b>
				$_coluna</b><br>
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
</body></head></html>
