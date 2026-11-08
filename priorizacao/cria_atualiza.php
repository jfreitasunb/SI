<?php
require_once(dirname(__FILE__)."/autentica.php");
//function cria_atulaiza($usuario,$semestre,$ano)
//{
//if (($teste1!=0) and ($teste3==0) and ($teste4==0))  //------------------------------------- "escolheu fazer atualizar/inserir semestre";
//{
//$usuario=$_POST['usuario'];
//$semestre=$_POST['semestre'];
//$ano=$_POST['ano'];

$data_de_hoje=date("Y-m-d");
$ano_atual=date("Y");

$query_pesq_mestrado=db_query("select sum(creditos) as creditos from oferta_escolha_creditos_est_pesq_pos where coduser=? and semestre=? and ano=? and orientando in (select coduser from student where formation='mestrado' and depart_date1<=?)", array($usuario,$semestre,$ano,$data_de_hoje), $con);
$num_mestrado=$query_pesq_mestrado->fetch();
$query_pesq_doutorado=db_query("select sum(creditos) as creditos from oferta_escolha_creditos_est_pesq_pos where coduser=? and semestre=? and ano=? and orientando in (select coduser from student where formation='doutorado' and depart_date1<=?)", array($usuario,$semestre,$ano,$data_de_hoje), $con);
$num_doutorado=$query_pesq_doutorado->fetch();

$query_creditos_grad=db_query("select sum(creditos) as creditos from oferta_escolha_creditos where coduser=? and semestre=? and ano=?", array($usuario,$semestre,$ano), $con);
$num_creditos_grad=$query_creditos_grad->fetch();


$query_creditos_pos=db_query("select sum(creditos) as creditos from oferta_escolha_creditos_pos where coduser=? and semestre=? and ano=?", array($usuario,$semestre,$ano), $con);
$num_creditos_pos=$query_creditos_pos->fetch();

if (isset($num_mestrado['creditos'])) $creditos_pesq_mestrado=$num_mestrado['creditos'];else $creditos_pesq_mestrado=0;
if (isset($num_doutorado['creditos'])) $creditos_pesq_doutorado=$num_doutorado['creditos']; else $creditos_pesq_doutorado=0;

if (count($num_creditos_pos)!=0) $creditos_pos=$num_creditos_pos['creditos']; else $creditos_pos=0; 
if (count($num_creditos_grad)!=0) $creditos_grad=$num_creditos_grad['creditos']; else $creditos_grad=0;

$creditos=$creditos_pos+$creditos_grad;



$query_historico_MAT=db_query("select * from prio_licencas_historico_MAT where coduser=? and semestre=? and ano=?", array($usuario,$semestre,$ano), $con);

//coduser|semestre|ano|creditos|creditos_pesq_mestrado|creditos_pesq_doutorado|monografia_esp_mat|esp_profmat|pub_livro|pub_art_arb|pub_cap_livro|pub_res_an_div|apr_oral_evento|apr_poster_evento|
//coord_proj_fin|banca_mes_dou| exame_qualif_dou| exame_qualif_mest(0/1)|exame_linguas(0/1)|orient_pibs_pet|tutor_pet(0/1)|coord_pibid(0/1)|coord_ext_profmat|org_local_reg|org_nac_inter|
//coord_verao(0/1)|coord_sem_mat(0/1)|cargo_dir(opcoes)|coord(opcoes)|comis_mat(opcoes)|repr_cons(opcoes)|banca_conc | inicio_ultima | fim_ultima

if ($query_historico_MAT->rowCount()==0) $historico=array("creditos" => $creditos,"coord_massa" => 0,"creditos_pesq_mestrado" => $creditos_pesq_mestrado, "creditos_pesq_doutorado" => $creditos_pesq_doutorado, "monografia_esp_mat" => 0, "esp_profmat" => 0, "pub_livro" => 0, "pub_art_arb" => 0, "pub_cap_livro" => 0, "pub_res_an_div" => 0, "apr_oral_evento" => 0, "apr_poster_evento" => 0, "coord_proj_fin" => 0, "banca_mes_dou" => 0, "exame_qualif_dou" => 0, "exame_qualif_mest" => 0, "exame_linguas" => 0, "orient_pibs_pet" => 0, "tutor_pet" => 0, "coord_pibid" => 0, "coord_ext_profmat" => 0, "org_local_reg" => 0, "org_nac_inter" => 0, "coord_verao" => 0, "coord_sem_mat" => 0, "cargo_dir" => "nulo", "coord" => "nulo", "comis_mat" => "nulo", "repr_cons" => "nulo", "banca_conc" => 0, "inicio_ultima" => "0/0/0", "fim_ultima" => "0/0/0"); else $historico=$query_historico_MAT->fetch();

