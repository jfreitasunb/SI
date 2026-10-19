<?php require("head_admin.php"); ?>
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
$id_documentador=$_GET["id_documentador"];

////////////////////////////////////busca pelo "documento" na tabela "rascunho".//////////////////////////////////////

$resultado=pg_query("SELECT * FROM admin_rascunho WHERE id_documentador = '$id_documentador'") or die("N? foi poss?el executar a opera?o. Contacte a Coordena?o de Inform?ica.");

//$col=(id_documentador, id_tipo, id_departamento, vocativo, mensagem, desfecho, id_assinatura, assunto, anexo, data, via, assinante)
$col= pg_fetch_array($resultado,0);

?>
<! form action='ati.php?id_documentador=<?php echo $id_documentador ?>' method='post'>
<form action='ati.php' method='post'>
<table class=form>
		<input type=hidden name='id_documentador' value="<?php echo $id_documentador ?>">
		<tr><td width='20%'><font size='2' face='Verdana, Arial, Helvetica, sans-serif'><p>Tipo de Documento:</p></font></td>
                <td><select name= 'dado[]' size='1'>
		<?php 
                $res=pg_query("SELECT nometipo FROM admin_tipo WHERE id_tipo='$col[id_tipo]'")
		or die ("N? foi poss?el consultar o banco.");
                $registro=pg_fetch_row($res,0);
                $nome=$registro[0];
                echo"<option value=\"$col[1]\">$nome</option>";
		?>
                </select></td></tr>
		<br>
<?php
if($col[1]=="1"){ //memorando
?>


	   <tr><td width='20%'><font size='2' face='Verdana, Arial, Helvetica, sans-serif'><p>Via:</p></font></td>
            <td><input name='dado[]'  size=60 value="<?php echo $col['via'] ?>"></td></tr>
	   <tr><td width='20%'><font size='2' face='Verdana, Arial, Helvetica, sans-serif'><p>C/C:</p></font></td>
            <td><input name='com_copia'  size=60 value="<?php echo $col['com_copia'] ?>"></td></tr>

		<tr><td width='20%'><font size='2' face='Verdana, Arial, Helvetica, sans-serif'><p>Destino:</p></font></td>
                <td><select name= 'dado[]' size='1'>
		<?php
                $res=pg_query("SELECT id_departamento,nomedepartamento FROM admin_departamento")
		or die ("N? foi poss?el consultar o banco.");
		$i=0;
                while(@$registro=pg_fetch_row($res,$i))
                {
                        $cod=$registro[0];
                        $nome=$registro[1];
                        echo"<option value=\"$cod\"";
                        if($cod==$col['id_departamento'])
                                echo"selected";
                        echo">$nome</option>\n";
			$i=$i+1;
                }
		$assunto=$col['assunto'];
		$anexo=$col['anexo'];
		$vocativo=$col['vocativo'];
		$mensagem=$col['mensagem'];
		$desfecho=$col['desfecho'];
		?>
                </select></td></tr>
		<br>

            <tr><td width='20%'><font size='2' face='Verdana, Arial, Helvetica, sans-serif'><p>Assunto:</p></font></td>
            <td><input name='dado[]'  size=60 value="<?php echo $assunto ?>"></td></tr>

            <td width='20%'><font size='2' face='Verdana, Arial, Helvetica, sans-serif'><p>Anexo(s):</p></font></td>
            <td><input name='dado[]'  size=60 value="<?php echo $anexo ?>"></td></tr>

            <tr><td width='20%'><font size='2' face='Verdana, Arial, Helvetica, sans-serif'><p>Vocativo:</p></font></td>
            <td><input name='dado[]'  size=60 value="<?php echo $vocativo ?>"></td></tr>

	    <tr><td width='20%'><font size='2' face='Verdana, Arial, Helvetica, sans-serif'><p>Mensagem:</p></font></td>
	    <td><TEXTAREA name= 'dado[]' rows=10 cols=60> <?php echo $mensagem ?> </TEXTAREA></td></tr>

            <tr><td width='130'><font size='2' face='Verdana, Arial, Helvetica, sans-serif'><p>Desfecho:</p></font></td>
            <td><input name='dado[]' size=60 value="<?php echo $desfecho ?>"></td></tr>

	    <tr><td width='20%'><font size='2' face='Verdana, Arial, Helvetica, sans-serif'><p>Assinatura:</p></font></td>
                <td><select name= 'dado[]' size='1'>
		<?php
                $res=pg_query("SELECT id_assinatura,cargo,titulo FROM admin_assinatura") or die ("N? foi poss?el consultar o banco.");
		$i=0;
                while(@$registro=pg_fetch_row($res,$i))
                {
                        $cod=$registro[0];
                        $cargo=$registro[1];
                        echo"<option value=\"$cod\"";
                        if($cod==$col['id_assinatura'])
                                echo"selected";
                        echo">".$cargo."(".$registro[2].")</option>\n";
			$i=$i+1;
                }
		?>

                </select></td></tr>

	    <tr><td width='20%'><font size='2' face='Verdana, Arial, Helvetica, sans-serif'><p>Assinante:</p></font></td>
                <td><select name= 'dado[]' size='1'>
		<?php
                $res2=pg_query("SELECT coduser,name, firstname FROM users where tipo_users='professor' or tipo_users='administrativo' order by name") or die ("N? foi poss?el consultar o banco.");
		$i=0;
                while(@$registro2=pg_fetch_row($res2,$i))
                {
                        $cod2=$registro2[0];
                        $nome2=$registro2[1];
                        $sobrenome2=$registro2[2];
                        echo"<option value=\"$cod2\"";
                        if($cod2==$col['assinante'])
                                echo"selected";
                        echo">$nome2 $sobrenome2 </option>\n";
			$i=$i+1;
                }
		?>

                </select></td></tr>
		<br>
<?php
}

