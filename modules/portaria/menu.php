<table align=center class=form>
        <tr>
          <td class=header align=center colspan=2>Menu :</td>
        </tr>
        <tr>
          <td>Selecione o livro :</td>
          <td>
	    <select size="1" name="titulo">
<?php
		// gera a lista de livros
		$res = pg_query("SELECT * FROM livros");
		while($registro = pg_fetch_row($res))
		{
   		$cod = $registro[0];
                $nome = $registro[1];
		echo "<option value=\"$cod\">$nome</option>\n";
		}
?>
</select>
          </td>
        </tr>
        <tr>
          <td align=center colspan=2>
             <input type="button" value="|<<" onclick="i=0;enregistrement(utilisateurs,i,nb_enreg);">
             <input type="button" value="<<" onclick="i=precedent(i);enregistrement(utilisateurs,i,nb_enreg);">
             <input type="button" name="noenreg">
             <input type="button" value=">>" onclick="i=suivant(i,nb_enreg);enregistrement(utilisateurs,i,nb_enreg);">
             <input type="button" value=">>|" onclick="i=nb_enreg;enregistrement(utilisateurs,i,nb_enreg);">
          </td>
        </tr>
        </table>
	<br>

<?php
	$codigo=$_POST["titulo"];
	$sql = "SELECT * FROM livros WHERE titulo=$codigo";
	$res = pg_query($sql);
	$registro=pg_fetch_row($res);
	$id_livro=$registro[2];
	$titulo=$registro[3];
	$autor=$registro[4];
	$tema=$registro[5];
?>