<?PHP

include("head_oferta.php");
/* CORRIGE LISTA DE OFERTAS DO SEMESTRE/ANO:
1- entrar com semestre e ano;
2- mostrar a lista ordenada por disciplina: 
	deve ser possível selecionar uma discilina/turma para trocar o professor ou para eliminar a disciplina
3- alterar banco
4- voltar para o item 2 até que seja teclado "sair"
*/
// funcoes novas em 21/04/2014:



function corrige_codigo_turmas_magistral($semestre,$ano) 
{
// roda no fim da rotina que roda a lista;
// no final da elaboração da lista, a tabela é corrigida par poder ser impressa e apresentada ao colegiado:
$seleciona_magistral=db_query("select codigo from  oferta_disciplinas_magistral", array()) or die("problema 02 em muda_horarios_turmas_magistral");  

// para cada linha de $seleciona_magistral, muda o código da disciplina teoria:
while($turma=db_fetch_row($seleciona_magistral))
{

list($muda_codigo, $muda_codigo__p) = array("update oferta_lista_de_ofertas_nova set codigo=? where codigo=?", array($turma[0], $turma[0].'001'));

$query_muda_codigo=db_query($muda_codigo, $muda_codigo__p) or die("problema 05 em muda_horarios_turmas_magistral");

} //fim do do while
} // fim da funcao corrige_codigo_turmas_magistral
//

function creditos_magistral($codigo,$turma)
{
//$creditos=array("teoria"=>0,"exercicios"=>0);
$pega_horarios=db_query("select turmas from oferta_grupos_magistral_teoria where (grupo,horario) in (select grupo,horario from oferta_grupos_magistral_teoria where turmas=? and codigo_1=?)", array($turma, $codigo));
$turmas=db_num_rows($pega_horarios); 
$pega_creditos=db_query("select teoria,exercicios from oferta_disciplinas_magistral where codigo in (select codigo from  oferta_grupos_magistral_teoria where codigo_1=?) or codigo =?", array($codigo, $codigo));

$creditos=db_fetch_array($pega_creditos);
if (!$creditos) $creditos=array('teoria'=>0, 'exercicios'=>0);
// PHP 8: divisao por zero e erro fatal (no PHP 7 era aviso e o resultado ficava vazio).
$creditos['teoria']=($turmas > 0) ? $creditos['teoria']/$turmas : 0;
//echo $codigo."-".$turma."-".$creditos['teoria']."-".$creditos['exercicios']."-/-";
return $creditos;
} 

// aloca professores nas turmas de um determinado grupo de aulas magistrais/teoria:
function aloca_professor_no_grupo_teoria_da_turma_dada($codigo,$professor,$turma,$semestre,$ano)
{
//$codigo_0=($codigo-1)/1000;
list($pega_turmas_horarios_grupo, $pega_turmas_horarios_grupo__p) = array("select turmas,horario from oferta_grupos_magistral_teoria where grupo in (select grupo from oferta_grupos_magistral_teoria where codigo_1=? and turmas=?)", array($codigo, $turma));
//echo $pega_turmas_horarios_grupo."---//---";
$query_pega_turmas_horarios_grupo=db_query($pega_turmas_horarios_grupo, $pega_turmas_horarios_grupo__p) or die ("problema 01 em aloca_professor_no_grupo_teoria_da_turma_dada");

while($horarios=db_fetch_row($query_pega_turmas_horarios_grupo))
{
list($update_oferta, $update_oferta__p) = array("update oferta_lista_de_ofertas_nova set professor=? where codigo=?  and  turma=? and semestre=? and ano=?", array($professor, $codigo, $horarios[0], $semestre, $ano));
//echo $update_oferta."--/--";
$res_oferta=db_query($update_oferta, $update_oferta__p) or die("problema 02 em aloca_professor_no_grupo_teoria_da_turma_dada");
}

}// fim function aloca_professor_no_grupo_teoria_da_turma_dada 


?>



<html>
  <header>
    <link type="text/css" rel="stylesheet" href="../../global/grafic.css">
<meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
  </header>

<?php 