else if(($col[1]=="3")||($col[1]=="6")){ //of?io interno ou externo
//$col=(id_documentador, id_tipo, id_departamento, vocativo, mensagem, desfecho, id_assinatura, assunto, anexo, data, via, assinante)

		$assunto=$col['assunto'];
		$anexo=$col['anexo'];
		$vocativo=$col['vocativo'];
		$mensagem=$col['mensagem'];
		$desfecho=$col['desfecho'];
?>


	    <tr><td width='20%'><font size='2' face='Verdana, Arial, Helvetica, sans-serif'><p>Via:</p></font></td>
            <td><input name='dado[]'  size=60 value="<?php echo $col['via'] ?>"></td></tr>
	    <tr><td width='20%'><font size='2' face='Verdana, Arial, Helvetica, sans-serif'><p>C/C:</p></font></td>
            <td><input name='com_copia'  size=60 value="<?php echo $col['com_copia'] ?>"></td></tr>

	   <tr><td width='20%'><font size='2' face='Verdana, Arial, Helvetica, sans-serif'><p>Destino:</p></font></td>
           <td><select name= 'dado[]' size='1'>
	<?php	
           $res=pg_query("SELECT id_departamento,nomedepartamento FROM admin_departamento") or die ("N? foi poss?el consultar o banco.");
           $i=0;
           while($registro=pg_fetch_row($res,$i))
                {
                 $cod=$registro[0];
                 $nome=$registro[1];
                 echo"<option value=\"$cod\"";
                 if($cod==$col['id_departamento'])
                       echo"selected";
                       echo">$nome</option>\n";
	        $i=$i+1;
                }
		?>


	    <tr><td width='20%'><font size='2' face='Verdana, Arial, Helvetica, sans-serif'><p>Assunto:</p></font></td>
            <td><input name='dado[]'  size=60 value="<?php echo $assunto ?>"></td></tr>

            <td width='20%'><font size='2' face='Verdana, Arial, Helvetica, sans-serif'><p>Anexo(s):</p></font></td>
            <td><input name='dado[]'  size=60 value="<?php echo $anexo ?>"></td></tr>

            <tr><td width='20%'><font size='2' face='Verdana, Arial, Helvetica, sans-serif'><p>Vocativo:</p></font></td>
            <td><input name='dado[]'  size=60 value="<?php echo $vocativo ?>"></td></tr>

            <tr><td width='20%'><font size='2' face='Verdana, Arial, Helvetica, sans-serif'><p>Mensagem:</p></font></td>
            <td><TEXTAREA name= 'dado[]' rows=10 cols=60> <?php echo $mensagem ?> </TEXTAREA></td></tr>

            <tr><td width='130'><font size='2' face='Verdana, Arial, Helvetica, sans-serif'><p>Desfecho:</p></font></td>
            <td><input name='dado[]' size=60 value="<?php echo $desfecho ?>"></td></tr>

	    <tr><td width='20%'><font size='2' face='Verdana, Arial, Helvetica, sans-serif'><p>Assinatura:</p></font></td>
                <td><select name= 'dado[]' size='1'>
		<?php 
                $res=pg_query("SELECT id_assinatura,cargo,titulo FROM admin_assinatura") or die ("N? foi poss?el consultar o banco.");
		$i=0;
                while($registro=pg_fetch_row($res,$i))
                {
                        $cod=$registro[0];
                        $cargo=$registro[1];
                        echo"<option value=\"$cod\"";
                        if($cod==$col['id_assinatura'])
                                echo"selected";
                        echo">".$cargo."(".$registro[2].")</option>\n";
			$i=$i+1;
                }
		?>
                </select></td></tr>

	    <tr><td width='20%'><font size='2' face='Verdana, Arial, Helvetica, sans-serif'><p>Assinante:</p></font></td>
                <td><select name= 'dado[]' size='1'>
		<?php 
                $res2=pg_query("SELECT coduser,name, firstname FROM users where tipo_users='professor' or tipo_users='administrativo' order by name") or die ("N? foi poss?el consultar o banco.");
		$i=0;
                while($registro2=pg_fetch_row($res2,$i))
                {
                        $cod2=$registro2[0];
                        $nome2=$registro2[1];
                        $sobrenome2=$registro2[2];
                        echo"<option value=\"$cod2\"";
                        if($cod2==$col['assinante'])
                                echo"selected";
                        echo">$nome2  $sobrenome2 </option>\n";
			$i=$i+1;
                }
		?>

                </select></td></tr>
<br>
<?php
}

