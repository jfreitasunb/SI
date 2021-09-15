<?PHP // criação de grupos de turmas para teoria
include("head_magistral.php");

$lista=explode("_",$_POST['lista']);

$horas=array("08","10","14","16","19","21");
$dias=array("2","3","4","5","6","7");

$disciplina=$_POST['disciplina'];
$dados=$_POST['dados'];
$retirados=$_POST['retirados'];

$turma=array();

$query_grupos_num=pg_query("select grupo from oferta_grupos_magistral_teoria order by grupo desc limit 1");
$num_grupo=pg_result($query_grupos_num,0,0) +1;

// pega os grupos já prontos em table oferta_grupos_magistral_teoria: grupo,codigo,turmas,horario
foreach ($horas as $key0 => $value0)
	{
	foreach($dias as $key1 => $value1)
		{
		foreach($dados[$value0][$value1] as $key2 => $value2)
			{
			$turma[]=$value2;
			}
		}
	}

foreach($retirados as $key => $value)
	{
	$query_grupos="delete from oferta_grupos_magistral_teoria where grupo='".$value."' and semestre='".$lista[0]."' and ano='".$lista[1]."'";
	echo $query_grupos."<br>";
	$res_grupos=pg_query($query_grupos) or die("problema de conexao 1 em magistral_grupo_2");
	}

foreach($turma as $key => $value)
	{
	$codigo_1=$disciplina."001";
	$valor=explode("-",$value);
	$query_grupos="insert into oferta_grupos_magistral_teoria values ('".$num_grupo."','".$disciplina."','".$valor[1]."','".$valor[0]."','".$codigo_1."','".$lista[0]."','".$lista[1]."')";
	echo $query_grupos."<br>";
//	$res_grupos=pg_query($query_grupos) or die("problema de conexao 1 em magistral_grupo_2");
	}


pg_close($idconn);
?>

