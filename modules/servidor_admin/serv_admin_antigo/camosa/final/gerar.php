<?php
require "verifica.php";
?>

<head>
<meta http-equiv="content-type" content="text/html; charset=iso-8859-1">
<title>Departamento de Matemática - UnB</title><style type="text/css" media="all">@import "style.css";</style></head>


<body>
<div id="Header">
</div>

<div id="Content">
	<h1>Novos Documentos</h1>
	<p>Selecione abaixo o tipo de documento a ser criado, bem como se deseja criá-lo a partir de um modelo pré-exi
	stente ou não.</p>	



<form action='gerar1.php' method='post'>

<table>

            <tr><td width='20%'><p>Tipo de Documento:</p></font></td>
        	<td><select name= 'id_tipo' size='1'>
		<?php
                require "conexao.php";
                $res=pg_query("SELECT id_tipo,nometipo FROM tipos") or die ("Não foi possível consultar o banco.");
                while($registro=pg_fetch_row($res,$i))
                {
                        $cod=$registro[0];
                        $nome=$registro[1];
                        echo"<option value=$cod>$nome</option>\n";
                }
        	?>
		</select></td></tr>

<br>
           <tr><td width='20%'><font size='2' face='Verdana, Arial, Helvetica, sans-serif'><p>Destino:</p></font></td>
        	<td><select name= 'id_departamentos' size='1'>
		<?php
                require "conexao.php";
                $res1=pg_query("SELECT id_departamentos,nomedepartamento FROM departamentos") or die ("Não foi possível consultar o banco.");
                while($registro1=pg_fetch_row($res1,$i))
                {
                        $cod1=$registro1[0];
                        $nome1=$registro1[1];
                        echo"<option value=$cod1>$nome1</option>\n";
                }
        	?>
		</select></td></tr>


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
        
        
           <tr><td width='130'><font size='2' face='Verdana, Arial, Helvetica, sans-serif'><p>Assinatura:</p></font></td>

           <td><select name= 'assinatura' size='1'>
                        
		<?php
                $res2=pg_query("SELECT id_assinaturas,nome FROM assinaturas") or die ("Não foi possível consultar o banco.");
                while($registro2=pg_fetch_row($res2,$i))
                {
                        $cod2=$registro2[0];
                        $nome2=$registro2[1];
                        echo"<option value=$cod2>$nome2</option>\n";
                }
        	?>

		</select></td></tr>
</table>
<br>
	
	<input name='acao' type='submit' value='Visualizar'>
       	<input name='acao' type='submit' value='Salvar Rascunho'>
	<input type='reset' value='Limpar'>

</form>
</div>

<?php require "menu.php"; ?>
</body></html>
