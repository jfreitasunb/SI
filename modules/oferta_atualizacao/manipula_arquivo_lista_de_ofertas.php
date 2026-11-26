<?php
// Equivalencia SIGAA -> SIGRA dos codigos de disciplina.
require_once __DIR__ . '/codigos_disciplinas_sigaa.php';


function monta_array_profs()
{
 $query_profs=db_query("select name,firstname from users where tipo_users='professor' order by name", array());
$i=0;
$devolve=array();
$acentos=array('á','à','ã','é','è','ê','í','ó','ò','õ','ô','ö','ú','ù','ç');
$letras=array('a','a','a','e','e','e','i','o','o','o','o','o','u','u','c');
while ($registro=db_fetch_row($query_profs))
      {
      $registro_0=implode(explode(" ",$registro[0]));
      $registro_1=implode(explode(" ",$registro[1]));
      $registro_nome=$registro_0.$registro_1;
      $registro_nome=str_replace($acentos,$letras,$registro_nome);
      $devolve[$i]=strtoupper($registro_nome);
      $i=$i+1;
      }

//                                if (preg_match("/".strtoupper($registro_nome)."/", $resto_da_linha))

return $devolve;
}

function procura_prof($array_prof,$prof)
{
$acentos=array('Á','À','Ã','É','È','Ê','Í','Ó','Ò','Õ','Ô','Ö','Ú','Ù','Ç');
$letras=array('A','A','A','E','E','E','I','O','O','O','O','O','U','U','C');
echo "<br> em procura_prof:".h($prof)."<br>"; // $prof vem do arquivo enviado (lista SAA)
$prof_sem_acentos=str_replace($acentos,$letras,$prof);
echo "<br>sem acentos em procura_prof: ".h($prof_sem_acentos)."<br>";
$devolve="nulo";
if (isset($array_prof[$prof_sem_acentos])) $devolve=$array_prof[$prof_sem_acentos][0]."__--__".$array_prof[$prof_sem_acentos][1];
/*foreach ($array_prof as $key => $value)
	{
	if(_value_in_array($value, $prof_sem_acentos))
		{
		$devolve=$value[1]."__--__".$value[2];
		break;
		}
	}
*/
return $devolve;
}


//------------------------------


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

function decide_o_que_e_linha($disciplinas,$linha)
{
$turmas_disc_outros_campi=array(113018 => array('J'), 113034 => array('Q','R','AA','BB','CC','DD'), 113042 => array('N','AA','BB','CC'), 113051 => array('AA','BB'), 113093 => array('AA','BB','CC'));
//Inclusao de novas turmas no C1. Mudanca feita por Jose Antonio.
$turmas=array('A','B','C','D','E','F','G','H','I','J','K','L','M','N','O','P','Q','R','S','T','U','V','W','X','Y','Z','AF','CH','HO','DM','GK','AB','SA','SB','SC','SD','SE','SF','SG','SH','SI','SJ','SK','SL','SM','SN');
//$turmas=array(A,B,C,D,E,F,G,H,I,J,K,L,M,N,O,P,Q,R,S,T,U,V,W,X,Y,Z);
$dias=array('Segunda','Terça','Quarta','Quinta','Sexta','Sábado');
$acentos=array('á','à','ã','é','è','ê','í','ó','ò','õ','ô','ö','ú','ù','ç');
$letras=array('a','a','a','e','e','e','i','o','o','o','o','o','u','u','c');
$lista_de_salas=array('ICC','PAT','BAES','PJC','FA',"BSA S");
$lista_de_blocos=array('AT','BT','A1',"ANF.",'B1','CSS','B2','A2',"ASS");
$dias_si=array('Segunda'=>2,'Terça'=>3,'Quarta'=>4,'Quinta'=>5,'Sexta'=>6,'Sábado'=>7);
$titulos=array('Turma','Vagas','Turno','dia','inicio','fim','Local','Professores',"Reserva/Vagas",'Obs');

// deve retornar dizendo se é um:
// nova disciplina
// nova turma da discilpina
// novo dia da turma

if (_value_in_array($disciplinas, $linha[0])) $devolve="nova disciplina";
	else
		{
		if ( _value_in_array($turmas, $linha[0]) and !_value_in_array($turmas_disc_outros_campi,$linha[0])) $devolve="nova turma";
		else
			{
			if ( _value_in_array($dias, $linha[0])) $devolve="novo dia"; else $devolve="problema";
			}
		}
return $devolve;
}

function testa_sala($linha,$k)
{
$devolve=array();
$lista_de_salas=array('ICC','PAT','BAES','PJC','FA','BSA');
$lista_de_blocos=array('AT','BT','A1',"ANF.",'B1','CSS','B2','A2',"ASS");
$lista_de_locais=array('S');

$p=$k;
//$sala=$linha[$k];
if ($linha[$p]." ".$linha[$p+1]=="A Designar")
	{
	$devolve[0]="A Designar";
        $devolve[1]=$p+1;
	return $devolve;
	}
else
{
while ($p<count($linha))
	{
	if ($linha[$p]!="")
		{
		if (_value_in_array($lista_de_salas,$linha[$p]))
			{
                        $sala=$linha[$p];
                        $p=$p+1;
                        }
		else
			{
			if (_value_in_array($lista_de_blocos,$linha[$p]))
				{
				$sala.=" ".$linha[$p];
				$p=$p+1;
				}
			 else
				{
				if (_value_in_array($lista_de_locais,$linha[$p]))
					{
					$sala.=" ".$linha[$p];
					$p=$p+1;
					}
				else
					{// ou e numero e termina ou separa para terminar:
					if (ctype_digit($linha[$p]))
						{
						$sala.=" ".$linha[$p];
						$devolve[0]=$sala;
						$devolve[1]=$p;
						return $devolve;
						}
					else
						{
						// ou o numero esta grudado no bloco ou o numero contem uma /
						$explodido=explode("/",$linha[$p]);
						if (preg_match("/ANF/", $linha[$p]) or (ctype_digit($explodido[0]) and ctype_digit($explodido[1])))
							{
							$sala.=" ".$linha[$p];
							$devolve[0]=$sala;
	                                                $devolve[1]=$p;
        	                                        return $devolve;
		//					break;105317
							}
						else
							{
							$sala.=" ".$linha[$p];
							$p=$p+1;
							//$sala.="erro";
							//$devolve[0]=$sala;
	                                                //$devolve[1]=$p;
        	                                        //return $devolve;
//							break;
							}
						}
					}
				}
			}
		}
	else $p=$p+1;
	}
}
} // fim da funcao

