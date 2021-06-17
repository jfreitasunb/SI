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
//		echo $x_registro[$i]."<br>";
		if(is_numeric($x_registro[$i])) $num_reuniao=$x_registro[$i];
		$acha_barra=explode("/",$x_registro[$i]);
		if(count($acha_barra)==3) $data_reuniao=$x_registro[$i];
		}
	if(substr_count($registro[0],"/")==0) $data_reuniao="";
	$array_reuniao[$num_reuniao]=$data_reuniao;
	$array_num_reuniao[$j]=$num_reuniao;
//	echo $num_reuniao."---".$data_reuniao."<br>";
	$j=$j+1;
	}
rsort($array_num_reuniao);
// fim funcao

$query_resolucoes=pg_query("select codigo,to_char(data_reuniao,'dd/mm/yyyy'),numero_reuniao,assunto_resolucao from admin_resolucoes_colegiado where submetido='FALSE' order by numero_reuniao desc") or die("problema de conexao 1");

?>

<html>
  <header>
    <link type="text/css" rel="stylesheet" href="../../global/grafic.css">
    <meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
  </header>
  <body>
      <table class=big>
      <form method="POST" name="formu" action="edita_resolucao_2.php">
         <tr>
        <td class=header align=center colspan=2>
        <h1> Resolu&ccedil;&otilde;es do MAT </h1>
        </td>
        </tr>
        <tr><td><INPUT TYPE="radio" NAME="resolucao" VALUE="editar"> Editar a resolu&ccedil;&atilde;o:</td></tr>
	<tr><td>
        <select name='pega_resolucao'>
	<option value="0" selected>--N&atilde;o editar-----</option>
        <?php
        while ($registro=pg_fetch_row($query_resolucoes))
        {
        echo "<option value=\"".$registro[0]."\">Assunto:".$registro[3]." votado na reuni&atolde;o ".$registro[2]." realizada em ".$registro[1]."</option>";
        }
        ?>
        </select></td>
        </tr>
	<tr><td><INPUT TYPE="RADIO" NAME="resolucao" VALUE="criar"> Criar uma nova resolu&ccedil;&atilde;o:</td></tr>
	<tr><td>Escolher a ata das reuni&atilde;o correspondente: 
		<select name='pega_ata'>
		<option value="nova" selected>--Ata ainda n&atilde;o registrada no SI--</option>
		<?php
	        foreach($array_num_reuniao as $key=>$value)
        	{
	        echo "<option value=\"".$value."\"> Ata da reuni&atilde;o ".$value." realizada em ".$array_reuniao[$value]."</option>";
        	}
        	?>
        	</select></td>
	</tr>	
	<tr><td align=center>
        <input type=submit name='confirmar' value="Confirmar">
        </td>
        </tr>
        </table>
        </form>
        </BODY>
</html>
<?php
pg_close($idconn);
?>

