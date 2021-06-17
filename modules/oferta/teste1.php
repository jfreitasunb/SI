<?PHP

function upload_do_arquivo($name_arquivo,$error_arquivo,$size_arquivo,$tmpname_arquivo)
{

echo "Estou em upload_do_arquivo";

echo $name_arquivo['name'];



// Pasta onde o arquivo vai ser salvo
$_UP['pasta'] = '/paginas/si/modules/oferta/listas_SAA/';

// Tamanho máximo do arquivo (em Bytes)
$_UP['tamanho'] = 1024 * 1024 * 2; // 2Mb

// Array com as extensões permitidas
$_UP['extensoes'] = array('txt');

// Renomeia o arquivo? (Se true, o arquivo será salvo como .jpg e um nome único)
$_UP['renomeia'] = true;

// Array com os tipos de erros de upload do PHP
$_UP['erros'][0] = 'N&atilde;o houve erro';
$_UP['erros'][1] = 'O arquivo no upload &eacute; maior do que o limite do PHP';
$_UP['erros'][2] = 'O arquivo ultrapassa o limite de tamanho especifiado no HTML';
$_UP['erros'][3] = 'O upload do arquivo foi feito parcialmente';
$_UP['erros'][4] = 'N&atilde;o foi feito o upload do arquivo';


// tabela admin_anexos: id_documento, numero_anexo, nome_arquivo


//        if ($_FILES['arquivo']['name']!="")
        if ($name_arquivo!="")
                {
                //############### CASO ESTEJA PRONTO PARA UPLOAD
                // Verifica se houve algum erro com o upload. Se sim, exibe a mensagem do erro
//                if ($_FILES['arquivo']['error'] != 0)
                if ($error_arquivo != 0)
                        {
//                        die("N&atilde;o foi poss&iacute;vel fazer o upload, erro:<br />" . $_UP['erros'][$_FILES['arquivo']['error']]);
                        die("N&atilde;o foi poss&iacute;vel fazer o upload, erro:<br />" . $_UP['erros'][$error_arquivo]);
                        exit; // Para a execução do script
                        }
                // Caso script chegue a esse ponto, não houve erro com o upload e o PHP pode continuar

                // Faz a verificação da extensão do arquivo
//                $extensao = strtolower(end(explode('.', $_FILES['arquivo']['name'])));
                $extensao = strtolower(end(explode('.', $name_arquivo)));
                if (array_search($extensao, $_UP['extensoes']) === false)
                        {
                        echo "Por favor, envie arquivos com as seguintes extens&otilde;es: txt";
                        }

                // Faz a verificação do tamanho do arquivo
//                        else if ($_UP['tamanho'] < $_FILES['arquivo']['size'])
                        else if ($_UP['tamanho'] < $size_arquivo)
                        {
			 echo "O arquivo enviado &eacute; muito grande, envie arquivos de at&eacute; 2Mb.";
                        }
                // O arquivo passou em todas as verificações, hora de tentar movê-lo para a pasta
                        else {
                // Primeiro verifica se deve trocar o nome do arquivo
                                if ($_UP['renomeia'] == true)
                                        {
                // Cria um nome baseado no UNIX TIMESTAMP atual e com extensão .jpg
                                        $nome_final = "carga_profs_".$semestre."_".$ano.".".$extensao;
                                        //echo $nome_final;
                                        } else
                                        {
                // Mantém o nome original do arquivo
//                                        $nome_final = $_FILES['arquivo']['name'];
                                        $nome_final = $name_arquivo;
                                        }

                // Depois verifica se é possível mover o arquivo para a pasta escolhida
//                                if (move_uploaded_file($_FILES['arquivo']['tmp_name'], $_UP['pasta'] . $nome_final))
                                if (move_uploaded_file($tmpname_arquivo, $_UP['pasta'] . $nome_final))
                                        {
                // Upload efetuado com sucesso, exibe uma mensagem e um link para o arquivo; insere ponteiro na tabela
                                        echo "Upload efetuado com sucesso!";
                                        echo '<br /><a href="http://www.mat.unb.br/si/modules/oferta/listas_SAA/'.$nome_final . '">Clique aqui para acessar o arquivo</a><br>';
					$devolve=true;
					}
			
   				}
		  }
                  else
                     {
                // Não foi possível fazer o upload, provavelmente a pasta está incorreta
                     echo "N&atilde;o foi poss&iacute;vel enviar o arquivo, tente novamente";
		     $devolve=false;
                     }
return $devolve;
}
//------------------------

