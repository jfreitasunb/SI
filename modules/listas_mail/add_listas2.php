<?php
  require("head_listas.php");


if ($_POST['licenca']=="palestra") $id_licence=0;
if ($_POST['licenca']=="colab_cientifica")  $id_licence=1;
if ($_POST['licenca']=="congresso") $id_licence=2;
if ($_POST['licenca']=="banca_esp") $id_licence=3;
if ($_POST['licenca']=="banca_m")  $id_licence=4;
if ($_POST['licenca']=="banca_d") $id_licence=5;
if ($_POST['licenca']=="banca_ass") $id_licence=6;
if ($_POST['licenca']=="banca_ad") $id_licence=7;
if ($_POST['licenca']=="banca_tit") $id_licence=8;


//$id_licence=$_POST['licenca'];
$date_debut=$_POST['ano_ida']."-".$_POST['mes_ida']."-".$_POST['dia_ida'];
$date_fin=$_POST['ano_volta']."-".$_POST['mes_volta']."-".$_POST['dia_volta'];
$destino=mb_convert_encoding( $_POST['instituicao'],"UTF-8")."/$/".mb_convert_encoding( $_POST['cidade'],"UTF-8")."/$/".mb_convert_encoding( $_POST['estado'],"UTF-8");
$coduser=$_POST['coduser'];
$titulo=mb_convert_encoding($_POST['titulo'],"UTF-8")."/$/".mb_convert_encoding($_POST['autor'],"UTF-8");

	$query_user="select coduser from users where matricul=?"; $query_user__p = array($_POST['matricul']);
	$res_user=db_query($query_user, $query_user__p);
	$coduser=db_fetch_array($res_user);

     $query="insert into licences values(?,?,?,?,?,?)"; $query__p = array($id_licence, $date_debut, $date_fin, $destino, $coduser[0], $titulo);
     $result=db_query($query, $query__p);


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
  db_close($idconn);
?>
