<?php
  include("head_user.php");


/* // somente para carreagr as matriculas na tabela student
     $query_provisorio="select matricul,coduser from users where tipo_users='student'";
     $result_provisorio=pg_query($query_provisorio);
     $nb_enreg_provisorio=pg_num_rows($result_provisorio);
     $i=0;
            for ($i=0;$i<$nb_enreg_provisorio;$i++)
            {
               $tab_provisorio=pg_fetch_array($result_provisorio, $i);
	       $muda_student="update student set matricul=".$tab_provisorio['matricul']." where coduser=".$tab_provisorio['coduser'];
	       $muda=pg_query($muda_student);
		}
*/
?>

<html>
  <header>
    <link type="text/css" rel="stylesheet" href="../../global/grafic.css">
    <script language="javascript" src="navig_js.js"></script>
    <script language="javascript"  src="formu.js"></script>
    <script language="javascript" > 
	var utilisateurs = new Array();
      var i = 0;
   </script>
   <meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
   </header>
  <body>
  <table class=big>
  <form name="utilisateur" action="add_user2.php" method="POST">
  <tr>
      <td class=header align=center>
        <h1>Modifica&ccedil;&atilde;o de Dados do Usu&aacute;rio</h1>
      </td>
    </tr>
    <tr>
      <td>
        <table align=center class=form>
        <tr>
          <td class=header align=center colspan=2>Selecione um usu&aacute;rio</td>
        </tr>
        <tr>
          <td>
<?php
     $query="select * from users where name<>'root' order by name";
     $result=pg_query($query);
     $nb_enreg=pg_num_rows($result);
     $i=0;
?>
            <select name='user' onchange='enregistrement(utilisateurs,this.selectedIndex,nb_enreg);'>
