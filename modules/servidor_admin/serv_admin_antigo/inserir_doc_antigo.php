<?php include("head_account.php"); ?>
<?php
$tipo_documento=$_POST["tipo_documento"];
require "cabecalho.html";


if(!isset($_POST["tipo_documento"]))
	{
?>


		<h1>Inserir Documentos Antigos</h1>
		<p>Selecione abaixo o tipo de documento que deseja inserir.</p>
        		<form action='inserir_doc_antigo.php' method='post'>
        		<table>
                	<tr><td><select name= 'tipo_documento' size='1'>
				<?php
                        	$res=pg_query("SELECT id_tipo,nometipo FROM admin_tipo")
				or die ("Não foi possível consultar o banco.");
                		while($registro=pg_fetch_row($res,$i))
                			{
                        		$cod=$registro[0];
                        		$nome=$registro[1];
                        		echo"<option value=$cod>$nome</option>\n";
                			}
				?>
                	</select></td></tr></table><br>
                	<input  type='submit' value='Selecionar'>
                	</form>
                	</div>


<?php
	}
else if(isset($_POST["tipo_documento"]))
        {
?>


                <h1>Inserir Documentos Antigos</h1>
		<form action='ati_antigo.php' method='post' >
		<table>
			<tr><td width='20%'><p>Tipo de Documento:</p></font></td>
                	<td><select name= 'dado[]' size='1'>
                		<?php
                		$res=pg_query("SELECT nometipo FROM admin_tipo WHERE id_tipo='$tipo_documento'")
                		or die ("Não foi possível consultar o banco.");
                		$registro=pg_fetch_row($res,$i);
                		$nome=$registro[0];
                		echo"<option value=\"$tipo_documento\">$nome</option>";
                		?>
                		</select></td></tr><br>

	<tr><td width='20%'><font size='2' face='Verdana, Arial, Helvetica, sans-serif'><p>Data (dd/mm/aaaa):</p>
	</font></td>
        <td><input name='dado[]' type='text' size=20 ></td></tr>



<?php

	if(($_POST["tipo_documento"])=="1") //memorando
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
                        	echo"<option value=$cod1>$nome1</option>\n";
                		}
        		?>
		</select></td></tr>


           	<tr><td width='20%'><font size='2' face='Verdana, Arial, Helvetica, sans-serif'><p>Assunto:</p></font></td>
           	<td><input name='dado[]' type='text' size=60 ></td></tr>


           	<tr><td width='20%'><font size='2' face='Verdana, Arial, Helvetica, sans-serif'><p>Anexo(s):</p></font></td>
           	<td><input name='dado[]' type='text' size=60 ></td></tr>


           	<tr><td width='20%'><font size='2' face='Verdana, Arial, Helvetica, sans-serif'><p>Vocativo:</p></font></td>
           	<td><input name='dado[]' type='text' size=60 ></td></tr>


           	<tr><td width='20%'><font size='2' face='Verdana, Arial, Helvetica, sans-serif'><p>Mensagem:</p></font></td>
	   	<td><TEXTAREA name= 'dado[]' rows=10 cols=60>Insira aqui a mensagem.</TEXTAREA></td></tr>


           	<tr><td width='130'><font size='2' face='Verdana, Arial, Helvetica, sans-serif'><p>Desfecho:</p></font></td>
           	<td><input name='dado[]' type='text' size=60></td></tr>


           	<tr><td width='130'><font size='2' face='Verdana, Arial, Helvetica, sans-serif'><p>Assinatura:</p>
		</font></td>
           	<td><select name= 'dado[]' size='1'>
			<?php
                	$res2=pg_query("SELECT id_assinatura,nome FROM admin_assinatura")
			or die ("Não foi possível consultar o banco.");
                	while($registro2=pg_fetch_row($res2,$i))
                		{
                        	$cod2=$registro2[0];
                        	$nome2=$registro2[1];
                        	echo"<option value=$cod2>$nome2</option>\n";
                		}
        		?>
		</select></td></tr>

