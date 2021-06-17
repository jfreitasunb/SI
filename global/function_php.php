<?php
error_reporting(E_ALL ^E_WARNING ^E_NOTICE);
///////////////////////////////////////
////////////  DB_CONNECT  /////////////
///////////////////////////////////////

// The db_connect function allows to connect to the database, an id_connection is returned.

  function db_connect()
  {
    $host="127.0.0.1";
    $port="5432";
    $dbname="si";
    $user="si";
    $passwd="estudos";
    $str_connection="host=".$host." port=".$port." dbname=".$dbname." user=".$user." password=".$passwd;
    $idconn=pg_connect($str_connection) or die (error("The server ".$host." seems to be have many problem. Please try again in a few time."));
    // pg_set_client_encoding($idconn, 'UTF-8');
    return $idconn;
  }


///////////////////////////////////////
////////////     ERROR    /////////////
///////////////////////////////////////
 
// The error function allows to show an error_page instead of an error_message to the php_server

  function error($error="")
  {
    if (empty($error))
      $error="This maybe come to the server. Please try again in a few minutes and contact an administrator if the probleme go on.";
?>
<html>
  <body>
    <table width=100%  height=100%  bgcolor="#aaaaaa">
    <tr valign=bottom height=50%>
      <td align=center>
        <h1><b>An error has occured.</b></h1>
      </td>
    </tr>
    <tr valign=top>
      <td align=center>
        <?php echo $error; ?>
      </td>
    </tr>
    </table>
  </body>
</html>
<?php
  }


///////////////////////////////////////
////////// VERIF_SESSION_IP ///////////
///////////////////////////////////////

// The verif_session_ip verify if the session is avaibale.
// She returns true if is it, else false.

  function verif_session_ip()
  {
    //the IP adress and the session`s identify to the client are got
    $ip = $_SERVER['REMOTE_ADDR'];
    $id = session_id();     
    //we verify then that the IP and the session`s ID are in relation
    $query = "select * from ident where ip='".$ip."' and session='".$id."';";
    $verif = pg_query($query) or die (error());
    //if IP adress and session`s ID are in relation, the client is identified
    //else we must destroy the session`s cookie which have been been falsified, identification is canceled    
    if (pg_num_rows($verif))
    {
       pg_free_result($verif);
       return true;
    }
    else
    {
       pg_free_result($verif);
       return false;
    }
  }


///////////////////////////////////////
////////// VERIF_PASS_LOGIN ///////////
///////////////////////////////////////

//The verif_pass_login function must verify login and password
//She returns true if is it, else false.

  function verif_pass_login($login, $pass)
  {
    $query = "select * from admin where login='".addslashes($login)."' and passwd='".md5($pass)."'";
    $result = pg_query ($query) or die(error());
    if (pg_num_rows($result))
    {
      pg_free_result($result);
      return true;
    }
    else
    {
      pg_free_result($result);
      return false;
    }
  }


///////////////////////////////////////
////////// CLEAR_SESSION_IP ///////////
///////////////////////////////////////

// The sessions` relation ID-IP must be delete to the database after 15 minutes.

  function clear_session_ip()
  {
     $date = date("Y-m-d");
     $time = date("H:i:s");
     list($h,$m,$s) = explode(":",$time);
     if ($m > 15)
     {
      	$m=$m-15;
       	$time = $h.":".$m.":".$s;
        $query = "delete from ident where date ='".$date."' and time <='".$time."';";
        $query2= "delete from ident where date <'".$date."'";
        $result = pg_query($query) or die(error());
        $result2 = pg_query($query2) or die(error());    
     }
   }


///////////////////////////////////////
/////////  RECORD_SESSION_IP  /////////
///////////////////////////////////////
  
//we record IP and session`s ID the in the data base
 
   function record_session_ip() 
   {
       $ip = $_SERVER['REMOTE_ADDR'];
       $session = session_id();
       $fai = gethostbyaddr($_SERVER['REMOTE_ADDR']);
       $query = "insert into ident (session,ip,date,time,fai) values ('".$session."','".$ip."','".date("Y-m-d")."','".date("H:i:s")."','".$fai."');";
       $result = pg_query($query) or die(error());
   }


///////////////////////////////////////
//////////      SECURE       //////////
///////////////////////////////////////
  
//The secure function allows to identify the client and returns true if the identification is ok or false
// This function build all the session's variables.

  function secure($login, $pass, $idmodule)
  {     
     //if there are more than 8 connections the access is closed
     if ($_SESSION['tentatives']>8) 
       return false;
     // if the session`s variables exist,we verifie that the IP of the customer corresponds to his session`s identifier
     // if there is not correspondence,  the session will be destroyed so that it can relog him
     if (isset($_SESSION['login']) and isset($_SESSION['passwd']) and !verif_session_ip()) 
     {
        clear_session_ip();
        session_destroy();
        return false;
     }
     //we test login and passwd and put them in the sessions` variables
     if (verif_pass_login($login,$pass))
     {
       $_SESSION['login'] = $login;
       $_SESSION['passwd'] = $pass;
       record_session_ip();
       clear_session_ip();
       $_SESSION['tentatives']=0;
       return verif_permission($idmodule);
     }
     else
     {
       clear_session_ip();
       //if session`s variables exist the session must be destroy in order the client can this log again
       if(isset($_SESSION['login']) and isset($_SESSION['passwd']))
       {
          session_destroy();
       }
       //the number to tentative of connection becomes +1
       else
       {
         $_SESSION['tentatives']=$_SESSION['tentatives']+1;
       }
       return false;
     }
   }

///////////////////////////////////////
////      VERIF_PERMISSION       //////
///////////////////////////////////////

   // This function take in paramater a module's id and return true if the user can access to this modules.
   // The session's variable is built if the user has the permission...
  
   function verif_permission($idmodule)
   {
     if (isset($idmodule))
     {
       $query  = "select permission from permission where login='".$_SESSION['login']."' and idmodule=".$idmodule;
       $result = pg_query($query) or die (error());
       $array=pg_fetch_array($result); 
       if ($array["permission"]==0) 
         return false;
       else
         $_SESSION['permission']=$array["permission"]; 
     }
     return true;
   }
?>
