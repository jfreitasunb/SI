<?php
 require("head_user.php");

if ( $_REQUEST['formulario'] ) {
	$_SESSION['aluno'] = array(
		'professor_orientador' => $_POST['professor_orientador'],
		'formacao_seguida' => $_POST['formacao_seguida'],
		'especialidade' => $_POST['especialidade'],
		'tutor' => $_POST['tutor'],
		'prorrogacao' => $_POST['prorrogacao'],
		'd1a1' => $_POST['dia1'],
		'dia2' => $_POST['dia2'],
		'mes1' => $_POST['mes1'],
		'mes2' => $_POST['mes2'],
		'ano1' => $_POST['ano1'],
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
      <form method="POST" name="formu_aluno" action="aluno1.php">
      <tr>
        <td class=header align=center>
          <h1>Alunos</h1>Atualização de Dados
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
		$res = db_query("SELECT coduser FROM fonctionnaire where status='prof'"); 
//seleciona coduser onde status é prof em fonctionnaire e depois, selecione em users nome onde coduser=coduser
		while($registro = db_fetch_row($res)) //enquanto ouver registro escreva
		{
			$res2 = db_query("SELECT nome FROM users where coduser=?", array($registro[0])); 
			$cod = $registro[0];  		// primeira coluna da tabela usuario
//			$titulo = $registro[1];         // segunda coluna da tabela usuario
			$titulo = $res2;         // segunda coluna da tabela usuario
//			echo "<option value=\"$cod\">$titulo</option>\n"; //Escreva o codigo e o nome do usuario
			echo "<option value=\"$cod\">$titulo</option>\n"; //Escreva o codigo e o nome do usuario
		}
?>
            </td>
            <td>Formação Seguida :</td>
            <td>
              <input type=text name='formacao_seguida' value="<?php= $_SESSION['aluno']['formacao_seguida'] ?>" maxlength=60 ">
            </td>
          </tr>
          <tr>
            <td>Especialidade :</td>
            <td colspan=3>
              <input type=text name='especialidade' value="<?php= $_SESSION['aluno']['especialidade'] ?>" maxlength=100 ">
            </td>
          </tr>
          <tr>
             <td>Tutor :</td>
             <td>
		<input type=text name='tutor' value="<?php= $_SESSION['aluno']['tutor'] ?>" maxlength=10 ">
             </td>
             <td>Prorrogação Prevista :</td>
             <td>
		<input type=text name='prorrogacao' value="<?php= $_SESSION['aluno']['prorrogacao'] ?>" maxlength=20 ">
             </td>
          </tr>
          <tr><td colspan=4><hr></td></tr>
	  <tr>
	    <td>Data de Admissão :</td>
		<td>
		  <input type=integer name='dia1' value="<?php= $_SESSION['aluno']['dia1'] ?>" size='1' maxlength=2 ">/<input type=integer name='mes1' value="<?php= $_SESSION['aluno']['mes1'] ?>" size='1' maxlength=2 ">/<input type=integer name='ano1' value="<?php= $_SESSION['aluno']['ano1'] ?>"size='3' maxlength=4 ">
		</td>
	   <td>Data de Saída Prevista :</td>
		<td><input type=integer name='dia2' value="<?php= $_SESSION['aluno']['dia2'] ?>" size='1' maxlength=2 ">/<input type=integer name='mes2' value="<?php= $_SESSION['aluno']['mes2'] ?>" size='1' maxlength=2 ">/<input type=integer name='ano2' value="<?php= $_SESSION['aluno']['ano2'] ?>" size='3' maxlength=4 ">
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
