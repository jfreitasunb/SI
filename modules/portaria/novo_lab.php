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
          <h1>Inclus&atilde;o de Equipamento</h1>Informa&ccedil;&otilde;es sobre o equipamento
        </td>
      </tr>
      <tr>
        <td align=center>
               <title>Incluir Produtos</title>
<?php
if(!isset($_POST["enviar"]))
{
?>
<form method="POST" action="incluir_n.php"><p>
<tr>
        <td align=center>
          <table class=form>
          <tr>
            <td colspan=4 class=header align=center>
              Descria&ccedil;&atilde;o da Inclus&atilde;o :
            </td>
          </tr>
          <tr>
            <td> Codigo do Livro : </td>
            <td>
              <input type="text" name="id_livro" size="20">
            </td>
            <td> Codigo do Usuario :</td>
            <td>
              <input type="text" name="coduser" size="20" >
            </td>
          </tr>
          <tr>
             <td>Data Emprestimo :</td>
             <td>
               <input type="text" name="data_emprunt" size="20" >
             </td>
  	  <td> Data Retorno :</td>
            <td>
              <input type="text" name="data_retour" size="20" >
            </td>
	     </tr>
	  <input type="hidden" name="enviar" value="S">
<?php
}
else   // cadastra o emprestimo
{
	$livro=$_POST["id_livro"];
	$coduser=$_POST["coduser"];
	$data_emprunt=$_POST["data_emprunt"];
	$data_retour=$_POST["data_retour"];
	$res = pg_query("INSERT INTO produtos VALUES('$livro','$coduser','$data_emprunt','$data_retour'");
	if(pg_affected_rows($res)>0)
		echo "<p align='center'>Equipamento incluido com sucesso!</p>";
	else	{
		$erro = pg_last_error();
		echo "<p align='center'>Erro: $erro</p>";
	}
}
?>
</table><br>
<input type="submit" value="Incluir Equipamento" name="incluir"></p>
</form><p align="center"><a href="javascript:history.back();">Voltar</a></p>
</body>
</html>