function testa_arquivo($semestre,$ano,$arquivo,$tipo)
{
//; $tipo deve ser um de: lstofelst,lstofedlp

$essenciais=array("IE-MAT","MAT",$tipo,$ano."/".$semestre,"lstofelst","lstofedlp");
$tipo_0=0;
$periodo=0;
$ie=0;

$diretorio="listas_SAA/";
$trimmed=file($diretorio.$arquivo);

for ($i=0;$i<count($trimmed);$i++)
	{
        if (trim($trimmed[$i])!="")  // se a linha não for vazia.
                { // para a linha não vazia
                $linha=mb_convert_encoding(trim($trimmed[$i]),"UTF-8");  // elimina espaços de cada lado da linha

	        $linha_array=explode(" ",$linha); // recupera cada parte da linha num array
		if (_value_in_array($linha_array,"IE-MAT") or _value_in_array($linha_array,"MAT") or _value_in_array($linha_array,"Departamento de Matemática")) $ie=1;
		if (_value_in_array($linha_array,$tipo)) $tipo_0=1;
		if (_value_in_array($linha_array,$ano."/".$semestre)) $periodo=1;
		}
		if (($ie!=0) and ($tipo_0!=0) and ($periodo!=0)) $devolve=TRUE; else $devolvo=FALSE; // dividir pela quanidade de paginas;

}
return $devolve;
}

function caminho_lista_saa_seguro($arquivo)
{
    $base = realpath(__DIR__ . '/listas_SAA');
    $nome = basename((string)$arquivo);
    if ($base === false || $nome === '' || $nome !== (string)$arquivo) {
        return false;
    }
    $alvo = realpath($base . DIRECTORY_SEPARATOR . $nome);
    if ($alvo === false || strpos($alvo, $base . DIRECTORY_SEPARATOR) !== 0) {
        return false;
    }
    return $alvo;
}

function testa_arquivo_sigaa($semestre,$ano,$arquivo)
{
    //; $tipo deve ser um de: lstofelst,lstofedlp

    $periodo=0;

    $caminho = caminho_lista_saa_seguro($arquivo);
    if ($caminho === false) {
        return false;
    }
    $trimmed = file_get_contents($caminho);

    if (stripos($trimmed,"MAT0025") !== false and stripos($trimmed, "MAT0022") !== false and stripos($trimmed, "MAT0010") !== false) {
        $devolve=true;
    }else{
        $devolve=false;
    }

    return $devolve;
}

// Lista do SIGAA no formato novo (2026.2 em diante):
//   2026.2,Turma 02,JOAO ... (60h) e MAURO ... (30h),REGULAR,Presencial,ABERTA,246T23 (10/08/2026 - 14/12/2026),ICC ASS 415/10,26/36 estudantes
// vira linhas no formato antigo, que processa_linhas_sigaa le, uma por professor:
//   02,2026.2,JOAO ... (60h),246T23,,36,0,ICC ASS 415/10
//   02,2026.2,MAURO ... (30h),246T23,,36,0,ICC ASS 415/10
// Cabecalhos de disciplina e linhas no formato antigo voltam sem mudanca.
function normaliza_linha_sigaa($row)
{
    $campos = explode(",", rtrim($row, "\r\n"));
    $n = count($campos);
    if ($n < 9 || !preg_match('/^\d{4}\.\d$/', trim($campos[0])) || !preg_match('/^Turma\b/i', trim($campos[1]))) {
        return array($row);
    }

    $periodo = trim($campos[0]);
    $turma = trim(preg_replace('/^Turma\s*/i', '', trim($campos[1])));
    // Tira o periodo de aulas "(10/08/2026 - 14/12/2026)" do horario.
    $horario = trim(preg_replace('/\(\s*\d{2}\/\d{2}\/\d{4}\s*-\s*\d{2}\/\d{2}\/\d{4}\s*\)/', '', $campos[6]));
    // A sala pode ter virgulas; as vagas sao sempre o ultimo campo ("26/36 estudantes" -> 36).
    $sala = trim(implode(",", array_slice($campos, 7, $n - 8)));
    $vagas = trim($campos[$n - 1]);
    if (preg_match('/(\d+)\s*\/\s*(\d+)/', $vagas, $m)) {
        $vagas = $m[2];
    }

    // "NOME (60h) e OUTRO NOME (30h)": um professor para cada "(NNh)".
    preg_match_all('/\s*(?:e\s+)?(.+?\(\d+h\))/', $campos[2], $profs);
    $profs = count($profs[1]) ? $profs[1] : array(trim($campos[2]));

    $linhas = array();
    foreach ($profs as $prof) {
        $linhas[] = implode(",", array($turma, $periodo, trim($prof), $horario, "", $vagas, "0", $sala)) . "\n";
    }
    return $linhas;
}

// Cabecalho de disciplina: "MAT0025 - CALCULO 1 ...". Antes o teste era contar
// hifens, o que confundia as linhas novas que tem "(10/08/2026 - 14/12/2026)".
function linha_e_disciplina_sigaa($row)
{
    return preg_match('/^\s*[A-Z]{3}\d{4}\s*-/', $row) === 1;
}

function manipula_arquivo_sigaa_atualiza_lista($semestre,$ano,$arquivo)
{

    set_time_limit(100);

    $caminho = caminho_lista_saa_seguro($arquivo);
    if ($caminho === false) {
        return array();
    }

    $trimmed=file($caminho);

    $devolve = array();

    $rows = file($caminho);

    $arquivo_tratado = str_replace(".txt", "", $arquivo)."_tratado.txt";

    $blacklist = "FGA|FUP|a designar|A DESIGNAR-FGA|A DESIGNAR-FUP";

    foreach($rows as $key => $row) {
        if(preg_match("/($blacklist)/", $row)) {
            unset($rows[$key]);
        }
    }

    $dados_tratados = [];

    foreach ($rows as $key) {
        foreach (normaliza_linha_sigaa($key) as $linha) {
            $dados_tratados[] = $linha;
        }
    }

    $tamanho = count($dados_tratados);

    for ($i=0; $i < $tamanho - 1; $i++) {

        if (linha_e_disciplina_sigaa($dados_tratados[$i])) {

            $temp = array();

            for ($j=$i+1; $j < $tamanho; $j++) {
                if (!linha_e_disciplina_sigaa($dados_tratados[$j])) {
                    $temp[] = $dados_tratados[$j];
                }else{
                    break;
                }

                $devolve[rtrim(trim($dados_tratados[$i]), ",")] = $temp;
            }
            unset($temp);
        }
    }

    return $devolve;
}

