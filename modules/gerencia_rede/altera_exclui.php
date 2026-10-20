<?php 
// Seleciona os dados das maquinas de usuarios; permite eliminar e/ou modificar dados de maquinas

  require("head_redes.php"); //necessita deste arquivo para conectar arquivos de acesso, banco de dados e etc...
  include("funcoes_gera_arquivos.php");

//include("date.php");
//  include ("ip.php"); //para gerar o ip
// include ("gera_dhcp.php"); //para gerar o arquivo dhcpd.conf atualizado
?>
<html>
<header>
    <script language=javascript src="navig_js.js">
    </script>
 <script language=javascript>
	function verif_mac(e)
	{
        if(e.keyCode)touche = e.keyCode;
        else touche = e.which;
        if((touche >= 48 && touche <= 57) || (touche >= 65 && touche <= 70) || (touche == 8 || touche == 9))return true;
        else {
		alert("Endereco MAC invalido; os caracteres devem ser letras maiusculas entre A e F ou numeros entre 0 e 9.");
                document.forms["utilisateur"].mac1.focus();
		return false;
		}
	}
    </script>
    <script language="javascript"> 
        var utilisateurs = new Array();
      var i = 0;
    </script>
    <script language=javascript>
	function validaForm()
		{
		 if ((document.forms["utilisateur"].mac1.value.length < 2) ||(document.forms["utilisateur"].mac2.value.length < 2) || (document.forms["utilisateur"].mac3.value.length < 2)||(document.forms["utilisateur"].mac4.value.length < 2) ||(document.forms["utilisateur"].mac5.value.length < 2)||(document.forms["utilisateur"].mac6.value.length < 2))
		  {
		    alert("O campo correspondente ao endereco MAC e obrigatorio. Queira informa-lo, por favor.");
		    document.forms["utilisateur"].mac1.focus();
		    return false;
		  }
		}
    </script>
    <link type="text/css" rel="stylesheet" href="../../global/grafic.css">
 <meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
  </header>
<body>
<table class=big>
      <tr>
        <td class=header align=center>
          <h1>Cadastro de M&aacute;quinas</h1>Informa&ccedil;&otilde;es sobre computadores
        </td>
      </tr>
      <tr>
        <td align=center>
               <title>Cadastrar de M&aacute;quina</title>
<?php
      ////////////////// VERIFICA SE O FORMULARIO ESTA PREENCHIDO ////////////////////////////////////////////////
if ((!isset($_POST['usuario'])) and (!isset($_POST['maquina'])))// Se o usuario nao tiver sido escolhido
	{
?>
<form name="cadastro_ip" method="POST" action="altera_exclui.php" onSubmit="return validaForm()"><p>
<tr>
        <td align=center>
          <table class=form>
          <tr>
            <td colspan=4 class=header align=center>
              Selecione um usu&aacute;rio :
            </td>
          </tr>
          <tr>
            <td> Usuario : </td>
	    <td>
              <select size="1" name="host">
				<option value="MAT">M&aacute;quina do MAT</option>
	<?php                                   		// gera a lista de usuarios registrados
								// seleciona usuario e patrimonio das máquinas do usuario.
		$res = db_query("SELECT * FROM users where name<>'root' order by name", array());
		while($registro = db_fetch_row($res)) //enquanto ouver registro escreva
		{
			$host = $registro[0];  		// primeira coluna da tabela usuario
			$titulo = $registro[1]." ".$registro[2];         // segunda coluna da tabela usuario
			echo "<option value=\"$host\">$titulo</option>\n"; //Escreva o codigo e o nome do usuario
		}
	?>
	</select>
	</table><br>
        <table class=form>
	<input type="submit" value="Confirmar" name="usuario"> 
	</table>
	</form>
	</body>
	</html>
<?php
	}
