<?php
   require_once(dirname(__FILE__).'/sessao_cookie.php');
   session_start();
   include("function_php.php");

   $idconn = db_connect();
   $idmodule = isset($idmodule) ? $idmodule : null;

   if (isset($_POST['login']) && isset($_POST['pass'])) {
       $identification = secure($_POST['login'], $_POST['pass'], $idmodule);
   } else {
       // Sessao existente: autenticacao validada pela flag de sessao + vinculo de IP.
       $identification = secure('', '', $idmodule);
   }

   if (!$identification)
   {
?>
     <script language="javascript">
       document.location.href="../index.php"
     </script>
<?php
       exit; // Previne vazamento de informações da tela
   }
?>
<html>
  <head>
    <script language="JavaScript" src="menu2.js"></script>
    <link type="text/css" rel="stylesheet" href="grafic.css">
  </head>
  <body>
    <table class="big">
    <tr>
      <td class="header">
        <h1 align="center">Menu</h1>
      </td>
    </tr>
    <tr valign="top">
      <td>
        <a href="accueil.php" target="right" class="menu"><B>P&aacute;gina principal</B></a>
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
  // Fechando conexão PDO
  $idconn = null;
?>