function manipula_arquivo_atualiza_lista($semestre,$ano,$arquivo)
{
set_time_limit(100);

//$ano=2012;//$_POST['ano'];
//$semestre=1;//$_POST['semestre'];

$diretorio="listas_SAA/";
//$arquivo="a_de_ofertas_".$semestre."_".$ano.".txt";

// Using the optional flags parameter since PHP 5
//$trimmed = file('listas_SAA/lista_de_oferta_1_2012.txt');
$trimmed=file($diretorio.$arquivo);

// teste se o arquivo e o arquivo que deveria ser: periodo correto e lista correta

$disciplinas=array();
$creditos=array();

$turmas_a_incluir=array();
$num_a_incluir=0;

$turmas_disc_outros_campi=array(113018 => array('J'), 113034 => array('Q','R','AA','BB','CC','DD'), 113042 => array('N','AA','BB','CC'), 113051 => array('AA','BB'), 113093 => array('AA','BB','CC'));

//Inclusao de novas turmas no C1. Mudanca feita por Jose Antonio.
$turmas=array('A','B','C','D','E','F','G','H','I','J','K','L','M','N','O','P','Q','R','S','T','U','V','W','X','Y','Z','AF','CH','HO','DM','GK','AB','SA','SB','SC','SD','SE','SF','SG','SH','SI','SJ','SK','SL','SM','SN');
//$turmas=array(A,B,C,D,E,F,G,H,I,J,K,L,M,N,O,P,Q,R,S,T,U,V,W,X,Y,Z);
//$dias=array(Segunda,Terça,Quarta,Quinta,Sexta,Sábado);
$dias=array('Segunda','Terça','Quarta','Quinta','Sexta','Sábado');

$acentos=array('á','à','ã','é','è','ê','í','ó','ò','õ','ô','ö','ú','ù','ç');
$letras=array('a','a','a','e','e','e','i','o','o','o','o','o','u','u','c');

$lista_de_salas=array('ICC','PAT','BAES','PJC','FA',"BSA S");
$lista_de_blocos=array('AT','BT','A1',"ANF.",'B1','CSS','B2','A2');

$dias_si=array('Segunda'=>2,'Terça'=>3,'Quarta'=>4,'Quinta'=>5,'Sexta'=>6,'Sábado'=>7);

$titulos=array('Turma','Vagas','Turno','dia','inicio','fim','Local','Professores',"Reserva/Vagas",'Obs');

$proibidos=array('Universidade','Secretaria','Lista',"IE-MAT","----------------------------------------------",'Turma',"000","004","006","010","008","002","005",'Observações',"(*)",'lstofelst','Disciplinas','lstofedlp','DEPARTAMENTO','Período','Orgão','Nome',$ano."/".$semestre,'Disciplina','Professor');

$num_turmas_SI=0;

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
//                      echo $linha_escrita."<br>";
                        $devolve[$key_devolve]=$linha_array;
//print_r($devolve[$key_devolve]);
                        $key_devolve=$key_devolve+1;
                        }
                } // fim de para a linha não vazia
        } // fim de para cada linha do arquivo

return $devolve;
} // fim da funca

function cria_array_disciplinas()
{
$disciplinas0=array();
$query_codigos=db_query("select codigo from disciplinas_mat order by codigo", array());
$disciplinas=db_fetch_all($query_codigos);
for ($i=0;$i<count($disciplinas);$i++)
{
$disciplinas0[$i]=$disciplinas[$i]['codigo'];
}
return $disciplinas0;
}

function nova_disciplina($linha)
{
// codigo,hifem,nome
//echo "print de nova disciplina";
return $linha[0];
}

function nova_turma($codigo,$linha,$profs_si)  // devolve um aray com: codigo,turma,vagas,turno,dia,horario,sala,professor,reserva,observacoes
{
$devolve=array();
//devolver: turma,vagas,turno,dia,horario,sala,professor,reserva,observacoes
$devolve['turma']=$linha[0];
$k=1;
while (($linha[$k]=="") and ($k<count($linha)))
	{
	$k=$k+1;
	}
if ($k<count($linha))
        {
	$devolve['vagas']=$linha[$k];
	$k=$k+1;
	}
while (($linha[$k]=="") and ($k<count($linha)))
        {
        $k=$k+1;
        }
if ($k<count($linha))
        {
	$devolve['turno']=$linha[$k];
	$k=$k+1;
	}
while (($linha[$k]=="") and ($k<count($linha)))
        {
        $k=$k+1;
        }
if ($k<count($linha))
        {
	$dia=$linha[$k];
	$k=$k+1;
	}
while (($linha[$k]=="") and ($k<count($linha)))
        {
        $k=$k+1;
        }
if ($k<count($linha))
        {
	$hora_inicio=$linha[$k];
	$k=$k+1;
	}
while (($linha[$k]=="") and ($k<count($linha)))
        {
        $k=$k+1;
        }
if ($k<count($linha))
        {
	$hora_fim=$linha[$k];
	$k=$k+1;
	}
while (($linha[$k]=="") and ($k<count($linha)))
        {
        $k=$k+1;
        }
if ($k<count($linha))
        { // Testar o tipio de sala ṕara saber quanto espacos usar.
        $sala0=testa_sala($linha,$k);
        $sala=$sala0[0];
        $k=$sala0[1]+1;
        }
while (($linha[$k]=="") and ($k<count($linha)))
        {
        $k=$k+1;
        }
if ($k<count($linha))
        {
        // checa se ha um nome de prof na linha:
        $existe=_existe_prof_na_linha($k,$linha,$profs_si);
        if ($existe[0]) $k=$existe[3];
/*                {
                $nome_prof=$linha[$k];
                $k=$k+1;
                while($nome_prof!=$existe[1])
                        {
                        if ($linha[$k]!="") $nome_prof.=$linha[$k];
                        $k=$k+1;
                        }
//echo "<BR> Professor (nova Turma): ".$nome_prof."-".$existe[2]."<BR>";
                }
*/
        }
while (($linha[$k]=="") and ($k<count($linha)))
        {
        $k=$k+1;
        }
if ($k<count($linha))
        {
	$reserva=$linha[$k];
	$k=$k+1;
	}
while (($linha[$k]!="") and ($k<count($linha)))
        {
        $reserva.=" ".$linha[$k];
        $k=$k+1;
        }
$devolve['sala']=$sala;
$devolve['horarios']=trata_horario($dia,$hora_inicio,$hora_fim);
$devolve['reserva']=$reserva;
$devolve['codigo']=$codigo;
$devolve['nome_prof']=$nome_prof;
$devolve['coduser']=$existe[2];

//echo "<BR>nova turma:<BR>".$codigo."','".$turma."','".$vagas."','".$turno."','".$devolve['horarios']."','".$sala."','".$nome_prof."','".$reserva."','".$semestre."','".$ano."<BR><BR>";

//echo "print de nova turma";
//print_r($devolve);
return $devolve;
}

function trata_horario($dia,$hora_inicio,$hora_fim)
{
$dias_si=array('Segunda'=>2,'Terça'=>3,'Quarta'=>4,'Quinta'=>5,'Sexta'=>6,'Sábado'=>7);
foreach ($dias_si as $key => $value)
	{
	if ($dia==$key) {$devolve_dia=$value; break;}
	}

$inicio_explode=explode(":",$hora_inicio);
if ($inicio_explode[0]=="20") $devolve=$devolve_dia."21"; else $devolve=$devolve_dia.$inicio_explode[0];

$fim_explode=explode(":",$hora_fim);
if (($inicio_explode[0]=="08") and ($fim_explode[0]=="11")) $devolve.="-".$devolve_dia."10";
if (($inicio_explode[0]=="14") and ($fim_explode[0]=="17")) $devolve.="-".$devolve_dia."16";
if (($inicio_explode[0]=="19") and ($fim_explode[0]=="22")) $devolve.="-".$devolve_dia."21";

return $devolve;
}