<?php
            for ($i=0;$i<$nb_enreg;$i++)
            {
               $tab=pg_fetch_array($result, $i);

       $test1="select * from admin where coduser=".$tab['coduser'];
       $test2="select * from unix where coduser=".$tab['coduser'];
//       $test3="select * from samba where coduser=".$tab['coduser']; // o objetivo e fazer com que os e-mail sejam tambem trazidos para a tela
       $test3="select mail from mail where coduser=".$tab['coduser'];
       $res1=pg_query($test1);
       $res2=pg_query($test2);
       $res3=pg_query($test3);
       $nbre1=pg_num_rows($res1);
       $nbre2=pg_num_rows($res2);
       $nbre3=pg_num_rows($res3);
/////////////////////////////////////////////////////////////// recuperacao de dados profissionais//////////////////////////////////////////////
//	$sql="select * from users where coduser=".$tab['coduser'];
//	$sql_query=pg_query($sql);
//	$sql_array=pg_fetch_array($sql_query, 0);
	$tabela=$tab['tipo_users'];  //traz o tipo de usuario (fonctionnaire, student, visitor)
	if (($tabela=='professor') || ($tabela=='administrativo')) $tabela='fonctionnaire';

	if ($tabela=='fonctionnaire')
		{
		$sql2="select * from ". $tabela. " where coduser=".$tab['coduser'];
		$sql2=pg_query($sql2);
		$status1=pg_fetch_array($sql2,0);		//data_admissao
		$data_de_entrada=$status1['contract_date'];
		$data_encerramento=$status1['contract_end'];
		$data_encerramento=explode('-',$data_encerramento);
		$dia2=$data_encerramento[2];
		$mes2=$data_encerramento[1];
		$ano2=$data_encerramento[0];
		$status_usuario=$status1['statut'];
		$prof_orientador='0';
		$prof_orientador2='indefinido';
		$tipo_contrato=$status1['contract_type'];
	        if (($status_usuario=='professor') or ($status_usuario=='Professor'))
			{
			$sql1=pg_query("select * from profs where coduser=".$tab['coduser']);
			$sql1_array=pg_fetch_array($sql1, 0);
			$especialidade=$sql1_array['area_atuacao'];
			$funcional=$sql1_array['niveau_fonctionnel'];
			$bolsista=$sql1_array['bolsista'];
			$situacao=$sql1_array['situacao'];
		// acrescentado em 18/10/2018: credenciamento
//			$data_hoje=date("Y-m-d"); echo $data_hoje
//			$sql_cred=pg_query("select * from orientateur where coduser='".$tab['coduser']."' and date_debut<='".$data_hoje."' and '".$data_hoje."'<=date_fin");
			$sql_cred=pg_query("select date_fin,orientacao from orientateur where coduser='".$tab['coduser']."'");
			$cred_array=pg_fetch_array($sql_cred, 0);
var_dump($cred_array);
			//$debut_credencia=$cred_array['date_debut'];
			if(!empty($cred_array))
			{
				$date_fin=$cred_array['date_fin'];
				$date_fin_cred=explode('-',$date_fin);
				$fim_credencia_dia=$date_fin_cred[2];
				$fim_credencia_mes=$date_fin_cred[1];
				$fim_credencia_ano=$date_fin_cred[0];
				$orientacao=$cred_array['orientacao'];
			}
			else 
			{
                	        $fim_credencia_dia=0;
                        	$fim_credencia_mes=0;
                        	$fim_credencia_ano=0;
                      		$orientacao="nulo";
			}
// fim acrescimo credenciamento
			}
		else
			{
			$especialidade="esp. indefinido";
			$funcional="indeterminado";
			$bolsista="sem bolsa";
			$situacao='indefinido'; 
// includo em 18/10/2018
			$fim_credencia_dia=0;
                        $fim_credencia_mes=0;
                        $fim_credencia_ano=0;
                        $orientacao="nulo";
// fim incluido em 18/10/2018
			}
		}

	if ($tabela=='student')
		{
		$sql2="select * from ". $tabela. " where matricul=".$tab['matricul'];
		$sql2=pg_query($sql2);
		$status1=pg_fetch_array($sql2,0);		//data_admissao
		$status_usuario='Aluno';
		$funcional='Indeterminado';
		$data_de_entrada=$status1['coming_date'];
		$data_encerramento=$status1['depart_date1'];
		$data_encerramento=explode('-',$data_encerramento);
		$dia2=$data_encerramento[2];
		$mes2=$data_encerramento[1];
		$ano2=$data_encerramento[0];
		$tipo_contrato=$status1['formation'];
		$especialidade=$status1['speciality'];
		$prof_orientador=$status1['orientateur'];
		$bolsista=$status1['bolsista'];
		$situacao=$status1['status'];
// includo em 18/10/2018
                $fim_credencia_dia=0;
                $fim_credencia_mes=0;
                $fim_credencia_ano=0;
                $orientacao="nulo";
// fim incluido em 18/10/2018 
		if ($prof_orientador==0)
			$prof_orientador2='indefinido';
		else
			{
			$query_users="select name,firstname from users where coduser='".$prof_orientador."'";
			$prof_orientador1=pg_fetch_array(pg_query($query_users),0);
			$prof_orientador2=$prof_orientador1[0]." ".$prof_orientador1[1];
			}
		}

	if ($tabela=='visitor') 
		{ 
		$sql2="select * from ". $tabela. " where coduser=".$tab['coduser']." order by date_begin DESC limit 1";
		$sql2=pg_query($sql2);
		$status1=pg_fetch_array($sql2,0);		
		$status_usuario='Visitante'; 
		$especialidade=$status1['area_atuacao']; 
		$funcional='Indeterminado'; 
		$prof_orientador='0';
		$prof_orientador2='indefinido';
		$bolsista='sem bolsa';
		$situacao='indefinido'; 
		$tipo_contrato=$status1['tipo_visitor'];
		$data_de_entrada=$status1['date_begin'];
		$data_encerramento=$status1['date_end'];
		$data_encerramento=explode('-',$data_encerramento);
		$dia2=$data_encerramento[2];
		$mes2=$data_encerramento[1];
		$ano2=$data_encerramento[0];
// includo em 18/10/2018
                $fim_credencia_dia=0;
                $fim_credencia_mes=0;
                $fim_credencia_ano=0;
                $orientacao="nulo";
// fim incluido em 18/10/2018
		}



///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	$k_mail=0;
	$mail_user=array();
	while ($k_mail<$nbre3)
	{
        $tab3=pg_fetch_array($res3,$k_mail);
        $mail_user[$k_mail]=$tab3[0];
	$k_mail=$k_mail+1;
	}
////////////////////

//	$nome=mb_convert_encoding($tab['name'],"ISO-8859-1","UTF-8");
//	$sobrenome=mb_convert_encoding($tab['firstname'],"ISO-8859-1","UTF-8");
//	$cidade=mb_convert_encoding($tab['city'],"ISO-8859-1","UTF-8");
//	$endereco=mb_convert_encoding($tab['adresse'],"ISO-8859-1","UTF-8");

	$nome=$tab['name'];
	$sobrenome=$tab['firstname'];
	$cidade=$tab['city'];
	$endereco=$tab['adresse'];


               $param="'".$tab['coduser']."','".$nome."','".$sobrenome."','".$tab['matricul']."','".$tab['cpf']."','".$tab['identity']."','".$tab['phone_work']."','".$tab['phone_home']."','".$endereco."','".$tab['cp']."','".$cidade."','".$mail_user[0]."','".$mail_user[1]."','".$mail_user[2]."','".$mail_user[3]."','".$status_usuario."','".$tipo_contrato."','".$data_de_entrada."','".$dia2."','".$mes2."','".$ano2."','".$especialidade."','".$funcional."','".$prof_orientador."','".$prof_orientador2."','".$bolsista."','".$situacao."','".$fim_credencia_dia."','".$fim_credencia_mes."','".$fim_credencia_ano."','".$orientacao."'";

 //.$nbre1.",".$nbre2.",".$nbre3;

               $param=str_replace(CHR(10)," ",$param);
               $param=str_replace(CHR(13)," ",$param);

?>
	       <script language="javascript" >
                 utilisateurs[<?php echo $i ?>] = new users(<?php echo $param ?>);
               </script>
<?php
               echo "<option value='".$tab['coduser']."'";
               if ($_GET['US']==$tab['coduser']) echo " selected  ";
//               echo ">".$tab['matricul']."--".$tab['name']." ".$tab['firstname']."</option>";
               echo ">".$nome." ".$sobrenome."--".$tab['matricul']."</option>";
		}

    	?>
            </select>
          </td>
        </tr>
        </table>
      </td>
    </tr>
