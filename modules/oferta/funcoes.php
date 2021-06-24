<?php

function organiza_pedidos_por_creditos($semestre,$ano)
{
$limpa_oferta_organiza_pedidos=pg_query("delete from oferta_organiza_pedidos") or die ("problema com o acesso ao Banco de Daodos");

$query_creditos_pos=pg_query("select coduser,SUM(creditos) as creditos from oferta_escolha_creditos_pos group by coduser where semestre='".$semestre."' and  ano='".$ano."' order by coduser");
$creditos_pos=pg_fetch_all($query_creditos_pos);

$query_creditos_est_pesq_pos=pg_query("select coduser,SUM(creditos) as creditos from oferta_escolha_creditos_est_pesq_pos group by coduser where semestre='".$semestre."' and ano='".$ano."' order by coduser");
$creditos_est_pesq_pos=pg_fetch_all($query_creditos_est_pesq_pos);

$query_creditos_grad=pg_query("select distinct on (coduser) coduser,creditos, disciplinas_iguais_6 from oferta_escolha_creditos where semestre='".$semestre."' and ano='".$ano."' order by coduser");
$creditos_grad=pg_fetch_all($query_creditos_grad);
$num_pedidos=pg_num_rows($query_creditos_grad);


// montar tabela de pedidos organizados por prioridade de créditos:
for ($i=0;$i<$num_pedidos; $i++)
	{
	if (in_array($creditos_grad[$i]['coduser'],$creditos_pos)) $creditospos=$creditos_pos[$creditos_grad[$i]['coduser']]['creditos'];
	if (in_array($creditos_grad[$i]['coduser'],$creditos_est_pesq_pos)) $creditospos=$creditospos+$creditos_est_pesq_pos[$creditos_grad[$i]['coduser']]['creditos'];
	$creditosgrad=$creditos_grad[$i]['creditos'];
	$creditos=$creditosgrad+$creditospos;

	$disciplinas_iguais_6=$creditos_grad[$i]['disciplinas_iguais_6'];

	if ($creditospos!=0)
		{
		if ($creditos>=9) $prioridade=1; // corresponde a a
		}
	if ($creditospos==0)
		{
		if (($creditosgrad>12) and ($disciplinas_iguais_6=="nao")) $prioridade=2; 				// corresponde a b
		if (($creditosgrad>12) and ($disciplinas_iguais_6=="sim")) $prioridade=3;				// corresponde a c
		if (($creditosgrad==12) and ($disciplinas_iguais_6=="nao")) $prioridade=4;				// corresponde a d
		if (($creditosgrad==12) and ($disciplinas_iguais_6=="sim")) $prioridade=5;				// corresponde a e
		if (($creditosgrad<12) and ($creditosgrad>=10) and ($disciplinas_iguais_6=="nao")) $prioridade=6;	// corresponde a f
		if (($creditosgrad<10) and ($creditosgrad>=8) and ($disciplinas_iguais_6=="nao")) $prioridade=7;	// corresponde a g
		if (($creditosgrad<8) and ($creditosgrad>=6) and ($disciplinas_iguais_6=="nao")) $prioridade=8;	// corresponde a h
		if (($creditosgrad<6) and ($creditosgrad>=4) and ($disciplinas_iguais_6=="nao")) $prioridade=9;	// corresponde a i
		if ((($creditospos!=0) and ($creditos<9)) or (($creditospos==0) and ($creditosgrad<12) and ($disciplinas_iguais_6=="sim"))) $prioridade=10;															     // corresponde a j i.e. o resto
		}
	$insere_prioridade="insert into oferta_organiza_pedidos values('".$creditos_grad[$i]['coduser']."','".$prioridade."')";
	$res=pg_query($insere_prioridade) or die ("problema com o acesso ao Banco de Daodos");
	}

}



//Montagem da tabela de frequencias dos pedidos:


