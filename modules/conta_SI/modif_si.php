<?php
  require("head_conta_SI.php");

 if($_POST['retira']=="sim")
	{
	$query0="select u.name, u.firstname from users u, admin ad where ad.coduser=u.coduser and ad.login='".$_POST['login']."'";
 	$res0=pg_query($query0);
	$nome=pg_fetch_array($res0);
	$query1="delete from permission where login='".$_POST['login']."'";
	$res1=pg_query($query1);
	$query1="delete from admin where login='".$_POST['login']."'";
	$res1=pg_query($query1);
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
	     $query="select idmodule,name from module order by idmodule";
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
  pg_close($idconn);
?>
