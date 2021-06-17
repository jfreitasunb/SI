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
	<h1>Modelo Documento</h1>


<?php
require "conexao.php";
$tipo_modelo=$_POST["tipo_modelo"];
//busca pelo "modelo" na tabela "modelo".
$resultado=pg_query("SELECT * FROM modelo WHERE id_modelo = '$tipo_modelo'") or die("Não foi possível executar a operação. Contacte a Coordenação de Informática.");
$col= pg_fetch_row($resultado,$i);
?>

<form action='ati.php' method='post'>
<table>


	<tr><td width='20%'><p>Tipo de Documento:</p></font></td>
                <td><select name= 'dado[]' size='1'>
                <?php
		require "conexao.php";
                $res=pg_query("SELECT nometipo FROM tipos WHERE id_tipo='$col[10]'")
                or die ("N\xe3o foi poss\xedvel consultar o banco.");
                $registro=pg_fetch_row($res,$i);
                $nome=$registro[0];
                echo"<option value=$col[10]>$nome</option>"; ?>
                
                </select></td></tr><br>

<?php

        if(($col[10]=="1") || ($col[10]=="3") ) //memorando ou of\xedcio
        {
?>



	    <tr><td width='20%'><font size='2' face='Verdana, Arial, Helvetica, sans-serif'><p>Destino:</p></font></td>
                <td><select name= 'dado[]' size='1'>
		<?php
                require "conexao.php";
                $res1=pg_query("SELECT id_departamentos,nomedepartamento FROM departamentos") or die ("Não foi possível consultar o banco.");
                while($registro1=pg_fetch_row($res1,$i))
                {
                        $cod1=$registro1[0];
                        $nome1=$registro1[1];
                        echo"<option value=\"$cod1\">$nome1</option>\n";
                }
		?>
                </select></td></tr><br> 
	    

            <tr><td width='20%'><font size='2' face='Verdana, Arial, Helvetica, sans-serif'><p>Assunto:</p></font></td>
            <td><input name='dado[]'  size=60 <?php echo "value=\"$col[2]\" " ; ?>></td></tr>

            <td width='20%'><font size='2' face='Verdana, Arial, Helvetica, sans-serif'><p>Anexo(s):</p></font></td>
            <td><input name='dado[]'  size=60 <?php echo "value=\"$col[3]\" ";?> ></td></tr>

            <tr><td width='20%'><font size='2' face='Verdana, Arial, Helvetica, sans-serif'><p>Vocativo:</p></font></td>
            <td><input name='dado[]'  size=60 <?php echo "value=\"$col[4]\" ";?>></td></tr>
          
	    <tr><td width='20%'><font size='2' face='Verdana, Arial, Helvetica, sans-serif'><p>Mensagem:</p></font></td>
	    <td><TEXTAREA name= 'dado[]' rows=10 cols=60> <?php echo $col[5]; ?> </TEXTAREA></td></tr>

            <tr><td width='130'><font size='2' face='Verdana, Arial, Helvetica, sans-serif'><p>Desfecho:</p></font></td>
            <td><input name='dado[]' size=60 <?php echo "value=\"$col[6]\" ";?>></td></tr>
	
	     <tr><td width='130'><font size='2' face='Verdana, Arial, Helvetica, sans-serif'><p>Assinatura:</p></font></td>

           <td><select name= 'dado[]' size='1'>
		<?php
                $res2=pg_query("SELECT id_assinaturas,nome FROM assinaturas") or die ("Não foi possível consultar o banco.");
                while($registro2=pg_fetch_row($res2,$i))
                {
                        $cod2=$registro2[0];
                        $nome2=$registro2[1];
                        echo"<option value=\"$cod2\">$nome2</option>\n";
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
<?php } ?>
<?php require "menu.php"; ?>
</body></html>