else if($col[1]=="2"){ //circular
//$col=(id_documentador, id_tipo, id_departamento, vocativo, mensagem, desfecho, id_assinatura, assunto, anexo, data, via, assinante)
?>

	    <tr><td width='20%'><font size='2' face='Verdana, Arial, Helvetica, sans-serif'><p>Remetente:</p></font></td>
                <td><select name= 'dado[]' size='1'>
		<?php 
                $res=pg_query("SELECT id_assinatura,cargo,titulo FROM admin_assinatura") or die ("N? foi poss?el consultar o banco.");
		$i=0;
                while($registro=pg_fetch_row($res,$i))
                {
                        $cod=$registro[0];
                        $cargo=$registro[1];
                        echo"<option value=\"$cod\"";
                        if($cod==$col['id_assinatura'])
                                echo"selected";
                        echo">".$cargo."(".$registro[2].")</option>\n";
			$i=$i+1;
                }
?>
                </select></td></tr>
	    <tr><td width='20%'><font size='2' face='Verdana, Arial, Helvetica, sans-serif'><p>Assinante:</p></font></td>
                <td><select name= 'dado[]' size='1'>
		<?php 
                $res2=pg_query("SELECT coduser,name, firstname FROM users where tipo_users='professor' or tipo_users='administrativo' order by name") or die ("N? foi poss?el consultar o banco.");
		$i=0;
                while($registro2=pg_fetch_row($res2,$i))
                {
                        $cod2=$registro2[0];
                        $nome2=$registro2[1];
                        $sobrenome2=$registro2[2];
                        echo"<option value=\"$cod2\"";
                        if($cod2==$col['assinante'])
                                echo"selected";
                        echo">$nome2  $sobrenome2 </option>\n";
			$i=$i+1;
                }
?>
                </select></td></tr>
<?php
		$assunto=$col['assunto'];
		$anexo=$col['anexo'];
		$vocativo=$col['vocativo'];
		$mensagem=$col['mensagem'];
		$desfecho=$col['desfecho'];
		?>


	    <tr><td width='20%'><font size='2' face='Verdana, Arial, Helvetica, sans-serif'><p>Destinat?io:</p></font></td>    
           <td><select name= 'dado[]' size='1'>
	<?php	
           $res=pg_query("SELECT id_departamento,nomedepartamento FROM admin_departamento where '223'<= id_departamento and id_departamento <= '226' or id_departamento='229' or id_departamento='236'") or die ("N? foi poss?el consultar o banco.");
           $i=0;
           while($registro=pg_fetch_row($res,$i))
                {
                 $cod=$registro[0];
                 $nome=$registro[1];
                 echo"<option value=\"$cod\"";
                 if($cod==$col['id_departamento'])
                       echo"selected";
                       echo">$nome</option>\n";
	        $i=$i+1;
                }
		?>
             </select></td></tr>
            <tr><td width='20%'><font size='2' face='Verdana, Arial, Helvetica, sans-serif'><p>Assunto:</p></font></td>
            <td><input name='dado[]'  size=60 value="<?php echo $assunto ?>"></td></tr>

            <td width='20%'><font size='2' face='Verdana, Arial, Helvetica, sans-serif'><p>Vocativo:</p></font></td>
            <td><input name='dado[]'  size=60 value="<?php echo $vocativo ?>"></td></tr>

            <tr><td width='20%'><font size='2' face='Verdana, Arial, Helvetica, sans-serif'><p>Mensagem:</p></font></td>
            <td><TEXTAREA name= 'dado[]' rows=10 cols=60><?php echo $mensagem ?></TEXTAREA></td></tr>

	    <tr><td width='20%'><font size='2' face='Verdana, Arial, Helvetica, sans-serif'><p>Desfecho:</p></font></td>
            <td><input name='dado[]'  size=60 value="<?php echo $desfecho ?>"></td></tr>

	    <br>
<?php
}

