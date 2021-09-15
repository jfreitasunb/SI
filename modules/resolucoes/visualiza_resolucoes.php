<?php include("head_resolucoes.php"); ?>
<html>
<header>
    <script language=javascript src="function_js.js">
    </script>
    <script language=javascript src="formu.js">
    </script>
    <script language=javascript>
function verif_touche(e)
        {
        if(e.keyCode)touche = e.keyCode;
        else touche = e.which;
        if((touche>=48 && touche <= 57) || (touche==8) || (touche==9)) return true;
        else return false;
        }
    </script>
    <link type="text/css" rel="stylesheet" href="../../global/grafic.css">
<meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
  </header>
<body>
<table class=big>
      <tr>
        <td class=header align=center>
          <h1>Departamento de Matematica</h1>
        </td>
      </tr>
      <tr>
        <td align=center>
               <title>Servidor Administrativo</title>
<?php
	echo " 	<h1>Buscar Resolu&ccedil;&otilde;es</h1>
		<p> Escolha abaixo o tipo de busca. </p> ";

?>

<form action='visualiza_resolucoes_finais.php' method='post'>
<table><br>
        
	<tr>
	<td><b>Por ata:</b></td><td><input type="text" name="ata" maxlength="10" size="5"></td>
	</tr>
	<tr>
	<td><b>Assunto:</b></td><td><input type="text" name="assunto" maxlength="40"></td>
	</tr>
	<tr>
	<td><b>N&uacute;mero da resolu&ccedil;&atilde;o:</b></td><td><input type="text" name="numero_resolucao" maxlength="3" size="2"></td>
	</tr>
	<tr>
	<td><b>Ano:</b></td><td><input type="text" name="anoresolucao" maxlength="5" size="5">
	</tr>
		
</table><br>


<table>
	<input type='submit' name='busca' value='Buscar'>
</table>
</form>
</table>
</body>
</html>

