<?php
  include("head_account.php");
   $query="select * from users where matricul='".$_POST['matricul']."' or identity= '".$_POST['identity']."' or cpf='".$_POST['cpf']."'";
   $result=pg_query($query);
   $count=pg_num_rows($result);
?>
<html>
   <header>
    <script language=javascript src="formu.js">
    </script>
    <script language=javascript>
      function verif_pass()
{
            if (document.utilisateur.pass1.value!= document.utilisateur.pass2.value)
            {
                alert('les 2 mots de passe ne correspondent pas!');
                document.utilisateur.pass1.focus();
                return false;
            }
            if (document.utilisateur.login.value.length==0)
            {
                alert("Vous devez saisir un login !");
                document.forms['utilisateur'].login.focus();
                return false;
            } 
            if ((document.utilisateur.pass1.value.length==0)||(document.utilisateur.pass2.value.length==0))
            {
                alert("Vous devez saisir un mot de passe et le confirmer!");
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
        <h1>Creation de compte Utilisateur</h1><br>Renseignements sur le compte
      </td>
    </tr>   
<?php   
   if ($count!=0)
   {
?>
    <tr>
      <td align=center>
        <table class=form>
        <tr>
          <td class=header align=center>Erreur :</td> 
        </tr>
        <tr>
          <td>As informa&ccedil;&otilde;es que voc&ecirc; forneceu j&aacute; existem na<br>
	      base de dados (cpf, identidade, matr&iacute;cula). Este erro pode <br>
	      ser devido a uma falha de digita&ccedil;&atilde;o ou pelo fato de voc&ecirc; <br>
              j&aacute; possuir uma conta. <br>
	      Se j&aacute; possuir uma conta, favor utilisar
	      <a href='modif_user.php'>o menu apropriado</a>,<br>
              no caso contr&aacute;rio, favor tentar novamente.
          </td>
        </tr>
        </table>  
      </td>
    </tr>  
<?php 
   }
   else
   {
     $compte=new c_user;
     $compte->set_name       ($_POST['name']       ) ;
     $compte->set_firstname  ($_POST['firstname']  ) ;
     $compte->set_matricul   ($_POST['matricul']   ) ;
     $compte->set_cpf        ($_POST['cpf']        ) ;
     $compte->set_identity   ($_POST['identity']   ) ;
     $compte->set_phone_home ($_POST['phone_home'] ) ;
     $compte->set_phone_work ($_POST['phone_work']   ) ;
     $compte->set_adresse    ($_POST['adresse']    ) ;
     $compte->set_cp         ($_POST['cp']         ) ;
     $compte->set_city       ($_POST['city']       ) ;
     $compte->set_coduser($compte->add_user ());
     $query="insert into mail values('".$_POST['mail1']."',". $compte->get_coduser().")";
     $result=pg_query($query);
     pg_free_result($result);
  
     if (!empty($_POST['mail2']))
     {
       $query="insert into mail values('".$_POST['mail2']."',". $compte->get_coduser().")";
       $result=pg_query($query);
       pg_free_result($result);
       if (!empty($_POST['mail3']))
       {
         $query="insert into mail values('".$_POST['mail3']."',". $compte->get_coduser().")";
         $result=pg_query($query);
         pg_free_result($result);
         if (!empty($_POST['mail4']))
         {
           $query="insert into mail values('".$_POST['mail4']."',". $compte->get_coduser().")";
           $result=pg_query($query);
           pg_free_result($result);
         }
       }
     }   
?>
    <tr>
      <td align=center>
        Please, choose a <b>Login</b>:
        <input type=text name=login maxlength=8 onkeypress="return verif_log(event);">
      </td>
    </tr>
     <tr>
      <td align=center>
        a <b>Password</b>:
        <input type=password name=pass1 maxlength=8>
        and <b>comfirm</b> it:
        <input type=password name=pass2 maxlength=8>
      </td>
    </tr> 
<?php
    if (isset($_POST['unix']))
    {
?>
    <input type=hidden value='un_prec' name='un_prec'>
    <tr>  
      <td align=center>
        <table class=form>
        <tr>
          <td class=header colspan=4>
            Compte UNIX :
          </td>
        </tr> 
        <tr>
          <td colspan=2>Quel type de shell souhaitez vous utiliser :</td>
          <td colspan=2><input type=text name='shell'></td>
        </tr>
         <tr>
          <td colspan=2>Classe de login : </td>
          <td colspan=2><input type=text name='class'></td>
        </tr>
         <tr>
          <td colspan=2>Gecos : </td>
          <td colspan=2><input type=text name='gecos'></td>
        </tr>
         <tr>
          <td colspan=2>Classe de login : </td>
          <td colspan=2><input type=text name='homedir'></td>
        </tr>
         <tr>
          <td>uid :</td>
          <td><input type=text name='uid'></td>
          <td>gid :</td>
          <td><input type=text name='gid'></td>
        </tr> 
        </table> 
      </td>
    </tr>
<?php
    }
    if (isset($_POST['samba']))
    {
?>
    <input type=hidden value='sa_prec' name='sa_prec'>
    <tr>
      <td align=center>
        <table class=form>
        <tr>
          <td class=header align=center colspan=2>
            Compte SAMBA :
          </td>
        </tr>
        <tr>
          <td>
            Date d'expiration du compte : 
          </td> 
          <td>
            <input type=text name=date> 
          </td>
        </tr>
        </table>
      </td>
    </tr>
<?php
    }
    if (isset($_POST['si']))
    {
?>
    <input type=hidden value='si_prec' name='si_prec'>
    <tr>
      <td align=center>
        <table class=form>
        <tr>
          <td class=header align=center colspan=2>
            Droits pour le compte Systeme d'Information : 
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
        <tr>
          <td>
            
          </td>
          <td>

          </td> 
        </tr> 

        </table>
      </td>
    </tr>
<?php
    }  
?>
    <tr>
      <td align=center>
        <input type=submit value='Record'>
      </td>
    </tr> 
    <input type=hidden name=coduser value="<?php echo $compte->get_coduser() ?>"> 
  </form>
  </table>
  </body>
</html>
<?php
  }
  pg_close($idconn);
?>
