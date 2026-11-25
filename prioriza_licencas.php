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
// CSRF: valida o POST de login e injeta o token nos formularios.
csrf_valida();
csrf_token();
ob_start('csrf_injeta');
//require("estudos/formulario1.php");
//require("muda_senha/header.php");

$submit           = isset($_POST['submit']) ? trim((string)$_POST['submit']) : '';
$usuario          = isset($_POST['usuario']) ? trim((string)$_POST['usuario']) : '';
$senhaatual       = isset($_POST['senhaatual']) ? trim(addslashes((string)$_POST['senhaatual'])) : '';
$msg = '';
$msgErro = "Usuario ou senha invalidos.";

if(strlen($submit)>0)
{
   if(strlen($usuario)==0 || strlen($senhaatual)==0)
	{
	$msg = $msgErro;
	}
   else {
     $res = db_query("select login,passwd,tabela_user,coduser from unix where login=?", array($usuario), $con);
     if (login_bloqueado($usuario)) { $msg = login_msg_bloqueio(); }
     elseif($res->rowCount()==1 )
	{
           $linha = $res->fetch(PDO::FETCH_NUM);
           $senhaBD = (string)$linha[1];
	   $tipo_usuario=$linha[2];
	   $coduser=$linha[3];
 
		$senha_ok = ($senhaBD !== '') && hash_equals($senhaBD, (string)crypt($senhaatual,$senhaBD));
		if ($senha_ok) login_sucesso($usuario);
		// Restringe priorizacao de licencas a servidores/professores (fonctionnaire).
		if($senha_ok && ($tipo_usuario=="fonctionnaire"))
		{
		// identifica o professor para as paginas de estudos/ (priorizacao/)
		session_regenerate_id(true);
		$_SESSION['priori_coduser'] = $coduser;
		$_SESSION['csrf_token'] = bin2hex(random_bytes(32));
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
	<tr><td align=center><input type=hidden name='usuario' value="<?php echo h($coduser);?>"></td></tr>
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
	        if (!$senha_ok) login_falhou($usuario);
	        $msg = $msgErro;
	        } 
     	}
	else { crypt($senhaatual, '$6$abcdefghijklmnop$'); login_falhou($usuario); $msg = $msgErro; } 
   }
}

if (empty($_SESSION['priori_coduser']) || $msg !== '')
{
?>
<HTML>
<HEAD>
</HEAD>
<BODY onload="document.form1.usuario.focus();">

<FORM name="form1" method="POST" action="">

<h2> Formul&aacute;rio para prioriza&ccedil;&atilde;o de licen&ccedil;as do MAT/UnB </h2>

<h3>
<font color="red"><?php echo h($msg);?></font>
</h3>

<table border="0">
<tr>
  <td> Usuario: </td>
  <td> <INPUT type="TEXT" name="usuario" value="<?php echo h($usuario);?>"> </td>
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

