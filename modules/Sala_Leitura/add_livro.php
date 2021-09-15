<?php
  include("head_account.php");
?>
<html>
  <header>
    <link type="text/css" rel="stylesheet" href="../../global/grafic.css">
    <script language="JavaScript" src="navig_js.js"></script>
    <script language="javascript" src="formu.js"></script>
    <script language="javascript">
      var utilisateurs = new Array();
      var i = 0;
    </script>
    <script language="javascript" src="formu.js">
    </script>
  </header>
  <body>
  <table class=big>
  <form name="utilisateur">
  <tr><td class=header align=center><h1>Consulta a livros</h1></td></tr>
  <tr><td colspan=2 align=center>
        <table class=form>
        <tr>
          <td colspan=4 class=header align=center>
            Dados do Livro :
          </td>
        </tr>
        <tr>
          <td> Identificador do Livro : </td>
          <td>
            <input type=text name='name' maxlength=60 onblur="this.value= prem_lettre_majuscule(this.value)">
          </td>
          <td>Título :</td>
            <td>
              <select size="1" name="titulo" maxlength=60>
	<?php
		// gera a lista de titulos
		$res = pg_query("SELECT * FROM livros where titulo!=''");
		while($registro = pg_fetch_row($res))
		{
			$cod = $registro[4];
			$nome = $registro[1];
			echo "<option value=\"$cod\">$nome</option>\n";
		}
	?>
	</select>
	</tr>
        <tr>
          <td> Autor : </td>
          <td>
            <input type=text name='autor' maxlength=60 onblur="this.value= prem_lettre_majuscule(this.value)">
          </td>
          <td>Tema :</td>
          <td>
            <input type=text name='tema' maxlength=60 onblur="this.value= prem_lettre_majuscule(this.value)" >
          </td>
        </tr>

         </table>
<tr>
      <td colspan=2 align=center>
        <table class=form>
        <tr>
          <td colspan=4 class=header align=center>
            Emprestimo :
          </td>
        </tr>
        <tr>
          <td> Identificador do Usuario : </td>
          <td>
          <select size=1 name="coduser" maxlength=60>
	<?php
		// gera a lista de usuarios
		$res = pg_query("SELECT * FROM users");
		while($registro = pg_fetch_row($res))
		{
			$cod = $registro[0];
			$nome = $registro[1];
			echo "<option value=\"$cod\">$nome</option>\n";
		}
	?>
	</select>
          </td>
          <td>Data de Emprestimo :</td>
          <td>
            <input type=text name='firstname' maxlength=60 onblur="this.value= prem_lettre_majuscule(this.value)" >
          </td>
        </tr>
        <tr>
          <td> Reserva : </td>
          <td>
            <input type=text name='name' maxlength=60 onblur="this.value= prem_lettre_majuscule(this.value)">
          </td>
          <td>Data de Devolucao :</td>
          <td>
            <input type=text name='firstname' maxlength=60 onblur="this.value= prem_lettre_majuscule(this.value)" >
          </td>
        </tr>

         </table>
       </td>
     </tr>
     <tr>
       <td align=center>

     <tr>
       <td align=center>
         <input type=button name='rights' value='Cadastrar Livro' onclick="window.open('cada_livr.php?idmod=<?php echo $_GET['idmod'] ?>','pop1','width=600,height=600');">
	 <input type=submit value=Enviar>
         <input type=button value=Modificar>
         <input type=button value=Fechar>
	 </td>
     </tr>
  </form>
  <script language="javascript">
    var nb_enreg = <?php echo $nb_enreg-1 ?>;
    enregistrement(utilisateurs,i,nb_enreg);
  </script>
     <table>
    </body>
</html>