if (!isset($_POST['registra']) and !isset($_POST['registra2']))
{
$query_acusa_lista=db_query("select * from oferta_acusa_lista where encaminhada='nova' order by ano desc,semestre desc", array());

?>
  <body>
      <table class=big>
   <form method="POST" name="formu" action="atualiza_lista_provisoria.php">
      <tr>
        <td class=header align=center colspan=2>
        <h1>Corre&ccedil;&atilde;o da Lista de Oferta de Disciplinas</h1>
        </td>
      </tr>

<tr><td>Escolha a lista:
        </select>
        <select name='lista'>
        <?php 
        while ($registro=db_fetch_row($query_acusa_lista))
        {
        ?>
        <option name='lista' value="<?php echo h($registro[0])."_".h($registro[1]);?>"> <?php  echo h($registro[0]);?> &ordm;/ <?php  echo h($registro[1]);?></option>
        <?php 
        }
        ?>
        </tr>
	<tr><td><b>Limpar a lista de aloca&ccedil;&atilde;o de professores? </b><b>sim (<input type=radio name="limpa_tabela" value="sim">)</b>  <b>N&atilde;o (<input type=radio name="limpa_tabela" value="nao" checked>)<b></td></tr>
        <td align=center>
        <input type=submit name='registra' value="Confirmar op&ccedil;&otilde;es">
        </td>
        </tr>
        </table>
        </form>
        </BODY>
<?php 
}

