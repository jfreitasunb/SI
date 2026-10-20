<?php
  require("head_conta_SI.php");

 if($_POST['retira']=="sim")
	{
	$query0="select u.name, u.firstname from users u, admin ad where ad.coduser=u.coduser and ad.login=?"; $query0__p = array($_POST['login']);
 	$res0=db_query($query0, $query0__p);
	$nome=db_fetch_array($res0);
	$query1="delete from permission where login=?"; $query1__p = array($_POST['login']);
	$res1=db_query($query1, $query1__p);
	$query1="delete from admin where login=?"; $query1__p = array($_POST['login']);
	$res1=db_query($query1, $query1__p);
	?>
	<html>
	  <header>
	    <link type="text/css" rel="stylesheet" href="../../global/grafic.css">
	  </header>
	  <body> 
	    <table class=big>
	    <tr>
	     <td align=center>
	       <table class=form>
	       <tr>
		    <td class=header align=center>
		        O usu&aacute;rio <?php echo $nome['name'] ?>  <?php echo $nome['firstname'] ?> n&atilde;o tem mais permiss&atilde;o de acesso ao SI.
		   </td>
	      </tr> 
	   </tr>  
	  </table>    
	</table>  
	</body>
	</html>
	<?php
	}
 else
	{
	     $query="select idmodule,name from module order by idmodule"; $query__p = array();
	     $result=db_query($query, $query__p);
	     $count=db_num_rows($result);
	     $i=0;
	     foreach($_POST['droits']as $arr)
	     {
	       $tab=db_fetch_array($result,$i);
	       $query3="update permission set permission=? where login=? and idmodule=?"; $query3__p = array($arr, $_POST['login'], $tab['idmodule']);
	       $result3=db_query($query3, $query3__p);
	       $i+=1;
	      } 
	?>
	<html>
	  <header>
	    <link type="text/css" rel="stylesheet" href="../../global/grafic.css">
	  </header>
	  <body> 
	    <table class=big>
	    <tr>
	     <td align=center>
	       <table class=form>
	       <tr>
		    <td class=header align=center>
		        Dados modificados com sucesso
		   </td>
	      </tr> 
	   </tr>  
	  </table>    
	</table>  
	</body>
	</html>
<?php
	}
  db_close($idconn);
?>
