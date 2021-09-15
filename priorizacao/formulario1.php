<?php
//include("formulario11.php");
//include("relatorio.php");
//include("cria_atualiza.php");


$lang="pt_BR";
require("pgsql.php");

if(isset($_POST['salva_dados']) and !isset($_POST['relatorio']) and !isset($_POST['selecao1']))
{
$usuario=$_POST['usuario'];
$data_de_hoje=date("Y-m-d");
$semestre=$_POST['semestre'];
$ano=$_POST['ano'];

$query_historico_MAT=pg_query("select * from prio_licencas_historico_MAT where coduser='".$usuario."' and semestre='".$semestre."' and ano='".$ano."'");
$num_query=pg_num_rows($query_historico_MAT);


$inicio_ultima=$_POST['dia_inicio']."/".$_POST['mes_inicio']."/".$_POST['ano_inicio'];
$fim_ultima=$_POST['dia_fim']."/".$_POST['mes_fim']."/".$_POST['ano_fim'];

if ($num_query==0)
	{
	$query_grava="insert into prio_licencas_historico_MAT values('".$usuario."','".$semestre."','".$ano."','".$_POST['creditos']."','".$_POST['coord_massa']."','".$_POST['creditos_pesq_mestrado']."','".$_POST['creditos_pesq_doutorado']."','".$_POST['monografia_esp_mat']."','".$_POST['esp_profmat']."','".$_POST['pub_livro']."','".$_POST['pub_art_arb']."','".$_POST['pub_cap_livro']."','".$_POST['pub_res_an_div']."','".$_POST['apr_oral_evento']."','".$_POST['apr_poster_evento']."','".$_POST['coord_proj_fin']."','".$_POST['banca_mes_dou']."','".$_POST['exame_qualif_dou']."','".$_POST['exame_qualif_mest']."','".$_POST['exame_linguas']."','".$_POST['orient_pibs_pet']."','".$_POST['tutor_pet']."','".$_POST['coord_pibid']."','".$_POST['coord_ext_profmat']."','".$_POST['org_local_reg']."','".$_POST['org_nac_inter']."','".$_POST['coord_verao']."','".$_POST['coord_sem_mat']."','".$_POST['cargo_dir']."','".$_POST['coord']."','".$_POST['comis_mat']."','".$_POST['repr_cons']."','".$_POST['banca_conc']."','".$inicio_ultima."','".$fim_ultima."')";
	}
else
	{
	$query_grava="update prio_licencas_historico_MAT set creditos='".$_POST['creditos']."',coord_massa='".$_POST['coord_massa']."',creditos_pesq_mestrado='".$_POST['creditos_pesq_mestrado']."',creditos_pesq_doutorado='".$_POST['creditos_pesq_doutorado']."',monografia_esp_mat='".$_POST['monografia_esp_mat']."',esp_profmat='".$_POST['esp_profmat']."',pub_livro='".$_POST['pub_livro']."',pub_art_arb='".$_POST['pub_art_arb']."',pub_cap_livro='".$_POST['pub_cap_livro']."',pub_res_an_div='".$_POST['pub_res_an_div']."',apr_oral_evento='".$_POST['apr_oral_evento']."', apr_poster_evento='".$_POST['apr_poster_evento']."', coord_proj_fin='".$_POST['coord_proj_fin']."',banca_mes_dou='".$_POST['banca_mes_dou']."',exame_qualif_dou='".$_POST['exame_qualif_dou']."',exame_qualif_mest='".$_POST['exame_qualif_mest']."',exame_linguas='".$_POST['exame_linguas']."',orient_pibs_pet='".$_POST['orient_pibs_pet']."',tutor_pet='".$_POST['tutor_pet']."',coord_pibid='".$_POST['coord_pibid']."',coord_ext_profmat='".$_POST['coord_ext_profmat']."',org_local_reg='".$_POST['org_local_reg']."',org_nac_inter='".$_POST['org_nac_inter']."',coord_verao='".$_POST['coord_verao']."',coord_sem_mat='".$_POST['coord_sem_mat']."',cargo_dir='".$_POST['cargo_dir']."',coord='".$_POST['coord']."',comis_mat='".$_POST['comis_mat']."',repr_cons='".$_POST['repr_cons']."',banca_conc='".$_POST['banca_conc']."', inicio_ultima='".$inicio_ultima."', fim_ultima='".$fim_ultima."' where coduser='".$usuario."' and semestre='".$semestre."' and ano='".$ano."'";
	}
//echo $query_grava;
$query_res=pg_query($query_grava) or die("problema de conexao com o banco");

}

