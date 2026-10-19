<?php
  require("head_user.php");
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
          <h1>Funcionários</h1>Atualização de Dados
        </td>
      </tr>
      <tr>
        <td align=center>
          <table class=form>
          <tr>
            <td colspan=4 class=header align=center>
              Relativo ao Funcionário :
            </td>
          </tr>
          <tr>
            <td> Admissão: </td>
            <td>
              <input type=text name='name' maxlength=60 onblur="this.value= prem_lettre_majuscule(this.value)" >
            </td>
            <td>Duração Contratual :</td>
            <td>
              <input type=text name='firstname' maxlength=60 onblur="this.value= prem_lettre_majuscule(this.value)" >
            </td>
          </tr>
          <tr>
             <td>Status :</td>
             <td>
               <input type=text name='cp' maxlength=10 onkeypress="return verif_touche(event);" >
             </td>
             <td>Tipo Contratual :</td>
             <td>
               <input type=text name='city' maxlength=20 onblur="this.value= prem_lettre_majuscule(this.value)">
             </td>
          </tr>
          </table>
        </td>
      </tr>
      <tr>
        <td align=center>
          <table class=form>
          <tr>
            <td colspan=4 class=header align=center>
              Férias Previstas:
            </td>
          </tr>
          <tr>
            <td>Inicio do Período :</td>
            <td><input type=text name='mail1' maxlength=15 onblur="this.value=verif_mail(this.value)" ></td>
            <td>Fim do Período :</td>
            <td><input type=text name='mail2' maxlength=15 onfocus="if (document.formu.mail1.value.length==0){document.formu.mail1.focus();}"  onblur="this.value=verif_mail(this.value)" ></td>
          </tr>
          </table>
        </td>
      </tr>
      <tr>
        <td align=center>
          <table class=form>
          <tr>
            <td class=header colspan=4 align=center>
              Licenças ou Ausências Acidentais :
            </td>
          </tr>
          <tr>
            <td>Inicio do Período :</td>
            <td>
              <input type=text name="matricul" maxlength=6 onBlur="if(document.formu.matricul.value.length!=6){alert ('Campo doit avoir 6 caracteres.');document.formu.cpf.focus();}" onkeypress="return verif_touche(event);">
            </td>
            <td>Final do Período :</td>
            <td>
              <input type=text name='cpf' maxlength=14 onkeypress="return verif_touche(event);" onkeyup="if(event.keyCode!=8 && event.keyCode!=13){this.value = saisie_cpf(this.value);}" onfocus="if(document.formu.matricul.value.length!=6){document.formu.matricul.focus();}" >
            </td>
          </tr>
          <tr>
            <td>Motivo da Ausência:</td>
            <td>
              <input type=text name='identity' maxlength=25 onkeypress="return verif_touche(event);">
            </td>
          </tr>
          </table>
        </td>
      </tr>

      <tr>
        <td align=center>
          <input type=submit value="Enviar">
        </td>
      </tr>
      </form>
      </table>
  </body>
</html>
<?php
  pg_close($idconn);
?>