function monta_array_profs()
{
 $query_profs=pg_query ("select name,firstname,coduser,matricul from users where tipo_users='professor' order by name");         
$i=0;
$devolve=array();
$acentos=array(á,à,ã,é,è,ê,í,ó,ò,õ,ô,ú,ù,ç);
$letras=array(a,a,a,e,e,e,i,o,o,o,o,u,u,c);
while ($registro=pg_fetch_row($query_profs))
      {
      $registro_0=implode(explode(" ",$registro[0]));
      $registro_1=implode(explode(" ",$registro[1]));
      $registro_nome=$registro_0.$registro_1;
      $registro_nome=str_replace($acentos,$letras,$registro_nome);
      $devolve[$i]=array(strtoupper($registro_nome),$registro[2],$registro[3]);
      $i=$i+1;
      }

//                                if (preg_match("/".strtoupper($registro_nome)."/", $resto_da_linha))  
                                
return $devolve;
}
//----------------


function _value_in_array($array, $find)
{
 $exists = FALSE;
 if(!is_array($array)){
   return;
}
foreach ($array as $key => $value) {
  if($find == $value){
       $exists = TRUE;
  }
}
  return $exists;
}

function manipula_arquivo_atualiza_lista($semestre,$ano,$arquivo) // devolve um array somente com as linhas a serm utilizadas 
{

//$ano=2012;//$_POST['ano'];
//$semestre=1;//$_POST['semestre'];

$diretorio="listas_SAA/";
//$arquivo="a_de_ofertas_".$semestre."_".$ano.".txt";

// Using the optional flags parameter since PHP 5
//$trimmed = file('listas_SAA/lista_de_oferta_1_2012.txt');
$trimmed=file($diretorio.$arquivo);

$query_disciplinas=pg_query("select codigo,creditos from disciplinas_MAT order by codigo");
$num_disc=pg_num_rows($query_disciplinas);
$disc_0=pg_fetch_all($query_disciplinas);
for ($k=0;$k<$num_disc;$k++)
	{
	$disciplinas[$k]=$disc_0[$k]['codigo'];
	$creditos[$k]=$disc_0[$k]['creditos'];
	}

$turmas_a_incluir=array();
$num_a_incluir=0;

$turmas_disc_outros_campi=array(113018 => array(J), 113034 => array(Q,R,AA,BB,CC,DD), 113042 => array(N,AA,BB,CC), 113051 => array(AA,BB), 113093 => array(AA,BB,CC));

$turmas=array(A,B,C,D,E,F,G,H,I,J,K,L,M,N,O,P,Q,R,S,T,U,V,W,X,Y,Z);
//$dias=array(Segunda,Terça,Quarta,Quinta,Sexta,Sábado);
$dias=array(Segunda,Terça,Quarta,Quinta,Sexta,Sábado);

$acentos=array(á,à,ã,é,è,ê,í,ó,ò,õ,ô,ú,ù,ç);
$letras=array(a,a,a,e,e,e,i,o,o,o,o,u,u,c);

$lista_de_salas=array(ICC,PAT,BAES,PJC,FA,"BSA S");
$lista_de_blocos=array(AT,BT,A1,"ANF.",B1,CSS,B2,A2,ASS);

$dias_si=array(Segunda=>2,Terça=>3,Quarta=>4,Quinta=>5,Sexta=>6,Sábado=>7);

$titulos=array(Turma,Vagas,Turno,dia,inicio,fim,Local,Professores,"Reserva/Vagas",Obs);

$num_turmas_SI=0;

$proibidos=array(Universidade,Secretaria,Disciplinas,lstofedlp,DEPARTAMENTO,Período,Orgão,Nome,$ano."/".$semestre,Disciplina,Professor);

$devolve=array();
$key_devolve=0;

for ($i=0;$i<count($trimmed);$i++)
	{// para cada linha do arquivo
	if (trim($trimmed[$i])!="")  // se a linha não for vazia.
		{ // para a linha não vazia
		$linha=mb_convert_encoding(trim($trimmed[$i]),"UTF-8");  // elimina espaços de cada lado da linha
		
		$linha_array=explode(" ",$linha); // recupera cada parte da linha num array
		if (!_value_in_array($proibidos,$linha_array[0]) and (count($linha_array)>1) and (strpos($linha_array[0],'/')===false))
			{
			$linha_escrita="Linha ".$i.":";
			for ($k=0;$k<count($linha_array);$k++)
				{
				$linha_escrita.="(".$k.")".trim($linha_array[$k])."; ";
				}
//			echo $linha_escrita."<br>";
			$devolve[$key_devolve]=$linha_array;
print_r($devolve[$key_devolve]);
			$key_devolve=$key_devolve+1;
			}
		} // fim de para a linha não vazia
	} // fim de para cada linha do arquivo
return $devolve;
} // fim da funca


