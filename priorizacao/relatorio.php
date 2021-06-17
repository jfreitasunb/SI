<?php
//function relatorio($usuario,$semestre_inicio,$ano_inicio,$semestre_fim,$ano_fim,$teste3,$teste4)
//{
//if (($teste1==0) and (($teste3!=0) or ($teste4!=0))) //------------------------------------------"escolheu relatorio no periodo";
//{

if($teste3!=0 and $teste4!=0)
{
if (($semestre_inicio==1) and ($semestre_fim==2)) $where=" ano>='".$ano_inicio."' and ano<= '".$ano_fim."'";
if (($semestre_inicio==1) and ($semestre_fim==1)) $where=" ((ano>='".$ano_inicio."' and ano< '".$ano_fim."') or (ano='".$ano_fim."' and semestre='1'))";
if (($semestre_inicio==2) and ($semestre_fim==1)) $where=" ((ano>'".$ano_inicio."' and ano< '".$ano_fim."') or (ano='".$ano_fim."' and semestre='1') or (ano='".$ano_inicio."' and semestre='2'))";
if (($semestre_inicio==2) and ($semestre_fim==2)) $where=" ((ano>'".$ano_inicio."' and ano<= '".$ano_fim."') or (ano='".$ano_inicio."' and semestre='2'))";
}

if($teste3!=0 and $teste4==0)
{
$where=" ano='".$ano_inicio."' and semestre='".$semestre_inicio."'";
}

if($teste3==0 and $teste4!=0)
{
$where=" ano='".$ano_fim."' and semestre='".$semestre_fim."'";
}

$dados="select * from prio_licencas_historico_MAT where coduser='".$usuario."' and ".$where;
//echo $dados;
$query_dados=pg_query($dados);

$creditos=0;
$coord_massa=0;
$creditos_pesq_mestrado=0;
$creditos_pesq_doutorado=0;
$monografia_esp_mat=0;
$esp_profmat=0;
$pub_livro=0;
$pub_art_arb=0;
$pub_cap_livro=0;
$pub_res_an_div=0;
$apr_oral_evento=0;
$apr_poster_evento=0;
$coord_proj_fin=0;
$banca_mes_dou=0;
$exame_qualif_dou=0;
$exame_qualif_mest=0;
$exame_linguas=0;
$orient_pibs_pet=0;
$tutor_pet=0;
$coord_pibid=0;
$coord_ext_profmat=0;
$org_local_reg=0;
$org_nac_inter=0;
$coord_verao=0;
$coord_sem_mat=0;
$banca_conc=0;

$cargo_dir="";
$coord="";
$comis_mat="";
$repr_cons="";
$inicio_ultima="";
$fim_ultima="";

