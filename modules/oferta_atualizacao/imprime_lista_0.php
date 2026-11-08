<?PHP
require("head_oferta.php");

$ordena=$_POST['ordena'];

?>

<html>
  <header>
    <link type="text/css" rel="stylesheet" href="../../global/grafic.css">
<meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
  </header>
<?php 
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
        <?php 
        while ($registro=db_fetch_row($query_acusa_lista))
        {
        ?>
        <option value="<?php echo h($registro[0])."_".h($registro[1]);?>"> <?php  echo h($registro[0]);?> &ordm;/ <?php  echo h($registro[1]);?></option>
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
db_close($idconn);
?>

