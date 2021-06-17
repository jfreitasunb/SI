<?PHP // Inclusao de disciplinas magistrais
include("head_magistral.php");

?>
<html>
  <header>
    <link type="text/css" rel="stylesheet" href="../../global/grafic.css">
<meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
  </header>


<?
//print_r($_POST);
if (isset($_POST['registra'])  and isset($_POST['submit']))
{
$dados=$_POST['dados'];
$codigo_explodido=explode("_",$dados['nova_magistral']);
$lista=$_POST['lista'];
$soma=$codigo_explodido[1]-$dados['creditos_teoria']-$dados['creditos_exos'];
if (($dados['nova_magistral']!=0) and ($dados['creditos_teoria']!=0) and ($dados['creditos_exos']!=0) and ($soma==0)) 
	{
	$checa_disciplina=pg_query("select * from oferta_disciplinas_magistral where codigo='".$codigo_explodido[0]."' and semestre='".$lista[0]."' and ano='".$lista[1]."'");
	if (pg_num_rows($checa_disciplina)!=0) 
		$query_insere="update oferta_disciplinas_magistral set teoria='".$dados['creditos_teoria']."', exercicios='".$dados['creditos_exos']."' where codigo='".$codigo_explodido[0]."' and semestre='".$lista[0]."' and ano='".$lista[1]."'"; 
	else 
		$query_insere="insert into oferta_disciplinas_magistral values('".$codigo_explodido[0]."','".$dados['creditos_teoria']."','".$dados['creditos_exos']."','".$lista[0]."','".$lista[1]."')";
//	echo $query_insere;
	$res_insere=pg_query($query_insere) or die("problema de conexao 1 em magistral_cria_disciplina.php");
	echo "disciplina ".$codigo_explodido[0]." inserida.";
	}

}

