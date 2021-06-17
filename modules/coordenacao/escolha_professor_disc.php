<?php
include("head_coordenacao.php");


//$semestre=xx;
//$ano=xx;


?>
<html>
  <header>
    <link type="text/css" rel="stylesheet" href="../../global/grafic.css">
<meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
  </header>


<?php

if(!isset($_POST['registra0']))
{
$ano=date(Y);

$periodo1="1/".$ano;
$periodo2="2/".$ano;

//$tabela="oferta_lista_de_ofertas_".$semestre."_".$ano;
?>
 <body>
      <table class=big>
   <form method="POST" name="formu" action="escolha_professor_disc.php">
      <tr>
        <td class=header align=center colspan=2>
        <h1>Atribui&ccedil;&atilde;o de disciplinas a professores para efeito de aproveitamentos de estudos para o <?php echo $semestre;?>/<?php echo $ano;?></h1>
        </td>
      </tr>
      <tr>
	 <td><table border>
		<tr><td> Escolha o per&iacute;odo:<select name='periodo'>
							<option value="<?php echo $periodo1;?>"><?php echo $periodo1;?></option>
							<option value="<?php echo $periodo2;?>"><?php echo $periodo2;?></option>
						</select></td></tr>
		<tr><td> <input type=submit name='registra0' value="Confirmar"></td></tr>
	</table>
	</form>
	</table>
	</body>
<?php
}



if(!isset($_POST['registra']) and isset($_POST['registra0']))

{
//$ano=date(Y);
//$mes=date(n);
//$semestre=$mes/12;
//if ($semestre<=0.5) $semestre=1; else $semestre=2;

//$periodo=$semestre."/".$ano;
$periodo=$_POST['periodo'];

$periodo_explode=explode("/",$periodo);
$semestre=$periodo_explode[0];
$ano=$periodo_explode[1];

//$tabela="oferta_lista_de_ofertas_".$semestre."_".$ano;

//$select_profs=pg_query("select coduser,name,firstname from users where coduser in (select p.coduser from profs p, oferta_lista_de_ofertas olo where p.coduser=olo.professor and p.situacao='ativo' and olo.semestre='".$semestre."' and olo.ano='".$ano."') order by name");

$query_disciplinas=pg_query("select codigo,nome from disciplinas_MAT where codigo in (select distinct on (disciplina) disciplina from oferta_lista_de_ofertas where semestre='".$semestre."' and ano='".$ano."') order by nome");  

$query_prof_disc=pg_query("select coduser,codigo from aproveitamento_prof_disc where periodo='".$periodo."'");
$prof_disc=array();
while ($registro=pg_fetch_row($query_prof_disc))
	{
	$prof_disc[$registro[1]]=$registro[0];
	}
//print_r($prof_disc);
?>
  <body>
      <table class=big>
   <form method="POST" name="formu" action="escolha_professor_disc.php">
      <tr>
        <td class=header align=center colspan=2>
        <h1>Atribui&ccedil;&atilde;o de disciplinas a professores para efeito de aproveitamentos de estudos para o <?php echo $semestre;?>/<?php echo $ano;?></h1>
        </td>
      </tr>
      <tr>
	<td><table border>
		<tr><td><b>Disciplina</b></td><td><b>Professor</b></td></tr>
				<?php	
				while ($registro_0=pg_fetch_row($query_disciplinas))
				{
				?>
				<tr><td><?php echo $registro_0[1];?></td><td><select name='professor[<?php echo $registro_0[0];?>]'> 
				<option value=0 <?php if(empty($prof_disc[$registro_0[0]]) or ($prof_disc[$registro_0[0]]==0)) echo "selected";?>>---</option>
				<?php
//				$select_profs[$registro_0[0]]=pg_query("select coduser,name,firstname from users where coduser in (select p.coduser from profs p, oferta_lista_de_ofertas olo where p.coduser=olo.professor and p.situacao='ativo' and olo.semestre='".$semestre."' and olo.ano='".$ano."') order by name");
				$select_profs[$registro_0[0]]=pg_query("select coduser,name,firstname from users where coduser in (select coduser from profs where situacao='ativo') order by name");
//				if(empty($prof_disc[$registro_0[0]]) or ($prof_disc[$registro_0[0]]==0)) echo "<option value=\"0\">---</option>";
				while($registro_1[$registro_0[0]]=pg_fetch_row($select_profs[$registro_0[0]]))
					{
					if ($registro_1[$registro_0[0]][0]==$prof_disc[$registro_0[0]]) $selected="selected"; else $selected="";
					echo "<option value=\"".$registro_1[$registro_0[0]][0]."\" ".$selected.">".$registro_1[$registro_0[0]][1]." ".$registro_1[$registro_0[0]][2]."</option>";
					}
				echo "</select><td></tr>";
				}
				?>
		</table> 
		</td>
	</tr>
	<tr>
	<td align=center>
	<input type=submit name='registra' value="Confirmar op&ccedil;&otilde;es">
	<input type=reset name='limpa' value="Limpar formul&aacute;rio">
	<input type=hidden name='semestre' value="<?php echo $semestre;?>">
	<input type=hidden name='ano' value="<?php echo $ano;?>">
	<input type=hidden name='registra0' value="ok">
	</td>
	</tr>
	</table>
	</form>
	</BODY>
	</HTML>

<?php
}

// Inicia gravacao das opcoes

if(isset($_POST['registra']) and isset($_POST['registra0']))

{

$ano=$_POST['ano'];
$semestre=$_POST['semestre'];

$periodo=$semestre."/".$ano;

$professor=$_POST['professor'];

foreach ($professor as $key => $value)
	{
	$query_checa=pg_query("select * from aproveitamento_prof_disc where codigo='".$key."' and periodo='".$periodo."'");
	$num=pg_num_rows($query_checa);
	if ($num==0) $query="insert into aproveitamento_prof_disc values('".$value."','".$key."','".$periodo."')"; else $query="update aproveitamento_prof_disc set coduser='".$value."' where codigo='".$key."' and periodo='".$periodo."'";
//	echo $query;
	$res_query=pg_query($query);
	}  

	echo "Op&ccedil;&otilde;es confirmadas e registradas.";
}
pg_close($idconn);
?>