function melhora_lista_carga($array_profs,$array_arquivo,$semestre,$ano)
{
// $array_arquivo: e um array de array cada um sendo uma linha do arquivo
// $array_profs e um array de arrays com nome,coduser,matricula

for ($i=0;$i<count($array_arquivo);$i++)
	{
	$teste=explode("-",$array_arquivo[$i][0]);
	if (count($teste)!=3) 
		{
		$prof=implode("", $array_arquivo[$i]);
		$dados_prof=procura_prof($array_profs,$prof);
		if($dados_prof!="nulo") 
			{
			$dados_prof_2=explode("__--__",$dados_prof);
			$nome_prof=ucwords(strtolower(implode(" ", $array_arquivo[$i])));
			$coduser=$dados_prof_2[0];
			$matricula=$dados_prof_2[1];
//			$res_teste="<br><br> a linha é o professor: ".$nome_prof." coduser=".$coduser." e matricula=".$matricula."<br>";
			echo $res_teste;
			}
		}
	else 
		{// a linha e uma disciplina:
		$departamento=$teste[0];
		$codigo=$teste[1];
		$nivel=$teste[2];
		if ($departamento=="MAT")
			{
			$nome_disc=$array_arquivo[$i][3];
			$k=4;
			while($array_arquivo[$i][$k]!="")
				{
				$nome_disc.=" ".$array_arquivo[$i][$k];
				$k=$k+1;
				}	
			while($array_arquivo[$i][$k]=="") 
                                { 
                                $k=$k+1;
                                } 
                        $turma_disc=$array_arquivo[$i][$k];
			$k=$k+1;
			while($array_arquivo[$i][$k]=="")                
                                { 
                                $k=$k+1;
                                }
			$creditos_disc=$array_arquivo[$i][$k];
			$k=$k+1;
			while($array_arquivo[$i][$k]=="") 
                                { 
                                $k=$k+1;
                                }  		
			$creditos_prof=$array_arquivo[$i][$k]*100;
			$k=$k+1;
			while($array_arquivo[$i][$k]=="")
                                {
                                $k=$k+1;
                                }
                        $matriculas_na_turma=$array_arquivo[$i][$k];
			$linha=$coduser.",".$departamento.",".$codigo.",".$nivel.",".$nome_prof.",".$coduser.",".$turma_disc.",".$creditos_disc.",".$creditos_prof.",".$matriculas_na_turma;
			echo $linha."<br>";
			$query_insere="insert into oferta_carga_professor values('".$coduser."','".$codigo."','".$nivel."','".$turma_disc."','".$creditos_disc."','".$creditos_prof."','".$matriculas_na_turma."','".$semestre."','".$ano."')";
			$res_insere=pg_query($query_insere);
//			echo "<BR>".$query_limpa."<br>";
//			echo "<BR>".$query_insere."<br>";
			}

		}
	}

}

function procura_prof($array_prof,$prof)
{
$devolve="nulo";
foreach ($array_prof as $key => $value) 
	{
	if(_value_in_array($value, $prof))
		{
		$devolve=$value[1]."__--__".$value[2];
		break;
		}
	}
return $devolve;
}

?>
