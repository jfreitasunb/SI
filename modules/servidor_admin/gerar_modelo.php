<?php require("head_admin.php");?>
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
          <h1>Departamento de Matematica</h1>
        </td>
      </tr>
      <tr>
        <td align=center>
               <title>Servidor Administrativo</title>
<?php
$tipo_modelo=$_POST["tipo_modelo"]; //busca pelo "modelo" na tabela "modelo".
$vetor_modelo=db_query("SELECT * FROM admin_modelo WHERE id_modelo = ?", array($tipo_modelo)) or die("Não foi possível executar a operação. Contacte a Coordenação de Informática.");
$col= db_fetch_array($vetor_modelo,0);

$res=db_query("SELECT nometipo FROM admin_tipo WHERE id_tipo=?", array($col[1]))
                or die ("N\xe3o foi poss\xedvel consultar o banco.");
                $registro=db_fetch_row($res,$i);
                $nome=$registro[0];
?>
	<form action='ati.php' method='post'>
	<h2>Gerar documento a partir do modelo de <br> <?php echo $nome ?> abaixo</h2>
	<table class=form>
	<tr><td width='20%'><font size='2' face='Verdana, Arial, Helvetica, sans-serif'><p>Tipo de Documento:</p></font></td>
                <td><select name= 'dado[]' size='1'>
                <?php
                $res=db_query("SELECT nometipo FROM admin_tipo WHERE id_tipo=?", array($col[1]))
                or die ("N\xe3o foi poss\xedvel consultar o banco.");
                $registro=db_fetch_row($res,0);
                $nome=$registro[0];

                echo"<option value=$col[id_tipo]>$nome</option>";
		?>
                </select></td></tr><br>

<?php

if($col[1]=="1") //memorando
        {
//(id_modelo,id_tipo,assunto,anexo,vocativo,mensagem,desfecho,campo_6,campo_7,campo_8,campo_9,campo_10) 
		$assunto=$col['assunto'];
		$anexo=$col['anexo'];
		$vocativo=$col['vocativo'];
		$mensagem=$col['mensagem'];
		$desfecho=$col['desfecho'];
		$via=$col['via'];
		$destino=$col['destino'];

?>

	<tr><td width='20%'><font size='2' face='Verdana, Arial, Helvetica, sans-serif'><p>Via:</p></font></td>
           <td><input name='dado[]' type='text' size=20 <?php echo "value=\"$via\" " ; ?>></td></tr>


	    <tr><td width='20%'><font size='2' face='Verdana, Arial, Helvetica, sans-serif'><p>Destino:</p></font></td>
                <td><select name= 'dado[]' size='1'>
		<?php
                $res1=db_query("SELECT id_departamento,nomedepartamento FROM admin_departamento", array())
		or die ("Não foi possível consultar o banco.");
		$i=0;
                while($registro1=db_fetch_row($res1,$i))
                {
                        $cod1=$registro1[0];
                        $nome1=$registro1[1];
                        echo"<option value=\"$cod1\"";
                        if($cod1==$col['destino'])
                                echo"selected";
                        echo">$nome1</option>\n";
			$i=$i+1;
                }
		?>
                </select></td></tr><br>
	
            <tr><td width='20%'><font size='2' face='Verdana, Arial, Helvetica, sans-serif'><p>Assunto:</p></font></td>
            <td><input name='dado[]'  size=60 <?php echo "value=\"$assunto\" " ; ?>></td></tr>

            <td width='20%'><font size='2' face='Verdana, Arial, Helvetica, sans-serif'><p>Anexo(s):</p></font></td>
            <td><input name='dado[]'  size=60 <?php echo "value=\"$anexo\" ";?> ></td></tr>

            <tr><td width='20%'><font size='2' face='Verdana, Arial, Helvetica, sans-serif'><p>Vocativo:</p></font></td>
            <td><input name='dado[]'  size=60 <?php echo "value=\"$vocativo\" ";?>></td></tr>

	    <tr><td width='20%'><font size='2' face='Verdana, Arial, Helvetica, sans-serif'><p>Mensagem:</p></font></td>
	    <td><TEXTAREA name= 'dado[]' rows=10 cols=60> <?php echo $mensagem; ?> </TEXTAREA></td></tr>

            <tr><td width='130'><font size='2' face='Verdana, Arial, Helvetica, sans-serif'><p>Desfecho:</p></font></td>
            <td><input name='dado[]' size=60 <?php echo "value=\"$desfecho \" ";?>></td></tr>

           <tr><td width='130'><font size='2' face='Verdana, Arial, Helvetica, sans-serif'><p>Assinatura:</p></font></td>
           <td><select name= 'dado[]' size='1'>
		<?php
                $res2=db_query("SELECT id_assinatura,cargo FROM admin_assinatura", array()) or die ("Nao foi possivel consultar o banco.");
		$i=0;
                while($registro2=db_fetch_row($res2,$i))
                {
                        $cod2=$registro2[0];
                        $cargo2=$registro2[1];
                        echo"<option value='".$cod2."'>".$cargo2."</option>\n";
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
                        echo"<option value='".$cod3."'>".$nome3." ".$sobrenome."</option>\n";
			$i=$i+1;
                }
        	?>
		</select></td></tr>
<?php
	}
