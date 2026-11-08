<?php

function gera_dhcp ()
{
$file = 'dhcpd_cab.txt';
$newfile = 'dhcpd.conf.new.txt';

if (!copy($file, $newfile)) 
	{
	echo "falha ao copiar $file...\n";
	}
else 
	{
	echo "Arquivo gravado com sucesso\n";
	}
	echo "<br />";
	echo "<br />";

$qu = db_query(" select * from computers where status<>0 and codloc<>'lab. grad.';", array());
$row = 0; // postgres needs a row counter
$nlinha = db_num_rows($qu);

$myarray='';
while ($row < $nlinha) 
	{
	$data = db_fetch_object($qu, $row); 
	$myarray= $myarray. "host " . cfg_host($data->host) . "{" . "\n" . "Hardware Ethernet " . cfg_mac($data->mac) . ";" . "\n" . "fixed-address " . cfg_ip($data->ipnet) . 
";". "\n" . "option host-name  \"ws_" . cfg_host($data->host) . "\";}" . "\n" . "\n";
  	$row++;
	}

// Tendo certeza que o arquivo existe e que há permissão de escrita primeiro.
if (is_writable($newfile)) 
	{

    // Em nosso exemplo, nós estamos abrindo $filename em modo de append (acréscimo).
    // O ponteiro do arquivo estará no final dele desde
    // que será aqui que $somecontent será escrito com fwrite().
    if (!$handle = fopen($newfile, 'a')) 
	{
         print "Erro abrindo arquivo ($filename)";
         exit;
	}
    // Escrevendo $somecontent para o arquivo aberto.
    if (!fwrite($handle, $myarray)) 
	{
        print "Erro escrevendo no arquivo ($filename)";
        exit;
	}
    print "Sucesso: escrito ($mystring) no arquivo ($newfile)";
   fclose($handle);
	} 
else 
	{
	print "The file $filename is not writable";
	}

}


function gera_hosts ()
{
$file = 'hosts_cab.txt';
$newfile = 'hosts.new.txt';
	if (!copy($file, $newfile)) 
		{
		    echo "falha ao copiar $file...\n";
		}
	else {
		echo "Arquivo gravado com sucesso\n";}
		echo "<br />";
		echo "<br />";
		$qu = db_query(" select * from computers where status<>0 and codloc<>'lab. grad.';", array());
		$row = 0; 
		$nlinha = db_num_rows($qu);
		$myarray='';
			while ($row < $nlinha) {
				$data = db_fetch_object($qu, $row); 
  				$myarray= $myarray.cfg_ip($data->ipnet). "		ws_".cfg_host($data->host).".ltsp"."		ws_".cfg_host($data->host). "\n" . "\n";
			  	$row++;}

				// Tendo certeza que o arquivo existe e que há permissão de escrita primeiro.
		if (is_writable($newfile)) 
		    {
			    // Em nosso exemplo, nós estamos abrindo $filename em modo de append (acréscimo).
			    // O ponteiro do arquivo estará no final dele desde
    			    // que será aqui que $somecontent será escrito com fwrite().
		    if (!$handle = fopen($newfile, 'a')) 
			{
		         print "Erro abrindo arquivo ($filename)";
		         exit;
			}

			    // Escrevendo $somecontent para o arquivo aberto.
		  if (!fwrite($handle, $myarray)) 
			{
		        print "Erro escrevendo no arquivo ($filename)";
		        exit;
			}
		print "Sucesso: escrito ($mystring) no arquivo ($newfile)";
		fclose($handle);
		   } 
}


function gera_lts ()
{
$file = 'lts_cab.txt';
$newfile = 'lts.conf.new.txt';
	if (!copy($file, $newfile)) 
		{
		    echo "falha ao copiar $file...\n";
		}
	else {
		echo "Arquivo gravado com sucesso\n";}
		echo "<br />";
		echo "<br />";
		$qu = db_query(" select * from computers where status<>0 and codloc<>'lab. grad.';", array());
		$row = 0; 
		$nlinha = db_num_rows($qu);
		$myarray='';
			while ($row < $nlinha) {
				$data = db_fetch_object($qu, $row); 
				$servidor = $data->ipnet;
				$servidor_rede = array();
				$servidor_rede = explode (".",$servidor);
				if ($servidor_rede[2] =='38')
					$server ='172.16.38.5'; //angico1';
					else
					$server ='172.16.38.5'; //'angico2';
				$mouse = $data->mouse;
					if ($mouse =='PS/2')
						$mouse_device = '"/dev/psaux"';
						elseif ($mouse =='Serial')
							$mouse_device = '"/dev/ttyS0"';
							else 
								$mouse_device = '"/dev/udev"';

  				$myarray= $myarray. "[ws_".cfg_host($data->host)."]". "\n" . "SERVER		=\"".$server."\""."\n"."X_MOUSE_PROTOCOL   = \"" . cfg_texto($data->mouse) . "\"" . "\n" . "X_MOUSE_DEVICE     = " . $mouse_device."\n"."X_MODE_0           = ".cfg_texto($data->resolucao). "\n" . "\n";
			  	$row++;}

				// Tendo certeza que o arquivo existe e que há permissão de escrita primeiro.
		if (is_writable($newfile)) 
		    {
			    // Em nosso exemplo, nós estamos abrindo $filename em modo de append (acréscimo).
			    // O ponteiro do arquivo estará no final dele desde
    			    // que será aqui que $somecontent será escrito com fwrite().
		    if (!$handle = fopen($newfile, 'a')) 
			{
		         print "Erro abrindo arquivo ($filename)";
		         exit;
			}

			    // Escrevendo $somecontent para o arquivo aberto.
		  if (!fwrite($handle, $myarray)) 
			{
		        print "Erro escrevendo no arquivo ($filename)";
		        exit;
			}
		print "Sucesso: escrito ($mystring) no arquivo ($newfile)";
		fclose($handle);
		   } 
}


