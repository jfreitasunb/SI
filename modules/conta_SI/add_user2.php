<?php
  include("head_conta_SI.php");
?>

<html>
   <header>
    <script language=javascript src="formu.js">
    </script>
    <script language="JavaScript" src="navig_js.js"></script>
    <script language="javascript"> 
	var utilisateurs = new Array();
      var i = 0;
   </script>
    <script language=javascript>
      function verif_pass()
{
            if (document.utilisateur.pass1.value!= document.utilisateur.pass2.value)
            {
                alert("As duas senhas devem ser as mesmas!");
                document.utilisateur.pass1.focus();
                return false;
            }
            if (document.utilisateur.login.value.length==0)
            {
                alert("Forne&ccedil;a um login !");
                document.forms['utilisateur'].login.focus();
                return false;
            } 
            if ((document.utilisateur.pass1.value.length==0)||(document.utilisateur.pass2.value.length==0))
            {
                alert("Forne&ccedil;a uma senha e confirme-a!");
                document.forms['utilisateur'].pass1.focus();
                return false;
            }
            return true;
}

    </script>
    <link type="text/css" rel="stylesheet" href="../../global/grafic.css">
  </header>
  <body>
  <table class=big>
  <form method=POST name="utilisateur" action='add_user3.php' onsubmit="return verif_pass();">
  <tr>
      <td class=header align=center colspan=2>
        <h1>Cria&ccedil;&atilde;o de uma conta SI</h1>
      </td>
    </tr>   
    <tr>
      <td>
        <table align=center class=form>
        <tr>
          <td class=header align=center colspan=2>Selecione um usu&aacute;rio</td>
        </tr>
        <tr>
          <td>

<?php
     $query="select * from users where name<>'root' and (tipo_users='professor' or tipo_users='administrativo') order by name";
     $result=pg_query($query);
     $nb_enreg=pg_num_rows($result);
     $i=0;
?>
            <select name='user' onchange="enregistrement(utilisateurs,this.selectedIndex,nb_enreg);">>
<?php
            for ($i=0;$i<$nb_enreg;$i++)
            {
               $tab=pg_fetch_array($result, $i);

               $param="'".$tab['coduser']."'"; //,'".$tab['name']."','".$tab['firstname']."','".$tab['matricul']."'";
              $param=str_replace(CHR(10)," ",$param);
             $param=str_replace(CHR(13)," ",$param);
?>
	       <script language="javascript">
                 utilisateurs[<?php echo $i ?>] = new conta(<?php echo $param ?>);
               </script>
<?php

               echo "<option value='".$tab['coduser']."'";
               if ($_GET['US']==$tab['coduser']) echo " selected  ";
               echo ">".$tab['matricul']."--".$tab['name']." ".$tab['firstname']."</option>";
            }
?>
            </select>
          </td>
        </tr>
        </table>
      </td>
    </tr>
        <td colspan=2 align=center>
        <table class=form>
        <td class=header colspan=4 align=center>Dados da conta SI </td>
        <tr>
          <td> Nome de usu&aacute;rio: </td>
          <td>
            <input type=text name='login'>
          </td>
   <tr>
          <td>Digite a senha :</td>
          <td><input type=password name=pass1></td>
          <td>Confirme :</td>
          <td><input type=password name=pass2></td>
  </tr>
         </tr>
	</table>
    <input type=hidden value='si_prec' name='si_prec'>

    <tr>
      <td align=center>
        <table class=form>
        <tr>
          <td class=header align=center colspan=2>
            Permiss&otilde;es para a conta SI : 
          </td>
        </tr>
<?php
  $query2="select idmodule,name from module";
  $result2=pg_query($query2);
  $count2=pg_num_rows($result2);
  for ($y;$y<$count2;$y++)
  {
    $tab2=pg_fetch_array($result2,$y);
?>
  <tr>
    <td>
      <b><?php echo $tab2['name'] ?></b>
    </td>
    <td align=right>
      <select name=droits[]>
        <option value=0 checked>no rights</option>
        <option value=1>readonly</option>
        <option value=2>read and write</option>
      </select>
    </td>
  </tr>
<?php    
  } 
?>
	</table>

        <table class=form>
      <td align=center>
        <input type=submit value='Cadastrar'>
      </td>
	</table>
    </tr> 
    <input type=hidden name='coduser'> 
  </form>
 <script language="javascript">
    var nb_enreg = <?php echo $nb_enreg-1 ?>;
    enregistrement(utilisateurs,i,nb_enreg);
  </script>

  </table>
  </body>
</html>
<?php

  pg_close($idconn);
?>
