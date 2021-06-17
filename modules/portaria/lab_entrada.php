<?php
  include("head_account.php");
?>
<html>
<header>
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
          <h1>Controle de Acesso</h1>Informa&ccedil;&otilde;es sobre o aluno
        </td>
      </tr>
      <tr>
        <td align=center>
               <title>Cadastrar Acesso</title>
<?php
if(!isset($_POST["enviar"]))
{
?>
<form method="POST" action="lab_entrada.php"><p>
<tr>
        <td align=center>
          <table class=form>
          <tr>
            <td colspan=4 class=header align=center>
              Descria&ccedil;&atilde;o do Aluno :
            </td>
          </tr>
          <td> Matricula : <input type="text" name="matricula" size="20"></td>
	<input type="hidden" name="enviar" value="S">
<?php
}
else   // cadastra entrada
{
	$matricula=$_POST["matricula"];
	$res = pg_query("SELECT * FROM aluno  where matricula='$matricula'");
	if(pg_affected_rows($res)>0)
		echo "<p align='center'>Acesso Liberado!</p>";
	else	{
		$erro = pg_last_error();
		echo "<p align='center'>Erro: $erro</p>";
	}
}
?>
</table><br>
<input type="submit" value="Cadastrar Acesso" name="incluir"></p>
</form><p align="center"><a href="javascript:history.back();">Voltar</a></p>
</body>
</html>
