<?php
$lang="pt_BR";
//require("muda_senha/libs.php");
//require("muda_senha/forms.php");
require("muda_senha/pgsql.php");
//require("muda_senha/header.php");

$submit 	  = trim(addslashes($_POST['submit']));
// O login vai para o banco via Prepared Statement; as senhas mantem o addslashes
// por compatibilidade com os hashes ja gravados (nao e usado em SQL).
$usuario 	  = trim($_POST['usuario']);
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
     $res = db_query("select login,passwd,erro,erro_data from unix where login=?", array($usuario), $con);
   
     $msg="Dados Invalidos!";
   
     if (login_bloqueado($usuario)) {
        $msg = login_msg_bloqueio();
     } elseif($res->rowCount()==1 ){
           $linha = $res->fetch(PDO::FETCH_NUM);
           $senhaBD = $linha[1];
	   $qtErros = $linha[2];
	   $timeErro = $linha[3];
   
	   if($qtErros>=5){
                $msg="Conta bloqueada por excesso de tentativas frustradas. Entre em contato com o CPD.";
           } elseif(hash_equals((string)$senhaBD, (string)crypt($senhaatual,$senhaBD))) {
              login_sucesso($usuario);
   
              // Hora de mudar a senha
              $res = db_query("update unix set passwd=? where login=?", array(cripta_senha_unix($senhanova), $usuario), $con);
   
              $msg="Senha alterada com sucesso! Estara atualizada em no maximo 15 minutos.";
          }else {
	      login_falhou($usuario);
	      if($timeErro + 60*10 > time()){
                 $res = db_query("update unix set erro= erro+1,erro_data=? where login=?", array(time(), $usuario), $con);
               }else {
                 $res = db_query("update unix set erro=1,erro_data=? where login=?", array(time(), $usuario), $con);
               } 
          } 
     } else {
        login_falhou($usuario);
     }
   }
}

?>

<HTML>
<HEAD>
</HEAD>
<BODY onload="document.form1.usuario.focus();">

<FORM name="form1" method="POST" action="<?php echo $PHP_SELF;?>">

<h2> Alteracao de Senha de usuarios </h2>

<h3>
<font color="red"><?php echo $msg;?></font>
</h3>

<table border="0">
<tr>
  <td> Usuario: </td>
  <td> <INPUT type="TEXT" name="usuario" value="<?php echo htmlspecialchars($usuario);?>"> </td>
</tr>
<tr>
  <td> Senha Atual: </td>
  <td> <INPUT type="password" name="senhaatual" autocomplete="off"> </td>
</tr>
<tr>
  <td> Senha Nova: </td>
  <td> <INPUT type="password" name="senhanova" autocomplete="off"> </td>
</tr>
<tr>
  <td> Confirmacao da Senha Nova: </td>
  <td> <INPUT type="password" name="senhaconfirmacao" autocomplete="off"> </td>
</tr>
<tr>
  <td> </td>
  <td> <input type="submit" value="Alterar" name="submit"> </td>
</tr>

</table>

</FORM>

</BODY>
</HTML>

