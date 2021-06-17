<?php
  include("head_account.php");

  if ( isset($_POST['prec']) && $_POST['prec']=="si" )
  {                
     $query="select idmodule,name from module order by name";
     $result=pg_query($query);
     $count=pg_num_rows($result);
     $i=0;
     foreach($_POST['droits']as $arr)
     {
       $tab=pg_fetch_array($result,$i);
       $query3="update permission set permission=".$arr." where login='".$_POST['login']."' and idmodule=".$tab['idmodule'];
       $result3=pg_query($query3);
       $i+=1;
      } 
  }
?>
<html>
  <header>
    <link type="text/css" rel="stylesheet" href="../../global/grafic.css">
  </header>
  <body>
    <table class=big>
    <form method=POST action="modif_si.php?cu=<?php echo $_GET['cu'] ?>">
<?php
    $query4="select login from admin where coduser=".$_GET['cu'];
    $result4=pg_query($query4);
    $count4=pg_num_rows($result4);
    $tab4=pg_fetch_array($result4,0);
    echo "<input type='hidden' name='login' value='".$tab4['login']."'>"; 
?>
    <input type=hidden name=prec value=si>
    <tr> 
      <td class=header align=center>
        <h1>Modification du compte SI</h1>
      </td> 
    </tr>
    <tr>
      <td align=center>
        <table class=form>
        <tr>
          <td class=header align=center colspan=2>
            Droits pour le compte Systeme d'Information :
          </td>
        </tr>
        <?php
           if (!isset($_POST['prec']))
           {
              $query="select idmodule,name from module order by name";
              $result=pg_query($query);
              $count=pg_num_rows($result);
           }
            for ($y=0;$y<$count;$y++)
            {
               $tab=pg_fetch_array($result,$y);
               $query2="select permission from permission where idmodule=".$tab['idmodule']." and login='".$tab4['login']."'";
               $result2=pg_query($query2);
               $count2=pg_num_rows($result2);
               if ($count2!=0)
                 $tab2=pg_fetch_array($result2,0);
        ?>
        <tr>
          <td>
            <b><?php echo $tab['name'] ?></b>
          </td>
          <td align=right>
            <select name="droits[]">
<?php 
               if ( ( ($idmodule==$tab['idmodule'])&&($tab2['permission']==2)&&($tab4['login']==$_SESSION['login']) )||( ($idmodule==0)&&($_SESSION['login']=="root") ))
               {
                 ?><option value=2>read and write</option><?php
               }
               else
               {  
                 if ($_SESSION['permission']==1)
                 {
                   if ($tab2['permission']==0) echo "<option value=0 >no rights</option> ";
                   if ($tab2['permission']==1) echo "<option value=1 >no rights</option> ";
                   if ($tab2['permission']==2) echo "<option value=2 >no rights</option> "; 
                 }
                 else
                 { 
?>               
                 <option value=0 <?php if ($tab2['permission']==0) echo " selected " ?>>no rights</option>
                 <option value=1 <?php if ($tab2['permission']==1) echo " selected " ?>>readonly</option>
                 <option value=2 <?php if ($tab2['permission']==2) echo " selected " ?>>read and write</option>
<?php
               } }
?>            
            </select>
          </td>
        </tr>
        <?php
            }     
        ?>
        </table>
        <tr>
          <td align=center>
            <?php if ($_SESSION['permission']==2) { ?><input type=submit value="Modificiar"><?php } ?>
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
