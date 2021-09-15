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
$seleciona_magistral=pg_query("select codigo from  oferta_disciplinas_magistral") or die("problema 02 em muda_horarios_turmas_magistral");  

// para cada linha de $seleciona_magistral, muda o código da disciplina teoria:
while($turma=pg_fetch_row($seleciona_magistral))
{

$muda_codigo="update oferta_lista_de_ofertas_nova set codigo='".$turma[0]."' where codigo='".$turma[0]."001'";

$query_muda_codigo=pg_query($muda_codigo) or die("problema 05 em muda_horarios_turmas_magistral");

} //fim do do while
} // fim da funcao corrige_codigo_turmas_magistral
//

function creditos_magistral($codigo,$turma)
{
//$creditos=array("teoria"=>0,"exercicios"=>0);
$pega_horarios=pg_query("select turmas from oferta_grupos_magistral_teoria where (grupo,horario) in (select grupo,horario from oferta_grupos_magistral_teoria where turmas='".$turma."' and codigo_1='".$codigo."')");
$turmas=pg_num_rows($pega_horarios); 
$pega_creditos=pg_query("select teoria,exercicios from oferta_disciplinas_magistral where codigo in (select codigo from  oferta_grupos_magistral_teoria where codigo_1='".$codigo."') or codigo ='".$codigo."'");

$creditos=pg_fetch_array($pega_creditos);
$creditos['teoria']=$creditos['teoria']/$turmas;
//echo $codigo."-".$turma."-".$creditos['teoria']."-".$creditos['exercicios']."-/-";
return $creditos;
} 

// aloca professores nas turmas de um determinado grupo de aulas magistrais/teoria:
function aloca_professor_no_grupo_teoria_da_turma_dada($codigo,$professor,$turma,$semestre,$ano)
{
//$codigo_0=($codigo-1)/1000;
$pega_turmas_horarios_grupo="select turmas,horario from oferta_grupos_magistral_teoria where grupo in (select grupo from oferta_grupos_magistral_teoria where codigo_1='".$codigo."' and turmas='".$turma."')";
//echo $pega_turmas_horarios_grupo."---//---";
$query_pega_turmas_horarios_grupo=pg_query($pega_turmas_horarios_grupo) or die ("problema 01 em aloca_professor_no_grupo_teoria_da_turma_dada");

while($horarios=pg_fetch_row($query_pega_turmas_horarios_grupo))
{
$update_oferta="update oferta_lista_de_ofertas_nova set professor='".$professor."' where codigo='".$codigo."'  and  turma='".$horarios[0]."' and semestre='".$semestre."' and ano='".$ano."'";
//echo $update_oferta."--/--";
$res_oferta=pg_query($update_oferta) or die("problema 02 em aloca_professor_no_grupo_teoria_da_turma_dada");
}

}// fim function aloca_professor_no_grupo_teoria_da_turma_dada 


?>



<html>
  <header>
    <link type="text/css" rel="stylesheet" href="../../global/grafic.css">
<meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
  </header>

<?

