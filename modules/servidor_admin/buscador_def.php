<?php require("head_admin.php"); ?>
<html>
<header>
    <script language=javascript src="function_js.js">
    </script>
    <script language=javascript src="formu.js">
    </script>
    <script language=javascript>
function verif_touche(e)
        {
        if(e.keyCode)touche = e.keyCode;
        else touche = e.which;
        if((touche>=48 && touche <= 57) || (touche==8) || (touche==9)) return true;
        else return false;
        }
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
	echo " 	<h1>Buscar Documento</h1>
		<p> Escolha abaixo o tipo de documento a ser encontrado. </p> ";

?>

<form action='buscador_lista_def.php' method='post'>
<table><br>
        <tr><td><b>Tipo de documento: </b></td><td><select name= 'id_tipo' size = '1'>
		<?php
                $res=db_query("SELECT id_tipo,nometipo FROM admin_tipo", array()) or die ("N? foi poss?el consultar o banco.");
                while($registro=db_fetch_row($res,$i))
                	{
                        $cod=$registro[0];
                        $nome=$registro[1];
                        echo"<option value=$cod>$nome</option>\n";
                	}
        	?>

        </select></td></tr>
	<tr>
	<td><b>Destino(sigla):</b></td><td><input type="text" name="destino" maxlength="10" size="5"></td>
	</tr>
	<tr>
	<td><b>Assunto:</b></td><td><input type="text" name="assunto" maxlength="40"></td>
	</tr>
	<tr>
	<td><b>N&uacute;mero do documento:</b></td><td><input type="text" name="numerodocumento" maxlength="5"></td>
	</tr>
	<tr>
	<td><b>Data de emiss&atilde;o(mes/ano):</b></td><td><input type="text" name="mes" maxlength="2" size="1">/<input type="text" 
name="ano" maxlength="4" size="2"></td>
	</tr>
	<tr>
	<td><b>UnBDoc:</b></td><td><input type="text" name="unbdoc" size="5" onkeypress="return verif_touche(event);">/<select name="ano_unbdoc"> 
	<?php
//onkeypress="return verif_touche(event);"
        $ano_atual=date(Y);
        $ano_fim=$ano_atual-11;
        for ($indice_ano=$ano_atual;$indice_ano>$ano_fim;$indice_ano--)
                {
                if ($indice_ano==$ano_atual) $selected_ano="selected"; else $selected_ano="";
                echo "<option value='".$indice_ano."' ".$selected_ano." >".$indice_ano."</option>";
                }
	?>      
        </select></td>
	</tr>
		
</table><br>


<table>
	<input type='submit' name='busca' value='Buscar'>
</table>
</form>
</table>
</body>
</html>