<?php
/*
        <tr>
          <td align=center colspan=2>
             <input type="button" value="|<<" onclick="i=0;enregistrement(utilisateurs,i,nb_enreg);">
             <input type="button" value="<<" onclick="i=precedent(i);enregistrement(utilisateurs,i,nb_enreg);">
             <input type="button" name="noenreg">
             <input type="button" value=">>" onclick="i=suivant(i,nb_enreg);enregistrement(utilisateurs,i,nb_enreg);">
             <input type="button" value=">>|" onclick="i=nb_enreg;enregistrement(utilisateurs,i,nb_enreg);">
          </td>
        </tr>
*/
?>
<?php
/*  if (isset($_GET['US']))
  { 
    $query2="select * from users where coduser=".$_GET['US'];
    $result2=pg_query($query2);
    $tab2=pg_fetch_array($result2,0);

///////////////////////////////////////////////////////////

  }*/
?>
        <td colspan=2 align=center>
        <table class=form>
        <tr>
          <td colspan=4 class=header align=center>
            Dados Pessoais :
          </td>
        </tr>
        <tr>
          <td> Nome : </td>
          <td>
            <input type=text name='name' maxlength=60 onblur="this.value= prem_lettre_majuscule(this.value)">
<input type=hidden name='coduser' >
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
             <input type=text name='cp' maxlength=10 onkeypress="return verif_touche(event);">
           </td>
           <td>Bairro :</td>
           <td>
             <input type=text name='city' maxlength=20 onblur="this.value=prem_lettre_majuscule(this.value)">
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
<?php ////////////// ADICIONADO EM 04/12/07