else if (($col[1]=="3")||($col[1]=="6"))//ofício interno ou externo
	{
//(id_modelo,id_tipo,assunto,anexo,vocativo,mensagem,desfecho,campo_6,campo_7,campo_8,campo_9,campo_10) 
		$assunto=$col['assunto'];
		$anexo=$col['anexo'];
		$vocativo=$col['vocativo'];
		$mensagem=$col['mensagem'];
		$desfecho=$col['desfecho'];
		$via=$col['via'];
		$destino=$col['destino'];

?>


	<tr><td width='20%'><font size='2' face='Verdana, Arial, Helvetica, sans-serif'><p>Via:</p></font></td>
           <td><input name='dado[]' type='text' size=20 <?php echo "value=\"$via \" " ; ?>></td></tr>


	    <tr><td width='20%'><font size='2' face='Verdana, Arial, Helvetica, sans-serif'><p>Destino:</p></font></td>
                <td><select name= 'dado[]' size='1'>
		<?php
                $res1=db_query("SELECT id_departamento,nomedepartamento FROM admin_departamento", array())
		or die ("Não foi possível consultar o banco.");
		$i=0;
                while($registro1=db_fetch_row($res1,$i))
                {
                        $cod1=$registro1[0];
                        $nome1=$registro1[1];
                        echo"<option value=\"$cod1\"";
                        if($cod1==$col['destino'])
                                echo"selected";
                        echo">$nome1</option>\n";
			$i=$i+1;
                }
		?>
                </select></td></tr><br>

	<tr><td width='20%'><font size='2' face='Verdana, Arial, Helvetica, sans-serif'><p>Assunto:</p></font></td>
            <td><input name='dado[]'  size=60 <?php echo "value=\"$assunto\" " ; ?>></td></tr>

        <td width='20%'><font size='2' face='Verdana, Arial, Helvetica, sans-serif'><p>Anexo(s):</p></font></td>
            <td><input name='dado[]'  size=60 <?php echo "value=\"$anexo\" ";?> ></td></tr>

        <tr><td width='20%'><font size='2' face='Verdana, Arial, Helvetica, sans-serif'><p>Vocativo:</p></font></td>
            <td><input name='dado[]'  size=60 <?php echo "value=\"$vocativo\" ";?>></td></tr>

        <tr><td width='20%'><font size='2' face='Verdana, Arial, Helvetica, sans-serif'><p>Mensagem:</p></font></td>
            <td><TEXTAREA name= 'dado[]' rows=10 cols=60> <?php echo $mensagem; ?> </TEXTAREA></td></tr>

            <tr><td width='130'><font size='2' face='Verdana, Arial, Helvetica, sans-serif'><p>Desfecho:</p></font></td>
            <td><input name='dado[]' size=60 <?php echo "value=\"$desfecho \" ";?>></td></tr>

           <tr><td width='130'><font size='2' face='Verdana, Arial, Helvetica, sans-serif'><p>Assinatura:</p></font></td>
           <td><select name= 'dado[]' size='1'>
		<?php
                $res2=db_query("SELECT id_assinatura,cargo FROM admin_assinatura", array()) or die ("Nao foi possivel consultar o banco.");
		$i=0;
                while($registro2=db_fetch_row($res2,$i))
                {
                        $cod2=$registro2[0];
                        $cargo2=$registro2[1];
                        echo"<option value='".$cod2."'>".$cargo2."</option>\n";
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
                        echo"<option value='".$cod3."'>".$nome3." ".$sobrenome."</option>\n";
			$i=$i+1;
                }
        	?>
		</select></td></tr>
<?php
	}

