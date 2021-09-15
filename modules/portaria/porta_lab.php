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
          <h1>Laboratorio de Matematica</h1>Informa&ccedil;&otilde;es sobre o Aluno
        </td>
      </tr>
      <tr>
        <td align=center>
               <title>Registro de Entrada</title>
<?php
if(!isset($_POST["matricula"]))	              // solicita a matricula
{
?>
	<form method="POST" action="porta_lab.php">
		<tr><td align=center>
          <table class=form>
          <tr><td colspan=4 class=header align=center>Matricula do Aluno :   </td></tr>
          <tr><td> Matricula:<input type="text" name="matricula" size="20"> </td>
  	  <td><input type="submit" value="Cadastrar Entrada" name="alterar"></td>
	</form>
<?php
}
elseif(!isset($_POST["enviar"]))		// busca os dados do aluno select * from clientes order by codigo desc
{
 	$matricula=$_POST["matricula"];
	$sql = "SELECT * FROM aluno WHERE matricula='$matricula'";
	$res = pg_query($sql);
	if(pg_num_rows($res)==0)
		echo "Aluno não cadastrado!";
	else
	{
		$registro=pg_fetch_row($res);
		$matricula=$registro[0];
		$nome=$registro[1];
  		$hora=getdate();
		$entrada=$horacerta=($hora['hours'].':'.$hora['minutes']);
		$data=date("d.m.y");
?>
	<form method="POST" action="porta_lab.php">
		<tr><td align=center>
          	<table class=form>
                    <tr><td colspan=4 class=header align=center>Dados do Aluno :</td></tr>
          	    <tr><td><p><b>Matricula:</b></td><td><b><?php echo $matricula; ?></b></td>
            	    <tr><td><b> Nome :</b></td><td><?php echo $nome; ?>
		    <tr><td><b> Entrada:</b></td><td><?php echo($entrada); ?></td></tr>
                    <tr><td><b> Data:</b></td><td><?php echo($data); ?></td></tr>
                <input type="hidden" name="enviar" value="S">
        	    </table>
      <br><input type="submit" value="Gravar Dados" name="alterar">
 </form>
<?php
	}

  // Cadastrar acesso do aluno
	$sql = "insert into acesso_laboratorio values ('$matricula', '$nome','$entrada','$saida','$data')";
	$res = pg_query($sql);
  	if(pg_affected_rows($res)>0)
  			echo "<p align='center'>Cadastro Encontrado!</p>";
  else
		{
			$erro = pg_last_error();
			echo "<p align='center'>Aluno nao Encontrado! Erro: $erro</p>";
				}
}
?>
</table>
</body>
</html>