?>
       <tr><td colspan=4><hr></td></tr>
         <tr>
	<td colspan=1>Endereco eletronico : </td><td colspan=3><input type=text name='mail1' size='20' maxlength=300 >
		      Endereco eletronico : <input type=text name='mail2' size='20' maxlength=300 >
	<tr>
	<td colspan=1>Endereco eletronico : </td><td colspan=3><input type=text name='mail3' size='20' maxlength=300 >
	              Endereco eletronico :<input type=text name='mail4' size='20' maxlength=300 >
       </tr>
<?php ////////////////////////////////////
?>
         <tr><td colspan=4><hr></td></tr>
         <tr>
            <td>N&uacute;mero de matr&iacute;cula :</td>
            <td>
              <input type=text name='matricul' maxlength=15  onkeypress="return verif_matricul(event);" onBlur="if(this.value.length<6){alert ('O Campo deve ter no minimo 6 caracteres.');this.focus();}">
            </td>
            <td>N&uacute;mero de CPF :</td>
            <td>
              <input type=text name='cpf' maxlength=14 onkeypress="return verif_touche(event);" onkeyup="if(event.keyCode!=8 && event.keyCode!=13){this.value = saisie_cpf(this.value);}" onfocus="if(document.formu.matricul.value.length<6){document.formu.matricul.focus();}">
            </td>
          </tr>
          <tr>
            <td>N&uacute;mero de identidade:</td>
            <td>
              <input type=text name='identity' maxlength=40>
            </td>
          </tr>
         </table>

<?php
/////////////////////////////////////////////////////////////// Dados profissionais ////////////////////////////////////////////////////////////////////////
?>
		<tr>

		<td align=center>
		<table class=form>
		<tr>
		<td colspan=8 class=header align=center>Dados profissionais:</td>
		</tr>
		<tr>

 <td>Status :</td><td><input name='status_usuario' readonly>	
						<td><select name='status_usuario1'>
                  				    <OPTION selected value="nao_modifica">n&atilde;o altera
						    <OPTION value="visitor">Visitante
						    <OPTION value="student">Aluno
						    <OPTION value="administrativo">Administrativo
						    <OPTION value="professor">Professor</SELECT></td>
					   
<?php /////////////////////////////////////////////////////////////Data Admissão ///////////////////////////////////////////////////////////////////////
?>
<td>Data de Admiss&atilde;o :</td><td><input name='data_de_entrada' readonly size='10'></td>
<td> Nova admiss&atilde;o:<input name='dia_novo' size='1' maxlength="2">/<input name='mes_novo' size='1' maxlength="2">/<input name='ano_novo' size='3' maxlength="4">		
			</td>

<tr> 
<?php /////////////////////////////////////////////////////////////Tipo Contratual ///////////////////////////////////////////////////////////////////////

// <td>Tipo Contratual :</td><td><input name='tipo_contrato'  readonly>
?>
<td>Tipo Contratual :<td><input name='tipo_contrato1' readonly>
							<td><SELECT name='tipo_contrato'>
							<OPTION selected value="nao_modifica">n&atilde;o altera
							<?php            // gera a lista de usuarios registrados
							$res_tipo_cont = pg_query("SELECT * FROM users_tipo_contrato order by descricao");
							while($reg_tipo_cont = pg_fetch_row($res_tipo_cont)) 
								{
								echo "<option value='".$reg_tipo_cont[0]."'>".$reg_tipo_cont[1]."</option>";
								}
							?></select></td>


<td>Data de encerramento :</td>
			<td><input name='dia_dois' size='1' maxlength="2">/<input name='mes_dois' size='1' maxlength="2">/<input name='ano_dois' size='3' maxlength="4">		
			</td>    
			</tr>
			<tr>
<td>Nivel :</td><td><input name='funcional1' readonly >   
							<td><SELECT name='funcional'>
							<OPTION selected value="nao_modifica">n&atilde;o altera
							<?php            // gera a lista de usuarios registrados
							$res_nivel = pg_query("SELECT * FROM users_nivel_funcional order by descricao");
							while($reg_nivel = pg_fetch_row($res_nivel)) 
								{
								echo "<option value='".$reg_nivel[0]."'>".$reg_nivel[1]."</option>";
								}
							?></select></td>

