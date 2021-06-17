<?php
  include("head_account.php");
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
        <h1>Modification des comptes utilisateurs</h1>
      </td>
    </tr>
    <tr>
      <td>
        <table align=center class=form>
        <tr>
          <td class=header align=center colspan=2>Choix :</td>
        </tr> 
        <tr>
          <td>Choisissez dans le menu ci contre, votre identifiant d'utilisateur</td>
          <td>
<?php
     $query="select * from users order by name";
     $result=pg_query($query);
     $nb_enreg=pg_num_rows($result);  
     $i=0;
?>
            <select name='user' onchange="enregistrement(utilisateurs,this.selectedIndex,nb_enreg);">>
<?php
            for ($i=0;$i<$nb_enreg;$i++)
            {
               $tab=pg_fetch_array($result, $i);

       $test1="select * from admin where coduser=".$tab['coduser'];
       $test2="select * from unix where coduser=".$tab['coduser'];
       $test3="select * from samba where coduser=".$tab['coduser'];
       $res1=pg_query($test1);
       $res2=pg_query($test2);
       $res3=pg_query($test3);
       $nbre1=pg_num_rows($res1);
       $nbre2=pg_num_rows($res2);
       $nbre3=pg_num_rows($res3); 
               $param="'".$tab['coduser']."','".$tab['name']."','".$tab['firstname']."','".$tab['matricul']."','".$tab['cpf']."','".$tab['identity']."','".$tab['phone_work']."','".$tab['phone_home']."','".$tab['adresse']."','".$tab['cp']."','".$tab['city']."',".$nbre1.",".$nbre2.",".$nbre3;
               $param=str_replace(CHR(10)," ",$param);
               $param=str_replace(CHR(13)," ",$param);
?>
	       <script language="javascript">
                 utilisateurs[<?php echo $i ?>] = new users(<?php echo $param ?>);
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
        <tr>
          <td align=center colspan=2>
             <input type="button" value="|<<" onclick="i=0;enregistrement(utilisateurs,i,nb_enreg);">
             <input type="button" value="<<" onclick="i=precedent(i);enregistrement(utilisateurs,i,nb_enreg);">
             <input type="button" name="noenreg">
             <input type="button" value=">>" onclick="i=suivant(i,nb_enreg);enregistrement(utilisateurs,i,nb_enreg);">
             <input type="button" value=">>|" onclick="i=nb_enreg;enregistrement(utilisateurs,i,nb_enreg);">
          </td>
        </tr>
        </table>
      </td>
    </tr> 
<?php
  if (isset($_GET['US']))
  { 
    $query2="select * from users where coduser=".$_GET['US'];
    $result2=pg_query($query2);
    $tab2=pg_fetch_array($result2,0);
  }
?>
    <tr>
      <td colspan=2 align=center>
        <table class=form>
        <tr>
          <td colspan=4 class=header align=center>
            Coordonnees Personnelles :
          </td>
        </tr>
        <tr>
          <td> Nom : </td>
          <td>
            <input type=text name='name' maxlength=60 onblur="this.value= prem_lettre_majuscule(this.value)">
          </td>
          <td>Prenom :</td>
          <td>
            <input type=text name='firstname' maxlength=60 onblur="this.value= prem_lettre_majuscule(this.value)" >
          </td>
        </tr>
        <tr>
           <td>Adresse :</td>
           <td colspan=3>
             <input type=text name='adresse' maxlength=100>
           </td>
         </tr>
         <tr>
           <td>Psotal Code :</td>
           <td>
             <input type=text name='cp' maxlength=10 onkeypress="return verif_touche(event);">
           </td>
           <td>Ville :</td>
           <td>
             <input type=text name='city' maxlength=20 onblur="this.value=prem_lettre_majuscule(this.value)">
           </td>
         </tr>
         <tr><td colspan=4><hr></td></tr>
         <tr>
           <td>Telephone au Domicile :</td>
           <td>
             <input type=text name='phone_home' maxlength=15 onkeypress="return verif_touche(event);">
           </td>
           <td>Telephone au Travail :</td>
           <td>
             <input type=text name='phone_work' maxlength=15 onkeypress="return verif_touche(event);">
           </td>
         </tr>
         <tr><td colspan=4><hr></td></tr>
         <tr>
            <td>Numero de matriculation :</td>
            <td>
              <input type=text name='matricul' maxlength=6  onkeypress="return verif_touche(event);" onBlur="if(this.value.length!=6){alert ('Campo doit avoir 6 caracteres.');this.focus();}">
            </td>
            <td>Numero de CPF :</td>
            <td>
              <input type=text name='cpf' maxlength=14 onkeypress="return verif_touche(event);" onkeyup="if(event.keyCode!=8 && event.keyCode!=13){this.value = saisie_cpf(this.value);}" onfocus="if(document.formu.matricul.value.length!=6){document.formu.matricul.focus();}">
            </td>
          </tr>
          <tr>
            <td>Numero d'identite:</td>
            <td>
              <input type=text name='identity' maxlength=15 onkeypress="return verif_touche(event);">
            </td>
          </tr>
         </table>
       </td>
     </tr>
     <tr>
       <td align=center>
         <table class=form>
          <tr>
            <td class=header align=center colspan=3>Comptes crees</td>
          </tr>
          <tr>
            <td>Unix :</td>
            <td><input type=checkbox name=unix disabled ></td>
          </tr>
          <tr>
            <td>Samba :</td>
            <td><input type=checkbox name=samba disabled ></td>
          </tr>
          <tr>
            <td>SI :</td>
            <td><input type=checkbox name=si disabled  ></td>
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
  pg_close($idconn);
?>
