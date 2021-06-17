<?php
include("head_inscricao_pos.php");
//include ("../pgsql/pgsql.php");
//include("gera_senha.php");
//echo "passei aqui de volta";

function gera_senha() 
{
        $length=rand(8, 10);
        $strength=4;
        $vowels = 'aeiouy';
        $consonants = 'bcdfghjklmnpqrstvwxz';
        if ($strength >= 1) {
                $consonants .= 'BCDFGHJKLMNPQRSTVWXZ';
        }
        if ($strength >= 2) {
                $vowels .= "AEIOUY";
        }
        if ($strength >= 3) {
                $consonants .= '0123456789';
        }
        if ($strength >= 4) {
                $consonants .= '*?!+';
        }
 
        $password = '';
        $alt = time() % 2;
        for ($i = 0; $i < $length; $i++) {
                if ($alt == 1) {
                        $password .= $consonants[(rand() % strlen($consonants))];
                        $alt = 0;
                } else {
                        $password .= $vowels[(rand() % strlen($vowels))];
                        $alt = 1;
                }
        }
        return $password;
}





function cria_conta_recomendante($login,$senha)
{
$query_checa=pg_query("select * from inscricao_pos_login where login='".$login."'");
$num_checa=pg_num_rows($query_checa);

if($num_checa==0)
	{
	$query_insere="insert into inscricao_pos_login values (default,'".$login."',md5('".$senha."'),'recomendante')";
	$res_insere=pg_query($query_insere) or die ("problema de conexao com o banco");
//	echo $query_insere."<br>";
	if($res_insere) $devolve="gravado"; else $devolve="problema";
	}
	else 
	{
//	$query_insere="update inscricao_pos_login set senha=md5('".$senha."') where login='".$login."'";
//        $res_insere=pg_query($query_insere) or die ("problema de conexao com o banco");
//        //echo $query_insere."<br>";
//        if($res_insere) $devolve="gravado"; else $devolve="problema";
	$devolve="ja existe uma conta com este login";
	}
return $devolve;
}

function  manda_mail($email,$senha,$nome,$status,$opcao)
{		 

$nome_explode=explode(" ",strtolower($nome));
$nome_novo="";
for ($k=0;$k<count($nome_explode);$k++)
	{
	$nome_novo.=" ".ucfirst($nome_explode[$k]);
	}

if ($opcao==1) 
	{
	//Gerar nova senha e mandar mail com dados da conta
	$subject ="Inscrições no programa de pós-graduação Mat/UnB: dados para login de ".ucfirst($status); 
	$texto="Prezado(a) ".$nome_novo.",\r\n Seu login é  ".$email." \r\n Sua senha é: ".$senha." \r\n";
	}

if ($opcao==2) 
	{
	//Criar conta de recomendantes e mandar mail com dados da conta e de cartas
	$subject ="Inscrições no programa de pós-graduação Mat/UnB: dados para login de ".ucfirst($status); 
	$texto="Prezado(a) ".$nome_novo.",\r\n  Para poder enviar/submeter uma carta de recomendação para inscrição no Programa p�s-gradua��o do do MAT/UnB, solicitamos que acesse o link http://www.mat.unb.br/inscricoespos. \r\n  Seu login é:  ".$email." \r\n Sua senha é: ".$senha." \r\n";
	}
if ($opcao==3) 
	{
	//Mandar aviso de nova carta para recomendante
	$query_alunos=pg_query("select dc.id_aluno, name||' '||firstname as nom_aluno from inscricao_pos_contatos_recomendante cr, inscricao_pos_dados_candidato dc where emailprofrecomendante1='".$email."' and dc.id_aluno=cr.id_aluno union (select dc.id_aluno, name||' '||firstname as nom_aluno from inscricao_pos_contatos_recomendante cr, inscricao_pos_dados_candidato dc where emailprofrecomendante2='".$email."' and dc.id_aluno=cr.id_aluno) union (select dc.id_aluno, name||' '||firstname as nom_aluno from inscricao_pos_contatos_recomendante cr, inscricao_pos_dados_candidato dc where emailprofrecomendante3='".$email."' and dc.id_aluno=cr.id_aluno)");

	$alunos="";
	while($registro=pg_fetch_row($query_alunos))
		{
		$nome_aluno=explode(" ",strtolower($registro[1]));
		$nome_novo="";
		for ($i=0;$i<count($nome_aluno);$i++)
			{
			$nome_novo.=" ".ucfirst($nome_aluno[$i]);
			} 
		if ($alunos=="") $alunos.=$nome_novo; else $alunos.=",".$nome_novo;
		}
	$subject ="Inscrições no programa de pós-graduação Mat/UnB: aviso de cartas pendentes para ".ucfirst($status); 
	$texto="Prezado(a) Prof(a).".$nome_novo.",\n Os alunos seguintes solicitaram uma carta de recomendação: \n ".$alunos; 
	}


$texto=wordwrap($texto,70);

echo "<br><br> Para:".$email.";<br> Subject: ".$subject." ;<br> Mensagem: ".$texto." ;<br>";

$res_mail=mail($email, mb_convert_encoding($subject,'ISO-8859-1','UTF-8'), mb_convert_encoding($texto,'ISO-8859-1','UTF-8'),"FROM: posgrad@mat.unb.br \r\n");
if ($res_mail) $devolve="mensagem enviada"; else $devolve="problema no envio de mensagens";

return $devolve;

}