else if ($col[1]=="2") //circular
	{
//(id_modelo,id_tipo,assunto,anexo,vocativo,mensagem,desfecho,campo_6,campo_7,campo_8,campo_9,campo_10) 
		$assunto=$col['assunto'];
		$anexo=$col['anexo'];
		$vocativo=$col['vocativo'];
		$mensagem=$col['mensagem'];
		$desfecho=$col['desfecho'];
		$via=$col['via'];
		$destino=$col['destino'];

?>

           <tr><td width='130'><font size='2' face='Verdana, Arial, Helvetica, sans-serif'><p>Remetente:</p></font></td>
           <td><select name= 'dado[]' size='1'>
		<?php
                $res2=db_query("SELECT id_assinatura,cargo FROM admin_assinatura", array()) or die ("Nao foi possivel consultar o banco.");
		$i=0;
                while($registro2=db_fetch_row($res2,$i))
                {
                        $cod2=$registro2[0];
                        $cargo2=$registro2[1];
                        echo"<option value='".$cod2."'>".$cargo2."</option>\n";
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
                        echo"<option value='".$cod3."'>".$nome3." ".$sobrenome."</option>\n";
			$i=$i+1;
                }
        	?>
		</select></td></tr>
	   <tr><td width='20%'><font size='2' face='Verdana, Arial, Helvetica, sans-serif'><p>Destinatário:</p></font></td>
                <td><select name= 'dado[]' size='1'>
		<?php
                $res1=db_query("SELECT id_departamento,nomedepartamento FROM admin_departamento", array())
		or die ("Não foi possível consultar o banco.");
		$i=0;
                while($registro1=db_fetch_row($res1,$i))
                {
                        $cod1=$registro1[0];
                        $nome1=$registro1[1];
                        echo"<option value=\"$cod1\"";
                        if($cod1==$col['destino'])
                                echo"selected";
                        echo">$nome1</option>\n";
			$i=$i+1;
                }
        	?>
		</select></td></tr>


	   <tr><td width='20%'><font size='2' face='Verdana, Arial, Helvetica, sans-serif'><p>Assunto:</p></font></td>
           <td><input name='dado[]' type='text' size=60 <?php echo "value=\"$assunto\" ";?>></td></tr>


           <tr><td width='20%'><font size='2' face='Verdana, Arial, Helvetica, sans-serif'><p>Vocativo:</p></font></td>
           <td><input name='dado[]' type='text' size=60  <?php echo "value=\"$vocativo\" ";?>></td></tr>


           <tr><td width='20%'><font size='2' face='Verdana, Arial, Helvetica, sans-serif'><p>Mensagem:</p></font></td>
           <td><TEXTAREA name= 'dado[]' rows=10 cols=60> <?php echo $mensagem ?></TEXTAREA></td></tr>


           <tr><td width='130'><font size='2' face='Verdana, Arial, Helvetica, sans-serif'><p>Desfecho:</p></font></td>
           <td><input name='dado[]' type='text' size=60 <?php echo "value=\"$desfecho\" ";?>></td></tr>
<?php 
	}
else if ($col[1]=="4") //ato
	{
//(id_modelo,id_tipo,assunto,anexo,vocativo,mensagem,desfecho,campo_6,campo_7,campo_8,campo_9,campo_10) 
		$assunto=$col['assunto'];
//		$anexo=mb_convert_encoding($col['anexo'],"ISO-8859-1","UTF-8");
//		$vocativo=mb_convert_encoding($col['vocativo'],"ISO-8859-1","UTF-8");
		$mensagem=$col['mensagem'];
//		$desfecho=mb_convert_encoding($col['desfecho'],"ISO-8859-1","UTF-8");
//		$via=mb_convert_encoding($col['via'],"ISO-8859-1","UTF-8");
//		$destino=mb_convert_encoding($col['destino'],"ISO-8859-1","UTF-8");

?>
         <tr><td width='20%'><font size='2' face='Verdana, Arial, Helvetica, sans-serif'><p>Assunto:</p></font></td>
           <td><input name='dado[]' type='text' size=60 <?php echo "value=\"$assunto\" ";?>></td></tr>

	<tr><td width='20%'><font size='2' face='Verdana, Arial, Helvetica, sans-serif'><p>Mensagem:</p></font></td>
           <td><TEXTAREA name= 'dado[]' rows=10 cols=60> <?php echo $mensagem ?></TEXTAREA></td></tr>


<tr><td width='130'><font size='2' face='Verdana, Arial, Helvetica, sans-serif'><p>Assinatura:</p></font></td>
           <td><select name= 'dado[]' size='1'>
		<?php
                $res2=db_query("SELECT id_assinatura,cargo FROM admin_assinatura", array()) or die ("Nao foi possivel consultar o banco.");
		$i=0;
                while($registro2=db_fetch_row($res2,$i))
                {
                        $cod2=$registro2[0];
                        $cargo2=$registro2[1];
                        echo"<option value='".$cod2."'>".$cargo2."</option>\n";
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
                        echo"<option value='".$cod3."'>".$nome3." ".$sobrenome."</option>\n";
			$i=$i+1;
                }
        	?>
		</select></td></tr>
		<input type='hidden' name=dado[]' value="152">
<?php 
	}
