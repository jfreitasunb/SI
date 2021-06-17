<?php
  include("head_account.php");

  $query="select idmodule,name from module order by name";
  $result=pg_query($query);
  $count=pg_num_rows($result);
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
       $tab=pg_fetch_array($result,$i);
       $query3="update permission set permission=".$arr." where login='".$account->get_login()."' and idmodule=".$tab['idmodule'];
       $result3=pg_query($query3);
       $i+=1;
      } 
  }
  if($_GET['un']!=0)
  {
    $req1="select login from unix where coduser=".$_GET['cu'];
    $res1=pg_query($req1);
    $blo1=pg_fetch_array($res1,0);
    $loginsi=$blo1['login'];
    pg_free_result($res1);    
  }
  else
  {
     if($_GET['sa']!=0)
     {
         $req2="select login from samba where coduser=".$_GET['cu'];
         $res2=pg_query($req2);
         $blo2=pg_fetch_array($res2,0);
         $loginsi=$blo2['login'];
         pg_free_result($res2);   
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
     echo "<td colspan=4>Uma conta Samba ou Unix ja existe para este usu&aacute;rio.<br>
           O mesmo login sera conservado:<b>$loginsi</b>.</td>";
  }
  else
  {
     echo "<td>Digite seu login :</td><td><input type=text name=login></td>";
  }
?>
        </tr>
        <tr>
          <td>Digite a senha :</td>
          <td><input type=password name=pass1></td>
          <td>Confirma :</td>
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
            Permiss&otilde;es para as contas do sistema de informa&ccedil;&otilde;es :
          </td>
        </tr>
<?php
  for ($y=0;$y<$count;$y++)
  {
    $tab=pg_fetch_array($result,$y);
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
  pg_close($idconn);
?>
