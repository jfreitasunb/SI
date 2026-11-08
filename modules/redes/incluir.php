<?php
  require("head_redes.php"); //necessita deste arquivo para conectar arquivos de acesso, banco de dados e etc...
  include("funcoes_gera_arquivos.php");

//include("date.php");
//  include ("ip.php"); //para gerar o ip
// include ("gera_dhcp.php"); //para gerar o arquivo dhcpd.conf atualizado
?>
<html>
<header>
   <script language="javascript">
    <script language=javascript src="function_js.js">
    </script>
    <script language=javascript>
	function verif_mac(e)
	{
        if(e.keyCode)touche = e.keyCode;
        else touche = e.which;
        if((touche >= 48 && touche <= 57) || (touche >= 65 && touche <= 70) || (touche == 8 || touche == 9))return true;
        else {
		alert("Endereco MAC invalido; os caracteres devem ser letras maiusculas entre A e F ou numeros entre 0 e 9.");
                document.forms["cadastro_ip"].mac1.focus();
		return false;
		}
	}
    </script>
    <script language=javascript>
	function validaForm()
		{
		 if ((document.forms["cadastro_ip"].mac1.value.length <2 ) ||(document.forms["cadastro_ip"].mac2.value.length < 2) || (document.forms["cadastro_ip"].mac3.value.length < 2)||(document.forms["cadastro_ip"].mac4.value.length < 2) ||(document.forms["cadastro_ip"].mac5.value.length < 2)||(document.forms["cadastro_ip"].mac6.value.length < 2))
		  {
		    alert("O campo correspondente ao endereco MAC e obrigatorio. Verifique se foi preenchido na forma xx:xx:xx:xx:xx:xx.");
		    document.forms["cadastro_ip"].mac1.focus();
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
if(!isset($_POST['enviar'])) // Se campos do formulario estiverem em branco, faça .....
	{
?>
<form name="cadastro_ip" method="POST" action="incluir.php" onSubmit="return validaForm()"><p>
<tr>
        <td align=center>
          <table class=form>
          <tr>
            <td colspan=4 class=header align=center>
              Descria&ccedil;&atilde;o do Equipamento :
            </td>
          </tr>
          <tr>
            <td> Usuario : </td>
	    <td>
              <select size="1" name="host">
				<option value="MAT">M&aacute;quina do MAT</option>
	<?php                                   		// gera a lista de usuarios registrados
		$res = db_query("SELECT * FROM users where name<>'root' order by name", array());
		while($registro = db_fetch_row($res)) //enquanto ouver registro escreva
		{
			$coduser = $registro[0];  		// primeira coluna da tabela usuario
			$titulo = $registro[1]." ".$registro[2];         // segunda coluna da tabela usuario
			echo "<option value=\"" . h($coduser) . "\">" . h($titulo) . "</option>\n"; //Escreva o codigo e o nome do usuario
		}
	?>
	</select>
	<input type="hidden" name="enviar" value="S">
       	<td>Patrimonio:</td><td><input type="text" name="patrimonio" size="20" ></td></td>
	<tr>
	<td></td><td></td><td>Teclado:</td><td><SELECT NAME="teclado">
				<OPTION>PS/2
				<OPTION>USB
				</SELECT>
	Mouse:<SELECT NAME="mouse">
				<OPTION>PS/2
				<OPTION>Serial
				<OPTION>USB
				</SELECT></td>          
	</tr>
	<tr>
	<td></td><td></td><td>Layout do Teclado:</td>
		          <td><SELECT NAME="layout_teclado">
                                <OPTION>abnt2
                                <OPTION>us
                                </SELECT>
                                </td>
	</tr>
	<tr>
            <td> Sala : </td>
            <td>
              <select size="1" name="sala">
        <?php                                                   // gera a lista de salas registradas
                $res_sala = db_query("SELECT * FROM room where codloc<>'123' order by codloc", array());
                while($registro_sala = db_fetch_row($res_sala)) //enquanto ouver registro escreva
                {
                        $codloc = $registro_sala[0];                // primeira coluna da tabela usuario
			$descricao=$registro_sala[1];
                        echo "<option value=\"" . h($codloc) . "\">" . h($descricao) . "</option>\n"; //Escreva o codigo e o nome do usuario
                }
        ?>
        </select></td>
	<td>Resolucao de Tela:<td><SELECT NAME="resolucao">
				<OPTION>1920x1080
				<OPTION>1440x900
				<OPTION>1280x1024
				<OPTION>1280x800
				<OPTION>1024x768
				<OPTION>800x600
				<OPTION>640x480
				</SELECT></td>   
	<tr><td>Tipo de Maquina :</td><td><SELECT NAME="id_maquina" >
					<OPTION>Terminal Leve
					<OPTION>Desktop
					<OPTION>Laptop
					</SELECT></td>
<?php
//	<td>End. MAC (xx:xx:xx:xx:xx:xx) :</td><td><input type="text" name="mac" size="17" ></td>
?>  
 	<td>End. MAC :</td><td><input type=text name="mac1" maxlength="2" size="1" onkeypress="return verif_mac(event);" >:<input type=text name="mac2" maxlength="2" size="1" onkeypress="return verif_mac(event);">:<input type=text name="mac3" maxlength="2" size="1" onkeypress="return verif_mac(event);">:<input type=text name="mac4" maxlength="2" size="1" onkeypress="return verif_mac(event);">:<input type=text name="mac5" maxlength="2" size="1" onkeypress="return verif_mac(event);">:<input type=text name="mac6" maxlength="2" size="1" onkeypress="return verif_mac(event);"></td>

	</table><br>
	<input type="submit" value="Cadastrar Maquina" name="incluir"> 
	</form>
	</body>
	</html>
<?php

	}

	////////////////////////////////////////////////////////////////////////////////////////////////////////////////////// 
else	//////////////////Cadastra o equipamento /////////////////////////////////////////////////////////////////////////////
{	//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	$status='1';
//	$date=$_POST['date'];
//	$id_usuario=$_POST['id_usuario'];
	$host=$_POST['host'];	
	//////////////////////////////////////// host ///////////////////////////////////////////////////////////////////////////////
//  se existe alguma máquina como $host_"alguma coisa". Se não existir então o host é $host_1 
//    se existir, então devemos saber quantas há e numerar de acordo:
/*
	$query_host="select host from computers where host like '".$host."%' order by host DESC";
	$res_host=pg_query($query_host);
	$linhas_host=db_num_rows($res_host);
	$final=$linhas_host + 1;
	$host=$host."_".$final;
*/
	$host=gera_hostname($host);  // acrescentado em 25/04/08
	//////////////////////////////// fim do host //////////////////////////////////////////////////////////////////////////

	$sala=$_POST['sala']; //"123";
//	$tipo_usuario=$_POST["tipo_usuario"];
	$tipo_mouse=$_POST["mouse"];
	$tipo_teclado=$_POST["teclado"];
	$tipo_layout_teclado=$_POST["layout_teclado"];

	$patrimonio=$_POST["patrimonio"];
	if ($patrimonio =="") $patrimonio=gera_sem_patrimonio();
/*		{
//		$patrimonio=$host . $id_maquina;
//		$patrimonio=$_POST['mac1'].$_POST['mac2'].$_POST['mac3'].$_POST['mac4'].$_POST['mac5'].$_POST['mac6'];
		$query_maqcod="select maqcod from computers where maqcod like 'sp_%'";
		$res_maqcod=pg_query($query_maqcod);
		$num_sp=db_num_rows($res_maqcod) + 1;
		$patrimonio="sp_".$num_sp;
		}
*/
//        $mac=$_POST["mac"];
      $mac=$_POST['mac1'].":".$_POST['mac2'].":".$_POST['mac3'].":".$_POST['mac4'].":".$_POST['mac5'].":".$_POST['mac6'];

	$resolucao=$_POST["resolucao"];
	$id_maquina=$_POST["id_maquina"];
	////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	$ip=gera_IP($id_maquina,$sala);
/*
	//////////////////Gera a lista de usuarios registrados ////////////////////////////////////////////////////////////////////////
	////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
		
	$ip_38=array();
	$ip_39=array();
	$qu = pg_query("select * from computers where status<>0 order by ipnet;");
	$nlinha = db_num_rows($qu);

	///////////////processa os dados em ordem crescente de ip ///////////////////////////////////////////////////////////////////

	for ($lt = 0; $lt < $nlinha; $lt++) 
  		{
		$ip_test = db_result($qu, $lt,'ipnet'); 							// o número da coluna que tem o IP é 1.
		$ip_test_explodido=explode(".",$ip_test);
		if ($ip_test_explodido[2]==38)  {$ip_38[$lt]=$ip_test;$rede_38=$lt;}	// seleciona os ip da rede 38 na array $ip_38:
		if ($ip_test_explodido[2]==39)  $ip_39[$lt-$rede_38-1]=$ip_test;	// seleciona os ip da rede 39 na array $ip_39:
		}
	////////Associa IP: os IP válidos em cada rede começam com 172.16.3x.11 até 172.16.3x.254 ////////////////////////////////////


	///////////// Decidir se vai para a rede 38 ou rede  39 //////////////////////////////////////////////////////////////////////

	if ($id_maquina=="Terminal Leve") //  || ($sala=="Laboratorio"))  modificado em 31/03/08
		{
		$i=11;
	        do 
		   {
        	    $ip_provavel=explode(".",$ip_38[$i-11]);
        	    $i++;
		    $j=$i-1;		
		   }
           	while($ip_provavel[3]==$j); // "finalde" é o final do número IP
        	$ip="172.16.38.".$j ;// é o IP que será cadastrado
					//	echo "Este vai ser o numero do ip usado na rede 38: ";
					//	print $ip;

		}
//	elseif (($id_maquina=="Pessoal_1") or ($id_maquina=="Pessoal_2") or ($id_maquina=="Pessoal_3"))
	else  // if ($id_maquina=="Pessoal") modificado em 31/03/08
		{
		$i=11;
		do 
		    {
        	    $ip_provavel=explode(".",$ip_39[$i-11]);
        	    $i++;
		    $j=$i-1;		
		    }
        	while($ip_provavel[3]==$j); // "finalde" é o final do número IP
		$ip="172.16.39." . $j; // é o IP que será cadastrado  
					//	echo "Este vai ser o numero ip usado na rede 39:";
					//	print $ip;
		}
*/
	/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	if ($_POST['host']=="MAT")
		{
		$new_year=date("Y")+5;
		$new_month=date("m");
		$new_day=date("d");		
		$new_data=$new_year."-".$new_month."-".$new_day;
		}
	else
		{
		$query_data_visitor="select date_end from visitor where coduser=? order by date_end DESC"; $query_data_visitor__p = array($_POST['host']);
		$res_data_visitor=db_query($query_data_visitor, $query_data_visitor__p);
		$linhas_visitor=db_num_rows($res_data_visitor);

		$query_data_student="select depart_date1 from student where coduser=? order by depart_date1 DESC"; $query_data_student__p = array($_POST['host']);
		$res_data_student=db_query($query_data_student, $query_data_student__p);
		$linhas_student=db_num_rows($res_data_student);

		$query_data_fonctionnaire="select contract_end from fonctionnaire where coduser=?"; $query_data_fonctionnaire__p = array($_POST['host']);
		$res_data_fonctionnaire=db_query($query_data_fonctionnaire, $query_data_fonctionnaire__p);
		$linhas_fonctionnaire=db_num_rows($res_data_fonctionnaire);

		if (($linhas_visitor!=0) and ($linhas_student!=0) and ($linhas_fonctionnaire!=0))
			{
			$data_visitor_0=db_fetch_array($res_data_visitor,0);
			$data_student_0=db_fetch_array($res_data_student,0);
			$data_fonctionnaire_0=db_fetch_array($res_data_fonctionnaire,0);
			$data_visitor=$data_visitor_0[0];
			$data_student=$data_student_0[0];
			$data_fonctionnaire=$data_fonctionnaire_0[0];
			$data_fon_0=explode("-",$data_fonctionnaire);
			$data_vis_0=explode("-",$data_visitor);
			$data_stu_0=explode("-",$data_student);
			$array_datas=array("fonctionnaire" => $data_fon_0,"visitor" => $data_vis_0,"student" => $data_stu_0);
			asort($array_datas);
			foreach( $array_datas as $chave => $valor ){$chave_0=$chave;}
			$new_data="$data_".$chave_0;
			}

		if (($linhas_visitor!=0) and ($linhas_student!=0))
			{
			$data_visitor_0=db_fetch_array($res_data_visitor,0);
			$data_student_0=db_fetch_array($res_data_student,0);
			$data_visitor=$data_visitor_0[0];
			$data_student=$data_student_0[0];
			$data_vis_0=explode("-",$data_visitor);
			$data_stu_0=explode("-",$data_student);
			if (implode('',$data_vis_0) > implode('',$data_stu_0)) $new_data=$data_visitor; else $new_data=$data_student;
			}
		if (($linhas_fonctionnaire!=0) and ($linhas_student!=0))
			{
			$data_fonctionnaire_0=db_fetch_array($res_data_fonctionnaire,0);
			$data_student_0=db_fetch_array($res_data_student,0);
			$data_fonctionnaire=$data_fonctionnaire_0[0];
			$data_student=$data_student_0[0];
			$data_fon_0=explode("-",$data_fonctionnaire);
			$data_stu_0=explode("-",$data_student);
			if (implode('',$data_fon_0) > implode('',$data_stu_0)) $new_data=$data_fonctionnaire; else $new_data=$data_student;
			}
		if (($linhas_visitor!=0) and ($linhas_fonctionnaire!=0))
			{
			$data_visitor_0=db_fetch_array($res_data_visitor,0);
			$data_fonctionnaire_0=db_fetch_array($res_data_fonctionnaire,0);
			$data_visitor=$data_visitor_0[0];
			$data_fonctionnaire=$data_fonctionnaire_0[0];
			$data_vis_0=explode("-",$data_visitor);
			$data_fon_0=explode("-",$data_student);
			if (implode('',$data_vis_0) > implode('',$data_fon_0)) $new_data=$data_visitor; else $new_data=$data_fonctionnaire;
			}
		if (($linhas_visitor!=0) and ($linhas_student==0) and ($linhas_fonctionnaire==0))
			{
			$data_visitor_0=db_fetch_array($res_data_visitor,0);
			$data_visitor=$data_visitor_0[0];
			$new_data=$data_visitor;
			}

		if (($linhas_visitor==0) and ($linhas_student!=0) and ($linhas_fonctionnaire==0))
			{
			$data_student_0=db_fetch_array($res_data_student,0);
			$data_student=$data_student_0[0];
			$new_data=$data_student;
			}
		if (($linhas_visitor==0) and ($linhas_student==0) and ($linhas_fonctionnaire!=0))
			{
			$data_fonctionnaire_0=db_fetch_array($res_data_fonctionnaire,0);
			$data_fonctionnaire=$data_fonctionnaire_0[0];
print " data de encerramento: ".h($data_fonctionnaire);
			$new_data=$data_fonctionnaire;
			}
	}
//
//	Antes de cadastrar, verifica se existe um amáquina ativa com o memso endereço MAC: se houver, o cadastro não será efetuado!
//	
	$query_mac="select host from computers where mac=? and status='1'"; $query_mac__p = array($mac);
        $res_mac=db_query($query_mac, $query_mac__p);
        $linhas_mac=db_num_rows($res_mac);
        if (($linhas_mac==0) and ($ip <> "out_of_range"))
	{
	$query_computers="INSERT INTO computers VALUES(?,?,?,?,?,?,?,?,?,?,?,?)"; $query_computers__p = array($patrimonio, $ip, $sala, $host, $mac, $tipo_mouse, $tipo_teclado, $resolucao, $id_maquina, $status, $new_data, $tipo_layout_teclado);
	$res = db_query($query_computers, $query_computers__p);
	if(db_affected_rows($res)>0)
		{
		echo "<p align='center'>Maquina cadastrada!</p>";
		///////////////////////////////////////////////////gera os arquivos /////////////////////////////////////////////
		gera_dhcp();
		gera_hosts ();
		gera_lts ();
		}
	else	
		{
	//	$erro = db_last_error();
	//	echo "<p align='center'>Erro: $erro</p>";
		echo "Observe se a data foi escrita no formato xx/xx/xxxx, como por exemplo 16/11/2007";
		}
	}
	else 
	{
	$host_cadastrado=db_fetch_array($res_mac);
	echo "A maquina nao pode ser cadastrada porque a ".h($host_cadastrado['host'])." já esta cadastrada com o 
mesmo mac! ou a margem de IP extrapolou:".h($ip)."!";
	}
	}

?>
