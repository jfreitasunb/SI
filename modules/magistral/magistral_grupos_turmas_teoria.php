<?PHP // criação de grupos de turmas para teoria
include("head_magistral.php");

?>
<html>
  <header>
    <link type="text/css" rel="stylesheet" href="../../global/grafic.css">
<meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
  </header>


<?

if (isset($_POST['registra']) and isset($_POST['submit']))
{
$lista=explode("_",$_POST['lista']);
$dado=explode("-",$_POST['disciplina']);
$disciplina=$dado[0];
$creditos_teor=$dado[1];
$turma_usada=array();
$indice_usada=0;
$turma=array();

//echo $creditos_teor."-".$disciplina;

$horas=array("08","10","14","16","19","21");
$dias=array("2","3","4","5","6","7");
$linhas=array();

//pega creditos:
$query_creditos=pg_query("select creditos from disciplinas_mat where codigo='".$disciplina."'");
$creditos=pg_fetch_result($query_creditos,0,0);
$comando="SUBSTRING (horarios,1,3) as horario_1";
$order_by="horario_1";
for ($i=1;$i<$creditos/2;$i++)
	{
	$j=$i+1;
	$k=$i*4+1;
	$comando.=",SUBSTRING (horarios,".$k.",3) as horario_".$j;
	$order_by.=",horario_".$j;
	}
// pega os horarios:
$query_turmas=pg_query("select turma,".$comando." from oferta_semestres where codigo='".$disciplina."' and semestre in ('12','1','2') order by ".$order_by);

// pega os grupos já prontos em table oferta_grupos_magistral_teoria: grupo,codigo,turmas,horario
$query_grupos=pg_query("select * from oferta_grupos_magistral_teoria where codigo='".$disciplina."' and semestre='".$lista[0]."' and ano='".$lista[1]."' order by grupo,horario,turmas");
//$grupos=pg_fetch_all($query_grupos);

//echo $num_grupos;
//print_r($grupos);

/*
Ver quais são os horários que podem ser usados para a(s) aula(s) magistral(is) e agrupar as turmas de acordo com esses horários. A seleção é feita escolhendo-se 2 turmas no horário mostrado e montando-se assim os grupos de acordo com o máximo de créditos que nos intressa por grupo. 
ex.: 210: turmas A,B,C,D etc
308: turmas A,C,O, P...
Os grupos são montados 1 a 1. Para montar um grupo, mostra-se os grupos já existentes e somente as turmas que sobraram poderão ser usadas.
Coluna  |     Tipo     | Modificadores 
---------+--------------+---------------
 grupo   | smallint     | 
 codigo  | integer      | 
 turmas  | character(1) | 
 horario | smallint     | 
*/

?>
  <body>
      <table class=big>
   <form method="POST" name="formu" action="magistral_grupos_turmas_teoria_2.php">
      <tr>
        <td class=header align=center colspan=2>
        <h1>Cria&ccedil;&atilde;o de grupos de turmas da disciplina <? echo $disciplina;?></h1>
        </td>
      </tr>
      <tr><td align=center><table border>
				<tr><td><b>Grupos existentes</b>(Eliminar?)</b></td><td><b>Turmas</b></td><td><b>Hor&aacute;rio da aula te&oacute;rica</b></td></tr>
		<?
  		$cor_de_fundo="#FFFFFF";
	        $grupo=0;
		$indice_usada=0;
		$linha=array();
		while($registro_1=pg_fetch_row($query_grupos))
                	      {
	                      if ($registro_1[0]!=$grupo)
        	                        {
					$linha[$registro_1[0]]=array();
			//		echo $registro_1[0]."<br>";
					if($grupo!=0) 
						{
						$linha[$grupo][0]="<tr VALIGN=CENTER BGCOLOR=".$cor_de_fundo."><td rowspan=".count($linha[$grupo])."><input type=checkbox name='retirados[".$grupo."]' value=\"".$grupo."\">".$linha[$grupo][0];
						for($j=0;$j<count($linha[$grupo]);$j++)
							{
							echo $linha[$grupo][$j];
							}
						}
					$i=0;
                                	$grupo=$registro_1[0];
	                                if ($cor_de_fundo=="#FFFFFF") $cor_de_fundo="#D0D0D0"; else $cor_de_fundo="#FFFFFF";
        	                        $linha[$grupo][$i]=$registro_1[0]."</td><td>".$registro_1[2]."</td><td>".$registro_1[3]."</td></tr>";
					}
			      else 
					{
					$i=$i+1;
					$linha[$grupo][$i]="<tr VALIGN=CENTER BGCOLOR=".$cor_de_fundo."><td>".$registro_1[2]."</td><td>".$registro_1[3]."</td></tr>";
					}
	                      $turma_usada[$indice_usada]=$registro_1[2];
        	              $indice_usada=$indice_usada+1;
                	      }
		if($grupo!=0) 
			{
			$linha[$grupo][0]="<tr VALIGN=CENTER BGCOLOR=".$cor_de_fundo."><td rowspan=".count($linha[$grupo])."><input type=checkbox name='retirados[".$grupo."]' value=\"".$grupo."\">".$linha[$grupo][0];
	                for($j=0;$j<count($linha[$grupo]);$j++)
                             {
                              echo $linha[$grupo][$j];
                             }
			}
		?>
	</td>                      
        </tr>
	</TABLE></tr>
	<? // determinacao da array de turmas sobrando por horario (hora.dia).
	   while ($registro=pg_fetch_row($query_turmas))
                 {
		 if(!in_array($registro[0],$turma_usada)) 
			{
			for ($i=1;$i<count($registro);$i++)
				{
				$turma[substr($registro[$i],1)][$registro[$i]{0}].=$registro[0];
				}
			}
		 }
           foreach($horas as $key =>$value) // contar quantas linhas (turnmas) devo colocar em cada quadrado da tabela.
		{
                foreach($dias as $key0 =>$value0) 
			{
			$linhas[$value][$value0]=strlen($turma[$value][$value0]);
			} 
		}
//print_r($turma);
	?>
	<tr><td> Cria&ccedil;&atilde;o de um novo grupo para a disciplina <? echo $disciplina;?></td></tr>
	<tr><td align=center> <table border>
			<tr><td></td><td><b>Segunda</b></td><td><b>Ter&ccedil;a</b></td><td><b>Quarta</b></td><td><b>Quinta</b></td><td><b>Sexta</b></td><td><b>S&aacute;bado</b></td></tr>
	<?
	 $cor_de_fundo="#FFFFFF";
           foreach($horas as $key =>$value) // contar quantas linhas (turnmas) devo colocar em cada quadrado da tabela.
		{
		// procura o maior número de linhas neste horário: 
		$num_linhas=0;
                foreach($dias as $key2 =>$value2) 
			{
			if ($linhas[$value][$value2]>$num_linhas) $num_linhas=$linhas[$value][$value2];
			} 		
		if($num_linhas>0) 
			{
			for($i=0;$i<$num_linhas;$i++)
				{
				if($i==0) 
					{
					if ($cor_de_fundo=="#FFFFFF") $cor_de_fundo="#D0D0D0"; else $cor_de_fundo="#FFFFFF";
					$linha_impressa="<tr VALIGN=CENTER BGCOLOR=".$cor_de_fundo."><td rowspan=".$num_linhas.">".$value."</td>"; 
					}
				else $linha_impressa="<tr VALIGN=CENTER BGCOLOR=".$cor_de_fundo.">";
		       	         foreach($dias as $key2 =>$value2) 
						{
						if(($i<=$linhas[$value][$value2]) and isset($turma[$value][$value2]{$i})) $linha_impressa.="<td><input type=checkbox name='dados[".$value."][".$value2."][".$i."]' value=\"".$value2.$value."-".$turma[$value][$value2]{$i}."\">".$turma[$value][$value2]{$i}."</td>"; else $linha_impressa.="<td></td>";
						} 
				$linha_impressa.="</tr>";
				echo $linha_impressa;
				}
			}
	        else echo "<tr><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td></tr>";
		}
	?>		
        </table></td></tr>
	<tr>
	<td align=center>
	<input type=hidden name='lista' value="<? echo $lista[0]."_".$lista[1];?>">
	<input type=hidden name='disciplina' value="<? echo $disciplina;?>">
	<input type=submit name='submit' value="Confirmar op&ccedil;&otilde;es">
	</td>
	</tr>
	</form>
	</table>
	</BODY>
	</HTML>
<?

}

