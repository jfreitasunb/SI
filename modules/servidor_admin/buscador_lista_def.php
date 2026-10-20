<?php require("head_admin.php"); ?>
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
$id_tipo=$_POST['id_tipo'];
$id_departamento=$_POST['destino'];
$assunto=$_POST['assunto'];
$numerodocumento=$_POST['numerodocumento'];
$mes=$_POST['mes'];
$ano=$_POST['ano'];
$unbdoc=$_POST['unbdoc']."/".$_POST['ano_unbdoc'];
}
else{
$busca=$_GET['busca'];
$id_tipo=$_GET['id_tipo'];
$id_departamento=$_GET['destino'];
$assunto=$_GET['assunto'];
$numerodocumento=$_GET['numerodocumento'];
$mes=$_GET['mes'];
$ano=$_GET['ano'];
$unbdoc=$_GET['unbdoc']."/".$_GET['ano_unbdoc'];
}

if($busca=="Buscar") {

	$tabela="admin_documentador";
	$arquivo_php="operacao_2.php";
	$coluna="numerodocumento";
	$item="N?ero do documento";
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
		<p> Os seguintes documentos foram encontrados. Para edit?los clique no link referente.</p><br>";
	}

//busca pelos documentos a partir do "tipo" especificado.
$selecione_o_que="id_tipo=".db_quote($id_tipo);
if (!empty($id_departamento)) $selecione_o_que.=" and id_departamento=   (select id_departamento from admin_departamento where nomedepartamento= ".db_quote($id_departamento).")  ";
if (!empty($assunto)) $selecione_o_que.=" and assunto like ".db_quote('%'.$assunto.'%');
if (!empty($numerodocumento)) $selecione_o_que.=" and numerodocumento=".db_quote($numerodocumento);
if (!empty($ano) and !empty($mes)) $selecione_o_que.=" and data like ".db_quote('%'.$mes.'/'.$ano);
if (!empty($ano) and empty($mes)) $selecione_o_que.=" and data like ".db_quote('%'.$ano);
if (empty($ano) and !empty($mes)) $selecione_o_que.=" and data like ".db_quote('%'.$mes)."%";
if (!empty($unbdoc)) 
	{
	$query_unbdoc=db_query("select id_documentador from admin_unbdoc where unbdoc=?", array($unbdoc));
	$id_documnetador_0=db_fetch_row($query_unbdoc);
	$id_documnetador=$id_documnetador_0[0];
	if (!empty($id_documnetador_0)) $selecione_o_que.=" and id_documentador=".db_quote($id_documnetador);
	}


$query_select="SELECT id_documentador,".$coluna.",id_departamento,mensagem,id_assinatura,assinante,assunto FROM ".$tabela." WHERE ".$selecione_o_que." ORDER BY id_documentador DESC LIMIT 10 OFFSET ".(int)$xpagina;

