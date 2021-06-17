<?php  // Inserir nova ou editar uma resolução
include("head_resolucoes.php");

// funcao que pega e trata  numero da ata:
$array_reuniao=array();
$array_num_reuniao=array();

$query_atas=pg_query("select assunto from admin_documentador where id_tipo='5'") or die("problema de conexao 0");;
$j=0;
while($registro=pg_fetch_row($query_atas))
        {
        $x_registro=explode(" ",$registro[0]);
        for ($i=0;$i<count($x_registro);$i++)
                {
//              echo $x_registro[$i]."<br>";
                if(is_numeric($x_registro[$i])) $num_reuniao=$x_registro[$i];
                $acha_barra=explode("/",$x_registro[$i]);
                if(count($acha_barra)==3) $data_reuniao=$x_registro[$i];
                }
        if(substr_count($registro[0],"/")==0) $data_reuniao="";
        $array_reuniao[$num_reuniao]=$data_reuniao;
        $array_num_reuniao[$j]=$num_reuniao;
//      echo $num_reuniao."---".$data_reuniao."<br>";
        $j=$j+1;
        }
rsort($array_num_reuniao);
// fim funcao

if($_POST['resolucao']=="editar")  
	{
	$query_resolucao=pg_query("select codigo,to_char(data_reuniao,'dd/mm/yyyy') as data_reuniao,numero_reuniao,assunto_resolucao,texto_resolucao from admin_resolucoes_colegiado where codigo='".$_POST['pega_resolucao']."'") or die("problema de conexao 2.0");
	$dados=pg_fetch_array($query_resolucao,0);
	}
if($_POST['resolucao']=="criar")  
	{
	$dados['codigo']=0;
	if($_POST['pega_ata']=="nova") 
		{
		$dados['data_reuniao']="";
		$dados['numero_reuniao']="";
		}
	else 
		{
		$dados['data_reuniao']=$array_reuniao[$_POST['pega_ata']];
		$dados['numero_reuniao']=$_POST['pega_ata'];
		}
	$dados['assunto_resolucao']="";
	$dados['texto_resolucao']="";
	}
?>
<html>
  <header>
    <link type="text/css" rel="stylesheet" href="../../global/grafic.css">
    <meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
  </header>
  <body>
      <table class=big>
      <form method="POST" name="formu" action="edita_resolucao_3.php">
         <tr>
        <td class=header align=center colspan=2>
        <h1> Resolu&ccedil;&otilde;es do MAT </h1>
        </td>
        </tr>
	<tr><td><b>Data da reuni&atilde;o de colegiado:</b> <input type=text maxlength=10 size=11 name='dados[data_reuniao]' value="<?php echo $dados['data_reuniao'];?>"></td></tr>
	<tr><td><b>Reuni&atilde;o de colegiado n&uacute;mero:</b> <input type=text maxlength=4 size=3 name='dados[numero_reuniao]' value="<?php echo $dados['numero_reuniao'];?>"></td></tr>
	<tr><td><b>Assunto da resolu&ccedil;&atilde;o de colegiado:</b> <textarea cols=30 rows=1 name='dados[assunto_resolucao]'> <?php echo $dados['assunto_resolucao'];?></textarea></td></tr>
	<tr><td><b>Texto da resolu&ccedil;&atilde;o de colegiado:</b></td></tr>
	<tr><td><textarea cols=60 rows=20 name='dados[texto_resolucao]'><?php echo $dados['texto_resolucao'];?></textarea></td></tr>
	<TR><td><INPUT TYPE="RADIO" NAME="salva_tipo" VALUE="rascunho"> Salvar rascunho</td></tr>
	<tr><td><INPUT TYPE="RADIO" NAME="salva_tipo" VALUE="definitivo"> Salvar vers&atilde;o definitiva </td></tr>
	<tr><td align=center>
	<input type=submit name='confirma' value="Confirmar">
	<input type=hidden name='dados[codigo]' value="<?php echo $dados['codigo'];?>">
        </td>
        </tr>
        </table>
        </form>
        </BODY>
</html>
<?php
pg_close($idconn);
?>

