<?php
require("head_contas_especiais.php");



$query_contas=db_query("select * from contas_especiais order by nome_conta", array());


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
                 while($registro = db_fetch_row($query_contas)) //enquanto houver                           
                        {
//			$descricao=mb_convert_encoding($registro[2],"UTF-8");
			$descricao=$registro[2];
                        $valor_da_conta=$registro[0]."-".$registro[1]."-".$registro[4];
		        echo "<tr><td><input type=radio name='eliminar' value=\"".h($valor_da_conta)."\"></td><td>".h($registro[1])."</td><td>".h($descricao)."</td><td>".h($registro[4])."</td></tr>";
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
	exige_escrita();
	if (isset($_POST['eliminar']))
	{
       $valor_da_conta=explode("-",$_POST['eliminar']);
        if ($valor_da_conta[2]=="desativada") $status="ativa"; else $status="desativada";
	list($query_elimina, $query_elimina__p) = array("update contas_especiais set status=? where codigo=?", array($status, $valor_da_conta[0]));
	$res_elimina=db_query($query_elimina, $query_elimina__p);
        $nome_da_conta=$valor_da_conta[1];
	list($pega_descricao, $pega_descricao__p) = array("select descricao from contas_especiais where codigo=?", array($valor_da_conta[0]));
        $query_descricao=db_query($pega_descricao, $pega_descricao__p);
        $res_descricao=db_fetch_row($query_descricao);
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
          <tr><td><input type=hidden name='atualizar' value="criar"></td><td> <input type=text name='nome_conta' maxlength=10 size=12 value="<?php echo h($valor_da_conta[1]);?>"> </td><td><input type=text name='descricao' maxlength=200 size=50 value="<?php echo h($res_descricao[0]);?>"> </td><td><input type=password name='senha1' size=10></td><td><input type=password name='senha2' size=10></td></tr>
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

	echo " Conta ".h($valor_da_conta[1])."@mat.unb.br ".$status."\n";
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
               <tr><td><input type=hidden name='atualizar' value="criar"></td><td> <input type=text name='nome_conta' maxlength=10 size=12 value="<?php echo h($_POST['nome_conta']);?>"> </td><td><input type=text name='descricao' maxlength=200 size=50 value="<?php echo h($_POST['descricao']);?>"> </td><td><input type=password name='senha1' size=10></td><td><input type=password name='senha2' size=10></td></tr>
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
	   $nome_conta_upd = isset($_POST['nome_conta']) ? trim((string)$_POST['nome_conta']) : '';
	   if (empty($_POST['senha1']) || !preg_match('/^[a-z][a-z0-9_-]{1,15}$/', $nome_conta_upd)) {
	       http_response_code(400);
	       die(error("Nome de conta ou senha invalidos."));
	   }
	   // Restringe a atualizacao exclusivamente a contas especiais existentes (nunca altera usuarios regulares ou root).
	   $chk_esp = db_query("select 1 from contas_especiais where nome_conta=?", array($nome_conta_upd));
	   if (db_num_rows($chk_esp) == 0) {
	       http_response_code(403);
	       die(error("Conta especial nao encontrada."));
	   }
	   list($atualiza_unix, $atualiza_unix__p) = array("update unix set passwd=? where login=? and tabela_user='contas_especiais'", array(cripta_senha_unix($_POST['senha1']), $nome_conta_upd));
           $query_unix=db_query($atualiza_unix, $atualiza_unix__p);
           //echo $atualiza_unix;
	   echo "\n";
           echo "Conta ".h($nome_conta_upd)."@mat.unb.br atualizada com sucesso.";	   
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
	$nome_conta_novo = isset($_POST['nome_conta']) ? trim((string)$_POST['nome_conta']) : '';
	$nome_valido = (bool)preg_match('/^[a-z][a-z0-9_-]{1,15}$/', $nome_conta_novo);

        list($pega_nome, $pega_nome__p) = array("select login from unix where login=?", array($nome_conta_novo));
        $query_unix=db_query($pega_nome, $pega_nome__p);
        $num_unix=db_num_rows($query_unix);

	if ((!$nome_valido) OR empty($_POST['senha1']) OR ($_POST['senha1']!=$_POST['senha2']) OR ($num_unix!=0)) 
		{
		
                if (!$nome_valido) $mensagem1="O nome da conta deve conter apenas letras minusculas, digitos, _ ou - (2 a 16 caracteres)"; else $mensagem1="";
                if (empty($_POST['senha1']) || $_POST['senha1']!=$_POST['senha2']) $mensagem2="As senhas devem ser id&ecirc;nticas e n&atilde;o vazias"; else $mensagem2="";
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
                 while($registro = db_fetch_row($query_contas)) //enquanto houver
                        {
//                        $descricao=mb_convert_encoding($registro[2],"UTF-8");
                        $descricao=$registro[2];
                        $valor_da_conta=$registro[0]."-".$registro[1]."-".$registro[4];
                    echo "<tr><td><input type=radio name='eliminar' value=\"".h($valor_da_conta)."\"></td><td>".h($registro[1])."</td><td>".h($descricao)."</td><td>".h($registro[4])."</td></tr>";
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
               <tr><td><input type=hidden name='criar' value="criar"></td><td> <input type=text name='nome_conta' maxlength=10 size=12 value="<?php echo h($_POST['nome_conta']);?>"> </td><td><input type=text name='descricao' maxlength=200 size=50 value="<?php echo h($_POST['descricao']);?>"> </td><td><input type=password name='senha1' size=10></td><td><input type=password name='senha2' size=10></td></tr>
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
		list($query_cria, $query_cria__p) = array("insert into contas_especiais values(default,?,?,?,'ativa')", array($_POST['nome_conta'], $descricao, $data_de_hoje));
		$res_cria=db_query($query_cria, $query_cria__p);
                list($pega_codigo, $pega_codigo__p) = array("select codigo from contas_especiais where nome_conta=?", array($_POST['nome_conta']));
                $query_codigo=db_query($pega_codigo, $pega_codigo__p);
                $res_codigo=db_fetch_row($query_codigo);

                list($pega_uid, $pega_uid__p) = array("select uid+1 from unix order by uid desc limit 1", array()); 
                $query_uid=db_query($pega_uid, $pega_uid__p);
                $res_uid=db_fetch_row($query_uid);
                $uid=$res_uid[0];

                $homedir="/home/".$_POST['nome_conta'];
//		echo "insert into unix values('".$_POST['nome_conta']."','".crypt($_POST['senha1'])."','".$uid."','10000','1','','".$homedir."','/bin/tcsh','0','0','500Mb','100Mb','contas_especiais','nao')"; 
		list($query_unix, $query_unix__p) = array("insert into unix values(?,?,?,'10000','1','',?,'/bin/tcsh','0','0','500Mb','100Mb','contas_especiais','nao')", array($_POST['nome_conta'], cripta_senha_unix($_POST['senha1']), $uid, $homedir)); 
		$res_unix=db_query($query_unix, $query_unix__p);

// $query="insert into unix values ('".$this->login."','".crypt($this->passwd)."','".$uid[0]."','".$gid."','1','".$this->gecos."','/home/".$this->login."','bash','0','".$cota_impressao."','".$cota_disco."','".$cota_mail."','".$tabela_user."','".$ssh."')";

                echo "\n";
		echo "Conta ".h($_POST['nome_conta'])."@mat.unb.br criada com sucesso.";
		}
	}
}
db_close($idconn);
?>
