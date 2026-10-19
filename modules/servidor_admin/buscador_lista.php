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
$resultado=pg_query("SELECT id_documentador,$coluna,id_departamento,mensagem,id_assinatura,assinante,assunto
      FROM $tabela
      WHERE id_tipo='$id_tipo'
      ORDER BY id_documentador DESC
      LIMIT 10 OFFSET $xpagina") or die ("N? foi poss?el realizar a consulta ao banco de dados");
$contador=pg_num_rows($resultado);

//mostrar na tela o resultado.
if ($contador == 0)
	{
	if($pagina>1)
		echo " <p> <b><i>Observa?o: pesquisa finalizada. N? h?mais documentos registrados.</i></b></p>";
	else
		echo " <p> <b><i>N? h?documentos registrados.</i></b></p>";
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

			if ($id_tipo=="1"){ //memorando, para imprimir o destino
				$id_departamento=trim($linha['id_departamento']);
				//print_r($linha);
				//die();
				// busca pelo "destino"
				if ($id_departamento!="")
				{
				$query1="SELECT nomedepartamento FROM admin_departamento WHERE id_departamento ='".$id_departamento."'";
                        	$resultado1=pg_query($query1) or die("N? foi poss?el executar a opera?o. Contacte a Coordena?o de
                         	Inform?ica.");
                        	$row1=pg_fetch_row($resultado1);
				}
				else $row1[0]="";
				}
			if ($id_tipo!="5"){ //se n? for 'ata', imprimir mensagem e assinatura
				$mensagem=trim($linha['mensagem']);
				$assinatura=trim($linha['id_assinatura']);
				$assinante=trim($linha['assinante']);
//print "linha= ".print_r($linha)."--///--";
				// busca pelo "nome" e "cargo" de assinatura
				if ($assinatura!="")
				{
				$query2="SELECT cargo FROM admin_assinatura WHERE id_assinatura = '".$assinatura."'";
				$resultado2=pg_query($query2) or die("N? foi poss?el executar a opera?o. Contacte a Coordena?o de Inform?ica.");
				$row2= pg_fetch_row($resultado2);
				}
				else $row2[0]="";
				if ($assinante!="")
				{
				$query21="SELECT name, firstname FROM users WHERE coduser = '".$assinante."'";
				$resultado21=pg_query($query21) or die("N? foi poss?el executar a opera?o. Contacte a Coordena?o de Inform?ica.");
				$row21= pg_fetch_row($resultado21);
				}
				else 
				{
				$row21[0]="";
				$row21[1]="";
				}
				//if ($id_tipo!="4") //se n? for 'ato', acrescentar assunto
				//	$assunto=trim($linha["assunto"]);
				}
			$assunto=trim($linha['assunto']);

			//impress? na tela
			if($id_tipo=="1")//memorando
				echo "<a href='$arquivo_php?id_documentador=$id_documentador&acao2=$visual'> <p> - $item :<b>
				$_coluna</b><br>- Destino: <b> $row1[0]</b><br>- Assunto : <b> $assunto</b><br>- Mensagem : <b> $mensagem </b><br>
				- Assinatura : <b> $row21[0] $row21[1]</b><b> $row2[0]</b></a></p></font><br><br>";
			else if($id_tipo=="2")//circular
				 echo "<a href='$arquivo_php?id_documentador=$id_documentador&acao2=$visual'> <p> - $item :<b>
				$_coluna</b><br>
                                - Assunto : <b> $assunto</b><br>- Mensagem : <b> $mensagem</b><br>
                                - Rementente : <b> $row21[0] $row21[1]</b><b> $row2[0]
                                </b></a></p></font><br><br>";
			else if(($id_tipo=="3")||($id_tipo=="6"))//of?io interno ou externo
				 echo "<a href='$arquivo_php?id_documentador=$id_documentador&acao2=$visual'> <p> - $item :<b>
				$_coluna</b><br>
                                - Assunto : <b> $assunto</b><br>- Mensagem : <b> $mensagem</b><br>
                                - Assinatura : <b> $row21[0] $row21[1]</b><b> $row2[0]
                                </b></a></p></font><br><br>";
			else if($id_tipo=="4")//ato
				 echo "<a href='$arquivo_php?id_documentador=$id_documentador&acao2=$visual'> <p> - $item :<b>
				$_coluna</b><br>
                                - Assunto : <b> $assunto</b><br>
                                - Mensagem : <b> $mensagem</b><br>
                                - Assinatura : <b> $row21[0] $row21[1]</b><b> $row2[0]
                                </b></a></p></font><br><br>";
			else if($id_tipo=="5")//ata
				 echo "<a href='$arquivo_php?id_documentador=$id_documentador&acao2=$visual'> <p> - $item :<b>
				$_coluna</b><br>
                                - Assunto : <b> $assunto</b><br>
                                </b></a></p></font><br><br>";
			$i=$i+1;
			}

	if($pagina == 1)
		{
		echo "<br><td nowrap align=left>
                <a href='buscador_lista.php?id_tipo=".$id_tipo."&busca=".$busca."&pagina=".$pagina."'><br><span class=b>
                <b>Pr\xf3xima</b></span></a>";
                }
        else
                {
                echo "<td nowrap align=right><a href='buscador_lista.php?id_tipo=".$id_tipo."&busca=".$busca."&pagina=".$paginamenosum."'>
                <br><span class=b><b>Anterior</b></span></a><br>
                <td nowrap align=left>
                <a href='buscador_lista.php?id_tipo=".$id_tipo."&busca=".$busca."&pagina=".$pagina."'><br><span class=b>
                <b>Pr\xf3xima</b></span></a>";
                }
	}
?>
</body></head></html>
