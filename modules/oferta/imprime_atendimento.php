<?PHP
include("head_oferta.php");

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

$query_acusa_lista=pg_query("select * from oferta_acusa_lista order by ano desc, semestre desc");
?>
  <body>
      <table class=big>
      <form method="POST" name="formu" action="imprime_atendimento.php">
         <tr>
        <td class=header align=center colspan=2>
        <h1> Lista de Ofertas do MAT </h1>
        </td>
      </tr>
      <tr><td>Escolha o semestre:
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
//$ano=$_POST['ano'];
//$semestre=$_POST['semestre'];

// disciplina |  turma | turno | professor  |  semestre|  ano | horarios |

$query_dados=pg_query("select distinct on (nome) u.coduser,name||' '||firstname as nome from users u, oferta_escolha_disciplina ed where u.coduser=ed.coduser and ed.semestre='".$semestre."' and ed.ano='".$ano."' order by nome");
$num_dados=pg_num_rows($query_dados);


$query_creditos=pg_query("select coduser,creditos,disciplinas_iguais_6 from oferta_escolha_creditos where semestre='".$semestre."' and ano='".$ano."'");
$creditos=array();
while($registro_creditos=pg_fetch_row($query_creditos))
	{
	$creditos[$registro_creditos[0]]['creditos']=$registro_creditos[1];
	$creditos[$registro_creditos[0]]['disciplinas_iguais']=$registro_creditos[2];
	}
//print_r($creditos);

$query_magistral=pg_query("select coduser,codigo,tipo from oferta_magistral_opcoes_profs where semestre='".$semestre."' and ano='".$ano."' order by coduser");
$magistral=array();
$coduser=0;
while($registro_magistral=pg_fetch_row($query_magistral))
	{
	if($registro_magistral[0]==$coduser)
		{
		if($registro_magistral[2]=="exercicios") $magistral[$coduser][$registro_magistral[1]]['exercicios']="sim";
		if($registro_magistral[2]=="teoria") $magistral[$coduser][$registro_magistral[1]]['teoria']="sim";
		}
	else
		{
		$coduser=$registro_magistral[0];
		if($registro_magistral[2]=="exercicios") $magistral[$coduser][$registro_magistral[1]]['exercicios']="sim";
		if($registro_magistral[2]=="teoria") $magistral[$coduser][$registro_magistral[1]]['teoria']="sim";
		}
	}
//print_r($magistral);

?>
     <body>
      <table class=big>
         <tr>
        <td class=header align=center>
        <h1> Lista de Ofertas do <? echo $semestre;?>&ordm;/ <? echo $ano;?></h1>
        </td>
      </tr>
	 <tr><td class=data align=center>
	<table border> 
	<tr><th rowspan=3><b>Professor</b></th><th rowspan=3><b>Cr&eacute;ditos</b></th><th rowspan=3 align=center><b>Disciplinas<br>iguais<br>6 cred.</b></th><td colspan=6 align=center><b>magistral</b></td><th rowspan=3><b>Prioridade 1</b></th><th rowspan=3><b>Prioridade 2</b></th><th rowspan=3><b>Prioridade 3</b></th><th rowspan=3><b>Prioridade 4</b></th><th rowspan=3><b>Prioridade 5</b></th><th rowspan=3><b>Prioridade 6</b></th></tr>
	<tr><td align=center colspan=2><b>Mat. 1 </b></td><td align=center colspan=2><b>Calc. 1 </b></td><td align=center colspan=2><b>IMS </b></td></tr>
	<tr><td align=center><b>Exerc.</b></td><td align=center><b>Teoria</b></td><td align=center><b>Exerc.</b></td><td align=center><b>Teoria</b></td><td align=center><b>Exerc.</b></td><td align=center><b>Teoria</b></td></tr>
	<tr></tr>
	<?
	$cor_de_fundo="#FFFFFF";
	$prof=0;
	while ($registro=pg_fetch_row($query_dados))
		{
		if ($prof==0) $prof=$registro[0]; 
		else 
		   {
		    if ($registro[0]!=$prof) {$prof=$registro[0]; if ($cor_de_fundo=="#FFFFFF") $cor_de_fundo="#D0D0D0"; else $cor_de_fundo="#FFFFFF";}
		   }
		$query_prioridades=pg_query("select prioridade,atendido,disciplina from oferta_escolha_disciplina where coduser='".$prof."' and semestre='".$semestre."' and ano='".$ano."' order by prioridade");
		$impresso="<td>".$registro[1]."</td>";
// colunas de creditos e discilpinas iguais:
		$impresso.="<td align=center>".$creditos[$prof]['creditos']."</td><td align=center>".$creditos[$prof]['disciplinas_iguais']."</td>";
// colunas das disciplinas magistrais:
		$impresso.="<td align=center>".$magistral[$prof]['113018']['exercicios']."</td><td align=center>".$magistral[$prof]['113018']['teoria']."</td><td align=center>".$magistral[$prof]['113034']['exercicios']."</td><td align=center>".$magistral[$prof]['113034']['teoria']."</td><td align=center>".$magistral[$prof]['113701']['exercicios']."</td><td align=center>".$magistral[$prof]['113701']['teoria']."</td>";
 
		while ($registro2=pg_fetch_row($query_prioridades))
			{
			$query_disciplina=pg_query("select nome from disciplinas_mat where codigo='".$registro2[2]."'");
			$disciplina=pg_fetch_row($query_disciplina);
			$impresso.="<td>".$registro2[1]."<br>".$disciplina[0]."</td>";
			}
		?>
		<tr VALIGN=CENTER BGCOLOR="<? echo $cor_de_fundo;?>"> <? echo $impresso;?></tr>
		<?
		}
?>
	</table>
	</td></tr> 
	</table>
	</body>
<?
}

?>
</html>
<?
pg_close($idconn);
?>

