<?php
  require("head_account.php");
  include("gera_senha.php");
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

  $queryverif1="select * from admin where login=?"; $queryverif1__p = array($_POST['login_novo']);
  $queryverif2="select * from unix where login=?"; $queryverif2__p = array($_POST['login_novo']);

  $resverif1=db_query($queryverif1, $queryverif1__p);
  $resverif2=db_query($queryverif2, $queryverif2__p);
  $countverif1=db_num_rows($resverif1);
  $countverif2=db_num_rows($resverif2);

  if (($countverif2==0) and ($countverif1==0))
    $verifbool=true;
  else 
    $verifbool=false;

  if ($verifbool)
  {
   $pass1=generatePassword();
	if ($_POST['login']=='student')
	{
	$query_contrato="select formation from student where coduser=?"; $query_contrato__p = array($_POST['coduser']);
	$contrato=db_query($query_contrato, $query_contrato__p);
	$tipo_contrato=db_fetch_array($contrato,0);
	}
    $compte2= new c_unix;
    $compte2->set_login($_POST['login_novo']);
    $compte2->set_passwd($pass1);
//    $compte2->set_uid     ($_POST['uid']);
//   $compte2->set_gid     ($_POST['gid']); 
//    $compte2->set_class   ($_POST['class']);
//    $compte2->set_change  ($_POST['change']);
//    $compte2->set_expire  ($_POST['expire']);
//    $compte2->set_gecos   ($_POST['gecos']); 
//    $compte2->set_homedir ($_POST['homedir']); 
//    $compte2->set_shell   ($_POST['shell']);  
    $compte2->set_coduser ($_POST['coduser']);
    $compte2->set_status_usuario ($_POST['login']);
    $compte2->set_tipo_contrato ($tipo_contrato[0]);
    $compte2->create_account();

  }  
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
//	 echo "A conta foi criada com sucesso. Voce pode acessa-la<br> e usar o sistema.<br>Para voltar ao inicio <a href='../../global/accueil.php'>clique aqui</a>. <br>";       
//         echo "<td class=header align=center>A conta foi criada: </td> Seu novo email &eacute; ".$_POST['login_novo']."@mat.unb.br  <br>";
//         echo "<td></td> Sua senha &eacute: ".$pass1;
	 ?>
	 <table class=form>	 
	 <form method=POST name="utilisateur" action='imprime_dados_conta.php'>
	 <h1>Cria&ccedil;&atilde;o de Conta:</h1><br>A conta foi criada com sucesso. Voce pode acessa-la<br> e usar o sistema.<br>Para voltar ao inicio <a href='../../global/accueil.php'>clique aqui</a>. <br>
	 <tr>
         <td align=center>
         <input type=hidden name="coduser" value="<?php echo h($_POST['coduser']); ?>">
         <input type=hidden name="senha" value="<?php echo $pass1; ?>">
         <input type=submit value="Imprimir dados da conta">
         </td>
         </tr>
	 <tr>
         <td align=center>
         <input type=submit value='Imprimir dados da Conta'>
         </td>
         </tr>
         </table>
         </form>
	 <?php
	}
       else
	{
	?>
	<table class=form>
	<!form method=POST name="utilisateur2" action='add_user4.php' onsubmit="return verif_pass();">
	<form method=POST name="utilisateur2" action='add_user4.php'>
	<tr>
<?php/*	<input type=hidden name='uid' value="<?php echo h($_POST['uid']) ?>">
	<input type=hidden name='gid' value="<?php echo h($_POST['gid']) ?>">
	<input type=hidden name='class' value="<?php echo h($_POST['class']) ?>">
	<input type=hidden name='change' value="<?php echo h($_POST['change']) ?>">
	<input type=hidden name='expire' value="<?php echo h($_POST['expire']) ?>">
	<input type=hidden name='gecos' value="<?php echo h($_POST['gecos']) ?>">
	<input type=hidden name='homedir' value="<?php echo h($_POST['homedir']) ?>">
	<input type=hidden name='shell' value="<?php echo h($_POST['shell']) ?>">
*/ ?>
	<input type=hidden name='coduser' value="<?php echo h($_POST['coduser']) ?>">
	<input type=hidden name='login' value="<?php echo h($_POST['login']) ?>">
	<input type=hidden name='tipo_contrato' value="<?php echo $tipo_contrato[0] ?>">
	<! td class=header align=center colspan=2>
	<h1>O login fornecido j&aacute; existe</h1><br>Informa&ccedil;&otilde;es sobre a conta
	<!/td>
	</tr>
	<tr>
	<td align=center>Por favor, escolha um outro<b>Nome de usuario</b>:
        <input type=text name='login_novo' maxlength=10 onkeypress="return verif_log(event);">
      	</td>
    	</tr>
<?php /*
     	<tr>
      	<td align=center>Uma <b>Senha</b>:<input type=password name=pass1 maxlength=8>
        		e <b>confirme</b> :<input type=password name=pass2 maxlength=8>
	</td>
	</tr>
*/ ?>
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