while ($registro=pg_fetch_row($query_dados))
{
$creditos=$creditos+$registro[3];
$coord_massa=$coord_massa+$registro[4];
$creditos_pesq_mestrado=$creditos_pesq_mestrado+$registro[5];
$creditos_pesq_doutorado=$creditos_pesq_doutorado+$registro[6];
$monografia_esp_mat=$monografia_esp_mat+$registro[7];
$esp_profmat=$esp_profmat+$registro[8];
$pub_livro=$pub_livro+$registro[9];
$pub_art_arb=$pub_art_arb+$registro[10];
$pub_cap_livro=$pub_cap_livro+$registro[11];
$pub_res_an_div=$pub_res_an_div+$registro[12];
$apr_oral_evento=$apr_oral_evento+$registro[13];
$apr_poster_evento=$apr_poster_evento+$registro[14];
$coord_proj_fin=$coord_proj_fin+$registro[15];
$banca_mes_dou=$banca_mes_dou+$registro[16];
$exame_qualif_dou=$exame_qualif_dou+$registro[17];
$exame_qualif_mest=$exame_qualif_mest+$registro[18];
$exame_linguas=$exame_linguas+$registro[19];
$orient_pibs_pet=$orient_pibs_pet+$registro[20];
$tutor_pet=$tutor_pet+$registro[21];
$coord_pibid=$coord_pibid+$registro[22];
$coord_ext_profmat=$coord_ext_profmat+$registro[23];
$org_local_reg=$org_local_reg+$registro[24];
$org_nac_inter=$org_nac_inter+$registro[25];
$coord_verao=$coord_verao+$registro[26];
$coord_sem_mat=$coord_sem_mat+$registro[27];
$banca_conc=$banca_conc+$registro[32];
$inicio_ultima="0/0/0";
$fim_ultima="0/0/0";
$licencas="";

if ($registro[28]!="nulo") $cargo_dir=$cargo_dir."--".$registro[28]." em ".$registro[1]."/".$registro[2];
if ($registro[29]!="nulo") $coord=$coord."--".$registro[29]." em ".$registro[1]."/".$registro[2];
if ($registro[30]!="nulo") $comis_mat=$comis_mat."--".$registro[30]." em ".$registro[1]."/".$registro[2];
if ($registro[31]!="nulo") $repr_cons=$repr_cons."--".$registro[31]." em ".$registro[1]."/".$registro[2];

if (($registro[33]!=$inicio_ultima) and ($registro[34]!=$fim_ultima))  $licencas=$licencas." -- de ".$registro[33]." a ".$registro[34]."--";
$inicio_ultima=$registro[33];
$fim_ultima=$registro[34];
}
// escreve formulario/relatorio
?>
<html>
<header>
<link type="text/css" rel="stylesheet" href="../../global/grafic.css">
<meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
</header>
<body>
<table class=big>
   <form method="POST" name="formu" action="formulario1.php">
      <tr>
        <td class=header align=center colspan=2>
        <h1>Informa&ccedil;&otilde;es para prioriza&ccedil;&atilde;o de licen&ccedil;as do MAT/UnB</h1>
        </td>
      </tr>
     <tr>    
        <td align=center><b> Informa&ccedil;&otilde;es sobre o per&iacute;odo: de <?php   echo $semestre_inicio."/".$ano_inicio;?> a <?php   echo $semestre_fim."/".$ano_fim;?> </b> </td></tr>
        <td align=center><b> &Uacute;ltimas licen&ccedil;as: <?php echo $licencas;?></b> </td></tr>
        <tr><td align=center>
	<table border>
	<tr><td colspan="2" align=center><b>Atividades de ensino/orienta&ccedil;&atilde;o</b></td></tr>
	<tr><td>Carga did&aacute;tica (disciplinas regulares gradua&ccedil;&atilde;o/p&oacute;s-gradua&ccedil;&atilde;o exceto est&aacute;gios de pesquisa)</td><td><?php  echo $creditos;?></td></tr>
	<tr><td>Coordena&ccedil;&atilde;o de disciplina de servi&ccedil;o </td><td align=center> <?php  echo $coord_massa;?></td></tr>
	<tr><td>Orienta&ccedil;&atilde;o de monografia de especializa&ccedil;&atilde;o (do MAT/UnB)</td><td align=center> <?php   echo $monografia_esp_mat;?></td></tr>
	<tr><td>Ministrante/orienta&ccedil;&atilde;o em projeto de PROFMAT/Especializa&ccedil;&atilde;o</td><td align=center><?php   echo $esp_profmat;?></td></tr>
	</table>
	</td></tr>
	<tr><td align=center>
	<table border>
	<tr><td colspan="2" align=center><b>Atividades de pesquisa</b></td></tr>
	<tr><td>Publica&ccedil;&atilde;o de livro </td><td align=center> <?php   echo $pub_livro;?></td></tr>
	<tr><td>Publica&ccedil;&atilde;o de artigo de pesquisa em revista arbitrada </td><td align=center> <?php   echo $pub_art_arb;?></td></tr>
	<tr><td>Publica&ccedil;&atilde;o de cap&iacute;tulo de livro </td><td align=center> <?php   echo $pub_cap_livro;?></td></tr>
	<tr><td>Publica&ccedil;&atilde;o em anais de congressos/artigo de divulga&ccedil;&atilde;o </td><td align=center> <?php   echo $pub_res_an_div;?></td></tr>
	<tr><td>Apresenta&ccedil;&atilde;o de trabalho oral em evento </td><td align=center> <?php   echo $apr_oral_evento;?></td></tr>
	<tr><td>Apresenta&ccedil;&atilde;o de poster em evento </td><td align=center><?php   echo $apr_poster_evento;?></td></tr>
	<tr><td>Coordena&ccedil;&atilde;o de projeto (n&atilde;o individual) com financiamento </td><td align=center><?php   echo $coord_proj_fin;?></td></tr>
	</table>
	</td></tr>
	<tr><td align=center>
	<table border>
	<tr><td colspan="2" align=center><b>Atividades de p&oacute;s-gradua&ccedil;&atilde;o</b></td></tr>
	<tr><td>Orienta&ccedil;&atilde;o de mestrado</td><td><?php  echo $creditos_pesq_mestrado;?></td></tr>
	<tr><td>Orienta&ccedil;&atilde;o de doutorado</td><td><?php  echo $creditos_pesq_doutorado;?></td></tr>
	<tr><td>Banca de mestrado/doutorado </td><td align=center><?php   echo $banca_mes_dou;?></td></tr>
	<tr><td>Exame de qualifica&ccedil;&atilde;o ao doutorado </td><td align=center> <?php  echo $exame_qualif_dou;?></td></tr>
	<tr><td>Exame de qualifica&ccedil;&atilde;o ao mestrado (do MAT/UnB) </td><td align=center> <?php echo $exame_qualif_mest;?></td></tr>
	<tr><td>Exame de L&iacute;nguas (do MAT/UnB) </td><td align=center> <?php echo $exame_linguas;?></td></tr>
	</table>
	</td></tr>
	<tr><td align=center>
	<table border>
	<tr><td colspan="2" align="center"><b>Atividades de extens&atilde;o</b></td></tr>
	<tr><td>Orienta&ccedil;&atilde;o de alunos de PIBIC, PIBID, PEAC ou PET </td><td align=center> <?php   echo $orient_pibs_pet;?></td></tr>
	<tr><td>Tutoria do PET </td><td align=center> <?php   echo $tutor_pet;?></td></tr>
	<tr><td>Coordena&ccedil;&atilde;o PIBID, PEAC </td><td align=center> <?php   echo $coord_pibid;?></td></tr>
	<tr><td>Coordena&ccedil;&atilde;o de projeto de extens&atilde;o (que n&atilde;o seja PEAC)</td><td align=center> <?php   echo $coord_ext_profmat;?></td></tr>
	<tr><td>Organiza&ccedil;&atilde;o de evento local/regional </td><td align=center><?php   echo $org_local_reg;?></td></tr>
	<tr><td>Organiza&ccedil;&atilde;o de evento nacional/internacional </td><td align=center><?php   echo $org_nac_inter;?></td></tr>
	<tr><td>Coordena&ccedil;&atilde;o da Escola de Ver&atilde;o </td><td align=center> <?php   echo $coord_verao;?></td></tr>
	<tr><td>Coordena&ccedil;&atilde;o da Semana de Matem&aacute;tica </td><td align=center> <?php   echo $coord_sem_mat;?></td></tr>
	</table>
	</td></tr>
	<tr><td align=center>
	<table border>
	<tr><td colspan="2" align="center"><b>Atividades administrativas</b></td></tr>
	<tr><td>Cargo de dire&ccedil;&atilde;o </td><td> <?php   echo $cargo_dir;?></td></tr>
	<tr><td>Cargo de coordena&ccedil;&atilde;o </td><td> <?php   echo $coord;?></td></tr>
	<tr><td>Participa&ccedil;&atilde;o em Comiss&otilde;es do MAT </td><td> <?php   echo $comis_mat;?></td></tr>
	<tr><td>Representa&ccedil;&atilde;o em conselhos e c&acirc;maras</td><td> <?php   echo $repr_cons;?>
</td></tr>
	<tr><td>Banca de concurso </td><td align=center> <?php   echo $banca_conc;?></td></tr>
	</table>
	</td></tr>
	<tr><td align=center><input type=submit name='relatorio' value="Confirmar"></td></tr>
	<input type=hidden name='semestre' value="<?php echo $semestre;?>">
	<input type=hidden name='ano' value="<?php echo $ano;?>">
	<input type=hidden name='usuario' value="<?php echo $usuario;?>">

</form>
</table>
</body>
</html>

<?php
//pg_close($com);
//}
?>
