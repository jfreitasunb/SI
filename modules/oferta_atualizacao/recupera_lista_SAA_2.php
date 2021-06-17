<?PHP

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

function manipula_arquivo_atualiza_lista($semestre,$ano,$arquivo)
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

//Inclusao de novas turmas no C1. Mudanca feita por Jose Antonio.
$turmas=array(A,B,C,D,E,F,G,H,I,J,K,L,M,N,O,P,Q,R,S,T,U,V,W,X,Y,Z,AF,CH,HO);

//$turmas=array(A,B,C,D,E,F,G,H,I,J,K,L,M,N,O,P,Q,R,S,T,U,V,W,X,Y,Z);
//$dias=array(Segunda,Terça,Quarta,Quinta,Sexta,Sábado);
$dias=array(Segunda,Terça,Quarta,Quinta,Sexta,Sábado);

$acentos=array(á,à,ã,é,è,ê,í,ó,ò,õ,ô,ú,ù,ç);
$letras=array(a,a,a,e,e,e,i,o,o,o,o,u,u,c);

$lista_de_salas=array(ICC,PAT,BAES,PJC,FA);
$lista_de_blocos=array(AT,BT,A1,"ANF.",B1,CSS);

$dias_si=array(Segunda=>2,Terça=>3,Quarta=>4,Quinta=>5,Sexta=>6,Sábado=>7);

$titulos=array(Turma,Vagas,Turno,dia,inicio,fim,Local,Professores,"Reserva/Vagas",Obs);

$num_turmas_SI=0;

