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
   <meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
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
   $query="select u.matricul, u.name, u.firstname, u.coduser from users u, unix ux where u.coduser=ux.coduser and ux.coduser<>'0' order by u.name ";
     $result=pg_query($query);
     $nb_enreg=pg_num_rows($result);
     $i=0;
?>
            <select name='user' onchange="enregistrement(utilisateurs,this.selectedIndex,nb_enreg);">>
<?php
            for ($i=0;$i<$nb_enreg;$i++)
            {
               $tab=pg_fetch_array($result, $i);

       $test2="select * from unix where coduser=".$tab['coduser'];
       $result2=pg_query($test2);
       $tab2=pg_fetch_array($result2,0);
               
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
					<?php 
					$query_cotas_disco=pg_query("select * from cotas");
					while($registro_cota_disco=pg_fetch_row($query_cotas_disco))
						{
						echo "<option>".$registro_cota_disco[0]."</option>";
						}
					?>
					</select></td>

        <tr><td>Quota de email :</td><td><input type=text name='cota_mail1' maxlength=5 size=4 readonly>
					<select name='cota_mail'>
					<option value='nao_modifica' selected>n&atilde;o altera</option>
					 <?php
                                        $query_cotas_mail=pg_query("select * from cotas");
                                        while($registro_cota_mail=pg_fetch_row($query_cotas_mail))
                                                {
                                                echo "<option>".$registro_cota_mail[0]."</option>";
                                                }
					?>
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

    <tr><td align=center>
         <table class=form><tr><td class=header align=center colspan=3>Mudar automaticamente a senha do usuário</td></tr>
          <tr><td><input type=radio name="muda_senha" value="sim"><b>Sim</b></td><td><input type=radio name="muda_senha" value="nao" CHECKED><b>N&atilde;o</b></td></tr> 
          </td></tr></table></td></tr> 
   
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
  pg_close($idconn);
?>
