<?php
$lang="pt_BR";
require("libs.php");
require("forms.php");
require("pgsql.php");
require("header.php");

$submit 	  = trim(addslashes($_POST['submit']));
$usuario 	  = trim(addslashes($_POST['usuario']));
$senhaatual 	  = trim(addslashes($_POST['senhaatual']));
$senhanova        = trim(addslashes($_POST['senhanova']));
$senhaconfirmacao = trim(addslashes($_POST['senhaconfirmacao']));


if(strlen($submit)>0){
  sleep(1);

   if(strlen($usuario)==0){
     $msg="Login invalido.";
   }elseif(strlen($senhaatual)==0){
     $msg="Senha atual invalida.";
   }elseif(strlen($senhanova)==0){
     $msg="Senha nova invalida.";
   }elseif(strlen($senhanova)<6){
     $msg="Senha nova muita curta, coloque pelomenos 6 caracteres.";
   }elseif(strcmp($senhanova,$senhaconfirmacao)!=0){
     $msg="Confirmacao da senha nao confere.";
   } else {
   
     $matricula = substr($usuario,1);
     $res = pg_query("select login,passwd,erro,erro_data from unix where login='$usuario'");
   
     $msg="Dados Invalidos!";
   
     if(pg_num_rows($res)==1 ){
           $senhaBD = pg_result($res,0,1);
	   $qtErros = pg_result($res,0,2);
	   $timeErro = pg_result($res,0,3);
   
	   if($qtErros>=3){
                $msg="Conta bloqueada por excesso de tentativas frustradas. Entre em contato com o CPD.";
           } elseif(crypt($senhaatual,$senhaBD) == $senhaBD) {
   
              // Hora de mudar a senha
              $res = pg_query("update unix set passwd='".crypt($senhanova)."' where login='$usuario' ");
   
              $msg="Senha alterada com sucesso! Estara atualizada em no maximo 15 minutos.";
          }else {
	      if($timeErro + 60*10 > time()){
                 $res = pg_query("update unix set erro= erro+1,erro_data='".time()."'  where login='$usuario' ");
               }else {
                 $res = pg_query("update unix set erro=1,erro_data='".time()."'  where login='$usuario' ");
               } 
          } 
     } 
   }
}

?>

<HTML>
<HEAD>
</HEAD>
<BODY onload="document.form1.usuario.focus();">

<FORM name="form1" method="POST" action="<?php=$PHP_SELF;?>">

<h2> Alteracao de Senha de Alunos de Gradua?o </h2>

<h3>
<font color="red"><?php=$msg;?></font>
</h3>

<table border="0">
<tr>
  <td> Usuario: </td>
  <td> <INPUT type="TEXT" name="usuario" value="<?php=$usuario;?>"> </td>
</tr>
<tr>
  <td> Senha Atual: </td>
  <td> <INPUT type="password" name="senhaatual" value="<?php=$senhaatual;?>"> </td>
</tr>
<tr>
  <td> Senha Nova: </td>
  <td> <INPUT type="password" name="senhanova" value="<?php=$senhanova;?>"> </td>
</tr>
<tr>
  <td> Confirma?o da Senha Nova: </td>
  <td> <INPUT type="password" name="senhaconfirmacao" value="<?php=$senhaconfirmacao;?>"> </td>
</tr>
<tr>
  <td> </td>
  <td> <input type="submit" value="Alterar" name="submit"> </td>
</tr>

</table>

</FORM>

</BODY>
</HTML>

