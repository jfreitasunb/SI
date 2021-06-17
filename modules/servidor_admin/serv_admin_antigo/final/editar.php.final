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
	<h1>Editar Documento</h1>


<?php
require "conexao.php";

//busca pelo "documento" na tabela "rascunho".
$resultado=pg_query("SELECT * FROM rascunho WHERE id_documentador = '$id_documentador'") or die("Não foi possível executar a operação. Contacte a Coordenação de Informática.");
$col= pg_fetch_row($resultado,$i);

echo "
<form action='confirma_edita.php?id_documentador=$id_documentador' method='post'>

<table>

	    <tr><td width='20%'><p>Tipo de Documento:</p></font></td>
                <td><select name= 'id_tipo' size='1'>";
                require "conexao.php";
                $res=pg_query("SELECT id_tipo,nometipo FROM tipos") or die ("Não foi possível consultar o banco.");
                while($registro=pg_fetch_row($res,$i))
                {
                        $cod=$registro[0];
                        $nome=$registro[1];
                        echo"<option value=\"$cod\"";
                        if($cod==$col[1])
                                echo"selected";
                        echo">$nome</option>\n";
                }
               echo" 
                </select></td></tr>

<br>


	    <tr><td width='20%'><p>Destino:</p></font></td>
                <td><select name= 'id_departamentos' size='1'>";
                $res=pg_query("SELECT id_departamentos,nomedepartamento FROM departamentos") 
		or die ("Não foi possível consultar o banco.");
                while($registro=pg_fetch_row($res,$i))
                {
                        $cod=$registro[0];
                        $nome=$registro[1];
                        echo"<option value=\"$cod\"";
                        if($cod==$col[2])
                                echo"selected";
                        echo">$nome</option>\n";
                }
               echo" 
                </select></td></tr>

<br>


            <tr><td width='20%'><font size='2' face='Verdana, Arial, Helvetica, sans-serif'><p>Assunto:</p></font></td>
            <td><input name='assunto'  size=60 value='$col[7]'></td></tr> 

            <td width='20%'><font size='2' face='Verdana, Arial, Helvetica, sans-serif'><p>Anexo(s):</p></font></td>
            <td><input name='anexo'  size=60 value='$col[8]'></td></tr>

            <tr><td width='20%'><font size='2' face='Verdana, Arial, Helvetica, sans-serif'><p>Vocativo:</p></font></td>
            <td><input name='vocativo'  size=60 value='$col[3]'></td></tr>
          
	    <tr><td width='20%'><font size='2' face='Verdana, Arial, Helvetica, sans-serif'><p>Mensagem:</p></font></td>
	    <td><TEXTAREA name= 'mensagem' rows=10 cols=60> $col[4] </TEXTAREA></td></tr>

            <tr><td width='130'><font size='2' face='Verdana, Arial, Helvetica, sans-serif'><p>Desfecho:</p></font></td>
            <td><input name='desfecho' size=60 value='$col[5]'></td></tr>
	
	    <tr><td width='20%'><p>Assinatura:</p></font></td>
                <td><select name= 'assinatura' size='1'>";
                $res=pg_query("SELECT id_assinaturas,nome FROM assinaturas") or die ("Não foi possível consultar o banco.");
                while($registro=pg_fetch_row($res,$i))
                {
                        $cod=$registro[0];
                        $nome=$registro[1];
                        echo"<option value=\"$cod\"";
                        if($cod==$col[6])
                                echo"selected";
                        echo">$nome</option>\n";
                }
               echo" 
                </select></td></tr>

<br>


</table>
<br>

	    <input name='data' type='hidden' value='$col[9]'>
            <input name='acao' type='submit' value='Visualizar'>
	    <input name='acao' type='submit' value='Rascunho'> 
            <input name='acao' type='submit' value='Definitivo'> 

</form>
</div>";
?>
<?php require "menu.php"; ?>
</body></html>