if (!isset($_POST['registra']) and !isset($_POST['registra2']))
{
$query_acusa_lista=pg_query("select * from oferta_acusa_lista where encaminhada='nova' order by ano desc,semestre desc");

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
        <?
        while ($registro=pg_fetch_row($query_acusa_lista))
        {
        ?>
        <option name='lista' value="<?echo $registro[0]."_".$registro[1];?>"> <? echo $registro[0];?> &ordm;/ <? echo $registro[1];?></option>
        <?
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
<?
}

if (isset($_POST['registra']) and !isset($_POST['registra2']))
{

$lista=explode("_",$_POST['lista']);
$semestre=$lista[0];
$ano=$lista[1];
//$tabela="oferta_lista_de_ofertas_".$lista[0]."_".$lista[1];
$tabela="oferta_lista_de_ofertas_nova";


if($_POST['limpa_tabela']=="sim") $query_limpa_oferta_semestre=pg_query("update ".$tabela." set professor='0' where semestre='".$semestre."' and ano='".$ano."'");

// lista de disciplinas no esquema magistral:
$query_magistral=pg_query("select * from oferta_disciplinas_magistral"); 
$magistral=array();
while($magistral_0=pg_fetch_row($query_magistral))
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
        <h1> Corre&ccedil;&atilde;o da Lista de Ofertas do <? echo $semestre;?>&ordm;/ <? echo $ano;?></h1>
        </td>
      </tr>
         <tr><td class=data align=center>
        <table border>
        <tr><td><b>Disciplina</b></td><td><b>C&oacute;digo</b></td><td><b>Turma</b></td><td><b>Vagas</b></td><td><b>Turno</b></td><td><b>Hor&aacute;rios</b></td><td><b>Salas</b></td><td><b>Reservas</b></td><td><b>Status</b></td><td><b>Professor</b></td><td><b>Carga</b></td><td><b>Substituir</b></td></tr>
        <tr></tr>

<?

//disciplina | codigo | turma | vagas |  turno  |  horarios   | salas | reserva |  status | professo | elimina | semestre | ano | magistral


//	$query_oferta="select m.nome as disciplina, lo.*, u.name||' '||u.firstname as nome_prof,creditos from ".$tabela." lo, disciplinas_mat m, users u where lo.codigo=m.codigo and u.coduser=lo.professor and lo.elimina='nao' and lo.semestre='".$semestre."' and lo.ano='".$ano."' order by disciplina,turma,magistral";
// correção feita EM 21/04/2014 PARA CONTEMPLAR AS TURMAS MAGISTRAIS:
	$query_oferta="select m.nome as disciplina, lo.*, u.name||' '||u.firstname as nome_prof,creditos from ".$tabela." lo, disciplinas_mat m, users u where lo.codigo=m.codigo and u.coduser=lo.professor and lo.elimina='nao' and lo.semestre='".$semestre."' and lo.ano='".$ano."'  union (select m.nome as disciplina, og.codigo_1,lo.turma,lo.vagas,lo.turno,lo.horarios,lo.salas,lo.reserva, lo.status,lo.professor,lo.elimina,lo.semestre,lo.ano,lo.magistral, u.name||' '||u.firstname as nome_prof,creditos from ".$tabela." lo, disciplinas_mat m, users u, oferta_grupos_magistral_teoria og where lo.codigo=og.codigo_1 and og.codigo=m.codigo and u.coduser=lo.professor and lo.elimina='nao' and lo.turma=og.turmas and lo.semestre='".$semestre."' and lo.ano='".$ano."') order by disciplina,turma,magistral";
//echo $query_oferta;
	$oferta0=pg_query($query_oferta);
	$oferta=pg_fetch_all($oferta0);
//disciplina | codigo | turma | vagas |  turno  |  horarios   | salas | reserva |  status | professor | nome_prof
        $cor_de_fundo="#FFFFFF";
	$codigo=0;
	$turma="";
	for($i=0;$i<count($oferta);$i++)
//        while ($registro=pg_fetch_row($oferta))
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
				<tr bgcolor="<? echo $cor_de_fundo;?>">
                                <td><? echo $disciplina;?></td>
                                <td><? echo $oferta[$i]['codigo'];?></td>
                                <td><? echo $oferta[$i]['turma'];?></td>
                                <td><? echo $oferta[$i]['vagas'];?></td>
                                <td><? echo $oferta[$i]['turno'];?></td>
                                <td><? echo $oferta[$i]['horarios'];?></td>
                                <td><? echo $oferta[$i]['salas'];?></td>
                                <td><? echo $oferta[$i]['reserva'];?></td>
                                <td><? echo $oferta[$i]['status'];?></td>
                                <td><? echo $oferta[$i]['nome_prof'];?></td>
                                <td><? echo $creditos;?>
                                <td><input type=radio name='disc_turma' value="<? echo $oferta[$i]['codigo']."_".$oferta[$i]['turma']."_".$oferta[$i]['magistral'];?>"></td>
                                </tr>

                <?
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
		<?
					$query_profs=pg_query("select coduser,name||' '||firstname as nome from users where coduser in (select coduser from profs where situacao='ativo') order by nome") or die("probema de acesso ao Banco de dados");
					while($registro2=pg_fetch_row($query_profs))
						{
						?>
						<option value="<? echo $registro2[0];?>"><? echo $registro2[1];?></option> 
						<?
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
<?			
		
?>
	</table>
	</td>
	</tr>
	<tr>
	<td align=center>
	
	<input type=submit name='registra2' value="Confirmar corre&ccedil;&atilde;o">
	<input type=reset name='limpa' value="Limpar dados">
	
	<input type=hidden name='semestre' value="<? echo $semestre;?>">
	<input type=hidden name='ano' value="<? echo $ano;?>">
	</td>
	</tr>
	</form>
	</table>
	</BODY>
	</HTML>
<?
}

if (!isset($_POST['registra']) and isset($_POST['registra2']))
{


$semestre=$_POST['semestre'];
$ano=$_POST['ano'];
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
				$query_corrige_lista=pg_query("update ".$tabela." set professor='".$substituto."' where codigo='".$disc_turma[0]."' and turma='".$disc_turma[1]."' and magistral='".$disc_turma[2]."'");
				}
			}
		else 
			{
			if($disc_turma['2']=="exercicios") $query_corrige_lista=pg_query("update ".$tabela." set professor='".$substituto."' where codigo='".$disc_turma[0]."' and turma='".$disc_turma[1]."' and magistral='".$disc_turma[2]."'"); else 
			$query_corrige_lista=pg_query("update ".$tabela." set professor='".$substituto."' where codigo='".$disc_turma[0]."' and turma='".$disc_turma[1]."'");
			}
//		echo $query_corrige_lista;
//		$res_corrige_lista=pg_query($query_corrige_lista);
		}
	 if ($tipo_correcao=="cor_elimina")
                {
		$query_corrige_lista="update ".$tabela." set elimina='sim' where codigo='".$disc_turma[0]."' and turma='".$disc_turma[1]."'";
//                echo $query_corrige_lista;
              $res_corrige_lista=pg_query($query_corrige_lista);
                }
