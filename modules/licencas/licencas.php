<?php
  include("head_licencas.php");
?>
<html>
  <header>
    <link type="text/css" rel="stylesheet" href="../../global/grafic.css">
    <script language="JavaScript" src="navig_js.js"></script>
    <script language="javascript" src="formu.js"></script>
    <script language="javascript" src="function_js.js"></script>
    <script language="javascript"> 
	var utilisateurs = new Array();
      var i = 0;
   </script>
   </header>
  <body>
  <table class=big>
  <form method="POST" name="utilisateur" action="add_licencas2.php" onsubmit="return valid_form()">
  <tr>
      <td class=header align=center>
        <h1>Inclus&atilde;o/Altera&ccedil;&atilde;o de Licen&ccedil;as</h1>
      </td>
    </tr>
    <tr>
      <td>
        <table align=center class=form>
        <tr>
          <td class=header align=center colspan=2>Selecione um professor:</td>
        </tr>
        <tr>
          <td>
<?php
     $query_licences=pg_query("select * from licences_tipo order by tipo");
     $query="select us.coduser,us.name,us.firstname,us.matricul from users us, profs p where us.coduser=p.coduser and p.orientateur='true' order by us.name";
     $result=pg_query($query);
     $nb_enreg=pg_num_rows($result);
     $i=0;
?>
            <select name='user' onchange="enregistrement(utilisateurs,this.selectedIndex,nb_enreg);">>
<?php
            for ($i=0;$i<$nb_enreg;$i++)
            {
               $tab=pg_fetch_array($result, $i);
		$nome=mb_convert_encoding($tab['name'],"ISO-8859-1","UTF-8");
		$sobrenome=mb_convert_encoding($tab['firstname'],"ISO-8859-1","UTF-8");

               $param="'".$tab['coduser']."','".$nome."','".$sobrenome."','".$tab['matricul']."'";
               $param=str_replace(CHR(10)," ",$param);
               $param=str_replace(CHR(13)," ",$param);
?>
	       <script language="javascript">
                 utilisateurs[<?php echo $i ?>] = new users(<?php echo $param ?>);
               </script>
<?php
               echo "<option value='".$tab['coduser']."'";
               if ($_GET['US']==$tab['coduser']) echo " selected  ";
               echo ">".$tab['matricul']."--".$nome." ".$sobrenome."</option>";
            }
?>
            </select>
          </td>
        </tr>
        </table>
      </td>
    </tr>
<input type=hidden name='coduser'>
<input type=hidden name='name'>
<input type=hidden name='firstname'>
<input type=hidden name='matricul'>
    <tr>
      <td colspan=2 align=center>
        <table class=form>
        <tr>
          <td colspan=4 class=header align=center>
            Dados da licen&ccedil;a</td>
		<tr><td>Tipo de licen&ccedil;a :
		<select name="licenca">
		<?php
		while($registro_licences=pg_fetch_row($query_licences))
			{
			echo "<option value=\"".$registro_licences[0]."\">".mb_convert_encoding($registro_licences[1],"ISO-8859-1","UTF-8")."</option>";
			}
		?>
		</select>
		</td>
        </tr>
        <tr>
           <td>Institui&ccedil;&atilde;o:<input type=text name='instituicao' maxlength=67 size="50" onblur="this.value= prem_lettre_majuscule(this.value)"></td>
           <td> Cidade: <input type=text name='cidade' maxlength=17></td>
           <td> Estado: <input type=text name='estado' maxlength=10></td>
           </td>
         </tr>

        <tr>
          <td> T&iacute;tulo (palestra ou trablaho apresentado/ tese ou disserta&ccedil;&atilde;o) : 
		<input type=text name='titulo' maxlength=58 onblur="this.value= prem_lettre_majuscule(this.value)">
          </td>
         </tr>
        <tr>
          <td> Autor (da tese ou disserta&ccedil;&atilde;o) : 
		<input type=text name='autor' maxlength=39 size="30" onblur="this.value= prem_lettre_majuscule(this.value)">
          </td>
         </tr>

        <tr>
          <td>Per&iacute;odo de: <input type=integer name='dia_ida' maxlength="2" size="1">/<input type=integer name='mes_ida' maxlength="2" size="1">/<input type=integer name='ano_ida' maxlength="4" size="4">
	a: <input type=integer name='dia_volta' maxlength="2" size="1">/<input type=integer name='mes_volta' maxlength="2" size="1">/<input type=integer name='ano_volta' maxlength="4" size="4"></td>
        </tr>
        </table>
       </td>
     </tr>
     <tr>
       <td align=center>
         <input type=submit value=Cadastrar>
       </td>
     </tr>
  </form>
  <script language="javascript">
    var nb_enreg = <?php echo $nb_enreg-1 ?>;
    enregistrement(utilisateurs,i,nb_enreg);
  </script>
     <table>
    </body>
</html>
<?php
  pg_close($idconn);
?>