function monta_tabela_oferta_frequencia_pedidos($semestre,$ano)
{
$limpa_oferta_frequencia_pedidos=pg_query("delete from oferta_frequencia_pedidos where semestre='".$semestre."' and ano='".$ano."'") or die ("problema com o acesso ao Banco de Dados");
$tabela="oferta_lista_de_ofertas_nova";
$query_disciplinas=pg_query("select distinct on (codigo) codigo from ".$tabela." order by codigo") or die ("Problema no acesso ao Banco de Dados");

// pega codigos dio magistral. adicionado em 07/05/14
$pega_magistral=pg_query("select distinct on (codigo_1) codigo_1 from oferta_grupos_magistral_teoria");
$array_magistral=pg_fetch_all($pega_magistral);

while($registro=pg_fetch_row($query_disciplinas))
	{
	$disciplina=$registro[0];
	for ($i=1;$i<7;$i++)
		{
// seleciona turnos magistral: adicionado em 07/05/14
		if(in_array($disciplina,$array_magistral))
			{
			$query_turnos_grad_magistral=pg_query("select distinct on (turno) turno from oferta_lista_de_ofertas_nova where codigo='".$disciplina."' and elimina='nao' and semestre='".$semestre."' and ano='".$ano."'");
			while($turno_mag=pg_fetch_row($query_turnos_grad_magistral))
				{
				$query_disciplinas_grad=pg_query("select coduser from oferta_escolha_disciplina where semestre='".$semestre."' and ano='".$ano."' and prioridade='".$i."' and disciplina='".$disciplina."' and turno='".$turno_mag[0]."' order by coduser");
		                $num_mag=pg_num_rows($query_disciplinas_grad);
                		$insere_frequencia_mag="insert into oferta_frequencia_pedidos values('".$disciplina."','".$turno_mag[0]."','".$i."','".$num_mag."','".$semestre."','".$ano."')";
				}
			}
// fim magistral

		$query_disciplinas_grad=pg_query("select coduser from oferta_escolha_disciplina where semestre='".$semestre."' and ano='".$ano."' and prioridade='".$i."' and disciplina='".$disciplina."' and turno='Diurno' order by coduser");
		$num_diurno=pg_num_rows($query_disciplinas_grad);
		$insere_frequencia_diurno="insert into oferta_frequencia_pedidos values('".$disciplina."','Diurno','".$i."','".$num_diurno."','".$semestre."','".$ano."')";
		$res_diurno=pg_query($insere_frequencia_diurno) or die ("Problema no acesso ao Banco de Dados");

		$query_disciplinas_grad=pg_query("select coduser from oferta_escolha_disciplina where semestre='".$semestre."' and ano='".$ano."' and prioridade='".$i."' and disciplina='".$disciplina."' and turno='Noturno' order by coduser");
		$num_noturno=pg_num_rows($query_disciplinas_grad);
		$insere_frequencia_noturno="insert into oferta_frequencia_pedidos values('".$disciplina."','Noturno','".$i."','".$num_noturno."','".$semestre."','".$ano."')";
		$res_noturno=pg_query($insere_frequencia_noturno) or die ("Problema no acesso ao Banco de Dados");

		}
	}
}


