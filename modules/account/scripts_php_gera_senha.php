<?php

require("head_account.php");

 
function generatePassword() 
{
	return gera_senha_segura(12);
}


?>
<html>
<header>
   <script language="javascript">
    <script language=javascript src="function_js.js">
    </script>
    <script language=javascript src="formu.js">
    </script>
    <link type="text/css" rel="stylesheet" href="../../global/grafic.css">
  </header>
<body>
<table class=big>
      <tr>
        <td class=header align=center>
          <h1>Cria&ccedil;&atilde;o de senha</h1>
        </td>
      </tr>
      <tr>
        <td align=center>
      <?php
      ////////////////// VERIFICA SE O FORMULARIO ESTA PREENCHIDO ////////////////////////////////////////////////
if(!isset($_POST['enviar'])) // Se campos do formulario estiverem em branco, faça .....
	{
?>
<form name="gera_senha" method="POST" action=""scripts_php_gera_senha.php"><p>
<tr>
        <td align=center>
          <table class=form>
          <tr>
            <td colspan=4 class=header align=center>
              Cria&ccedil;&atilde;o de senha :
            </td>
          </tr>
          <tr>
	</tr>
	</table><br>
	<input type="submit" value="Criar senha" name="enviar"> 
	</form>
	</body>
	</html>
<?php

	}
else	////////////////// Pesquisa do equipamento ///////////////////////////////////////////////////////////////////////////
{
$senha=generatePassword($_POST['caracteres'], $_POST['forca']);

echo "A senha &eacute;: ".h($senha);

}

 
?>

