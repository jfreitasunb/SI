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
  <form method=POST name="utilisateur" action='add_user3.php' onsubmit="return verif_pass();">
  <tr><td class=header align=center>
        <h1>Modifica&ccedil;&atilde;o de conta</h1></td></tr>
    <tr><td><table align=center class=form><tr>
          <td class=header align=center colspan=2></td></tr>
        <tr><td>
<?php
//     $query="select * from users order by name";
   $query="select u.matricul, u.name, u.firstname, u.coduser from users u, unix ux where u.coduser=ux.coduser order by u.name "; $query__p = array();
     $result=db_query($query, $query__p);
     $nb_enreg=db_num_rows($result);
     $i=0;
?>
            <select name='user' onchange="enregistrement(utilisateurs,this.selectedIndex,nb_enreg);">>
<?php
            for ($i=0;$i<$nb_enreg;$i++)
            {
               $tab=db_fetch_array($result, $i);

       $test2="select * from unix where coduser=?"; $test2__p = array($tab['coduser']);
       $result2=db_query($test2, $test2__p);
       $tab2=db_fetch_array($result2,0);
               
$param="'".$tab['coduser']."','".$tab2['login']."','".$tab2['cota_impressao']."','".$tab2['cota_disco']."','".$tab2['cota_mail']."','".$tab2['ssh']."'";
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
<INPUT TYPE=HIDDEN NAME='coduser'>
        <tr>
        </table>
      </td>
    </tr>
    <tr>
      <td colspan=3 align=center>
        <table class=form>
        <tr><td colspan=4 class=header align=center>
            Dados da Conta :</td></tr>
        <tr><td> Quota Impress&atilde;o : </td><td><input type=text name='cota_impressao' maxlength=4 size=4>  por m&ecirc;s

            <td>Quota de Disco :</td><td><input type=text name='cota_disco1' maxlength=5 size=4 readonly>
					<select name='cota_disco'>
					<option value='nao_modifica' selected>n&atilde;o altera</option>
				        <option>300Mb</option>
					<option>500Mb</option>
					<option>1Gb</option>
					</select></td>

        <tr><td>Quota de email :</td><td><input type=text name='cota_mail1' maxlength=5 size=4 readonly>
					<select name='cota_mail'>
					<option value='nao_modifica' selected>n&atilde;o altera</option>
					<option>50Mb</option>
					<option>100Mb</option>
					<option>200Mb</option>
					<option>300Mb</option>
					<option>400Mb</option>
					</select></td>

            <td>Acesso ao ssh :</td><td><input type=text name='ssh1' maxlength=5 size=4 readonly>
					<select name='ssh'>
					<option value='nao_modifica' selected>n&atilde;o altera</option>
				        <option>nao</option>
					<option>sim</option>
					</select></td>
	</tr>
	<tr>
       <tr><td>O seu login n&atilde;o ser&aacute; modificado:</td><td><input type=text name='login' readonly></td>
    	<td>Senha Atual :</td><td><input type=password name='pass0' maxlength=20>
	<tr><td>Insira uma nova <b>Senha</b>:</td><td><input type=password name='pass1' maxlength=20>
        <td>e <b>confirme</b> :</td><td><input type=password name='pass2' maxlength=20>
      </td>
    </tr> 
	</table></td></tr>

   <?php php/*  <tr><td align=center>
         <table class=form><tr><td class=header align=center colspan=3>Tipo de Conta</td></tr>
          <tr><td>Unix :</td><td><input type=checkbox name=unix enabled ></td></tr> 
          </td></tr></table></td></tr> */?>
     <tr>
       <td align=center>
         <input type=submit value=Modificar>
    
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
  db_close($idconn);
?>