function aloca_professores($semestre,$ano)
{
/*
3- aloca_professores:
	k=1
	a- prioridade=k;
	   para cada elemento [a,b,c,d,e,f,g,h,i,j] (na ordem do item 2) seleciona a disciplina mais solicitada na perioridade k;
		aloca os professores nas turmas (no horário correspondente, se tiver) escolhendo o professor aleatoriamente;
	   existe um professor não alocado?
		sim: j:=k+1; volta para o a- com lista de professores que sobraram e prioridade=j;
		não: k=k+1 volta para a;
*/
// recupera grade:
	//$tabela="oferta_semestre_".$semestre;
	$tabela="oferta_lista_de_ofertas_nova";
	$query_grade=pg_query("select codigo,turno,turma,horarios from ".$tabela." order by codigo") or die ("Problema no acesso ao Banco de Dados");
	$num_grad=pg_num_rows($query_grade);
	$grade=pg_fetch_all($query_grade);

// pega os codigos do magistral. adicionado em 07/05/14.
	$query_codigos_magistral=pg_query("select distinct on (codigo_1) codigo_1 from oferta_grupos_magistral_teoria") or die ("Problema query_codigos_magistral");
	$codigos_magistral=array();//pg_fetch_all($query_codigos_magistral);
	for($i=0;$i<pg_num_rows($query_codigos_magistral);$i++)
		{
		$codigos_magistral[$i]=pg_fetch_result($query_codigos_magistral,$i,'codigo_1');
		}


//echo "select codigo,turno,turma,horarios from ".$tabela." order by codigo or die Problema no acesso ao Banco de Dados";
//echo $num_grad."\n";

	for ($i=1;$i<11;$i++)
		{
/*
		// recupera as disciplinas por ordem de solicitação:
		$query_pega_disciplina=pg_query("select * from oferta_frequencia_pedidos where semestre='".$semestre."' and ano='".$ano."' and prioridade='".$prioridade."' order by frequencia desc,turno");
		$pega_disciplina=pg_fetch_all($query_pega_disciplina);
*/
		$query_professor_prioridade=pg_query("select coduser from oferta_organiza_pedidos where prioridade='".$i."'");
		$professor_prioridade=pg_fetch_all($query_professor_prioridade);
//echo "select coduser from oferta_organiza_pedidos where prioridade='".$i."'";
		while((count($professor_prioridade)>0) and !empty($professor_prioridade))
				{

				$num_profs=count($professor_prioridade)-1;
				$prof_num=rand(0,$num_profs);
				$prof=$professor_prioridade[$prof_num]['coduser'];

//				$prof=array_rand($professor_prioridade['coduser'],1);
//echo "array: ".$num_profs;
//echo "prof_num: ".$prof_num;
//echo "professor: ".$prof;

			if($prof!=0)
			   {
				for ($prioridade=1; $prioridade<7;$prioridade++)
					{
					//$atendido="nao";
					$query_pega_escolha_prof=pg_query("select disciplina,turno from oferta_escolha_disciplina where coduser='".$prof."' and prioridade='".$prioridade."' and semestre='".$semestre."' and ano='".$ano."' limit 1");
					$pega_escolha_prof=pg_fetch_row($query_pega_escolha_prof);

					//$query_pega_turma=pg_query("select turma,horarios from ".$tabela." where codigo='".$pega_escolha_prof[0]."' and turno='".$pega_escolha_prof[1]."' and turma not in (select turma from oferta_lista_de_ofertas where semestre='".$semestre."' and ano='".$ano."' and disciplina='".$pega_escolha_prof[0]."' and turno='".$pega_escolha_prof[1]."' and professor<>'0') limit 1");
					if(!in_array($pega_escolha_prof[0],$codigos_magistral)) // incluido em 07/05/14
						{
						$query_pega_turma=pg_query("select turma,horarios from ".$tabela." where codigo='".$pega_escolha_prof[0]."' and turno='".$pega_escolha_prof[1]."' and professor='0' and semestre='".$semestre."' and ano='".$ano."' limit 1");
						$pega_turma=pg_fetch_row($query_pega_turma);

						// analise se ha turma para o professor na prioridade solicitada; se nao houver, pasa para a aprioridade seguinte.
						if(!empty($pega_turma))
							{
							if(checa_horarios_choque($prof,$pega_turma[1],$semestre,$ano)!="choque")
                                                                {
								$query_insere_lista_de_ofertas="update ".$tabela." set professor='".$prof."' where codigo='".$pega_escolha_prof[0]."' and turma='".$pega_turma[0]."' and semestre='".$semestre."' and ano='".$ano."'";
								//echo $query_insere_lista_de_ofertas."\n";
								$res=pg_query($query_insere_lista_de_ofertas) or die ("Problema no acesso ao banco de dados");
								$query_prof_atendido=pg_query("update oferta_escolha_disciplina set atendido='sim' where coduser='".$prof."' and disciplina='".$pega_escolha_prof[0]."' and semestre='".$semestre."' and ano='".$ano."'");
								$prioridade=7;
								//echo "atendido=sim \n";
								}
							}
						}
					else  // se é disciplina magistral/teoria checa todas as turmas do grupo. 07/05/14
						{
						// pega todas as turmas dos grupos/turno correspondente
						$query_grupos_turno=pg_query("select grupo,turmas from oferta_grupos_magistral_teoria where (turmas,codigo_1) in (select turma,codigo from oferta_lista_de_ofertas_nova where turno='".$pega_escolha_prof[1]."' and codigo='".$pega_escolha_prof[0]."') order by grupo,turmas");
						$grupo=array();
						$ocupado=array();
						while($reg_tur_cod=pg_fetch_row($query_grupos_turno))
							{
							$grupo[$reg_tur_cod[0]].="'".$reg_tur_cod[1]."',";
							}
						foreach($grupo as $key => $value)
							{
//echo "select turma,horarios from ".$tabela." where codigo='".$pega_escolha_prof[0]."' and turno='".$pega_escolha_prof[1]."' and professor='0' and semestre='".$semestre."' and ano='".$ano."' and turma in (".trim($value,",").")";
							$query_pega_turma=pg_query("select turma,horarios from ".$tabela." where codigo='".$pega_escolha_prof[0]."' and turno='".$pega_escolha_prof[1]."' and professor='0' and semestre='".$semestre."' and ano='".$ano."' and turma in (".trim($value,",").")");
							if(pg_num_rows($query_pega_turma)==count(explode(",",trim($value,",")))) $ocupado[$key]=0; else $ocupado[$key]=1;
							}
						foreach($ocupado as $key => $value)
							{
							if($value==0)
								{
								$turm=explode(",",trim($grupo[$key],","));
								if(checa_horarios_choque($prof,horarios_magistral($key),$semestre,$ano)!="choque")
                                                                        {
									aloca_professor_no_grupo_teoria_da_turma_dada($pega_escolha_prof[0],$prof,$turm[0],$semestre,$ano);
									$query_prof_atendido=pg_query("update oferta_escolha_disciplina set atendido='sim' where coduser='".$prof."' and disciplina='".$pega_escolha_prof[0]."' and semestre='".$semestre."' and ano='".$ano."'");
		                                                        $prioridade=7;
									break;
									}
								}
							}
						}
					}
				unset($professor_prioridade[$prof_num]);
				$professor_prioridade=array_values($professor_prioridade);

				}
			  }
			}

// ---------------  SEGUNDA RODADA ---------------------------------
// SOMENTE ALOCA CREDITO A QUEM PEDIU 8; 10 OU 12 OU MAIS.
for ($i=2;$i<8;$i++)
                {
                $query_professor_prioridade=pg_query("select coduser from oferta_organiza_pedidos where prioridade='".$i."'");
                $professor_prioridade=pg_fetch_all($query_professor_prioridade);
//echo "select coduser from oferta_organiza_pedidos where prioridade='".$i."'";
                while((count($professor_prioridade)>0) and !empty($professor_prioridade))
                          {

                                $num_profs=count($professor_prioridade)-1;
                                $prof_num=rand(0,$num_profs);
                                $prof=$professor_prioridade[$prof_num]['coduser'];


   		 if($prof!=0)
                           {
                                for ($prioridade=1; $prioridade<7;$prioridade++)
                                        {
					$query_iguais=pg_query("select creditos from oferta_escolha_creditos where coduser='".$prof."' and semestre='".$semestre."' and ano='".$ano."' and disciplinas_iguais_6='sim'");
					$creditos_iguais=pg_fetch_row($query_iguais);

                                        //$atendido="nao";
                                        $query_pega_escolha_prof=pg_query("select disciplina,turno,creditos from oferta_escolha_disciplina where coduser='".$prof."' and prioridade='".$prioridade."' and semestre='".$semestre."' and ano='".$ano."' and atendido='nao'  limit 1");
                                        $pega_escolha_prof=pg_fetch_row($query_pega_escolha_prof);

					 if (!empty($pega_escolha_prof))
                                             {
////////////////////////------------- substitui a parte comentada a partir de 07/05/14
					if(!in_array($pega_escolha_prof[0],$codigos_magistral)) // incluido em 07/05/14
                                                {
                                                $query_pega_turma=pg_query("select turma,horarios from ".$tabela." where codigo='".$pega_escolha_prof[0]."' and turno='".$pega_escolha_prof[1]."' and professor='0' and semestre='".$semestre."' and ano='".$ano."' limit 1");
                                                $pega_turma=pg_fetch_row($query_pega_turma);

                                                // analise se ha turma para o professor na prioridade solicitada; se nao houver, pasa para a aprioridade seguinte.
                                                if(!empty($pega_turma))
                                                        {
							 if(checa_horarios_choque($prof,$pega_turma[1],$semestre,$ano)!="choque")
                                                                {
	                                                        $query_insere_lista_de_ofertas="update ".$tabela." set professor='".$prof."' where codigo='".$pega_escolha_prof[0]."' and turma='".$pega_turma[0]."' and semestre='".$semestre."' and ano='".$ano."'";
        	                                                //echo $query_insere_lista_de_ofertas."\n";
                	                                        $res=pg_query($query_insere_lista_de_ofertas) or die ("Problema no acesso ao banco de dados");
                        	                                $query_prof_atendido=pg_query("update oferta_escolha_disciplina set atendido='sim' where coduser='".$prof."' and disciplina='".$pega_escolha_prof[0]."' and semestre='".$semestre."' and ano='".$ano."'");
                                	                        $prioridade=7;
                                        	                //echo "atendido=sim \n";
								}
                                                        }
                                                }
                                        else  // se é disciplina magistral/teoria checa todas as turmas do grupo. 07/05/14
                                                {
                                                // pega todas as turmas dos grupos/turno correspondente
                                                $query_grupos_turno=pg_query("select grupo,turmas from oferta_grupos_magistral_teoria where (turmas,codigo_1) in (select turma,codigo from oferta_lista_de_ofertas_nova where turno='".$pega_escolha_prof[1]."' and codigo='".$pega_escolha_prof[0]."') order by grupo,turmas");
                                                $grupo=array();
                                                $ocupado=array();
                                                while($reg_tur_cod=pg_fetch_row($query_grupos_turno))
                                                        {
                                                        $grupo[$reg_tur_cod[0]].="'".$reg_tur_cod[1]."',";
                                                        }
                                                foreach($grupo as $key => $value)
                                                        {
                                                        $query_pega_turma=pg_query("select turma,horarios from ".$tabela." where codigo='".$pega_escolha_prof[0]."' and turno='".$pega_escolha_prof[1]."' and professor='0' and semestre='".$semestre."' and ano='".$ano."' and turma in (".trim($value,",").")");
                                                        if(pg_num_rows($query_pega_turma)==count(explode(",",trim($value,",")))) $ocupado[$key]=0; else $ocupado[$key]=1;
                                                        }
                                                foreach($ocupado as $key => $value)
                                                        {
                                                        if($value==0)
								{
// AQUI ENTRA A CHECAGEM DE CHOQUE DE HORARIOS COM AS TURMAS DO MAGISTRAL;
								$turm=explode(",",trim($grupo[$key],","));
								if(checa_horarios_choque($prof,horarios_magistral($key),$semestre,$ano)!="choque")
									{
									aloca_professor_no_grupo_teoria_da_turma_dada($pega_escolha_prof[0],$prof,$turm[0],$semestre,$ano);
									$query_prof_atendido=pg_query("update oferta_escolha_disciplina set atendido='sim' where coduser='".$prof."' and disciplina='".$pega_escolha_prof[0]."' and semestre='".$semestre."' and ano='".$ano."'");
                	                                        	$prioridade=7;
                        		                                //echo "atendido=sim \n";
									break;
									}
								}
                                                        }
                                                }

					    }
/*//%% comentado em 07/05/14
					if (!empty($pega_escolha_prof))
						{
	                                        $query_pega_turma=pg_query("select turma,horarios from ".$tabela." where codigo='".$pega_escolha_prof[0]."' and turno='".$pega_escolha_prof[1]."' and professor='0' and semestre='".$semestre."' and ano='".$ano."' limit 1");
        	                                $pega_turma=pg_fetch_row($query_pega_turma);


// analise se ha tyurma para o professor na prioridade solicitada; se nao houver, pasa para a aprioridade seguinte.
                	                        if(!empty($pega_turma))
                        	                        {
							if(checa_horarios_choque($prof,$pega_turma[1],$semestre,$ano)!="choque")
								{

								 $query_insere_lista_de_ofertas="update ".$tabela." set professor='".$prof."' where codigo='".$pega_escolha_prof[0]."' and turma='".$pega_turma[0]."' and semestre='".$semestre."' and ano='".$ano."'";
                                                //echo $query_insere_lista_de_ofertas."\n";
        	                                	        $res=pg_query($query_insere_lista_de_ofertas) or die ("Problema no acesso ao banco de dados");
                	                                	$query_prof_atendido=pg_query("update oferta_escolha_disciplina set atendido='sim' where coduser='".$prof."' and disciplina='".$pega_escolha_prof[0]."' and semestre='".$semestre."' and ano='".$ano."'");

                        	                        	$prioridade=7;
                                                //echo "atendido=sim \n";
								}
                                                	}
						}
*///%%
                                        }
                                unset($professor_prioridade[$prof_num]);
                                $professor_prioridade=array_values($professor_prioridade);

                                }
                          }
                }

}


