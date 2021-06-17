<?php 
	include("head_admin.php"); 
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
          <h1>Departamento de Matematica</h1>
        </td>
      </tr>
      <tr>
        <td align=center>
               <title>Servidor Administrativo</title>

<form action='ati_insere_modelo.php' method='post'>

<table class=form>
	<tr><td width='20%'><font size='2' face='Verdana, Arial, Helvetica, sans-serif'><p>Tipo de Documento:</p></font></td>
        	<td><select name= 'id_tipo' size = '1'>
		<?php
                $res=pg_query("SELECT id_tipo,nometipo FROM admin_tipo") or die ("Não foi possível consultar o banco.");
		$i=0;
                while($registro=pg_fetch_row($res,$i))
                	{
                        $cod=$registro[0];
                        $nome=$registro[1];
                        echo"<option value=$cod>$nome</option>\n";
			$i=$i+1;
                	}
        	?>

        </select></td></tr>
<br>

	<tr><td width='20%'><font size='2' face='Verdana, Arial, Helvetica, sans-serif'><p>Via:</p></font></td>
           <td><input name='via' type='text' size=20 ></td></tr>


	    <tr><td width='20%'><font size='2' face='Verdana, Arial, Helvetica, sans-serif'><p>Destino:</p></font></td>
                <td><select name= 'destino' size='1'>
		<?php
                $res1=pg_query("SELECT id_departamento,nomedepartamento FROM admin_departamento")
		or die ("Não foi possível consultar o banco.");
		$i=0;
                while($registro1=pg_fetch_row($res1,$i))
                {
                        $cod1=$registro1[0];
                        $nome1=$registro1[1];
                        echo"<option value=\"$cod1\">$nome1</option>\n";
			$i=$i+1;
                }
		?>
                </select></td></tr><br>



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
	
       	<input name='acao' type='submit' value='Salvar Modelo'>
	<input type='reset' value='Limpar'>

</form>

</body></html>
