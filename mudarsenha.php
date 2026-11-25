<?php
$lang="pt_BR";
require_once(dirname(__FILE__).'/global/sessao_cookie.php');
session_start();
require("muda_senha/pgsql.php");
csrf_valida();
csrf_token();

$submit 	  = isset($_POST['submit']) ? trim((string)$_POST['submit']) : '';
// O login vai para o banco via Prepared Statement; as senhas mantem o addslashes
// por compatibilidade com os hashes ja gravados (nao e usado em SQL).
$usuario 	  = isset($_POST['usuario']) ? trim((string)$_POST['usuario']) : '';
$senhaatual 	  = isset($_POST['senhaatual']) ? trim(addslashes((string)$_POST['senhaatual'])) : '';
$senhanova        = isset($_POST['senhanova']) ? trim(addslashes((string)$_POST['senhanova'])) : '';
$senhaconfirmacao = isset($_POST['senhaconfirmacao']) ? trim(addslashes((string)$_POST['senhaconfirmacao'])) : '';
$msg = '';

if(strlen($submit)>0){
   if(strlen($usuario)==0 || strlen($senhaatual)==0){
     $msg="Usuario ou senha invalidos.";
   }elseif(strlen($senhanova)<8){
     $msg="Senha nova muito curta, coloque pelo menos 8 caracteres.";
   }elseif(strcmp($senhanova,$senhaconfirmacao)!=0){
     $msg="Confirmacao da senha nao confere.";
   } else {
     $res = db_query("select login,passwd,erro,erro_data from unix where login=?", array($usuario), $con);
     $msg="Usuario ou senha invalidos.";

     if (login_bloqueado($usuario)) {
        $msg = login_msg_bloqueio();
     } elseif($res->rowCount()==1 ){
           $linha = $res->fetch(PDO::FETCH_NUM);
           $senhaBD = (string)$linha[1];
           $qtErros = (int)$linha[2];
           $timeErro = (int)$linha[3];
           $janelaExpirada = ($timeErro + 60*15) <= time();

           if(!$janelaExpirada && $qtErros>=5){
                $msg = login_msg_bloqueio();
           } elseif($senhaBD !== '' && hash_equals($senhaBD, (string)crypt($senhaatual,$senhaBD))) {
              login_sucesso($usuario);
              // Hora de mudar a senha (zera contador de erros).
              db_query("update unix set passwd=?, erro=0, erro_data=0 where login=?", array(cripta_senha_unix($senhanova), $usuario), $con);
              $msg="Senha alterada com sucesso! Estara atualizada em no maximo 15 minutos.";
          }else {
              login_falhou($usuario);
              if(!$janelaExpirada){
                 db_query("update unix set erro=erro+1, erro_data=? where login=?", array(time(), $usuario), $con);
               }else {
                 db_query("update unix set erro=1, erro_data=? where login=?", array(time(), $usuario), $con);
               } 
          } 
     } else {
        // Dummy hash para evitar oracle de temporizacao.
        crypt($senhaatual, '$6$abcdefghijklmnop$');
        login_falhou($usuario);
     }
   }
}

?>

<HTML>
<HEAD>
</HEAD>
<BODY onload="document.form1.usuario.focus();">

<FORM name="form1" method="POST" action="">
<?php echo csrf_campo(); ?>

<h2> Alteracao de Senha de usuarios </h2>

<h3>
<font color="red"><?php echo h($msg);?></font>
</h3>

<table border="0">
<tr>
  <td> Usuario: </td>
  <td> <INPUT type="TEXT" name="usuario" value="<?php echo h($usuario);?>"> </td>
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

