<?php
  require("head_redes.php"); //necessita deste arquivo para conectar arquivos de acesso, banco de dados e etc...
//  include("funcoes_gera_arquivos.php");

/////////
  function cor($i)
	{
	if (is_int($i/2)) return ("#00BFFF"); else return("#FFFFFF"); 
	}
//
function relatorio($query_pesquisa,$host)
{

	$result=db_query($query_pesquisa);
	$retorna=db_fetch_all($result);
	$linhas=db_num_rows($result);

	if (!empty($retorna)) 
	{
	?>
	<tr><td>
	<table border class=form align=center>
	<tr>
	<td colspan=9 class=header align=center>Resultado da pesquisa: foram encontrados  <?php echo h($linhas) ?> dados </td>
	</tr>
	<td colspan=9 class=header align=center>
	<tr>
	<td>Respons&aacute;vel</td><td>Patrim&ohat;nio</td><td> IP </td><td> Local </td><td> host </td><td> MAC </td><td> Tipo </td><td> Ativo </td><td> Data de desativa&ccedil;&atilde;o </td>
	</tr> 
	<?php
	$j=0;
	$cor_anterior="#00BFFF";
// name | firstname | maqcod   |    ipnet     |   codloc    | host  |        mac        | mouse  | keyboard | resolucao | tipo_maquina | status | data_encerramento
	for ($i=0; $i< $linhas; $i++)
		{
		$dados=$retorna[$i];
		if ($i>0) $host_anterior=$retorna[$i-1]['host']; else $host_anterior=$dados['host'];
		$host_anterior_ex=explode("_",$host_anterior); 
		$data_de_encerramento=explode("-",$dados['data_encerramento']);
		$dados_host=explode("_",$dados['host']);
		if ($dados_host[0]=="MAT") $nome="Maquina do MAT"; else $nome=mb_convert_encoding($dados['name'],"ISO-8859-1","UTF-8")." ".mb_convert_encoding($dados['firstname'],"ISO-8859-1","UTF-8");
		$data_encerramento=$data_de_encerramento[2]."/".$data_de_encerramento[1]."/".$data_de_encerramento[0];
		if ($dados['status']==1) $dados_status="sim"; else $dados_status="nao";
		if ($cor_anterior=="#00BFFF") $nova_cor="#FFFFFF"; else $nova_cor="#00BFFF";
		if (($dados_host[0]==$host_anterior_ex[0]) and $i>0) {$j=$j+1; $cor=$cor_anterior;} else {$j=0; $cor=$nova_cor; 
$cor_anterior=$nova_cor;}
	?>
		<tr bgcolor="<?php echo $cor ?>"> 
		<td><?php echo h($nome)?></td>
		<td><?php echo h($dados['maqcod'])?></td>
		<td><?php echo h($dados['ipnet'])?></td>
		<td><?php echo h($dados['codloc'])?></td>
		<td><?php echo h($dados['host'])?></td>
		<td><?php echo h($dados['mac'])?></td>
		<td><?php echo h($dados['tipo_maquina'])?></td>
		<td><?php echo $dados_status?></td>
		<td><?php echo h($data_encerramento)?></td>
		</tr>
	<?php		
		}
	?>
	</table>
	<?php
	}
	else 
	{
	?>
		<table class=form align=center>
	        <tr>
	        <td class=header align=center colspan=1><h1>N&atilde;o h&aacute; dados dispon&iacute;veis para esta pesquisa</h1> </td></tr>
		</table>
	<?php
	}
	
}
////////////
?>
<html>
<header>
   <script language="javascript">
    <script language=javascript src="function_js.js">
    </script>
    <script language=javascript src="formu.js">
    </script>
    <link type="text/css" rel="stylesheet" href="../../global/grafic.css">
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
               <title>Pesquisa de M&aacute;quina</title>
<?php
      ////////////////// VERIFICA SE O FORMULARIO ESTA PREENCHIDO ////////////////////////////////////////////////