if (isset($_POST['registra']) and !isset($_POST['submit']))
{
$lista=explode("_",$_POST['lista']);

$query_magistral=pg_query("select nome, m.codigo, m.teoria, d.creditos from disciplinas_mat d, oferta_disciplinas_magistral m where d.codigo=m.codigo and semestre='".$lista[0]."' and ano='".$lista[1]."' order by nome");

?>
  <body>
      <table class=big>
   <form method="POST" name="formu" action="magistral_grupos_turmas_teoria.php">
      <tr>
        <td class=header align=center colspan=2>
        <h1>Cria&ccedil;&atilde;o de grupos de turmas de mesmo hor&aacute;rio no esquema magistral</h1>
        </td>
      </tr>
      <tr><td align=center><table border>
				<tr><td></td><td><b>C&oacute;digo</b></td><td><b>Disciplina</b></td><td><b>Cr&eacute;ditos totais</b></td><td><b>Cr&eacute;ditos teoria</b></td></tr>
		<?
                while ($registro_1=pg_fetch_row($query_magistral))
                      {
                      echo "<tr><td><input type=radio name='disciplina' value=\"".$registro_1[1]."-".$registro_1[2]."\"></td><td>".$registro_1[1]."</td><td>".$registro_1[0]."</td><td>".$registro_1[3]."</td><td>".$registro_1[2]."</td><td></tr>";  
                      }
		?>
	</td>                      
        </tr>
	</TABLE>
        <tr>
	<td align=center>
	<input type=hidden name='lista' value="<? echo $lista[0]."_".$lista[1];?>">
	<input type=hidden name='registra' value="Confirmar op&ccedil;&otilde;es">
	<input type=submit name='submit' value="Confirmar op&ccedil;&otilde;es">
	</td>
	</tr>
	</form>
	</table>
	</BODY>
	</HTML>
<?php
}