<! incluido em 18/10/2018 >
<td>Credenciado para orientar at&eacute; </td><td><input name='fim_credencia_dia' size='2' maxlength="2" >/<input  name='fim_credencia_mes' size='1' maxlength="2" >/<input name='fim_credencia_ano' size='3' maxlength="4" > <input name='orientacao' readonly size="6"></td><td><select name="credencia_nivel">
			<OPTION selected value="nao_modifica">n&atilde;o altera
			<option value="nulo"> N&atilde;o credenciado</option>			
			<option value="ambos"> Mestrado e doutorado</option>
			<option value="mestrado"> Mestrado </option>
			<option value="doutorado"> Doutorado </option>
			</select></td></tr>  

<! Fim inclusao 18/10/2018 >

<tr>
<td> Professor Orientador : </td><td><input name='prof_orientador2' readonly>
				<td><SELECT name='prof_orientador'>
				<option selected value='0'>indefinido</option>
				<OPTION selected value="nao_modifica">n&atilde;o altera</OPTION>
		<?php               // gera a lista de usuarios registrados
					//$res = pg_query("SELECT coduser FROM profs where orientateur='true'");
$res = pg_query("SELECT pf.coduser, us.name, us.firstname FROM profs pf,users us where pf.orientateur='true' and pf.coduser=us.coduser order by us.name");
					//seleciona coduser onde status é prof em fonctionnaire e depois, selecione em users nome onde coduser=coduser
					while($registro = pg_fetch_row($res)) //enquanto ouver registro escreva
						{
						$cod = $registro[0];  		// primeira coluna da tabela usuario
						//$res2 = pg_query("SELECT name,firstname FROM users where coduser=$cod");
						//$novo_registro = pg_fetch_row($res2);
						//$sobrenome=explode(" ",$novo_registro[1]);
						$sobrenome=explode(" ",$registro[2]);
						$sobrenome2=$sobrenome[count($sobrenome)-1];
//						$titulo=$novo_registro[0]." ".$sobrenome2;
//						$titulo=mb_convert_encoding($registro[1],"ISO-8859-1","UTF-8")." ".mb_convert_encoding($sobrenome2,"ISO-8859-1","UTF-8");
						$titulo=$registro[1]." ".$sobrenome2;
						//echo "<option value=\"$cod\">$titulo</option>\n"; //Escreva o codigo e o nome do usuario
						echo "<option value='".$cod."'>".$titulo."</option>";
						}

				?></select>
            </td>
<td>Especialidade :</td><td><input name='especialidade1' readonly>
							<td><SELECT name='especialidade'>
							<OPTION selected value="nao_modifica">n&atilde;o altera
							<OPTION value="esp. indefinido">Sem Especialidade
							<OPTION value="algebra">Algebra
							<OPTION value="teoria dos numeros">Teoria dos N&uacute;meros
							<OPTION value="analise">Analise
							<OPTION value="geometria">Geometria
							<OPTION value="fisica matematica">F&iacute;sica Matem&aacute;tica
							<OPTION value="computacao">Teoria da Computa&ccedil;&atilde;o
							<OPTION value="probabilidade">Probabilidade
							<OPTION value="historia matematica">Hist&oacute;ria da Matem&aacute;tica
							<OPTION value="sistemas dinamicos">Sistemas Din&acirc;micos
					                <OPTION value="mecanica">Mec&acirc;nica
							</SELECT></td>



