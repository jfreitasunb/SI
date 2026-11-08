<?PHP
$idmodule=98;
   include("../../../global/header.php");
//include("../head_oferta.php");
//require("../muda_senha/pgsql.php");
include("imprime_oferta_prof.php");

$ano=$_POST['ano'];
$semestre=$_POST['semestre'];
if (!ctype_digit((string)$semestre) || !ctype_digit((string)$ano)) {
	die(error("Semestre/ano invalido."));
}

//$tabela="oferta_semestre_".$semestre;

$professor=$_POST['professor'];

$creditos=$_POST['creditos'];
$disciplinas_iguais_6=$_POST['disciplinas_iguais_6'];

$disc_pos=$_POST['disc_pos'];

$orientando=$_POST['orientando'];
$credito_estagio_pesquisa=$_POST['credito_estagio_pesquisa'];

$disciplina=$_POST['disciplina'];

//$magistral_teoria=$_POST['magistral_teoria'];
//$magistral_exercicios=$_POST['magistral_exercicios'];
//echo $professor."_".$ano."_".$semestre."--/--";
$query_limpa_oferta_magistral=db_query("delete from oferta_magistral_opcoes_profs where coduser=? and ano=? and semestre=?", array($professor, $ano, $semestre)) or die("problema 00"); 

// if duas iguais nao faz nada!
//$teste=0;
$teste_array=array_unique($disciplina);
if((count($teste_array)==count($disciplina)) and !in_array("_0",$disciplina)) $teste=0; else $teste=1;