<?php

	}
	else if((($_POST["tipo_documento"])=="3")||(($_POST["tipo_documento"])=="6")) //ofício interno e externo
        {
?>

   	<tr><td width='20%'><font size='2' face='Verdana, Arial, Helvetica, sans-serif'><p>Via:</p></font></td>
        <td><input name='dado[]' type='text' size=20 ></td></tr>


	<tr><td width='20%'><font size='2' face='Verdana, Arial, Helvetica, sans-serif'><p>Destino:</p></font></td>
        <td><input name='dado[]' type='text' size=60 ></td></tr>


        <tr><td width='20%'><font size='2' face='Verdana, Arial, Helvetica, sans-serif'><p>Assunto:</p></font></td>
        <td><input name='dado[]' type='text' size=60 ></td></tr>


        <tr><td width='20%'><font size='2' face='Verdana, Arial, Helvetica, sans-serif'><p>Anexo(s):</p></font></td>
        <td><input name='dado[]' type='text' size=60 ></td></tr>



         <tr><td width='20%'><font size='2' face='Verdana, Arial, Helvetica, sans-serif'><p>Vocativo:</p></font></td>
         <td><input name='dado[]' type='text' size=60 ></td></tr>


    	<tr><td width='20%'><font size='2' face='Verdana, Arial, Helvetica, sans-serif'><p>Mensagem:</p></font></td>
        <td><TEXTAREA name= 'dado[]' rows=10 cols=60>Insira aqui a mensagem.</TEXTAREA></td></tr>


        <tr><td width='130'><font size='2' face='Verdana, Arial, Helvetica, sans-serif'><p>Assinatura:</p></font></td>
        <td><select name= 'dado[]' size='1'>
                <?php
                $res2=pg_query("SELECT id_assinatura,nome FROM admin_assinatura")
		or die ("Não foi possível consultar o banco.");
                while($registro2=pg_fetch_row($res2,$i))
                	{
                        $cod2=$registro2[0];
                        $nome2=$registro2[1];
                        echo"<option value=$cod2>$nome2</option>\n";
                	}
                ?>
         </select></td></tr>


<?php
	}

	else if($_POST["tipo_documento"]=="2") //circular
	{
?>
        <tr><td width='130'><font size='2' face='Verdana, Arial, Helvetica, sans-serif'><p>Remetente:</p></font></td>
        <td><select name= 'dado[]' size='1'>
                <?php
                $res2=pg_query("SELECT id_assinatura,nome FROM admin_assinatura")
		or die ("Não foi possível consultar o banco.");
                while($registro2=pg_fetch_row($res2,$i))
                	{
                        $cod2=$registro2[0];
                        $nome2=$registro2[1];
                        echo"<option value=$cod2>$nome2</option>\n";
                	}
                ?>

         </select></td></tr>


	   <tr><td width='20%'><font size='2' face='Verdana, Arial, Helvetica, sans-serif'><p>Destinatário:</p></font></td>
           <td><select name='dado[]' type='text' size='1' >
		<option value='Professores do MAT'>Professores do MAT</option>
		<option value='Funcionários da Secretaria do MAT'>Funcionários da Secretaria do MAT</option>
		<option value='Estagiários do MAT'>Estagiários do MAT</option>
		</select></td></tr>


	   <tr><td width='20%'><font size='2' face='Verdana, Arial, Helvetica, sans-serif'><p>Assunto:</p></font></td>
           <td><input name='dado[]' type='text' size=60 ></td></tr>


           <tr><td width='20%'><font size='2' face='Verdana, Arial, Helvetica, sans-serif'><p>Vocativo:</p></font></td>
           <td><input name='dado[]' type='text' size=60 ></td></tr>


           <tr><td width='20%'><font size='2' face='Verdana, Arial, Helvetica, sans-serif'><p>Mensagem:</p></font></td>
           <td><TEXTAREA name= 'dado[]' rows=10 cols=60>Insira aqui a mensagem.</TEXTAREA></td></tr>


           <tr><td width='130'><font size='2' face='Verdana, Arial, Helvetica, sans-serif'><p>Desfecho:</p></font></td>
           <td><input name='dado[]' type='text' size=60></td></tr>

<?php
	}
	else if($_POST["tipo_documento"]=="4") //ato
	{
?>

	<tr><td width='20%'><font size='2' face='Verdana, Arial, Helvetica, sans-serif'><p>Mensagem:</p></font></td>
        <td><TEXTAREA name= 'dado[]' rows=10 cols=60>Insira aqui a mensagem.</TEXTAREA></td></tr>


	<tr><td width='130'><font size='2' face='Verdana, Arial, Helvetica, sans-serif'><p>Assinatura:</p></font></td>
        <td><select name= 'dado[]' size='1'>
                <?php
                $res2=pg_query("SELECT id_assinatura,nome FROM admin_assinatura")
		or die ("Não foi possível consultar o banco.");
                while($registro2=pg_fetch_row($res2,$i))
                	{
                        $cod2=$registro2[0];
                        $nome2=$registro2[1];
                        echo"<option value=$cod2>$nome2</option>\n";
                	}
                ?>
         </select></td></tr>

<?php
	}
	else if($_POST["tipo_documento"]=="5") //ata
	{
?>

	<tr><td width='20%'></td>
        <td><TEXTAREA name= 'dado[]' rows=30 cols=60>Descreva aqui a ata da reunião.</TEXTAREA></td></tr>


<?php
	}
?>

 	</table>
        <br>
        <input name='origem' type='hidden' value='gerar'>
        <input name='acao' type='submit' value='Visualizar'>
        <input name='acao' type='submit' value='Definitivo'>
        <input type='reset' value='Limpar'>

        </form>
        </div>

<?php
}
require "menu.php";
?>
