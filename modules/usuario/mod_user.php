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
          <h1>Criação de Novos Usuarios</h1>Atualização de Dados
        </td>
      </tr>
      <tr>
        <td align=center>
          <table class=form>
          <tr>
            <td colspan=4 class=header align=center>
              Dados Pessoais :
            </td>
          </tr>
          <tr>
            <td> Nome : </td>
            <td>
              <input type=text name='name' maxlength=60 onblur="this.value= prem_lettre_majuscule(this.value)" >
            </td>
            <td>Sobrenome :</td>
            <td>
              <input type=text name='firstname' maxlength=60 onblur="this.value= prem_lettre_majuscule(this.value)" >
            </td>
          </tr>
          <tr>
            <td>Endereço :</td>
            <td colspan=3>
              <input type=text name='adresse' maxlength=100>
            </td>
          </tr>
          <tr>
             <td>Código Postal :</td>
             <td>
               <input type=text name='cp' maxlength=10 onkeypress="return verif_touche(event);" >
             </td>
             <td>Bairro :</td>
             <td>
               <input type=text name='city' maxlength=20 onblur="this.value= prem_lettre_majuscule(this.value)">
             </td>
          </tr>
          <tr><td colspan=4><hr></td></tr>
          <tr>
            <td>Telefone Residencial :</td>
            <td>
              <input type=text name='phone_home' maxlength=15 onkeypress="return verif_touche(event);">
            </td>
            <td>Telefone Comercial :</td>
            <td>
              <input type=text name='phone_work' maxlength=15 onkeypress="return verif_touche(event);">
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
              Endereço de E-mail:
            </td>
          </tr>
          <tr>
            <td>Mail1 :</td>
            <td><input type=text name='mail1' maxlength=15 onblur="this.value=verif_mail(this.value)" ></td>
            <td>Mail2 :</td>
            <td><input type=text name='mail2' maxlength=15 onfocus="if (document.formu.mail1.value.length==0){document.formu.mail1.focus();}"  onblur="this.value=verif_mail(this.value)" ></td>
          </tr>
           <tr>
            <td>Mail3 :</td>
            <td><input type=text name='mail3' maxlength=15 onfocus="if (document.formu.mail2.value.length==0){document.formu.mail2.focus();}"  onblur="this.value=verif_mail(this.value)" ></td>
            <td>Mail4 :</td>
            <td><input type=text name='mail4' maxlength=15 onfocus="if (document.formu.mail3.value.length==0){document.formu.mail3.focus();}" onblur="this.value=verif_mail(this.value)" ></td>
          </tr>
          </table>
        </td>
      </tr>
      <tr>
        <td align=center>
          <table class=form>
          <tr>
            <td class=header colspan=4 align=center>
              Documentação :
            </td>
          </tr>
          <tr>
            <td>Número de matrícula :</td>
            <td>
              <input type=text name="matricul" maxlength=6 onBlur="if(document.formu.matricul.value.length!=6){alert ('Campo doit avoir 6 caracteres.');document.formu.cpf.focus();}" onkeypress="return verif_touche(event);">
            </td>
            <td>Numero de CPF :</td>
            <td>
              <input type=text name='cpf' maxlength=14 onkeypress="return verif_touche(event);" onkeyup="if(event.keyCode!=8 && event.keyCode!=13){this.value = saisie_cpf(this.value);}" onfocus="if(document.formu.matricul.value.length!=6){document.formu.matricul.focus();}" >
            </td>
          </tr>
          <tr>
            <td>Numero de identidade:</td>
            <td>
              <input type=text name='identity' maxlength=15 onkeypress="return verif_touche(event);">
            </td>
          </tr>
          </table>
        </td>
      </tr>
      <tr>
        <td align=center>


<tr>
       <td align=center>
         <table class=form>
          <tr>
            <td class=header align=center colspan=3>Vínculo</td>
          </tr>
           <td>
		<input type=button name='rights' value='Aluno' onclick="window.open('aluno.php?idmod=<?php echo $_GET['idmod'] ?>','pop1','width=600,height=600');">
		<input type=button name='rights' value='Convidados' onclick="window.open('convidado.php?idmod=<?php echo $_GET['idmod'] ?>','pop1','width=600,height=600');">
		<input type=button name='rights' value='Funcion?rio' onclick="window.open('funcionario.php?idmod=<?php echo $_GET['idmod'] ?>','pop1','width=600,height=600');">
	  </td>
          </tr>
          </table>
       </td>
     </tr>

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