//echo "id_tipo=".$id_tipo;
//echo "xpagina=".$xpagina;
//echo $query_select;
$resultado=db_query($query_select);
//"SELECT id_documentador,$coluna,id_departamento,mensagem,id_assinatura,assinante,assunto
//      FROM $tabela
//      WHERE $selecione_o_que 
//      ORDER BY id_documentador DESC
//      LIMIT 10 OFFSET $xpagina") or die ("N? foi poss?el realizar a consulta ao banco de dados");
$contador=db_num_rows($resultado);

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
	while ($linha=db_fetch_array($resultado))
			{
			$id_documentador0=trim($linha["id_documentador"]);
			$_coluna0=trim($linha[$coluna]);

			if ($id_tipo=="1"){ //memorando, para imprimir o destino
				$id_departamento0=trim($linha["id_departamento"]);
				// busca pelo "destino"
                        	$resultado1=db_query("SELECT nomedepartamento FROM admin_departamento WHERE id_departamento =?", array($id_departamento0));
                        	$row1= db_fetch_row($resultado1,0);
				}

			if ($id_tipo!="5"){ //se n? for 'ata', imprimir mensagem e assinatura
				$mensagem0=trim($linha["mensagem"]);
				$assinatura0=trim($linha["id_assinatura"]);
				$assinante0=trim($linha["assinante"]);
				// busca pelo "nome" e "cargo" de assinatura
				$resultado2=db_query("SELECT cargo FROM admin_assinatura WHERE id_assinatura = ?", array($assinatura0));
				$row2= db_fetch_row($resultado2,0);
				$resultado21=db_query("SELECT name, firstname FROM users WHERE coduser = ?", array($assinante0));
				$row21= db_fetch_row($resultado21,0);

				if ($id_tipo!="4") //se n? for 'ato', acrescentar assunto
					$assunto0=trim($linha["assunto"]);
				}


			//impress? na tela
			if($id_tipo=="1")//memorando
				echo "<a href='$arquivo_php?id_documentador=$id_documentador0&acao2=$visual'> <p> - $item :<b>
				$_coluna0</b><br>
				- Destino: <b> $row1[0]</b><br>- Assunto : <b> $assunto0</b><br>- Mensagem : <b> $mensagem0</b><br>
				- Assinatura : <b> $row21[0] $row21[1]</b><b> $row2[0]
				</b></a></p></font><br><br>";
			else if($id_tipo=="2")//circular
				 echo "<a href='$arquivo_php?id_documentador=$id_documentador0&acao2=$visual'> <p> - $item :<b>
				$_coluna0</b><br>
                                - Assunto : <b> $assunto0</b><br>- Mensagem : <b> $mensagem0</b><br>
                                - Rementente : <b> $row21[0] $row21[1]</b><b> $row2[0]
                                </b></a></p></font><br><br>";
			else if(($id_tipo=="3")||($id_tipo=="6"))//of?io interno ou externo
				 echo "<a href='$arquivo_php?id_documentador=$id_documentador0&acao2=$visual'> <p> - $item :<b>
				$_coluna0</b><br>
                                - Assunto : <b> $assunto0</b><br>- Mensagem : <b> $mensagem0</b><br>
                                - Assinatura : <b> $row21[0] $row21[1]</b><b> $row2[0]
                                </b></a></p></font><br><br>";
			else if($id_tipo=="4")//ato
				 echo "<a href='$arquivo_php?id_documentador=$id_documentador0&acao2=$visual'> <p> - $item :<b>
				$_coluna0</b><br>
                                - Mensagem : <b> $mensagem0</b><br>
                                - Assinatura : <b> $row21[0] $row21[1]</b><b> $row2[0]
                                </b></a></p></font><br><br>";
			else if($id_tipo=="5")//ata
				 echo "<a href='$arquivo_php?id_documentador=$id_documentador0&acao2=$visual'> <p> - $item :<b>
				$_coluna0</b><br>
                                </b></a></p></font><br><br>";
			}

	if($pagina == 1)
		{
		echo "<br><td nowrap align=left>
                <a href='buscador_lista_def.php?id_tipo=".$id_tipo."&busca=".$busca."&pagina=".$pagina."&numerodocumento=".$numerodocumento."&id_departamento=".$id_departamento."&assunto=".$assunto."&ano=".$ano."&mes=".$mes."'><br><span class=b>
                <b>Pr\xf3xima</b></span></a>";
                }
        else
                {
                echo "<td nowrap align=right><a href='buscador_lista_def.php?id_tipo=".$id_tipo."&busca=".$busca."&pagina=".$paginamenosum."'>
                <br><span class=b><b>Anterior</b></span></a><br>
                <td nowrap align=left>
                <a href='buscador_lista_def.php?id_tipo=".$id_tipo."&busca=".$busca."&pagina=".$pagina."&numerodocumento=".$numerodocumento."&id_departamento=".$id_departamento."&assunto=".$assunto."&ano=".$ano."&mes=".$mes."'><br><span class=b>
                <b>Pr\xf3xima</b></span></a>";
                }

	}
?>
</body></head></html>
