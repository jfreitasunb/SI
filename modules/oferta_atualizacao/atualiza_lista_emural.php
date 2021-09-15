<?php
include("head_oferta.php");

$ordena=$_POST['ordena'];

?>

<html>
  <header>
    <link type="text/css" rel="stylesheet" href="../../global/grafic.css">
<meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
  </header>
<?php
// Escolhe semestre e ano:

//$query_acusa_lista=pg_query("select * from oferta_acusa_lista order by ano desc, semestre desc");
$query_acusa_lista=pg_query("select * from oferta_acusa_lista where encaminhada<>'nova' order by ano desc, semestre desc");
?>
  <body>
      <table class=big>
      <form method="POST" name="formu" action="atualiza_lista_emural_2.php">
         <tr>
        <td class=header align=center colspan=2>
        <h1> Lista de Ofertas do MAT </h1>
        </td>
      </tr>
      <tr><td>Escolha o semestre:
        <select name='lista'>
        <?php
        while ($registro=pg_fetch_row($query_acusa_lista))
        {
        ?>
        <option value="<?php echo $registro[0]."_".$registro[1];?>"> <?php echo $registro[0];?> &ordm;/ <?php echo $registro[1];?></option>
	<?php
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
<?php
pg_close($idconn);
?>