if(!isset($_POST['confirmar']))
{
$query_usuarios=pg_query("select id_aluno as coduser, name||' '||firstname as nome, login, l.status from inscricao_pos_dados_candidato dc, inscricao_pos_login l where l.coduser=dc.id_aluno and l.status='candidato' union (select id_prof as coduser, nomerecomendante as nome, login, l.status from inscricao_pos_dados_pessoais_recomendante dr, inscricao_pos_login l where l.coduser=dr.id_prof and l.status='recomendante') order by nome,login,status");

?>
<html>
	<head>
	<META http-equiv="Content-Type" content="text/html; charset=utf-8">
        <link type="text/css" rel="stylesheet" href="../../global/grafic.css">
	</head>
	

<body >
      <table class=big>
  <form method="POST" name="formu" action="formu_manda_nova_senha_novo.php">
      <tr>
        <td class=header align=center>
<h1>Cadastro para Processo Seletivo do Curso de Ver&atilde;o / P&oacute;s-Gradua&ccedil;&atilde;o </h1><br>
          <h1>Cria&ccedil;&atilde;o/envio de nova senha</h1>
                MAT-UnB <?php echo date("Y")+1;?><br>
        </td>
      </tr>
      <tr>
        <td align=center><table class=form><tr>
    <td colspan=4 class=header align=center>
      <b>Selecione um usu&aacute;rio:</b>
	<select name=usuario>
	<option value='nulo'>--- escolha um usu&aacute;rio ---</option>
<?php
	while($registro=pg_fetch_row($query_usuarios))
		{
		$valor=$registro[0]."_--_".$registro[1]."_--_".$registro[2]."_--_".$registro[3];
		echo "<option value=\"".$valor."\">".$registro[1]." / ".$registro[2]." / ".$registro[3]."</option>";
		}
?>
	</select></td>
	  </tr>
	<tr><td colspan=4><b>Selecione uma op&ccedil;&atilde;: </b></td></tr>
	<tr><td><input type=radio name='opcao' value=1> Gerar nova senha e mandar mail com dados da conta</td></tr>
	<tr><td><input type=radio name='opcao' value=2> Criar conta de recomendante e mandar mail com dados da conta</td><td>Programa: <input type=radio name='programa' value="mestrado">Mestrado; <input type=radio name='programa' value="doutorado">Doutorado</td></tr>
	<tr><td><input type=radio name='opcao' value=3> Mandar aviso de nova carta para recomendante</td></tr>
	</tr> 
	</table>
	  </td>
	  </tr>
      <tr>
        <td align=center>
          <input type=submit name='confirmar' value="Confirmar"><input type=reset name='limpa' value="Limpar formul&aacute;rio">
        </td>
      </form>
</table>
</body>
</html>
<?php
}

