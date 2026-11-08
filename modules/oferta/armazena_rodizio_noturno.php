<?PHP
include("head_oferta.php");

?>

<html>
  <header>
    <link type="text/css" rel="stylesheet" href="../../global/grafic.css">
<meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
  </header>
<?php 
// Escolhe semestre e ano:

if (!isset($_POST['registra']))
{
$query_dados=db_query("select coduser,name||' '||firstname as nome from users where tipo_users='professor' order by nome", array());

?>
  <body>
      <table class=big>
      <form method="POST" name="formu" action="armazena_rodizio_noturno.php">
         <tr>
        <td class=header align=center>
        <h1> Armazenar rodizio Noturnodo MAT </h1>
        </td>
      </tr>
      <tr><td>
	<table border> 
	<tr><td><b>Professor</b></td>
		<td><b>94-04</b></td>
		<td><b>1-05</b></td><td><b>2-05</b></td>
		<td><b>1-06</b></td><td><b>2-06</b></td>
		<td><b>1-07</b></td><td><b>2-07</b></td>
		<td><b>1-08</b></td><td><b>2-08</b></td>
		<td><b>1-09</b></td><td><b>2-09</b></td>
		<td><b>1-10</b></td><td><b>2-10</b></td>
		<td><b>1-11</b></td><td><b>2-11</b></td>
	</tr>
	<tr></tr>
	<?php 
	$cor_de_fundo="#FFFFFF";
	$prof=0;
	while ($registro=db_fetch_row($query_dados))
		{
		if ($prof==0) $prof=$registro[0]; 
		else 
		   {
		    if ($registro[0]!=$prof) {if ($cor_de_fundo=="#FFFFFF") $cor_de_fundo="#D0D0D0"; else $cor_de_fundo="#FFFFFF";}
		   }
		?>
		<tr VALIGN=CENTER BGCOLOR="<?php  echo $cor_de_fundo;?>">
		<td><?php  echo $registro[1];?></td>
		<td><input type=text name='acumulado[<?php  echo $registro[0];?>]' maxlength="2" size=1></td>
		<td><input type=text name='1_05[<?php  echo $registro[0];?>]' maxlength="1" size=1></td><td><input type=text name='2_05[<?php  echo $registro[0];?>]' maxlength="1" size=1></td>
		<td><input type=text name='1_06[<?php  echo $registro[0];?>]' maxlength="1" size=1></td><td><input type=text name='2_06[<?php  echo $registro[0];?>]' maxlength="1" size=1></td>
		<td><input type=text name='1_07[<?php  echo $registro[0];?>]' maxlength="1" size=1></td><td><input type=text name='2_07[<?php  echo $registro[0];?>]' maxlength="1" size=1></td>
		<td><input type=text name='1_08[<?php  echo $registro[0];?>]' maxlength="1" size=1></td><td><input type=text name='2_08[<?php  echo $registro[0];?>]' maxlength="1" size=1></td>
		<td><input type=text name='1_09[<?php  echo $registro[0];?>]' maxlength="1" size=1></td><td><input type=text name='2_09[<?php  echo $registro[0];?>]' maxlength="1" size=1></td>
		<td><input type=text name='1_10[<?php  echo $registro[0];?>]' maxlength="1" size=1></td><td><input type=text name='2_10[<?php  echo $registro[0];?>]' maxlength="1" size=1></td>
		<td><input type=text name='1_11[<?php  echo $registro[0];?>]' maxlength="1" size=1></td><td><input type=text name='2_11[<?php  echo $registro[0];?>]' maxlength="1" size=1></td>
		</tr>
	<?php 
		}
	?>
	</table>
	</td></tr> 
	<tr><td align=center><input type=submit name='registra' value='Registrar'></td></tr>
	</form>
	</table>
	</body>
	</html>
	<?php 
}

