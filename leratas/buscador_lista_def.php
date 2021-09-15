<?php include("head_admin.php"); ?>
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
$id_tipo=5;

if (strlen($_POST['chave'])==0) $chave=""; else $chave=" and mensagem like '%".$_POST['chave']."%'";

if(strlen($_POST['numeroreuniao'])==0) $numeroreuniao=""; else $numeroreuniao="%".$_POST['numeroreuniao']."%";
if (strlen($_POST['dia'])==0) {$dia=""; $dd=0;} else {$dia=$_POST['dia']; $dd=1;}
if (strlen($_POST['mes'])==0) {$mes=""; $dm=0;} else {$mes=$_POST['mes']; $dm=1;}
if (strlen($_POST['ano'])==0) {$ano=""; $da=0;} else {$ano=$_POST['ano']; $da=1;}
if ($numeroreuniao=="")
{
if (($dd==0) and ($dm==0) and ($da==0)) $assunto="";
if (($dd==0) and ($dm==0) and ($dd==1)) $assunto=" and assunto like '%/".$ano."%'";
if (($dd==0) and ($dm==1) and ($dd==1)) $assunto=" and assunto like '%/".$mes."/".$ano."%'";
if (($dd==1) and ($dm==1) and ($dd==1)) $assunto=" and assunto like '%".$dia."/".$mes."/".$ano."%'";
if (($dd==0) and ($dm==1) and ($dd==0)) $assunto=" and assunto like '%/".$mes."/%'";
if (($dd==1) and ($dm==0) and ($dd==0)) $assunto=" and assunto like '%".$dia."/%'";
if (($dd==1) and ($dm==1) and ($dd==0)) $assunto=" and assunto like '%".$dia."/".$mes."/%'";
if (($dd==1) and ($dm==0) and ($dd==1)) $assunto=" and assunto like '%".$dia."/%/".$ano."%'";
}
if ($numeroreuniao!="")
{
$assunto1=" and (assunto like '%".$numeroreuniao."%' or assunto like ";
if (($dd==0) and ($dm==0) and ($da==0)) $assunto=" and assunto like '%".$numeroreuniao."%'";
if (($dd==0) and ($dm==0) and ($dd==1)) $assunto=$assunto1." '%/".$ano."%')";
if (($dd==0) and ($dm==1) and ($dd==1)) $assunto=$assunto1." '%/".$mes."/".$ano."%')";
if (($dd==1) and ($dm==1) and ($dd==1)) $assunto=$assunto1." '%".$dia."/".$mes."/".$ano."%')";
if (($dd==0) and ($dm==1) and ($dd==0)) $assunto=$assunto1." '%/".$mes."/%')";
if (($dd==1) and ($dm==0) and ($dd==0)) $assunto=$assunto1." '%".$dia."/%')";
if (($dd==1) and ($dm==1) and ($dd==0)) $assunto=$assunto1." '%".$dia."/".$mes."/%')";
if (($dd==1) and ($dm==0) and ($dd==1)) $assunto=$assunto1." '%".$dia."/%/".$ano."%')";
}


if($busca=="Buscar") {

	$tabela="admin_documentador";
	$arquivo_php="operacao_2.php";
//	$coluna="numerodocumento";
	$coluna="assunto";
//	$item="Numero do documento";
	$item="Ata: ";
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
$selecione_o_que="id_tipo='".$id_tipo."'";
$selecione_o_que.=$assunto;
$selecione_o_que.=$chave;

$query_select="SELECT id_documentador,mensagem,assunto FROM ".$tabela." WHERE ".$selecione_o_que." ORDER BY id_documentador DESC LIMIT 10 OFFSET ".$xpagina;
//echo $query_select;
//echo "id_tipo=".$id_tipo;
//echo "xpagina=".$xpagina;
//echo $query_select;
$resultado=pg_query($query_select)  or die ("Nao foi possivel realizar a consulta ao banco de dados");
//"SELECT id_documentador,$coluna,id_departamento,mensagem,id_assinatura,assinante,assunto
//      FROM $tabela
//      WHERE $selecione_o_que  
//      ORDER BY id_documentador DESC
//      LIMIT 10 OFFSET $xpagina") or die ("N? foi poss?el realizar a consulta ao banco de dados");
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
			$id_documentador0=trim($linha["id_documentador"]);
			$_coluna0=trim($linha[$coluna]);

			if ($id_tipo=="1"){ //memorando, para imprimir o destino
				$id_departamento0=trim($linha["id_departamento"]);
				// busca pelo "destino"
                        	$resultado1=pg_query("SELECT nomedepartamento FROM admin_departamento WHERE id_departamento 
='".$id_departamento0."'") or die("N? foi poss?el executar a opera?o. Contacte a Coordena?o de Inform?ica.");
                        	$row1= pg_fetch_row($resultado1,$i);
				}

			if ($id_tipo!="5"){ //se n? for 'ata', imprimir mensagem e assinatura
				$mensagem0=trim($linha["mensagem"]);
				$assinatura0=trim($linha["id_assinatura"]);
				$assinante0=trim($linha["assinante"]);
				// busca pelo "nome" e "cargo" de assinatura
				$resultado2=pg_query("SELECT cargo FROM admin_assinatura WHERE id_assinatura = '$assinatura0'") or
				die("N? foi poss?el executar a opera?o. Contacte a Coordena?o de Inform?ica.");
				$row2= pg_fetch_row($resultado2,$i);
				$resultado21=pg_query("SELECT name, firstname FROM users WHERE coduser = '$assinante0'") or
				die("N? foi poss?el executar a opera?o. Contacte a Coordena?o de Inform?ica.");
				$row21= pg_fetch_row($resultado21,$i);

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
                <b>Pr&oacute;xima</b></span></a>";
                }
        else
                {
                echo "<td nowrap align=right><a href='buscador_lista_def.php?id_tipo=".$id_tipo."&busca=".$busca."&pagina=".$paginamenosum."'>
                <br><span class=b><b>Anterior</b></span></a><br>
                <td nowrap align=left>
                <a href='buscador_lista_def.php?id_tipo=".$id_tipo."&busca=".$busca."&pagina=".$pagina."&numerodocumento=".$numerodocumento."&assunto=".$assunto."&$dia=".$dia."&ano=".$ano."&mes=".$mes."'><br><span class=b>
                <b>Pr&oacute;xima</b></span></a>";
                }

	}
pg_close($con);
}
?>
</body></head></html>
