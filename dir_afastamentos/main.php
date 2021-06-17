<?php
$lang="pt_BR";
//require("muda_senha/libs.php");
//require("muda_senha/forms.php");
require("../muda_senha/pgsql.php");

//include("dir_escolha_prof/atuacao_noturno.php");

//require("muda_senha/header.php");
//if(isset ($_POST['submit']))
//{
$submit           = trim(addslashes($_POST['submit']));
$usuario          = trim(addslashes($_POST['usuario']));
$senhaatual       = trim(addslashes($_POST['senhaatual']));

$msgL="Login invalido.";
$msgS="Senha atual invalida.";
//}

if (isset($_GET['professor'])) $prof_get=$_GET['professor']; else unset($prof_get);


if((strlen($submit)>0) or isset($prof_get))
{
  sleep(1);
   
   if((strlen($usuario)==0) and (!isset($prof_get)))
	{
	echo $msgL;
   	}
   else if((strlen($senhaatual)==0) and (!isset($prof_get)))
	{
        echo $msgS;
        }
	
   else {
   	if (isset($prof_get)) $res = pg_query("select login,passwd,tabela_user,coduser from unix where md5(coduser)='".$prof_get."'"); else 
     $res = pg_query("select login,passwd,tabela_user,coduser from unix where login='$usuario'");
   
//     $msg="Dados Invalidos!";
   
     if(pg_num_rows($res)==1 )
	{
           $senhaBD = pg_result($res,0,1);
	   $tipo_usuario=pg_result($res,0,2);
		if(((crypt($senhaatual,$senhaBD) == $senhaBD) and ($tipo_usuario=="fonctionnaire")) or (isset($prof_get))) //:so permite acesso a professores e administrativos
		{

 	        $professor=pg_result($res,0,3);
              // Hora de solicitar documentos
//              SOLICITAR DISCILPINAS
//$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$
?>

<html>
	<meta charset="UTF-8" />
	
	
		<head>
			<title> Licenças e Afastamentos </title>
			<script type="text/javascript" src="http://cdn.mathjax.org/mathjax/latest/MathJax.js?config=TeX-AMS-MML_HTMLorMML">
			</script>
		</head>
	
	<body>
		
	
	<form method="POST" enctype="multipart/form-data" action ="recebe_sugestao.php">
		
		<h2 align="center">Lista de sugestões de diretrizes gerais para priorização de pedidos de Licença para Capacitação e afastamento de longa duração						 </h2> 
		<hr>
		<p>
		<table cellpadding="2" align="left" border="0">
			
			<tr>  
			<td align="left" width="25%"> 
			<ul style="list-style: none; ">
			<!-- <li> <a href="todas_sugestoes.php?professor=<?php echo md5($professor);?>">Ver todas as sugestões</a>. </li> -->
			<br>
			<li> <a href="minhas_sugestoes.php?professor=<?php echo md5($professor);?>">Ver/Atualizar minhas sugestões</a>. </li>
			<br>
			<br>
			<li align="left"> <a href="logout.php"; title="Logout"><img alt="Logout" border="0" src="sair.png" width="50" /></a> </li>
			</ul> 
			</td>
				


			<td> 
					
			<table width="75%"> 
							
				<tr>
				<td>
				Use a caixa de texto abaixo para enviar sua sugestão de diretrizes gerais para priorização de 
				pedidos de Licença para Capacitação e afastamento de longa duração 
				(pós doutorado, visitas técnicas, entre outros).
				<br>
				&#160			
				</td>
				</tr>
							
							
							
				<tr> 
				<td>
				<textarea style="background:#F3FFFD" name="sugestao" rows="20" cols="100%" > </textarea>
				</td>
				</tr>	
				
			
			
						
				<tr> 
				<td align="right">
				<input type=hidden name="professor" value="<?php echo $professor;?>"> 
				<input  type="submit" name="enviar" value="Enviar sugestão">
				</td>
				</tr>
			</table>
					
			</td>
				
			</tr>
	
		</table>
		</p>
	
	
	<!-- <p align="left">
		<b> Atenção: </b> esta página receberá sugestões até  às 00:00h do dia DD/MM/AA.
	</p>
	-->
	</form>
	
	
	</body>


</html>
<?php
// FIM solicitar arquivo
		pg_close($con);
 	         }
		else 
		{
	        echo $msgS;       
	        } 
     	}
	else echo $msgL; 
   }
}

if (!isset($_POST['submit']) and !isset($prof_get))
{
//if ((date(j)<16) and (date(n)==5) and (date(Y)==2012))
if (date(Y)==2012)
{
?>
<HTML>
<HEAD>
</HEAD>
<BODY onload="document.form1.usuario.focus();">

<FORM name="form1" method="POST" action="<?php=$PHP_SELF;?>">

<h2> Login e Senha do usuarios </h2>

<h3>
<font color="red"><?php=$msg;?></font>
</h3>

<table border="0">
<tr>
  <td> Usuario: </td>
  <td> <INPUT type="TEXT" name="usuario" value="<?php=$usuario;?>"> </td>
</tr>
<tr>
  <td> Senha: </td>
  <td> <INPUT type="password" name="senhaatual" value="<?php=$senhaatual;?>"> </td>
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
else echo "op&ccedil;&otilde;es n&atilde;o dispon&iacute;veis";
}
?>

