<?PHP
require("head_oferta.php");

function pega_carga_na_turma($disciplina,$turma,$professores,$array_carga)
{
$calcula=array();
foreach($professores as $key => $value)
	{
	for ($i=0;$i<count($array_carga);$i++)
		{
		if (($array_carga[$i]['codigo']==$disciplina) and ($array_carga[$i]['turma_disc']==$turma) and  ($array_carga[$i]['coduser']==$value)) 
			{
			$calcula[$key]['creditos_prof']=$array_carga[$i]['creditos_prof'];
			$calcula[$key]['matriculas_na_turma']=$array_carga[$i]['matriculas_na_turma'];
			$calcula[$key]['coduser']=$value;
			}
		}
	}

return $calcula;
} //end function procura_carga_na_turma



function prepara_array_de_linhas($semestre,$ano)
{
$query_deleta=db_query("delete from oferta_tabela_impressao", array());

$linhas=array();

$query_profs=db_query("select coduser,name||' '||firstname as nome from users where tipo_users='professor' order by nome", array()) or die ("problemas de acesso ao banco");
$nome_profs=db_fetch_all($query_profs);
$nomes_de_profs=array();
foreach ($nome_profs as $key => $value)
	{
	$nomes_de_profs[$value['coduser']]=$value['nome'];
	}

$query_carga=db_query("select * from oferta_carga_professor where semestre=? and ano=? and nivel='GR' order by codigo, turma_disc", array($semestre, $ano)) or die ("problemas de acesso ao banco");
$array_carga=db_fetch_all($query_carga);

$query_lista=db_query("select os.codigo as codigo,os.turma as turma,os.turno as turno,os.horarios as horarios,os.coduser as coduser,dm.nome as nome_disciplina,dm.creditos as creditos from oferta_lista_sigra os, disciplinas_mat dm where os.semestre=? and os.ano=? and os.codigo=dm.codigo order by codigo,turma", array($semestre, $ano)) or die ("problemas de acesso ao banco");

$i=0;
while($registro=db_fetch_row($query_lista))
	{
	$disciplina=$registro[0];
	$turma=$registro[1];
	$turno=$registro[2];
	$horarios=$registro[3];
	$professores=explode("-",$registro[4]);
	$nome_disciplina=$registro[5];
	$creditos=$registro[6];
	$carga=pega_carga_na_turma($disciplina,$turma,$professores,$array_carga);
	if (empty($carga)) 
		{
//		$linhas[$i]=array('nome'=> $nomes_de_profs[$professor[0]], 'codigo' => $disciplina, 'turma' => $turma, 'turno'=> $turno, 'horarios'=> $horarios, 'nome_disciplina'=> $nome_disciplina, 'creditos' => $creditos);
//		$i=$i+1;
		$query_insere=db_query("insert into oferta_tabela_impressao values(?,?,?,?,?,?,?)", array($nomes_de_profs[$professores[0]], $disciplina, $turma, $turno, $horarios, $nome_disciplina, $creditos));
		}
	else
		{
		foreach ($carga as $key => $row)
			{
			$creditos=$row['creditos_prof']/100;
//			$linhas[$i]=array('nome'=> $nomes_de_profs[$row['coduser']], 'codigo' => $disciplina, 'turma' => $turma, 'turno'=> $turno, 'horarios'=> $horarios, 'nome_disciplina'=> $nome_disciplina, 'creditos' => $creditos);
//			$i=$i+1;
			$query_insere=db_query("insert into oferta_tabela_impressao values(?,?,?,?,?,?,?)", array($nomes_de_profs[$row['coduser']], $disciplina, $turma, $turno, $horarios, $nome_disciplina, $creditos));
			}
		}
	
//	$query_insere=pg_query($insere);
//	echo $insere;
	}

return $linhas;
} // fim function prepara_array_de_linhas


function ordena_array($linhas,$ordena)
{
$filtro=array();
$turmas=array();
//print_r($linhas);
if ($ordena=="professor") 
	{
	foreach ($linhas as $key => $row) 
        	{
	        $filtro[$key]  = $linhas[$key]['nome'];
		$turmas[$key]=$linhas[$key]['turma'];
		$disciplinas[$key]=$linhas[$key]['nome_disciplina'];
        	}
	$linhas_ordenadas = array_multisort($filtro, SORT_ASC,SORT_STRING, $disciplinas,SORT_ASC,SORT_STRING,$turmas, SORT_ASC,SORT_STRING,$linhas);
	} 
if ($ordena=="disciplina") 
	{
	foreach ($linhas as $key => $row) 
		{
		$filtro[$key]  = $linhas[$key]['nome_disciplina'];
		$turmas[$key]=$linhas[$key]['turma'];
		}
	$linhas_ordenadas = array_multisort($filtro, SORT_ASC,SORT_STRING, $turmas, SORT_ASC,SORT_STRING,$linhas);
	}
//var_dump($filtro);
print_r($linhas_ordenadas);
return $linhas_ordenadas;
}