if (isset($_POST['confirmar']))
{

$dados=explode("_--_",$_POST['usuario']);
$coduser=$dados[0];
$nome=$dados[1];
$usuario=$dados[2];
$status=$dados[3];
$opcao=$_POST['opcao'];
$programa=ucfirst($_POST['programa']);

if (isset($_POST['opcao']) and ($dados[0]!="nulo"))
{
	if ($opcao==1) 
	{
	// gera nova senha e faz update da tabela login:
	$senha=gera_senha();
	$update_login="update inscricao_pos_login set senha=md5('".$senha."') where coduser='".$coduser."'";
//	echo $update_login;
	$res_update_login=pg_query($update_login) or die ("problema de conexao com o banco");
	$manda=manda_mail($usuario,$senha,$nome,$status,1);
	echo $manda;
?>
	<html>
        <body>
        <form method="POST" name="formu" action="formu_manda_nova_senha_novo.php">
          <input type=submit name='voltar' value="Voltar">
      	</form>
     	</body>
    	</html>
<?php
	}
	else
	{
		if (($opcao==2) and ($status=="candidato") and isset($_POST['programa'])) 
		{
		$query_recomendantes=pg_query("select nomeprofrecomendante1,emailprofrecomendante1 from inscricao_pos_contatos_recomendante where id_aluno='".$coduser."' and programa='".$programa."' union (select nomeprofrecomendante2,emailprofrecomendante2 from inscricao_pos_contatos_recomendante where id_aluno='".$coduser."' and programa='".$programa."') union  (select nomeprofrecomendante3,emailprofrecomendante3 from inscricao_pos_contatos_recomendante where id_aluno='".$coduser."' and programa='".$programa."')");
echo "select nomeprofrecomendante1,emailprofrecomendante1 from inscricao_pos_contatos_recomendante where id_aluno='".$coduser."' and programa='".$programa."' union (select nomeprofrecomendante2,emailprofrecomendante2 from inscricao_pos_contatos_recomendante where id_aluno='".$coduser."' and programa='".$programa."') union  (select nomeprofrecomendante3,emailprofrecomendante3 from inscricao_pos_contatos_recomendante where id_aluno='".$coduser."' and programa='".$programa."')";
		$num_recomendantes=pg_num_rows($query_recomendantes);
		if ($num_recomendantes!=0)
		{
		while ($registro=pg_fetch_row($query_recomendantes))
			{			
			$senha=gera_senha();
			$res_cria=cria_conta_recomendante(trim($registro[1]),$senha);
			if ($res_cria=="gravado") $manda=manda_mail(trim($registro[1]),$senha,$registro[0],"recomendante",2); else $manda=$res_cria;
			echo $manda."<br>";
			}
		}
		else $manda="N&atilde;o h&aacute; recomendantes cadastrados para ".$nome.", candidato ao ".$programa;
?>
			<html>
			<body>
		        <form method="POST" name="formu" action="formu_manda_nova_senha_novo.php">
		          <input type=submit name='voltar' value="Voltar">
		      </form>
		     </body>
		    </html>
<?php
			
		}
		else 
		{
			if (($opcao==3) and ($status=="recomendante")) 
				{
				$manda=manda_mail($usuario,$senha,$nome,$status,3);
				echo $manda;
				}
			else 
				{
?>
				  <html>
				        <body>
			        <form method="POST" name="formu" action="formu_manda_nova_senha_novo.php">
				<br>Op&ccedil;&otilde;es incorretas<br>
			        <input type=submit name='voltar' value="Voltar">
				</form>	
				</body>
				</html>
<?php
				}
		}	
	
	}
}
else 
{
?>
      <html>
	<body>
	<form method="POST" name="formu" action="formu_manda_nova_senha_novo.php">
	<br>Escolher alguma op&ccedil;&atilde;o<br>
          <input type=submit name='voltar' value="Voltar">
      </form>
     </body>
    </html>
<?php
}
}

pg_close($idconn);
?>
