<?php
  include("head_sala_leitura.php");
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
          <h1>Cadastro de Livro</h1>Informa&ccedil;&otilde;es sobre o Livro
        </td>
      </tr>
      <tr>
        <td align=center>
               <title>Cadastrar Livro</title>
<?php
if(!isset($_POST["enviar"]))
{
?>
<form method="POST" action="cada_livr.php"><p>
<tr>
        <td align=center>
          <table class=form>
          <tr>
            <td colspan=4 class=header align=center>
              Descria&ccedil;&atilde;o do Livro :
            </td>
          </tr>
          <tr>
            <td> Codigo : </td><td><input type="text" name="codigo" size="20"></td>
            <td> Titulo :</td><td><input type="text" name="titulo" size="20" ></td>
            </tr><tr>
	     <td>Autor :</td><td><input type="text" name="autor" size="20" ></td>
             <td>Tema:</td><td><input type="text" name="tema" size="20" ></td>
            <input type="hidden" name="enviar" value="S">
<?php
}
else   // inclui o livro
{
	$codigo=$_POST["codigo"];
	$titulo=$_POST["titulo"];
	$autor=$_POST["autor"];
	$tema=$_POST["tema"];
	$res = pg_query("INSERT INTO livros VALUES('$codigo','$titulo','$autor','$tema')");
	if(pg_affected_rows($res)>0)
		echo "<p align='center'>Livro cadastrado!</p>";
	else	{
		$erro = pg_last_error();
		echo "<p align='center'>Erro: $erro</p>";
	}
}
?>
</table><br>
<input type="submit" value="Cadastrar Livro" name="incluir">
<input type=button value="Fechar Janela" onclick="window.close();">
</form>
</body>
</html>
