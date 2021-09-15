<?php

require "verifica.php";

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml"><head>
<meta http-equiv="content-type" content="text/html; charset=iso-8859-1">

<title>Servidor Administrativo</title><style type="text/css" media="all">@import "style.css";</style></head>



<body>

<div id="Header"></div>

<div id="Content">
        <h1>Editar Formulário</h1>
<p> Faça as alterações necessárias abaixo para o novo documento. </p>

<?php

require "conexao.php";

$sel="SELECT * 
      FROM documentador
      WHERE id_documentador='$id_documentador'";

$resultado=pg_query($sel) or die ("Não foi possível realizar a consulta ao banco de dados");
while ($linha=pg_fetch_array($resultado))
	{
	$id_documentador=trim($linha["id_documentador"]);
	$id_tipo=trim($linha["id_tipo"]);
	$numerodocumento=trim($linha["numerodocumento"]);
	$id_departamentos=trim($linha["id_departamentos"]);
	$vocativo=trim($linha["vocativo"]);
	$mensagem=trim($linha["mensagem"]);
	$desfecho=trim($linha["desfecho"]);
	$id_assinaturas=trim($linha["id_assinaturas"]);
	}
?>


<?php

echo "<form name='formulario' action='confirma_edita.php?numerodocumento=$numerodocumento' method='post'>";
	echo "<table width='100%' border='0' cellspacing='0' cellpadding='0'>
	           <tr>
	             <td width='130'><p>Departamento:</p></font></td>

		<td><select name= 'id_departamentos' value='$id_departamentos' size = '2' multiple>
                        <option value='1'>Qu\xedmica</option>
                        <option value='2'>Fisica</option>
                        </select></td></tr>
	          <tr>
	            <td width='130'><p>Vocativo:</p></font></td>
	            <td><input name='vocativo' value='$vocativo' type='text' size=30></td>
	         </tr>

		<tr>
                  <td width='130'><p>Mensagem:</p></font></td>
                  <td><textarea name='mensagem' value='$mensagem' rows=10 cols=60></textarea></td>
                </tr>
	         <tr>
	           <td width='130'><p>Desfecho:</p></font></td>
	           <td><input name='desfecho' value='$desfecho' type='text' size=6></td>
	         </tr>
	         <tr>
	           <td width='130'><p>Assinatura:</p></font></td>

			<td><select name= 'assinatura' value='$assinatura' size = '3' multiple>
                        <option value='1'>Prof. Guy</option>
                        <option value='2'>Prof. Leonardo</option>
                        <option value='3'>Prof. Celius</option>
                        </select></td></tr>

	      </table>";
	echo "
	     
	      <input name='id_tipo' type='hidden' value='$id_tipo'>		    
	      <input name='acao' type='hidden' value=''>";
?>
<br>
<br>
<input name="button" type="button" onClick="document.formulario.acao.value='inserir';document.formulario.submit()" value="Editar">

<div id="Menu">
        <a href="exercicio_insere.php">Preencher Formulário</a><br>
        <a href="exercicio_edita_lista.php">Buscar Documentos</a><br>
        <a href="sair.php">Sair</a><br>
</div>

</body>

</head>
</html>
