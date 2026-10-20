<?php
  require("head_conta_SI.php");
?>

<html>
  <header>
    <link type="text/css" rel="stylesheet" href="../../global/grafic.css">
    <script language="JavaScript" src="navig_js.js"></script>
    <script language=javascript src="formu.js"></script>
    <script language="javascript">
      var utilisateurs = new Array();
      var i = 0;
    </script>
    <script language=javascript src="formu.js">
    </script>
  </header>  
<base target="coluna2">
<body >
  <table class=big>
  <form method="POST" name="utilisateur" action="coluna2.php"> 
    <tr><td><table align=center class=form><tr>
          <td class=header align=center colspan=2>Selecione um usu&aacute;rio: </td></tr>
        <tr><td>
<?php
     $query="select ad.login, u.* from users u, admin ad where u.coduser=ad.coduser and ad.login<>'root' order by u.name"; $query__p = array();
     $result=db_query($query, $query__p);
     $nb_enreg=db_num_rows($result);
     $i=0;
?>
            <select name='user' onchange="enregistrement_modif(utilisateurs,this.selectedIndex,nb_enreg);">>
<?php
            for ($i=0;$i<$nb_enreg;$i++)
            {
               $tab=db_fetch_array($result, $i);

               $param="'".$tab['login']."'"; // ,'".$tab3."'".$nb_perm."'"; //tab['firstname']."','".$tab['matricul']."'";
              $param=str_replace(CHR(10)," ",$param);
             $param=str_replace(CHR(13)," ",$param);
?>
	       <script language="javascript">
                 utilisateurs[<?php echo $i ?>] = new modif_conta(<?php echo $param ?>);
               </script>
<?php

               echo "<option value='".$tab['coduser']."'";
               if ($_GET['US']==$tab['coduser']) echo " selected  ";
               echo ">".$tab['name']." ".$tab['firstname']."</option>";
        	}
?>
            </select>
       </table>
	<input type=hidden name='login'>
       </td>
     </tr>
     <tr>
       <td align=center>
         <input type=submit value=Selecionar>
       </td>
     </tr>
  </form>
  <script language="javascript">
    var nb_enreg = <?php echo $nb_enreg-1 ?>;
    enregistrement_modif(utilisateurs,i,nb_enreg);
  </script>
     <table>
    </body>
</html>
<?php
  db_close($idconn);
?>
