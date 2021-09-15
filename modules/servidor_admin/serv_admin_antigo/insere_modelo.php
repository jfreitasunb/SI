<?php include("head_account.php"); ?>
<head>
<meta http-equiv="content-type" content="text/html; charset=iso-8859-1">
<title>Departamento de Matemática - UnB</title><style type="text/css" media="all">@import "style.css";</style></head>


<body>
<div id="Header">
</div>

<div id="Content">
	<h1>Documento</h1>



<form action='ati_insere_modelo.php' method='post'>

<table>

            <tr><td width='20%'><p>Tipo de Documento:</p></font></td>
		<td><input name='tipo_documento' type='text' size=60 ></td></tr>
		</select></td></tr>

<br>

           <tr><td width='20%'><font size='2' face='Verdana, Arial, Helvetica, sans-serif'><p>Assunto:</p></font></td>
           <td><input name='assunto' type='text' size=60 ></td></tr>


           <tr><td width='20%'><font size='2' face='Verdana, Arial, Helvetica, sans-serif'><p>Anexo(s):</p></font></td>
           <td><input name='anexo' type='text' size=60 ></td></tr>


           <tr><td width='20%'><font size='2' face='Verdana, Arial, Helvetica, sans-serif'><p>Vocativo:</p></font></td>
           <td><input name='vocativo' type='text' size=60 ></td></tr>
        

           <tr><td width='20%'><font size='2' face='Verdana, Arial, Helvetica, sans-serif'><p>Mensagem:</p></font></td>
	   <td><TEXTAREA name= 'mensagem' rows=10 cols=60>Insira aqui a mensagem.
                        </TEXTAREA></td></tr>
        
        
           <tr><td width='130'><font size='2' face='Verdana, Arial, Helvetica, sans-serif'><p>Desfecho:</p></font></td>
           <td><input name='desfecho' type='text' size=60></td></tr>
        
        
</table>
<br>
	
       	<input name='acao' type='submit' value='Modelo'>
	<input type='reset' value='Limpar'>

</form>
</div>

</body></html>
