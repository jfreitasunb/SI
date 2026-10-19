<?php
  require("head_aliases.php");
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
      <td colspan=2 class=header align=center>
        <h1>Cria&ccedil;&atilde;o/Atualiza&ccedil;&atilde;o de Aliases para as contas de usu&aacute;rios</h1></td></tr>
	<form method="POST" name="utilisateur" action="cria_alias.php">
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
// 		       $nome=mb_convert_encoding($tab['name'],"ISO-8859-1","UTF-8");
//		       $sobrenome=mb_convert_encoding($tab['firstname'],"ISO-8859-1","UTF-8");
 		       $nome=$tab['name'];
		       $sobrenome=$tab['firstname'];
		       $param="'".$tab['login']."','".$nome." ".$sobrenome."'"; //.$nb_perm."'"; //tab['firstname']."','".$tab['matricul']."'";
	              $param=str_replace(CHR(10)," ",$param);
	             $param=str_replace(CHR(13)," ",$param);
	?>
		       <script language="javascript">
	                 utilisateurs[<?php echo $i ?>] = new modif_conta(<?php echo $param ?>);
	               </script>
	<?php
	
	               echo "<option value='".$tab['coduser']."-".$nome."-".$sobrenome."'";
	               if ($_GET['US']==$tab['coduser']) echo " selected  ";
	               echo ">".$nome." ".$sobrenome."</option>";
	        	}
	?>
	            </select>
	       </table>
		<input type=hidden name='login'>
		<input type=hidden name='nome'>
	       <td align=center>
	         <input type=submit name='registra' value=Confirmar>
	       </td>
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
	

