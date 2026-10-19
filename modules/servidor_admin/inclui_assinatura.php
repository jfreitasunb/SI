<?php
require("head_admin.php");


if (!isset($_POST['grava']))
{
?>
<html>
<body>

	<form action='inclui_assinatura.php' method='post'>
	<h2>Incluir assinatura de documentos</h2>
	<table class=form>
	<tr><td width='20%'><font size='2' face='Verdana, Arial, Helvetica, sans-serif'><p>Tipo de assinatura:</p></font></td>
                <tr><td>assinatura: <input name='dado[]' size='40'>
		<td>Titulo: <select name= 'dado[]' size='10'>
                            <option value=''>Deixar em branco </option>
                            <option value='Prof.'>professor: Prof. </option>
                            <option value='Profa.'>professora: Profa. </option>
                            <option value='Sr.'>senhor: Sr.</option>
                            <option value='Sra.'>senhor: Sra.</option>
		            </select></td>
	</tr>
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
//for($i=0;$i<2; $i++)
//{
$insere=mb_convert_encoding($dado[0],"UTF-8");
$titulo=mb_convert_encoding($dado[1],"UTF-8");

$query_admin_assinatura="insert into admin_assinatura values(default,'','$insere','$titulo')";
$result=pg_query($query_admin_assinatura);
//}
}
?>



	

