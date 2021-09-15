<?php
  include("head_quotas.php");
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
    <meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
  </header>  
<base target="linha2">
<body >
  <table class=big>
      <td class=header align=center colspan="2">
        <h1>Controle de c&oacute;pias</h1></td></tr>
	<form method="POST" name="utilisateur" action="cria_arquivo_quotas.php">
	<tr><td><table align=center class=form><tr>
          <td class=header align=center colspan=2>Selecione um usu&aacute;rio: </td></tr>
        <tr><td>
	<?php
	     $query="select ux.login, u.* from users u, unix ux where u.coduser=ux.coduser and ux.coduser<>'0' order by u.name";
	     $result=pg_query($query);
	     $nb_enreg=pg_num_rows($result);
	     $i=0;
	?>
	            <select name='user' onchange="enregistrement_modif(utilisateurs,this.selectedIndex,nb_enreg);">>
	<?php
	            for ($i=0;$i<$nb_enreg;$i++)
	            {
	               $tab=pg_fetch_array($result, $i);
			$nome=$tab['name']." ".$tab['firstname'];	
	               $param="'".$tab['login']."','".$nome."'"; //.$nb_perm."'"; //tab['firstname']."','".$tab['matricul']."'";
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
		<input type=hidden name='nome'>
	       <td align=center>
	         <input type=submit name='registra' value=Confirmar>
	       </td>
	     </tr>
	  </form>
	  <script language="javascript">
	    var nb_enreg = <?php echo $nb_enreg-1 ?>;
	    enregistrement_modif(utilisateurs,i,nb_enreg);
	  </script>
	     </table>
	    </body>
	</html>
<?php
pg_close($idconn);

?>
	

