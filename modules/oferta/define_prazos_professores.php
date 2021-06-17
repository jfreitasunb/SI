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
   <form method="POST" name="formu" action="define_prazos_professores.php">
      <tr>
        <td class=header align=center colspan=2>
        <h1>Defini&ccedil;&atilde;o do prazo de abertura do preenchimento da LO online</h1>
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
	<tr>
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
$data=explode("_",$_POST['lista']);
$semestre=$data[0];
$ano=$data[1];
?>

  <body>
      <table class=big>
      <form method="POST" name="formu" action="define_prazos_professores.php">
         <tr>
        <td class=header align=center>
        <h1> Escolha o prazo de abertura da tela de preenchimento da lista de ofertas do <? echo $semestre;?>&ordm;/ <? echo $ano;?></h1>
        </td>
      </tr>
         <tr><td class=data align=center>
        <tr><td><b>De: </b></td><td><select name='de_dia'> 
					<? 
					for($de_u=0;$de_u<32;$de_u++)
						{
						if($de_u<10) $de_d="0".$de_u; else $de_d=$de_u;
						echo "<option value=\"".$de_d."\">".$de_d."</option>";	
						}
					?>
					</select>/
					<select name='de_mes'>
                                        <?
                                        for($de_v=0;$de_v<13;$de_v++)
                                                {
                                                if($de_v<10) $de_m="0".$de_v; else $de_m=$de_v;
                                                echo "<option value=\"".$de_m."\">".$de_m."</option>";
                                                }
                                        ?>
                                        </select>/
					<select name='de_ano'>
                                        <?
                                        for($de_a=$ano-1;$de_a<$ano+2;$de_a++)
                                                {
                                                echo "<option value=\"".$de_a."\">".$de_a."</option>";
                                                }
                                        ?>
                                        </select></td></tr>
	<tr><td><b>A: </b></td><td><select name='ao_dia'>
                                        <?
                                        for($ao_u=0;$ao_u<32;$ao_u++)
                                                {
                                                if($ao_u<10) $ao_d="0".$ao_u; else $ao_d=$ao_u;
                                                echo "<option value=\"".$ao_d."\">".$ao_d."</option>";
                                                }
                                        ?>
                                        </select>/
                                        <select name='ao_mes'>
                                        <?
                                        for($ao_v=0;$ao_v<13;$ao_v++)
                                                {
                                                if($ao_v<10) $ao_m="0".$ao_v; else $ao_m=$ao_v;
                                                echo "<option value=\"".$ao_m."\">".$ao_m."</option>";
                                                }
                                        ?>
                                        </select>/
                                        <select name='ao_ano'>
                                        <?
                                        for($ao_a=$ano-1;$ao_a<$ano+2;$ao_a++)
                                                {
                                                echo "<option value=\"".$ao_a."\">".$ao_a."</option>";
                                                }
                                        ?>
                                        </select></td></tr>
	</table>
	</td>
	</tr>
	<tr>
	<td align=center>
	
	<input type=submit name='registra2' value="Confirmar">
	<input type=reset name='limpa' value="Limpar dados">
	
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
$de=$_POST['de_ano']."-".$_POST['de_mes']."-".$_POST['de_dia'];
$ao=$_POST['ao_ano']."-".$_POST['ao_mes']."-".$_POST['ao_dia'];

//$tabela="oferta_lista_de_ofertas_".$semestre."_".$ano;

$insere_prazo_abertura_telo_LO="insert into oferta_abertura_tela_lo values ('".$de."','".$ao."','".$semestre."','".$ano."')";
	echo $insere_prazo_abertura_telo_LO;
	$res_insere=pg_query($insere_prazo_abertura_telo_LO)  or die ("Problema de acesso ao banco");	
	echo "Prazo de abertura da tela de ofertas (de ".$de." ao ".$ao.") inserido no banco de dados.";
}

	pg_close($idconn);

?>


