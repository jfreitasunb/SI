<?php
  require("head_user.php");
include("alias.php");

?>
 <script language=javascript src="formu.js">
    </script>
    <script language=javascript>
      function verif_pass()
{
            if (document.utilisateur2.pass1.value!= document.utilisateur2.pass2.value)
            {
                alert('As duas senhas nao sao identicas!');
                document.utilisateur2.pass1.focus();
                return false;
            }
            if (document.utilisateur2.login.value.length==0)
            {
                alert("Voce deve digitar um login!");
                document.forms['utilisateur2'].login.focus();
                return false;
            }
            if ((document.utilisateur2.pass1.value.length==0)||(document.utilisateur2.pass2.value.length==0))
            {
                alert("Voce deve digitar a senha e confirma-la!");
                document.forms['utilisateur2'].pass1.focus();
                return false;
            }
            return true;
}

    </script>
    <?php


//  $queryverif1="select * from admin where login='".$_POST['login']."'";
  $queryverif2="select * from unix where login=?"; $queryverif2__p = array($_POST['login']);
//  $queryverif3="select * from samba where login='".$_POST['login']."'";
//  $resverif1=pg_query($queryverif1);
  $resverif2=db_query($queryverif2, $queryverif2__p);
//  $resverif3=pg_query($queryverif3);
//  $countverif1=db_num_rows($resverif1);
  $countverif2=db_num_rows($resverif2);
//  $countverif3=db_num_rows($resverif3);

 // if ( ($countverif1==0)&&($countverif2==0)&&($countverif3==0) )
  if ($countverif2==0)
    $verifbool=true;
  else
    $verifbool=false;

/*  if ( (!empty($_POST['sa_prec']))&& $verifbool)
  {
    $compte1= new c_samba;
    $compte1->set_login($_POST['login']);
    $compte1->set_passwd($_POST['pass1']);
    $compte1->set_expire($_POST['date']);
    $compte1->set_date(date("Y-m-d"));
    $compte1->set_coduser($_POST['coduser']);
    $compte1->create_account();

  } */
//  if ( (!empty($_POST['un_prec']))&& $verifbool)
  if ($verifbool)
  {
    $compte2= new c_unix;
    $compte2->set_login($_POST['login']);
    $compte2->set_passwd($_POST['pass1']);
    $compte2->set_uid     ($_POST['uid']);
    $compte2->set_gid     ($_POST['gid']);
    $compte2->set_class   ($_POST['class']);
    $compte2->set_change  ($_POST['change']);
    $compte2->set_expire  ($_POST['expire']);
    $compte2->set_gecos   ($_POST['gecos']);
    $compte2->set_homedir ($_POST['homedir']);
    $compte2->set_shell   ($_POST['shell']);
//    $compte2->set_coduser ($_POST['coduser']);
    $compte2->set_coduser ($_POST['coduser']);
    $compte2->set_status_usuario ($_POST['status_usuario']);
    $compte2->set_tipo_contrato ($_POST['tipo_contrato']);
    $compte2->create_account();

  }
/*  if ( (!empty($_POST['si_prec']))&& $verifbool)
  {
    $compte3= new c_admin;
    $compte3->set_login($_POST['login']);
    $compte3->set_passwd($_POST['pass1']);
    $compte3->set_coduser($_POST['coduser']);
    $compte3->create_account();

    $query4="select idmodule from module";
    $result4=pg_query($query4);
    $i=0;
    foreach($_POST['droits']as $arr)
    {
      $sl=db_fetch_array($result4,$i);
      //$query3="insert into permission values('".$compte3->get_login()."',".$sl['idmodule'].",".$arr.")";
      $query3="update permission set permission=".$arr." where login='".$compte3->get_login()."' and idmodule=".$sl['idmodule'];
      $result3=pg_query($query3);
      $i+=1;
    }

  } */
?>
<html>
  <header>
    <link type="text/css" rel="stylesheet" href="../../global/grafic.css">
  </header>
  <body>
    <table class=big>
    <tr>
      <td class=header align=center>
        <h1>Criacao de conta</h1>
      </td>
    </tr>
    <tr>
     <td align=center>
       <table class=form>
       <tr>
       </tr>
       <tr>
         <td align=center>
<?php
       if ($verifbool)
        {
	// faz o alias
	$alias=gera_alias($_POST['coduser']);
	if (checa_alias($alias)!="ok") $alias=$alias."_0";
	while (checa_alias($alias)!="ok") 
	      {
	      $alias=$alias."0";
	      }
    	grava_alias($_POST['coduser'],$alias);
	echo "A conta foi criada com sucesso. Voce pode acessa-la<br> e usar o sistema.<br>Para voltar ao inicio <a href='../../global/accueil.php'>clique aqui</a>. <br>";
        echo "<td class=header align=center>A conta foi criada: </td> Seu novo email &eacute; ".$_POST['login']."@mat.unb.br e/ou ".$alias."@mat.unb.br";
	}
		else
		{
			?>
  			<table class=form>
   			<form method=POST name="utilisateur2" action='add_user3_novo.php' onsubmit="return verif_pass();">
  			<tr>
			<input type=hidden name='uid' value="<?php echo h($_POST['uid']) ?>">
			<input type=hidden name='gid' value="<?php echo h($_POST['gid']) ?>">
			<input type=hidden name='class' value="<?php echo h($_POST['class']) ?>">
			<input type=hidden name='change' value="<?php echo h($_POST['change']) ?>">
			<input type=hidden name='expire' value="<?php echo h($_POST['expire']) ?>">
			<input type=hidden name='gecos' value="<?php echo h($_POST['gecos']) ?>">
			<input type=hidden name='homedir' value="<?php echo h($_POST['homedir']) ?>">
			<input type=hidden name='shell' value="<?php echo h($_POST['shell']) ?>">
			<input type=hidden name='coduser' value="<?php echo h($_POST['coduser']) ?>">
			<input type=hidden name='status_usuario' value="<?php echo h($_POST['status_usuario']) ?>">
			<input type=hidden name='tipo_contrato' value="<?php echo h($_POST['tipo_contrato']) ?>">
      			<! td class=header align=center colspan=2>
        		<h1>O login fornecido j&aacute; existe</h1><br>Informa&ccedil;&otilde;es sobre a conta
      			<!/td>
    			</tr>
			<tr>
      			<td align=center>
       			Por favor, escolha um outro<b>Nome de usuario</b>:
        		<input type=text name='login' maxlength=10 onkeypress="return verif_log(event);">
      			</td>
    			</tr>
     			<tr>
      			<td align=center>
	        	Uma <b>Senha</b>:
        		<input type=password name=pass1 maxlength=8>
        		e <b>confirme</b> :
        		<input type=password name=pass2 maxlength=8>
      			</td>
    			</tr>
    			<tr>
      			<td align=center>
        		<input type=submit value='Cadastrar'>
      			</td>
    			</tr>
			</form>
        		</table>
    <?php } ?>
         </td>
       </tr>
       </table>
     </td>
    </tr>
    </table>
  </body>
</html>
<?php
  db_close($idconn);
?>