else if($col[1]=="4"){ // ato
//$col=(id_documentador, id_tipo, id_departamento, vocativo, mensagem, desfecho, id_assinatura, assunto, anexo, data, via, assinante)
		$assunto=$col['assunto'];
//		$anexo=mb_convert_encoding($col['anexo'],"ISO-8859-1","UTF-8");
//		$vocativo=mb_convert_encoding($col['vocativo'],"ISO-8859-1","UTF-8");
		$mensagem=$col['mensagem'];
//		$desfecho=mb_convert_encoding($col['desfecho'],"ISO-8859-1","UTF-8");
?>
           <tr><td width='20%'><font size='2' face='Verdana, Arial, Helvetica, sans-serif'><p>Assunto:</p></font></td>
            <td><input name='dado[]'  size=60 value="<?php echo $assunto ?>"></td></tr>
	
	<tr><td width='20%'><font size='2' face='Verdana, Arial, Helvetica, sans-serif'><p>Mensagem:</p></font></td>
        <td><TEXTAREA name= 'dado[]' rows=10 cols=60><?php echo $mensagem ?></TEXTAREA></td></tr>

	    <tr><td width='20%'><font size='2' face='Verdana, Arial, Helvetica, sans-serif'><p>Assinatura:</p></font></td>
                <td><select name= 'dado[]' size='1'>
		<?php
                $res=pg_query("SELECT id_assinatura,cargo,titulo FROM admin_assinatura") or die ("N? foi poss?el consultar o banco.");
		$i=0;
                while($registro=pg_fetch_row($res,$i))
                {
                        $cod=$registro[0];
                        $cargo=$registro[1];
                        echo"<option value=\"$cod\"";
                        if($cod==$col['id_assinatura'])
                                echo"selected";
                        echo">".$cargo."(".$registro[2].")</option>\n";
			$i=$i+1;
                }
		?>
               
                </select></td></tr>

	    <tr><td width='20%'><font size='2' face='Verdana, Arial, Helvetica, sans-serif'><p>Assinante:</p></font></td>
                <td><select name= 'dado[]' size='1'>
		<?php
                $res2=pg_query("SELECT coduser,name, firstname FROM users where tipo_users='professor' or tipo_users='administrativo' order by name") or die ("N? foi poss?el consultar o banco.");
		$i=0;
                while($registro2=pg_fetch_row($res2,$i))
                {
                        $cod2=$registro2[0];
                        $nome2=$registro2[1];
                        $sobrenome2=$registro2[2];
                        echo"<option value=\"$cod2\"";
                        if($cod2==$col['assinante'])
                                echo"selected";
                        echo">$nome2  $sobrenome2 </option>\n";
			$i=$i+1;
                }
		?>
               </select></td></tr>
<br>
<?php
}

