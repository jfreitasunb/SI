<?PHP
require("head_oferta.php");
exige_post();
exige_escrita();

$e_mural = isset($_POST['e_mural']) && is_array($_POST['e_mural']) ? $_POST['e_mural'] : array();
// Recebe o semestre e o ano:

$semestre=$_POST['semestre'];
$ano=$_POST['ano'];

foreach($e_mural as $key1=>$value1)
	{
	if (!is_array($value1)) continue;
	foreach($value1 as $key2=>$value)
		{
		$query="update oferta_lista_de_ofertas set professor=? where disciplina=? and turma=? and semestre=? and ano=?"; $query__p = array($value, $key1, $key2, $semestre, $ano); 
		$res_query=db_query($query, $query__p) or die("problema de conexao em atualiza_lista_emural_3.php");
		}
	}
echo "Atualiza&ccedil;&otilde;es efetuadas";
db_close($idconn);
?>