if (isset($_POST['registra']) and !isset($_POST['registra2']))
{

$lista=explode("_",$_POST['lista']);
$semestre=$lista[0];
$ano=isset($lista[1]) ? $lista[1] : '';
if (!ctype_digit((string)$semestre) || !ctype_digit((string)$ano)) {
	die(error("Semestre/ano invalido."));
}
//$tabela="oferta_lista_de_ofertas_".$lista[0]."_".$lista[1];
$tabela="oferta_lista_de_ofertas_nova";


if(isset($_POST['limpa_tabela']) && $_POST['limpa_tabela']=="sim") $query_limpa_oferta_semestre=db_query("update ".$tabela." set professor='0' where semestre=? and ano=?", array($semestre, $ano));

// lista de disciplinas no esquema magistral:
$query_magistral=db_query("select * from oferta_disciplinas_magistral", array()); 
$magistral=array();
while($magistral_0=db_fetch_row($query_magistral))
	{
	$magistral[$magistral_0[0]]=array("teoria"=>$magistral_0[1],"exercicios"=>$magistral_0[2]);
	}
//print_r($magistral);
?>

  <body>
      <table class=big>
      <form method="POST" name="formu" action="atualiza_lista_provisoria.php">
         <tr>
        <td class=header align=center>
        <h1> Corre&ccedil;&atilde;o da Lista de Ofertas do <?php  echo h($semestre);?>&ordm;/ <?php  echo h($ano);?></h1>
        </td>
      </tr>
         <tr><td class=data align=center>
        <table border>
        <tr><td><b>Disciplina</b></td><td><b>C&oacute;digo</b></td><td><b>Turma</b></td><td><b>Vagas</b></td><td><b>Turno</b></td><td><b>Hor&aacute;rios</b></td><td><b>Salas</b></td><td><b>Reservas</b></td><td><b>Status</b></td><td><b>Professor</b></td><td><b>Carga</b></td><td><b>Substituir</b></td></tr>
        <tr></tr>

<?php 

//disciplina | codigo | turma | vagas |  turno  |  horarios   | salas | reserva |  status | professo | elimina | semestre | ano | magistral


//	$query_oferta="select m.nome as disciplina, lo.*, u.name||' '||u.firstname as nome_prof,creditos from ".$tabela." lo, disciplinas_mat m, users u where lo.codigo=m.codigo and u.coduser=lo.professor and lo.elimina='nao' and lo.semestre='".$semestre."' and lo.ano='".$ano."' order by disciplina,turma,magistral";
// correção feita EM 21/04/2014 PARA CONTEMPLAR AS TURMAS MAGISTRAIS:
	list($query_oferta, $query_oferta__p) = array("select m.nome as disciplina, lo.*, u.name||' '||u.firstname as nome_prof,creditos from ".$tabela." lo, disciplinas_mat m, users u where lo.codigo=m.codigo and u.coduser=lo.professor and lo.elimina='nao' and lo.semestre=? and lo.ano=?  union (select m.nome as disciplina, og.codigo_1,lo.turma,lo.vagas,lo.turno,lo.horarios,lo.salas,lo.reserva, lo.status,lo.professor,lo.elimina,lo.semestre,lo.ano,lo.magistral, u.name||' '||u.firstname as nome_prof,creditos from ".$tabela." lo, disciplinas_mat m, users u, oferta_grupos_magistral_teoria og where lo.codigo=og.codigo_1 and og.codigo=m.codigo and u.coduser=lo.professor and lo.elimina='nao' and lo.turma=og.turmas and lo.semestre=? and lo.ano=?) order by disciplina,turma,magistral", array($semestre, $ano, $semestre, $ano));
//echo $query_oferta;
	$oferta0=db_query($query_oferta, $query_oferta__p);
	$oferta=db_fetch_all($oferta0);
//disciplina | codigo | turma | vagas |  turno  |  horarios   | salas | reserva |  status | professor | nome_prof
        $cor_de_fundo="#FFFFFF";
	$codigo=0;
	$turma="";
	for($i=0;$i<count($oferta);$i++)
//        while ($registro=db_fetch_row($oferta))
	        {
		if(($oferta[$i]['codigo']!=$codigo) or ($oferta[$i]['turma']!=$turma)) // nova disciplina/turma
			{
	                if ($cor_de_fundo=="#FFFFFF") $cor_de_fundo="#D0D0D0"; else $cor_de_fundo="#FFFFFF";
			if($oferta[$i]['codigo']!=$codigo) $codigo=$oferta[$i]['codigo'];
			if($oferta[$i]['turma']!=$turma) $turma=$oferta[$i]['turma'];

//atualizado em 21/04/2014:
		if ($oferta[$i]['magistral']=="teoria") $disciplina=$oferta[$i]['disciplina']."-- Teoria"; 
		else {
		     if ($oferta[$i]['magistral']=="exercicios") $disciplina=$oferta[$i]['disciplina']."-- Exerc.";
		     else $disciplina=$oferta[$i]['disciplina'];
		     }

		$creditos0=creditos_magistral($oferta[$i]['codigo'],$oferta[$i]['turma']);
		if ($oferta[$i]['magistral']=="teoria") $creditos=$creditos0['teoria'];
		else {
		     if ($oferta[$i]['magistral']=="exercicios") $creditos=$creditos0['exercicios'];
		     else $creditos=$oferta[$i]['creditos'];
		     }


?>
				<tr bgcolor="<?php  echo $cor_de_fundo;?>">
                                <td><?php  echo h($disciplina);?></td>
                                <td><?php  echo h($oferta[$i]['codigo']);?></td>
                                <td><?php  echo h($oferta[$i]['turma']);?></td>
                                <td><?php  echo h($oferta[$i]['vagas']);?></td>
                                <td><?php  echo h($oferta[$i]['turno']);?></td>
                                <td><?php  echo h($oferta[$i]['horarios']);?></td>
                                <td><?php  echo h($oferta[$i]['salas']);?></td>
                                <td><?php  echo h($oferta[$i]['reserva']);?></td>
                                <td><?php  echo h($oferta[$i]['status']);?></td>
                                <td><?php  echo h($oferta[$i]['nome_prof']);?></td>
                                <td><?php  echo h($creditos);?>
                                <td><input type=radio name='disc_turma' value="<?php  echo h($oferta[$i]['codigo'])."_".h($oferta[$i]['turma'])."_".h($oferta[$i]['magistral']);?>"></td>
                                </tr>

                <?php 
// fim da atualizacao de 21/04/2014
			   }
		}
		?>
		<tr><td colspan=11 align=center>Tipo de Corre&ccedil;&atilde;o:</td></tr>
        	<tr><td colspan=11 align=center><select name='tipo_correcao'>
			<option value="cor_subs_prof_global" > <b>Substituir professor em grupos magistrais</b>) </option>
			<option value="cor_subs_prof_local" selected> <b>Substituir professor</b>)</option>
			<option value="cor_elimina">Elimina&ccedil;&atilde;o de disciplina</option>
			</select> 
		        Novo Professor: <select name='substituto'> 
					<option value='0' selected>Nenhum</option>
		<?php 
					$query_profs=db_query("select coduser,name||' '||firstname as nome from users where coduser in (select coduser from profs where situacao='ativo') order by nome", array()) or die("probema de acesso ao Banco de dados");
					while($registro2=db_fetch_row($query_profs))
						{
						?>
						<option value="<?php  echo h($registro2[0]);?>"><?php  echo h($registro2[1]);?></option> 
						<?php 
						}
						?>
					</select>
		<!--	<select name='encaminhada'>
                        <option value="0" selected>N&atilde;o encaminhar</option>
                        < option value="SAA">Encaminhar para SAA</option>
                        </select> 
		-->
		</td>
		</tr>
<?php 			
		
?>
	</table>
	</td>
	</tr>
	<tr>
	<td align=center>
	
	<input type=submit name='registra2' value="Confirmar corre&ccedil;&atilde;o">
	<input type=reset name='limpa' value="Limpar dados">
	
	<input type=hidden name='semestre' value="<?php  echo h($semestre);?>">
	<input type=hidden name='ano' value="<?php  echo h($ano);?>">
	</td>
	</tr>
	</form>
	</table>
	</BODY>
	</HTML>
<?php 
}

