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
  <?php/*    <form method="POST" name="formu" action="add_user2.php" onsubmit="return controle_choix()" onsubmit="return valid_form()"> 27/11/2007 */?>
  <form method="POST" name="formu" action="add_user2.php" onsubmit="return valid_form()">
      <tr>
        <td class=header align=center>
          <h1>Cria&ccedil;&atilde;o de Usu&acute;rios</h1>
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
            <td>Endere&cedil;o :</td>
            <td colspan=3>
              <input type=text name='adresse' maxlength=100>
            </td>
          </tr>
          <tr>
             <td>C&ocute;digo Postal :</td>
             <td>
               <input type=text name='cp' maxlength=10 onkeypress="return verif_touche(event);" >
             </td>
             <td>Cidade :</td>
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
              Endere&ccedil;o Eletronico:
            </td>
          </tr>
          <tr>
            <td>E mail :</td>
            <td><input type=text name='mail1' maxlength=30 onblur="this.value=verif_mail(this.value)" ></td>
            <td>E mail2 :</td>
            <td><input type=text name='mail2' maxlength=30 onfocus="if (document.formu.mail1.value.length==0){document.formu.mail1.focus();}"  onblur="this.value=verif_mail(this.value)" ></td>
          </tr>
           <tr>
      <?php/*      <td>E mail3 :</td>
            <td><input type=text name='mail3' maxlength=15 onfocus="if (document.formu.mail2.value.length==0){document.formu.mail2.focus();}"  onblur="this.value=verif_mail(this.value)" ></td>
            <td>E mail4 :</td>
            <td><input type=text name='mail4' maxlength=15 onfocus="if (document.formu.mail3.value.length==0){document.formu.mail3.focus();}" onblur="this.value=verif_mail(this.value)" ></td>  Retirado em 27/11/2007 (Cristiano) */  ?>
          </tr>
          </table>
        </td>
      </tr>
      <tr>
        <td align=center>
          <table class=form>
          <tr>
            <td class=header colspan=4 align=center>
              Documentos  :
            </td>
          </tr>
          <tr>
            <td>Número de matrícula :</td>
            <td>
            <?php /* <input type=text name="matricul" maxlength=11  onkeypress="return verif_touche(event);">
            </td> */ ?>
<input type=text name="matricul" maxlength=15 onBlur="if(document.formu.matricul.value.length<6){alert ('O Campo deve ter no minimo 6 caracteres.');document.formu.cpf.focus();}" onkeypress="return verif_touche(event);">
           </td>
            <td>Número de CPF :</td>
            <td>
              <input type=text name='cpf' maxlength=14 onkeypress="return verif_touche(event);" onkeyup="if(event.keyCode!=8 && event.keyCode!=13){this.value = saisie_cpf(this.value);}" onfocus="if(document.formu.matricul.value.length<6){document.formu.matricul.focus();}" >
            </td>
          </tr>
          <tr>
            <td>Número de Identidade:</td>
            <td>
              <input type=text name='identity' maxlength=40>
<?php
// onkeypress="return verif_touche(event);">
?>
            </td>
          </tr>
          </table>
           <tr>
	   <td align=center>
             	<table class=form>
           	<tr><td class=header align=center colspan=3>Vínculo</td></tr>
           	<tr>
	   		<td>
			<input type=button name='rights' value='Aluno' onclick="window.open('aluno.php?idmod=<?php echo $_GET['idmod'] ?>','pop1','width=600,height=600');">
			<input type=button name='rights' value='Convidados' onclick="window.open('convidado.php?idmod=<?php echo $_GET['idmod'] ?>','pop1','width=600,height=600');">
			<input type=button name='rights' value='Funcionário' onclick="window.open('funcionario.php?idmod=<?php echo $_GET['idmod'] ?>','pop1','width=600,height=600');">
		</td>
	  	</tr>
	  	</table>
	  </td>
	  </tr>
	<tr>
	 <td align=center>
   	 <table class=form>
          <tr>
          <td class=header align=center colspan=2>Quais(s) tipos(s) de conta deseja criar?</td>
          </tr>
          <tr>
            <td>Unix :</td>
            <td><input type=checkbox name=unix enable value="true"></td>
          </tr>
         <?php/*
	 <tr>
            <td>Samba :</td>
            <td><input type=checkbox name=samba></td>
          </tr>
          <tr>
            <td>SI :</td>
            <td><input type=checkbox name=si></td>
          </tr>
	*/ 
	?>
	  </tr>
          </table> 
</td> 
      </tr>
      <tr>
        <td align=center>
          <input type=submit>
        </td>
      </tr>
      </form>
      </table>
  </body>
</html>
<?php
  pg_close($idconn);
?>
