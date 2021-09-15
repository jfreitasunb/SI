<?php
  include("head_licencas.php");
?>
<html>
    <link type="text/css" rel="stylesheet" href="../../global/grafic.css">
<base target="baixo">
<body leftmargin="0">

	<form name="utilisateur2" action="relat_licencas.php" method="POST">
	<table class=form align=center>
	<tr>
	<td>
        <table align=center class=form>
        <tr>
          <td class=header align=center colspan=2>Selecione um ano:</td><td><input type=integer name='ano' maxlength="4" size="3"></td>
	  </tr>
        </table>
	<br>
        <table align=center class=form>
        <tr>
	<td><input type=submit value='Confirmar'>
	</td></tr>
	</table>
	</form>
	</body>
	</html>
<?php	

  pg_close($idconn);
?>