if (!isset($_POST['registra']) and isset($_POST['registra2']))
{


$semestre=$_POST['semestre'];
$ano=$_POST['ano'];
if (!ctype_digit((string)$semestre) || !ctype_digit((string)$ano)) {
	die(error("Semestre/ano invalido."));
}
//$tabela="oferta_lista_de_ofertas_".$semestre."_".$ano;
$tabela="oferta_lista_de_ofertas_nova";





$disc_turma=explode("_",$_POST['disc_turma']);

$tipo_correcao=$_POST['tipo_correcao'];

$substituto=$_POST['substituto'];

if (isset($disc_turma) and ($disc_turma!=0))
	{
	if((($tipo_correcao!="cor_elimina") and ($substituto==0)) or (($tipo_correcao=="cor_elimina") and (($substituto!=0)) )) echo "<script type=\"text/javascript\">history.back()</script>";
	else 
	{
	if ($tipo_correcao!="cor_elimina") 
		{
		if($disc_turma[2]=="teoria") 
			{
			if($tipo_correcao=="cor_subs_prof_global") aloca_professor_no_grupo_teoria_da_turma_dada($disc_turma[0],$substituto,$disc_turma[1],$semestre,$ano);   // corrigido em 21/04/2014
			else 
				{
				$query_corrige_lista=db_query("update ".$tabela." set professor=? where codigo=? and turma=? and magistral=?", array($substituto, $disc_turma[0], $disc_turma[1], $disc_turma[2]));
				}
			}
		else 
			{
			if($disc_turma['2']=="exercicios") $query_corrige_lista=db_query("update ".$tabela." set professor=? where codigo=? and turma=? and magistral=?", array($substituto, $disc_turma[0], $disc_turma[1], $disc_turma[2])); else 
			$query_corrige_lista=db_query("update ".$tabela." set professor=? where codigo=? and turma=?", array($substituto, $disc_turma[0], $disc_turma[1]));
			}
//		echo $query_corrige_lista;
//		$res_corrige_lista=db_query($query_corrige_lista, $query_corrige_lista__p);
		}
	 if ($tipo_correcao=="cor_elimina")
                {
		list($query_corrige_lista, $query_corrige_lista__p) = array("update ".$tabela." set elimina='sim' where codigo=? and turma=?", array($disc_turma[0], $disc_turma[1]));
//                echo $query_corrige_lista;
              $res_corrige_lista=db_query($query_corrige_lista, $query_corrige_lista__p);
                }
//	echo "<script type=\"text/javascript\">history.back();?</script>";

?>
 <body>
      <table class=big>
      <form method="POST" name="formu" action="atualiza_lista_provisoria.php">
         <tr>
        <td class=header align=center>
        <input type=submit name='registra' value="Fazer outras altera&ccedil;&otilde;es">
	<input type=hidden name='lista' value="<?php echo h($semestre."_".$ano);?>">
        </td>
        </tr>
        </table>
        </form>
	</body>
	</html>

<?php 
	}
	}

/* Foi criada a função para finalizar o processo.
if ($_POST['encaminhada']!="0")
	{
	$query_encaminhada=db_query("update oferta_acusa_lista set encaminhada=? where ano=? and semestre=?", array($_POST['encaminhada'], $ano, $semestre));
	// copia a lista provisoria para a lista definitiva que sera atualizada pelas correcoes feitas no SIGRA:
//oferta_lista_de_ofertas:   disciplina | turma | turno | professor | semestre | ano  |  horarios 
//oferta_lista_de_ofertas_nova:  codigo | turma | vagas |  turno  |  horarios  | salas | reserva | status | professor | elimina | semestre | ano
 	list($limpa_provisoria_na_definitiva, $limpa_provisoria_na_definitiva__p) = array("delete from oferta_lista_de_ofertas where semestre=? and ano=?", array($semestre, $ano));
	$res_limpa=db_query($limpa_provisoria_na_definitiva, $limpa_provisoria_na_definitiva__p);
	corrige_codigo_turmas_magistral($semestre,$ano);// em 21/04/2014
	list($insere_provisoria_na_definitiva, $insere_provisoria_na_definitiva__p) = array("insert into oferta_lista_de_ofertas (disciplina,turma,turno,professor,semestre,ano,horarios) select codigo,turma,turno,professor,?,?,horarios from oferta_lista_de_ofertas_nova where semestre=? and ano=? and elimina='nao'", array($semestre, $ano, $semestre, $ano));
//	echo $insere_provisoria_na_definitiva;
//	$res_insere=db_query($insere_provisoria_na_definitiva, $insere_provisoria_na_definitiva__p)  or die ("Problema de acesso ao banco");	 nao se substitui  lista de ofertas porque nao faz mais sentido.
	} 
*/
}

	db_close($idconn);

?>


