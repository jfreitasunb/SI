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
  </header>  
  <body>
  <table class=big>
  <form name="utilisateur"> 
  <tr>
      <td class=header align=center>
        <h1>Modifica&ccedil;&atilde;o de conta</h1></td></tr>
    <tr><td><table align=center class=form><tr>
          <td class=header align=center colspan=2></td></tr>
        <tr><td>
<?php
     $result=db_query("select * from users order by name");
     $nb_enreg=db_num_rows($result);
     $i=0;
?>
            <select name='user' onchange="enregistrement(utilisateurs,this.selectedIndex,nb_enreg);">>
<?php
            for ($i=0;$i<$nb_enreg;$i++)
            {
               $tab=db_fetch_array($result, $i);

       $res3=db_query("select * from unix where coduser=?", array($tab['coduser']));
       $nbre3=db_num_rows($res3);
          
?>
	       <script language="javascript">
                 utilisateurs[<?php echo $i ?>] = new users(<?php echo $param ?>);
               </script>
<?php
               echo "<option value='".h($tab['coduser'])."'";
               if ($_GET['US']==$tab['coduser']) echo " selected  ";
               echo ">".h($tab['matricul'])."--".h($tab['name'])." ".h($tab['firstname'])."</option>";
            }
?>
            </select>
          </td>
        </tr>
        <tr>
        </table>
      </td>
    </tr>
<?php
  if (isset($_GET['US']))
  {
    $result2=db_query("select * from users where coduser=?", array($_GET['US']));
    $tab2=db_fetch_array($result2,0);
  }
?>
    <tr>
      <td colspan=2 align=center>
        <table class=form>
        <tr>
          <td colspan=4 class=header align=center>
            Dados da Conta :
          </td>
        </tr>
        <tr>
          <td> Cota Impress&atilde;o : </td><td><input type=text name='impressao' maxlength=60 ></td>
          <td>Tamanho da Conta :</td><td><input type=text name='conta' maxlength=60 ></td>
       <tr><td>Tamanho do email :</td><td><input type=text name='correio' maxlength=100></td>
	  <td>Cota de C&oacute;pia</td><td><input type=text name='copia' maxlength=60  ></td>
          </td></tr></table></td></tr>
     <tr><td align=center>
         <table class=form>
          <tr>
            <td class=header align=center colspan=3>Tipo de Conta</td>
          </tr>
          <tr>
            <td>Unix :</td>
            <td><input type=checkbox name=unix disabled ></td>
          </tr> 
            <td> 
              <input type=button name="si_modif" value="Modificar" onclick="window.open('modif_si.php?cu='+ utilisateurs[i].coduser,'pop1','width=510,height=560');">
              <input type=button name="si_add" value="Adicionar" onclick="window.open('add_si.php?cu='+ utilisateurs[i].coduser +'&&un=' +  utilisateurs[i].unix  + '&&sa='+  utilisateurs[i].samba,'pop1','width=510,height=560');">
            </td>
          </tr>
          </table>
       </td>
     </tr>
     <tr>
       <td align=center>
         <input type=submit value=Modificar>
         <input type=button value=Mail>
         <input type=button value=Login/Pass>
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
  $idconn = null;
?>