if (isset($_POST['registra']))
{

$query_dados=db_query("select coduser from users where tipo_users='professor'", array());

$acumulado=$_POST['acumulado'];
$um_05=$_POST['1_05'];
$dois_05=$_POST['2_05'];

$um_06=$_POST['1_06'];
$dois_06=$_POST['2_06'];

$um_07=$_POST['1_07'];
$dois_07=$_POST['2_07'];

$um_08=$_POST['1_08'];
$dois_08=$_POST['2_08'];

$um_09=$_POST['1_09'];
$dois_09=$_POST['2_09'];

$um_10=$_POST['1_10'];
$dois_10=$_POST['2_10'];

$um_11=$_POST['1_11'];
$dois_11=$_POST['2_11'];

	while ($registro=db_fetch_row($query_dados))
		{
		if ($acumulado[$registro[0]]=="") $acumula=0; else $acumula=$acumulado[$registro[0]];
		list($query_insere_acumulado, $query_insere_acumulado__p) = array("insert into oferta_horario_noturno_acumulado_94_04 values(?,?)", array($registro[0], $acumula));
		$res_acumulado=db_query($query_insere_acumulado, $query_insere_acumulado__p);
//		echo $query_insere_acumulado."\n";

		if ($um_05[$registro[0]]=="") $turno=0; else $turno=$um_05[$registro[0]];
		list($query_insere, $query_insere__p) = array("insert into oferta_horarios_rodizio_noturno values(?,'1','2005',?)", array($registro[0], $turno));
		$res_insere=db_query($query_insere, $query_insere__p);
//		echo $query_insere."\n";

		if ($dois_05[$registro[0]]=="") $turno=0; else $turno=$dois_05[$registro[0]];
		list($query_insere, $query_insere__p) = array("insert into oferta_horarios_rodizio_noturno values(?,'2','2005',?)", array($registro[0], $turno));
		$res_insere=db_query($query_insere, $query_insere__p);
//		echo $query_insere."\n";

		if ($um_06[$registro[0]]=="") $turno=0; else $turno=$um_06[$registro[0]];
		list($query_insere, $query_insere__p) = array("insert into oferta_horarios_rodizio_noturno values(?,'1','2006',?)", array($registro[0], $turno));
		$res_insere=db_query($query_insere, $query_insere__p);
//		echo $query_insere."\n";

		if ($dois_06[$registro[0]]=="") $turno=0; else $turno=$dois_06[$registro[0]];
		list($query_insere, $query_insere__p) = array("insert into oferta_horarios_rodizio_noturno values(?,'2','2006',?)", array($registro[0], $turno));
		$res_insere=db_query($query_insere, $query_insere__p);
//		echo $query_insere."\n";

		if ($um_07[$registro[0]]=="") $turno=0; else $turno=$um_07[$registro[0]];
		list($query_insere, $query_insere__p) = array("insert into oferta_horarios_rodizio_noturno values(?,'1','2007',?)", array($registro[0], $turno));
		$res_insere=db_query($query_insere, $query_insere__p);
//		echo $query_insere."\n";

		if ($dois_07[$registro[0]]=="") $turno=0; else $turno=$dois_07[$registro[0]];
		list($query_insere, $query_insere__p) = array("insert into oferta_horarios_rodizio_noturno values(?,'2','2007',?)", array($registro[0], $turno));
		$res_insere=db_query($query_insere, $query_insere__p);
//		echo $query_insere."\n";

		if ($um_08[$registro[0]]=="") $turno=0; else $turno=$um_08[$registro[0]];
		list($query_insere, $query_insere__p) = array("insert into oferta_horarios_rodizio_noturno values(?,'1','2008',?)", array($registro[0], $turno));
		$res_insere=db_query($query_insere, $query_insere__p);
//		echo $query_insere."\n";

		if ($dois_08[$registro[0]]=="") $turno=0; else $turno=$dois_08[$registro[0]];
		list($query_insere, $query_insere__p) = array("insert into oferta_horarios_rodizio_noturno values(?,'2','2008',?)", array($registro[0], $turno));
		$res_insere=db_query($query_insere, $query_insere__p);
//		echo $query_insere."\n";

		if ($um_09[$registro[0]]=="") $turno=0; else $turno=$um_09[$registro[0]];
		list($query_insere, $query_insere__p) = array("insert into oferta_horarios_rodizio_noturno values(?,'1','2009',?)", array($registro[0], $turno));
		$res_insere=db_query($query_insere, $query_insere__p);
//		echo $query_insere."\n";

		if ($dois_09[$registro[0]]=="") $turno=0; else $turno=$dois_09[$registro[0]];
		list($query_insere, $query_insere__p) = array("insert into oferta_horarios_rodizio_noturno values(?,'2','2009',?)", array($registro[0], $turno));
		$res_insere=db_query($query_insere, $query_insere__p);
//		echo $query_insere."\n";

		if ($um_10[$registro[0]]=="") $turno=0; else $turno=$um_10[$registro[0]];
		list($query_insere, $query_insere__p) = array("insert into oferta_horarios_rodizio_noturno values(?,'1','2010',?)", array($registro[0], $turno));
		$res_insere=db_query($query_insere, $query_insere__p);
//		echo $query_insere."\n";

		if ($dois_10[$registro[0]]=="") $turno=0; else $turno=$dois_10[$registro[0]];
		list($query_insere, $query_insere__p) = array("insert into oferta_horarios_rodizio_noturno values(?,'2','2010',?)", array($registro[0], $turno));
		$res_insere=db_query($query_insere, $query_insere__p);
//		echo $query_insere."\n";

		if ($um_11[$registro[0]]=="") $turno=0; else $turno=$um_11[$registro[0]];
		list($query_insere, $query_insere__p) = array("insert into oferta_horarios_rodizio_noturno values(?,'1','2011',?)", array($registro[0], $turno));
		$res_insere=db_query($query_insere, $query_insere__p);
//		echo $query_insere."\n";

		if ($dois_11[$registro[0]]=="") $turno=0; else $turno=$dois_11[$registro[0]];
		list($query_insere, $query_insere__p) = array("insert into oferta_horarios_rodizio_noturno values(?,'2','2011',?)", array($registro[0], $turno));
		$res_insere=db_query($query_insere, $query_insere__p);
//		echo $query_insere."\n";
		}
}

db_close($idconn);
?>

