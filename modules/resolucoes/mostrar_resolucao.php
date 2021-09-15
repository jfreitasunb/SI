<?PHP  // Inserir nova ou editar uma resolução
include("head_resolucoes.php");

if(!isset($_POST['confirmar']))
{
$query_resolucoes=pg_query("select codigo,to_char(data_reuniao,'dd/mm/yyyy'),numero_reuniao,assunto_resolucao from admin_resolucoes_colegiado where submetido='TRUE' order by numero_reuniao desc,data_reuniao desc") or die("problema de conexao 1");

?>

<html>
  <header>
    <link type="text/css" rel="stylesheet" href="../../global/grafic.css">
    <meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
  </header>
  <body>
      <table class=big>
      <form method="POST" name="formu" action="mostrar_resolucao.php">
         <tr>
        <td class=header align=center colspan=2>
        <h1> Resolu&ccedil;&otilde;es do MAT </h1>
        </td>
        </tr>
	<tr><td>Selecionar a resolu&ccedil;&atilde;o: <select name='dados[resolucao]'> 
							<option value=0>------</option>
	<?
	while ($registro=pg_fetch_row($query_resolucoes))
		{
		echo "<option value=\"".$registro[0]."\"> Reuni&atilde;o ".$registro[2]."; Assunto: ".$registro[3]."</option>";
		}			

	?>
	</select>
	</td></tr>
	<tr><td>Fazer pesquisa por n&uacute;mero de ata: <input type=text name='dados[numero_reuniao]' maxlength=5 size=4></td></tr>
	<tr><td>Fazer pesquisa por assunto da resolu&ccedil;&atilde;o: <input type=text name='dados[assunto_resolucao]' maxlength=200 size=150></td></tr>
	<tr><td align=center>
        <input type=submit name='confirmar' value="Confirmar">
        </td>
        </tr>
        </table>
        </form>
        </BODY>
</html>
<?
}
if(isset($_POST['confirmar']))
{
$dados=$_POST['dados'];

if($dados['resolucao']!=0) 
	{
//	echo $dados['resolucao'];
	$query_resolucao=pg_query("select to_char(data_reuniao,'dd/mm/yyyy') as datareuniao,numero_reuniao,assunto_resolucao,texto_resolucao from admin_resolucoes_colegiado where codigo='".$dados['resolucao']."'") or die("problema de conexao 2");
	$linha="xx";
	//$mostra_dados=pg_fetch_array($query_resolucao,0);
	}
else 
	{
	if (($dados['numero_reuniao']!="") or ($dados['assunto_resolucao']!=""))
	{
	$linha="select to_char(data_reuniao,'dd/mm/yyyy') as datareuniao,numero_reuniao,assunto_resolucao,texto_resolucao from admin_resolucoes_colegiado where";
	if (($dados['numero_reuniao']!="") and ($dados['assunto_resolucao']!="")) $linha.=" numero_reuniao='".$dados['numero_reuniao']."' or assunto_resolucao like '%".$dados['assunto_resolucao']."%'";  
	if (($dados['numero_reuniao']!="") and ($dados['assunto_resolucao']=="")) $linha.=" numero_reuniao='".$dados['numero_reuniao']."'";
	if (($dados['numero_reuniao']=="") and ($dados['assunto_resolucao']!="")) $linha.=" assunto_resolucao like '%".$dados['assunto_resolucao']."%'";
	$linha.=" order by numero_reuniao desc, data_reuniao desc";
//	echo $linha;
	$query_resolucao=pg_query($linha) or die("problema de conexao 3");
	//$mostra_dados=pg_fetch_all($query_resolucao);
	}
	else $linha="";
	}
	

if($linha=="") 
{
?>
<html>
  <header>
    <link type="text/css" rel="stylesheet" href="../../global/grafic.css">
    <meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
  </header>
  <body>
      <table class=big>
               <tr>
        <td class=header align=center colspan=2>
        <h1> Resolu&ccedil;&otilde;es do MAT </h1>
        </td>
        </tr>
	<tr><td>N&atilde;o h&aacute; dados a serem mostrardos</td></tr>
        </table>
        </BODY>
</html>
<?
}

if($linha!="") 
{
?>
<html>
  <header>
    <link type="text/css" rel="stylesheet" href="../../global/grafic.css">
    <meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
  </header>
  <body>
      <table class=big>
               <tr>
        <td class=header align=center colspan=2>
        <h1> Resolu&ccedil;&otilde;es do MAT </h1>
        </td>
	</tr>
	<?
	while($registro=pg_fetch_row($query_resolucao))
		{
			echo "<tr><td><table>";
			echo "<tr><td> Data da reuni&atilde;o de colegiado: ".$registro[0]." </td></tr>";
			echo "<tr><td> Reuni&atilde;o de colegiado n&uacute;mero: ".$registro[1]." </td></tr>";
			echo "<tr><td> Assunto: ".$registro[2]." </td></tr>";
			echo "<tr><td> Resolu&ccedil;&atilde;o: </td></tr> ";
			echo "<tr><td>".$registro[3]."</td></tr>";
			echo "</table></tr></td>";
		}
	?>
        </table>
        </BODY>
</html>
<?
}

} //fim isset.
	
pg_close($idconn);
?>

