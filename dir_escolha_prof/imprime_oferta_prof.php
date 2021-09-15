<?php
function imprime_escolha_prof($coduser,$semestre,$ano)
{
	$lang="pt_BR";
	$select_profs=pg_query("select name||' '||firstname as nome from users where coduser='".$coduser."'");
	$nome_prof=pg_fetch_array($select_profs,0);
		//oferta_escolha_disciplina: coduser | prioridade | disciplina | dias | horarios | semestre | ano  |  turno  | creditos | atendido
		$query_escolha_disciplinas=pg_query("select * from oferta_escolha_disciplina where coduser='".$coduser."' and semestre='".$semestre."' and ano='".$ano."' order by prioridade");
		$registro_disciplinas=pg_fetch_all($query_escolha_disciplinas);
		$num_disc=pg_num_rows($query_escolha_disciplinas); 
		//oferta_escolha_creditos:  coduser | creditos | disciplinas_iguais_6 | semestre | ano 
		$query_escolha_creditos=pg_query("select * from oferta_escolha_creditos where coduser='".$coduser."' and semestre='".$semestre."' and ano='".$ano."'");
		$registro_creditos=pg_fetch_row($query_escolha_creditos);

		//oferta_escolha_creditos_pos: coduser | creditos | disciplina | semestre | ano
		$query_escolha_creditos_pos=pg_query("select * from oferta_escolha_creditos_pos where coduser='".$coduser."' and semestre='".$semestre."' and ano='".$ano."'");
		$registro_creditos_pos=pg_fetch_all($query_escolha_creditos_pos);
		$num_creditos_pos=pg_num_rows($query_escolha_creditos_pos);


		//oferta_escolha_creditos_est_pesq_pos: coduser | creditos | orientando | semestre | ano
		$query_escolha_creditos_est_pesq_pos=pg_query("select * from oferta_escolha_creditos_est_pesq_pos where coduser='".$coduser."' and semestre='".$semestre."' and ano='".$ano."'");
		$registro_creditos_est_pesq_pos=pg_fetch_all($query_escolha_creditos_est_pesq_pos);
		$num_creditos_est_pesq_pos=pg_num_rows($query_escolha_creditos_est_pesq_pos);
		$tabela="oferta_lista_de_ofertas_nova";


		// pega dados de oferta_magistral_opcoes_profs
                $query_magistral_opcoes_profs=pg_query("select * from oferta_magistral_opcoes_profs where coduser='".$coduser."' and semestre='".$semestre."' and ano='".$ano."'");
                $ck_c1_teoria="";
                $ck_c1_exos="";
                $ck_m1_teoria="";
                $ck_m1_exos="";
                $ck_ims_teoria="";
                $ck_ims_exos="";
                while($registro_magistral=pg_fetch_row($query_magistral_opcoes_profs))
                        {
                        if($registro_magistral[1]==113034)
                                { 
                                if($registro_magistral[2]=="teoria") $ck_c1_teoria="sim";
                                if($registro_magistral[2]=="exercicios") $ck_c1_exos="sim";
                                }
                        if($registro_magistral[1]==113018)
                                {
                                if($registro_magistral[2]=="teoria") $ck_m1_teoria="sim";
                                if($registro_magistral[2]=="exercicios") $ck_m1_exos="sim";
                                }
                        if($registro_magistral[1]==113701)
                                {
                                if($registro_magistral[2]=="teoria") $ck_ims_teoria="sim";
                                if($registro_magistral[2]=="exercicios") $ck_ims_exos="sim";
                                }
                        }



?>		
	<html>
	  <header>
	    <link type="text/css" rel="stylesheet" href="global/grafic.css">
	    <meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
	 </header>	
	  <body>
		  <table class=big>
		    <tr>
		        <td class=header align=center colspan=2>
			<h1>Ficha de Prefer&ecirc;ncias para a lista de ofertas do <?php echo $semestre;?>&ordm;/<?php echo $ano;?><br>
				Atualiza&ccedil;&otilde;es registradas em <?php echo date(d)."/".date(m)."/".date(Y);?> &agrave;s <?php echo date("H:i:s");?></h1>
        	</td>
	      </tr>
	      <tr>
	      <td><b>Professor:</b> <?php echo $nome_prof['nome'];?></td>
        	</tr>
        	<tr>
		<td><b>Quantos cr&eacute;ditos pretende lecionar na gradua&ccedil;&atilde;o?</b> <?php echo $registro_creditos[1];?></td>
	        </tr>
        	<tr>
		<td><b>Prefer&ecirc;ncia por 2 (duas) disciplinas de 6 cr&eacute;ditos iguais? </b><?php echo $registro_creditos[2];?></td>
	        </tr>
        	<tr>
		<td><b>Quais disciplinas pretende lecionar na p&oacute;s-gradua&ccedil;&atilde;o (exceto Est&aacute;gios em Pesquisa)?</b><BR>
		<?php
               	for ($cont_pos=0;$cont_pos<2;$cont_pos++)
                	{
        		if ($num_creditos_pos==0) echo "Nenhuma";
        	        $select_disciplinas_pg[$cont_pos]=pg_query("select codigo, nome, creditos from disciplinas_mat where status='pgrad' order by nome"); 
                	while ($registro[$cont_pos]=pg_fetch_row($select_disciplinas_pg[$cont_pos]))
                        	{
                                if ($registro[$cont_pos][0]==$registro_creditos_pos[$cont_pos]['disciplina']) echo $registro[$cont_pos][0]."-".$registro[$cont_pos][1]." (".$registro[$cont_pos][2].")<BR>";
        	                }
			}
		?>
		<BR>
		</td>
		</tr>
	        <tr>
                <td><b>Cr&eacute;ditos em Est&aacute;gio de Pesquisa:</b><br>
		<?php
                for ($cont_pesq=0;$cont_pesq<5;$cont_pesq++)
                        {
                	if ($registro_creditos_est_pesq_pos[$cont_pesq]['creditos']!=0) 
				{
	                        if ($registro_creditos_est_pesq_pos[$cont_pesq]['creditos']==1) echo "1 cr&eacute;dito   ";
        	                if ($registro_creditos_est_pesq_pos[$cont_pesq]['creditos']==2) echo "2 cr&eacute;ditos  ";
	        	        $select_orientando[$cont_pesq]=pg_query("select coduser,name,firstname from users where coduser in (select coduser from student where status='ativo') order by name");
        	        	while ($registro1[$cont_pesq]=pg_fetch_row($select_orientando[$cont_pesq]))
                	        	{
	                	        if ($registro_creditos_est_pesq_pos[$cont_pesq]['orientando']==$registro1[$cont_pesq][0]) echo " Orientando: ".$registro1[$cont_pesq][1]." ".$registro1[$cont_pesq][2]."<BR>";
					}
				}
			}
		?>
		<BR>    
                </td>
                </tr>
		<tr><td><b> Escolha a disciplina/turno:</b><br>
		<?php
//$registro_disciplinas: coduser | prioridade | disciplina | dias | horarios | semestre | ano  |  turno  | creditos | atendido
                 for ($i=1;$i<7;$i++)
                                {
                                echo "<b>Prioridade ".$i.":</b>";
				$select_disciplinas[$i]=pg_query("select distinct on (m.nome,lo.turno) lo.codigo,m.nome,m.creditos,upper(lo.turno),lo.status from ".$tabela." lo, disciplinas_mat m where m.codigo=lo.codigo order by m.nome,lo.turno");                
				$num_disc=pg_num_rows($select_disciplinas[$i]);
				if ($num_disc==0) echo "escolher uma disciplina <br>";
					else 
					{
				while($registro2[$i]=pg_fetch_row($select_disciplinas[$i]))
                                        {
                                        if (($registro2[$i][0]==$registro_disciplinas[$i-1]['disciplina']) and ($registro2[$i][3]==strtoupper($registro_disciplinas[$i-1]['turno']))) echo $registro2[$i][3].":  ".$registro2[$i][0]."-".$registro2[$i][1]." (".$registro2[$i][2].")<br>";
					}
					}
				}
		?>
		</td></tr>
	<tr><td><b>Atua&ccedil;&atilde;o em disciplinas no esquema magistral:</b></td></tr>
        <tr><td><b>C&aacute;lculo 1:</b>  Teoria(<?php echo $ck_c1_teoria;?>); Exerc&iacute;cios(<?php echo $ck_c1_exos;?>)</td></tr>
        <tr><td><b>Matem&aacute;tica 1:</b>  Teoria(<?php echo $ck_m1_teoria;?>); Exerc&iacute;cios(<?php echo $ck_m1_exos;?>)</td></tr>
        <tr><td><b>Introdu&ccedil;&atilde;o &agrave; Matem&aacutetica Superior:</b>  Teoria(<?php echo $ck_ims_teoria;?>); Exerc&iacute;cios(<?php echo $ck_ims_exos;?>)</td></tr>
        <tr><td><br><br></td></tr>

        </td>
        </tr>
        </table>
        </BODY>
        </HTML>
<?php
}
?>

