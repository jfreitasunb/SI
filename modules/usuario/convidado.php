<?php
  include("head_user.php");
?>
<html>
  <header>
    <script language=javascript src="function_js.js">
    </script>
    <script language=javascript src="formu.js">
    </script>
    <link type="text/css" rel="stylesheet" href="../../global/grafic.css">
  </header>
  <body>
      <table class=big>
      <form method="POST" name="formu" action="add_user2.php" onsubmit="return controle_choix()">
      <tr>
        <td class=header align=center>
          <h1>Visitantes</h1>Estágiarios, Convidados,Visitantes,...
        </td>
      </tr>
      <tr>
        <td align=center>
          <table class=form>
          <tr>
            <td colspan=4 class=header align=center>
              Relativo ao Visitante :
            </td>
          </tr>
          <td>Status do Convidado :</td>
            <td>
              <input type=text name='firstname' maxlength=60 onblur="this.value= prem_lettre_majuscule(this.value)" >
            </td>
          </tr>
          <tr><td colspan=4><hr></td></tr>
          <tr>
            <td>Data de Admissão :</td>
            <td>
              <input type=text name='phone_home' maxlength=15 onkeypress="return verif_touche(event);">
            </td>
            <td>Data de Saída Prevista :</td>
            <td>
              <input type=text name='phone_work' maxlength=15 onkeypress="return verif_touche(event);">
            </td>
          </tr>
          </table>
	   <tr>
        <td align=center>
          <input type=submit value="Enviar">
        </td>
      </tr>
</body>
</html>
<?php
  pg_close($idconn);
?>
