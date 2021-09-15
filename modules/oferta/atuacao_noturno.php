<?php

include("head_oferta.php");
include("funcoes.php");
?>
<html>
  <header>
    <link type="text/css" rel="stylesheet" href="../../global/grafic.css">
<meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
  </header>
<?php

if (!isset($_POST['registra']))
{
$query_acusa_lista=pg_query("select * from oferta_acusa_lista order by ano desc,semestre desc");

?>
  <body>
      <table class=big>
   <form method="POST" name="formu" action="atuacao_noturno.php">
      <tr>
        <td class=header align=center colspan=2>
        <h1>Prioridades de atua&ccedil;&otilde;es no noturno para a Lista de Oferta de Disciplinas</h1>
        </td>
      </tr>

<tr><td>Escolha a lista:
        </select>
        <select name='lista'>
        <?php
        while ($registro=pg_fetch_row($query_acusa_lista))
        {
        ?>
        <option value="<?php echo $registro[0]."_".$registro[1];?>"> <?php echo $registro[0];?> &ordm;/ <?php echo $registro[1];?></option>
        <?php
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
<?php
}

if (isset($_POST['registra']))
{

$lista=explode("_",$_POST['lista']);
$semestre=$lista[0];
$ano=$lista[1];
//$ano_atual=date(Y);
//$mes_atual=date(m);

//if ($mes_atual<6) and $semestre

atualiza_rodizio_noturno($semestre,$ano);

//if ($semestre==1) {$ano_anterior=$ano-1;$semestre_anterior=2;} else {$ano_anterior=$ano;$semestre_anterior=1;}
//1-
// seleciona as atuacoes a partir de 2005:
//$query_atuacoes="select coduser,sum(disc_noturno) as soma from oferta_horarios_rodizio_noturno where coduser in (select distinct on (coduser) coduser from oferta_escolha_disciplina where semestre='".$semestre."' and ano='".$ano."') group by (coduser) order by coduser";

if ($semestre==1) {$condicao="o.ano<'".$ano."'";$semestre_anterior=2;$ano_anterior=$ano-1;} else {$condicao="(o.ano<'".$ano."' or (o.semestre='1' and o.ano='".$ano."'))";$semestre_anterior=1;$ano_anterior=$ano;}

//$query_atuacoes="select coduser,sum(disc_noturno) as soma from oferta_horarios_rodizio_noturno where ".$condicao." and coduser in (select u.coduser from users u, fonctionnaire f where u.coduser=f.coduser and u.is_actif='true' and f.statut='professor' and f.contract_type='dedicacao exclusiva') group by (coduser) order by coduser";
$query_atuacoes="select o.coduser, sum(o.disc_noturno) as soma from oferta_horarios_rodizio_noturno o, users u,fonctionnaire f where o.coduser=u.coduser and u.coduser=f.coduser and u.is_actif and f.statut='professor' and f.contract_type='dedicacao exclusiva' and ".$condicao." group by (o.coduser) order by o.coduser";
//echo $query_atuacoes."\n";

$pg_query_atuacoes=pg_query($query_atuacoes);
//$atuacoes=pg_fetch_all($pg_query_atuacoes);
//$num_atuacoes=pg_num_rows($pg_query_atuacoes);
//echo $num_atuacoes;

// seleciona as atuacoes acumuladas de 94 a 2004:
//$query_acumulados="select o4.coduser,quantidade, name||' '||firstname as nome from oferta_horario_noturno_acumulado_94_04 o4, users u where o4.coduser=u.coduser and o4.coduser in (select distinct on (coduser) coduser from oferta_escolha_disciplina where semestre='".$semestre."' and ano='".$ano."') order by o4.coduser";
//$query_acumulados="select coduser,quantidade from oferta_horario_noturno_acumulado_94_04 where coduser in (select u.coduser from users u, fonctionnaire f where u.coduser=f.coduser and u.is_actif='true' and f.statut='professor' and f.contract_type='dedicacao exclusiva') order by coduser";
$query_acumulados="select o.coduser,o.quantidade from oferta_horario_noturno_acumulado_94_04 o, users u,fonctionnaire f where o.coduser=u.coduser and u.coduser=f.coduser and u.is_actif and f.statut='professor' and f.contract_type='dedicacao exclusiva' order by o.coduser";
//echo $query_acumulados."\n";
$pg_query_acumulados=pg_query($query_acumulados);
//$acumulados=pg_fetch_all($pg_query_acumulados);
//$num_acumulados=pg_num_rows($pg_query_acumulados);
//echo $num_acumulados;
$soma=array();
while ($atuacoes=pg_fetch_row($pg_query_atuacoes))
	{
	$soma[$atuacoes[0]]=$atuacoes[1];
	}
while ($atuacoes_2=pg_fetch_row($pg_query_acumulados))
        {
        $soma[$atuacoes_2[0]]=$soma[$atuacoes_2[0]]+$atuacoes_2[1];
        }

/*for ($i=0;$i<$num_atuacoes;$i++)
	{
	$soma=$acumulados[$i]['quantidade']+$atuacoes[$i]['soma'];
//echo $soma."---";
	$total[]=array('coduser' => $atuacoes[$i]['coduser'], 'nome' => $acumulados[$i]['nome'], 'total' => $soma);
	}
*/
foreach ($soma as $key => $value)
        {
	$query_nome=pg_query("select name||' '||firstname from users where coduser='".$key."'");
	$nome=pg_fetch_row($query_nome);
	$total[]=array('coduser' => $key, 'nome' => $nome[0], 'total' => $value);
	}

//print_r($total);
//2-

//$total_0=asort($total,'total');
foreach ($total as $key => $row)
	{
    	$soma_1[$key] = $row['total'];
//echo $soma_1[$key];
	}
asort($soma_1);

$ano_1=$ano-1;
$ano_2=$ano-2;

//if ($semestre==1) $query_atuacoes_3="select o.coduser from oferta_horarios_rodizio_noturno o, users u, fonctionnaire f where o.coduser=u.coduser and u.coduser=f.coduser and u.is_actif and f.statut='professor' and f.contract_type='dedicacao exclusiva' and (o.semestre='1' or o.semestre='2') and o.ano='".$ano_1."' and o.disc_noturno<>'0'";
// corrigido em 5/05/2016 para acrescentar um semestre:
if ($semestre==1) $query_atuacoes_3="select o.coduser from oferta_horarios_rodizio_noturno o, users u, fonctionnaire f where (o.coduser=u.coduser and u.coduser=f.coduser and u.is_actif and f.statut='professor' and f.contract_type='dedicacao exclusiva' and (o.semestre='1' or o.semestre='2') and o.ano='".$ano_1."' and o.disc_noturno<>'0') or (o.coduser=u.coduser and u.coduser=f.coduser and u.is_actif and f.statut='professor' and f.contract_type='dedicacao exclusiva' and o.semestre='1' and o.ano='".$ano_2."' and o.disc_noturno<>'0')";

//if ($semestre==2) $query_atuacoes_3="select o.coduser from oferta_horarios_rodizio_noturno o, users u, fonctionnaire f where (o.coduser=u.coduser and u.coduser=f.coduser and u.is_actif and f.statut='professor' and f.contract_type='dedicacao exclusiva' and o.semestre='1' and o.ano='".$ano."' and o.disc_noturno<>'0') or (o.coduser=u.coduser and u.coduser=f.coduser and u.is_actif and f.statut='professor' and f.contract_type='dedicacao exclusiva' and o.semestre='2' and o.ano='".$ano_1."' and o.disc_noturno<>'0')"; corrigido em 5/5/2016 para acrescentar um semestre:

if ($semestre==2) $query_atuacoes_3="select o.coduser from oferta_horarios_rodizio_noturno o, users u, fonctionnaire f where (o.coduser=u.coduser and u.coduser=f.coduser and u.is_actif and f.statut='professor' and f.contract_type='dedicacao exclusiva' and o.semestre='1' and o.ano='".$ano."' and o.disc_noturno<>'0') or (o.coduser=u.coduser and u.coduser=f.coduser and u.is_actif and f.statut='professor' and f.contract_type='dedicacao exclusiva' and (o.semestre='1' or o.semestre='2') and o.ano='".$ano_1."' and o.disc_noturno<>'0')";
//echo $query_atuacoes;
//echo $query_atuacoes;

$pg_query_atuacoes_3=pg_query($query_atuacoes_3);
$noturno_3_semestres=pg_fetch_all($pg_query_atuacoes_3);

foreach ($noturno_3_semestres as $key => $row)
        {
//      $coduser[$key]  = $row['coduser'];
//      $nome[$key]=$row['nome'];
        $coduser[$key] = $row['coduser'];
//echo $soma_1[$key];
        }
//print_r($coduser);

//4- Relatorio:

// seleciona apenas professores na ativa na tabela profs em que situacao='ativo'; incluido em 19/10/2015:
$query_ativos_0=pg_query("select coduser from profs where situacao='ativo'") or die("problema selecao de profs na ativa em atuacao_noturno.php");
$profs_na_ativa=array();
$indice=0;
while($registro_ativos=pg_fetch_row($query_ativos_0))
{
$profs_na_ativa[$indice]=$registro_ativos[0];
$indice=$indice+1;
}

?>

<body>
      <table class=big>
      <!form method="POST" name="formu" action="armazena_rodizio_noturno.php">
         <tr>
        <td class=header align=center>
        <h1> Atua&ccedil;&otilde;es no Noturno do MAT  at&eacute; o <?php echo $semestre_anterior."/".$ano_anterior;?></h1>
        </td>
      </tr>
      <tr><td>
      <table border>
	<tr>
	<td><b>Atua&ccedil;&otilde;es</b></td><td><b>Nome</b></td>
	</tr>
	<tr></tr>
<?php
	$cordefundo="#FFFFFF";
//	for ($i=0;$i<$num_atuacoes;$i++)
	foreach ($soma_1 as $key => $valor)
	{
 	if ($cordefundo=="#FFFFFF") $cordefundo="#D0D0D0"; else $cordefundo="#FFFFFF";

	if (in_array($total[$key]['coduser'],$coduser)) $cordaletra="#00AA00"; else $cordaletra="#000000";
	if(in_array($total[$key]['coduser'],$profs_na_ativa)){
	echo "<tr bgcolor=".$cordefundo."><td><font color=".$cordaletra.">".$total[$key]['total']."</font></td><td><font color=".$cordaletra.">".$total[$key]['nome']."</font></td></tr>";
	}
	}

?>
	</table>
        </td></tr>
	<tr><td><font color="#00AA00">Obs.: A cor verde significa que o professor est&aacute; na zona de conforto de 3 semestres ap&oacute;s atua&ccedil;&atilde;o no noturno</font></td></tr>
<?php
}
?>
</table>
</body>
</html>

<?php
pg_close($idconn);
?>