$data_inicio_ultima=explode("/",$historico['inicio_ultima']);
$data_fim_ultima=explode("/",$historico['fim_ultima']);

?>
<html>
<header>
 <script language=javascript>
function verif_touche(e)
{
 if(e.keyCode)touche = e.keyCode;
    else touche = e.which;
 if((touche>=48 && touche <= 57)||touche==9 || touche==8 || touche==46 )return true;
   else return false;
}
    </script>

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
        <td align=center><b> Semestre : <?php   echo $semestre."/".$ano;?> </b> </td></tr>
        <td align=center><b> Per&iacute;odo da &uacute;ltima licen&ccedil;a: de <select name='dia_inicio'>
										<option value=0 <?php if ($data_inicio_ultima[0]==0) echo "selected";?>>--</option>
										<?php 
										for ($i=1;$i<32;$i++) 
											{if ($data_inicio_ultima[0]==$i) $selected="selected"; else $selected=""; 
											echo "<option value=\"".$i."\" ".$selected.">".$i."</option>";} 
										?>
										</select>/
										<select name='mes_inicio'>
										<option value=0 <?php if ($data_inicio_ultima[1]==0) echo "selected";?>>--</option>
										<?php 
										for ($j=1;$j<13;$j++) 
											{if ($data_inicio_ultima[1]==$j) $selected="selected"; else $selected=""; 
											echo "<option value=\"".$j."\" ".$selected.">".$j."</option>";} 
										?>
										</select>/
										<select name='ano_inicio'>
										<option value=0 <?php if ($data_inicio_ultima[2]==0) echo "selected";?>>--</option>
										<?php 
										for ($k=$ano_atual-10;$k<$ano_atual+1;$k++) 
											{if ($data_inicio_ultima[2]==$k) $selected="selected"; else $selected=""; 
											echo "<option value=\"".$k."\" ".$selected.">".$k."</option>";} 
										?>
										</select> a 
										<select name='dia_fim'>
										<option value=0 <?php if ($data_fim_ultima[0]==0) echo "selected";?>>--</option>
										<?php 
										for ($if=1;$if<32;$if++) 
											{if ($data_inicio_ultima[0]==$if) $selected="selected"; else $selected=""; 
											echo "<option value=\"".$if."\" ".$selected.">".$if."</option>";} 
										?>
										</select>/
										<select name='mes_fim'>
										<option value=0 <?php if ($data_fim_ultima[1]==0) echo "selected";?>>--</option>
										<?php 
										for ($jf=1;$jf<13;$jf++) 
											{if ($data_fim_ultima[1]==$jf) $selected="selected"; else $selected=""; 
											echo "<option value=\"".$jf."\" ".$selected.">".$jf."</option>";} 
										?>
										</select>/
										<select name='ano_fim'>
										<option value=0 <?php if ($data_fim_ultima[2]==0) echo "selected";?>>--</option>
										<?php 
										for ($kf=$ano_atual-10;$kf<$ano_atual+1;$kf++) 
											{if ($data_fim_ultima[2]==$kf) $selected="selected"; else $selected=""; 
											echo "<option value=\"".$kf."\" ".$selected.">".$kf."</option>";} 
										?>
										</select>
