<?php

require("head_account.php");

 
function generatePassword() 
{
	$length=rand(8, 10);
	$strength=4;
	$vowels = 'aeiouy';
	$consonants = 'bcdfghjklmnpqrstvwxz';
	if ($strength >= 1) {
		$consonants .= 'BCDFGHJKLMNPQRSTVWXZ';
	}
	if ($strength >= 2) {
		$vowels .= "AEIOUY";
	}
	if ($strength >= 3) {
		$consonants .= '0123456789';
	}
	if ($strength >= 4) {
		$consonants .= '#$%?';
	}
 
	$password = '';
	$alt = time() % 2;
	for ($i = 0; $i < $length; $i++) {
		if ($alt == 1) {
			$password .= $consonants[(rand() % strlen($consonants))];
			$alt = 0;
		} else {
			$password .= $vowels[(rand() % strlen($vowels))];
			$alt = 1;
		}
	}
	return $password;
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

echo "A senha &eacute;: ".$senha;

}

 
?>