if (!isset($_POST['selecao1']))
{
$ano=date("Y");
//----------------------------  Inserir preferencias
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
     <tr><table><tr><td align=center>Escolha uma opção: <b></td></tr> 
     <tr><td align=center><b> Um semestre/ano para inclus&atilde;o/atualiza&ccedil;&atilde;o de atividades: </b><select name='semestre'>
														  <option value=0 selected>--</option> 
														  <option value=1>1</option> 
														  <option value=2>2</option>
														</select>
														<select name='ano'>
														  <option value=0 selected>--</option> 
														<?php 
														for ($i=$ano;$i>$ano-8;$i=$i-1)
															{
															echo "<option value=\"".$i."\">".$i."</option>";
															}
														?>
														</select></td></tr>
     <tr><td align=center><b> Um per&iacute;odo para emiss&atilde;0 de relat&oacute;rio: </b> de <select name='semestre_inicio'>
														  <option value=0 selected>--</option> 
														  <option value=1>1</option> 
														  <option value=2>2</option>
														</select>
														<select name='ano_inicio'>
														  <option value=0 selected>--</option> 
														<?php 
														for ($i=$ano;$i>$ano-8;$i=$i-1)
															{
															echo "<option value=\"".$i."\">".$i."</option>";
															}
														?>
														</select> a 
														<select name='semestre_fim'>
														  <option value=0 selected>--</option> 
														  <option value=1>1</option> 
														  <option value=2>2</option>
														</select>
														<select name='ano_fim'>
														  <option value=0 selected>--</option> 
														<?php 
														for ($i=$ano;$i>$ano-8;$i=$i-1)
															{
															echo "<option value=\"".$i."\">".$i."</option>";
															}
														?>
														</select></td></tr>
	<tr><td align=center><input type=submit name='selecao1' value='Confirmar'></td></tr>
	<tr><td align=center><input type=hidden name='usuario' value="<?php echo $usuario;?>"></td></tr>
	</table>
	</form>
	</table>
	</body>
	</html>
<?php
} // fim selecao1

if (isset($_POST['selecao1']))
{
$semestre=$_POST['semestre'];
$ano=$_POST['ano'];
$usuario=$_POST['usuario'];

$semestre_inicio=$_POST['semestre_inicio'];
$semestre_fim=$_POST['semestre_fim'];
$ano_inicio=$_POST['ano_inicio'];
$ano_fim=$_POST['ano_fim'];

$teste1=$ano*$semestre;
$teste2=$semestre_inicio*$semestre_fim*$ano_inicio*$ano_fim;
$teste3=$semestre_inicio*$ano_inicio;
$teste4=$semestre_fim*$ano_fim;

if ((($teste1==0) and ($teste3==0) and ($teste4==0)) or (($teste1!=0) and (($teste3!=0) or ($teste4!=0)))) // --------------------------------------Fazer outra seleção
{
include("formulario11.php");
}


if (($teste1!=0) and ($teste3==0) and ($teste4==0))  //------------------------------------- "escolheu fazer atualizar/inserir semestre";
{
include("cria_atualiza.php");
}


if (($teste1==0) and (($teste3!=0) or ($teste4!=0))) //------------------------------------------"escolheu relatorio no periodo";
{
include("relatorio.php");
}
}
//pg_close($con);
?>