if (isset($_POST['registra']) and !isset($_POST['submit']))
{
$lista_post=$_POST['semestre']."_".$_POST['ano'];

$lista=explode("_",$lista_post);

$checa_lista=pg_query("select encaminhada from oferta_acusa_lista where semestre='".$lista[0]."' and ano='".$lista[1]."'");
$checa_lista_num=pg_num_rows($checa_lista);

if($checa_lista_num==0)
{
if($_POST['aproveita']=="sim") // corrigido em 20/12/2014
{
if($lista[0]==1) {$semestre_anterior=2;$ano_anterior=$lista[1]-1;} 
if($lista[0]==2) {$semestre_anterior=1;$ano_anterior=$lista[1];}
// limpa as tabelas de dados do semestre corrente
$query_limpa_disc_mag=pg_query("delete from oferta_disciplinas_magistral where semestre='".$lista[0]."' and ano='".$lista[1]."'");
//echo "delete from oferta_disciplinas_magistral where semestre='".$lista[0]."' and ano='".$lista[1]."'<br>";
$query_limpa_grupos_mag=pg_query("delete from oferta_grupos_magistral_teoria where semestre='".$lista[0]."' and ano='".$lista[1]."'");
//echo "delete from oferta_grupos_magistral_teoria where semestre='".$lista[0]."' and ano='".$lista[1]."'<br>";

$query_disc_mag=pg_query("select * from oferta_disciplinas_magistral where semestre='".$semestre_anterior."' and ano='".$ano_anterior."'"); 
while($dados0=pg_fetch_row($query_disc_mag))
{
$query_insere=pg_query("insert into oferta_disciplinas_magistral values('".$dados0[0]."','".$dados0[1]."','".$dados0[2]."','".$lista[0]."','".$lista[1]."')");
//echo "insert into oferta_disciplinas_magistral values('".$dados0[0]."','".$dados0[1]."','".$dados0[2]."','".$lista[0]."','".$lista[1]."')<br>";
}
$query_grupos_mag=pg_query("select * from oferta_grupos_magistral_teoria where semestre='".$semestre_anterior."' and ano='".$ano_anterior."'"); 
while($dados0=pg_fetch_row($query_grupos_mag))
{
$query_insere=pg_query("insert into oferta_grupos_magistral_teoria values('".$dados0[0]."','".$dados0[1]."','".$dados0[2]."','".$dados0[3]."','".$dados0[4]."','".$lista[0]."','".$lista[1]."')");
//echo "insert into oferta_grupos_magistral_teoria values('".$dados0[0]."','".$dados0[1]."','".$dados0[2]."','".$dados0[3]."','".$dados0[4]."','".$lista[0]."','".$lista[1]."')<br>";
}

}

$query_magistral=pg_query("select nome, m.codigo, m.teoria, m.exercicios,d.creditos from disciplinas_mat d, oferta_disciplinas_magistral m where d.codigo=m.codigo and semestre='".$lista[0]."' and ano='".$lista[1]."' order by nome") or die("problema de conexao 01");

$query_disciplinas=pg_query("select codigo,nome, creditos from disciplinas_mat where status='grad' order by nome") or die("problema de conexao 02");

?>
  <body>
      <table class=big>
   <form method="POST" name="formu" action="magistral_cria_disciplina.php">
      <tr>
        <td class=header align=center colspan=2>
        <h1>Inclus&atilde;o de discilpinas com esuqema magistral</h1>
        </td>
      </tr>
      <tr><td align=center><table border>
				<tr><td><b>C&oacute;digo</b></td><td><b>Disciplina</b></td><td><b>Cr&eacute;ditos totais</b></td><td><b>Cr&eacute;ditos teoria</b></td><td><b>Cr&eacute;ditos exerc&iacute;cios</b></td></tr>
		<?
                while ($registro_1=pg_fetch_row($query_magistral))
                      {
                      echo "<tr><td>".$registro_1[1]."</td><td>".$registro_1[0]."</td><td>".$registro_1[4]."</td><td>".$registro_1[2]."</td><td>".$registro_1[3]."</td><td></tr>";  
                      }
		?>
	</td>                      
        </tr>
	</TABLE>
        <tr>
	<td>Incluir nova discilpina/corrigir dados da disciplina: <select name='dados[nova_magistral]'> 
						  <option value=0> ------- </option>
						  <?
				                  while ($registro_2=pg_fetch_row($query_disciplinas))
                      					{
				                        echo "<option value=".$registro_2[0]."_".$registro_2[2].">".$registro_2[1]."  (".$registro_2[2].")</option>";  
					                }
				                  ?>
						  </select>Cr&eacute;ditos te&oacute;ricos: <select name='dados[creditos_teoria]'><option value=0>0</option>
																	   <option value=2>2</option>
																	   <option value=4>4</option>
																	   <option value=6>6</option>
												      </select>
								Cr&eacute;ditos exerc&iacute;cios: <select name='dados[creditos_exos]'><option value=0>0</option>
																	   <option value=2>2</option>
																	   <option value=4>4</option>
																	   <option value=6>6</option>
												      </select></td>

	<tr>
	<td align=center>
	<input type=hidden name='lista' value="<? echo $lista;?>">
	<input type=hidden name='registra' value="Confirmar op&ccedil;&otilde;es">
	<input type=submit name='submit' value="Confirmar op&ccedil;&otilde;es">
	</td>
	</tr>
	</form>
	</table>
	</BODY>
	</HTML>
<?
}
}



if(!isset($_POST['registra']))
{
?>

<html>
  <header>
    <link type="text/css" rel="stylesheet" href="../../global/grafic.css">
<meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
  </header>
<?
// Escolhe semestre e ano:


$query_acusa_lista=pg_query("select * from oferta_acusa_lista where encaminhada='nova' order by ano desc, semestre desc");
?>
  <body>
      <table class=big>
      <form method="POST" name="formu" action="magistral_cria_disciplina.php">
         <tr>
        <td class=header align=center colspan=2>
        <h1> Lista de Ofertas do MAT </h1>
        </td>
      </tr>
      <tr><td>Escolha o semestre: <input type=text name='semestre' size=1></td></tr>
      <tr><td>Escolha o ano: <input type=text name='ano' size=1></td></tr>
	<tr><td><b>Voc&ecirc; deseja aproveitar a distribui&ccedil;&atilde;o do semestre passado? <input type=radio name='aproveita' value="sim" > sim / <input type=radio name='aproveita' checked value="nao" > n&atilde;o</b></td></>
	<tr>
        <td align=center>
        <input type=submit name='registra' value="Confirmar op&ccedil;&otilde;es">
        </td>
        </tr>
        </table>
        </form>
        </BODY>
</html>
<?
}
pg_close($idconn);
?>

