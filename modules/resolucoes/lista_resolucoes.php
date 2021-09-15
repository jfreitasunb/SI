<?php include("head_resolucoes.php"); ?>
<html>
<header>
    <script language=javascript src="function_js.js">
    </script>
    <script language=javascript src="formu.js">
    </script>
    <link type="text/css" rel="stylesheet" href="../../global/grafic.css">
<meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
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
}
else{
$busca=$_GET["busca"];
}

$arquivo_php="edita_resolucoes.php";
// if($busca=="Buscar") {


// 	$tabela="admin_documentador";
// 	$arquivo_php="operacao_2.php";
// 	$coluna="numerodocumento";
// 	$item="N?ero do documento";
// 	echo "

//         	<h1>Buscar Documento</h1>
// 		<p> Os seguintes documentos foram encontrados. Para visualizar em formato <i>.pdf</i> o documento completo, clique no link referente.</p><br>";
// 	}
// else {
// 	$tabela="admin_rascunho";
// 	$arquivo_php="editar.php";
// 	$coluna="data";
// 	$item="Data";
// 	
//busca pelos documentos a partir do "tipo" especificado.


echo " <h1>Editar Documento</h1>
 	<p> Os seguintes documentos foram encontrados. Para edit&aacute;-los clique no link referente.</p><br>";


		$tabela = "admin_resolucoes_colegiado";
		$resultado=pg_query("SELECT codigo,data_reuniao,numero_reuniao,assunto_resolucao,texto_resolucao,assinante
      		FROM $tabela WHERE submetido='FALSE'
      		ORDER BY numero_reuniao desc,data_reuniao desc
      		LIMIT 10 OFFSET $xpagina") or die ("N? foi poss?el realizar a consulta ao banco de dados");
		//$coluna="codigo";


$contador=pg_num_rows($resultado);

//mostrar na tela o resultado.
if ($contador == 0)
	{
	if($pagina>1)
		echo " <p> <b><i>Observa&ccedil;&atilde;o: pesquisa finalizada. N&atilde;o h&aacute; mais documentos registrados.</i></b></p>";
	else
		echo " <p> <b><i>N&atilde;o h&aacute; registrados.</i></b></p>";
	echo "<br><p align='center'><a href='javascript:history.back();'>Retornar</a></p>";
	}
else
	{
	$i=0;
	while ($i<$contador)
			{
			$linha=pg_fetch_array($resultado,$i);
			$id_documentador=trim($linha["id_documentador"]);
			$_coluna=trim($linha[$coluna]);
			
			
			$id_documentador = trim($linha['codigo']);
			$data_reuniao = trim($linha['data_reuniao']);
			$numero_reuniao = trim($linha['numero_reuniao']);
			$assunto_resolucao = trim($linha['assunto_resolucao']);
			$assinante = $linha['assinante'];

				if ($assinante!="") {
					$query21="SELECT name, firstname FROM users WHERE coduser = '".$assinante."'";
					$resultado21=pg_query($query21) or die("N? foi poss?el executar a opera?o. Contacte a Coordena?o de Inform?ica.");
					$row21= pg_fetch_row($resultado21);
					$assinatura=trim($linha['id_assinatura']);
					$assinante=trim($linha['assinante']);
				}else{
					$row21[0]="";
					$row21[1]="";
				}

				 echo "<a href='$arquivo_php?id_documentador=$id_documentador&acao2=$visual'>
				  <p>
                        		- Data da reuni&atilde;o: <b> $data_reuniao</b><br>
                        		- N&uacute;mero da reuni&atilde;o: <b> $numero_reuniao</b><br>
                        		- Assunto da resolu&ccedil;&atilde;o: <b> $assunto_resolucao</b><br>
                                - Assinatura: <b> $row21[0] $row21[1]</b><b> $row2[0]
                                </b></a></p></font><br><br>";
			$i=$i+1;
			}

	if($pagina == 1)
		{
		echo "<br><td nowrap align=left>
                <a href='lista_resolucoes.php?id_tipo=".$id_tipo."&busca=".$busca."&pagina=".$pagina."'><br><span class=b>
                <b>Pr&oacute;xima</b></span></a>";
                }
        else
                {
                echo "<td nowrap align=right><a href='lista_resolucoes.php?id_tipo=".$id_tipo."&busca=".$busca."&pagina=".$paginamenosum."'>
                <br><span class=b><b>Anterior</b></span></a><br>
                <td nowrap align=left>
                <a href='lista_resolucoes.php?id_tipo=".$id_tipo."&busca=".$busca."&pagina=".$pagina."'><br><span class=b>
                <b>Pr&oacute;xima</b></span></a>";
                }
	}
?>
</body></head></html>
