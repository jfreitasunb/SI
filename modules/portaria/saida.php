<?php include("head_account.php"); //conexao com o banco de dados e identificação do usuario ?>
<html>
<header>
    <script language=javascript src="function_js.js"></script>
    <script language=javascript src="formu.js"></script>
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
               <title>Registro de Saida</title>
<?php
if(!isset($_POST["matricula"]))	              // solicita a matricula do aluno para identificação
{
?>
	<form method="POST" action="saida.php"><tr><td align=center>
          <table class=form>
          <tr><td colspan=4 class=header align=center>Matricula do Aluno :   </td></tr>
          <tr><td> Matricula:<input type="text" name="matricula" size="20"> </td>
  	  <td><input type="submit" value="Cadastrar Saida" name="alterar"></td>
	</form>
<?php
}
elseif(!isset($_POST["enviar"]))		// busca os dados do aluno no banco yan na tabela acesso_laboratorio
{
 $matricula=$_POST["matricula"];
	$sql = "SELECT * FROM acesso_laboratorio WHERE matricula='$matricula'";
	$res = pg_query($sql);
	if(pg_num_rows($res)==0)                    //Se não encontrar a matricula do aluno, mostrar o mensagem abaixo
		echo "Aluno não registrou entrada!";
	else
	{
		$registro=pg_fetch_row($res);
		$matricula=$registro[0];
		$nome=$registro[1];
		$entrada=$registro[2];
		$data=$registro[4];
		$hora=getdate();
		$saida=$horacerta=($hora['hours'].':'.$hora['minutes']);
?>
	<form method="POST" action="saida.php">
		<tr><td align=center>
          	<table class=form>
                    <tr><td colspan=4 class=header align=center>Dados do Aluno :</td></tr>
          	    <tr><td><p>Matricula:</td><td><b><?php echo $matricula; ?></b></td>
            	    <tr><td> Nome :</td><td><?php echo $nome; ?></td></tr>
		    <tr><td> Entrada:</td><td><?php echo($entrada); ?></td></tr>
           	    <tr><td> Saida:</td><td><?php echo($saida); ?></td></tr></td>
		    <tr><td> Data:</td><td><?php echo($data); ?></td></tr></td>
		<input type="hidden" name="enviar" value="S">
        	    </table>
      <br><input type="submit" value="Gravar Dados" name="alterar">
 </form>
<?php
	}
                                                    // Gravar o horario da  saida do aluno
	$sql = "UPDATE acesso_laboratorio SET saida = '$saida'  WHERE saida = '';";
	$res = pg_query($sql);
 			 if(pg_affected_rows($res)>0)
  			echo "<p align='center'>Ate Logo!</p>";
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
