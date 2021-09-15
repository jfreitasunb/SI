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
    <meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
  </header>
  <body>
      <table class=big>
  <?php
/*    <form method="POST" name="formu" action="add_user2.php" onsubmit="return controle_choix()" onsubmit="return valid_form()"> 27/11/2007 
*/ 
?>
  <form method="POST" name="formu" action="add_user2.php"  onsubmit="return valid_form()">
      <tr>
        <td class=header align=center>
          <h1>Cria&ccedil;&atilde;o de Usu&aacute;rios</h1>
        </td>
      </tr>
      <tr>
        <td align=center><table class=form><tr>
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
            <td>Endere&ccedil;o :</td>
            <td colspan=3>
              <input type=text name='adresse' maxlength=100>
            </td>
          </tr>
          <tr>
             <td>C&oacute;digo Postal :</td>
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
          </table></td></tr>
      <tr>
        <td align=center>
          <table class=form>
          <tr>
            <td colspan=4 class=header align=center>
              Endere&ccedil;o Eletr&ocirc;nico:
            </td>
          </tr>
          <tr>
            <td>E mail :</td>
            <td><input type=text name='mail1' maxlength=30 onblur="this.value=verif_mail(this.value)" ></td>
            <td>E mail2 :</td>
            <td><input type=text name='mail2' maxlength=30 onfocus="if (document.formu.mail1.value.length==0){document.formu.mail1.focus();}"  onblur="this.value=verif_mail(this.value)" ></td>
<tr>
            <td>E mail3 :</td>
            <td><input type=text name='mail3' maxlength=30 onblur="this.value=verif_mail(this.value)" ></td>
            <td>E mail4 :</td>
            <td><input type=text name='mail4' maxlength=30 onfocus="if (document.formu.mail1.value.length==0){document.formu.mail1.focus();}"  onblur="this.value=verif_mail(this.value)" ></td>

          </tr>
           <tr>
      <?php
/*      <td>E mail3 :</td>
            <td><input type=text name='mail3' maxlength=15 onfocus="if (document.formu.mail2.value.length==0){document.formu.mail2.focus();}"  onblur="this.value=verif_mail(this.value)" ></td>
            <td>E mail4 :</td>
            <td><input type=text name='mail4' maxlength=15 onfocus="if (document.formu.mail3.value.length==0){document.formu.mail3.focus();}" onblur="this.value=verif_mail(this.value)" ></td>  Retirado em 27/11/2007 (Cristiano) */  
?>
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
            <td>N&uacute;mero de matr&iacute;cula :</td>
            <td>
            <?php /* <input type=text name="matricul" maxlength=11  onkeypress="return verif_touche(event);">
            </td> */ ?>
<input type=text name="matricul" maxlength=15 onkeypress="return verif_matricul(event);" onBlur="if(document.formu.matricul.value.length<6 && document.formu.matricul.value.length!0){alert ('O Campo deve ter no minimo 6 caracteres.'); document.formu.cpf.focus();}">
           </td>
            <td>N&uacute;mero de CPF :</td>
            <td>
              <input type=text name='cpf' maxlength=14 onkeypress="return verif_touche(event);" onkeyup="if(event.keyCode!=8 && event.keyCode!=13){this.value = saisie_cpf(this.value);}" onfocus="if(document.formu.matricul.value.length<6 && document.formu.matricul.value.length!0){document.formu.matricul.focus();}" >

            </td>
          </tr>
          <tr>
            <td>N&uacute;mero de Identidade:</td>
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
		<tr>
		<td colspan=4 class=header align=center>Dados profissionais:</td>
		</tr>
		<tr>

 <td>Status :</td><td><select name="status_usuario">
							<OPTION selected value="visitor">Visitante
							<OPTION selected value="student">Aluno
							<OPTION selected value="administrativo">Administrativo
							<OPTION selected value="professor">Professor</SELECT></td>
<?php /////////////////////////////////////////////////////////////Data Admissão ///////////////////////////////////////////////////////////////////////
?>
<td>Data de Admiss&atilde;o :<td><!input name='dia_dois' size='1' maxlength="2" onkeypress="return verif_touche(event);"><input type=text name='dia_dois' size='1' maxlength=10 onkeypress="return verif_touche(event);" >/<input name='mes_dois' size='1' maxlength="2">/<input name='ano_dois' size='3' maxlength="4">
			</td>
			</tr>