function checa_horarios_choque($professor,$horarios,$semestre,$ano)
{

//$tabela="oferta_semestre_".$semestre;
$tabela="oferta_lista_de_ofertas_nova";
$tab_horarios=explode("-",$horarios);

/*
if(count($tab_horarios)==1) $lista_horarios="('".$tab_horarios[0]."')";
if(count($tab_horarios)==2) $lista_horarios="('".$tab_horarios[0]."','".$tab_horarios[1]."')";
if(count($tab_horarios)==3) $lista_horarios="('".$tab_horarios[0]."','".$tab_horarios[1]."','".$tab_horarios[2]."')";
*/
for($i=0;$i<count($tab_horarios);$i++)
	{
	$lista_horarios.="'".$tab_horarios[$i]."',";
	}
$lista_horarios="(".rtrim($lista_horarios,",").")";

//echo $lista_horarios."--/--";
//echo "select codigo FROM ".$tabela." WHERE professor='".$professor."' and semestre='".$semestre."' and ano='".$ano."' and (SUBSTR(horarios,1,3) in ".$lista_horarios." or SUBSTR(horarios,5,3) in ".$lista_horarios." or SUBSTR(horarios,9,3) in ".$lista_horarios."--/--";

$query_choque=pg_query("select codigo FROM ".$tabela." WHERE professor='".$professor."' and semestre='".$semestre."' and ano='".$ano."' and (SUBSTR(horarios,1,3) in ".$lista_horarios." or SUBSTR(horarios,5,3) in ".$lista_horarios." or SUBSTR(horarios,9,3) in ".$lista_horarios.")");

$num_choque=pg_num_rows($query_choque);

if ($num_choque!=0) $resultado="choque"; else $resultado="ok";
//echo print_r(pg_fetch_all($query_choque));
//echo "--/--".$resultado."--/--";
return $resultado;
}



