<?php
require("head_listas.php");

if(!isset($_POST['enviar'])) // Se campos do formulario estiverem em branco, faça .....
{
$chave="";
//$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$

if (isset($_POST['seleciona']) and ($chave!="atualizar"))
{
	if ($_POST['eliminar']!="criar")
	{
        $valor_da_conta=explode("-",$_POST['eliminar']);
        if ($valor_da_conta[3]=="desativada") $status="ativa"; else $status="desativada";
	$query_elimina="update listas_de_mails set status=? where id_lista=?"; $query_elimina__p = array($status, $valor_da_conta[0]);
	$res_elimina=db_query($query_elimina, $query_elimina__p);
        $nome_da_conta=$valor_da_conta[1];
	// ##############  Permitir a edicao da lista
        if ($status=="ativa") 
           {
           //$$$$$$$$$ COLOCAR LISTA DE USUARIOS $$$$$$$$$$$$$$$$$$$$$$$$$$$$
	   $chave="atualizar";
	   $id_lista=$valor_da_conta[0];
           $nome_lista=$valor_da_conta[1];
	   $lista_mails=explode(",",$valor_da_conta[2]);
	   }
	else  echo "Lista ".$valor_da_conta[1]."@mat.unb.br desativada.";
	}

// CASO SEJA CRIAÇÃO DE LISTA
   	else 
	{
	$substituto[0]='/&([a-zA-Z])(uml|acute|grave|circ|tilde);/';
	$substituto[1]='" "';
	//NMBUPGRADE// $nome_limpo=preg_replace($substituto,'',$_POST['nome_conta']);
    $nome_limpo=preg_replace_callback($substituto, function ($matches) { return ''; }, $_POST['nome_conta']);

        $pega_nome="select * from listas_de_mails where nome_lista=?"; $pega_nome__p = array($nome_limpo);
        $query_listas=db_query($pega_nome, $pega_nome__p);
        $num_listas=db_num_rows($query_listas);

	// Se houver acentos ou caracteres proibidos, solicitar outro nome antes de continuar:
	if ((strlen($nome_limpo)!=strlen($_POST['nome_conta'])) OR ($num_listas!=0)) 
		{
                if (strlen($nome_limpo)!=strlen($_POST['nome_conta'])) $mensagem1="O nome da lista n&atilde;o pode conter caracteres especiais"; else $mensagem1="";
                if ($num_listas!=0) $mensagem3="Escolha outro nome para a lista; j&aacute; existe uma lista com este nome"; else $mensagem3="";
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
		   <td align=center colspan=1 class=header align=center><h1>Cria&ccedil;&atilde;o/Atualiza&ccedil;&atilde;o de Listas de mails</h1></td></tr>
		   <form method="POST" name="formu" action="usuarios.php">
		   <tr>
		   <td align=center>
		   <table class=form>
		   <tr>
		   <?php
		   /*
		   ?>
		   <table border class=form align=center>
		   <tr><td colspan=4 class=header align=center>Contas j&aacute; existentes</td></tr>
		   <tr><td><b>Ativar/Desativar</b></td><td> <b>Nome da lista</b></td><td><b>Descri&ccedil;&atilde;o</b></td><td><b>Status</b></td></b></tr>
		   <?php
                   while($registro = db_fetch_row($query_listas)) //enquanto houver
                        {
                        $descricao=$registro[2];
                        $valor_da_conta=$registro[0]."-".$registro[1]."-".$registro[3]."-".$registro[4];
                        echo "<tr><td><input type=radio name='eliminar' value=".$valor_da_conta."></td><td>".$registro[1]."</td><td>".$descricao."</td><td>".$registro[4]."</td></tr>";
                        }
// id_lista | nome_lista | descricao | e_mails (lista de coduser) | status (ativada/desativada)
                 ?>
     		  </table>
		  </td>
         	  </tr>
        	  <?php
		  */
		  ?>
		  <tr></tr>
        	  <tr>  <td align=center>
               	  <table border class=form align=center>
               	  <tr><td colspan=3 class=header align=center>Criar uma Nova Conta</td></tr>
               	  <tr><td colspan=3><blink><?php echo $mensagem1;?></blink></td></tr>
               	  <tr><td colspan=3><blink><?php echo $mensagem3;?></blink></td></tr>
               	  <tr><td><b>Criar</b></td><td> <b>Nome da conta</b></td><td><b>Descri&ccedil;&atilde;o</b></td></tr>
               	  <tr><td><input type=hidden name='eliminar' value="criar"></td><td> <input type=text name='nome_conta' maxlength=10 size=12 value="<?php echo $_POST['nome_conta'];?>"> </td><td><input type=text name='descricao' maxlength=200 size=50 value="<?php echo $_POST['descricao'];?>"> </td></tr>
                  </table>
               	  </td>
               	  </tr>
	       	  <tr>
        	  <td align=center>
          	  <input type=submit name='seleciona' value="Confirme"> <input type=reset name='limpa' value="Limpar"></td></tr>
        	  </table>
        	  </form>
		  </table>
		  </body>
		  </html>
           <?php
		}
		else 
		{
		$descricao=$_POST['descricao'];
		$query_cria="insert into listas_de_mails values(default,?,?,'','ativa')"; $query_cria__p = array($_POST['nome_conta'], $descricao);
		$res_cria=db_query($query_cria, $query_cria__p);
                $pega_codigo="select id_lista from listas_de_mails where nome_lista=?"; $pega_codigo__p = array($_POST['nome_conta']);
                $query_codigo=db_query($pega_codigo, $pega_codigo__p);
                $res_codigo=db_fetch_row($query_codigo);
                
		$chave="atualizar";
		$id_lista=$res_codigo[0];
		$nome_lista=$_POST['nome_conta'];
		$lista="";
		echo "\n";
		echo "Conta ".$_POST['nome_conta']."@mat.unb.br criada com sucesso.";
		}
	}
}
//$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$


if (isset($_POST['seleciona']) and ($chave=="atualizar"))
{
$lista=array();
for ($k=0; $k<count($lista_mails); $k++)
{
$login_0=explode("@",$lista_mails[$k]);
$lista[$k]=$login_0[0];
}

$data=getdate();
$data_de_hoje=$data['year']."-".$data['mon']."-".$data['mday'];

//$pega_prof_do_quadro="select ux.login as login,us.coduser as coduser,us.name as nome,us.firstname as sobrenome,f.contract_end from fonctionnaire f, users us, profs pr, unix ux where us.coduser=f.coduser and us.coduser=ux.coduser and us.coduser=pr.coduser and f.contract_type='dedicacao exclusiva' and f.statut='professor' and pr.situacao='ativo' order by nome,sobrenome";
$pega_prof_do_quadro="select ux.login as login,us.coduser as coduser,us.name as nome,us.firstname as sobrenome,f.contract_end from fonctionnaire f, users us, profs pr, unix ux where us.coduser=f.coduser and us.coduser=ux.coduser and us.coduser=pr.coduser and f.contract_type='dedicacao exclusiva' and f.statut='professor' order by nome,sobrenome"; $pega_prof_do_quadro__p = array();

$pega_prof_substitutos="select ux.login as login, us.coduser as coduser,us.name as nome,us.firstname as sobrenome,f.contract_end from fonctionnaire f,users us, profs pr, unix ux where us.coduser=f.coduser and us.coduser=ux.coduser and us.coduser=pr.coduser and f.contract_type like 'substituto%' and f.statut='professor' and pr.situacao='ativo' order by nome,sobrenome"; $pega_prof_substitutos__p = array();

$pega_administrativos="select ux.login as login,us.coduser as coduser,us.name as nome,us.firstname as sobrenome,f.contract_end from fonctionnaire f,users us, unix ux where us.coduser=f.coduser and us.coduser=ux.coduser and f.statut='administrativo' and f.contract_end>?order by nome,sobrenome"; $pega_administrativos__p = array($data_de_hoje);

$pega_alunos_graduacao="select ux.login as login, us.coduser as coduser,us.name as nome,us.firstname as sobrenome,f.depart_date1 from student f,users us, unix ux where us.coduser=f.coduser and us.coduser=ux.coduser and f.status='ativo' and f.depart_date1>? and f.formation='graduacao'  order by nome,sobrenome"; $pega_alunos_graduacao__p = array($data_de_hoje);

$pega_alunos_mestrado="select ux.login as login, us.coduser as coduser,us.name as nome,us.firstname as sobrenome,f.depart_date1 from student f,users us, unix ux where us.coduser=f.coduser and us.coduser=ux.coduser and f.status='ativo' and f.depart_date1>? and f.formation='mestrado' order by nome,sobrenome"; $pega_alunos_mestrado__p = array($data_de_hoje);

$pega_alunos_doutorado="select ux.login as login,us.coduser as coduser,us.name as nome,us.firstname as sobrenome,f.depart_date1 from student f,users us, unix ux where us.coduser=f.coduser and us.coduser=ux.coduser and f.status='ativo' and f.depart_date1>? and f.formation='doutorado' order by nome,sobrenome"; $pega_alunos_doutorado__p = array($data_de_hoje);


$query_prof_do_quadro=db_query($pega_prof_do_quadro, $pega_prof_do_quadro__p);
$res_prof_do_quadro=db_fetch_all($query_prof_do_quadro);
$num_prof_do_quadro=db_num_rows($query_prof_do_quadro);

$linhas_prof_do_quadro=intval($num_prof_do_quadro/3)+1;

$query_prof_substitutos=db_query($pega_prof_substitutos, $pega_prof_substitutos__p);
$res_prof_substitutos=db_fetch_all($query_prof_substitutos);
$num_prof_substitutos=db_num_rows($query_prof_substitutos);

$linhas_prof_substitutos=intval($num_prof_substitutos/3)+1;

$query_administrativos=db_query($pega_administrativos, $pega_administrativos__p);
$res_administrativos=db_fetch_all($query_administrativos);
$num_administrativos=db_num_rows($query_administrativos);

$linhas_administrativos=intval($num_administrativos/3)+1;

$query_alunos_graduacao=db_query($pega_alunos_graduacao, $pega_alunos_graduacao__p);
$res_alunos_graduacao=db_fetch_all($query_alunos_graduacao);
$num_alunos_graduacao=db_num_rows($query_alunos_graduacao);

$linhas_alunos_graduacao=intval($num_alunos_graduacao/3)+1;


$query_alunos_mestrado=db_query($pega_alunos_mestrado, $pega_alunos_mestrado__p);
$res_alunos_mestrado=db_fetch_all($query_alunos_mestrado);
$num_alunos_mestrado=db_num_rows($query_alunos_mestrado);

$linhas_alunos_mestrado=intval($num_alunos_mestrado/3)+1;

$query_alunos_doutorado=db_query($pega_alunos_doutorado, $pega_alunos_doutorado__p);
$res_alunos_doutorado=db_fetch_all($query_alunos_doutorado);
$num_alunos_doutorado=db_num_rows($query_alunos_doutorado);

$linhas_alunos_doutorado=intval($num_alunos_doutorado/3)+1;

$total=$num_prof_do_quadro+$num_prof_substitutos+$num_administrativos+$num_alunos_doutorado+$num_alunos_mestrado+$num_alunos_graduacao;


?>
<html>
<header>
 <meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
   <script language="javascript">
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
          <h1>Cria&ccedil;&atilde;o/Atualiza&ccedil;&atilde;o de listas de mail: Integrantes da lista <?php echo $nome_lista;?></h1>
        </td>
      </tr>
      <tr>
      <form name="relatorio_usuarios" method="POST" action="usuarios.php"><p>
      <tr>
        <td align=center>
          <table class=form>
	<tr>
	<td colspan=3 class=header align=center><b>Professores do quadro:</b></td>
	</tr>
	<?php
	for ($k=0;$k<$linhas_prof_do_quadro;$k++)
		{
		 if ($cor_anterior=="#00BFFF") $nova_cor="#FFFFFF"; else $nova_cor="#00BFFF";
	?>
		<tr bgcolor="<?php echo $cor ?>"> 
		<td VALIGN="top"><INPUT TYPE=CHECKBOX NAME="usuario[]" value="<?php echo $res_prof_do_quadro[$k]['login'];?>" <?php if (!empty($lista) and in_array($res_prof_do_quadro[$k]['login'],$lista) and ($k <$num_prof_do_quadro)) echo "checked";?>><?php echo $res_prof_do_quadro[$k]['nome']."  ".$res_prof_do_quadro[$k]['sobrenome'];?></td>
		<td VALIGN="top"><INPUT TYPE=CHECKBOX NAME="usuario[]" value="<?php echo $res_prof_do_quadro[$k+$linhas_prof_do_quadro]['login'];?>" <?php if (!empty($lista) and in_array($res_prof_do_quadro[$k+$linhas_prof_do_quadro]['login'],$lista) and ($k+$linhas_prof_do_quadro<$num_prof_do_quadro)) echo "checked";?>><?php echo $res_prof_do_quadro[$k+$linhas_prof_do_quadro]['nome']."  ".$res_prof_do_quadro[$k+$linhas_prof_do_quadro]['sobrenome'];?></td>
		<td VALIGN="top"><INPUT TYPE=CHECKBOX NAME="usuario[]" value="<?php echo $res_prof_do_quadro[$k+2*$linhas_prof_do_quadro]['login'];?>" <?php if (!empty($lista) and in_array($res_prof_do_quadro[$k+2*$linhas_prof_do_quadro]['login'],$lista) and ($k+2*$linhas_prof_do_quadro <$num_prof_do_quadro)) echo "checked";?>><?php echo $res_prof_do_quadro[$k+2*$linhas_prof_do_quadro]['nome']."  ".$res_prof_do_quadro[$k+2*$linhas_prof_do_quadro]['sobrenome'];?></td>
        	</tr>
	<?php
		}
	?>	
	<tr>
	<td colspan=3 class=header align=center><b>Professores substitutos:</b></td>
	</tr>
	<?php
	for ($k=0;$k<$linhas_prof_substitutos;$k++)
		{
		 if ($cor_anterior=="#00BFFF") $nova_cor="#FFFFFF"; else $nova_cor="#00BFFF";
	?>
		<tr bgcolor="<?php echo $cor ?>"> 
		<td VALIGN="top"><INPUT TYPE=CHECKBOX NAME="usuario[]" value="<?php echo $res_prof_substitutos[$k]['login'];?>" <?php if (!empty($lista) and in_array($res_prof_substitutos[$k]['login'],$lista) and ($k<$num_prof_substitutos)) echo "checked";?>><?php echo $res_prof_substitutos[$k]['nome']."  ".$res_prof_substitutos[$k]['sobrenome'];?></td>
		<td VALIGN="top"><INPUT TYPE=CHECKBOX NAME="usuario[]" value="<?php echo $res_prof_substitutos[$k+$linhas_prof_substitutos]['login'];?>" <?php if (!empty($lista) and in_array($res_prof_substitutos[$k+$linhas_prof_substitutos]['login'],$lista) and ($k+$linhas_prof_substitutos<$num_prof_substitutos)) echo "checked";?>><?php echo $res_prof_substitutos[$k+$linhas_prof_substitutos]['nome']."  ".$res_prof_substitutos[$k+$linhas_prof_substitutos]['sobrenome'];?></td>
		<td VALIGN="top"><INPUT TYPE=CHECKBOX NAME="usuario[]" value="<?php echo $res_prof_substitutos[$k+2*$linhas_prof_substitutos]['login'];?>" <?php if (!empty($lista) and in_array($res_prof_substitutos[$k+2*$linhas_prof_substitutos]['login'],$lista) and ($k+2*$linhas_prof_substitutos<$num_prof_substitutos)) echo "checked";?>><?php echo $res_prof_substitutos[$k+2*$linhas_prof_substitutos]['nome']."  ".$res_prof_substitutos[$k+2*$linhas_prof_substitutos]['sobrenome'];?></td>
        	</tr>
	<?php
		}
	?>
	<tr></tr><tr></tr>
	<tr>
	<td colspan=3 class=header align=center><b>Servidores administrativos:</b></td>
	</tr>
	<?php
	for ($k=0;$k<$linhas_administrativos;$k++)
		{
		 if ($cor_anterior=="#00BFFF") $nova_cor="#FFFFFF"; else $nova_cor="#00BFFF";
	?>
		<tr bgcolor="<?php echo $cor ?>"> 
		<td VALIGN="top"><INPUT TYPE=CHECKBOX NAME="usuario[]" value="<?php echo $res_administrativos[$k]['login'];?>" <?php if (!empty($lista) and in_array($res_administrativos[$k]['login'],$lista) and ($k<$num_administrativos)) echo "checked";?>><?php echo $res_administrativos[$k]['nome']."  ".$res_administrativos[$k]['sobrenome'];?></td>
		<td VALIGN="top"><INPUT TYPE=CHECKBOX NAME="usuario[]" value="<?php echo $res_administrativos[$k+$linhas_administrativos]['login'];?>" <?php if (!empty($lista) and in_array($res_administrativos[$k+$linhas_administrativos]['login'],$lista) and ($k+$linhas_administrativos<$num_administrativos)) echo "checked";?>><?php echo $res_administrativos[$k+$linhas_administrativos]['nome']."  ".$res_administrativos[$k+$linhas_administrativos]['sobrenome'];?></td>
		<td VALIGN="top"><INPUT TYPE=CHECKBOX NAME="usuario[]" value="<?php echo $res_administrativos[$k+2*$linhas_administrativos]['login'];?>" <?php if (!empty($lista) and in_array($res_administrativos[$k+2*$linhas_administrativos]['login'],$lista) and ($k+2*$linhas_administrativos<$num_administrativos)) echo "checked";?>><?php echo $res_administrativos[$k+2*$linhas_administrativos]['nome']."  ".$res_administrativos[$k+2*$linhas_administrativos]['sobrenome'];?></td>
        	</tr>
	<?php
		}
	?>
	<tr></tr><tr></tr>
	<tr>
	<td colspan=3 class=header align=center><b>Alunos de Doutorado:</b></td>
	</tr>
	<?php
	for ($k=0;$k<$linhas_alunos_doutorado;$k++)
		{
		 if ($cor_anterior=="#00BFFF") $nova_cor="#FFFFFF"; else $nova_cor="#00BFFF";
	?>
		<tr bgcolor="<?php echo $cor ?>"> 
		<td VALIGN="top"><INPUT TYPE=CHECKBOX NAME="usuario[]" value="<?php echo $res_alunos_doutorado[$k]['login'];?>" <?php if (!empty($lista) and in_array($res_alunos_doutorado[$k]['login'],$lista) and ($k<$num_alunos_doutorado)) echo "checked";?>><?php echo $res_alunos_doutorado[$k]['nome']."  ".$res_alunos_doutorado[$k]['sobrenome'];?></td>
		<td VALIGN="top"><INPUT TYPE=CHECKBOX NAME="usuario[]" value="<?php echo $res_alunos_doutorado[$k+$linhas_alunos_doutorado]['login'];?>" <?php if (!empty($lista) and in_array($res_alunos_doutorado[$k+$linhas_alunos_doutorado]['login'],$lista) and ($k+$linhas_alunos_doutorado<$num_alunos_doutorado)) echo "checked";?>><?php echo $res_alunos_doutorado[$k+$linhas_alunos_doutorado]['nome']."  ".$res_alunos_doutorado[$k+$linhas_alunos_doutorado]['sobrenome'];?></td>
		<td VALIGN="top"><INPUT TYPE=CHECKBOX NAME="usuario[]" value="<?php echo $res_alunos_doutorado[$k+2*$linhas_alunos_doutorado]['login'];?>" <?php if (!empty($lista) and in_array($res_alunos_doutorado[$k+2*$linhas_alunos_doutorado]['login'],$lista)  and ($k+2*$linhas_alunos_doutorado<$num_alunos_doutorado)) echo "checked";?>><?php echo $res_alunos_doutorado[$k+2*$linhas_alunos_doutorado]['nome']."  ".$res_alunos_doutorado[$k+2*$linhas_alunos_doutorado]['sobrenome'];?></td>
        	</tr>
	<?php
		}
	?>
	<tr>
	<td colspan=3 class=header align=center><b>Alunos de Mestrado:</b></td>
	</tr>
	<?php
	for ($k=0;$k<$linhas_alunos_mestrado;$k++)
		{
		 if ($cor_anterior=="#00BFFF") $nova_cor="#FFFFFF"; else $nova_cor="#00BFFF";
	?>
		<tr bgcolor="<?php echo $cor ?>"> 
		<td VALIGN="top"><INPUT TYPE=CHECKBOX NAME="usuario[]" value="<?php echo $res_alunos_mestrado[$k]['login'];?>" <?php if (!empty($lista) and in_array($res_alunos_mestrado[$k]['login'],$lista) and ($k<$num_alunos_mestrado)) echo "checked";?>><?php echo $res_alunos_mestrado[$k]['nome']."  ".$res_alunos_mestrado[$k]['sobrenome'];?></td>
		<td VALIGN="top"><INPUT TYPE=CHECKBOX NAME="usuario[]" value="<?php echo $res_alunos_mestrado[$k+$linhas_alunos_mestrado]['login'];?>" <?php if (!empty($lista) and in_array($res_alunos_mestrado[$k+$linhas_alunos_mestrado]['login'],$lista) and ($k+$linhas_alunos_mestrado<$num_alunos_mestrado)) echo "checked";?>><?php echo $res_alunos_mestrado[$k+$linhas_alunos_mestrado]['nome']."  ".$res_alunos_mestrado[$k+$linhas_alunos_mestrado]['sobrenome'];?></td>
		<td VALIGN="top"><INPUT TYPE=CHECKBOX NAME="usuario[]" value="<?php echo $res_alunos_mestrado[$k+2*$linhas_alunos_mestrado]['login'];?>" <?php if (!empty($lista) and in_array($res_alunos_mestrado[$k+2*$linhas_alunos_mestrado]['login'],$lista) and ($k+2*$linhas_alunos_mestrado<$num_alunos_mestrado)) echo "checked";?>><?php echo $res_alunos_mestrado[$k+2*$linhas_alunos_mestrado]['nome']."  ".$res_alunos_mestrado[$k+2*$linhas_alunos_mestrado]['sobrenome'];?></td>
        	</tr>
	<?php
		}
	?>
	<tr>
	<td colspan=3 class=header align=center><b>Alunos de Gradua&ccedil;&atilde;o:</b></td>
	</tr>
	<?php
	for ($k=0;$k<$linhas_alunos_graduacao;$k++)
		{
		 if ($cor_anterior=="#00BFFF") $nova_cor="#FFFFFF"; else $nova_cor="#00BFFF";
	?>
		<tr bgcolor="<?php echo $cor ?>"> 
		<td VALIGN="top"><INPUT TYPE=CHECKBOX NAME="usuario[]" value="<?php echo $res_alunos_graduacao[$k]['login'];?>" <?php if (!empty($lista) and in_array($res_alunos_graduacao[$k]['login'],$lista) and ($k<$num_alunos_graduacao)) echo "checked";?>><?php echo $res_alunos_graduacao[$k]['nome']."  ".$res_alunos_graduacao[$k]['sobrenome'];?></td>
		<td VALIGN="top"><INPUT TYPE=CHECKBOX NAME="usuario[]" value="<?php echo $res_alunos_graduacao[$k+$linhas_alunos_graduacao]['login'];?>" <?php if (!empty($lista) and in_array($res_alunos_graduacao[$k+$linhas_alunos_graduacao]['login'],$lista) and ($k+$linhas_alunos_graduacao<$num_alunos_graduacao)) echo "checked";?>><?php echo $res_alunos_graduacao[$k+$linhas_alunos_graduacao]['nome']."  ".$res_alunos_graduacao[$k+$linhas_alunos_graduacao]['sobrenome'];?></td>
		<td VALIGN="top"><INPUT TYPE=CHECKBOX NAME="usuario[]" value="<?php echo $res_alunos_graduacao[$k+2*$linhas_alunos_graduacao]['login'];?>" <?php if (!empty($lista) and in_array($res_alunos_graduacao[$k+2*$linhas_alunos_graduacao]['login'],$lista) and ($k+2*$linhas_alunos_graduacao<$num_alunos_graduacao)) echo "checked";?>><?php echo $res_alunos_graduacao[$k+2*$linhas_alunos_graduacao]['nome']."  ".$res_alunos_graduacao[$k+2*$linhas_alunos_graduacao]['sobrenome'];?></td>
        	</tr>
	<?php
		}
	?>
	</table><br>
	<input type=submit name='enviar' value="Confirme"> <input type=reset name='limpa' value="Limpar"></td></tr>
	<input type="hidden" name="total" value="<?php echo $total;?>">	<input type="hidden" name="id_lista" value="<?php echo $id_lista;?>">
	<input type="hidden" name="nome_lista" value="<?php echo $nome_lista;?>">
	</form>
	</body>
	</html>
	<?php
	}
}


if (isset($_POST['enviar']))
{
  $usuario=$_POST['usuario'];
  $usuarios_lista="";
  $total=count($usuario); 
//)$_POST['total'];
  for ($k=0;$k<$total;$k++)
         {
         if (!empty($usuario[$k])) {if ($k!=$total-1) $usuarios_lista.=$usuario[$k]."@mat.unb.br,"; else $usuarios_lista.=$usuario[$k]."@mat.unb.br";}
         }
  $grava_usuarios_lista="update listas_de_mails set e_mails=? where id_lista=?"; $grava_usuarios_lista__p = array($usuarios_lista, $_POST['id_lista']);
  $query_grava_usuarios_lista=db_query($grava_usuarios_lista, $grava_usuarios_lista__p);
  echo "Lista ".$_POST['nome_lista']."@mat.unb.br atualizada com sucesso.";
}


db_close($idconn);

?>
