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
  
  $query="select m.url,m.name,m.idmodule from module m, permission p where m.idmodule=p.idmodule and p.login='".$_SESSION['login']."' and p.permission > 0";
  $result=pg_query($query)or die(error());
  $count=pg_numrows($result);
?>
<html>
  <head>
    <script language="JavaScript" src="menu1.js">
    </script>
    <script language="JavaScript">
      var menu=new CreerMenu("dyn03.gif","dyn04.gif","dyn02.gif","dyn05.gif");
      
<?php 
    $i=0;
    while ($i<$count)
    {
             $array = pg_fetch_array($result, $i);
             $query2="select funcurl,funcname from functions f where f.idmodule=".$array["idmodule"] ;
             $result2=pg_query($query2)or die(error());
             $count2=pg_numrows($result2);
             echo "menu.AddRub(\"<B>".addslashes($array["name"])."</B>\",\"N\");";
             $j=0;
             while($j<$count2)
             {
                $array2 = pg_fetch_array($result2, $j);
                echo "menu.AddLien(\"".addslashes($array2["funcname"])."\",\"".addslashes($array2["funcurl"])."\");"; 
                $j+=1;
             }
             $i+=1;
    }
?>
    </script>
    <link type="text/css" rel="stylesheet" href="../../global/grafic.css">
  </head>
<?php
  if (isset($_GET['fra']))
  {
?>
    <script language="javascript">
      // document.location.href="./menu.php"
    </script>
    <frame name="left" src="menu.php" noresize> 
<?php
  }
  else
  {
?>
  <frameset cols="20%,80%" frameborder=no>
    <frame name="left" src="menu.php" noresize>
    <frame name="right" src="accueil.php" noresize>
  </frameset>
<?php
  }
?> 
</html>  
<?php
  pg_close($idconn);
?>