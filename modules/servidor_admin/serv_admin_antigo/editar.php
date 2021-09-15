<?php include("head_account.php"); ?>
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
          <h1>Departamento de Matematica</h1>
        </td>
      </tr>
      <tr>
        <td align=center>
               <title>Servidor Administrativo</title>
<?php
$id_documentador=$_GET["id_documentador"];

////////////////////////////////////busca pelo "documento" na tabela "rascunho".//////////////////////////////////////

$resultado=pg_query("SELECT * FROM admin_rascunho WHERE id_documentador = '$id_documentador'") or die("Não foi possível executar a operação. Contacte a Coordenação de Informática.");
$col= pg_fetch_row($resultado,$i);

echo "<form action='ati.php?id_documentador=$id_documentador' method='post'>
<table>
	    <tr><td width='20%'><p>Tipo de Documento:</p></font></td>
                <td><select name= 'dado[]' size='1'>";
                $res=pg_query("SELECT nometipo FROM admin_tipo WHERE id_tipo='$col[1]'")
		or die ("Não foi possível consultar o banco.");
                $registro=pg_fetch_row($res,$i);
                $nome=$registro[0];
                echo"<option value=\"$col[1]\">$nome</option>
                </select></td></tr>

<br>";

if($col[1]=="1"){ //memorando

	echo"

	   <tr><td width='20%'><font size='2' face='Verdana, Arial, Helvetica, sans-serif'><p>Via:</p></font></td>
            <td><input name='dado[]'  size=60 value='$col[10]'></td></tr>


	    <tr><td width='20%'><p>Destino:</p></font></td>
                <td><select name= 'dado[]' size='1'>";
                $res=pg_query("SELECT id_departamento,nomedepartamento FROM admin_departamento")
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
            <td><input name='dado[]'  size=60 value='$col[7]'></td></tr>

            <td width='20%'><font size='2' face='Verdana, Arial, Helvetica, sans-serif'><p>Anexo(s):</p></font></td>
            <td><input name='dado[]'  size=60 value='$col[8]'></td></tr>

            <tr><td width='20%'><font size='2' face='Verdana, Arial, Helvetica, sans-serif'><p>Vocativo:</p></font></td>
            <td><input name='dado[]'  size=60 value='$col[3]'></td></tr>

	    <tr><td width='20%'><font size='2' face='Verdana, Arial, Helvetica, sans-serif'><p>Mensagem:</p></font></td>
	    <td><TEXTAREA name= 'dado[]' rows=10 cols=60> $col[4] </TEXTAREA></td></tr>

            <tr><td width='130'><font size='2' face='Verdana, Arial, Helvetica, sans-serif'><p>Desfecho:</p></font></td>
            <td><input name='dado[]' size=60 value='$col[5]'></td></tr>

	    <tr><td width='20%'><p>Assinatura:</p></font></td>
                <td><select name= 'dado[]' size='1'>";
                $res=pg_query("SELECT id_assinatura,nome FROM admin_assinatura") or die ("Não foi possível consultar o banco.");
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


<br>";
}

else if(($col[1]=="3")||($col[1]=="6")){ //ofício interno ou externo

	echo"

	    <tr><td width='20%'><font size='2' face='Verdana, Arial, Helvetica, sans-serif'><p>Via:</p></font></td>
            <td><input name='dado[]'  size=60 value='$col[10]'></td></tr>

	    <tr><td width='20%'><font size='2' face='Verdana, Arial, Helvetica, sans-serif'><p>Destino:</p></font></td>
            <td><input name='dado[]'  size=60 value='$col[5]'></td></tr>

	    <tr><td width='20%'><font size='2' face='Verdana, Arial, Helvetica, sans-serif'><p>Assunto:</p></font></td>
            <td><input name='dado[]'  size=60 value='$col[7]'></td></tr>

            <td width='20%'><font size='2' face='Verdana, Arial, Helvetica, sans-serif'><p>Anexo(s):</p></font></td>
            <td><input name='dado[]'  size=60 value='$col[8]'></td></tr>

            <tr><td width='20%'><font size='2' face='Verdana, Arial, Helvetica, sans-serif'><p>Vocativo:</p></font></td>
            <td><input name='dado[]'  size=60 value='$col[3]'></td></tr>

            <tr><td width='20%'><font size='2' face='Verdana, Arial, Helvetica, sans-serif'><p>Mensagem:</p></font></td>
            <td><TEXTAREA name= 'dado[]' rows=10 cols=60> $col[4] </TEXTAREA></td></tr>

            <tr><td width='20%'><p>Assinatura:</p></font></td>
                <td><select name= 'dado[]' size='1'>";
                $res=pg_query("SELECT id_assinatura,nome FROM admin_assinatura") or die ("Não foi possível consultar o banco.");
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

<br>";
}

else if($col[1]=="2"){ //circular

	echo "
	 <tr><td width='20%'><p>Remetente:</p></font></td>
                <td><select name= 'dado[]' size='1'>";
                $res=pg_query("SELECT id_assinatura,nome FROM admin_assinatura") or die ("Não foi possível consultar o banco.");
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

	    <tr><td width='20%'><font size='2' face='Verdana, Arial, Helvetica, sans-serif'><p>Destinatário:</p></font></td>
            <td><input name='dado[]'  size=60 value='$col[8]'></td></tr>

            <tr><td width='20%'><font size='2' face='Verdana, Arial, Helvetica, sans-serif'><p>Assunto:</p></font></td>
            <td><input name='dado[]'  size=60 value='$col[7]'></td></tr>

            <td width='20%'><font size='2' face='Verdana, Arial, Helvetica, sans-serif'><p>Vocativo:</p></font></td>
            <td><input name='dado[]'  size=60 value='$col[3]'></td></tr>

            <tr><td width='20%'><font size='2' face='Verdana, Arial, Helvetica, sans-serif'><p>Mensagem:</p></font></td>
            <td><TEXTAREA name= 'dado[]' rows=10 cols=60> $col[4] </TEXTAREA></td></tr>

	    <tr><td width='20%'><font size='2' face='Verdana, Arial, Helvetica, sans-serif'><p>Desfecho:</p></font></td>
            <td><input name='dado[]'  size=60 value='$col[5]'></td></tr>

	    <br>";
}

else if($col[1]=="4"){ // ato

	echo"
	<tr><td width='20%'><font size='2' face='Verdana, Arial, Helvetica, sans-serif'><p>Mensagem:</p></font></td>
        <td><TEXTAREA name= 'dado[]' rows=10 cols=60> $col[4] </TEXTAREA></td></tr>

	<tr><td width='20%'><p>Assinatura:</p></font></td>
                <td><select name= 'dado[]' size='1'>";
                $res=pg_query("SELECT id_assinatura,nome FROM admin_assinatura") or die ("Não foi possível consultar o banco.");
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
                </select></td></tr><br>";
}

else if($col[1]=="5"){ //ata

	echo"
	<tr><td width='20%'><font size='2' face='Verdana, Arial, Helvetica, sans-serif'><p>Mensagem:</p></font></td>
        <td><TEXTAREA name= 'dado[]' rows=10 cols=60> $col[4] </TEXTAREA></td></tr>
	<br>";
}

echo"


</table>
<br>
	    <input name='origem' type='hidden' value='editar'>
	    <input name='data' type='hidden' value='$col[9]'>
            <input name='acao' type='submit' value='Visualizar'>
	    <input name='acao' type='submit' value='Rascunho'>
            <input name='acao' type='submit' value='Definitivo'>

</form>
</div>";
?>

