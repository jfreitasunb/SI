<?php
include("head_inscricao_pos.php");
//include ("../pgsql/pgsql.php");
include("gera_senha.php");

function  manda_mail_login($coduser,$senha)
{
$query_mail=pg_query("select login, name||' '||firstname from inscricao_pos_login, inscricao_pos_dados_candidato where coduser='".$coduser."' and coduser=id_aluno");
$mail0=pg_fetch_row($query_mail);
$email=$mail0[0];
$nome=$mail0[1];
$texto="Prezado(a) ".$nome.",\n Seu login é  ".$email." \n Sua senha é: ".$senha." \n";
$texto=wordwrap($texto,70);
//echo $email;

// mensagem:

$subject ="Inscrições no programa de pós-graduação Mat/UnB: dados para login"; 
echo $email.";<br>".$subject." ;<br> ".$texto." ;<br>".$headers;
$res_mail=mail($email, $subject, $texto,"FROM: posgrad@mat.unb.br \r\n");
if ($res_mail) $devolve="mensagem enviada"; else $devolve="problema no envio de mensagens";

return $devolve;

}

if(!isset($_POST['confirmar']))
{
$query_usuarios=pg_query("select id_aluno, name||' '||firstname as nome from inscricao_pos_dados_candidato order by nome");
//$query_usuarios=pg_query("select coduser,login,id_aluno from inscricao_pos_login, inscricao_pos_contatos_recomendante where status='recomendante' and (emailprofrecomendante1=login or emailprofrecomendante2=login or emailprofrecomendante3=login");
//
?>
</body>
</html>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
	<head>
	<META http-equiv="Content-Type" content="text/html; charset=utf-8">
 <link type="text/css" rel="stylesheet" href="../../global/grafic.css">
	</head>
	

<body >
      <table class=big>
  <form method="POST" name="formu" action="formu_manda_nova_senha.php">
      <tr>
        <td class=header align=center>
<h1>Cadastro para Processo Seletivo do Curso de Ver&atilde;o / P&oacute;s-Gradua&ccedil;&atilde;o <br>
          <h1>Cria&ccedil;&atilde;o/envio de nova senha</h1>
                MAT-UnB <?php echo date("Y")+1;?><br><h1>
        </td>
      </tr>
      <tr>
        <td align=center><table class=form><tr>
    <td colspan=4 class=header align=center>
      <b>Selecione o candidato:</b>
	<select name=usuario>
<?php
	while($registro=pg_fetch_row($query_usuarios))
		{
		echo "<option value=\"".$registro[0]."\">".$registro[1]."</option>";
		}
?>
	</select></td>
          </tr>
	</tr> 
	</table>
	  </td>
	  </tr>
      <tr>
        <td align=center>
          <input type=submit name='confirmar' value="Confirmar">
        </td>
      </form>
</table>
</body>
</html>
<?php
}

if (isset($_POST['confirmar']))
{
$coduser=$_POST['usuario'];

// gera nova senha e faz update da tabela login:
$senha=gera_senha();
$update_login="update inscricao_pos_login set senha=md5('".$senha."') where coduser='".$coduser."'";
//echo $update_login;
$res_update_login=pg_query($update_login) or die ("problema de conexao com o banco");

$manda=manda_mail_login($coduser,$senha);

echo $manda;
}

pg_close($idconn);
?>