function antigo_gera_IP ($id_maquina,$sala)
{
if ($sala=="lab. grad. 2")
{
$query_labgrad="select ipnet from computers where ipnet like '10.0.0.%' and status<>'0' order by \nipnet"; $query_labgrad__p = array(); 
$res_query_labgrad=db_query($query_labgrad, $query_labgrad__p);
$nlinha_labgrad = db_num_rows($res_query_labgrad);
$ip_1001=array();
for ($lt = 0; $lt < $nlinha_labgrad; $lt++)
                {
//        $ip_1001[$lt] = db_result($res_query_labgrad, $lt,'ipnet');   // o número da coluna que tem o IP é 1.
		$ip_1001_ipnet=db_fetch_array($res_query_labgrad, $lt);
		$ip_test_explodido=explode(".",$ip_1001_ipnet['ipnet']);
                $ip_1001[$lt] = $ip_test_explodido[3];   // o número da coluna que tem o IP é 1.
                }
sort($ip_1001);
        ////////Associa IP: os IP válidos em cada rede começam com 10.0.1.0. até 10.0.1.20. 
////////////////////////////////////
                $i=11;
                do
                   {
                    $ip_provavel=$ip_1001[$i-11]; //explode(".",$ip_1001[$i-11]);
                    $i=$i+1;
                    $j=$i-1;
                   }
                while($ip_provavel==$j); // "finalde" é o final do número IP
		if ($j>254) $ip="out_of_range"; else $ip="10.0.0.".$j ; // é o IP que será cadastrado
                                        //      echo "Este vai ser o numero do ip usado na rede 38: ";
                                        //      print $ip;

}
else
{
//////////////////Gera a lista de usuarios registrados ///////////////////////////////////////////////////////////////////////
$ip_36=array();
$ip_37=array();
$ip_38=array();
$ip_39=array();
$qu = db_query("select * from computers where ipnet like '172.16.%' and status='1' order by ipnet;", array());
$nlinha = db_num_rows($qu);

///////////////processa os dados em ordem crescente de ip ///////////////////////////////////////////////////////////////////

for ($lt = 0; $lt < $nlinha; $lt++)
 	        {
		$ip_test=db_fetch_array($qu,$lt);
//o número da coluna que tem o IP 
		$ip_test_explodido=explode(".",$ip_test['ipnet']);
                if ($ip_test_explodido[2]==38) {$ip_38[$lt]=$ip_test_explodido[3];$rede_38=$lt;}  
//corrigido em 29/07/08
// {$ip_38[$lt]=$ip_test['ipnet'];$rede_38=$lt;}    
// seleciona os ip da rede 38 na array $ip_38:
                if ($ip_test_explodido[2]==39) $ip_39[$lt-$rede_38-1]=$ip_test_explodido[3]; 
//corrigido em 29/07/08
// $ip_39[$lt-$rede_38-1]=$ip_test['ipnet'];        
// seleciona os ip da rede 39 na array $ip_39:
                }
sort($ip_38);
sort($ip_39);

        ////////Associa IP: os IP válidos em cada rede começam com 172.16.3x.11 até 172.16.3x.254 ////////////////////////////////////

 if ($id_maquina=="Terminal Leve")
                {
                $i=11;
                do
                   {
                    $ip_provavel=$ip_38[$i-11];  //explode(".",$ip_38[$i-11]);
echo "ip_38:".h($ip_38[$i-11]);
                    $i=$i+1;
                    $j=$i-1;
echo "ip provavel:".h($ip_provavel);  //$ip_provavel[3];
                   }
//                while($ip_provavel[3]==$j); // "finalde" é o final do número IP
		while($ip_provavel==$j);
                if($j>254) $ip="out_of_range"; else $ip="172.16.38.".$j ;// é o IP que será cadastrado
                                        //      echo "Este vai ser o numero do ip usado na rede 38: ";
                                        //      print $ip;

                }
        else //if ($id_maquina=="Pessoal") corrigido em 31/03/08
                {
                $i=11;
                do
                    {
                    $ip_provavel=$ip_39[$i-11];  //explode(".",$ip_39[$i-11]);
                    $i=$i+1;
                    $j=$i-1;
                    }
//                while($ip_provavel[3]==$j); // "finalde" é o final do número IP
		while($ip_provavel==$j);
		if ($j>254) $ip="out_of_range"; else $ip="172.16.39." . $j; // é o IP que será cadastrado
                                        //      echo "Este vai ser o numero ip usado na rede 39:";
                                        //      print $ip;
                }
}
return $ip;
}

