<?php
include("head_contas_especiais.php");



$query_contas=pg_query("select * from contas_especiais order by nome_conta");


//print $num_submetido;

$hoje=getdate();
$data_de_hoje=$hoje['mon']."-".$hoje['mday']."-".$hoje['year'];

//print $data_de_hoje;

if (!isset($_POST['seleciona']))
{
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
        <td align=center colspan=1 class=header align=center><h1>Cria&ccedil;&atilde;o/Atualiza&ccedil;&atilde;o de Contas especiais</h1></td></t\
r>
  <form method="POST" name="formu" action="incluir_conta.php">
<tr>
        <td align=center>
          <table class=form>
   <tr>
        <table border class=form align=center>
        <tr><td colspan=4 class=header align=center>Contas j&aacute; existentes</td></tr>
        <tr><td><b>Ativar/Desativar</b></td><td> <b>Nome da conta</b></td><td><b>Descri&ccedil;&atilde;o</b></td><td><b>Status</b></td></b></tr>
                <?php
                 while($registro = pg_fetch_row($query_contas)) //enquanto houver                           
                        {
//			$descricao=mb_convert_encoding($registro[2],"UTF-8");
			$descricao=$registro[2];
                        $valor_da_conta=$registro[0]."-".$registro[1]."-".$registro[4];
		        echo "<tr><td><input type=radio name='eliminar' value=".$valor_da_conta."></td><td>".$registro[1]."</td><td>".$descricao."</td><td>".$registro[4]."</td></tr>";
                        }
                 ?>
         </table>
         </td>
         </tr>
	<tr></tr>
        <tr>  <td align=center>
               <table border class=form align=center> 
               <tr><td colspan=5 class=header align=center>Criar uma Nova Conta</td></tr>
               <tr><td><b>Criar</b></td><td> <b>Nome da conta</b></td><td><b>Descri&ccedil;&atilde;o</b></td><td><b>Senha</b></td><td><b>Confirmar senha</b></td></tr>
               <tr><td><input type=radio name='criar' value="criar"></td><td> <input type=text name='nome_conta' maxlength=10 size=12> </td><td><input type=text name='descricao' maxlength=200 size=50> </td><td><input type=password name='senha1' size=10></td><td><input type=password name='senha2' size=10></td></tr>
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


// mostra o relatoio selecionado com opcao de atualizar ou submeter  

if (isset($_POST['seleciona']))
{
	if (isset($_POST['eliminar']))
	{
       $valor_da_conta=explode("-",$_POST['eliminar']);
        if ($valor_da_conta[2]=="desativada") $status="ativa"; else $status="desativada";
	$query_elimina="update contas_especiais set status='".$status."' where codigo='".$valor_da_conta[0]."'";
	$res_elimina=pg_query($query_elimina);
        $nome_da_conta=$valor_da_conta[1];
	$pega_descricao="select descricao from contas_especiais where codigo='".$valor_da_conta[0]."'";
        $query_descricao=pg_query($pega_descricao);
        $res_descricao=pg_fetch_row($query_descricao);
// ##############  Permitir o estabelecimento de uma nova senha
        if ($status=="ativa") 
           {
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
         <td align=center colspan=1 class=header align=center><h1>Cria&ccedil;&atilde;o/Atualiza&ccedil;&atilde;o de Contas especiais</h1></td></tr>
	  <form method="POST" name="formu" action="incluir_conta.php">
	  <tr>  <td align=center>
	  <table border class=form align=center>
	  <tr><td colspan=5 class=header align=center>Criar uma Nova Conta</td></tr>
	  <tr><td colspan=5><blink><?php echo $mensagem1;?></blink></td></tr>
	  <tr><td colspan=5><blink><?php echo $mensagem2;?></blink></td></tr>
	  <tr><td colspan=5><blink><?php echo $mensagem3;?></blink></td></tr>
	  <tr><td><b>Criar</b></td><td> <b>Nome da conta</b></td><td><b>Descri&ccedil;&atilde;o</b></td><td><b>Senha</b></td><td><b>Confirmar senha</b></td></tr>
          <tr><td><input type=hidden name='atualizar' value="criar"></td><td> <input type=text name='nome_conta' maxlength=10 size=12 value="<?php echo $valor_da_conta[1];?>"> </td><td><input type=text name='descricao' maxlength=200 size=50 value="<?php echo $res_descricao[0];?>"> </td><td><input type=password name='senha1' size=10></td><td><input type=password name='senha2' size=10></td></tr>
	  </table>
	  </td>
	  </tr>
	  <tr>
	  <td align=center>
	  <input type=submit name='seleciona' value="Confirme"> <input type=reset name='limpa' value="Limpar"></td></tr>
	  </table>
	  </form>
	  <table>
	  </body>
	  </html>
          <?php
           }

	echo " Conta ".$valor_da_conta[1]."@mat.unb.br ".$status."\n";
	}

// CASO FOR CONTA A ATUALIZAR

        if (isset($_POST['atualizar']))
        {
	if ($_POST['senha1']!=$_POST['senha2'])
            {
	    $mensagem2="As senhas devem ser id&ecirc;nticas";
	    //############
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
	<td align=center colspan=1 class=header align=center><h1>Cria&ccedil;&atilde;o/Atualiza&ccedil;&atilde;o de Contas especiais</h1></td></tr>
		<form method="POST" name="formu" action="incluir_conta.php">
		<tr>  <td align=center>
               <table border class=form align=center>
               <tr><td colspan=5 class=header align=center>Criar uma Nova Conta</td></tr>
               <tr><td colspan=5><blink><?php echo $mensagem2;?></blink></td></tr>
               <tr><td><b>Criar</b></td><td> <b>Nome da conta</b></td><td><b>Descri&ccedil;&atilde;o</b></td><td><b>Senha</b></td><td><b>Confirmar senha</b></td></tr>
               <tr><td><input type=hidden name='atualizar' value="criar"></td><td> <input type=text name='nome_conta' maxlength=10 size=12 value="<?php echo $_POST['nome_conta'];?>"> </td><td><input type=text name='descricao' maxlength=200 size=50 value="<?php echo $_POST['descricao'];?>"> </td><td><input type=password name='senha1' size=10></td><td><input type=password name='senha2' size=10></td></tr>
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
	   $atualiza_unix="update unix set passwd='".crypt($_POST['senha1'])."' where login='".$_POST['nome_conta']."'";
           $query_unix=pg_query($atualiza_unix);
           //echo $atualiza_unix;
	   echo "\n";
           echo "Conta ".$_POST['nome_conta']."@mat.unb.br atualizada com sucesso.";	   
	   }

        }
	

// CASO SEJA CRIAÇÃO DE CONTA

	if (isset($_POST['criar']))
	{
// preg_replace('/&([a-zA-Z])(uml|acute|grave|circ|tilde);/','',$str);
/*

	$substituto[1]='';
	$substituto[2]=':';
	$substituto[3]=';';
	$substituto[4]='[';
	$substituto[5]=']';
	$substituto[6]='{';
	$substituto[7]='}';
*/
	$substituto[0]='/&([a-zA-Z])(uml|acute|grave|circ|tilde);/';
	$substituto[1]='" "';
	//NMBUPGRADE// $nome_limpo=preg_replace($substituto,'',$_POST['nome_conta']);
    $nome_limpo=preg_replace_callback($substituto, function ($matches) { return ''; }, $_POST['nome_conta']);

        $pega_nome="select login from unix where login='".$nome_limpo."'";
        $query_unix=pg_query($pega_nome);
        $num_unix=pg_num_rows($query_unix);

// ver como determinar se esses caracteres fazem parte do nome
	// Se houver acentos ou caracteres proibidos, solicitar outro nome antes de continuar:
	if ((strlen($nome_limpo)!=strlen($_POST['nome_conta'])) OR ($_POST['senha1']!=$_POST['senha2']) OR ($num_unix!=0)) 
		{
		
//                 #################################
//                  COPLOCQR AQUI O FORMULARIO
                if (strlen($nome_limpo)!=strlen($_POST['nome_conta'])) $mensagem1="O nome da conta n&atilde;o pode conter caracteres especiais"; else $mensagem1="";
                if ($_POST['senha1']!=$_POST['senha2']) $mensagem2="As senhas devem ser id&ecirc;nticas"; else $mensagem2="";
                if ($num_unix!=0) $mensagem3="Escolha outro nome para a conta; j&aacute; existe um login com este nome"; else $mensagem3="";
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
        <td align=center colspan=1 class=header align=center><h1>Cria&ccedil;&atilde;o/Atualiza&ccedil;&atilde;o de Contas especiais</h1></td>\
</tr>
  <form method="POST" name="formu" action="incluir_conta.php">
<tr>
        <td align=center>
          <table class=form>
   <tr>
        <table border class=form align=center>
        <tr><td colspan=4 class=header align=center>Contas j&aacute; existentes</td></tr>
      <tr><td><b>Ativar/Desativar</b></td><td> <b>Nome da conta</b></td><td><b>Descri&ccedil;&atilde;o</b></td><td><b>Status</b></td></b></tr>
                <?php
                 while($registro = pg_fetch_row($query_contas)) //enquanto houver
                        {
//                        $descricao=mb_convert_encoding($registro[2],"UTF-8");
                        $descricao=$registro[2];
                        $valor_da_conta=$registro[0]."-".$registro[1]."-".$registro[4];
                    echo "<tr><td><input type=radio name='eliminar' value=".$valor_da_conta."></td><td>".$registro[1]."</td><td>".$descricao."</td><td>".$registro[4]."</td></tr>";
                        }
                 ?>
         </table>
         </td>
         </tr>
        <tr></tr>
        <tr>  <td align=center>
               <table border class=form align=center>
               <tr><td colspan=5 class=header align=center>Criar uma Nova Conta</td></tr>
               <tr><td colspan=5><blink><?php echo $mensagem1;?></blink></td></tr>
               <tr><td colspan=5><blink><?php echo $mensagem2;?></blink></td></tr>
               <tr><td colspan=5><blink><?php echo $mensagem3;?></blink></td></tr>
               <tr><td><b>Criar</b></td><td> <b>Nome da conta</b></td><td><b>Descri&ccedil;&atilde;o</b></td><td><b>Senha</b></td><td><b>Confi\
rmar senha</b></td></tr>
               <tr><td><input type=hidden name='criar' value="criar"></td><td> <input type=text name='nome_conta' maxlength=10 size=12 value="<?php echo $_POST['nome_conta'];?>"> </td><td><input type=text name='descricao' maxlength=200 size=50 value="<?php echo $_POST['descricao'];?>"> </td><td><input type=password name='senha1' size=10></td><td><input type=password name='senha2' size=10></td></tr>
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
//         ##################################
		}
		else 
		{
//		$descricao=mb_convert_encoding($_POST['descricao'],"ISO-8859-1","UTF-8");
		$descricao=$_POST['descricao'];
		$query_cria="insert into contas_especiais values(default,'".$_POST['nome_conta']."','".$descricao."','".$data_de_hoje."','ativa')";
		$res_cria=pg_query($query_cria);
                $pega_codigo="select codigo from contas_especiais where nome_conta='".$_POST['nome_conta']."'";
                $query_codigo=pg_query($pega_codigo);
                $res_codigo=pg_fetch_row($query_codigo);

                $pega_uid="select uid+1 from unix order by uid desc limit 1"; 
                $query_uid=pg_query($pega_uid);
                $res_uid=pg_fetch_row($query_uid);
                $uid=$res_uid[0];

                $homedir="/home/".$_POST['nome_conta'];
//		echo "insert into unix values('".$_POST['nome_conta']."','".crypt($_POST['senha1'])."','".$uid."','10000','1','','".$homedir."','/bin/tcsh','0','0','500Mb','100Mb','contas_especiais','nao')"; 
		$query_unix="insert into unix values('".$_POST['nome_conta']."','".crypt($_POST['senha1'])."','".$uid."','10000','1','','".$homedir."','/bin/tcsh','0','0','500Mb','100Mb','contas_especiais','nao')"; 
		$res_unix=pg_query($query_unix);

// $query="insert into unix values ('".$this->login."','".crypt($this->passwd)."','".$uid[0]."','".$gid."','1','".$this->gecos."','/home/".$this->login."','bash','0','".$cota_impressao."','".$cota_disco."','".$cota_mail."','".$tabela_user."','".$ssh."')";

                echo "\n";
		echo "Conta ".$_POST['nome_conta']."@mat.unb.br criada com sucesso.";
		}
	}
}
pg_close($idconn);
?>
