<?PHP
//include ("../head_oferta.php");
$idmodule=98;
   include("../../../global/header.php");
$semestre=$_GET['semestre'];
$ano=$_GET['ano'];
// semestre/ano entram em calculos e na pagina: so aceita inteiros.
if (!ctype_digit((string)$semestre) || !ctype_digit((string)$ano)) {
	die(error("Semestre/ano invalido."));
}

?>
<html>
  <header>
    <link type="text/css" rel="stylesheet" href="../../../global/grafic.css">
<meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
  </header>
<?

if ($semestre==1) {$condicao="o.ano<?";$condicao__p=array($ano);$semestre_anterior=2;$ano_anterior=$ano-1;} else {$condicao="(o.ano<? or (o.semestre='1' and o.ano=?))";$condicao__p=array($ano,$ano); $semestre_anterior=1;$ano_anterior=$ano;}

list($query_atuacoes, $query_atuacoes__p) = array("select o.coduser, sum(o.disc_noturno) as soma from oferta_horarios_rodizio_noturno o, users u,fonctionnaire f,profs p where o.coduser=u.coduser and u.coduser=f.coduser and u.is_actif and p.coduser=u.coduser and p.situacao='ativo' and f.statut='professor' and f.contract_type='dedicacao exclusiva' and ".$condicao." group by (o.coduser) order by o.coduser", $condicao__p);
//echo $query_atuacoes."\n";

$pg_query_atuacoes=db_query($query_atuacoes, $query_atuacoes__p);
//echo $num_atuacoes;

// seleciona as atuacoes acumuladas de 94 a 2004:
list($query_acumulados, $query_acumulados__p) = array("select o.coduser,o.quantidade from oferta_horario_noturno_acumulado_94_04 o, users u,fonctionnaire f,profs p where o.coduser=u.coduser and u.coduser=f.coduser and u.is_actif  and p.coduser=u.coduser and p.situacao='ativo' and f.statut='professor' and f.contract_type='dedicacao exclusiva' order by o.coduser", array());
//echo $query_acumulados."\n";
$pg_query_acumulados=db_query($query_acumulados, $query_acumulados__p);
//$acumulados=db_fetch_all($pg_query_acumulados);
//$num_acumulados=db_num_rows($pg_query_acumulados);
//echo $num_acumulados;
$soma=array();
while ($atuacoes=db_fetch_row($pg_query_atuacoes))
	{
	$soma[$atuacoes[0]]=$atuacoes[1];
	}
while ($atuacoes_2=db_fetch_row($pg_query_acumulados))
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
	$query_nome=db_query("select name||' '||firstname from users where coduser=?", array($key));
	$nome=db_fetch_row($query_nome);
	$total[]=array('coduser' => $key, 'nome' => $nome[0], 'total' => $value);
	}

//print_r($total);
//2- 

//$total_0=asort($total,'total');
foreach ($total as $key => $row) 
	{
//    	$coduser[$key]  = $row['coduser'];
//   	$nome[$key]=$row['nome'];
    	$soma_1[$key] = $row['total'];
//echo $soma_1[$key]; 
	}
asort($soma_1);
//print_r($soma_1);
//foreach ($soma_1 as $key => $valor)
//	{
//	echo $key."--".$valor."\n";
//	}
//3-

$ano_1=$ano-1;

//if ($semestre==1) $query_atuacoes="select coduser from oferta_horarios_rodizio_noturno where coduser in (select distinct on (coduser) coduser from oferta_escolha_disciplina where semestre='".$semestre."' and ano='".$ano."') and (semestre='1' or semestre='2') and ano='".$ano_1."' and disc_noturno<>'0'";

if ($semestre==1) list($query_atuacoes_3, $query_atuacoes_3__p) = array("select o.coduser from oferta_horarios_rodizio_noturno o, users u, fonctionnaire f, profs p where o.coduser=u.coduser and u.coduser=f.coduser and u.is_actif  and p.coduser=u.coduser and p.situacao='ativo' and f.statut='professor' and f.contract_type='dedicacao exclusiva' and (o.semestre='1' or o.semestre='2') and o.ano=? and o.disc_noturno<>'0'", array($ano_1));

//if ($semestre==2) $query_atuacoes="select coduser from oferta_horarios_rodizio_noturno where coduser in (select distinct on (coduser) coduser from oferta_escolha_disciplina where (semestre='".$semestre."' and ano='".$ano."') and ((semestre='1' and ano='".$ano."') or (semestre='2' and ano='".$ano_1."')) and disc_noturno<>'0'";
if ($semestre==2) list($query_atuacoes_3, $query_atuacoes_3__p) = array("select o.coduser from oferta_horarios_rodizio_noturno o, users u, fonctionnaire f, profs p where (o.coduser=u.coduser and u.coduser=f.coduser and u.is_actif  and p.coduser=u.coduser and p.situacao='ativo' and f.statut='professor' and f.contract_type='dedicacao exclusiva' and o.semestre='1' and o.ano=? and o.disc_noturno<>'0') or (o.coduser=u.coduser and u.coduser=f.coduser and u.is_actif  and p.coduser=u.coduser and p.situacao='ativo' and f.statut='professor' and f.contract_type='dedicacao exclusiva' and o.semestre='2' and o.ano=? and o.disc_noturno<>'0')", array($ano, $ano_1));
//echo $query_atuacoes;

$pg_query_atuacoes_3=db_query($query_atuacoes_3, $query_atuacoes_3__p);
$noturno_3_semestres=db_fetch_all($pg_query_atuacoes_3);
$coduser=array(); // PHP 8: in_array() exige array mesmo sem atuacoes

foreach ($noturno_3_semestres as $key => $row)
        {
//      $coduser[$key]  = $row['coduser'];
//      $nome[$key]=$row['nome'];
        $coduser[$key] = $row['coduser'];
//echo $soma_1[$key]; 
        }
//print_r($coduser);

//4- Relatorio:
?>

<body>
      <table class=big>
      <!form method="POST" name="formu" action="armazena_rodizio_noturno.php">
         <tr>
        <td class=header align=center>
        <h1> Atua&ccedil;&otilde;es no Noturno do MAT  at&eacute; o <? echo h($semestre_anterior."/".$ano_anterior);?></h1>
        </td>
      </tr>
	<tr><td><font color="#00AA00">Obs.: A cor verde significa que o professor est&aacute; na zona de conforto de 3 semestres ap&oacute;s atua&ccedil;&atilde;o no noturno</font></td></tr> 
      <tr><td>
      <table border>
	<tr>
	<td><b>Atua&ccedil;&otilde;es</b></td><td><b>Nome</b></td>
	</tr>
	<tr></tr>
<?
	$cordefundo="#FFFFFF";
//	for ($i=0;$i<$num_atuacoes;$i++)
	foreach ($soma_1 as $key => $valor)
	{
 	if ($cordefundo=="#FFFFFF") $cordefundo="#D0D0D0"; else $cordefundo="#FFFFFF";	

	if (in_array($total[$key]['coduser'],$coduser)) $cordaletra="#00AA00"; else $cordaletra="#000000";

	echo "<tr bgcolor=".$cordefundo."><td><font color=".$cordaletra.">".$total[$key]['total']."</font></td><td><font color=".$cordaletra.">".h($total[$key]['nome'])."</font></td></tr>";

	}

?>
	</table>
        </td></tr>
</table>
</body>
</html>

<?
db_close($idconn);

?>

 
