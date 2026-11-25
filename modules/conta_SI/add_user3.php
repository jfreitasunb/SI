<?php
  require("head_conta_SI.php");
  exige_post();
  exige_escrita();
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

  $novo_login = isset($_POST['login']) ? trim((string)$_POST['login']) : '';
  if ($novo_login === '' || strtolower($novo_login) === 'root' || empty($_POST['pass1'])) {
      http_response_code(400);
      die(error("Login ou senha invalidos."));
  }

  $resverif1=db_query("select * from admin where login=?", array($novo_login));
  $countverif1=db_num_rows($resverif1);
  $resverif2=db_query("select * from unix where login=?", array($novo_login));
  $countverif2=db_num_rows($resverif2);

 if (($countverif1==0) and ($countverif2==0))
    $verifbool=true;
  else 
    $verifbool=false;

 if ($verifbool)  
  {
    $compte3= new c_admin;
    $compte3->set_login($novo_login);
    $compte3->set_passwd($_POST['pass1']);
    $compte3->set_coduser($_POST['coduser']);
    $compte3->create_account();
    
    $result4=db_query("select idmodule from module");
    $i=0;
    foreach($_POST['droits'] as $arr)
    {
      if (!in_array((string)$arr, array('0', '1', '2'), true)) continue;
      $sl=db_fetch_array($result4,$i);
      if (!$sl) break;
      $result3=db_query("update permission set permission=? where login=? and idmodule=?", array((int)$arr, $compte3->get_login(), $sl['idmodule']));
      $i+=1;
    }

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
		echo "A conta foi criada com sucesso. Voce pode acessa-la<br> e usar o sistema.<br>Para voltar ao inicio <a href='../../global/accueil.php'>clique aqui</a>. <br>";       
		}
       else
  		{
		?>
		<table class=form>
		<form method=POST name="utilisateur2" action='add_user3.php' onsubmit="return verif_pass();">
		<tr>
		<?php
		    $i=0;
		    foreach($_POST['droits'] as $arr)
		    {
		?>
		   <input type=hidden name='droits[]' value="<?php echo h($arr) ?>">
		<?php
		      $i+=1;
		    }
		?>
		<input type=hidden name='coduser' value="<?php echo h($_POST['coduser']) ?>">
		<! td class=header align=center colspan=2>
       		<h1>O login fornecido j&aacute; existe</h1>
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
  $idconn = null;
?>
