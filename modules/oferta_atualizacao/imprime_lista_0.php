<?PHP
require("head_oferta.php");

$ordena=$_POST['ordena'];

?>

<html>
  <header>
    <link type="text/css" rel="stylesheet" href="../../global/grafic.css">
<meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
  </header>
<?
// Escolhe semestre e ano:


$query_acusa_lista=db_query("select * from oferta_acusa_lista order by ano desc, semestre desc", array());
?>
  <body>
      <table class=big>
      <form method="POST" name="formu" action="imprime_lista.php">
         <tr>
        <td class=header align=center colspan=2>
        <h1> Lista de Ofertas do MAT </h1>
        </td>
      </tr>
      <tr><td>Escolha o semestre:
        <select name='lista'>
        <?
        while ($registro=db_fetch_row($query_acusa_lista))
        {
        ?>
        <option value="<?echo $registro[0]."_".$registro[1];?>"> <? echo $registro[0];?> &ordm;/ <? echo $registro[1];?></option>
	<?
        }
        ?>
	</select>
        </tr>
        <td align=center>
        <input type=submit name='registra' value="Confirmar op&ccedil;&otilde;es">
        </td>
        </tr>
        </table>
        </form>
        </BODY>
</html>
<?
db_close($idconn);
?>

