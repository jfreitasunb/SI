<?php
$lang="pt_BR";
require_once(dirname(__FILE__).'/global/sessao_cookie.php');
session_start();
require("muda_senha/pgsql.php");
csrf_valida();
csrf_token();

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
     $res = db_query("select login,passwd,tabela_user from unix where login=?", array($usuario), $con);
     if (login_bloqueado($usuario)) { $msg = login_msg_bloqueio(); }
     elseif($res->rowCount()==1 )
	{
           $linha = $res->fetch(PDO::FETCH_NUM);
           $senhaBD = (string)$linha[1];
	   $tipo_usuario=$linha[2];
 
		$senha_ok = ($senhaBD !== '') && hash_equals($senhaBD, (string)crypt($senhaatual,$senhaBD));
		if ($senha_ok) login_sucesso($usuario);
		if($senha_ok and ($tipo_usuario=="fonctionnaire")) //:so permite acesso a professores e administrativos
		{
			session_regenerate_id(true);
			$_SESSION['ler_atas_autenticado'] = true;
			$_SESSION['csrf_token'] = bin2hex(random_bytes(32));
              // Hora de solicitar documentos
//              SOLICITAR O DOCUMENTO A SER LIDO
//	php 
//	include("conecta.php"); 
	?>
	<html>
	<header>
	    <script language=javascript src="function_js.js">
	    </script>
	    <script language=javascript src="formu.js">
	    </script>
	    <link type="text/css" rel="stylesheet" href="../../global/grafic.css">
	<meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
	  </header>
	<body>
	<table class=big>
	      <tr>
	        <td class=header align=center>
	          <h1>Departamento de Matematica</h1>
	        </td>
	      </tr>
	      <tr>
	        <td align=center>
	               <title>Servidor Administrativo</title>
	<?php
	        echo "  <h1>Buscar Documento</h1>
	                <p> Escolha abaixo o tipo de documento a ser encontrado. </p> ";
		?>
	<form action='/leratas/buscador_lista_def.php' method='post'>
	<?php echo csrf_campo(); ?>
	<table><br>
	        <tr>
	        <td><b>Palavra chave:</b></td><td><input type="text" name="chave" maxlength="40"></td>
	        </tr>
	        <tr>
	        <td><b>N&uacute;mero da reuni&atilde;o:</b></td><td><input type="text" name="numeroreuniao" maxlength="5"></td>
	        </tr>
	        <tr>
	        <td><b>Data da reuni&atilde;o:</b></td><td><input type="text" name="dia" maxlength="2" size="1">/<input type="text" name="mes" maxlength="2" size="1">/<input type="text" name="ano" maxlength="4" size="2"></td>
        </tr>
	</table><br>
	<table>
	        <input type='submit' name='busca' value='Buscar'>
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

if (empty($_SESSION['ler_atas_autenticado']) || $msg !== '')
{
?>
<HTML>
<HEAD>
</HEAD>
<BODY onload="document.form1.usuario.focus();">

<FORM name="form1" method="POST" action="">
<?php echo csrf_campo(); ?>

<h2> Login e Senha do usuarios </h2>

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

