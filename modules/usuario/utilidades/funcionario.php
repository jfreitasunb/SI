<?php
 include("head_user.php");

if ( $_REQUEST['formulario'] ) {
	$_SESSION['funcionario'] = array(
		'contract_duration' => $_POST['contract_duration'],
		'contract_type' => $_POST['contract_type'],
		'statut' => $_POST['statut'],
		'raison' => $_POST['raison'],
		'dia1' => $_POST['dia1'],
		'mes1' => $_POST['mes1'],
		'ano1' => $_POST['ano1'],
		'dia2' => $_POST['dia2'],
		'mes2' => $_POST['mes2'],
		'ano2' => $_POST['ano2'],
		'dia3' => $_POST['dia3'],
		'mes3' => $_POST['mes3'],
		'ano3' => $_POST['ano3'],
		'dia4' => $_POST['dia4'],
		'mes4' => $_POST['mes4'],
		'ano4' => $_POST['ano4'],
		'dia5' => $_POST['dia5'],
		'mes5' => $_POST['mes5'],
		'ano5' => $_POST['ano5'],
	);
?>
<script> window.close(); </script>
<?php
}
?>
<html>
  <header><link type="text/css" rel="stylesheet" href="../../global/grafic.css"></header>
  <body>
      <table class=big>
      		<form method="POST" name="formu" action="funcionario.php">
		<input type="hidden" name="formulario" value="1"/>
      		<tr>
		<td class=header align=center><h1>Funcionários</h1>Atualização de Dados</td>
		</tr>
		<tr>
		<td align=center><table class=form>
		<tr>
		<td colspan=4 class=header align=center>Relativo ao Funcionário :</td>
		</tr>
		<tr>
		<td>Data de Admissão :</td>
			<td><input type=integer name='dia1' value="<?php= $_SESSION['funcionario']['dia1'] ?>" size='1' maxlength=2 ">/<input  		type=integer name='mes1' value="<?php= $_SESSION['funcionario']['mes1'] ?>" size='1' maxlength=2 ">/<input type=integer name='ano1' value="<?php= $_SESSION['funcionario']['ano1'] ?>"size='3' maxlength=4 ">
			</td>    
			<td>Duração Contratual :</td><td><SELECT NAME='contract_duration'><OPTION selected value="6">06 meses<OPTION selected value="12">1 ano<OPTION selected value="24">2 anos<OPTION selected value="360">30 anos<OPTION selected value="420">35 anos</SELECT></td>
		</tr>
		<tr>
		<td>Status :</td><td><SELECT NAME='statut'><OPTION selected value="professor">Professor<OPTION selected value="administrativo">Administrativo</SELECT>
		<td>Tipo Contratual :</td><td><SELECT NAME='contract_type'><OPTION selected value="dedicacao_exclusiva">Dedicacao exclusiva<OPTION selected value="tempo_parcial">Tempo Parcial<OPTION selected value="prestacao_de_servico">Prestacao de Servico<OPTION selected value="prof_substituto">Professor Substituto</SELECT>
		</tr>
     </table></td></tr>
      <tr>
      <td align=center>
    <table class=form>
      <tr><td colspan=4 class=header align=center>
     
 Férias Previstas:</td></tr>

     <tr><td>Inicio :
	</td><td><input type=integer name='dia2' value="<?php= $_SESSION['funcionario']['dia2'] ?>" size='1' maxlength=2 >/<input type=integer2 name='mes2' value="<?php= $_SESSION['funcionario']['mes2'] ?>" size='1' maxlength=2 >/<input type=integer name='ano2' value="<?php= $_SESSION['funcionario']['ano2'] ?>"size='3' maxlength=4 "></td><tr>

	<tr><td>Termino :</td><td>
	<input type=integer name='dia3' value="<?php= $_SESSION['funcionario']['dia3'] ?>" size='1' maxlength=2 ">/<input type=integer name='mes3' value="<?php= $_SESSION['funcionario']['mes3'] ?>" size='1' maxlength=2 ">/<input type=integer name='ano3' value="<?php= $_SESSION['funcionario']['ano3'] ?>"size='3' maxlength=4 "></td>
    </table></td></tr>
    <tr><td align=center><table class=form>

      <tr><td class=header colspan=4 align=center>Licenças ou Ausências Acidentais :</td></tr>

	<tr><td>Inicio :</td><td>
	<input type=integer name='dia4' value="<?php= $_SESSION['funcionario']['dia4'] ?>" size='1' maxlength=2 ">/<input type=integer name='mes4' value="<?php= $_SESSION['funcionario']['mes4'] ?>" size='1' maxlength=2 ">/<input type=integer name='ano4' value="<?php= $_SESSION['funcionario']['ano4'] ?>"size='3' maxlength=4 "></td>
	<tr><td>Termino:</td><td>
	<input type=integer name='dia5' value="<?php= $_SESSION['funcionario']['dia5'] ?>" size='1' maxlength=2 ">/<input type=integer name='mes5' value="<?php= $_SESSION['funcionario']['mes5'] ?>" size='1' maxlength=2 ">/<input type=integer name='ano5' value="<?php= $_SESSION['funcionario']['ano5'] ?>"size='3' maxlength=4 "></td>
      <tr><td>Motivo da Ausência:</td><td>
	<SELECT name='raison'><OPTION selected value="sem_licenca">sem licenca<OPTION selected value="doenca">Doenca<OPTION selected value="participacao_congresso">Participacao Congresso<OPTION selected value="participacao_banca">Participacao em banca<OPTION selected value="licenca_maternidade">Licenca Maternidade<OPTION selected value="licenca_paternidade">Licenca Paternidade<OPTION selected value="outros">Outros</SELECT></td></tr>
    </table></td></tr>
    <tr><td align=center><input type=submit value="Enviar"></td></tr>
</form>
</table>
</body>
</html>