function _existe_prof_na_linha($k,$linha,$profs_si)  // teste para ver se ha um prof na linha
{
set_time_limit(60);
$acentos=array('Á','À','Ã','É','È','Ê','Í','Ó','Ò','Õ','Ô','Ö','Ú','Ù','Ç');
$letras=array('A','A','A','E','E','E','I','O','O','O','O','O','U','U','C');
$key=0;
$devolve=array();
$resto_linha="";
$devolve[0]=FALSE;
$devolve[1]="";
$devolve[2]="";
$devolve[3]=$k;
for ($i=$k;$i<count($linha);$i++)
	{
//	if (($linha[$i]!=""))
//		{
//		$resto_linha.=$linha[$i];
//		if (!ctype_lower($linha[$i])) $resto_linha.=$linha[$i]; else break;
//		}
	if ($linha[$i]!="")
		{
		$elemento=str_replace($acentos,$letras,$linha[$i]);
		if (ctype_upper($elemento)) $resto_linha.=$elemento; else {$devolve[3]=$i;break;}
// DEVOLVER TAMBÉM $i PARA JÁ PULAR PARA ESTE LUGAR NA LINHA E NÃO TER DE REFAZER TUDO!
//		echo $resto_linha."<br>";
		}
	}
//echo "<BR>resto linha COM acento em _existe_prof_na_linha:".$resto_linha."<br>";
//$resto_linha=str_replace($acentos,$letras,$resto_linha);
//echo "<br>resto linha seM acento em _existe_prof_na_linha:".$resto_linha."<br>";

if(isset($profs_si[$resto_linha]))
	{
        $devolve[0]=TRUE;
        $devolve[1]=$resto_linha;
        $devolve[2]=$profs_si[$resto_linha][0];
        }
/*for ($key=0;$key<count($profs_si);$key++)
	{
	if (preg_match("/".$profs_si[$key][0]."/", $resto_linha))
		{
		$devolve[0]=TRUE;
		$devolve[1]=$profs_si[$key][0];
		$devolve[2]=$profs_si[$key][1];
		break;
		}
	}
*/
echo "<BR> Professor: ".h($devolve[0])."-".h($devolve[1])."-".h($devolve[2])."<br>";
return $devolve;
}

function novo_dia($codigo,$turma,$linha,$profs_si)
{
set_time_limit(60);
// dia/horario/sala/professor/reserva
$devolve=array();
$devolve['codigo']=$codigo;
$devolve['turma']=$turma;
$devolve['vagas']="";
$devolve['turno']="";
//echo "<BR>novo dia: ";
//print_r($linha);
//echo "<BR><BR>";

//devolver: turma,vagas,turno,dia,horario,sala,professor,reserva,observacoes
$dia=$linha[0];
$k=1;
while (($linha[$k]=="") and ($k<count($linha)))
	{
	$k=$k+1;
	}
if ($k<count($linha))
        {
	$hora_inicio=$linha[$k];
	$k=$k+1;
	}
while (($linha[$k]=="") and ($k<count($linha)))
        {
        $k=$k+1;
        }
if ($k<count($linha))
        {
	$hora_fim=$linha[$k];
	$k=$k+1;
	}
while (($linha[$k]=="") and ($k<count($linha)))
        {
        $k=$k+1;
        }
if ($k<count($linha))
        { // Testar o tipio de sala ṕara saber quanto espacos usar.
//	echo "<BR><BR>em novo dia antes de testar sala: ".$k;
	$sala0=testa_sala($linha,$k);
	$sala=$sala0[0];
	$k=$sala0[1]+1;
//	echo "<BR><BR>em novo dia depois de testar sala: ".$k;
	}
while (($linha[$k]=="") and ($k<count($linha)))
        {
        $k=$k+1;
        }
if ($k<count($linha))
        {
	// checa se ha um nome de prof na linha:
	$existe=_existe_prof_na_linha($k,$linha,$profs_si);
	if ($existe[0]) $k=$existe[3];
/*		{
		$nome_prof=$linha[$k];
		$k=$k+1;
		while($nome_prof!=$existe[1])
			{
			if ($linha[$k]!="") $nome_prof.=$linha[$k];
			$k=$k+1;
			}
//echo "<BR> Professor (novo Dia): ".$nome_prof."-".$existe[2]."<BR>";
		}
*/
	}
while (($linha[$k]=="") and ($k<count($linha)))
        {
        $k=$k+1;
        }
if ($k<count($linha))
	{
	$reserva=$linha[$k];
	$k=$k+1;
	}
while (($linha[$k]!="") and ($k<count($linha)))
        {
        $reserva.=" ".$linha[$k];
        $k=$k+1;
        }
$devolve['sala']=$sala;
$devolve['horarios']=trata_horario($dia,$hora_inicio,$hora_fim);
$devolve['reserva']=$reserva;
$devolve['codigo']=$codigo;
$devolve['nome_prof']=$nome_prof;
if ($existe[0]) $devolve['coduser']=$existe[2]; else $devolve['coduser']="";

// print_r($devolve);
return $devolve;
}

// Horario "2N12 35N34" -> aulas individuais ("2N1", "2N2", "3N3", ...), para comparar horarios.
function aulas_do_horario_sigaa($horario)
{
    $aulas = array();
    foreach (preg_split('/\s+/', trim($horario)) as $parte) {
        if (preg_match('/^(\d+)([MTN])(\d+)$/i', $parte, $m)) {
            foreach (str_split($m[1]) as $dia) {
                foreach (str_split($m[3]) as $aula) {
                    $aulas[$dia . strtoupper($m[2]) . $aula] = true;
                }
            }
        }
    }
    return $aulas;
}

// Nome do arquivo ("WILLIAN CINTRA DA SILVA") na chave de monta_array_de_profs(): sem espacos e acentos, maiusculo.
function chave_nome_prof_sigaa($nome)
{
    $acentos = array('á','à','ã','â','é','è','ê','í','ó','ò','õ','ô','ö','ú','ù','ü','ç','Á','À','Ã','Â','É','È','Ê','Í','Ó','Ò','Õ','Ô','Ö','Ú','Ù','Ü','Ç');
    $letras  = array('a','a','a','a','e','e','e','i','o','o','o','o','o','u','u','u','c','A','A','A','A','E','E','E','I','O','O','O','O','O','U','U','U','C');
    return strtoupper(str_replace($acentos, $letras, preg_replace('/\s+/', '', $nome)));
}

/**
 * Calcula os creditos do rodizio noturno a partir da lista do SIGAA
 * ($array_linhas, saida de manipula_arquivo_sigaa_atualiza_lista):
 *  - turma noturna: horario com "N";
 *  - disciplina: codigo do SIGAA ("MAT0025"), desde que conste em codigos_disciplinas_sigaa.php;
 *  - creditos: horas do professor na turma / 15 ("(60h)" -> 4);
 *  - turma como texto, sem zero a esquerda ("02" -> "2");
 *  - MAT0025 (Calculo 1): as turmas em que o mesmo professor de 30h aparece em
 *    horarios parecidos (com ao menos uma aula em comum, ex. 236M12 e 235M12) viram
 *    um registro so, com as turmas separadas por hifen ("7-8-9") e 2 creditos.
 * Devolve array('registros' => [{coduser, disciplina, turma, creditos}], 'ignorados' => [motivos]).
 */
