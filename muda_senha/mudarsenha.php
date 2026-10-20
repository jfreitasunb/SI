<?php
$lang="pt_BR";
require("libs.php");
require("forms.php");
require("pgsql.php");
require("header.php");

// Entrada: apenas trim(). O escape NAO e mais feito com addslashes (ineficaz e
// perigoso no PostgreSQL); as consultas usam prepared statements via db_query().
$submit           = isset($_POST['submit'])           ? trim($_POST['submit'])           : '';
$usuario          = isset($_POST['usuario'])           ? trim($_POST['usuario'])           : '';
$senhaatual       = isset($_POST['senhaatual'])        ? trim($_POST['senhaatual'])        : '';
$senhanova        = isset($_POST['senhanova'])         ? trim($_POST['senhanova'])         : '';
$senhaconfirmacao = isset($_POST['senhaconfirmacao'])  ? trim($_POST['senhaconfirmacao'])  : '';

$msg = '';

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
     $res = db_query("select login,passwd,erro,erro_data from unix where login=?", array($usuario), $con);

     $msg="Dados Invalidos!";

     if(db_num_rows($res)==1 ){
           $senhaBD  = db_result($res,0,1);
	   $qtErros  = db_result($res,0,2);
	   $timeErro = db_result($res,0,3);

	   if($qtErros>=3){
                $msg="Conta bloqueada por excesso de tentativas frustradas. Entre em contato com o CPD.";
           } elseif(hash_equals((string)$senhaBD, (string)crypt($senhaatual,$senhaBD))) {

              // Hora de mudar a senha (hash forte SHA-512, compativel com /etc/shadow)
              $res = db_query("update unix set passwd=?, erro=0 where login=?",
                              array(cripta_senha_unix($senhanova), $usuario), $con);

              $msg="Senha alterada com sucesso! Estara atualizada em no maximo 15 minutos.";
          }else {
	      if($timeErro + 60*10 > time()){
                 $res = db_query("update unix set erro= erro+1,erro_data=? where login=?", array(time(), $usuario), $con);
               }else {
                 $res = db_query("update unix set erro=1,erro_data=? where login=?", array(time(), $usuario), $con);
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

<FORM name="form1" method="POST" action="">

<h2> Alteracao de Senha de Alunos de Gradua&ccedil;&atilde;o </h2>

<h3>
<font color="red"><?php echo h($msg); ?></font>
</h3>

<table border="0">
<tr>
  <td> Usuario: </td>
  <td> <INPUT type="TEXT" name="usuario" value="<?php echo h($usuario); ?>"> </td>
</tr>
<tr>
  <td> Senha Atual: </td>
  <td> <INPUT type="password" name="senhaatual" value=""> </td>
</tr>
<tr>
  <td> Senha Nova: </td>
  <td> <INPUT type="password" name="senhanova" value=""> </td>
</tr>
<tr>
  <td> Confirma&ccedil;&atilde;o da Senha Nova: </td>
  <td> <INPUT type="password" name="senhaconfirmacao" value=""> </td>
</tr>
<tr>
  <td> </td>
  <td> <input type="submit" value="Alterar" name="submit"> </td>
</tr>

</table>

</FORM>

</BODY>
</HTML>