else if ((isset($_POST['usuario'])) and (!isset($_POST['maquina'])))
	{
?>
	<form name="utilisateur" method="POST" action="altera_exclui.php" onSubmit="return validaForm()"><p>
	<tr>
        <td align=center>
          <table class=form>
          <tr>
            <td colspan=4 class=header align=center>
              Descria&ccedil;&atilde;o do Equipamento :
            </td>
          </tr>
<?php
	$host=$_POST['host'];
	$query_maquinas="SELECT * FROM computers where host like ? order by ipnet"; $query_maquinas__p = array($host.'%');
	$res_maquinas = db_query($query_maquinas, $query_maquinas__p);
	$linhas_maquinas=db_num_rows($res_maquinas);
?>
            <tr><td><select name='maquina' onchange="enregistrement(utilisateurs,this.selectedIndex,nb_enreg);">
<?php
            for ($i=0;$i<$linhas_maquinas;$i++)
            {
               $tab=db_fetch_array($res_maquinas, $i);

		$mac=explode(":",$tab['mac']);
		$data_encerramento=explode("-",$tab['data_encerramento']);
		$dia=$data_encerramento['2'];
		$mes=$data_encerramento['1'];
		$ano=$data_encerramento['0'];
//patrimonio ; end. IP; sala ; host; end. MAC; tipo mouse; tipo teclado; resol. tela ; tipo de maquina;  status (ativa/nao ativa) ; data_encerramento
// maqcod    | ipnet  |codloc| host| mac     | mouse     | keyboard    | resolucao   | tipo_maquina   | status                    | data_encerramento| layout_teclado

               $param="'".$tab['maqcod']."','".$tab['ipnet']."','".$tab['codloc']."','".$tab['host']."','".$mac['0']."','".$mac['1']."','".$mac['2']."','".$mac['3']."','".$mac['4']."','".$mac['5']."','".$tab['mouse']."','".$tab['keyboard']."','".$tab['layout_teclado']."','".$tab['resolucao']."','".$tab['tipo_maquina']."','".$dia."','".$mes."','".$ano."'";
               $param=str_replace(CHR(10)," ",$param);
               $param=str_replace(CHR(13)," ",$param);
?>
	       <script language="javascript">
                 utilisateurs[<?php echo $i ?>] = new users(<?php echo $param ?>);
               </script>
<?php
               echo "<option value='".$tab['maqcod']."'";
               if ($_GET['US']==$tab['maqcod']) echo " selected  ";
               echo ">".$tab['ipnet']."--".$tab['host']." em ".$tab['codloc']."</option>";
		}

    	?>
            </select></td></tr>
	<tr>
       	<td>Patrimonio:<input name="patrimonio" size="20" readonly></td>
	<td>Tipo de Maquina :<input type=text name="id_maquina0" size="10" >
                                        <SELECT NAME="id_maquina" >
                                        <OPTION value="nao_altera" selected> n&atilde;o altera
                                        <OPTION value="Terminal Leve">Terminal Leve
                                        <OPTION value="Desktop">Desktop
                                        <OPTION value="Laptop">Laptop
                                        </SELECT></td>

	</tr>
	<tr>
       	<td>Host: <input name="host" size="10" readonly></td>
	<td>Teclado          :<input type=text name="teclado0" size="4" >
                                <SELECT NAME="teclado">
                                <OPTION value="nao_altera" selected> n&atilde;o altera
                                <OPTION value="PS/2" >PS/2
                                <OPTION value="USB">USB
                                </SELECT></td>
	<td>Layout do teclado:<input type=text name="layout_teclado0" size="5" >
                                <SELECT NAME="layout_teclado">
                                <OPTION value="nao_altera" selected> n&atilde;o altera
                                <OPTION value="abnt2" >abnt2
                                <OPTION value="us">us
                                </SELECT></td>
	</tr>
	<tr>
	<td>Status: <SELECT NAME="status">
				<OPTION value="1" selected>ativo
				<OPTION value="0">n&atilde;o ativo
				</SELECT></td>
	<td>Mouse             :<input type=text name="mouse0" size="6" >
                                <SELECT NAME="mouse">
                                <OPTION value="nao_altera" selected> n&atilde;o altera
                                <OPTION value="PS/2">PS/2
                                <OPTION value="Serial">Serial
                                <OPTION value="USB">USB
                                </SELECT></td>

	</tr>
	<tr>
	<td>Sala: <input type=text name="sala0" size="15" >
              <select size="1" name="sala">
				<OPTION value="nao_altera" selected> n&atilde;o altera 
        <?php                                                   // gera a lista de salas registradas
                $res_sala = db_query("SELECT * FROM room where codloc<>'123' order by codloc", array());
                while($registro_sala = db_fetch_row($res_sala)) //enquanto ouver registro escreva
                {
                        $codloc = $registro_sala[0];                // primeira coluna da tabela usuario
                        $descricao=$registro_sala[1];
                        echo "<option value=\"$codloc\">$descricao</option>\n"; //Escreva o codigo e o nome do usuario
                }
        ?>
        </select></td>
	<td>Resolucao de Tela:<input type=text name="resolucao0" size="15" >
				<SELECT NAME="resolucao">
				<OPTION value="nao_altera" selected> n&atilde;o altera 
				<OPTION value="1920x1080">1920x1080
				<OPTION value="1280x1024">1440x900
				<OPTION value="1280x1024">1280x1024
				<OPTION value="1280x800">1280x800
				<OPTION value="1024x768">1024x768
				<OPTION value="800x600">800x600
				<OPTION value="640x480">640x480
				</SELECT></td>   
	</tr>
	<tr>
 	<td>End. MAC :<input type=text name="mac1" maxlength="2" size="1"  onkeypress="return verif_mac(event);">:<input type=text name="mac2" maxlength="2" size="1"  onkeypress="return verif_mac(event);">:<input type=text name="mac3" maxlength="2" size="1"  onkeypress="return verif_mac(event);">:<input type=text name="mac4" maxlength="2" size="1"  onkeypress="return verif_mac(event);">:<input type=text name="mac5" maxlength="2" size="1"  onkeypress="return verif_mac(event);">:<input type=text name="mac6" maxlength="2" size="1"  onkeypress="return verif_mac(event);"></td>
 	 <td>End. IP:<input type=text name="ipnet" maxlength="14" size="10" readonly></td>
	<td>Data de encerramento:<input type=text name="dia" maxlength="2" size="1">/<input type=text name="mes" maxlength="2" size="1">/<input type=text name="ano" maxlength="4" size="3"></td>
	</tr>
	</table><br>
	<input type="submit" value="Corrigir dados da Maquina" name="maquina"> 
	  </form>
	  <script language="javascript">
	    var nb_enreg = <?php echo $linhas_maquinas-1 ?>;
	    enregistrement(utilisateurs,i,nb_enreg);
	  </script>
	     </table>
	    </body>
	</html>
	<?php
       db_close($idconn);

	
	} 