function calcula_rodizio_noturno_sigaa($array_linhas)
{
    $profs_si = monta_array_de_profs();
    $codigos = codigos_disciplinas_sigaa();
    $ignorados = array();

    // Uma entrada por professor em cada turma noturna.
    $entradas = array();
    foreach ($array_linhas as $nome_disciplina => $turmas) {
        $codigo_sigaa = strtoupper(trim(explode("-", $nome_disciplina)[0]));
        foreach ($turmas as $linha) {
            $campos = explode(",", trim($linha));
            if (count($campos) < 4 || stripos($campos[3], "N") === false) {
                continue;
            }
            $turma = preg_replace('/^0+(?=\d)/', '', trim($campos[0]));
            $prof = trim($campos[2]);
            if (!preg_match('/^(.*?)\s*\((\d+)h\)\s*$/i', $prof, $m)) {
                $ignorados[] = "$codigo_sigaa turma $turma: sem carga horaria em \"$prof\"";
                continue;
            }
            if (!isset($codigos[$codigo_sigaa])) {
                $ignorados[] = "$codigo_sigaa turma $turma: disciplina fora de codigos_disciplinas_sigaa.php";
                continue;
            }
            $chave = chave_nome_prof_sigaa($m[1]);
            if (!isset($profs_si[$chave])) {
                $ignorados[] = "$codigo_sigaa turma $turma: professor \"{$m[1]}\" nao encontrado na tabela users";
                continue;
            }
            $entradas[] = array(
                'disciplina' => $codigo_sigaa,
                'turmas' => array($turma),
                'horas' => (int)$m[2],
                'coduser' => $profs_si[$chave][0],
                'aulas' => aulas_do_horario_sigaa($campos[3]),
            );
        }
    }

    // Regra do MAT0025: junta as entradas do mesmo professor de 30h com horarios parecidos.
    $agrupadas = array();
    foreach ($entradas as $entrada) {
        if ($entrada['disciplina'] == 'MAT0025' && $entrada['horas'] == 30) {
            foreach ($agrupadas as $k => $outra) {
                if ($outra['disciplina'] == 'MAT0025' && $outra['horas'] == 30
                    && $outra['coduser'] == $entrada['coduser']
                    && count(array_intersect_key($outra['aulas'], $entrada['aulas']))) {
                    $agrupadas[$k]['turmas'][] = $entrada['turmas'][0];
                    $agrupadas[$k]['aulas'] += $entrada['aulas'];
                    continue 2;
                }
            }
        }
        $agrupadas[] = $entrada;
    }

    $registros = array();
    foreach ($agrupadas as $entrada) {
        $turmas = array_unique($entrada['turmas']);
        usort($turmas, 'strnatcmp');
        $registros[] = array(
            'coduser' => $entrada['coduser'],
            'disciplina' => $entrada['disciplina'],
            'turma' => implode("-", $turmas),
            'creditos' => intdiv($entrada['horas'], 15),
        );
    }

    return array('registros' => $registros, 'ignorados' => $ignorados);
}

/**
 * Grava em oferta_horarios_rodizio_noturno_creditos o que calcula_rodizio_noturno_sigaa()
 * devolve, sem duplicar: nao insere se ja houver registro com o mesmo professor,
 * semestre, ano, disciplina e turma.
 * Devolve array('inseridos' => n, 'existentes' => n, 'ignorados' => array(motivos)).
 */
function registra_rodizio_noturno_sigaa($array_linhas, $semestre, $ano)
{
    $calculo = calcula_rodizio_noturno_sigaa($array_linhas);
    $resultado = array('inseridos' => 0, 'existentes' => 0, 'ignorados' => $calculo['ignorados']);

    foreach ($calculo['registros'] as $registro) {
        $existe = db_query("select 1 from oferta_horarios_rodizio_noturno_creditos where coduser=? and semestre=? and ano=? and disciplina=? and turma=?",
            array($registro['coduser'], $semestre, $ano, $registro['disciplina'], $registro['turma']));
        if (db_fetch_row($existe)) {
            $resultado['existentes']++;
            continue;
        }

        db_query("insert into oferta_horarios_rodizio_noturno_creditos (coduser, semestre, ano, credito_noturno, disciplina, turma) values (?,?,?,?,?,?)",
            array($registro['coduser'], $semestre, $ano, $registro['creditos'], $registro['disciplina'], $registro['turma']))
            or die("problema de acesso ao banco: nao foi possivel inserir em oferta_horarios_rodizio_noturno_creditos");
        $resultado['inseridos']++;
    }

    return $resultado;
}