if(!isset($_POST['enviar'])) // Se campos do formulario estiverem em branco, faça .....
	{
?>
<form name="relatorio_maquinas" method="POST" action="relatorios.php"><p>
<tr>
        <td align=center>
          <table class=form>
          <tr>
            <td colspan=4 class=header align=center>
              Pesquisa de Equipamento :
            </td>
          </tr>
          <tr>
	<input type="hidden" name="enviar" value="S">
        <td> Nome do usu&aacute;rio : </td><td><select size="1" name="host">
				<option value="todos">Todos os usu&aacute;rios</option>
				<option value="MAT">M&aacute;quina do MAT</option>
				<?php                                   		 	// gera a lista de usuarios registrados
				$res = db_query("SELECT * FROM users where name<>'root' order by name");
				while($registro = db_fetch_row($res)) 				//enquanto houver registro escreva
					{
					$coduser = $registro[0];  		         	// primeira coluna da tabela usuario
					$titulo = $registro[1]." ".$registro[2];         	// segunda coluna da tabela usuario
					echo "<option value=\"" . h($coduser) . "\">" . h($titulo) . "</option>\n"; 	//Escreva o codigo e o nome do usuario
					}
				?>
				</select>
       	<td> Patrimonio:</td><td><input type="text" name="patrimonio" size="20" ></td></td>
	</tr>
	<tr>
        <td> N&uacute;mero IP: </td><td><SELECT NAME="IP0" >
                                        <option value="10.0">10.0</option>
                                        <option value="172.16">172.16</option>
					</SELECT>.<input type=text name="IP1" maxlength="2" size="1">.<input type=text name="IP2" maxlength="4" size="3"></td>
        <td> Endere&ccedil;o MAC: </td><td><input type=text name="mac1" maxlength="2" size="1">:<input type=text name="mac2" maxlength="2" size="1">:<input type=text name="mac3" maxlength="2" size="1">:<input type=text name="mac4" maxlength="2" size="1">:<input type=text name="mac5" maxlength="2" size="1">:<input type=text name="mac6" maxlength="2" size="1"></td>
	</tr>
	<tr>
	<td> Tipo de Maquina: </td><td><SELECT NAME="tipo" >
		                        <option value="todos">Todos os tipos</option>
					<OPTION value="Terminal Leve">Terminal Leve</OPTION>
					<OPTION value="Desktop">Desktop pessoal</OPTION>
					<OPTION value="Laptop">Laptop pessoal</OPTION>  
					</SELECT></td>
	<td> Status: </td><td><select name="status">
			      <option value="todas">Todas as M&aacute;quinas</option>
			      <option value="1">M&aacute;quinas ativas</option>
			      <option value="0">M&aacute;quinas n&atilde;o-ativas</option>
			      </select>
			      </td>
	</tr>
	<tr>
        <td> Sala: </td><td><select size="1" name="sala">
                                <option value="todas">Todas as salas</option>
			        <?php                                                   	// gera a lista de salas registradas
			         $res_sala = db_query("SELECT * FROM room where codloc<>'123' order by codloc");
		                 while($registro_sala = db_fetch_row($res_sala)) 		//enquanto houver registro escreva
			                {
                        		$codloc = $registro_sala[0];                		// primeira coluna da tabela usuario
					$descricao=$registro_sala[1];
                        		echo "<option value=\"" . h($codloc) . "\">" . h($descricao) . "</option>\n"; //Escreva o codigo e o nome do usuario
                			}
			        ?>
		          </select></td>
        <td> Data de desativa&ccedil;&atilde;o at&eacute; (xx/xx/xxxx): </td><td><INPUT type=text name="dia" maxlength="2" size="1">/<INPUT type=text 
name="mes" maxlength="2" size="1">/<input type=text name="ano" maxlength="4" size="3"></td>
	</tr>
	</table><br>
	<input type="submit" value="Pesquisar" name="incluir"> 
	</form>
	</body>
	</html>
<?php

	}
	////////////////////////////////////////////////////////////////////////////////////////////////////////////////////// 
