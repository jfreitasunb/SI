<?PHP

include("head_oferta.php");
/* CORRIGE LISTA DE OFERTAS DO SEMESTRE/ANO:
1- entrar com semestre e ano;
2- mostrar a lista ordenada por disciplina: 
	deve ser possível selecionar uma discilina/turma para trocar o professor ou para eliminar a disciplina
3- alterar banco
4- voltar para o item 2 até que seja teclado "sair"
*/
// funcoes novas em 21/04/2014:

function corrige_codigo_turmas_magistral($semestre,$ano)
{
// roda no fim da rotina que roda a lista;
// no final da elaboração da lista, a tabela é corrigida par poder ser impressa e apresentada ao colegiado:
$seleciona_magistral=pg_query("select codigo from  oferta_disciplinas_magistral where semestre='".$semestre."' and ano='".$ano."'") or die("problema 02 em muda_horarios_turmas_magistral");

// para cada linha de $seleciona_magistral, muda o código da disciplina teoria:
while($turma=pg_fetch_row($seleciona_magistral))
{

$muda_codigo="update oferta_lista_de_ofertas_nova set codigo='".$turma[0]."' where codigo='".$turma[0]."001' and semestre='".$semestre."' and ano='".$ano."'";

$query_muda_codigo=pg_query($muda_codigo) or die("problema 05 em muda_horarios_turmas_magistral");

} //fim do do while
} // fim da funcao corrige_codigo_turmas_magistral
//


?>

<html>
  <header>
    <link type="text/css" rel="stylesheet" href="../../global/grafic.css">
<meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
  </header>

<?

if (!isset($_POST['registra']) and !isset($_POST['registra2']))
{
$query_acusa_lista=pg_query("select * from oferta_acusa_lista where encaminhada='nova' order by ano desc,semestre desc");

?>
  <body>
      <table class=big>
   <form method="POST" name="formu" action="submeter_lista_SAA.php">
      <tr>
        <td class=header align=center colspan=2>
        <h1>Submiss&atilde;o da Lista de Oferta de Disciplinas</h1>
        </td>
      </tr>

<tr><td>Escolha a lista:
        </select>
        <select name='lista'>
        <?
        while ($registro=pg_fetch_row($query_acusa_lista))
        {
        ?>
        <option name='lista' value="<?echo $registro[0]."_".$registro[1];?>"> <? echo $registro[0];?> &ordm;/ <? echo $registro[1];?></option>
        <?
        }
        ?>
        </tr>
        <td align=center>
        <input type=submit name='registra' value="Confirmar op&ccedil;&otilde;es">
        </td>
        </tr>
        </table>
        </form>
        </BODY>
<?
}

if (isset($_POST['registra']) and !isset($_POST['registra2']))
{

$lista=explode("_",$_POST['lista']);
$semestre=$lista[0];
$ano=$lista[1];
//$tabela="oferta_lista_de_ofertas_".$lista[0]."_".$lista[1];
?>
<body>
      <table class=big>
   	<form method="POST" name="formu" action="submeter_lista_SAA.php">
      <tr>
        <td class=header align=center colspan=2>
        <h1>Submiss&atilde;o da Lista de Oferta de Disciplinas</h1>
        </td>
      </tr>
<tr><td><b>Voc&ecirc; est&aacute; submetendo a lista de ofertas do <?echo $semestre;?>/<? echo $ano;?></b></td></tr>
<tr><td><b>Uma vez confirmada esta opera&ccedil;&atilde;o, s&oacute; ser&aacute; poss&iacute;vel modificar a lista de ofertas SIGRA</b></td></tr>
	</table>
	</td>
	</tr>
	<tr>
	<td align=center>
	
	<input type=submit name='registra2' value="Confirmar submiss&ccedil;&atilde;o">
	
	<input type=hidden name='semestre' value="<? echo $semestre;?>">
	<input type=hidden name='ano' value="<? echo $ano;?>">
	</td>
	</tr>
	</form>
	</table>
	</BODY>
	</HTML>
<?
}

if (!isset($_POST['registra']) and isset($_POST['registra2']))
{


$semestre=$_POST['semestre'];
$ano=$_POST['ano'];
//$tabela="oferta_lista_de_ofertas_".$semestre."_".$ano;

	
	$query_encaminhada=pg_query("update oferta_acusa_lista set encaminhada='SAA' where ano='".$ano."' and semestre='".$semestre."'");
	// copia a lista provisoria para a lista definitiva que sera atualizada pelas correcoes feitas no SIGRA:
//oferta_lista_de_ofertas:   disciplina | turma | turno | professor | semestre | ano  |  horarios 
//oferta_lista_de_ofertas_nova:  codigo | turma | vagas |  turno  |  horarios  | salas | reserva | status | professor | elimina | semestre | ano
 	$limpa_provisoria_na_definitiva="delete from oferta_lista_de_ofertas where semestre='".$semestre."' and ano='".$ano."'";
	$res_limpa=pg_query($limpa_provisoria_na_definitiva);
	corrige_codigo_turmas_magistral($semestre,$ano);// em 21/04/2014
//	$insere_provisoria_na_definitiva="insert into oferta_lista_de_ofertas (disciplina,turma,turno,professor,semestre,ano,horarios) select codigo,turma,turno,professor,'".$semestre."','".$ano."',horarios from oferta_lista_de_ofertas_nova where semestre='".$semestre."' and ano='".$ano."' and elimina='nao'";
//	echo $insere_provisoria_na_definitiva;
//	$res_insere=pg_query($insere_provisoria_na_definitiva)  or die ("Problema de acesso ao banco");	 nao se substitui  lista de ofertas porque nao faz mais sentido.
	

echo "A lista de ofertas do ".$semestre."/".$ano." foi finalizada. As correcoes devem ser efetuadas no SIGRA"; 
}

	pg_close($idconn);

?>


