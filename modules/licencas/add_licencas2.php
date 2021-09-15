<?php
  include("head_licencas.php");

/* alteracao do dia 06/06/2013
if ($_POST['licenca']=="palestra") $id_licence=0;
if ($_POST['licenca']=="colab_cientifica")  $id_licence=1;
if ($_POST['licenca']=="congresso") $id_licence=2;
if ($_POST['licenca']=="banca_esp") $id_licence=3;
if ($_POST['licenca']=="banca_m")  $id_licence=4;
if ($_POST['licenca']=="banca_d") $id_licence=5;
if ($_POST['licenca']=="banca_ass") $id_licence=6;
if ($_POST['licenca']=="banca_ad") $id_licence=7;
if ($_POST['licenca']=="banca_tit") $id_licence=8;
if ($_POST['licenca']=="pos_doc") $id_licence=9;
if ($_POST['licenca']=="coloquio") $id_licence=10;
if ($_POST['licenca']=="capacitacao") $id_licence=11;
*/

$id_licence=$_POST['licenca']; //alteracao do dia 06/06/2013
$date_debut=$_POST['ano_ida']."-".$_POST['mes_ida']."-".$_POST['dia_ida'];
$date_fin=$_POST['ano_volta']."-".$_POST['mes_volta']."-".$_POST['dia_volta'];
$destino=mb_convert_encoding( $_POST['instituicao'],"UTF-8")."/$/".mb_convert_encoding( $_POST['cidade'],"UTF-8")."/$/".mb_convert_encoding( $_POST['estado'],"UTF-8");
$coduser=$_POST['coduser'];
$titulo=mb_convert_encoding($_POST['titulo'],"UTF-8")."/$/".mb_convert_encoding($_POST['autor'],"UTF-8");

	$query_user="select coduser from users where matricul='".$_POST['matricul']."'";
	$res_user=pg_query($query_user);
	$coduser=pg_fetch_array($res_user);

     $query="insert into licences values('".$id_licence."','".$date_debut."','".$date_fin."','".$destino."','".$coduser[0]."','".$titulo."')";
     $result=pg_query($query);


?>
<html>
  <header>
    <link type="text/css" rel="stylesheet" href="../../global/grafic.css">
     </header>
  <body>
  <table class=big>
	<td align=center><table class=form><tr>
            <td colspan=4 class=header align=center>
              Os dados forma gravados com sucesso
            </td>
          </tr>	
	</table>
</table>
</body>
</html>
<?php
  pg_close($idconn);
?>