function imprime_esboco_lista_ofertas($semestre,$ano)
{

// disciplina |  turma | turno | professor  |  semestre|  ano | horarios |

$query_dados=pg_query("select u.coduser,name||' '||firstname as nome, m.codigo as disciplina, lo.turma as turma, lo.turno as turno, lo.horarios as horarios, lo.magistral as magistral from oferta_lista_de_ofertas_nova lo, users u, disciplinas_mat m where u.coduser=lo.professor and m.codigo=lo.codigo and lo.semestre='".$semestre."' and lo.ano='".$ano."' union (select u.coduser,name||' '||firstname as nome, m.codigo as disciplina, lo.turma as turma, lo.turno as turno, lo.horarios as horarios, lo.magistral as magistral from oferta_lista_de_ofertas_nova lo, users u, disciplinas_mat m,oferta_grupos_magistral_teoria gm where u.coduser=lo.professor and lo.codigo=gm.codigo_1 and m.codigo=gm.codigo and lo.semestre='".$semestre."' and lo.ano='".$ano."') order by nome, disciplina");
$num_dados=pg_num_rows($query_dados);

?>
  <body>
      <table class=big>
         <tr>
        <td class=header align=center colspan=2>
        <h1> Lista de Ofertas do <?php echo $semestre;?>&ordm;/ <?php echo $ano;?></h1>
        </td>
      </tr>
      <tr><td>
	<table border>
	<tr><td><b>Professor</b></td><td><b>Disciplina</b></td><td><b>Turma</b></td><td><b>Turno</b></td><td><b>Hor&aacute;rios</b></td><td><b>Magistral</b></td></tr>
	<tr></tr>
	<?php
	$cor_de_fundo="#FFFFFF";
	$prof=0;
	while ($registro=pg_fetch_row($query_dados))
		{
		if ($prof==0) $prof=$registro[0];
		else
		   {
		    if ($registro[0]!=$prof) {if ($cor_de_fundo=="#FFFFFF") $cor_de_fundo="#D0D0D0"; else $cor_de_fundo="#FFFFFF";}
		   }
		?>
		<tr VALIGN=CENTER BGCOLOR="<?php echo $cor_de_fundo;?>">
		<td><?php echo $registro[1];?></td>
		<td><?php echo $registro[2];?></td>
		<td><?php echo $registro[3];?></td>
		<td><?php echo $registro[4];?></td>
		<td><?php echo $registro[5];?></td>
		<td><?php echo $registro[6];?></td>
		</tr>
		<?php
		}
	?>
	</table>
	</td></tr>
	</table>
	</body>
	</html>
	<?php
}