if($teste==0)
{

if ($creditos!=0)
	{
	$query_limpa_oferta_disc=db_query("delete from oferta_escolha_disciplina where coduser=? and semestre=? and ano=?", array($professor, $semestre, $ano)) or die ("problema de conexao com o banco 01");
	for ($i=1;$i<7;$i++)
		{
		$disciplina2=explode("_",$disciplina[$i]);
		$codigo=$disciplina2[0];
//		$magistral=$disciplina2[3];
		if($disciplina2[2]=="teoria") $turno=$disciplina2[1]; else $turno=ucfirst(strtolower($disciplina2[1]));
		$creditos_disc=$disciplina2[3]; // corrigido em 24/04/2014
//		$pega_creditos=pg_query("select creditos from disciplinas_mat where codigo='".$codigo."'"); // pegar do POST
//		$creditos_disc=db_fetch_row($pega_creditos);
		if ($codigo!=0) list($query_insere, $query_insere__p) = array("insert into oferta_escolha_disciplina values(?,?,?,'0','0',?,?,?,?,'nao')", array($professor, $i, $codigo, $semestre, $ano, $turno, $creditos_disc)); 
			else list($query_insere, $query_insere__p) = array("insert into oferta_escolha_disciplina values(?,?,'0','0','0',?,?,?,'0','nao')", array($professor, $i, $semestre, $ano, $turno));
//		echo $query_insere;
		$res=db_query($query_insere, $query_insere__p) or die ("Problemas no acesso ao Banco de dados");
// atualizado em 24/04/2014:
		if(($disciplina2[2]=="teoria") or ($disciplina2[2]=="exercicios")) 
			{
			 $insere_magistral=db_query("insert into oferta_magistral_opcoes_profs values (?,?,?,?,?)", array($professor, $codigo, $disciplina2[2], $semestre, $ano)) or die("problema de cionexao em oferta_escolha_professor.php 1"); // coduser | codigo | tipo | semestre | ano
			}
		}
	}
else $query_limpa_oferta_disc=db_query("delete from oferta_escolha_disciplina where coduser=? and semestre=? and ano=?", array($professor, $semestre, $ano)) or die ("problema de conexao com o banco");

//coduser | creditos | disciplinas_iguais_6 | semestre | ano
	$query_limpa_creditos=db_query("delete from oferta_escolha_creditos where coduser=? and semestre=? and ano=?", array($professor, $semestre, $ano)) or die ("problema de conexao com o banco");
	list($query_insere_escolha_creditos, $query_insere_escolha_creditos__p) = array("insert into oferta_escolha_creditos values(?,?,?,?,?)", array($professor, $creditos, $disciplinas_iguais_6, $semestre, $ano));
//	echo $query_insere_escolha_creditos;
	$res=db_query($query_insere_escolha_creditos, $query_insere_escolha_creditos__p) or die ("Problemas no acesso ao Banco de dados");



	$query_limpa_creditos_pos=db_query("delete from oferta_escolha_creditos_pos where coduser=? and semestre=? and ano=?", array($professor, $semestre, $ano)) or die ("problema de conexao com o banco");
for ($i=0;$i<count($disc_pos);$i++)
	{
	$pos=explode("-",$disc_pos[$i]);
	if (($pos[1]!=0) and ($pos[0]!=0)) 
		{
		list($query_insere_escolha_creditos_pos, $query_insere_escolha_creditos_pos__p) = array("insert into oferta_escolha_creditos_pos values(?,?,?,?,?)", array($professor, $pos[1], $pos[0], $semestre, $ano));
//		echo $query_insere_escolha_creditos_pos;
		$res=db_query($query_insere_escolha_creditos_pos, $query_insere_escolha_creditos_pos__p) or die ("Problemas no acesso ao Banco de dados");
		}
	}


	$query_limpa_escolha_creditos_est_pesq_pos=db_query("delete from oferta_escolha_creditos_est_pesq_pos where coduser=? and semestre=? and ano=?", array($professor, $semestre, $ano)) or die ("problema de conexao com o banco");
for ($i=0;$i<count($orientando);$i++)
	{
	if(($orientando[$i]!=0) and ($credito_estagio_pesquisa[$i]!=0))
		{
		list($query_insere_escolha_creditos_est_pesq_pos, $query_insere_escolha_creditos_est_pesq_pos__p) = array("insert into oferta_escolha_creditos_est_pesq_pos values(?,?,?,?,?)", array($professor, $credito_estagio_pesquisa[$i], $orientando[$i], $semestre, $ano));
//		echo $query_insere_escolha_creditos_est_pesq_pos;
		$res=db_query($query_insere_escolha_creditos_est_pesq_pos, $query_insere_escolha_creditos_est_pesq_pos__p) or die ("Problemas no acesso ao Banco de dados");
		}
	}

/*
Retirado em 24/04/2014
// inclui os dados do magistral:
	$query_limpa_oferta_magistral=db_query("delete from oferta_magistral_opcoes_profs where coduser=? and ano=? and semestre=?", array($professor, $ano, $semestre));  
	foreach($magistral_teoria as $key=>$value)
		{
		if(isset($magistral_teoria[$key])) $insere_calculo1=db_query("insert into oferta_magistral_opcoes_profs values (?,?,'teoria',?,?)", array($professor, $key, $semestre, $ano)) or die("problema de cionexao em oferta_escolha_professor.php 1");
		}
	foreach($magistral_exercicios as $key=>$value)
                {	
		if(isset($magistral_exercicios[$key])) 
			{
//			echo "insert into oferta_magistral_opcoes_profs values ('".$professor."','".$key."','exercicios','".$semestre."','".$ano."')";
			$insere_calculo1=db_query("insert into oferta_magistral_opcoes_profs values (?,?,'exercicios',?,?)", array($professor, $key, $semestre, $ano)) or die("problema de cionexao em oferta_escolha_professor.php 1");
			}
		}
*/


//	echo "Op&ccedil;&otilde;es confirmadas e registradas.";
	 imprime_escolha_prof($professor,$semestre,$ano);
}
else
{
echo "No preenchimento das escolhas, n&atilde;o pode haver duas prioridades iguais.<br>";
echo "No preenchimento das escolhas, todas as prioridades devem ser preenchidas.<br>";
echo "Reinicie o processo, por favor, observando estes fatos.";
}
db_close($con);
?>

