<?php
  require("head_user.php");

  $query="select idmodule,name from module order by name";
  $result=db_query($query);
  $count=db_num_rows($result);
  if ( isset($_POST['prec']) && $_POST['prec']=="si" )
  {    
     $account= new c_admin;
     $account->set_login($_POST['login']);
     $account->set_passwd($_POST['pass1']);
     $account->set_coduser($_GET['cu']);
     $account->create_account();
     $i=0;
     foreach($_POST['droits']as $arr)
     {
       $tab=db_fetch_array($result,$i);
       $result3=db_query("update permission set permission=? where login=? and idmodule=?", array($arr, $account->get_login(), $tab['idmodule']));
       $i+=1;
      } 
  }
  if($_GET['un']!=0)
  {
    $res1=db_query("select login from unix where coduser=?", array($_GET['cu']));
    $blo1=db_fetch_array($res1,0);
    $loginsi=$blo1['login'];
    db_free_result($res1);    
  }
  else
  {
     if($_GET['sa']!=0)
     {
         $res2=db_query("select login from samba where coduser=?", array($_GET['cu']));
         $blo2=db_fetch_array($res2,0);
         $loginsi=$blo2['login'];
         db_free_result($res2);   
     }
     else
       $loginsi="";
  }
?>
<html>
  <header>
    <link type="text/css" rel="stylesheet" href="../../global/grafic.css">
  </header>
  <body>
    <table class=big>
    <form method=POST action="add_si.php?cu=<?php echo $_GET['cu'] ?>">
    <input type=hidden name=prec value=si>
    <tr> 
      <td class=header align=center>
        <h1>Creation d'un compte SI</h1>
      </td> 
    </tr>
    <tr>
      <td>
        <table class=form align=center>
        <tr>
          <td class=header align=center colspan=4>Renseignements du compte</td>
        </tr>
        <tr>
<?php
  if (!empty($loginsi))
  {
     echo "<td colspan=4>Un compte Unix ou Samba existe deja pour cet utilisateur.<br>Par defaut, le meme login sera conserve :<b>$loginsi</b>.<br>Il est d'ailleurs conseille de garder le meme mot de passe pour tous les comptes.</td>";
  }
  else
  {
     echo "<td>Saisie du login :</td><td><input type=text name=login></td>"; 
  }
?>
        </tr> 
        <tr>
          <td>Saisie de mot de pass :</td>
          <td><input type=password name=pass1></td>
          <td>Confirmation :</td>
          <td><input type=password name=pass2></td> 
        </tr>
        </table>  
      </td>
    </tr>
    <tr>
      <td align=center>
        <table class=form>
        <tr>
          <td class=header align=center colspan=2>
            Droits pour le compte Systeme d'Information :
          </td>
        </tr>
<?php
  for ($y=0;$y<$count;$y++)
  {
    $tab=db_fetch_array($result,$y);
?>
        <tr>
          <td>
            <b><?php echo $tab['name'] ?></b>
          </td>
          <td align=right>
            <select name="droits[]">
              <option value=0>no rights</option>
              <option value=1>readonly</option>
              <option value=2>read and write</option>
            </select>
          </td>
        </tr>
<?php
   }
?>
        </table>
      </td>
    </tr>
    <tr>
      <td align=center>
        <input type=submit value="Adicionar" onclick="opener.utilisateurs[opener.i].si=1;">
        <input type=button value="Fechar Janela" onclick="window.close();">
      </td>
    </tr> 
    </form>   
    </table>
  </body>
</html>
<?php
  $idconn = null;
?>