function imprime_lista_atendimento($semestre,$ano)
{

// disciplina |  turma | turno | professor  |  semestre|  ano | horarios |

$query_dados=pg_query("select distinct on (nome) u.coduser,name||' '||firstname as nome from users u, oferta_escolha_disciplina ed where u.coduser=ed.coduser and ed.semestre='1' and ed.ano='2012' order by nome");
$num_dados=pg_num_rows($query_dados);

?>
<html>
  <header>
    <link type="text/css" rel="stylesheet" href="../../global/grafic.css">
<meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
  </header>
  <body>
      <table class=big>
         <tr>
        <td class=header align=center colspan=7>
        <h1> Lista de Atendimento aos professores - <?php echo $semestre;?>&ordm;/ <?php echo $ano;?></h1>
        </td>
      </tr>
      <tr>
	<table border>
	<tr><td><b>Professor</b></td><th colspan=6><b>Prioridade </b></th></tr>
	<tr></tr>
	<?php
	$cor_de_fundo="#FFFFFF";
	$prof=0;
	while ($registro=pg_fetch_row($query_dados))
		{
		if ($prof==0) $prof=$registro[0];
		else
		   {
		    if ($registro[0]!=$prof) {if ($cor_de_fundo=="#FFFFFF") $cor_de_fundo="#D0D0D0"; else $cor_de_fundo="#FFFFFF";}
		   }
		$query_prioridades=pg_query("select prioridade,atendido from oferta_escolha_disciplina where coduser='".$registro[0]."' and semestre='".$semetre."' and ano='".$ano."' order by prioridade");
		$impresso="<td>".$registro[1]."</td>";
		while ($registro2=pg_fetch_row($query_prioridades))
			{
			$impresso.="<td>".$registro2[1]."</td>";
			}
		?>
		<tr VALIGN=CENTER BGCOLOR="<?php echo $cor_de_fundo;?>"> <?php echo $impresso;?>
		<?php
		}
	?>
	</table>
	</table>
	</body>
	</html>
	<?php
}

function atualiza_rodizio_noturno($semestre, $ano){
// atualiza a taberla de rodizio noturno para o $semestre/$ano a partir dos dados da lista de ofertas do semestre anterior:
$horarios_not=array('2N34 4N12','2N12 35N34','2N12 35N34','3N34 56N12','3N34 5N34 6N12','2N12 35N34','35N12','3N12 5N12','24N34','3N12 6N12','36N12','3N12 5N12','3N34 6N12','26N12 4N34','2N12 4N34','2N12 3N34','7M12 4N1234','7T2345 5N1234','7M34 3N1234','2N12 35N34','2N12 35N34','2N12 35N34','2N12 35N34','7M1234 4N12','7M1234 4N12','7M1234 4N12','7M1234 4N12','246N12','35N34','24N12','46N12','46N12','2N12 6N34','35N34','24N12',);

$disciplinas_magistrais = array('113018', '113034');

$credito_noturno = 0;

$credito_teoria = 2;

if ($semestre==1){
    $semestre_anterior=2;
    $ano_anterior=$ano-1;
} else {
    $semestre_anterior=1;
    $ano_anterior=$ano;
}

$query_profs=pg_query("select f.coduser,os.codigo,os.turma,os.turno,os.horarios from oferta_lista_sigra os, users u,fonctionnaire f where os.coduser like '%'||f.coduser||'%' and f.coduser=u.coduser and u.is_actif and f.statut='professor' and f.contract_type='dedicacao exclusiva' and  os.semestre='".$semestre_anterior."' and os.ano='".$ano_anterior."' order by f.coduser,os.codigo,os.turma") or die("problemas de conexao em funcoes.php atualiza_rodizio_noturno");

$prof=0;
$registros = pg_fetch_all($query_profs);

foreach ($registros as $registro){
    echo "Inserindo atuação para o professor: ".$registro['coduser']."<br>";
        echo "aqui para o usuario: ".$prof."<br>";
        if(in_array($registro['codigo'], $disciplinas_magistrais)){
            $seleciona_professor_teoria = pg_query("select * from oferta_lista_de_ofertas where professor = '".$registro['coduser']."' and ano='".$ano_anterior."' and semestre = '".$semestre_anterior."' and turma = '".$registro['turma']."' and disciplina = '".$registro['codigo']."'");
            $professor_exercicio = pg_num_rows($seleciona_professor_teoria);

            if ($registro['turno'] == 'Noturno'){
                $seleciona_professor_teoria = pg_query("select * from oferta_lista_de_ofertas where professor = '".$registro['coduser']."' and ano='".$ano_anterior."' and semestre = '".$semestre_anterior."' and turma = '".$registro['turma']."' and disciplina = '".$registro['codigo']."'");
                $professor_exercicio = pg_num_rows($seleciona_professor_teoria);

                if ($professor_exercicio != 0) {
                        $resultado = pg_query("select * from disciplinas_mat where codigo = '".$registro['codigo']."'");
                    $linha = pg_fetch_row($resultado);

                    $credito_noturno = $linha[2] - $credito_teoria;

                }else{
                   $credito_noturno = $credito_teoria;
                }

                if (strlen($registro['turma'])==2){
                    $credito_noturno = 2;
                }
            } else {
                $credito_noturno = 0;
            }

            $query_recupera_grupo_magistral = pg_query("select * from oferta_grupos_magistral_teoria where codigo = '".$registro['codigo']."' and semestre='".$semestre_anterior."' and ano='".$ano_anterior."' and grupo in (select grupo from oferta_grupos_magistral_teoria where codigo = '".$registro['codigo']."' and semestre='".$semestre_anterior."' and ano='".$ano_anterior."' and turmas = '".$registro['turma']."')");

            $magistral = pg_fetch_all($query_recupera_grupo_magistral);

            $turmas = "";

            foreach ($magistral as $disciplina){
                $turmas .= "-".$disciplina['turmas'];
            }
            $turmas = substr($turmas, 1);
            die();
            $query_checa=pg_query("select * from oferta_horarios_rodizio_noturno_creditos where coduser='".$registro['coduser']."' and semestre='".$semestre_anterior."' and ano='".$ano_anterior."' and turma = '".$turmas."' and disciplina='".$registro['codigo']."'");

            $num_checa=pg_num_rows($query_checa);

            if ($num_checa == 0) {
               pg_query("insert into oferta_horarios_rodizio_noturno_creditos values(default, '".$registro['coduser']."','".$semestre_anterior."','".$ano_anterior."','".$credito_noturno."', '".$registro['codigo']."', '".$registro['turma']."')") or die ("problema 01 de conexao com o banco");
            }else{
               pg_query("update oferta_horarios_rodizio_noturno_creditos set credito_noturno='".$credito_noturno."' where coduser='".$registro['coduser']."' and semestre='".$semestre_anterior."' and ano='".$ano_anterior."' and turma = '".$registro['turma']."' and disciplina = '".$registro['codigo']."'") or die ("problema 02 de conexao com o banco");
            }

        } else{
                if ($registro['turno'] == 'Noturno'){
                $resultado = pg_query("select * from disciplinas_mat where codigo = '".$registro['codigo']."'");
                $linha = pg_fetch_row($resultado);

                $credito_noturno = $linha[2];
                } else {
                    $credito_noturno = 0;
                }
                $query_checa=pg_query("select * from oferta_horarios_rodizio_noturno_creditos where coduser='".$registro['coduser']."' and semestre='".$semestre_anterior."' and ano='".$ano_anterior."' and turma = '".$registro['turma']."' and disciplina='".$registro['codigo']."'");
                $num_checa=pg_num_rows($query_checa);
                if ($num_checa == 0) {
                    pg_query("insert into oferta_horarios_rodizio_noturno_creditos values(default, '".$registro['coduser']."','".$semestre_anterior."','".$ano_anterior."','".$credito_noturno."', '".$registro['codigo']."', '".$registro['turma']."')") or die ("problema 03 de conexao com o banco");
                }else{
                    pg_query("update oferta_horarios_rodizio_noturno_creditos set credito_noturno='".$credito_noturno."' where coduser='".$registro['coduser']."' and semestre='".$semestre_anterior."' and ano='".$ano_anterior."' and turma =  '".$registro['turma']."' and disciplina = '".$registro['codigo']."'") or die ("problema 04 de conexao com o banco");
                }
        }
	}
}