<tr>
<?php /////////////////////////////////////////////////////////////Tipo Contratual ///////////////////////////////////////////////////////////////////////
?>
<td>Tipo Contratual :<td><select name="tipo_contrato">
				<?php            // gera a lista de usuarios registrados
					$res_tipo_cont = pg_query("SELECT * from users_tipo_contrato order by descricao");
					while($reg_tipo_cont = pg_fetch_row($res_tipo_cont)) 
						{
						echo "<option value='".$reg_tipo_cont[0]."'>".$reg_tipo_cont[1]."</option>";
						}
				?></select></td></tr>
							
<td>Especialidade :</td><td>
<select name="especialidade">
							<OPTION selected value="esp. indefinido">Sem Especialidade
							<OPTION value="algebra">Algebra
							<OPTION value="teoria dos numeros">Teoria dos N&uacute;meros
							<OPTION value="analise">Analise
							<OPTION value="geometria">Geometria
							<OPTION value="fisica matematica">F&iacute;sica Matem&aacute;tica
							<OPTION value="computacao">Teoria da Computa&ccedil;&atilde;o
							<OPTION value="probabilidade">Probabilidade
							<OPTION value="historia matematica">Hist&oacute;ria da Matem&aacute;tica
							</SELECT></td>
<tr><td>N&iacute;vel :</td><td><select name="nivel_funcional">
				<?php            // gera a lista de usuarios registrados
					$res_nivel = pg_query("SELECT * from users_nivel_funcional order by descricao");
					while($reg_nivel = pg_fetch_row($res_nivel)) 
						{
						echo "<option value='".$reg_nivel[0]."'>".$reg_nivel[1]."</option>";
						}
				?></select></td>
<td> Credenciamento/Orient.:</td><td> in&iacute;cio em <input name="cred_dia" maxlength=2 size=1 onkeypress="return verif_touche(event);">/<input  name="cred_mes" maxlength=2 size=1 onkeypress="return verif_touche(event);">/<input name="cred_ano" maxlength=4 size=2 onkeypress="return verif_touche(event);"> 
N&iacute;vel: <select name="credencia_nivel">
			<option value="nulo"> N&atilde;o credenciado</option>			
			<option value="ambos"> Mestrado e doutorado</option>
			<option value="mestrado"> Mestrado </option>
			<option value="doutorado"> Doutorado </option>
			</select></td></tr>
	
<tr><td> Professor Orientador : </td><td><select name='prof_orientador'>
					<option selected value='0'>indefinido</option>
				<?php            // gera a lista de usuarios registrados
//					$res = pg_query("SELECT pf.coduser FROM profs pf,users us where pf.orientateur='true' and pf.coduser=us.coduser order by us.name");
					$data_hoje=date("Y-m-d");
					$res = pg_query("SELECT us.coduser,us.name,us.firstname,or.orientacao FROM users us,orientateur or where or.coduser=us.coduser and or.date_debut<='".$data_hoje."' and '".$data_hoje."'<= or.date_fin order by us.name"); // corrigido em 18/10/18.
					//seleciona coduser onde status é prof em fonctionnaire e depois, selecione em users nome onde coduser=coduser
					while($registro = pg_fetch_row($res)) //enquanto houver registro escreva
						{
						//$cod = $registro[0];  		// primeira coluna da tabela usuario
						//$res2 = pg_query("SELECT name,firstname FROM users where coduser=$cod");
						//$novo_registro = pg_fetch_array($res2);
//						//$titulo=$novo_registro[0];
						//echo "<option value='".$cod."'>".$novo_registro['name']." ".$novo_registro['firstname']."</	option>";
						echo "<option value='".$registro[0]."'>".$registro[1]." ".$registro[2]."(".$registro[3].")</	option>";
						}
				?></select></td></tr>
<tr> <td>Bolsista :</td><td><select name="bolsista">
				<?php            // gera a lista de usuarios registrados
					$res_bolsas = pg_query("SELECT * FROM users_bolsas order by descricao");
					while($reg_bolsas = pg_fetch_row($res_bolsas)) 
						{
						echo "<option value='".$reg_bolsas[0]."'>".$reg_bolsas[1]."</option>";
						}
				?></select></td>
</td></tr>

          </tr>
         </table>
	  </td>
	  </tr>
      <tr>
        <td align=center>
          <input type=submit>
        </td>
      </tr>
<input type=hidden name='modificacao' value="nao">
      </form>
      </table>
  </body>
</html>
<?php
  pg_close($idconn);
?>