function processa_linhas_sigaa($array_linhas,$semestre,$ano)
{
    $codigos_disciplinas_sigaa = codigos_disciplinas_sigaa();

    set_time_limit(100);

    $nao_reserva=array("*","**","***","");

    $profs_si=monta_array_de_profs();

    $array_c1 = [];

    $array_c1sp = [];

    $array_mat1 = [];

    $l = 0;

    $k = 0;

    $m = 0;

    foreach ($array_linhas as $nome_disciplina => $array_turmas) {
        foreach ($array_turmas as $turma) {

            $codigo_sigaa = trim(explode("-", $nome_disciplina)[0]);

            $codigo = $codigos_disciplinas_sigaa[$codigo_sigaa];

            if ($codigo_sigaa == "MAT0025") {

                $dados_c1 = explode(",", $turma);

                $array_c1[$l]['turma'] = $dados_c1[0];

                $array_c1[$l]['turno'] = stripos($dados_c1[3], "N") !== false ? "Noturno" : "Diurno";

                $array_c1[$l]['vagas'] = $dados_c1[5];

                $array_c1[$l]['horarios'] = $dados_c1[3];

                $array_c1[$l]['sala'] = $dados_c1[7];

                $temporario = explode(" ", $dados_c1[2]);

                $nome="";

                for ($i=0; $i < count($temporario)-1; $i++) {
                    $nome .= $temporario[$i];
                }

                $coduser = $profs_si[$nome][0];

                $array_c1[$l]['coduser'] = $coduser;

                $l++;

            }else if ($codigo_sigaa == "MAT0137") {

                $dados_c1sp = explode(",", $turma);

                $array_c1sp[$m]['turma'] = "SP".$dados_c1sp[0];

                $array_c1sp[$m]['turno'] = stripos($dados_c1sp[3], "N") !== false ? "Noturno" : "Diurno";

                $array_c1sp[$m]['vagas'] = $dados_c1sp[5];

                $array_c1sp[$m]['horarios'] = $dados_c1sp[3];

                $array_c1sp[$m]['sala'] = $dados_c1sp[7];

                $temporario = explode(" ", $dados_c1sp[2]);

                $nome="";

                for ($i=0; $i < count($temporario)-1; $i++) {
                    $nome .= $temporario[$i];
                }

                $coduser = $profs_si[$nome][0];

                $array_c1sp[$m]['coduser'] = $coduser;

                $m++;

            }else if ($codigo_sigaa == "MAT0022") {

                $dados_mat1 = explode(",", $turma);

                $array_mat1[$k]['turma'] = $dados_mat1[0];

                $array_mat1[$k]['turno'] = stripos($dados_mat1[3], "N") !== false ? "Noturno" : "Diurno";

                $array_mat1[$k]['vagas'] = $dados_mat1[5];

                $array_mat1[$k]['horarios'] = $dados_mat1[3];

                $array_mat1[$k]['sala'] = $dados_mat1[7];

                $temporario = explode(" ", $dados_mat1[2]);

                $nome="";
                for ($i=0; $i < count($temporario)-1; $i++) {
                    $nome .= $temporario[$i];
                }

                $coduser = $profs_si[$nome][0];

                $array_mat1[$k]['coduser'] = $coduser;

                $k++;
            }else{
                $linha_dados = explode(",", $turma);

                $turma = $linha_dados[0];

                $turno = stripos($linha_dados[3], "N") !== false ? "Noturno" : "Diurno";

                $vagas = $linha_dados[5];

                $horarios = $linha_dados[3];

                $sala = $linha_dados[7];

                $temporario = explode(" ", $linha_dados[2]);

                $nome="";

                for ($i=0; $i < count($temporario)-1; $i++) {
                    $nome .= $temporario[$i];
                }

                $coduser = $profs_si[$nome][0];

                $reserva = "sem registro";

                $query_insere="insert into oferta_lista_sigra values (?,?,?,?,?,?,?,?,?,?)"; $query_insere__p = array($codigo, $turma, $vagas, $turno, $horarios, $sala, $reserva, $semestre, $ano, $coduser);
                echo "<br>Insere nova Turma: ".$query_insere."<br>";

                $res_insere=db_query($query_insere, $query_insere__p) or die ("problema de acesso ao banco 03: n&atilde;o foi possivel inserir turma nova na tabela oferta_lista_sigra os dados referentes ao semestre='".$semestre."' e ano='".$ano."'");
            }
        }
    }

    $codigo_c1 = $codigos_disciplinas_sigaa['MAT0025'];

    for ($i=0; $i < count($array_c1); $i++) {

        $coduser = $array_c1[$i]['coduser'];

        for ($j=$i+1; $j < count($array_c1); $j++) {

            if ($array_c1[$i]['turma'] == $array_c1[$j]['turma']) {
                $coduser .= "-".$array_c1[$j]['coduser'];
            }else{
                break;
            }
        }

        $query_verifica_registro ="select * from oferta_lista_sigra where codigo=? and turma=? and semestre=? and ano=?"; $query_verifica_registro__p = array($codigo_c1, $array_c1[$i]['turma'], $semestre, $ano);

        $verifica_registro = db_query($query_verifica_registro, $query_verifica_registro__p);

        if (count(db_fetch_row($verifica_registro)) == 1) {
            $query_insere="insert into oferta_lista_sigra values (?,?,?,?,?,?,'sem reserva',?,?,?)"; $query_insere__p = array($codigo_c1, $array_c1[$i]['turma'], $array_c1[$i]['vagas'], $array_c1[$i]['turno'], $array_c1[$i]['horarios'], $array_c1[$i]['sala'], $semestre, $ano, $coduser);

            $res_insere=db_query($query_insere, $query_insere__p) or die ("problema de acesso ao banco 04: ".$query_insere."");
        }
    }

    for ($i=0; $i < count($array_c1sp); $i++) {

        $coduser = $array_c1sp[$i]['coduser'];

        for ($j=$i+1; $j < count($array_c1sp); $j++) {

            if ($array_c1sp[$i]['turma'] == $array_c1sp[$j]['turma']) {
                $coduser .= "-".$array_c1sp[$j]['coduser'];
            }else{
                break;
            }
        }

        $query_verifica_registro ="select * from oferta_lista_sigra where codigo=? and turma=? and semestre=? and ano=?"; $query_verifica_registro__p = array($codigo_c1, $array_c1sp[$i]['turma'], $semestre, $ano);

        $verifica_registro = db_query($query_verifica_registro, $query_verifica_registro__p);

        if (count(db_fetch_row($verifica_registro)) == 1) {
            $query_insere="insert into oferta_lista_sigra values (?,?,?,?,?,?,'sem reserva',?,?,?)"; $query_insere__p = array($codigo_c1, $array_c1sp[$i]['turma'], $array_c1sp[$i]['vagas'], $array_c1sp[$i]['turno'], $array_c1sp[$i]['horarios'], $array_c1sp[$i]['sala'], $semestre, $ano, $coduser);

            echo "<br>Insere nova Turma: ".$query_insere."<br>";

            $res_insere=db_query($query_insere, $query_insere__p) or die ("problema de acesso ao banco 05: ".$query_insere."");
        }
    }

    $codigo_mat1 = $codigos_disciplinas_sigaa['MAT0022'];

    for ($i=0; $i < count($array_mat1); $i++) {
        $coduser = $array_mat1[$i]['coduser'];

        for ($j=$i+1; $j < count($array_mat1); $j++) {
            if ($array_mat1[$i]['turma'] == $array_mat1[$j]['turma']) {
                $coduser .= "-".$array_mat1[$j]['coduser'];
            }
        }

        $query_verifica_registro ="select * from oferta_lista_sigra where codigo=? and turma=? and semestre=? and ano=?"; $query_verifica_registro__p = array($codigo_mat1, $array_mat1[$i]['turma'], $semestre, $ano);

        $verifica_registro = db_query($query_verifica_registro, $query_verifica_registro__p);

        if (count(db_fetch_row($verifica_registro)) == 1) {
            $query_insere="insert into oferta_lista_sigra values (?,?,?,?,?,?,'sem reserva',?,?,?)"; $query_insere__p = array($codigo_mat1, $array_mat1[$i]['turma'], $array_mat1[$i]['vagas'], $array_mat1[$i]['turno'], $array_mat1[$i]['horarios'], $array_mat1[$i]['sala'], $semestre, $ano, $coduser);

            echo "<br>Insere nova Turma: ".$query_insere."<br>";

            $res_insere=db_query($query_insere, $query_insere__p) or die ("problema de acesso ao banco 06: n�o foi possivel inserir turma nova na tabela oferta_lista_sigra os dados referentes ao semestre='".$semestre."' e ano='".$ano."'");

        }
    }
}


