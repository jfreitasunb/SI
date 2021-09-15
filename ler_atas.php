<?php
$lang="pt_BR";
//require("muda_senha/libs.php");
//require("muda_senha/forms.php");
require("muda_senha/pgsql.php");
//require("muda_senha/header.php");

$submit           = trim(addslashes($_POST['submit']));
$usuario          = trim(addslashes($_POST['usuario']));
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
   
     $res = pg_query("select login,passwd,tabela_user from unix where login='$usuario'");
   
//     $msg="Dados Invalidos!";
   
     if(pg_num_rows($res)==1 )
	{
           $senhaBD = pg_result($res,0,1);
	   $tipo_usuario=pg_result($res,0,2);
 
		if((crypt($senhaatual,$senhaBD) == $senhaBD) and ($tipo_usuario=="fonctionnaire")) //:so permite acesso a professores e administrativos
		{
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
	<form action='http://si.mat.unb.br/leratas/buscador_lista_def.php' method='post'>
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
	        echo $msgS;       
	        } 
     	}
	else echo $msgL; 
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
  <td> <INPUT type="TEXT" name="usuario" value="<?php echo $usuario;?>"> </td>
</tr>
<tr>
  <td> Senha: </td>
  <td> <INPUT type="password" name="senhaatual" value="<?php echo $senhaatual;?>"> </td>

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