else	////////////////// Pesquisa do equipamento ///////////////////////////////////////////////////////////////////////////
{	//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	$patrimonio=$_POST['patrimonio']; 											// maqcod  
	$host=$_POST['host']; 													// host 
	$ipnet=$_POST['IP0'].".".$_POST['IP1'].".".$_POST['IP2']; 								// ipnet   
	if (empty($_POST['mac1'])) $mac1="%"; else $mac1=$_POST['mac1'];
	if (empty($_POST['mac2'])) $mac2="%"; else $mac2=$_POST['mac2'];
	if (empty($_POST['mac3'])) $mac3="%"; else $mac3=$_POST['mac3'];
	if (empty($_POST['mac4'])) $mac4="%"; else $mac4=$_POST['mac4'];
	if (empty($_POST['mac5'])) $mac5="%"; else $mac5=$_POST['mac5'];
	if (empty($_POST['mac6'])) $mac6="%"; else $mac6=$_POST['mac6'];
	$mac=$mac1.":".$mac2.":".$mac3.":".$mac4.":".$mac5.":".$mac6; 	// mac    
	$tipo=$_POST['tipo']; 													// tipo_maquina 
	$status=$_POST['status']; 												// status 
	$sala=$_POST['sala']; 													// codloc   
	if (!empty($_POST['dia'])) $dia=$_POST['dia']; else $dia="01";
	if (!empty($_POST['mes'])) $mes=$_POST['mes']; else $mes="01";
	if (!empty($_POST['ano'])) $data=$_POST['ano']."-".$mes."-".$dia; else $data="nulo";					// data_encerramento

// maqcod   |    ipnet     |   codloc    | host  |        mac        | mouse  | keyboard | resolucao | tipo_maquina | status | data_encerramento



////se patrimonio!=vazio pesquise por patrimonio sobre as maquinas dos hosts dados e do tipo dado e status dado e sala dada 

	
	if ($host!="todos") 
	{
	if ($host=="MAT") $query_pesquisa="select users.name, users.firstname, computers.* from users, computers where users.name='Guy' 
and computers.host like '".$host."_%'"; 
	else 
	$query_pesquisa="select users.name, users.firstname, computers.* from users,computers where (substring(computers.host from 
'^...')=users.coduser and coduser=".db_quote($host).")"; 
//	else $query_pesquisa="select users.name, users.firstname, computers.* from users, computers where host like '".$host."_%' and 
//coduser=".db_quote($host)."";
	if (!empty($_POST['patrimonio'])) $query_pesquisa=$query_pesquisa." and maqcod like '%".$_POST['patrimonio']."%'";
	if ($tipo!="todos") $query_pesquisa=$query_pesquisa." and tipo_maquina=".db_quote($tipo)."";
	if ($status!="todas") $query_pesquisa=$query_pesquisa." and computers.status=".db_quote($status)."";
	if ($sala!="todas") $query_pesquisa=$query_pesquisa." and codloc=".db_quote($sala)."";
	if (($_POST['IP1']!="") and ($_POST['IP2']!="")) $query_pesquisa=$query_pesquisa." and ipnet=".db_quote($ipnet)."";
	if (($_POST['IP1']!="") and ($_POST['IP2']=="")) $query_pesquisa=$query_pesquisa." and ipnet like '".$_POST['IP0'].".".$_POST['IP1'].".%'";
	if (($_POST['IP1']=="") and ($_POST['IP2']!="")) $query_pesquisa=$query_pesquisa." and ipnet like '".$_POST['IP0'].".%.".$_POST['IP2']."'";
	if ($data!="nulo") $query_pesquisa=$query_pesquisa." and data_encerramento <= ".db_quote($data)."";
	$query_pesquisa=$query_pesquisa." and mac like ".db_quote($mac)." order by host";
	}
	else 
	{
	$query_pesquisa="select users.name, users.firstname, computers.* from users,computers where (substring(computers.host from 
'^...')=users.coduser or (users.name='Guy' and computers.host like 'MAT_%'))"; 
	if (!empty($_POST['patrimonio'])) $query_pesquisa=$query_pesquisa." and maqcod like '%".$_POST['patrimonio']."%'";
	if ($tipo!="todos") $query_pesquisa=$query_pesquisa." and tipo_maquina=".db_quote($tipo)."";
	if ($status!="todas") $query_pesquisa=$query_pesquisa." and computers.status=".db_quote($status)."";
	if ($sala!="todas") $query_pesquisa=$query_pesquisa." and codloc=".db_quote($sala)."";
	if (($_POST['IP1']!="") and ($_POST['IP2']!="")) $query_pesquisa=$query_pesquisa." and ipnet=".db_quote($ipnet)."";
	if (($_POST['IP1']!="") and ($_POST['IP2']=="")) $query_pesquisa=$query_pesquisa." and ipnet like '".$_POST['IP0'].".".$_POST['IP1'].".%'";
	if (($_POST['IP1']=="") and ($_POST['IP2']!="")) $query_pesquisa=$query_pesquisa." and ipnet like '".$_POST['IP0'].".%.".$_POST['IP2']."'";
	if ($data!="nulo") $query_pesquisa=$query_pesquisa." and data_encerramento <= ".db_quote($data)."";
	$query_pesquisa=$query_pesquisa." and mac like ".db_quote($mac)." order by name, host";
	}
///////////////////////////////////

//	$res_pesquisa=db_query($query_pesquisa);
//	$linhas_pesquisa=db_num_rows($res_pesquisa);
//	$data_pesquisa=db_fetch_array($res_pesquisa,0);

// escrever os dados ordenados!!
?>
		<html>
		  <header>
		    <link type="text/css" rel="stylesheet" href="../../global/grafic.css">
		    <script language="JavaScript" src="navig_js.js"></script>
		    <script language="javascript" src="formu.js"></script>
		   </header>
		  <body>
		  <table class=big>
		  <tr>
		      <td class=header align=center>
        	<h1>Relat&oacute;rio de pesquisa</h1>
      		</td>
		</tr>

<?php
		relatorio($query_pesquisa,$host);
?> 		
		<br> 
		</table>
		</body>
		</html>
<?php
}
db_close($idconn);
?>
