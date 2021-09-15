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

//if ($pagina=="1")
if (isset($_POST['busca']))
{
$busca=$_POST['busca'];
$ata=$_POST['ata'];
$assunto=$_POST['assunto'];
$numero_resolucao=$_POST['numero_resolucao'];
$ano_resolucao=$_POST['anoresolucao'];
}
else{
$busca=$_GET['busca'];
$ata=$_GET['ata'];
$assunto=$_GET['assunto'];
$numero_resolucao=$_GET['numero_resolucao'];
$ano_resolucao=$_GET['anoresolucao'];
}

if($busca=="Buscar") {

	$tabela="admin_resolucoes_colegiado";
	$arquivo_php="operacao_2.php";
	//$coluna="numero_resolucao";
	$item="N&uacute;mero da resolu&ccedil;&atilde;o";
	echo "

        	<h1>Buscar Documento</h1>
		<p> Os seguintes documentos foram encontrados. Para visualizar em formato <i>.pdf</i> o documento completo, clique no link referente.</p><br>";
	}
else {
	echo "
		<h1>Editar Documento</h1>
		<p> Os seguintes documentos foram encontrados. Para edit&aacute;los clique no link referente.</p><br>";
	}

//busca pelos documentos a partir do "tipo" especificado.
$selecione_o_que="submetido='TRUE'";
// if (!empty($id_departamento)) $selecione_o_que.=" and id_departamento=   (select id_departamento from admin_departamento where nomedepartamento= 
// '".$id_departamento."')  ";
if (!empty($assunto)) $selecione_o_que.=" and assunto_resolucao like '%".$assunto."%'";
if (!empty($ata)) $selecione_o_que.=" and numero_reuniao='".$ata."'";
if (!empty($numero_resolucao)) $selecione_o_que.=" and numero_resolucao='".$numero_resolucao."'";
if (!empty($ano_resolucao)) $selecione_o_que.=" and data_publicacao::text like '%".$ano_resolucao."%'";


$query_select="SELECT codigo,data_reuniao,numero_reuniao,assunto_resolucao,texto_resolucao,assinante,assinatura,to_char(data_publicacao,'dd/mm/yyyy'),numero_resolucao
      		 FROM ".$tabela." WHERE ".$selecione_o_que." ORDER BY numero_resolucao DESC LIMIT 10 OFFSET ".$xpagina;

$resultado=pg_query($query_select)  or die ("Nao foi possivel realizar a consulta ao banco de dados");
$contador=pg_num_rows($resultado);

//mostrar na tela o resultado.
if ($contador == 0)
	{
	if($pagina>1)
		echo " <p> <b><i>Observa&ccedil;&atilde;o: pesquisa finalizada. N&atilde;o h&aacute; mais documentos registrados.</i></b></p>";
	else
		echo " <p> <b><i>N&atilde;o h&aacute; documentos registrados.</i></b></p>";
	echo "<br><p align='center'><a href='javascript:history.back();'>Retornar</a></p>";
	}
else
	{
	while ($linha=pg_fetch_array($resultado))
			{
				$assunto0 = trim($linha["assunto_resolucao"]);
				$data_reuniao0 = trim($linha["data_reuniao"]);
				$assinatura0=trim($linha["assinatura"]);
				$assinante0=trim($linha["assinante"]);
				$numero_resolucao = trim($linha["numero_resolucao"]);
				// busca pelo "nome" e "cargo" de assinatura
				$resultado2=pg_query("SELECT cargo FROM admin_assinatura WHERE id_assinatura = '$assinatura0'") or
				die("N? foi poss?el executar a opera?o. Contacte a Coordena?o de Inform?ica.");
				$row2= pg_fetch_row($resultado2,$i);
				$resultado21=pg_query("SELECT name, firstname FROM users WHERE coduser = '$assinante0'") or
				die("N? foi poss?el executar a opera?o. Contacte a Coordena?o de Inform?ica.");
				$row21= pg_fetch_row($resultado21,$i);



				echo "<a href='$arquivo_php?numero_resolucao=$numero_resolucao&acao2=$visual'> <p> - $item:<b>
				$numero_resolucao</b><br>
				- Data da resolu&ccedil;&atilde;o: <b> $data_reuniao0</b><br>- Assunto: <b> $assunto0</b><br>
				- Assinatura : <b> $row21[0] $row21[1]</b><b> $row2[0]
				</b></a></p></font><br><br>";
			}


	if($pagina == 1)
		{
		echo "<br><td nowrap align=left>
                <a href='visualiza_resolucoes_finais?busca=".$busca."&pagina=".$pagina."&numero_resolucao=".$numero_resolucao."&ata=".$ata."&assunto=".$assunto."&anoresolucao=".$ano_resolucao."'><br><span class=b>
                <b>Pr&oacute;xima</b></span></a>";
                }
        else
                {
                echo "<td nowrap align=right><a href='visualiza_resolucoes_finais.php?busca=".$busca."&pagina=".$paginamenosum."'>
                <br><span class=b><b>Anterior</b></span></a><br>
                <td nowrap align=left>
                <a href='visualiza_resolucoes_finais.php?busca=".$busca."&pagina=".$pagina."&numero_resolucao=".$numero_resolucao."&ata=".$ata."&assunto=".$assunto."&anoresolucao=".$ano_resolucao."'><br><span class=b>
                <b>Pr&oacute;xima</b></span></a>";
                }

	}
?>
</body></head></html>