// funcao feita apos a inclusao das redfes 36 e 37.
function gera_IP_na_faixa ($faixa)
{
$qu_faixa= db_query("select substring(ipnet,11) as digitos_finais from computers where ipnet like ? and status='1' order by ipnet;", array($faixa.'%'));
$res_faixa=db_fetch_all($qu_faixa);
$num_faixa=db_num_rows($qu_faixa);

// cria uma array de digitos finais que sera ordenada:
$digitos_finais=array();
for($k=0;$k<$num_faixa;$k++)
{$digitos_finais[$k] = $res_faixa[$k]['digitos_finais'];}
sort($digitos_finais);
//foreach ($digitos_finais as $key => $val) {
//    echo "digitos[".$key."] = ".$val."\n";
//}

    
    if ($num_faixa==0) $ip_faixa_final="11";
    else
	{
	if ($num_faixa==1) {$ip=$faixa.".12"; return $ip;}
	for ($i=0;$i<=$num_faixa-2;$i++)
    	{
//print_r($res_faixa[$i+1]['digitos_finais']);
//	if ($res_faixa[$i+1]['digitos_finais']-$res_faixa[$i]['digitos_finais']!=1)
	if ($digitos_finais[$i+1]-$digitos_finais[$i]>1)
	   {
	//   $ip_faixa_final=$res_faixa[$i]['digitos_finais']+1;
	   $ip_faixa_final=$digitos_finais[$i]+1;
	   $ip=$faixa.".".$ip_faixa_final;
	   return $ip;
	   }
	   else 
	   {
	   	if ($i==$num_faixa-2)
	   	   {
		  // if ($res_faixa[$i+1]['digitos_finais']=='254') $ip_faixa_final="out_of_range";
		   if ($digitos_finais[$i+1]=='254') $ip_faixa_final="out_of_range";
		   //else $ip_faixa_final=$res_faixa[$i+1]['digitos_finais']+1;
		   else $ip_faixa_final=$digitos_finais[$i+1]+1;
		   }
	   }

	   } // final do for
	}// final do else
     if ($ip_faixa_final!="out_of_range") $ip=$faixa.".".$ip_faixa_final; else $ip="out_of_range";
     
return $ip;
} // fim de gera_ip_na_faixa


function gera_IP ($id_maquina,$sala)
{
if ($sala=="lab. grad. 2")  
   {$ip=gera_ip_na_faixa("10.0.0"); return $ip;}
else 
   {
   if ($id_maquina=="Terminal Leve") 
      {$ip=gera_ip_na_faixa("172.16.38"); return $ip;}
   if ($id_maquina!="Terminal_leve") 
      {
      $ip=gera_ip_na_faixa("172.16.36");
      if ($ip!="out_of_range") return $ip;

      $ip=gera_ip_na_faixa("172.16.37");
      if ($ip!="out_of_range") return $ip;

      $ip=gera_ip_na_faixa("172.16.39");
      if ($ip!="out_of_range") return $ip;

      else {$ip="out_of_range"; return $ip;}
      }
   }
//$return $ip;
} // fim novo_gera_IP ($id_maquina,$sala)


function gera_sem_patrimonio()
{
$num_patrimonio=array();
$query_patrimonio="select maqcod from computers where maqcod like 'sp_%'"; $query_patrimonio__p = array(); 
$res_query_patrimonio=db_query($query_patrimonio, $query_patrimonio__p);
$nlinha_patrimonio = db_num_rows($res_query_patrimonio);

if ($nlinha_patrimonio==0) {$sem_patrimonio="sp_1";}
else 
	{
	for ($lt = 0; $lt < $nlinha_patrimonio; $lt++)
                {
                $patrimonio_test=db_fetch_array($res_query_patrimonio,$lt);
                $patrimonio_explodido=explode("_",$patrimonio_test['maqcod']);
		$num_patrimonio[$lt]=$patrimonio_explodido[1];
                }
	$final_max=max($num_patrimonio);
	$final=$final_max+1;
	$sem_patrimonio="sp_".$final;
	}
return $sem_patrimonio;
}


function gera_hostname($host)
{
$num_host=array();
$query_host="select host from computers where host like ? "; $query_host__p = array($host.'%');
$res_host=db_query($query_host, $query_host__p);
$linhas_host=db_num_rows($res_host);

if ($linhas_host==0) {$novo_host=$host."_1";}
else 
	{
	for ($lt = 0; $lt < $linhas_host; $lt++)
                {
                $host_test=db_fetch_array($res_host,$lt);
                $host_explodido=explode("_",$host_test['host']);
                $num_host[$lt]=$host_explodido[1];
                }
	$final_max=max($num_host);
	$final=$final_max+1;
	$novo_host=$host."_".$final;
	}
return $novo_host;
}


?> 
