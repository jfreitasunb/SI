<?php require("head_admin.php");


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
exige_escrita();
$dado=$_POST['dado'];
//for($i=0;$i<10; $i++)
//{
$nomedepartamento=$dado[0];
$sigla=$dado[1];
$descricao=$dado[2];
$pessoadecontato=$dado[4];
$rua=$dado[5];
$bairro=$dado[6];
$cidade=$dado[7];

// id_departamento | nomedepartamento | sigla | descricao | fone | pessoadecontato | rua | bairro | cidade | uf | cep

$query_admin_departamento="insert into admin_departamento values(default,?,?,?,?,?,?,?,?,?,?)"; $query_admin_departamento__p = array($nomedepartamento, $sigla, $descricao, $dado[3], $pessoadecontato, $rua, $bairro, $cidade, $dado[8], $dado[9]);
$result=db_query($query_admin_departamento, $query_admin_departamento__p);
//}
}
?>



	