<tr><tr> <td>Bolsista :</td><td><input name='bolsista1' readonly>
							<td><SELECT name='bolsista'>
							<OPTION selected value="nao_modifica">n&atilde;o altera
							<?php            // gera a lista de usuarios registrados
							$res_bolsas = pg_query("SELECT * FROM users_bolsas order by descricao");
							while($reg_bolsas = pg_fetch_row($res_bolsas)) 
								{
								echo "<option value='".$reg_bolsas[0]."'>".$reg_bolsas[1]."</option>";
/*
							<OPTION  value="sem bolsa">Sem Bolsa
							<OPTION  value="pibic">Pibic
							<OPTION  value="extensao">Extens&atilde;o
							<OPTION  value="estagio">Est&aacute;gio
							<OPTION  value="cnpq">CNPq
							<OPTION  value="capes">CAPES
							<OPTION  value="femat">FEMAT
							<OPTION  value="monitoria">Monitoria
							<OPTION  value="outros">Outros</SELECT></td>
*/
								}
							?></select></td>
							
<td>Situa&ccedil;&atilde;o :</td><td><input name='situacao1' readonly>
							<td><SELECT name='situacao'>
							 <OPTION  value="nao_modifica" selected >N&atilde;o altera</OPTION> 
							<OPTION  value="ativo" >Matriculado </OPTION>
							<OPTION  value="aposentado" >professor aposentado </OPTION>
							<OPTION  value="redistribuido" >professor redistribuido </OPTION>
							<OPTION  value="titulado" >Titulado </OPTION>
							<OPTION  value="desligado" >Desligado </OPTION>
							<OPTION  value="abandonou" >Abandonou o curso </OPTION>
							</SELECT></td>

          </tr>
         </table>
<?php
////////////////////////////////////
?>

<?php
/*    onkeypress="return verif_touche(event);"

<tr>
<td align=center>
          <table class=form>
          <tr>
            <td class=header align=center colspan=3>Vínculo</td>
          </tr>
           <td>
		<input type=button name='rights' value='Aluno' onclick="window.open('aluno.php?idmod=<?php echo $_GET['idmod'] ?>','pop1','width=600,height=600');">
		<input type=button name='rights' value='Convidados' onclick="window.open('convidado.php?idmod=<?php echo $_GET['idmod'] ?>','pop1','width=600,height=600');">
		<input type=button name='rights' value='Funcionário' onclick="window.open('funcionario.php?idmod=<?php echo $_GET['idmod'] ?>','pop1','width=600,height=600');">
	  </td>
           </table>
</tr>
       </td>
     </tr>
*/
?>

     <tr>
   <?php /*   <td align=center>
         <table class=form>
          <tr>
            <td class=header align=center colspan=3>Tipo de Conta</td>
          </tr>
          <tr>
            <td>Unix :</td>
            <td><input type=checkbox name=unix disabled ></td>
          </tr>
          <tr>
            <td>Samba :</td>
            <td><input type=checkbox name=samba disabled ></td>
          </tr>
          <tr>
            <td>SI :</td>
            <td><input type=checkbox name=si disabled  ></td>
            <td>
              <input type=button name="si_modif" value="Modificar" onclick="window.open('modif_si.php?cu='+ utilisateurs[i].coduser,'pop1','width=510,height=560');">
              <input type=button name="si_add" value="Adicionar" onclick="window.open('add_si.php?cu='+ utilisateurs[i].coduser +'&&un=' +  utilisateurs[i].unix  + '&&sa='+  utilisateurs[i].samba,'pop1','width=510,height=560');">
            </td>
          </tr>
          </table>
   </td>   */
   ?>  </tr>
     <tr>
     <input type=hidden name='modificacao' value="sim">
     <input type=hidden name='prof_orientador1'>
       <td align=center>
         <input type=submit value=Modificar>
<?php
//         <input type=button value=Mail>  retirado em 30/11/07 pois o usuario recebe automaticamente uma conta de mail no sistema

//         <input type=button name="login/pass" value="Login/Senha" onclick="window.open('alter_senha.php?cu='+ utilisateurs[i].coduser,'pop1','width=510,height=560');">
?>
       </td>
     </tr>
  </form>
  <script language="javascript" >
    var nb_enreg = <?php echo $nb_enreg-1 ?>;
    enregistrement(utilisateurs,i,nb_enreg);
  </script>
     </table>
    </body>
</html>
<?php
  pg_close($idconn);
?>
