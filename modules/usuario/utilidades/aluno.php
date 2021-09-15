<?php
 include("head_user.php");

if ( $_REQUEST['formulario'] ) {
	$_SESSION['aluno'] = array(
		'orientateur' => $_POST['professor_orientador'],
		'formation' => $_POST['formacao_seguida'],
		'speciality' => $_POST['especialidade'],
		'prolongement' => $_POST['conclusao'],
		'dia1' => $_POST['dia1'],
		'dia2' => $_POST['dia2'],
		'mes1' => $_POST['mes1'],
		'mes2' => $_POST['mes2'],
		'ano1' => $_POST['ano1'],
		'ano2' => $_POST['ano2'],
		'dia3' => $_POST['dia3'],
		'mes3' => $_POST['mes3'], 
		'ano3' => $_POST['ano3'],
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
      <form method="POST" name="formu_aluno" action="aluno.php">
     <input type="hidden" name="formulario" value="1"/>
      <tr>
        <td class=header align=center>
          <h1>Alunos</h1>Atualizacao de Dados
        </td>
      </tr>
      <tr>
        <td align=center>
          <table class=form>
          <tr>
            <td colspan=4 class=header align=center>
              Relativo ao Aluno :
            </td>
          </tr>
          <tr>
            <td> Professor Orientador : </td>
  	    <td>
              <select size="1" name="professor_orientador">
	<?php                                   		// gera a lista de usuarios registrados
/*		$res = pg_query("SELECT nome FROM usuario where funcao='prof'"); 
//seleciona coduser onde status é prof em fonctionnaire e depois, selecione em users nome onde coduser=coduser
		while($registro = pg_fetch_row($res)) //enquanto ouver registro escreva
		{
			$cod = $registro[0];  		// primeira coluna da tabela usuario
			$titulo=$registro[0];
			echo "<option value=\"$cod\">$titulo</option>\n"; //Escreva o codigo e o nome do usuario
		}*/
// O que está comentado abaixo funciona e deve ser o correto
		$res = pg_query("SELECT coduser FROM fonctionnaire where statut='prof'"); 
//seleciona coduser onde status é prof em fonctionnaire e depois, selecione em users nome onde coduser=coduser
		while($registro = pg_fetch_row($res)) //enquanto ouver registro escreva
		{
			$cod = $registro[0];  		// primeira coluna da tabela usuario
			$res2 = pg_query("SELECT name FROM users where coduser=$cod"); 
			$novo_registro = pg_fetch_row($res2);
			$titulo=$novo_registro[0];
			echo "<option value=\"$titulo\">$titulo</option>\n"; //Escreva o codigo e o nome do usuario
		}

?>
            </td>
            <td>Formacao Seguida :</td><td>
            <SELECT name='formacao_seguida'> <OPTION selected value="graduacao">Graduacao<OPTION selected value="mestrado">Mestrado<OPTION selected value="doutorado">Doutorado</SELECT></td>
          </tr>
          <tr>
            <td>Especialidade :</td><td>
            <SELECT name='especialidade'> <OPTION selected value="algebra">Algebra<OPTION selected value="analise">Analise<OPTION selected value="geometria">Geometria<OPTION selected value="mat_aplicada">Matematica Aplicada</SELECT></td>
          </tr>
                     <td>Data de conclusao :</td>
             <td>
	  <input type=integer name='dia3' value="<?php= $_SESSION['aluno']['dia3'] ?>" size='1' maxlength=2 >/<input type=integer name='mes3' value="<?php= $_SESSION['aluno']['mes3'] ?>" size='1' maxlength=2 ">/<input type=integer name='ano3' value="<?php= $_SESSION['aluno']['ano3'] ?>"size='3' maxlength=4 ">

             </td>
          </tr>
          <tr><td colspan=4><hr></td></tr>
	  <tr>
	    <td>Data de Admissão :</td>
		<td>
		  <input type=integer name='dia1' value="<?php= $_SESSION['aluno']['dia1'] ?>" size='1' maxlength=2 >/<input type=integer name='mes1' value="<?php= $_SESSION['aluno']['mes1'] ?>" size='1' maxlength=2 ">/<input type=integer name='ano1' value="<?php= $_SESSION['aluno']['ano1'] ?>"size='3' maxlength=4 ">
		</td>
	   <td>Data de Saida Prevista :</td>
		<td><input type=integer name='dia2' value="<?php= $_SESSION['aluno']['dia2'] ?>" size='1' maxlength=2 >/<input type=integer name='mes2' value="<?php= $_SESSION['aluno']['mes2'] ?>" size='1' maxlength=2 >/<input type=integer name='ano2' value="<?php= $_SESSION['aluno']['ano2'] ?>" size='3' maxlength=4 >
		</td>
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
