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

   //If we don't are identified, we will transfert on the identification's page
   if (!$identification)
   {
?>
     <script language="javascript">
       document.location.href="../index.php"
     </script>
<?php
   }
?>
<html>
  <head>
    <script language="JavaScript" src="menu2.js">
    </script>
    <link type="text/css" rel="stylesheet" href="grafic.css">
  </head>
  <body>
    <table class=big>
    <tr>
      <td class=header>
        <h1 align=center>Menu</h1>
      </td>
    </tr>
    <tr valign=top>
      <td>
        <a href="accueil.php" target="right" class=menu><B>P&aacute;gina principal</B></a>
        <br>
        <script type="text/JavaScript">
          Aff(parent.menu);
        </script>
      </td>
    </tr>
    </table> 
  </body>
</html>
<?php
  pg_close($idconn);
?>
