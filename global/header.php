<?php
   session_start(); 
   include("function_php.php");
 
   $idconn = db_connect();
   $idmodule = isset($idmodule) ? $idmodule : null;

   if (isset($_POST['login']) && isset($_POST['pass'])) {
       $identification = secure($_POST['login'], $_POST['pass'], $idmodule);
   } else {
       $sess_login = isset($_SESSION['login']) ? $_SESSION['login'] : '';
       $sess_passwd = isset($_SESSION['passwd']) ? $_SESSION['passwd'] : '';
       $identification = secure($sess_login, $sess_passwd, $idmodule); 
   }
   
   if (!$identification)
   {
?>
     <script language="javascript">
       document.location.href="../../global/accueil.php"
     </script>
<?php
       exit;
   }
?>