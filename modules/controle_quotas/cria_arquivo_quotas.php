<?php
  include("head_quotas.php");

$usuario=$_POST['login'];
$nome=$_POST['nome'];
//$copias=$_POST['copias'];



//$file_base = 'impressao.txt';
//$file = 'quotas_impressao.txt';

//$linha=$usuario." ".$copias. "\n";

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
<body >
  <table class=big>
 <tr><td>
  <table class=form align=center> </td></tr>
  <form method="POST" name="utilisateur" action="cria_arquivo_quotas.php">
	<tr><td class=header align=center>
<?php
if (isset($_POST['confirma']))
	{
		$quota_corrigida=$_POST['quota_atual']-$_POST['copias'];
//		$linha=$usuario." ".$_POST['quota_atual']."  ".$_POST['copias']."  ".$quota_corrigida. "\n";
                $conn_pykota=connect_pykota();
                $grava_pykota_query="update users set balance='".$quota_corrigida."' where username='".$usuario."'";
                $res_grava_quotas=pg_query($grava_pykota_query) or die("conexao com banco impossivel!");
                $quotas=pg_fetch_array($res_grava_quotas);

		?>
	        C&oacute;pias contabilizadas</td></tr>
		<?php
	
pg_close($conn_pykota);
}
else
{
		$conn_pykota=connect_pykota();		
		$pykota_query="select balance from users where username='".$usuario."'";
		$res_quotas=pg_query($pykota_query) or die("conexao com banco impossivel!");
		$quotas=pg_fetch_array($res_quotas);
		?>
               <br>
                <tr><td><table align=center class=form><tr>
		<td><h1>Usu&aacute;rio: <?php echo $nome; ?> </h1> </td></tr>
		<tr><td> <h1> Quota do usu&aacute;rio <?php echo $usuario; ?>:</h1> </td><td> <h1><?php echo $quotas[0]; ?></h1></td></tr>
		<tr> <td><h1>Quantidade de c&oacute;pias a ser contabilizada:</h1> </td>
                        <td><input type=text name='copias' size="3" maxlength="3"></td></tr>
                <input type=hidden name='quota_atual' value="<?php echo $quotas[0] ?>">
                <input type=hidden name='login' value="<?php echo $usuario ?>">
                </table>
                <br>
             <tr>
               <td align=center>
                 <input type=submit name='confirma' value=Confirmar>
               </td>
             </tr>
          </form>
		

		<?php
pg_close($conn_pykota);
}
?> 
</table>
</table>
</body>
</html>
