<?php
   session_start();
   include("function_php.php");

   //connection to the database
   $idconn=db_connect();

   //check to the identification
   $identification = secure($_SESSION['login'],$_SESSION['passwd'], $idmodule);
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
    <link type="text/css" rel="stylesheet" href="grafic.css">    
  </head>
  <body>
    <table class=big>
    <tr>
      <td class=header align=center>
        <h1>P&aacute;gina principal:</h1>
      </td>
    </tr>
<?php
  $query="select m.name, m.descr from module m, permission p where m.idmodule=p.idmodule and p.login='".$_SESSION['login']."' and p.permission > 0";
  $result=pg_query($query)or die(error());
  $count=pg_numrows($result);
?>
    <tr>
      <td align=center valign=top><br>
<?php
      for ($i=0;$i<$count;$i++)
      {
        $tab=pg_fetch_array($result,$i);
?>
        <br>
        <table class=form align=center width=60%>
        <tr>
          <td class=header align=center>
            <b><?php echo mb_convert_encoding($tab['name'], "HTML-ENTITIES", "auto").' : ' ?></b>
          </td> 
        </tr>
        <tr>
          <td class=data>
            <?php echo mb_convert_encoding($tab['descr'], "HTML-ENTITIES", "auto"); ?>
          </td> 
        </tr>
        </table>
<?php
      }  
?> 
       </td>
    </tr>
    </table>
  </body> 
</html>
<?php
  pg_close($idconn);
?>  
