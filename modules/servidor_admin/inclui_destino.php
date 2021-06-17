<?php include("head_admin.php");


if (!isset($_POST['grava']))
{
?>
<html>
<body>

	<form action='inclui_destino.php' method='post'>
	<h2>Incluir destino para documentos:</h2>
	<table class=form>
	<tr><td width='20%'><font size='2' face='Verdana, Arial, Helvetica, sans-serif'><p>Destino:</p></font></td>
                <tr><td>Destino (obrigat&oacute;rio): <input name='dado[]' size='40'>
                <tr><td>Sigla (obrigat&oacute;rio): <input name='dado[]' size='10'>
                <tr><td>Descri&ccedil;&atilde;o: <input name='dado[]' size='40'>
                <tr><td>fone: <input name='dado[]' size='10'>
                <tr><td>contato: <input name='dado[]' size='40'>
                <tr><td>rua: <input name='dado[]' size='40'>
                <tr><td>bairro: <input name='dado[]' size='40'>
                <tr><td>cidade: <input name='dado[]' size='40'>
                <tr><td>UF (obrigat&oacute;rio): <input name='dado[]' size='4'>
                <tr><td>CEP (obrigat&oacute;rio)(sem barras e sem espa&ccedil;os): <input name='dado[]' size='40'>
        	<td><input type=hidden name='grava'>
<input name='acao' type='submit' value='gravar'>
</form>
</body>
</html>
<?php
}
else
{
$dado=$_POST['dado'];
//for($i=0;$i<10; $i++)
//{
$nomedepartamento=mb_convert_encoding($dado[0],"UTF-8");
$sigla=mb_convert_encoding($dado[1],"UTF-8");
$descricao=mb_convert_encoding($dado[2],"UTF-8");
$pessoadecontato=mb_convert_encoding($dado[4],"UTF-8");
$rua=mb_convert_encoding($dado[5],"UTF-8");
$bairro=mb_convert_encoding($dado[6],"UTF-8");
$cidade=mb_convert_encoding($dado[7],"UTF-8");

// id_departamento | nomedepartamento | sigla | descricao | fone | pessoadecontato | rua | bairro | cidade | uf | cep

$query_admin_departamento="insert into admin_departamento values(default,'$nomedepartamento','$sigla','$descricao','$dado[3]','$pessoadecontato','$rua','$bairro','$cidade','$dado[8]','$dado[9]')";
$result=pg_query($query_admin_departamento);
//}
}
?>



	

