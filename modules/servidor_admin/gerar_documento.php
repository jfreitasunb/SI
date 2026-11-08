<?php 

require("head_admin.php");
$tipo_documento=$_POST['tipo_documento'];
?>
<html>
<header>
    <script language=javascript src="function_js.js">
    </script>
    <script language=javascript src="formu.js">
    </script>
    <link type="text/css" rel="stylesheet" href="../../global/grafic.css">
<meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
  </header>
<body>
<table class=big>
      <tr>
        <td class=header align=center>
          <h1>Departamento de Matem&aacute;tica</h1>
        </td>
      </tr>
      <tr>
        <td align=center>
               <title>Servidor Administrativo</title>
<form action='ati.php' method='post' >

<?php 
                $res=db_query("SELECT nometipo FROM admin_tipo WHERE id_tipo=?", array($tipo_documento)) or die ("Nao foi possivel consultar o banco.");
                $registro=db_fetch_row($res)
                ?>
<h1>Gerar <?php echo h($registro[0]); ?> </h1>


<?php 

	if($_POST['tipo_documento']=="1") //gerar um memorando
	{
?>
		<table class=form align=center>
		<input type='hidden' name='dado[]' value="1">
		<tr><td width='20%'><font size='2' face='Verdana, Arial, Helvetica, sans-serif'><p>Via:</p></font></td>
        	   <td><input name='dado[]' type='text' size=20 ></td></tr>
		<tr><td width='20%'><font size='2' face='Verdana, Arial, Helvetica, sans-serif'><p>C/C:</p></font></td>
		   <td><input name='com_copia' type='text' size=20 ></td></tr>
		<tr><td width='20%'><font size='2' face='Verdana, Arial, Helvetica, sans-serif'><p>Destino:</p></font></td>
        	<td><select name= 'dado[]' size='1'>
		<?php
                $res1=db_query("SELECT id_departamento,nomedepartamento FROM admin_departamento order by nomedepartamento", array()) or die ("Nao foi possivel consultar o banco.");
		$i=0;
		while($registro1=db_fetch_array($res1,$i))
                {
	                $cod1=$registro1['id_departamento'];
                        $nome1=$registro1['nomedepartamento'];
                        echo "<option value='".h($cod1)."' >".h($nome1)."</option>\n";
			$i=$i+1;
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


           <tr><td width='130'><font size='2' face='Verdana, Arial, Helvetica, sans-serif'><p>Assinatura:</p></font></td>
           <td><select name= 'dado[]' size='1'>
		<?php
                $res2=db_query("SELECT id_assinatura,cargo,titulo FROM admin_assinatura", array()) or die ("Nao foi possivel consultar o banco.");
		$i=0;
                while($registro2=db_fetch_row($res2,$i))
                {
                        $cod2=$registro2[0];
                        $cargo2=$registro2[1];
//			$titulo2=$registro2[2];
                        echo"<option value='".h($cod2)."'>".h($cargo2)."(".h($registro2[2]).")</option>\n";
			$i=$i+1;
                }
        	?>
		</select></td></tr>

           <tr><td width='130'><font size='2' face='Verdana, Arial, Helvetica, sans-serif'><p>Assinante:</p></font></td>
           <td><select name= 'dado[]' size='1'>
		<?php
                $res3=db_query("SELECT coduser,name, firstname FROM users where tipo_users='professor' or tipo_users='administrativo' order by name", array()) or die ("Nao foi possivel consultar o banco.");
		$i=0;
                while($registro3=db_fetch_row($res3,$i))
                {
                        $cod3=$registro3[0];
                        $nome3=$registro3[1];
			$sobrenome=$registro3[2];
                        echo"<option value='".h($cod3)."'>".h($nome3)." ".h($sobrenome)."</option>\n";
			$i=$i+1;
                }
        	?>
		</select></td></tr>
		</table>

<?php


	}
	else if(($_POST["tipo_documento"]=="3")||($_POST["tipo_documento"]=="6")) //of?io interno ou externo
        {
?>
		<table class=form align=center>
	<input type='hidden' name='dado[]' value="<?php echo h($_POST["tipo_documento"])?>">
   	<tr><td width='20%'><font size='2' face='Verdana, Arial, Helvetica, sans-serif'><p>Via:</p></font></td>
           <td><input name='dado[]' type='text' size=20 ></td></tr>
	<tr><td width='20%'><font size='2' face='Verdana, Arial, Helvetica, sans-serif'><p>C/C:</p></font></td>
	   <td><input name='com_copia' type='text' size=20 ></td></tr>
	<tr><td width='20%'><font size='2' face='Verdana, Arial, Helvetica, sans-serif'><p>Destino:</p></font></td>
        	<td><select name= 'dado[]' size='1'>
		<?php
                $res1=db_query("SELECT id_departamento,nomedepartamento FROM admin_departamento order by nomedepartamento", array()) or die ("Nao foi possivel consultar o banco.");
		$i=0;
		while($registro1=db_fetch_array($res1,$i))
                {
	                $cod1=$registro1['id_departamento'];
                        $nome1=$registro1['nomedepartamento'];
                        echo "<option value='".h($cod1)."' >".h($nome1)."</option>\n";
			$i=$i+1;
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

	   <tr><td width='130'><font size='2' face='Verdana, Arial, Helvetica, sans-serif'><p>Assinatura:</p></font></td>
           <td><select name= 'dado[]' size='1'>
		<?php
                $res2=db_query("SELECT id_assinatura,cargo,titulo FROM admin_assinatura", array()) or die ("Nao foi possivel consultar o banco.");
		$i=0;
                while($registro2=db_fetch_row($res2,$i))
                {
                        $cod2=$registro2[0];
                        $cargo2=$registro2[1];
                        echo"<option value='".h($cod2)."'>".h($cargo2)."(".h($registro2[2]).")</option>\n";
			$i=$i+1;
                }
        	?>
		</select></td></tr>

           <tr><td width='130'><font size='2' face='Verdana, Arial, Helvetica, sans-serif'><p>Assinante:</p></font></td>
           <td><select name= 'dado[]' size='1'>
		<?php
                $res3=db_query("SELECT coduser,name, firstname FROM users where tipo_users='professor' or tipo_users='administrativo' order by name", array()) or die ("Nao foi possivel consultar o banco.");
		$i=0;
                while($registro3=db_fetch_row($res3,$i))
                {
                        $cod3=$registro3[0];
                        $nome3=$registro3[1];
			$sobrenome=$registro3[2];
                        echo"<option value='".h($cod3)."'>".h($nome3)." ".h($sobrenome)."</option>\n";
			$i=$i+1;
                }
        	?>
		</select></td></tr>		</table>
<?php

	}

	else if($_POST["tipo_documento"]=="2") //circular
	{
?>
		<table class=form align=center>
		<input type='hidden' name='dado[]' value="2">
           <tr><td width='130'><font size='2' face='Verdana, Arial, Helvetica, sans-serif'><p>Remetente:</p></font></td>
           <td><select name= 'dado[]' size='1'>
		<?php
                $res2=db_query("SELECT id_assinatura,cargo,titulo FROM admin_assinatura", array()) or die ("Nao foi possivel consultar o banco.");
		$i=0;
                while($registro2=db_fetch_row($res2,$i))
                {
                        $cod2=$registro2[0];
                        $cargo2=$registro2[1];
                        echo"<option value='".h($cod2)."'>".h($cargo2)."(".h($registro2[2]).")</option>\n";
			$i=$i+1;
                }
        	?>
		</select></td></tr>

           <tr><td width='130'><font size='2' face='Verdana, Arial, Helvetica, sans-serif'><p>Assinante:</p></font></td>
           <td><select name= 'dado[]' size='1'>
		<?php
                $res3=db_query("SELECT coduser,name, firstname FROM users where tipo_users='professor' or tipo_users='administrativo' order by name", array()) or die ("Nao foi possivel consultar o banco.");
		$i=0;
                while($registro3=db_fetch_row($res3,$i))
                {
                        $cod3=$registro3[0];
                        $nome3=$registro3[1];
			$sobrenome=$registro3[2];
                        echo"<option value='".h($cod3)."'>".h($nome3)." ".h($sobrenome)."</option>\n";
			$i=$i+1;
                }
        	?>
		</select></td></tr>
	   <tr><td width='20%'><font size='2' face='Verdana, Arial, Helvetica, sans-serif'><p>Destinat&aacute;io:</p></font></td>
           <td><select name='dado[]' type='text' size='1' >
		<?php
                $res1=db_query("SELECT id_departamento,nomedepartamento FROM admin_departamento where '22'<= id_departamento and id_departamento <= '226' order by nomedepartamento", array())
		or die ("N? foi poss?el consultar o banco.");
		$i=0;
                while($registro1=db_fetch_row($res1,$i))
                {
                        $cod1=$registro1[0];
                        $nome1=$registro1[1];
                        echo"<option value=\"" . h($cod1) . "\">" . h($nome1) . "</option>\n";
			$i=$i+1;
                }
		?>
                </select></td></tr><br>


	   <tr><td width='20%'><font size='2' face='Verdana, Arial, Helvetica, sans-serif'><p>Assunto:</p></font></td>
           <td><input name='dado[]' type='text' size=60 ></td></tr>


           <tr><td width='20%'><font size='2' face='Verdana, Arial, Helvetica, sans-serif'><p>Vocativo:</p></font></td>
           <td><input name='dado[]' type='text' size=60 ></td></tr>


           <tr><td width='20%'><font size='2' face='Verdana, Arial, Helvetica, sans-serif'><p>Mensagem:</p></font></td>
           <td><TEXTAREA name= 'dado[]' rows=10 cols=60>Insira aqui a mensagem.</TEXTAREA></td></tr>


           <tr><td width='130'><font size='2' face='Verdana, Arial, Helvetica, sans-serif'><p>Desfecho:</p></font></td>
           <td><input name='dado[]' type='text' size=60></td></tr>
		</table>
<?php 
	}
	else if($_POST["tipo_documento"]=="4") //ato
	{
?>
		<table class=form align=center>
		<input type='hidden' name='dado[]' value="4">

         <tr><td width='20%'><font size='2' face='Verdana, Arial, Helvetica, sans-serif'><p>Assunto:</p></font></td>
           <td><input name='dado[]' type='text' size=60 >Ato de xxxxxx do dia xx/xx/xxxx </td></tr>

	<tr><td width='20%'><font size='2' face='Verdana, Arial, Helvetica, sans-serif'><p>Mensagem:</p></font></td>
           <td><TEXTAREA name= 'dado[]' rows=10 cols=60>Insira aqui a mensagem.</TEXTAREA></td></tr>


<tr><td width='130'><font size='2' face='Verdana, Arial, Helvetica, sans-serif'><p>Assinatura:</p></font></td>
           <td><select name= 'dado[]' size='1'>
		<?php
                $res2=db_query("SELECT id_assinatura,cargo,titulo FROM admin_assinatura", array()) or die ("Nao foi possivel consultar o banco.");
		$i=0;
                while($registro2=db_fetch_row($res2,$i))
                {
                        $cod2=$registro2[0];
                        $cargo2=$registro2[1];
                        echo"<option value='".h($cod2)."'>".h($cargo2)."(".h($registro2[2]).")</option>\n";
			$i=$i+1;
                }
        	?>
		</select></td></tr>

           <tr><td width='130'><font size='2' face='Verdana, Arial, Helvetica, sans-serif'><p>Assinante:</p></font></td>
           <td><select name= 'dado[]' size='1'>
		<?php
                $res3=db_query("SELECT coduser,name, firstname FROM users where tipo_users='professor' or tipo_users='administrativo' order by name", array()) or die ("Nao foi possivel consultar o banco.");
		$i=0;
                while($registro3=db_fetch_row($res3,$i))
                {
                        $cod3=$registro3[0];
                        $nome3=$registro3[1];
			$sobrenome=$registro3[2];
                        echo"<option value='".h($cod3)."'>".h($nome3)." ".h($sobrenome)."</option>\n";
			$i=$i+1;
                }
        	?>
		</select></td></tr>
		</table>
		<input type='hidden' name='dado[]' value="152">
<?php 
	}
	else if($_POST["tipo_documento"]=="5") //ata
	{
?>
		<table class=form align=center>
		<input type='hidden' name='dado[]' value="5">

         <tr><td width='20%'><font size='2' face='Verdana, Arial, Helvetica, sans-serif'><p>Assunto:</p></font></td>
           <td><input name='dado[]' type='text' size=60 >Ata da reuni&atilde;o de colegiado do dia xx/xx/xxxx </td></tr>

	<tr><td width='20%'></td>
           <td><TEXTAREA name= 'dado[]' rows=30 cols=60>Descreva aqui a ata da reuni?.</TEXTAREA></td></tr>

<tr><td width='130'><font size='2' face='Verdana, Arial, Helvetica, sans-serif'><p>Assinatura:</p></font></td>
           <td><select name= 'dado[]' size='1'>
                <?php
                $res2=db_query("SELECT id_assinatura,cargo,titulo FROM admin_assinatura", array()) or die ("Nao foi possivel consultar o banco.");
                $i=0;
                while($registro2=db_fetch_row($res2,$i))
                {
                        $cod2=$registro2[0];
                        $cargo2=$registro2[1];
                        echo"<option value='".h($cod2)."'>".h($cargo2)."(".h($registro2[2]).")</option>\n";
                        $i=$i+1;
                }
                ?>
                </select></td></tr>
  
           <tr><td width='130'><font size='2' face='Verdana, Arial, Helvetica, sans-serif'><p>Assinante:</p></font></td>
           <td><select name= 'dado[]' size='1'>
                <?php
                $res3=db_query("SELECT coduser,name, firstname FROM users where tipo_users='professor' or tipo_users='administrativo' order by name", array()) 
or die ("Nao foi possivel consultar o banco.");
                $i=0;
                while($registro3=db_fetch_row($res3,$i))
                {
                        $cod3=$registro3[0];
                        $nome3=$registro3[1];
                        $sobrenome=$registro3[2];
                        echo"<option value='".h($cod3)."'>".h($nome3)." ".h($sobrenome)."</option>\n";
                        $i=$i+1;
                }
                ?>
                </select></td></tr>

	<tr><td width='130'><font size='2' face='Verdana, Arial, Helvetica, sans-serif'><p>Assinatura:</p></font></td>
           <td><select name= 'dado[]' size='1'>
                <?php
                $res4=db_query("SELECT id_assinatura,cargo,titulo FROM admin_assinatura", array()) or die ("Nao foi possivel consultar o banco.");
                $i=0;
                while($registro4=db_fetch_row($res4,$i))
                {       
                        $cod4=$registro4[0];
                        $cargo4=$registro4[1];
                        echo"<option value='".h($cod4)."'>".h($cargo4)."(".h($registro4[2]).")</option>\n";
                        $i=$i+1;
                }
                ?>
                </select></td></tr>

           <tr><td width='130'><font size='2' face='Verdana, Arial, Helvetica, sans-serif'><p>Assinante:</p></font></td>
           <td><select name= 'dado[]' size='1'>
                <?php
                $res5=db_query("SELECT coduser,name, firstname FROM users where tipo_users='professor' or tipo_users='administrativo' order by name", array())
or die ("Nao foi possivel consultar o banco.");
                $i=0;
                while($registro5=db_fetch_row($res5,$i))
                {
                        $cod5=$registro5[0];
                        $nome5=$registro5[1];
                        $sobrenome=$registro5[2];
                        echo"<option value='".h($cod5)."'>".h($nome5)." ".h($sobrenome)."</option>\n";
                        $i=$i+1;
                }
                ?>
                </select></td></tr>

	</table>
<?php 
	} 
?>
	<input name='origem' type='hidden' value='gerar'>
	<table class=form align=center>
	<tr>
        <td><input name='acao' type='submit' value='Visualizar'>
        <input name='acao' type='submit' value='Salvar Rascunho'>
        <input type='reset' value='Limpar'></td>
	</tr>
	</table>
</table>
</form>
</div>
</body>
</html>