// Escolhe semestre e ano:

$lista=$_REQUEST['lista'];
/*
if (isset($_POST['lista'])) 
{
$periodo=explode("_",$_POST['lista']); 
$lista=$_POST['lista'];
}
else 
{
$periodo=explode("_",$_GET['lista']);
$lista=$_GET['lista'];
}
*/
$periodo=explode("_",$lista);
$semestre=$periodo[0];
$ano=$periodo[1];
//$lista_oferta="oferta_lista_de_ofertas_".$lista;
$lista_oferta="oferta_lista_de_ofertas";

if (isset($_GET['ordena'])) 
	{
	$ordena=$_GET['ordena']; 
//	$linhas_ordenadas=ordena_array($linhas,$ordena);
	}
	else 
	{
	$ordena="professor";
	$linhas=prepara_array_de_linhas($semestre,$ano);
//	$linhas_ordenadas=ordena_array($linhas,"professor");
	}

//echo "<BR>";
//print_r($linhas_ordenadas);
//echo "<BR>";

//echo $lista_oferta;
//$ano=$_POST['ano'];
//$semestre=$_POST['semestre'];

//  prof | codigo | nome_disciplina |  turma | turno | horarios | creditos 

if ($ordena=="professor")
//$query_dados=pg_query("select u.coduser,name||' '||firstname as nome, m.codigo as disciplina, m.nome as nome_disciplina, lo.turma as turma, lo.turno as turno, lo.horarios as horarios from ".$lista_oferta." lo, users u, disciplinas_mat m where u.coduser=lo.professor and m.codigo=lo.disciplina and lo.semestre='".$semestre."' and lo.ano='".$ano."' order by nome, disciplina");
$query_dados=db_query("select * from oferta_tabela_impressao order by nome,nome_disciplina,turma", array());
else 
//$query_dados=pg_query("select u.coduser,name||' '||firstname as nome, m.codigo as disciplina, m.nome as nome_disciplina, lo.turma as turma, lo.turno as turno, lo.horarios as horarios from ".$lista_oferta." lo, users u, disciplinas_mat m where u.coduser=lo.professor and m.codigo=lo.disciplina and lo.semestre='".$semestre."' and lo.ano='".$ano."' order by disciplina,turma,nome");
$query_dados=db_query("select * from oferta_tabela_impressao order by nome_disciplina,turma", array());
$num_dados=db_num_rows($query_dados);
//$num_dados=count($linhas_ordenadas);

?>
<html>
  <header>
    <link type="text/css" rel="stylesheet" href="../../global/grafic.css">
<meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
  </header>
  <body>
      <table class=big>
         <tr>
        <td class=header align=center>
        <h1> Lista de Ofertas do <?php  echo $semestre;?>&ordm;/ <?php  echo $ano;?></h1>
        </td>
      </tr>
      <tr><td>
	<table border> 
	<tr><td><b><a href='imprime_lista.php?lista=<?php  echo $semestre."_".$ano;?>&ordena=professor'>Professor</a></b></td><td><b><a href='imprime_lista.php?lista=<?php  echo $semestre."_".$ano;?>&ordena=disciplina'>Disciplina</a></b></td><td><b>Turma</b></td><td><b>Turno</b></td><td><b>Hor&aacute;rios</b></td><td><b>Cr&eacute;ditos</b></td></tr>
	<tr></tr>
	<?php 
	$cor_de_fundo="#FFFFFF";
	$prof=0;
	while ($registro=db_fetch_row($query_dados))
//	for ($i=0;$i<count($linhas_ordenadas);$i++)
		{
		if ($prof===0) $prof=$registro[0]; 
//		if ($prof==0) $prof=$linhas_ordenadas[$i]['nome']; 
		if ($registro[0]!==$prof) 
			{
			$prof=$registro[0]; 
			if ($cor_de_fundo=="#FFFFFF") $cor_de_fundo="#D0D0D0"; else $cor_de_fundo="#FFFFFF";
			}
//		if ($linhas_ordenadas[$i]['nome']!=$prof) {$prof=$linhas_ordenadas[$i]['nome']; if ($cor_de_fundo=="#FFFFFF") $cor_de_fundo="#D0D0D0"; else $cor_de_fundo="#FFFFFF";}
		?>
		<tr VALIGN=CENTER BGCOLOR="<?php  echo $cor_de_fundo;?>">
		<td><?php  echo $registro[0];?></td>
		<td><?php  echo $registro[1]."-".$registro[5];?></td>
		<td><?php  echo $registro[2];?></td>
		<td><?php  echo $registro[3];?></td>
		<td><?php  echo $registro[4];?></td>
		<td><?php  echo $registro[6];?></td>
		</tr>
		<?php 
		}
	?>
	</table> 
	</td></tr>
	</table>
	</body>
</html>
<?php 
db_close($idconn);
?>