function processa_linhas($array_linhas,$semestre,$ano)
{
set_time_limit(100);
$nao_reserva=array("*","**","***","");
$profs_si=monta_array_de_profs();
$disciplinas=cria_array_disciplinas();
$codigo=0;
foreach ($array_linhas as $key => $linha)
{
$tipo=decide_o_que_e_linha($disciplinas,$linha);
//echo "<BR>".$tipo."<BR>";
if ($tipo=="nova disciplina")
	{
	$codigo_antigo=$codigo;
	$codigo=nova_disciplina($linha);
	if (($codigo_antigo!=0) and ($codigo_antigo!=$codigo))
		{
		// gravar no banco as informações da turma anterior;
		$query_insere="insert into oferta_lista_sigra values (?,?,?,?,?,?,?,?,?,?)"; $query_insere__p = array($codigo_antigo, $turma, $vagas, $turno, $horarios, $sala, $reserva, $semestre, $ano, $coduser);
		echo "<BR>Insere nova disciplina: ".$query_insere."<BR>";
		$res_insere=db_query($query_insere, $query_insere__p)  or die ("problema de acesso ao banco 00");
		}
	$nova_disciplina="sim";
	}
if ($tipo=="nova turma")
	{
	$turma_antiga=$turma;
	$dados_turma1=nova_turma($codigo,$linha,$profs_si);
	$turma=$dados_turma1['turma'];
	if (($turma_antiga!="") and ($turma!=$turma_antiga) and ($nova_disciplina=="nao"))
		{
		$query_insere="insert into oferta_lista_sigra values (?,?,?,?,?,?,?,?,?,?)"; $query_insere__p = array($codigo, $turma_antiga, $vagas, $turno, $horarios, $sala, $reserva, $semestre, $ano, $coduser);
        	echo "<BR>Insere nova Turma: ".$query_insere."<BR>";
		$res_insere=db_query($query_insere, $query_insere__p) or die ("problema de acesso ao banco 01");
		}

	$vagas=$dados_turma1['vagas'];
	$turno=$dados_turma1['turno'];
	$sala=$dados_turma1['sala'];
	$horarios=$dados_turma1['horarios'];
	if (!_value_in_array($nao_reserva,$dados_turma1['reserva'])) $reserva=$dados_turma1['reserva']; else $reserva="";
	$nome_prof=$dados_turma1['nome_prof'];
	$coduser=$dados_turma1['coduser'];
	$nova_disciplina="nao";
	}
if ($tipo=="novo dia")
	{
	$dados_turma2=novo_dia($codigo,$turma,$linha,$profs_si);
	$sala.="-".$dados_turma2['sala'];
	if (!_value_in_array($nao_reserva,$dados_turma2['reserva'])) $reserva.="-".$dados_turma2['reserva'];
	$horarios.="-".$dados_turma2['horarios'];
	$nome_prof=$dados_turma2['nome_prof'];
	if ($dados_turma2['coduser']!="") $coduser.="-".$dados_turma2['coduser'];
	}
if ($key==count($array_linhas)-1)
	{
	$query_insere="insert into oferta_lista_sigra values (?,?,?,?,?,?,?,?,?,?)"; $query_insere__p = array($codigo, $turma, $vagas, $turno, $horarios, $sala, $reserva, $semestre, $ano, $coduser);
//        echo "<BR>Insere nova disciplina: ".$query_insere."<BR>";
        $res_insere=db_query($query_insere, $query_insere__p)  or die ("problema de acesso ao banco 02");
	}
}
}

//////////////////////////////// ARQUIVO


function monta_array_de_profs()
{
    $query_profs=db_query("select name,firstname,coduser,matricul from users where tipo_users='professor' order by name", array());
    $i=0;
    $devolve=array();
    $acentos=array('á','à','ã','é','è','ê','í','ó','ò','õ','ô','ö','ú','ù','ç');
    $letras=array('a','a','a','e','e','e','i','o','o','o','o','o','u','u','c');
    while ($registro=db_fetch_row($query_profs))
          {

          $registro_0=implode(explode(" ",$registro[0]));
          $registro_1=implode(explode(" ",$registro[1]));
          $registro_nome=$registro_0.$registro_1;
          $registro_nome=str_replace($acentos,$letras,$registro_nome);
          $registro_nome=strtoupper($registro_nome);
          $devolve[$registro_nome]=array($registro[2],$registro[3]);
    //      $i=$i+1;
          }

    //                                if (preg_match("/".strtoupper($registro_nome)."/", $resto_da_linha))

    return $devolve;
}


function melhora_lista_carga($array_profs,$array_arquivo,$semestre,$ano)
{
// $array_arquivo: e um array de array cada um sendo uma linha do arquivo
// $array_profs e um array de arrays com nome,coduser,matricula

//echo "<BR>".count($array_arquivo);
//print_r($array_arquivo);
for ($i=0;$i<count($array_arquivo);$i++)
	{
//set_time_limit(40);
//echo "<BR>".$i;
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
//			echo $res_teste;
			}
		}
	else
		{// a linha e uma disciplina:
		$departamento=$teste[0];
		$codigo=$teste[1];
		$nivel=$teste[2];
		if ($departamento=="MAT")
			{
// 'e necessario partir do final do arquivo porque ha irregularidade no espaco entre nome da disciplina e turma:
			$k=count($array_arquivo[$i])-1;
                        $matriculas_na_turma=$array_arquivo[$i][$k];
			$k=$k-1;
			while($array_arquivo[$i][$k]=="")
                                {
                                $k=$k-1;
                                }
			$creditos_prof=100*$array_arquivo[$i][$k];
			$k=$k-1;
                        while($array_arquivo[$i][$k]=="")
                                {
                                $k=$k-1;
                                }
			$creditos_disc=$array_arquivo[$i][$k];
                        $k=$k-1;
                        while($array_arquivo[$i][$k]=="")
                                {
                                $k=$k-1;
                                }
			$turma_disc=$array_arquivo[$i][$k];
			$query_insere="insert into oferta_carga_professor values(?,?,?,?,?,?,?,?,?)"; $query_insere__p = array($coduser, $codigo, $nivel, $turma_disc, $creditos_disc, $creditos_prof, $matriculas_na_turma, $semestre, $ano);
			echo "<BR>".$query_insere."<br>";
			$res_insere=db_query($query_insere, $query_insere__p) or die ("problema de acesso ao banco em melhora_lista_carga");
//			echo "<BR>".$query_insere."<br>";
			}

		}
	}

}


