<?php
 include("head_user.php");

if ( $_REQUEST['formulario'] ) {
	$_SESSION['convidado'] = array(
		'convidado' => $_POST['name01'],
		'dia1' => $_POST['dia1'],
		'mes1' => $_POST['mes1'],
		'ano1' => $_POST['ano1'],
		'dia2' => $_POST['dia2'],
		'mes2' => $_POST['mes2'],
		'ano2' => $_POST['ano2'],
	);
?>
<script> window.close(); </script>
<?php
}

?>
<html>
  <header>
     <link type="text/css" rel="stylesheet" href="../../global/grafic.css">
  </header>
  <body>
      <table class=big>
      <form method="POST" name="formu_convidado" action="convidado.php" >
	<input type="hidden" name="formulario" value="1"/>
      <tr><td class=header align=center><h1>Visitantes</h1>Estágiarios, Convidados,Visitantes,...</td></tr>
      <tr><td align=center><table class=form><tr><td colspan=4 class=header align=center>
              Relativo ao Visitante :</td></tr>
<td>Status do Convidado :</td><td><SELECT name='name01'><OPTION selected value="estagiario">Estagiario<OPTION selected value="palestrante">Palestrante<OPTION selected value="prof_visitante">Prof. Visitante</SELECT></td></tr>
<tr><td colspan=4><hr></td></tr>
<tr><td>Data de Admissão :</td><td><input type=integer name='dia1' value="<?php= $_SESSION['convidado']['dia1'] ?>" size='1' maxlength=2 ">/<input type=integer name='mes1' value="<?php= $_SESSION['convidado']['mes1'] ?>" size='1' maxlength=2 ">/<input type=integer name='ano1' value="<?php= $_SESSION['convidado']['ano1'] ?>"size='3' maxlength=4 "></td>
<td>Data de Saída Prevista :</td><td><input type=integer name='dia2' value="<?php= $_SESSION['convidado']['dia2'] ?>" size='1' maxlength=2 ">/<input type=integer name='mes2' value="<?php= $_SESSION['convidado']['mes2'] ?>" size='1' maxlength=2 ">/<input type=integer name='ano2' value="<?php= $_SESSION['convidado']['ano2'] ?>" size='3' maxlength=4 "></td>
            </td>
          </tr>
          </table>
	   <tr>
		<td align=center>
                <input type=submit value="Enviar">
      </td>
      </tr>
</body>
</html>
