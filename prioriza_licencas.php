<?php
$lang="pt_BR";
require_once(dirname(__FILE__).'/global/sessao_cookie.php');
session_start();


//require("muda_senha/libs.php");
//require("muda_senha/forms.php");
require("estudos/pgsql.php");
if (!function_exists('db_connect')) {
   require_once(dirname(__FILE__).'/global/function_php.php'); // login_bloqueado() etc.
}
//require("estudos/formulario1.php");
//require("muda_senha/header.php");

$submit           = trim(addslashes($_POST['submit']));
// O login vai para o banco via Prepared Statement (sem addslashes).
$usuario          = trim($_POST['usuario']);
$senhaatual       = trim(addslashes($_POST['senhaatual']));

$msgL="Login invalido.";
$msgS="Senha atual invalida.";

if(strlen($submit)>0)
{
  sleep(1);

   if(strlen($usuario)==0)
	{
	echo $msgL;
   	}
   elseif(strlen($senhaatual)==0)
	{
        echo $msgS;
        }
   else {
   
     $res = db_query("select login,passwd,tabela_user,coduser from unix where login=?", array($usuario), $con);
   
//     $msg="Dados Invalidos!";
   
     if (login_bloqueado($usuario)) { echo login_msg_bloqueio(); }
     elseif($res->rowCount()==1 )
	{
//	echo "estou aqui";
           $linha = $res->fetch(PDO::FETCH_NUM);
           $senhaBD = $linha[1];
	   $tipo_usuario=$linha[2];
	   $coduser=$linha[3];
 
		if(hash_equals((string)$senhaBD, (string)crypt($senhaatual,$senhaBD))) //:permite acesso a todos
		{
		login_sucesso($usuario);
		// identifica o professor para as paginas de estudos/ (priorizacao/)
		session_regenerate_id(true);
		$_SESSION['priori_coduser'] = $coduser;
                //echo abre formulario para fornecer semestre/ano/ se quer relatorio ou se quer incluir.
		$ano=date("Y");
//----------------------------  Inserir preferencias
?>
<html>
<header>
<link type="text/css" rel="stylesheet" href="../../global/grafic.css">
<meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
</header>

<body>
<table class=big>
   <form method="POST" name="formu" action="estudos/formulario1.php">
      <tr>
        <td class=header align=center colspan=2>
        <h1>Informa&ccedil;&otilde;es para prioriza&ccedil;&atilde;o de licen&ccedil;as do MAT/UnB</h1>
        </td>
      </tr>
     <tr><table><tr><td align=center>Escolha uma opção: <b></td></tr> 
     <tr><td align=center><b> Um semestre/ano para inclus&atilde;o/atualiza&ccedil;&atilde;o de atividades: </b><select name='semestre'>
														  <option value=0 selected>--</option> 
														  <option value=1>1</option> 
														  <option value=2>2</option>
														</select>
														<select name='ano'>
														  <option value=0 selected>--</option> 
														<?php 
														for ($i=$ano;$i>$ano-8;$i=$i-1)
															{
															echo "<option value=\"".$i."\">".$i."</option>";
															}
														?>
														</select></td></tr>
     <tr><td align=center><b> Um per&iacute;odo para emiss&atilde;0 de relat&oacute;rio: </b> de <select name='semestre_inicio'>
														  <option value=0 selected>--</option> 
														  <option value=1>1</option> 
														  <option value=2>2</option>
														</select>
														<select name='ano_inicio'>
														  <option value=0 selected>--</option> 
														<?php 
														for ($i=$ano;$i>$ano-8;$i=$i-1)
															{
															echo "<option value=\"".$i."\">".$i."</option>";
															}
														?>
														</select> a 
														<select name='semestre_fim'>
														  <option value=0 selected>--</option> 
														  <option value=1>1</option> 
														  <option value=2>2</option>
														</select>
														<select name='ano_fim'>
														  <option value=0 selected>--</option> 
														<?php 
														for ($i=$ano;$i>$ano-8;$i=$i-1)
															{
															echo "<option value=\"".$i."\">".$i."</option>";
															}
														?>
														</select></td></tr>
	<tr><td align=center><input type=submit name='selecao1' value='Confirmar'></td></tr>
	<tr><td align=center><input type=hidden name='usuario' value="<?php echo $coduser;?>"></td></tr>
	</table>
	</form>
	</table>
	</body>
	</html>
<?php		
		// FIM solicitar arquivo
 	         }
		else 
		{
	        login_falhou($usuario);
	        echo $msgS;       
	        } 
     	}
	else { login_falhou($usuario); echo $msgL; } 
   }
}

if (!isset($_POST['submit']))
{
?>
<HTML>
<HEAD>
</HEAD>
<BODY onload="document.form1.usuario.focus();">

<FORM name="form1" method="POST" action="<?php echo $PHP_SELF;?>">

<h2> Formul&aacute;rio para prioriza&ccedil;&atilde;o de licen&ccedil;as do MAT/UnB </h2>

<h3>
<font color="red"><?php echo $msg;?></font>
</h3>

<table border="0">
<tr>
  <td> Usuario: </td>
  <td> <INPUT type="TEXT" name="usuario" value="<?php echo htmlspecialchars($usuario);?>"> </td>
</tr>
<tr>
  <td> Senha: </td>
  <td> <INPUT type="password" name="senhaatual" autocomplete="off"> </td>
</tr>
<tr>
  <td> </td>
  <td> <input type="submit" value="Confirmar" name="submit"> </td>
</tr>

</table>

</FORM>

</BODY>
</HTML>
<?php
}
?>