for ($i=0;$i<count($trimmed);$i++)
	{// para cada linha do arquivo
//echo "<BR>";
//print_r($trimmed[$i]);
//echo "<BR>";
	if (trim($trimmed[$i])!="")  // se a linha não for vazia.
		{ // para a linha não vazia
		$linha=mb_convert_encoding(trim($trimmed[$i]),"UTF-8");  // elimina espaços de cada cado da linha
		
		$linha_array=explode(" ",$linha); // recupera cada parte da linha num array
		//echo $linha_array[0]."<br>";
		//echo $linha_array[1]."<br>";
echo "<BR>";
print_r($linha_array);
echo "<BR>";
		if ($linha_array[0]=="Período") 
			{
			for ($p=1;$p<count($linha_array);$p++)
				{
				if ($linha_array[$p]!="") $periodo=$linha_array[$p];
				}
			if ($periodo!=$ano."/".$semestre) break;
			}

//		echo "Linha ".$i.": ";print_r($linha_array);echo "<br><br>";
		//if (in_array(substr($linha, 0, 6),$disciplinas)) echo substr($linha, 0, 6)."<br>";  // abcd
		// comeca uma nova disciplina
		if (in_array($linha_array[0],$disciplinas)) 
			{ // comeca uma nova disciplina
//			echo "disciplina: ".$linha_array[0]."<br>"; 
			$codigo=$linha_array[0];
			while ($name_codigo = current($disciplinas)) 
				{
				if ($name_codigo == $codigo) 
					{
//				        echo key($disciplinas).'<br />';
//					echo $creditos[key($disciplinas)]."<br>";
					$num_creditos=$creditos[key($disciplinas)];
					break;
    					}
				next($disciplinas);
				}
			} // fim de comeca uma nova disciplina

		if (in_array($linha_array[0],$turmas)) 
			{ // comeca uma nova turma da mesma disciplina
			$num_turmas_SI=$num_turmas_SI+1;
			$num=0;
			$tempo_aula=0;
			$turma=$linha_array[0];
			$resto_da_linha="";
			for ($j=1;$j<count($linha_array);$j++)
				{
				if ($linha_array[$j]!="")
					{
					$num=$num+1;
					if ($num==1) $vagas=$linha_array[$j];
					if ($num==2) $turno=$linha_array[$j];
					if ($num==3) $horarios=$dias_si[$linha_array[$j]];
					if ($num==4) {$horarios_0=explode(":",$linha_array[$j]);if ($horarios_0[0]==20) {$horarios.=21;$inicio=21;} else {$horarios.=$horarios_0[0]; if ($horarios_0[0]=="08") $inicio=8; else $inicio=$horarios_0[0];}}
					if ($num==5) {$horarios_1=explode(":",$linha_array[$j]); $final=$horarios_1[0]; $tempo_aula=$final-$inicio+1;}
					// Local-6,Professores-7,"Reserva/Vagas"-8,Obs-9); 
					if ($num>5) 
						{
						if (in_array($linha_array[$j],$lista_de_salas)) 
							{
							$salas=$linha_array[$j];
//							echo $salas; 
							$novo_j=$j+1; 
							while ($linha_array[$novo_j]!="") 
								{
								$salas.=" ".$linha_array[$novo_j]; 
								$novo_j=$novo_j+1;
								}
							}
                                                else if ($linha_array[$j]=="A" and $linha_array[$j+1]=="Designar") $salas="A Designar";
							else $resto_da_linha.=$linha_array[$j];
						}
//$resto_da_linha.=$linha_array[$j];
					}
				}
			//Processar resto da linha para extrair nome do professor e sala:
			$query_profs=pg_query ("select name,firstname,coduser,matricul from users where tipo_users='professor' order by name");		
			while ($registro=pg_fetch_row($query_profs))
				{
				$registro_0=implode(explode(" ",$registro[0]));
				$registro_1=implode(explode(" ",$registro[1]));
				$registro_nome=$registro_0.$registro_1;
				$registro_nome=str_replace($acentos,$letras,$registro_nome);
//				echo $resto_da_linha."<br>";
//				echo $registro_nome."<br>";
				if (preg_match("/".strtoupper($registro_nome)."/", $resto_da_linha))  
					{
					$nome_prof=$registro[0]." ".$registro[1];
					$coduser=$registro[2];
					$matricula=$registro[3];
					$resto_da_linha_array=explode(strtoupper($registro_nome),$resto_da_linha);
//					$salas=trim($resto_da_linha_array[0]);
//					Separa as salas por sala,bloco e resto:
//					$salas_0=explode($lista_de_blocos,$salas); $num_salas_0=strlen($salas_0[0]); 					
					$reservas_1=trim($resto_da_linha_array[1]);
					break;
					}
				}

			$num_horarios=explode("-",$horarios);
			if (($num_creditos==2*count($num_horarios)) or ($tempo_aula==$num_creditos))
				{		
				$disciplinas_SI[$num_turmas_SI]="(".$codigo.",".$turma.",".$vagas.",".$turno.",".$horarios.",".$coduser.",".$matricula.",".$nome_prof.")";

				if (!_value_in_array($turmas_disc_outros_campi[$codigo],$turma)) 
					{
					$num_a_incluir=$num_a_incluir+1;
					$turmas_a_incluir[$num_a_incluir]="('".$codigo."','".$turma."','".$turno."','".$coduser."','".$semestre."','".$ano."','".$horarios."')";
					}
/*				$query_checa_turma=pg_query("select * from oferta_lista_de_ofertas where disciplina='".$codigo."' and turma='".$turma."' and semestre='".$semestre."' and ano='".$ano."'");
                                $checa_turma=pg_fetch_row($query_checa_turma);


                                if (empty($checa_turma)) 
                                        {
					if (!_value_in_array($turmas_disc_outros_campi[$codigo],$turma)) 
							{$num_a_incluir=$num_a_incluir+1;
							$turmas_a_incluir[$num_a_incluir]=$codigo.",".$turma.",".$turno.",".$coduser.",".$semestre.",".$ano.",".$horarios;
//							$turmas_a_incluir[$num_a_incluir]="('".$codigo."','".$turma."','".$turno."','".$coduser."','".$semestre."','".$ano."','".$horarios."')";
							}
//			 
                                        }
                                else
                                        {
					$query_update="update oferta_lista_de_ofertas set turno='".$turno."', horarios='".$horarios."', professor='".$coduser."'  where disciplina='".$codigo."' and turma='".$turma."' and semestre='".$semestre."' and ano='".$ano."'";
					$res_update=pg_query($query_update) or die("problemas de acesso ao banco de dados.");
					}
*/
				}
			} // fim de comeca uma nova turma da mesma disciplina
//echo "elemento zero da linha:".$linha_array[0];
		if (in_array($linha_array[0],$dias))
			{// comeca um novo dia da mesma turma da mesma disciplina.
			$num=3;
			$resto_da_linha="";
			$salas.="-";
//			$horarios.=$dias_si[str_replace($acentos,$letras,$linha_array[0])];
			$horarios.="-".$dias_si[$linha_array[0]];
//                        echo "O horario é:".$horarios."<br>";
                        for ($j=1;$j<count($linha_array);$j++)
                                {
                                if ($linha_array[$j]!="")
                                        {
                                        $num=$num+1;
  //                                      if ($num<3) echo $titulos[$num].":".$linha_array[$j]."<br>";
//					if ($num==3) $horarios.=$dias_si[$linha_array[$j]];
                                        if ($num==4) {$horarios_0=explode(":",$linha_array[$j]);if($horarios_0[0]==20) {$horarios.=21; $inicio=21;} else {$horarios.=$horarios_0[0]; if ($horarios_0[0]=="08") $inicio=8; else $inicio=$horarios_0[0];}}
					if ($num==5) {$horarios_1=explode(":",$linha_array[$j]);$final=$horarios_1[0]; $tempo_aula=$tempo_aula+$final-$inicio+1;}
					if ($num>5) {if (in_array($linha_array[$j],$lista_de_salas)) {$salas.=$linha_array[$j]; $novo_j=$j+1; while ($linha_array[$novo_j]!="") {$salas.=" ".$linha_array[$novo_j]; $novo_j=$novo_j+1;}} 
						     else if ($linha_array[$j]=="A" and $linha_array[$j+1]=="Designar") $salas.="A Designar";}
                                        }

                                }

			$num_horarios=explode("-",$horarios);
			if (($num_creditos==2*count($num_horarios)) or ($tempo_aula==$num_creditos))
				{		
				$disciplinas_SI[$num_turmas_SI]="(".$codigo.",".$turma.",".$vagas.",".$turno.",".$horarios.",".$salas.",".$coduser.",".$matricula.",".$nome_prof.")";
			
				if (!_value_in_array($turmas_disc_outros_campi[$codigo],$turma)) 
					{
					$num_a_incluir=$num_a_incluir+1;
					$turmas_a_incluir[$num_a_incluir]="('".$codigo."','".$turma."','".$turno."','".$coduser."','".$semestre."','".$ano."','".$horarios."')";
					}
/*				$query_checa_turma=pg_query("select * from oferta_lista_de_ofertas where disciplina='".$codigo."' and turma='".$turma."' and semestre='".$semestre."' and ano='".$ano."'");
				$checa_turma=pg_fetch_row($query_checa_turma);
				if (empty($checa_turma)) 
					{
					if (!_value_in_array($turmas_disc_outros_campi[$codigo],$turma)) 
                                                        {$num_a_incluir=$num_a_incluir+1;
                                                        $turmas_a_incluir[$num_a_incluir]=$codigo.",".$turma.",".$turno.",".$coduser.",".$semestre.",".$ano.",".$horarios;
                                                        }
//			 
					}
				else 
					{
					$query_update="update oferta_lista_de_ofertas set turno='".$turno."', horarios='".$horarios."', professor='".$coduser."'  where disciplina='".$codigo."' and turma='".$turma."' and semestre='".$semestre."' and ano='".$ano."'";
//      	                        echo $query_update."<br>";
                	                $res_update=pg_query($query_update) or die("problemas de acesso ao banco de dados.");
					}
*/
				}
			} // fim de comeca um novo dia da mesma turma da mesma disciplina.
		

		} // fim de para a linha não vazia
	} // fim de para cada linha do arquivo
return $turmas_a_incluir;
} // fim da funca

?>