</b> </td></tr>
	</tr>

        <tr><td align=center>
	<table border>
	<tr><td colspan="2" align=center><b>Atividades de ensino/orienta&ccedil;&atilde;o</b></td></tr>
	<tr><td>Carga did&aacute;tica (disciplinas regulares gradua&ccedil;&atilde;o/p&oacute;s-gradua&ccedil;&atilde;o exceto est&aacute;gios de pesquisa)</td><td><input type=text name='creditos' value="<?php  echo h($historico['creditos']);?>"  maxlength=3 size=2 onkeypress="return verif_touche(event);"></td></tr>
	<tr><td>Coordena&ccedil;&atilde;o de disciplina de servi&ccedil;o </td><td align=center> <input type=text name='coord_massa' value="<?php  echo h($historico['coord_massa']);?>"  maxlength=3 size=2 onkeypress="return verif_touche(event);"></td></tr>
	<tr><td>Orienta&ccedil;&atilde;o de monografia de especializa&ccedil;&atilde;o (do MAT/UnB)</td><td align=center> <input type=text name='monografia_esp_mat' value="<?php   echo h($historico['monografia_esp_mat']);?>" maxlength=3 size=2 onkeypress="return verif_touche(event);"></td></tr>
	<tr><td>Ministrante/orienta&ccedil;&atilde;o em projeto de PROFMAT/Especializa&ccedil;&atilde;o</td><td align=center><input type=text name='esp_profmat' value="<?php   echo h($historico['esp_profmat']);?>" maxlength=3 size=2 onkeypress="return verif_touche(event);"></td></tr>
	</table>
	</td></tr>
	<tr><td align=center>
	<table border>
	<tr><td colspan="2" align=center><b>Atividades de pesquisa</b></td></tr>
	<tr><td>Publica&ccedil;&atilde;o de livro </td><td align=center> <input type=text name='pub_livro' value="<?php   echo h($historico['pub_livro']);?>" maxlength=3 size=2 onkeypress="return verif_touche(event);"></td></tr>
	<tr><td>Publica&ccedil;&atilde;o de artigo de pesquisa em revista arbitrada </td><td align=center> <input type=text name='pub_art_arb' value="<?php   echo h($historico['pub_art_arb']);?>"  maxlength=3 size=2 onkeypress="return verif_touche(event);"></td></tr>
	<tr><td>Publica&ccedil;&atilde;o de cap&iacute;tulo de livro </td><td align=center> <input type=text name='pub_cap_livro' value="<?php   echo h($historico['pub_cap_livro']);?>"  maxlength=3 size=2 onkeypress="return verif_touche(event);"></td></tr>
	<tr><td>Publica&ccedil;&atilde;o em anais de congressos/artigo de divulga&ccedil;&atilde;o </td><td align=center> <input type=text name='pub_res_an_div' value="<?php   echo h($historico['pub_res_an_div']);?>"  maxlength=3 size=2 onkeypress="return verif_touche(event);"></td></tr>
	<tr><td>Apresenta&ccedil;&atilde;o de trabalho oral em evento </td><td align=center> <input type=text name='apr_oral_evento' value="<?php   echo h($historico['apr_oral_evento']);?>"  maxlength=3 size=2 onkeypress="return verif_touche(event);"></td></tr>
	<tr><td>Apresenta&ccedil;&atilde;o de poster em evento </td><td align=center> <input type=text name='apr_poster_evento' value="<?php   echo h($historico['apr_poster_evento']);?>"  maxlength=3 size=2 onkeypress="return verif_touche(event);"></td></tr>
	<tr><td>Coordena&ccedil;&atilde;o de projeto (n&atilde;o individual) com financiamento </td><td align=center> <input type=text name='coord_proj_fin' value="<?php   echo h($historico['coord_proj_fin']);?>"  maxlength=3 size=2 onkeypress="return verif_touche(event);"></td></tr>
	</table>
	</td></tr>
	<tr><td align=center>
	<table border>
	<tr><td colspan="2" align=center><b>Atividades de p&oacute;s-gradua&ccedil;&atilde;o</b></td></tr>
	<tr><td>Orienta&ccedil;&atilde;o de mestrado</td><td><input type=text name='creditos_pesq_mestrado' value="<?php  echo h($historico['creditos_pesq_mestrado']);?>" maxlength=3 size=2 onkeypress="return verif_touche(event);"></td></tr>
	<tr><td>Orienta&ccedil;&atilde;o de doutorado</td><td><input type=text name='creditos_pesq_doutorado' value="<?php  echo h($historico['creditos_pesq_doutorado']);?>" maxlength=3 size=2 onkeypress="return verif_touche(event);"></td></tr>
	<tr><td>Banca de mestrado/doutorado </td><td align=center> <input type=text name='banca_mes_dou' value="<?php   echo h($historico['banca_mes_dou']);?>" maxlength=3 size=2 onkeypress="return verif_touche(event);"></td></tr>
	<tr><td>Exame de qualifica&ccedil;&atilde;o ao doutorado </td><td align=center> <input type=text name='exame_qualif_dou' value="<?php  echo h($historico['exame_qualif_dou']);?>"  maxlength=3 size=2 onkeypress="return verif_touche(event);"></td></tr>
	<tr><td>Exame de qualifica&ccedil;&atilde;o ao mestrado (do MAT/UnB) </td><td align=center> <select name='exame_qualif_mest'>
									<option value=1 <?php if ($historico['exame_qualif_mest']==1) echo "selected";?>> sim </option>
									<option value=0 <?php if ($historico['exame_qualif_mest']==0) echo "selected";?>> n&atilde;o </option>
									</select></td></tr>
	<tr><td>Exame de L&iacute;nguas (do MAT/UnB) </td><td align=center> <select name='exame_linguas'>
									<option value='1' <?php if ($historico['exame_linguas']==1) echo "selected";?>> sim </option>
									<option value='0' <?php if ($historico['exame_linguas']==0) echo "selected";?>> n&atilde;o </option>
									</select></td></tr>
	</table>
	</td></tr>
	<tr><td align=center>
	<table border>
	<tr><td colspan="2" align="center"><b>Atividades de extens&atilde;o</b></td></tr>
	<tr><td>Orienta&ccedil;&atilde;o de alunos de PIBIC, PIBID, PEAC ou PET </td><td align=center> <input type=text name='orient_pibs_pet' value="<?php   echo h($historico['orient_pibs_pet']);?>"  maxlength=3 size=2 onkeypress="return verif_touche(event);"></td></tr>
	<tr><td>Tutoria do PET </td><td align=center> <select name='tutor_pet'>
									<option value='1' <?php if ($historico['tutor_pet']==1) echo "selected";?>>sim</option>
									<option value='0' <?php if ($historico['tutor_pet']==0) echo "selected";?>>n&atilde;o</option>
									</select></td></tr>
	<tr><td>Coordena&ccedil;&atilde;o PIBID, PEAC </td><td align=center> <select name='coord_pibid'>
									<option value='1' <?php if ($historico['coord_pibid']==1) echo "selected";?>>sim</option>
									<option value='0' <?php if ($historico['coord_pibid']==0) echo "selected";?>>n&atilde;o</option>
									</select></td></tr>
	<tr><td>Coordena&ccedil;&atilde;o de projeto de extens&atilde;o (que n&atilde;o seja PEAC)</td><td align=center> <input type=text name='coord_ext_profmat' value="<?php   echo h($historico['coord_ext_profmat']);?>"  maxlength=3 size=2 onkeypress="return verif_touche(event);"></td></tr>
	<tr><td>Organiza&ccedil;&atilde;o de evento local/regional </td><td align=center> <input type=text name='org_local_reg' value="<?php   echo h($historico['org_local_reg']);?>"  maxlength=3 size=2 onkeypress="return verif_touche(event);"></td></tr>
	<tr><td>Organiza&ccedil;&atilde;o de evento nacional/internacional </td><td align=center> <input type=text name='org_nac_inter' value="<?php   echo h($historico['org_nac_inter']);?>"  maxlength=3 size=2 onkeypress="return verif_touche(event);"></td></tr>
	<tr><td>Coordena&ccedil;&atilde;o da Escola de Ver&atilde;o </td><td align=center> <select name='coord_verao'>
									<option value='1' <?php if ($historico['coord_verao']==1) echo "selected";?>>sim</option>
									<option value='0' <?php if ($historico['coord_verao']==0) echo "selected";?>>n&atilde;o</option>
									</select></td></tr>
	<tr><td>Coordena&ccedil;&atilde;o da Semana de Matem&aacute;tica </td><td align=center> <select name='coord_sem_mat'>
									<option value='1' <?php if ($historico['coord_sem_mat']==1) echo "selected";?>>sim</option>
									<option value='0' <?php if ($historico['coord_sem_mat']==0) echo "selected";?>>n&atilde;o</option>
									</select></td></tr>
	</table>
	</td></tr>
	<tr><td align=center>
	<table border>
	<tr><td colspan="2" align="center"><b>Atividades administrativas</b></td></tr>
	<tr><td>Cargo de dire&ccedil;&atilde;o </td><td> <select name='cargo_dir'>
									<option value='nulo' <?php if ($historico['cargo_dir']=="nulo") echo "selected";?>> ---nenhum---</option>
									<option value='chefia' <?php if ($historico['cargo_dir']=="chefia") echo "selected";?>>Chefia</option>
									<option value='subchefia' <?php if ($historico['cargo_dir']=="subchefia") echo "selected";?>>Subchefia</option>
									<option value='dir_unidade' <?php if ($historico['cargo_dir']=="dir_unidade") echo "selected";?>>Dire&ccedil;&atilde;o de unidade</option>
									<option value='vice_dir_unidade' <?php if ($historico['cargo_dir']=="vice_dir_unidade") echo "selected";?>>Vice-dire&ccedil;&atilde;o de unidade</option>
									<option value='decano' <?php if ($historico['cargo_dir']=="decano") echo "selected";?>>Decanato</option>
									<option value='dir_decanato' <?php if ($historico['cargo_dir']=="dir_decanato") echo "selected";?>>Diretoria vinculada a um Decanato</option>
									<option value='reitor' <?php if ($historico['cargo_dir']=="reitor") echo "selected";?>>Reitor</option>
									<option value='vice_reitor' <?php if ($historico['cargo_dir']=="vice_reitor") echo "selected";?>>Vice-reitor</option>
									</select></td></tr>
	<tr><td>Cargo de coordena&ccedil;&atilde;o </td><td> <select name='coord'>
									<option value='nulo' <?php if ($historico['coord']=="nulo") echo "selected";?>> ---nenhum---</option>
									<option value='coord_pgrad' <?php if ($historico['coord']=="coord_pgrad") echo "selected";?>>Coordena&ccedil;&atilde;o de p&oacute;s-gradua&ccedil;&atilde;o</option>
									<option value='coord_profmat' <?php if ($historico['coord']=="coord_profmat") echo "selected";?>>Coordena&ccedil;&atilde;o do PROFMAT</option>
									<option value='coord_grad' <?php if ($historico['coord']=="coord_grad") echo "selected";?>>Coordena&ccedil;&atilde;o de gradua&ccedil;&atilde;o</option>
									<option value='coord_inf' <?php if ($historico['coord']=="coord_inf") echo "selected";?>>Coordena&ccedil;&atilde;o de inform&aacute;tica</option>
									</select></td></tr>
	<tr><td>Participa&ccedil;&atilde;o em Comiss&otilde;es do MAT </td><td> <select name='comis_mat'>
									<option value='nulo' <?php if ($historico['comis_mat']=="nulo") echo "selected";?>> ---nenhuma---</option>
									<option value='comis_pgrad' <?php if ($historico['comis_mat']=="comis_pgrad") echo "selected";?>>Comiss&atilde;o de p&oacute;s-gradua&ccedil;&atilde;o</option>
									<option value='comis_grad' <?php if ($historico['comis_mat']=="comis_grad") echo "selected";?>>Comiss&atilde;o de gradua&ccedil;&atilde;o</option>
									<option value='comis_inf' <?php if ($historico['comis_mat']=="comis_inf") echo "selected";?>>Comiss&atilde;o de inform&aacute;tica</option>
									</select></td></tr>
	<tr><td>Representa&ccedil;&atilde;o em conselhos e c&acirc;maras</td><td> <select name='repr_cons'>
										  <option value='nulo' <?php if ($historico['repr_cons']=="nulo") echo "selected";?>> ---nenhum---</option> 
										<?php
										//usar tabela com: descricao| sigla. Ok.
										$query_conselhos=db_query("select * from estudos_conselhos_camaras order by descricao", array(), $con);

										while($registro=$query_conselhos->fetch(PDO::FETCH_NUM))
											{
											if ($registro[1]==$historico['repr_cons']) $selected="selected"; else $selected="";
											echo "<option value=\"".h($registro[1])."\" ".$selected.">".h($registro[0])."</option>";
											}
											?>
										</select></td></tr>
	<tr><td>Banca de concurso </td><td align=center> <input type=text name='banca_conc' value="<?php   echo h($historico['banca_conc']);?>"  maxlength=3 size=2 onkeypress="return verif_touche(event);"></td></tr>
	</table>
	</td></tr>
	<tr><td align=center><input type=submit name='salva_dados' value="Confirmar"></td></tr>
	<input type=hidden name='semestre' value="<?php echo $semestre;?>">
	<input type=hidden name='ano' value="<?php echo $ano;?>">
	<input type=hidden name='usuario' value="<?php echo $usuario;?>">

</form>
</table>
</body>
</html>
<?php  
$con = null;
//}
?>
