<?php
  include("head_account.php");

  $queryverif1="select * from admin where login='".$_POST['login']."'";
  $queryverif2="select * from unix where login='".$_POST['login']."'";
  $queryverif3="select * from samba where login='".$_POST['login']."'";
  $resverif1=pg_query($queryverif1);
  $resverif2=pg_query($queryverif2);
  $resverif3=pg_query($queryverif3);
  $countverif1=pg_num_rows($resverif1);
  $countverif2=pg_num_rows($resverif2);
  $countverif3=pg_num_rows($resverif3);

  if ( ($countverif1==0)&&($countverif2==0)&&($countverif3==0) )
    $verifbool=true;
  else 
    $verifbool=false;

  if ( (!empty($_POST['sa_prec']))&& $verifbool)
  { /*
    $compte1= new c_samba;
    $compte1->set_login($_POST['login']);
    $compte1->set_passwd($_POST['pass1']);
    $compte1->set_expire($_POST['date']);
    $compte1->set_date(date("Y-m-d"));
    $compte1->set_coduser($_POST['coduser']); 
    $compte1->create_account();
   */
  }
  if ( (!empty($_POST['un_prec']))&& $verifbool)
  {
   /*
    $compte2= new c_unix;
    $compte2->set_login($_POST['login']);
    $compte2->set_passwd($_POST['pass1']);
$compte2->set_uid     ($_POST['uid']);
$compte2->set_gid     ($_POST['gid']); 
    $compte2->set_class   ($_POST['class']);
$compte2->set_change  ($_POST['change']);
$compte2->set_expire  ($_POST['expire']);
    $compte2->set_gecos   ($_POST['gecos']); 
    $compte2->set_homedir ($_POST['homedir']); 
    $compte2->set_shell   ($_POST['shell']);  
    $compte2->set_coduser ($_POST['coduser']);
    */
  }  
  if ( (!empty($_POST['si_prec']))&& $verifbool)  
  {
    $compte3= new c_admin;
    $compte3->set_login($_POST['login']);
    $compte3->set_passwd($_POST['pass1']);
    $compte3->set_coduser($_POST['coduser']);
    $compte3->create_account();
    
    $query4="select idmodule from module";
    $result4=pg_query($query4);
    $i=0;
    foreach($_POST['droits']as $arr)
    {
      $sl=pg_fetch_array($result4,$i);
      //$query3="insert into permission values('".$compte3->get_login()."',".$sl['idmodule'].",".$arr.")";
      $query3="update permission set permission=".$arr." where login='".$compte3->get_login()."' and idmodule=".$sl['idmodule'];
      $result3=pg_query($query3);
      $i+=1;
    }

  }
?>
<html>
  <header>
    <link type="text/css" rel="stylesheet" href="../../global/grafic.css">
  </header>
  <body> 
    <table class=big>
    <tr>
      <td class=header align=center>
        <h1>Creation du compte</h1>
      </td>
    </tr> 
    <tr>
     <td align=center>
       <table class=form>
       <tr>
<?php
       if ($verifbool)
         echo "<td class=header align=center>Le compte a ete cree: </td>";
       else
         echo "<td class=header align=center>Impossible de creer ce compte: </td>";  
?>
       </tr>  
       <tr>
         <td align=center>
<?php
       if ($verifbool)
         echo "Le compte a bien ete cree, vous pouvez desormais y acceder<br>et utiliser le systeme approprie.<br>Pour retourner a l'accueil <a href='../../global/accueil.php'>clicke ici</a>.";       
       else
          echo "Le compte systeme n'a pas pu etre cree. En effet un utilisateur<br>
                disposant deja d'un compte systeme utilise le login saisi par vous.<br>
                Cependant votre profil utilisateur a ete enregistre.<br>
                Vous pouvez desormais y acceder, le modifier et creer les comptes<br>
                systemes en passant par <a href='modif_user.php'>l'interface appropriee.</a>";
?>  
         </td>
       </tr>
       </table>
     </td>
    </tr> 
    </table>
  </body>
</html>
<?php
  pg_close($idconn);
?>