if(!isset($_POST['registra']))
{
?>

<html>
  <header>
    <link type="text/css" rel="stylesheet" href="../../global/grafic.css">
<meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
  </header>
<?
// Escolhe semestre e ano:


//$query_listas=pg_query("SELECT semestre, ano FROM oferta_disciplinas_magistral AS om WHERE (NOT EXISTS (SELECT semestre,ano FROM oferta_acusa_lista AS oa WHERE (om.semestre= oa.semestre) OR (om.ano= oa.ano)))");
//$query_acusa_lista=pg_query("select * from oferta_acusa_lista where encaminhada='nova' order by ano desc, semestre desc");
$query_listas=pg_query("select * from oferta_acusa_lista where encaminhada='nova' order by ano desc, semestre desc");
$registro=pg_fetch_row($query_listas);
//print_r($registro);
?>
  <body>
      <table class=big>
      <form method="POST" name="formu" action="magistral_grupos_turmas_teoria.php">
         <tr>
        <td class=header align=center colspan=2>
        <h1> Lista de Ofertas do MAT </h1>
        </td>
      </tr>
      <tr><td><select name='lista'>
	<?php
	for ($i=0;$i<count($registro);$i++)
	//while($registro=pg_fetch_row($query_listas))
	{
	echo "<option value=\"".$registro[0]."_".$registro[1]."\">".$registro[0]."/".$registro[1]."</option>";
	}
	?>
	</select></td></tr>
        <tr><td align=center>
        <input type=submit name='registra' value="Confirmar op&ccedil;&otilde;es">
        </td>
        </tr>
        </table>
        </form>
        </BODY>
</html>
<?
}

pg_close($idconn);
?>

