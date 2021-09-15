<?PHP
include("head_oferta.php");
include("funcoes.php");

?>

<html>
  <header>
    <link type="text/css" rel="stylesheet" href="../../global/grafic.css">
<meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
  </header>
<?
// Escolhe semestre e ano:

if (!isset($_POST['registra']))
{

$query_acusa_lista=pg_query("select * from oferta_acusa_lista where encaminhada='nova' order by ano desc, semestre");
?>
  <body>
      <table class=big>
      <form method="POST" name="formu" action="roda_lista.php">
         <tr>
        <td class=header align=center colspan=2>
        <h1> Lista de Ofertas do MAT </h1>
        </td>
      </tr>
      <tr><td><b>Escolha o semestre:</b> 
	<select name='lista'> 
	<?
	while ($registro=pg_fetch_row($query_acusa_lista))
	{
	?>
        <option value="<?echo $registro[0]."_".$registro[1];?>"> <? echo $registro[0];?> &ordm;/ <? echo $registro[1];?></option>
	<?
	}
	?>
	</select>
	</tr>
	<tr><td><b>Limpar tabela de aloca&ccedil;&atilde;o de professores? </b><b>sim (<input type=radio name="limpa_tabela" value="sim">)</b>  <b>N&atilde;o (<input type=radio name="limpa_tabela" value="nao">)<b></td></tr> 
	<td align=center>
	<input type=submit name='registra' value="Confirmar op&ccedil;&otilde;es">
	</td>
	</tr>
	</table>
	</form>
	</BODY>
<?
}

if (isset($_POST['registra']))
{
$periodo=explode("_",$_POST['lista']);
$semestre=$periodo[0];
$ano=$periodo[1];

//$num_acusa_lista=pg_num_rows($query_acusa_lista);

$select_profs=pg_query("select coduser,name,firstname from users where coduser in (select coduser from profs where situacao='ativo') order by name");

//$mes=date(n);
//$semestre=$mes/12;
//if ($semestre<=0.5) $semestre=2; else $semestre=1;
//if ($semestre==1) $ano=date(Y)+1; else $ano=date(Y);
//$tabela="oferta_lista_de_oferta_".$semestre."_".$ano;
$tabela="oferta_lista_de_ofertas_nova";
//.oferta_lista_de_ofertas_1_2012

	//------------ LIMPA DADOS

	$query_limpa_oferta_frequencia_pedidos=pg_query("delete from oferta_frequencia_pedidos where semestre='".$semestre."' and ano='".$ano."'");

	$query_limpa_oferta_organiza_pedidos=pg_query("delete from oferta_organiza_pedidos where semestre='".$semestre."' and ano='".$ano."'");

//	$query_limpa_oferta_lista_de_ofertas=pg_query("delete from oferta_lista_de_ofertas where semestre='".$semestre."' and ano='".$ano."'");

	$query_limpa_oferta_escolha_disciplina=pg_query("update oferta_escolha_disciplina set atendido='nao' where semestre='".$semestre."' and ano='".$ano."'");

	if($_POST['limpa_tabela']=="sim") $query_limpa_oferta_semestre=pg_query("update ".$tabela." set professor='0' where semestre='".$semestre."' and ano='".$ano."'");

	//----------------------------------

	//echo "Organizando pedidos";
	organiza_pedidos_por_creditos($semestre,$ano);

	//echo "montando tabela de frequencias";
	monta_tabela_oferta_frequencia_pedidos($semestre,$ano);

	//echo "Alocando professores";
	aloca_professores($semestre,$ano);

	//echo "Atualizando tabela de rodizio noturno";
	//atualiza_rodizio_noturno($semestre,$ano);
	imprime_esboco_lista_ofertas($semestre,$ano);
	//imprime_lista_atendimento($semestre,$ano);
}

pg_close($idconn);
?>


