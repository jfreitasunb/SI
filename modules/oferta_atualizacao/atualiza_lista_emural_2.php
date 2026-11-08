<?php
require("head_oferta.php");


// Recebe o semestre e o ano:

$lista=$_REQUEST['lista'];
$periodo=explode("_",$lista);
$semestre=$periodo[0];
$ano=$periodo[1];

// carga_prof: nome | coduser | codigo | nivel | turma_disc | creditos_disc | creditos_prof | matriculas_na_turma | semestre | ano 
//$query_dados_carga=pg_query("select name||' '||firstname as nome,c.* from oferta_carga_professor c,users u where c.coduser=u.coduser and semestre='".$semestre."' and ano='".$ano."' and nivel='GR' order by codigo,turma_disc,creditos_prof") or die("problema de conexa 1 em atualiza_lista_emural_2.php");
//
// DEVE SER SUBSTITUÍDO PELA FUNÇÃO ANALISA_CARGA_PROF QUE DETERMINA A CARGA DOS PROFESSORES ENVOLVIDOS NAS DISCIPLINAS MAGISTRAIS; ISSO DEVE SER FEITO A APRTIR DA LO VINDA DO SIGRA.
//
//

//$query_dados_sigra=pg_query("select name||' '||firstname as nome,c.* from oferta_carga_professor c,users u where c.coduser=u.coduser and semestre='".$semestre."' and ano='".$ano."' and nivel='GR' order by codigo,turma_disc,creditos_prof") or die("problema de conexa 1 em atualiza_lista_emural_2.php");

$query_professores=db_query("select u.coduser,name||' '||firstname from users u inner join profs p on u.coduser=p.coduser inner join fonctionnaire f on u.coduser=f.coduser where f.statut='professor' and u.is_actif='t' order by name", array());
while($dados=db_fetch_row($query_professores))
{
$nome[$dados[0]]=$dados[1];
}

$query_sigra=db_query("select codigo,turma,coduser from oferta_lista_sigra where semestre=? and ano=? order by codigo,turma", array($semestre, $ano));



$query_dados_lista_de_ofertas=db_query("select professor,disciplina,turma from oferta_lista_de_ofertas where semestre=? and ano=? order by disciplina,turma", array($semestre, $ano)) or die ("problema de conexa 2 em atualiza_lista_emural_2.php");
// Monta um array de alocacao de professor por discilpina/turma: 
$LO_prof=array();
while($registro_disc=db_fetch_row($query_dados_lista_de_ofertas))
	{
	$LO_prof[$registro_disc[1]][$registro_disc[2]]=$registro_disc[0];
	}


$query_disciplinas=db_query("select codigo,nome from disciplinas_mat where status='grad' order by codigo", array()) or die("problema de conexa 3 em atualiza_lista_emural_2.php");
$Disciplinas=array();
while($registro_0=db_fetch_row($query_disciplinas))
	{
	$Disciplinas[$registro_0[0]]=$registro_0[1];
	}

?>
<html>
  <header>
    <link type="text/css" rel="stylesheet" href="../../global/grafic.css">
<meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
  </header>
  <body>
      <table class=big>
	<tr>
	<form method="POST" name="formu" action="atualiza_lista_emural_3.php">
        <td class=header align=center>
        <h1> Lista de Ofertas do <?php  echo h($semestre);?>&ordm;/ <?php  echo h($ano);?></h1>
        </td>
      </tr>
      <tr><td>
	<table border> 
	<tr><td><b>Disciplina</b></td><td><b>Turma</b></td><td><b>Professor</b></td><td><b>Cr&eacute;ditos</b></td><td><b>E-mural</b></td></tr>
	<tr></tr>
	<?php
	$cor_de_fundo="#ffffff";
	$disc=0;
	while ($registro=db_fetch_row($query_sigra))// USAR UMA ARRAY COM CHAVE SENDO O CÓDIGO DA DISCIPLINA/TURMA corrigido em 20/12/2014
		{
		if ($disc===0) $disc=$registro[0].$registro[1]; 
		if ($registro[0].$registro[1]!==$disc) 
			{
			$disc=$registro[0].$registro[1]; 
			if ($cor_de_fundo=="#ffffff") $cor_de_fundo="#d0d0d0"; else $cor_de_fundo="#ffffff";
			}
		$coduser=explode("-",$registro[2]);
		for($i=0;$i<count($coduser);$i++)
		{
		?>
		<tr VALIGN=CENTER BGCOLOR="<?php echo $cor_de_fundo;?>">
		<td><?php echo h($registro[0])."-".h($Disciplinas[$registro[0]]);?></td>
		<td><?php echo h($registro[1]);?></td>
		<td><?php echo h($nome[$coduser[$i]]);?></td> 
		<?php
		if($LO_prof[$registro[0]][$registro[1]]==$coduser[$i]){$ex="exerc.";$checked="checked";}else{$checked="";$ex="teoria";};
		?>
			<td><?php echo $ex;?></td>
			<td><input type=radio name='e_mural[<?php echo h($registro[0]);?>][<?php echo h($registro[1]);?>]' <?php echo $checked;?> value="<?php echo h($coduser[$i]);?>"></td>
		</tr>
		<?php
		}
		}
	?>
	</table> 
	<input type=hidden name='semestre' value="<?php echo h($semestre);?>">
	<input type=hidden name='ano' value="<?php echo h($ano);?>">
	<input type=submit name='confirma' value="Confirmar altera&ccedil;&otilde;es">
	</td>
	</form>
	</tr>
	</table>
	</body>
</html>
<?php
	db_close($idconn);
?>

