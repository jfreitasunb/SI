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
<body >
  <table class=big>
  <form method="POST" name="utilisateur" action="modif_si.php"> 
    <tr><td><table align=center class=form><tr>
          <td class=header align=center colspan=2></td></tr>
        <tr>
	<td><b>Retirar o usu&aacute;rio:</b><td><select name='retira'><option value="nao" selected> N&atilde;o </option>
							     <option value="sim"> Sim </option>
								</select></td>
        </tr>
        <?php
	       $usuario=$_POST['login'];
               $query3="select m.name, p.permission from permission p, module m where p.idmodule=m.idmodule and p.login='".$usuario."' order by 
m.idmodule";
               $result3=pg_query($query3);
               $nb_perm=pg_num_rows($result3);
//               $tab3=pg_fetch_all($result3);

/*             $query2="select idmodule,name from module order by idmodule";
             $result2=pg_query($query2);
             $count2=pg_num_rows($result2);
*/
            for ($y=0;$y<$nb_perm;$y++)
            {
//		$tab2=pg_fetch_array($result2,$y);
		$tab3=pg_fetch_array($result3,$y);
        ?>
        <tr>
          <td>
            <b><?php echo mb_convert_encoding($tab3['name'],"ISO-8859-1","UTF-8") ?></b>
          </td>
          <td align=right>
		<select name="droits[]">
                 <option value=0 <?php if ($tab3['permission']==0) echo "selected"; ?>>no rights</option>
                 <option value=1 <?php if ($tab3['permission']==1) echo "selected"; ?>>readonly</option>
                 <option value=2 <?php if ($tab3['permission']==2) echo "selected"; ?>>read and write</option>
            </select>
          </td>
        </tr>
        <?php
            }     
	?>
        </table>
	<input type=hidden name='login' value="<?php echo $usuario ?>">
       </td>
     </tr>
     <tr>
       <td align=center>
         <input type=submit value=Modificar>
       </td>
     </tr>
  </form>
     </table>
    </body>
</html>
<?php
  pg_close($idconn);
?>
