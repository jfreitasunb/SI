<?php
   session_start(); 

   include("function_php.php");
 
   //connection to the database
   $idconn=db_connect();

   //check to the identification 
   if (isset($_POST['login']) and isset($_POST['pass']))  
       $identification = secure($_POST['login'],$_POST['pass'], $idmodule);
   else
       $identification = secure($_SESSION['login'],$_SESSION['passwd'], $idmodule); 
   
   if (!$identification)
   {
?>
     <script language="javascript">
       document.location.href="../../global/accueil.php"
     </script>
<?php
   }
?>
