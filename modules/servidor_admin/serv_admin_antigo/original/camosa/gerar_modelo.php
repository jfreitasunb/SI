<?php
require "verifica.php";
require "cabecalho.html";
?>

	<h1>Modelo Documento</h1>


<?php
require "conexao.php";
$tipo_modelo=$_POST["tipo_modelo"];
//busca pelo "modelo" na tabela "modelo".
$vetor_modelo=pg_query("SELECT * FROM admin_modelo WHERE id_modelo = '$tipo_modelo'") or die("Não foi possível executar a operação. Contacte a Coordenação de Informática.");
$col= pg_fetch_row($vetor_modelo,$i);
?>

<form action='ati.php' method='post'>
<table>


	<tr><td width='20%'><p>Tipo de Documento:</p></font></td>
                <td><select name= 'dado[]' size='1'>
                <?php
                $res=pg_query("SELECT nometipo FROM admin_tipo WHERE id_tipo='$col[1]'")
                or die ("N\xe3o foi poss\xedvel consultar o banco.");
                $registro=pg_fetch_row($res,$i);
                $nome=$registro[0];
                echo"<option value=$col[1]>$nome</option>"; 
		?>
                </select></td></tr><br>

<?php

if(($col[1]=="1")) //memorando
        {
?>

	<tr><td width='20%'><font size='2' face='Verdana, Arial, Helvetica, sans-serif'><p>Via:</p></font></td>
           <td><input name='dado[]' type='text' size=20 ></td></tr>


	    <tr><td width='20%'><font size='2' face='Verdana, Arial, Helvetica, sans-serif'><p>Destino:</p></font></td>
                <td><select name= 'dado[]' size='1'>
		<?php
                $res1=pg_query("SELECT id_departamento,nomedepartamento FROM admin_departamento") 
		or die ("Não foi possível consultar o banco.");
                while($registro1=pg_fetch_row($res1,$i))
                {
                        $cod1=$registro1[0];
                        $nome1=$registro1[1];
                        echo"<option value=\"$cod1\">$nome1</option>\n";
                }
		?>
                </select></td></tr><br> 
	    

            <tr><td width='20%'><font size='2' face='Verdana, Arial, Helvetica, sans-serif'><p>Assunto:</p></font></td>
            <td><input name='dado[]'  size=60 <?php echo "value=\"$col[3]\" " ; ?>></td></tr>

            <td width='20%'><font size='2' face='Verdana, Arial, Helvetica, sans-serif'><p>Anexo(s):</p></font></td>
            <td><input name='dado[]'  size=60 <?php echo "value=\"$col[4]\" ";?> ></td></tr>

            <tr><td width='20%'><font size='2' face='Verdana, Arial, Helvetica, sans-serif'><p>Vocativo:</p></font></td>
            <td><input name='dado[]'  size=60 <?php echo "value=\"$col[5]\" ";?>></td></tr>
          
	    <tr><td width='20%'><font size='2' face='Verdana, Arial, Helvetica, sans-serif'><p>Mensagem:</p></font></td>
	    <td><TEXTAREA name= 'dado[]' rows=10 cols=60> <?php echo $col[6]; ?> </TEXTAREA></td></tr>

            <tr><td width='130'><font size='2' face='Verdana, Arial, Helvetica, sans-serif'><p>Desfecho:</p></font></td>
            <td><input name='dado[]' size=60 <?php echo "value=\"$col[7]\" ";?>></td></tr>
	
	     <tr><td width='130'><font size='2' face='Verdana, Arial, Helvetica, sans-serif'><p>Assinatura:</p></font></td>

           <td><select name= 'dado[]' size='1'>
		<?php
                $res2=pg_query("SELECT id_assinatura,nome FROM admin_assinatura") 
		or die ("Não foi possível consultar o banco.");
                while($registro2=pg_fetch_row($res2,$i))
                {
                        $cod2=$registro2[0];
                        $nome2=$registro2[1];
                        echo"<option value=\"$cod2\">$nome2</option>\n";
                }
		?>
                </select></td></tr>
<?php
	}
else if (($col[1]=="3")||($col[1]=="6"))//ofício interno ou externo
	{
?>
	
	
	<tr><td width='20%'><font size='2' face='Verdana, Arial, Helvetica, sans-serif'><p>Via:</p></font></td>
           <td><input name='dado[]' type='text' size=20 ></td></tr>


	<tr><td width='20%'><font size='2' face='Verdana, Arial, Helvetica, sans-serif'><p>Destino:</p></font></td>
            <td><input name='dado[]'  size=60 <?php echo "value=\"$col[8]\" " ; ?>></td></tr>

	<tr><td width='20%'><font size='2' face='Verdana, Arial, Helvetica, sans-serif'><p>Assunto:</p></font></td>
            <td><input name='dado[]'  size=60 <?php echo "value=\"$col[3]\" " ; ?>></td></tr>

        <td width='20%'><font size='2' face='Verdana, Arial, Helvetica, sans-serif'><p>Anexo(s):</p></font></td>
            <td><input name='dado[]'  size=60 <?php echo "value=\"$col[4]\" ";?> ></td></tr>

        <tr><td width='20%'><font size='2' face='Verdana, Arial, Helvetica, sans-serif'><p>Vocativo:</p></font></td>
            <td><input name='dado[]'  size=60 <?php echo "value=\"$col[5]\" ";?>></td></tr>

        <tr><td width='20%'><font size='2' face='Verdana, Arial, Helvetica, sans-serif'><p>Mensagem:</p></font></td>
            <td><TEXTAREA name= 'dado[]' rows=10 cols=60> <?php echo $col[6]; ?> </TEXTAREA></td></tr>

        <tr><td width='130'><font size='2' face='Verdana, Arial, Helvetica, sans-serif'><p>Assinatura:</p></font></td>
        <td><select name= 'dado[]' size='1'>
                <?php
                $res2=pg_query("SELECT id_assinatura,nome FROM admin_assinatura") 
		or die ("Não foi possível consultar o banco.");
                while($registro2=pg_fetch_row($res2,$i))
                {
                        $cod2=$registro2[0];
                        $nome2=$registro2[1];
                        echo"<option value=\"$cod2\">$nome2</option>\n";
                }
                ?>
                </select></td></tr>

<?php
	}
?>
	</table>
	<br>

	<input name='origem' type='hidden' value='gerar'>
	<input name='acao' type='submit' value='Visualizar'>
        <input name='acao' type='submit' value='Salvar Rascunho'>
        <input type='reset' value='Limpar'>

</form>
</div>
<?php require "menu.php"; ?>