else if ($col[1]=="5") //ata
	{
//(id_modelo,id_tipo,assunto,anexo,vocativo,mensagem,desfecho,campo_6,campo_7,campo_8,campo_9,campo_10) 
		$assunto=$col['assunto'];
//		$anexo=mb_convert_encoding($col['anexo'],"ISO-8859-1","UTF-8");
//		$vocativo=mb_convert_encoding($col['vocativo'],"ISO-8859-1","UTF-8");
		$mensagem=$col['mensagem'];
//		$desfecho=mb_convert_encoding($col['desfecho'],"ISO-8859-1","UTF-8");
//		$via=mb_convert_encoding($col['via'],"ISO-8859-1","UTF-8");
//		$destino=mb_convert_encoding($col['destino'],"ISO-8859-1","UTF-8");

?>
         <tr><td width='20%'><font size='2' face='Verdana, Arial, Helvetica, sans-serif'><p>Assunto:</p></font></td>
           <td><input name='dado[]' type='text' size=60 <?php echo "value=\"$assunto\" ";?>></td></tr>

	<tr><td width='20%'></td>
           <td><TEXTAREA name= 'dado[]' rows=30 cols=60> <?php echo $mensagem ?></TEXTAREA></td></tr>

	<tr><td width='130'><font size='2' face='Verdana, Arial, Helvetica, sans-serif'><p>Assinatura:</p></font></td>
           <td><select name= 'dado[]' size='1'>
                <?php
                $res2=db_query("SELECT id_assinatura,cargo FROM admin_assinatura", array()) or die ("Nao foi possivel consultar o banco");
                $i=0;
                while($registro2=db_fetch_row($res2,$i))
                {
                        $cod2=$registro2[0];
                        $cargo2=$registro2[1];
                        echo"<option value='".$cod2."'>".$cargo2."</option>\n";
                        $i=$i+1;
                }
                ?>
                </select></td></tr>

	   <tr><td width='130'><font size='2' face='Verdana, Arial, Helvetica, sans-serif'><p>Assinante:</p></font></td>
           <td><select name= 'dado[]' size='1'>
                <?php
                $res3=db_query("SELECT coduser,name, firstname FROM users where tipo_users='professor' or tipo_users='administrativo' order by \nname", array()) or die ("Nao foi possivel consultar o banco");
                $i=0;
                while($registro3=db_fetch_row($res3,$i))
                {
                        $cod3=$registro3[0];
                        $nome3=$registro3[1];
                        $sobrenome=$registro3[2];
                        echo"<option value='".$cod3."'>".$nome3." ".$sobrenome."</option>\n";
                        $i=$i+1;
                }
                ?>   
                </select></td></tr>

 <tr><td width='130'><font size='2' face='Verdana, Arial, Helvetica, sans-serif'><p>Assinatura:</p></font></td>
           <td><select name= 'dado[]' size='1'>
                <?php   
                $res4=db_query("SELECT id_assinatura,cargo FROM admin_assinatura", array()) or die ("Nao foi possivel consultar o banco");
                $i=0;
                while($registro4=db_fetch_row($res4,$i))
                {
                        $cod4=$registro4[0];
                        $cargo4=$registro4[1];
                        echo"<option value='".$cod4."'>".$cargo4."</option>\n";
                        $i=$i+1;
                }
                ?>
                </select></td></tr>

           <tr><td width='130'><font size='2' face='Verdana, Arial, Helvetica, sans-serif'><p>Assinante:</p></font></td>
           <td><select name= 'dado[]' size='1'>
                <?php
		$res5=db_query("SELECT coduser,name, firstname FROM users where tipo_users='professor' or tipo_users='administrativo' order by\nname", array()) or die ("Nao foi possivel consultar o banco");
                $i=0;
                while($registro5=db_fetch_row($res5,$i))
                {
                        $cod5=$registro5[0];
                        $nome5=$registro5[1];
                        $sobrenome=$registro5[2];
                        echo"<option value='".$cod3."'>".$nome5." ".$sobrenome."</option>\n";
                        $i=$i+1;
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
<?php
  db_close($idconn);
?>