//	echo "<script type=\"text/javascript\">history.back();?</script>";

?>
 <body>
      <table class=big>
      <form method="POST" name="formu" action="atualiza_lista_provisoria.php">
         <tr>
        <td class=header align=center>
        <input type=submit name='registra' value="Fazer outras altera&ccedil;&otilde;es">
	<input type=hidden name='lista' value="<?echo $semestre."_".$ano;?>">
        </td>
        </tr>
        </table>
        </form>
	</body>
	</html>

<?
	}
	}

/* Foi criada a função para finalizar o processo.
if ($_POST['encaminhada']!="0")
	{
	$query_encaminhada=pg_query("update oferta_acusa_lista set encaminhada='".$_POST['encaminhada']."' where ano='".$ano."' and semestre='".$semestre."'");
	// copia a lista provisoria para a lista definitiva que sera atualizada pelas correcoes feitas no SIGRA:
//oferta_lista_de_ofertas:   disciplina | turma | turno | professor | semestre | ano  |  horarios 
//oferta_lista_de_ofertas_nova:  codigo | turma | vagas |  turno  |  horarios  | salas | reserva | status | professor | elimina | semestre | ano
 	$limpa_provisoria_na_definitiva="delete from oferta_lista_de_ofertas where semestre='".$semestre."' and ano='".$ano."'";
	$res_limpa=pg_query($limpa_provisoria_na_definitiva);
	corrige_codigo_turmas_magistral($semestre,$ano);// em 21/04/2014
	$insere_provisoria_na_definitiva="insert into oferta_lista_de_ofertas (disciplina,turma,turno,professor,semestre,ano,horarios) select codigo,turma,turno,professor,'".$semestre."','".$ano."',horarios from oferta_lista_de_ofertas_nova where semestre='".$semestre."' and ano='".$ano."' and elimina='nao'";
//	echo $insere_provisoria_na_definitiva;
//	$res_insere=pg_query($insere_provisoria_na_definitiva)  or die ("Problema de acesso ao banco");	 nao se substitui  lista de ofertas porque nao faz mais sentido.
	} 
*/
}

	pg_close($idconn);

?>


