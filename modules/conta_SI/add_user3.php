<?php
  require("head_conta_SI.php");
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

  $resverif1=db_query("select * from admin where login=?", array($_POST['login']));
  $countverif1=db_num_rows($resverif1);
  $resverif2=db_query("select * from unix where login=?", array($_POST['login']));
  $countverif2=db_num_rows($resverif2);

 if (($countverif1==0) and ($countverif2==0))
    $verifbool=true;
  else 
    $verifbool=false;

 if ($verifbool)  
  {
    $compte3= new c_admin;
    $compte3->set_login($_POST['login']);
    $compte3->set_passwd($_POST['pass1']);
    $compte3->set_coduser($_POST['coduser']);
    $compte3->create_account();
    
    $result4=db_query("select idmodule from module");
    $i=0;
    foreach($_POST['droits'] as $arr)
    {
      $sl=db_fetch_array($result4,$i);
      $result3=db_query("update permission set permission=? where login=? and idmodule=?", array($arr, $compte3->get_login(), $sl['idmodule']));
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
		   <input type=hidden name='droits[]' value="<?php echo $arr ?>">
		<?php
		      $i+=1;
		    }
		?>
		<input type=hidden name='coduser' value="<?php echo $_POST['coduser'] ?>">
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
