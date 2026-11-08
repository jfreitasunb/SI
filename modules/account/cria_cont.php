<?php
  require("head_account.php");
?>
<html>
  <header>
    <link type="text/css" rel="stylesheet" href="../../global/grafic.css">
    <script language="JavaScript" src="navig_js.js"></script>
    <script language=javascript src="formu.js"></script>
    <script language="javascript">
      var utilisateurs = new Array();
      var i = 0;
    </script>
    <script language=javascript src="formu.js">
    </script>
    <script language=javascript>
      function verif_pass()
{
            if (document.utilisateur.pass1.value!= document.utilisateur.pass2.value)
            {
                alert('As duas senhas nao sao identicas!');
                document.utilisateur.pass1.focus();
                return false;
            }
            return true;
}
   </script>

  </header>  
  <body>
  <table class=big>
 <!form method=POST name="utilisateur" action='add_user4.php' onsubmit="return verif_pass();">
  <form method=POST name="utilisateur" action='add_user4.php'>
  <tr><td class=header align=center>
        <h1>Cria&ccedil;&atilde;o de conta</h1></td></tr>
    <tr><td><table align=center class=form><tr>
          <td class=header align=center colspan=2></td></tr>
        <tr><td>
<?php
//     $query="select * from users order by name";
   $query="select us.coduser from users us where us.coduser<>'0' except select ux.coduser from unix ux"; $query__p = array();
     $result=db_query($query, $query__p);
     $nb_enreg=db_num_rows($result);
     $i=0;
    if ($nb_enreg!=0)
	{
?>
            <select name='user' onchange="enregistrement(utilisateurs,this.selectedIndex,nb_enreg);">>
<?php
            for ($i=0;$i<$nb_enreg;$i++)
            {
               $tab0=db_fetch_array($result, $i);
		$query="select matricul, name, firstname, tipo_users from users where coduser=? and name<> 'root'"; $query__p = array($tab0['coduser']);
		$result1=db_query($query, $query__p);

               $tab=db_fetch_array($result1,0);
               $param=js_str($tab0['coduser']).','.js_str($tab['tipo_users']).','.js_str('').','.js_str('').','.js_str(''); // o nome de tipo_users no formulário é login. os campos 											// cota_impressao,cota_disco,cota_mail voltam vazios.
               $param=str_replace(CHR(10)," ",$param);
               $param=str_replace(CHR(13)," ",$param);
?>
	       <script language="javascript">
                 utilisateurs[<?php echo $i ?>] = new conta(<?php echo $param ?>);
               </script>
<?php
               echo "<option value='".h($tab0['coduser'])."'";
               if ($_GET['US']==$tab0['coduser']) echo " selected  ";
               echo ">".h($tab['matricul'])."--".h($tab['name'])." ".h($tab['firstname'])."</option>";
            }
?>
            </select>
          </td>
        </tr>
<INPUT TYPE=HIDDEN NAME='coduser'>
<INPUT TYPE=HIDDEN NAME='login'>
<INPUT TYPE=HIDDEN NAME='cota_impressao'>
<INPUT TYPE=HIDDEN NAME='cota_disco'>
<INPUT TYPE=HIDDEN NAME='cota_mail'>
        <tr>
        </table>
      </td>
    </tr>
    <tr>
      <td align=center>

       Por favor, escolha um<b>Nome de usuario</b>:
        <input type=text name='login_novo' maxlength=10 onkeypress="return verif_log(event);">
      </td>
    </tr>
<?php
/*
     <tr>
      <td align=center>
        Uma <b>Senha</b>:
        <input type=password name=pass1 maxlength=8>
        e <b>confirme</b> :
        <input type=password name=pass2 maxlength=8>
      </td>
    </tr> 
*/
?>
    <tr>
      <td align=center>
        <input type=submit value='Cadastrar'>
        <!/table>
      </td>
    </tr> 
        </table>
      </td>
    </tr>
  </form>
  <script language="javascript">
    var nb_enreg = <?php echo h($nb_enreg)-1 ?>;
    enregistrement(utilisateurs,i,nb_enreg);
  </script>
     <table>
<?php
  }
else 
{
?>

   <tr>
      <td align=center>

      <b> N&atilde;o &eacute; poss&iacute;vel criar uma conta nova. Cadastre um novo usu&aacute;rio primeiro.</b>
      </td>
    </tr>

<?php
}
?>
    </body>
</html>
<?php
  db_close($idconn);
?>


