<?php
$lang="pt_BR";
require_once(dirname(__FILE__).'/global/sessao_cookie.php');
session_start();
//require("muda_senha/libs.php");
//require("muda_senha/forms.php");
require("muda_senha/pgsql.php");
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
   
     $res = db_query("select login,passwd,tabela_user from unix where login=?", array($usuario), $con);
   
//     $msg="Dados Invalidos!";
   
     if (login_bloqueado($usuario)) { echo login_msg_bloqueio(); }
     elseif($res->rowCount()==1 )
	{
           $linha = $res->fetch(PDO::FETCH_NUM);
           $senhaBD = $linha[1];
	   $tipo_usuario=$linha[2];
 
		$senha_ok = hash_equals((string)$senhaBD, (string)crypt($senhaatual,$senhaBD));
		if ($senha_ok) login_sucesso($usuario);
		if($senha_ok and ($tipo_usuario=="fonctionnaire")) //:so permite acesso a professores e administrativos
		{
            session_regenerate_id(true);
            $_SESSION['autenticado'] = true;
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
	        echo "  <h1>Buscar Resolu&ccedil;&atilde;o</h1>
	                <p> Escolha abaixo os crit&eacute;rios da busca. </p> ";
		?>
	<form action='http://si.mat.unb.br/ler_resolucoes/visualiza_resolucoes_finais.php' method='post'>
<table><br>
        
    <tr>
    <td><b>Por ata:</b></td><td><input type="text" name="ata" maxlength="10" size="5"></td>
    </tr>
    <tr>
    <td><b>Assunto:</b></td><td><input type="text" name="assunto" maxlength="40"></td>
    </tr>
    <tr>
    <td><b>N&uacute;mero da resolu&ccedil;&atilde;o:</b></td><td><input type="text" name="numero_resolucao" maxlength="3" size="2"></td>
    </tr>
    <tr>
    <td><b>Ano:</b></td><td><input type="text" name="anoresolucao" maxlength="5" size="2">
    </tr>
        
</table><br>
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

<h2> Login e Senha do usuarios </h2>

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