else if($col[1]=="5"){ //ata

//$col=(id_documentador, id_tipo, id_departamento, vocativo, mensagem, desfecho, id_assinatura, assunto, anexo, data, via, assinante)
		$assunto=$col['assunto'];
//		$anexo=mb_convert_encoding($col['anexo'],"ISO-8859-1","UTF-8");
//		$vocativo=mb_convert_encoding($col['vocativo'],"ISO-8859-1","UTF-8");
		$mensagem=$col['mensagem'];
//		$desfecho=mb_convert_encoding($col['desfecho'],"ISO-8859-1","UTF-8");
?>
	 <tr><td width='20%'><font size='2' face='Verdana, Arial, Helvetica, sans-serif'><p>Assunto:</p></font></td>
            <td><input name='dado[]'  size=60 value="<?php echo $assunto ?>"></td></tr>
	
	<tr><td width='20%'><font size='2' face='Verdana, Arial, Helvetica, sans-serif'><p>Mensagem:</p></font></td>
        <td><TEXTAREA name= 'dado[]' rows=10 cols=60><?php echo $mensagem ?></TEXTAREA></td></tr>
	<br>

            <tr><td width='20%'><font size='2' face='Verdana, Arial, Helvetica, sans-serif'><p>Assinatura:</p></font></td>
                <td><select name= 'dado[]' size='1'>
                <?php
                $res=pg_query("SELECT id_assinatura,cargo,titulo FROM admin_assinatura") or die ("N?o foi poss?vel consultar o banco.");
                $i=0;
                while($registro=pg_fetch_row($res,$i))
                {
                        $cod=$registro[0];
                        $cargo=$registro[1];
                        echo"<option value=\"$cod\"";
                        if($cod==$col['id_assinatura'])
                                echo"selected";
                        echo">".$cargo,"(".$registro[2].")</option>\n";
                        $i=$i+1;
                }
                ?>

                </select></td></tr>

            <tr><td width='20%'><font size='2' face='Verdana, Arial, Helvetica, sans-serif'><p>Assinante:</p></font></td>
                <td><select name= 'dado[]' size='1'>
                <?php
                $res2=pg_query("SELECT coduser,name, firstname FROM users where tipo_users='professor' or tipo_users='administrativo' order by name") 
or die ("N?ofoi poss?vel consultar o banco.");
                $i=0;
                while($registro2=pg_fetch_row($res2,$i))
                {
                        $cod2=$registro2[0];
                        $nome2=$registro2[1];
                        $sobrenome2=$registro2[2];
                        echo"<option value=\"$cod2\"";
                        if($cod2==$col['assinante'])
                                echo"selected";
                        echo">$nome2  $sobrenome2 </option>\n";
                        $i=$i+1;
                }
                ?>
               </select></td></tr>

  <tr><td width='20%'><font size='2' face='Verdana, Arial, Helvetica, sans-serif'><p>Assinatura:</p></font></td>
                <td><select name= 'dado[]' size='1'>
                <?php
                $res3=pg_query("SELECT id_assinatura,cargo,titulo FROM admin_assinatura") or die ("N?o foi poss?vel consultar o banco.");
                $i=0;
                while($registro3=pg_fetch_row($res3,$i))
                {
                        $cod3=$registro3[0];
                        $cargo3=$registro3[1];
                        echo"<option value=\"$cod3\"";
                        if($cod3==$col['assinatura2'])
                                echo"selected";
                        echo">".$cargo3."(".$registro3[2].")</option>\n";
                        $i=$i+1;
                }
                ?>
  
                </select></td></tr>

            <tr><td width='20%'><font size='2' face='Verdana, Arial, Helvetica, sans-serif'><p>Assinante:</p></font></td>
                <td><select name= 'dado[]' size='1'>
                <?php
                $res4=pg_query("SELECT coduser,name, firstname FROM users where tipo_users='professor' or tipo_users='administrativo' order by name")
or die ("N?ofoi poss?vel consultar o banco.");
                $i=0;
                while($registro4=pg_fetch_row($res4,$i))
                {
                        $cod4=$registro4[0];
                        $nome4=$registro4[1];
                        $sobrenome4=$registro4[2];
                        echo"<option value=\"$cod4\"";
                        if($cod4==$col['assinante2'])
                                echo"selected";
                        echo">$nome4  $sobrenome4 </option>\n";
                        $i=$i+1;
                }
                ?>
               </select></td></tr>

<?php
}
?>

</table>
<br>
	    <input name='origem' type='hidden' value='editar'>
	    <input name='data' type='hidden' value='$col[9]'>
            <input name='acao' type='submit' value='Visualizar'>
	    <input name='acao' type='submit' value='Rascunho'>
            <input name='acao' type='submit' value='Definitivo'>
</table>
</form>
</div>