/////////////////////////////////////// LISTA DE OFERTAS
function monta_ofertas_emural($semestre,$ano)  // alterado em 18/12/2014
{
	//$query_carga=pg_query("select * from oferta_carga_professor where semestre='".$semestre."' and ano='".$ano."' and nivel='GR' order by codigo, turma_disc") or die ("problemas de acesso ao banco");
	//
	//redefinir a array_carga
// select DAS turmas/disciplinas que trabalham no esquema magistral ou COM MAIS DE UM PROFESSOR POR TURMA
$query_magistral_ou_turmas_unificadas=db_query("select s.codigo,s.turma,s.turno,s.horarios,s.coduser,grupo from oferta_lista_sigra s inner join oferta_grupos_magistral_teoria mt on mt.codigo=s.codigo and mt.turmas=s.turma and mt.semestre=s.semestre and mt.ano=s.ano where s.semestre=? and s.ano=? union (select s.codigo,s.turma,s.turno,s.horarios,s.coduser,'0' as grupo from oferta_lista_sigra s where  semestre=? and ano=? and coduser like '%-%'  and codigo not in (select codigo from oferta_grupos_magistral_teoria where  semestre=? and ano=? )) order by grupo,codigo,turma", array($semestre, $ano, $semestre, $ano, $semestre, $ano)) or die ("monta_ofertas_emural: problema 01");
$array_multiplos_profs=db_fetch_all($query_magistral_ou_turmas_unificadas);

// cria um array de profs de exerc�cios para as turmas do magistrsal e as turmas com mais de um prof.
$array_prof_exercicio=procura_prof_exercicio($array_multiplos_profs,$semestre,$ano);

////cria a tabela do SI com as disciplinas/turmas em esquema unificado.
//alimenta_tabela_oferta_disc_turmas_unificadas_emural($array_multiplos_profs,$semestre,$ano); N�O EST� IMPLEMENTADO: A FUN��O DEVE SER CORRIGIDA. 20/12/2014


// inicia a motagem da LO para o e-mural
$query_lista=db_query("select codigo,turma,turno,horarios,coduser from oferta_lista_sigra where semestre=? and ano=? order by codigo,turma", array($semestre, $ano)) or die ("problemas de acesso ao banco");

while($registro=db_fetch_row($query_lista))
	{
	$disciplina=$registro[0];
	$turma=$registro[1];
	$turno=$registro[2];
	$horarios=$registro[3];
	$professores=explode("-",$registro[4]);
 echo "<BR>";
 // print_r($professores);
 echo "<BR>";
	if (count($professores)!=1)
		{
		$coduser=$array_prof_exercicio[$disciplina][$turma];
		}
	else
		{
		if ($professores[0]=="") $coduser=0; else $coduser=$professores[0];
		}
	$insere="insert into oferta_lista_de_ofertas values(?,?,?,?,?,?,?)"; $insere__p = array($disciplina, $turma, $turno, $coduser, $semestre, $ano, $horarios);
	db_query($insere, $insere__p);

	echo "<BR> lista e-mural: ".$insere."<BR>";
	}
}

function procura_prof_exercicio($array_multiplos_profs,$semestre,$ano)
{

$array_profs=array();

for ($i=0;$i<count($array_multiplos_profs);$i++)
{
	if($array_multiplos_profs[$i]['grupo']!=0)
	{
		$profs=explode("-",$array_multiplos_profs[$i]['coduser']);
		$query_turma_gemea=db_query("select turmas from oferta_grupos_magistral_teoria where grupo=? and codigo=? and semestre=? and ano=? and horario in (select horario from oferta_grupos_magistral_teoria where codigo=? and turmas=?  and semestre=? and ano=?) and turmas<>?", array($array_multiplos_profs[$i]['grupo'], $array_multiplos_profs[$i]['codigo'], $semestre, $ano, $array_multiplos_profs[$i]['codigo'], $array_multiplos_profs[$i]['turma'], $semestre, $ano, $array_multiplos_profs[$i]['turma']));
		$turma=db_result($query_turma_gemea,0,0);
		if(db_num_rows($query_turma_gemea)!=0)
		{
// echo "turma: ".$turma;echo $i;echo "--";
$k=$i+1;
		for ($j=$k;$j<count($array_multiplos_profs);$j++)
		{
			if(($array_multiplos_profs[$i]['grupo']==$array_multiplos_profs[$j]['grupo']) and ($array_multiplos_profs[$j]['turma']==$turma))
			{
				$profs2=explode("-",$array_multiplos_profs[$j]['coduser']);
// print_r($profs2);
				foreach($profs as $key => $value)
					{
					if(!in_array($value,$profs2)) {$array_profs[$array_multiplos_profs[$i]['codigo']][$array_multiplos_profs[$i]['turma']]=$value;$def_i=1; break;} else $def_i=0;
					}
				foreach($profs2 as $key => $value)
                                        {
                                        if(!in_array($value,$profs)) {$array_profs[$array_multiplos_profs[$j]['codigo']][$array_multiplos_profs[$j]['turma']]=$value;$def_j=1; break;} else $def_j=0;
                                        }
				if($def_i==0) $array_profs[$array_multiplos_profs[$i]['codigo']][$array_multiplos_profs[$i]['turma']]=$profs[0];
				if($def_j==0) $array_profs[$array_multiplos_profs[$j]['codigo']][$array_multiplos_profs[$j]['turma']]=$profs2[0];
				break;
			}
		}
		}
		else $array_profs[$array_multiplos_profs[$i]['codigo']][$array_multiplos_profs[$i]['turma']]=$profs[0];
	}
	else
	{
		$profs=explode("-",$array_multiplos_profs[$i]['coduser']);
		$array_profs[$array_multiplos_profs[$i]['codigo']][$array_multiplos_profs[$i]['turma']]=$profs[0];

	}
}
// print_r($array_profs);
return $array_profs;

} // fim de function procura_prof_exercicio


function procura_carga_na_turma($disciplina,$turma,$professores,$array_carga) // alterado em 18/12/2014
{
$calcula=array();
foreach($professores as $key => $value)
	{
	for ($i=0;$i<count($array_carga);$i++)
		{
		if (($array_carga[$i]['codigo']==$disciplina) and ($array_carga[$i]['turma_disc']==$turma) and  ($array_carga[$i]['coduser']==$value))
			{
			$calcula[$key]['creditos_prof']=$array_carga[$i]['creditos_prof'];
			$calcula[$key]['matriculas_na_turma']=$array_carga[$i]['matriculas_na_turma'];
			$calcula[$key]['coduser']=$value;
			}
		}
	}
//echo "<BR>";
//print_r($calcula);
//echo "<BR>";
// Obter uma lista de colunas de $calcula:
$creditos=$calcula[0]['creditos_prof'];
$coduser=$calcula[0]['coduser'];
foreach ($calcula as $key => $row)
	{
	if ($row['creditos_prof']> $creditos) $coduser=$row['coduser'];
	}

return $coduser;
} //end function procura_carga_na_turma


/////  ATUALIZA OFERTA_SEMESTRES ////

function atualiza_oferta_semestres($semestre,$ano)
{
$query_oferta_sigra=db_query("select * from oferta_lista_sigra where semestre=? and ano=? and reserva<>'' and not( (codigo,turma) in (select codigo,turma from oferta_semestres where semestre<>'120'))", array($semestre, $ano)) or die ("problema de acesso ao banco");

while ($registro=db_fetch_row($query_oferta_sigra))
	{
	$insere="insert into oferta_semestres values(?,?,?,?,?,?,?,'fixa','12')"; $insere__p = array($registro[0], $registro[1], $registro[2], $registro[3], $registro[4], $registro[5], $registro[6]);
	$res_insere=db_query($insere, $insere__p);
//echo "<BR>".$insere."<BR>";
	}
} // fim function atualiza_lista_semestre
?>