function atualiza_rodizio_noturno_antiga($semestre,$ano)
{
// atualiza a taberla de rodizio noturno para o $semestre/$ano a partir dos dados da lista de ofertas do semestre anterior:
$horarios_not=array('2N34 4N12','2N12 35N34','2N12 35N34','3N34 56N12','3N34 5N34 6N12','2N12 35N34','35N12','3N12 5N12','24N34','3N12 6N12','36N12','3N12 5N12','3N34 6N12','26N12 4N34','2N12 4N34','2N12 3N34','7M12 4N1234','7T2345 5N1234','7M34 3N1234','2N12 35N34','2N12 35N34','2N12 35N34','2N12 35N34','7M1234 4N12','7M1234 4N12','7M1234 4N12','7M1234 4N12','246N12','35N34','24N12','46N12','46N12','2N12 6N34','35N34','24N12',);

if ($semestre==1) {$semestre_anterior=2;$ano_anterior=$ano-1;} else {$semestre_anterior=1; $ano_anterior=$ano;}

// acrescentado em 17/04/2015 para poder usar apenas a lista de ofertas do SIgra:
if ($ano_anterior<2012)
$query_profs=pg_query("select c.coduser,c.codigo,c.turma_disc,turno,horarios from oferta_carga_professor c,oferta_lista_sigra s where nivel='GR' and c.semestre='".$semestre_anterior."' and c.ano='".$ano_anterior."' and c.semestre=s.semestre and c.ano=s.ano and c.codigo=s.codigo and c.turma_disc=s.turma order by coduser,codigo,turma_disc") or die("problemas de conexao em funcoes.php atualiza_rodizio_noturno");
else
$query_profs=pg_query("select f.coduser,os.codigo,os.turma,os.turno,os.horarios from oferta_lista_sigra os, users u,fonctionnaire f where os.coduser like '%'||f.coduser||'%' and f.coduser=u.coduser and u.is_actif and f.statut='professor' and f.contract_type='dedicacao exclusiva' and  os.semestre='".$semestre_anterior."' and os.ano='".$ano_anterior."' order by f.coduser,os.codigo,os.turma") or die("problemas de conexao em funcoes.php atualiza_rodizio_noturno");


//$atuacao_noturno=array();
$prof=0;
while ($registro=pg_fetch_row($query_profs))
	{
	if($registro[0]!=$prof)
		{
		if($prof!=0)
			{
			$query_checa=pg_query("select * from oferta_horarios_rodizio_noturno where coduser='".$prof."' and semestre='".$semestre_anterior."' and ano='".$ano_anterior."'");
			$num_checa=pg_num_rows($query_checa);
			if ($num_checa==0)
				$query_atualiza=pg_query("insert into oferta_horarios_rodizio_noturno values('".$prof."','".$semestre_anterior."','".$ano_anterior."','".$atuacao_not."')") or die ("problema de conexao com o banco");
			else
				$query_atualiza=pg_query("update oferta_horarios_rodizio_noturno set disc_noturno='".$atuacao_not."' where coduser='".$prof."' and semestre='".$semestre_anterior."' and ano='".$ano_anterior."'") or die ("problema de conexao com o banco");
			}
		$prof=$registro[0];
		$atuacao_not=0;
		$array_de_horarios=array(219 => 0,221 => 0,319 => 0,321 => 0,419 => 0,421 => 0,519 => 0,521 => 0,619 => 0,621 => 0);
		}
	if (($registro[3]=="Noturno") or ($registro[3]=="Ambos"))
		{
		$horario=explode("-",$registro[4]);
		foreach ($horario as $key => $value)
			{
			if (in_array($value,$horarios_not) and ($array_de_horarios[$value]==0))
				{
				$array_de_horarios[$value]=1;
				$atuacao_not=1;// $atuacao_not=1; correcao emj 15/08/2015

				}
			}
		}
	}
// inclui a impressao dos dados da ultima linha de $registro:
	$query_checa=pg_query("select * from oferta_horarios_rodizio_noturno where coduser='".$prof."' and semestre='".$semestre_anterior."' and ano='".$ano_anterior."'");
                        $num_checa=pg_num_rows($query_checa);
                        if ($num_checa==0)
                                $query_atualiza=pg_query("insert into oferta_horarios_rodizio_noturno values('".$prof."','".$semestre_anterior."','".$ano_anterior."','".$atuacao_not."')") or die ("problema de conexao com o banco");
                        else
                                $query_atualiza=pg_query("update oferta_horarios_rodizio_noturno set disc_noturno='".$atuacao_not."' where coduser='".$prof."' and semestre='".$semestre_anterior."' and ano='".$ano_anterior."'") or die ("problema de conexao com o banco");

}


