<?php
   session_start();
   //if sessions'variables already exists, the client doesn't have to him identify
   if(!isset($_SESSION['tentatives']))
     $_SESSION['tentatives']=0;

/*
   if (isset($_SESSION['login']) and isset($_SESSION['passwd']))
   {
?>
     <script language="javascript">
       document.location.href="global/index.php";
     </script>
<?php
    }*/
    
?>

<html>
<meta charset="UTF-8">
  <head>
    <link type="text/css" rel="stylesheet" href="./global/grafic.css">
    <script language="javascript">
    <!--
      if (top.frames.length!=0)
      top.location=self.document.location;
     //-->
    </script>
<?php
  if (isset($_SESSION['login']) and isset($_SESSION['passwd']))
   {
?>
     <script language="javascript">
       document.location.href="global/index.php";
     </script>
<?php
    }
?>
  </head>
  <body>
    <table class=big>
    <tr valign=middle>
      <td>  
        <table align="center" class=form>
        <tr>
          <td colspan=2 align="center" class=header>
            <?php if(isset($_GET['error']))
                    echo "A identifica&ccedil;&atilde;o falhou.<br> Tente novamente."; 
                  else
                    echo "Identifique-se, por favor :";
            ?>
          </td>
        </tr>
        <form method="post" name="identification" action="global/index.php">
        <tr align="left">
          <td>
            Login : 
          </td>
          <td>
            <input type="text" name="login">
          </td>
        </tr>
        <tr align="left">
          <td>
            Senha : 
          </td>
          <td>
            <input type="password" name="pass">
          </td>
        </tr>
        <tr align="center">
          <td colspan=2>
            <input type="submit" name="valider" value="Confirmar">
          </td>
        </tr>
        </table>
      </td>
    </tr>
    </table>
  </body>
<html>