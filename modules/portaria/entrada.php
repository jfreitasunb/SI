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
          <h1>Altera&ccedil;&atilde;o de Entrada</h1>Informa&ccedil;&otilde;es sobre o aluno
        </td>
      </tr>
      <tr>
        <td align=center>
               <title>Registro de Aluno</title>
<?php
if(!isset($_POST["codigo"]))	// solicita a matricula
{
?>
	<form method="POST" action="entrada.php">
	<tr><td align=center>
        <table class=form><tr><td colspan=4 class=header align=center>
	Matricula :   </td></tr><tr><td> Matricula: </td>
              <td><input type="text" name="matricula" size="20"></td>
  	      <td><input type="submit" value="Entrada" name="alterar"></td>
	</form>
<?php
}
elseif(!isset($_POST["enviar"]))		// busca os dados do aluno
{
	$matricula=$_POST["matricula"];
	$sql = "SELECT * FROM aluno WHERE matricula=$matricula";
	$res = pg_query($sql);
	if(pg_num_rows($res)==0)
		echo "Aluno nao cadastrado, procurar a coordenacao de informatica";
	else
	{
		$registro=pg_fetch_row($res);
		$matricula=$registro[0];
		$nome=$registro[1]

?>
		<form method="POST" action="entrada.php"><tr>
        <td align=center>
          <table class=form>
          <tr>
            <td colspan=4 class=header align=center>
              Dados do Aluno :
            </td>
          </tr>
          <tr>
            <td><p>Matricula: <b><?php echo $matricula; ?></b></td>
            <tr><td> Nome :</td>
            <td><input type="text" name="nome" value="<?php echo $nome;?>"> </td></tr>
           	  <input type="hidden" name="enviar" value="S">
		  <input type="submit" value="Entrada de Aluno" name="alterar"></p>
		</form>
<?php
	}
}

</table><p align="center"><a href="javascript:history.back();">Voltar</a></p>
</body>
</html>