//Funções incluidas em 20/04/2014 para poder lidar com as turmas magostrais:

function corrige_codigo_turmas_magistral($semestre,$ano) // em 20/04/2014
{
// roda no fim da rotina que roda a lista;
// no final da elaboração da lista, a tabela é corrigida par poder ser impressa e apresentada ao colegiado:
$seleciona_magistral=pg_query("select codigo from  oferta_disciplinas_magistral") or die("problema 02 em muda_horarios_turmas_magistral");

// para cada linha de $seleciona_magistral, muda o código da disciplina teoria:
while($turma=pg_fetch_row($seleciona_magistral))
{

$muda_codigo="update oferta_lista_de_ofertas_nova set codigo='".$turma[0]."' where codigo='".$turma[0]."001'";

$query_muda_codigo=pg_query($muda_codigo) or die("problema 05 em muda_horarios_turmas_magistral");

} //fim do do while
} // fim da funcao corrige_codigo_turmas_magistral
//
//





function aloca_professor_no_grupo_teoria_da_turma_dada($codigo,$professor,$turma,$semestre,$ano)
{
//$codigo_0=($codigo-1)/1000;
$pega_turmas_horarios_grupo="select turmas,horario from oferta_grupos_magistral_teoria where grupo in (select grupo from oferta_grupos_magistral_teoria where codigo_1='".$codigo."' and turmas=".$turma.")";
//echo $pega_turmas_horarios_grupo."---//---";
$query_pega_turmas_horarios_grupo=pg_query($pega_turmas_horarios_grupo) or die ("problema 01 em aloca_professor_no_grupo_teoria_da_turma_dada");

while($horarios=pg_fetch_row($query_pega_turmas_horarios_grupo))
{
$update_oferta="update oferta_lista_de_ofertas_nova set professor='".$professor."' where codigo='".$codigo."'  and  turma='".$horarios[0]."' and semestre='".$semestre."' and ano='".$ano."'";
//echo $update_oferta."--/--";
$res_oferta=pg_query($update_oferta) or die("problema 02 em aloca_professor_no_grupo_teoria_da_turma_dada");
}

}// fim function aloca_professor_no_grupo_teoria_da_turma_dada



function horarios_magistral($grupo)
{
$pega_horarios=pg_query("select distinct on (horario) horario from oferta_grupos_magistral_teoria where grupo='".$grupo."' order by horario") or die("problema em funcoes.php horarios_magistral");

$horarios="";

while($res=pg_fetch_row($pega_horarios))
	{
	$horarios.=$res[0]."-";
	}

return rtrim($horarios,"-");
}


?>