else if (isset($_POST['maquina']))	
	{
//patrimonio ; end. IP; sala ; host; end. MAC; tipo mouse; tipo teclado; resol. tela ; tipo de maquina;  status (ativa/nao ativa) ; data_encerramento
// maqcod    | ipnet  |codloc| host| mac     | mouse     | keyboard    | resolucao   | tipo_maquina   | status                    | data_encerramento
	if ($_POST['teclado']=="nao_altera") $teclado=$_POST['teclado0']; else $teclado=$_POST['teclado'];
	if ($_POST['layout_teclado']=="nao_altera") $layout_teclado=$_POST['layout_teclado0']; else $layout_teclado=$_POST['layout_teclado'];
	if ($_POST['mouse']=="nao_altera") $mouse=$_POST['mouse0']; else $mouse=$_POST['mouse'];
	if ($_POST['sala']=="nao_altera") $sala=$_POST['sala0']; else $sala=$_POST['sala'];
	if ($_POST['resolucao']=="nao_altera") $resolucao=$_POST['resolucao0']; else $resolucao=$_POST['resolucao'];
	if ($_POST['id_maquina']=="nao_altera") $id_maquina=$_POST['id_maquina0']; else $id_maquina=$_POST['id_maquina'];
	$data=$_POST['ano']."-".$_POST['mes']."-".$_POST['dia'];
	$mac=$_POST['mac1'].":".$_POST['mac2'].":".$_POST['mac3'].":".$_POST['mac4'].":".$_POST['mac5'].":".$_POST['mac6'];
	// compara o status fornecido com o status do banco para atribuir um novo IP se necessario
	$query_status="select status from computers where host=?"; $query_status__p = array($_POST['host']);
	$res_status=db_query($query_status, $query_status__p);
	$status=db_fetch_array($res_status);
	if ($status[0]==$_POST['status']) 
		{
		$ipnet=$_POST['ipnet'];
		}
	else
		{
		if ($_POST['status']=="0") $ipnet="";
		if ($_POST['status']=="1") $ipnet=gera_IP($id_maquina,$sala);
		}
//
//      Antes de cadastrar, verifica se existe uma máquina ativa com o memso endereço MAC: se houver, o cadastro não será efetuado!
//
        $query_mac="select host,maqcod from computers where \nmac=? and status='1'"; $query_mac__p = array($mac);
        $res_mac=db_query($query_mac, $query_mac__p);
	$dados_banco=db_fetch_array($res_mac);
        $linhas_mac=db_num_rows($res_mac);
        if (($ipnet <> "out_of_range") and (($linhas_mac==0) or (($linhas_mac==1) and 
($dados_banco['maqcod']==$_POST['patrimonio']))) )
        {
        $query_muda="update computers set ipnet=?, codloc=?, mac=?, mouse=?, keyboard=?, layout_teclado=?,\n        resolucao=?, tipo_maquina=?, status=?, \ndata_encerramento=? where maqcod=?"; $query_muda__p = array($ipnet, $sala, $mac, $mouse, $teclado, $layout_teclado, $resolucao, $id_maquina, $_POST['status'], $data, $_POST['patrimonio']);
        $res_muda=db_query($query_muda, $query_muda__p);
        gera_dhcp ();
        gera_hosts ();
        gera_lts ();
        echo "Dados e arquivos de configura&ccedil;&atilde;o alterados com sucesso";
	}
        else
        {
        $host_cadastrado=db_fetch_array($res_mac);
	echo "A m&aacute;quina n&atilde;o p&ocirc;de ser cadastrada porque a ".$host_cadastrado[0]." j&aacute; 
est&aacute; ativa e cadastrada com mesmo MAC! Ou A margem de IP já extrapolou:".$ipnet."!";
	}
	db_close($idconn);
	}

?>


