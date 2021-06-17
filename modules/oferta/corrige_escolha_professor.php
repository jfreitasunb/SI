<?PHP
include("head_oferta.php");

function creditos_magistral($codigo,$turma)
{
//$creditos=array("teoria"=>0,"exercicios"=>0);
$pega_horarios=pg_query("select turmas from oferta_grupos_magistral_teoria where (grupo,horario) in (select grupo,horario from oferta_grupos_magistral_teoria where turmas='".$turma."' and codigo_1='".$codigo."')");
$turmas=pg_num_rows($pega_horarios); 
$pega_creditos=pg_query("select teoria,exercicios from oferta_disciplinas_magistral where codigo in (select codigo from  oferta_grupos_magistral_teoria where codigo_1='".$codigo."') or codigo ='".$codigo."'");

$creditos=pg_fetch_array($pega_creditos);
$creditos['teoria']=$creditos['teoria']/$turmas;
echo $codigo."-".$turma."-".$creditos['teoria']."-".$creditos['exercicios']."-/-";
return $creditos;
} 


?>
<html>
  <header>
    <link type="text/css" rel="stylesheet" href="../../global/grafic.css">
<meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
  </header>


<?


if (isset($_POST['submit']) and ($_POST['professor']=="todos"))
{
$lista_oferta=explode("/",$_POST['lista_oferta']);
$semestre=$lista_oferta[0];
$ano=$lista_oferta[1];

$creditos_todos=array();

$total_cred_est_pesq=pg_query("select distinct on (coduser) sum(creditos),coduser from oferta_escolha_creditos_est_pesq_pos where ano='".$ano."' and semestre='".$semestre."' group by coduser") or die("problema 01 em seleciona todos");
while($reg_cred=pg_fetch_row($total_cred_est_pesq))
	{
	$creditos_todos[$reg_cred[1]]['pos']=$reg_cred[0];
	}

$total_cred_grad=pg_query("select coduser,creditos from oferta_escolha_creditos where ano='".$ano."' and semestre='".$semestre."'") or die("problema 02 em seleciona todos");
while($reg_cred=pg_fetch_row($total_cred_grad))
        {
        $creditos_todos[$reg_cred[0]]['grad']=$reg_cred[1];
        }

$query_prioridades=pg_query("select u.coduser as coduser,name||' '||firstname as professor, oe.prioridade as prioridade, oe.disciplina as codigo,d.nome as disciplina,oe.creditos as creditos,oe.turno as turno from  oferta_escolha_disciplina oe, disciplinas_mat d,users u where oe.ano='".$ano."' and oe.semestre='".$semestre."' and u.coduser=oe.coduser and oe.disciplina=d.codigo union (select u.coduser as coduser,name||' '||firstname as professor, oe.prioridade as prioridade, oe.disciplina as codigo,d.nome as disciplina,oe.creditos as creditos,oe.turno as turno from  oferta_escolha_disciplina oe, disciplinas_mat d,users u where oe.ano='".$ano."' and oe.semestre='".$semestre."' and u.coduser=oe.coduser and d.codigo in (select codigo from oferta_grupos_magistral_teoria where codigo_1=oe.disciplina)) order by professor,prioridade");

$num=pg_num_rows($query_prioridades);
$registro=pg_fetch_all($query_prioridades);
$cor_de_fundo=="#FFFFFF";
$nome_0="Tarzan";
?>
 <body>
 <table class=big>
 <tr><td class=data align=center>
        <table border>
        <tr><td><b>Professor</b></td><td><b>Cr&eacute;ditos Grad.</b></td><td><b>Cr&eacute;ditos Est. PG</b></td><td><b>Prioridade 1</b></td><td><b>Prioridade 2</b></td><td><b>Prioridade 3</b></td><td><b>Prioridade 4</b></td><td><b>Prioridade 5</b></td><td><b>Prioridade 6</b></td></tr>
        <tr></tr>
<?
for($i=0;$i<$num;$i++) 
	{
	if($registro[$i]['professor']!=$nome_0)
		{
		echo $linha."</tr>";
		if ($cor_de_fundo=="#FFFFFF") $cor_de_fundo="#BEBEBE"; else $cor_de_fundo="#FFFFFF";
		$nome_0=$registro[$i]['professor'];
		$linha="<tr BGCOLOR=\"".$cor_de_fundo."\"><td>".$registro[$i]['professor']."</td><td>".$creditos_todos[$registro[$i]['coduser']]['grad']."</td><td>".$creditos_todos[$registro[$i]['coduser']]['pos']."</td><td>(".$registro[$i]['codigo'].")-".$registro[$i]['disciplina']."-".$registro[$i]['creditos']."-".$registro[$i]['turno']."</td>";	
		}
	else 
		{
		$linha.="<td>(".$registro[$i]['codigo'].")-".$registro[$i]['disciplina']."-".$registro[$i]['creditos']."-".$registro[$i]['turno']."</td>";
		}
	}
	echo $linha."</tr>";
?>
	</table>
	</table>
	</body>
	</html>
<?
}


if (isset($_POST['submit']) and ($_POST['professor']!="todos"))
{
		$coduser=$_POST['professor'];
		$lista_oferta=explode("/",$_POST['lista_oferta']);
		$semestre=$lista_oferta[0];
		$ano=$lista_oferta[1];
		$encaminhada=$lista_oferta[2];

		$query_nome=pg_query("select name||' '||firstname from users where coduser='".$coduser."'");
		$nome_prof=pg_fetch_row($query_nome);
	
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
                                if($registro_magistral[1]=="teoria") $ck_c1_teoria="checked";
                                if($registro_magistral[1]=="exercicios") $ck_c1_exos="checked";
                                }
                        if($registro_magistral[1]==113018)
                                {
                                if($registro_magistral[1]=="teoria") $ck_m1_teoria="checked";
                                if($registro_magistral[1]=="exercicios") $ck_m1_exos="checked";
                                }
                        if($registro_magistral[1]==113701)
                                {
                                if($registro_magistral[1]=="teoria") $ck_ims_teoria="checked";
                                if($registro_magistral[1]=="exercicios") $ck_ims_exos="checked";
                                }
                        }
		// TESTE:
		//$semestre=1;
		//$ano=2012;
		//$tabela="oferta_semestre_".$semestre;
		//$tabela="oferta_lista_de_ofertas_".$semestre."_".$ano;
		$tabela="oferta_lista_de_ofertas_nova";


?>
		  <body>
		      <table class=big>
		   <form method="POST" name="formu" action="correcao_escolha_prof/oferta_escolha_professor.php">
		      <tr>
		        <td class=header align=center colspan=2>
	        <h1>Ficha de Prefer&ecirc;ncias &ndash; <? echo $semestre;?>&ordm;/ <? echo $ano;?></h1>
        	</td>
	      </tr>
	      <tr>
              <td><b>Professor:</b> <? echo $nome_prof[0];?></td>
        	</tr>
        	<tr>
        	<td>Quantos cr&eacute;ditos pretende lecionar na gradua&ccedil;&atilde;o? 
                <select name='creditos'>
                        <option value='0' <? if ($registro_creditos[1]==0) echo "selected";?>> 0 cr&eacute;ditos</option> 
                        <option value='4' <? if ($registro_creditos[1]==4) echo "selected";?>> 4 cr&eacute;ditos</option> 
                        <option value='6' <? if ($registro_creditos[1]==6) echo "selected";?>> 6 cr&eacute;ditos</option>
                        <option value='8' <? if ($registro_creditos[1]==8) echo "selected";?>> 8 cr&eacute;ditos</option>
                        <option value='10' <? if ($registro_creditos[1]==10) echo "selected";?>> 10 cr&eacute;ditos</option>
                        <option value='12' <? if ($registro_creditos[1]==12) echo "selected";?>> 12 cr&eacute;ditos</option>
                        <option value='14' <? if ($registro_creditos[1]==14) echo "selected";?>> 14 cr&eacute;ditos</option>
                        <option value='16' <? if ($registro_creditos[1]==16) echo "selected";?>> 16 cr&eacute;ditos</option>
                        </select>
                </td>
	        </tr>
        	<tr>
                <td>Prefer&ecirc;ncia por 2 (duas) disciplinas de 6 cr&eacute;ditos iguais? 
                <select name='disciplinas_iguais_6'>  
                        <option value="nao" <? if ($registro_creditos[2]=="nao") echo "selected";?>> N&atilde;o</option>
                        <option value="sim" <? if ($registro_creditos[2]=="sim") echo "selected";?>> Sim</option>
                </select>
	        </td>
	        </tr>
        	<tr>
	        <td>Quais disciplinas pretende lecionar na p&oacute;s-gradua&ccedil;&atilde;o (exceto Est&aacute;gios em Pesquisa)?<BR>
        <?
        	for ($cont_pos=0;$cont_pos<2;$cont_pos++)
                	{
        ?>
	                <select name='disc_pos[]'>
                        <option value="0-0" <? if ($num_creditos_pos==0) echo "selected";?>>Nenhuma</option>
                <?
			$cor_de_fundo="#FFFFFF";
        	        $select_disciplinas_pg[$cont_pos]=pg_query("select codigo, nome, creditos from disciplinas_mat where status='pgrad' order by nome"); 
                	while ($registro[$cont_pos]=pg_fetch_row($select_disciplinas_pg[$cont_pos]))
                        	{
                        	if ($cor_de_fundo=="#FFFFFF") $cor_de_fundo="#D3D3D3"; else $cor_de_fundo="#FFFFFF";
			?>
	                        <option value="<? echo $registro[$cont_pos][0]."-".$registro[$cont_pos][2];?>" <? if ($registro[$cont_pos][0]==$registro_creditos_pos[$cont_pos]['disciplina']) echo "selected";?> style="COLOR: #000000; BACKGROUND-COLOR: <? echo $cor_de_fundo;?>"> <? echo $registro[$cont_pos][0]."-".$registro[$cont_pos][1]." (".$registro[$cont_pos][2].")";?></option>
                        <?
        	                }
                	?>
                        	</select>  
	                        <BR>
                <?
        	        }
                ?>
                </td>
		</tr>
	        <tr>
                <td>Cr&eacute;ditos em Est&aacute;gio de Pesquisa:<br>
                <?
		//$registro_creditos_est_pesq_pos=pg_fetch_all($query_escolha_creditos_est_pesq_pos); coduser | creditos | orientando | semestre | ano
		//$num_creditos_est_pesq_pos=pg_num_rows($query_escolha_creditos_est_pesq_pos);

                for ($cont_pesq=0;$cont_pesq<5;$cont_pesq++)
                        {
                ?>
                	<select name='credito_estagio_pesquisa[<? echo $cont_pesq;?>]'>
                        <option value='0' <? if (($num_creditos_est_pesq_pos==0) or ($registro_creditos_est_pesq_pos[$cont_pesq]['creditos']==0)) echo "selected";?>> 0 </option>
                        <option value='1' <? if ($registro_creditos_est_pesq_pos[$cont_pesq]['creditos']==1) echo "selected";?>> 1 </option>
                        <option value='2' <? if ($registro_creditos_est_pesq_pos[$cont_pesq]['creditos']==2) echo "selected";?>> 2 </option>
	                </select> cr&eacute;ditos -  Orientando: 
        	        <select name='orientando[<? echo $cont_pesq;?>]'>
                        <option value="0" selected>Nenhum</option>
                        <?
                        $select_orientando[$cont_pesq]=pg_query("select coduser,name,firstname from users where coduser in (select coduser from student where status='ativo') order by name");
                	while ($registro1[$cont_pesq]=pg_fetch_row($select_orientando[$cont_pesq]))
                        	{
                        ?>
	                        <option value="<? echo $registro1[$cont_pesq][0];?>" <? if ($registro_creditos_est_pesq_pos[$cont_pesq]['orientando']==$registro1[$cont_pesq][0]) echo "selected";?>> <? echo $registro1[$cont_pesq][1]." ".$registro1[$cont_pesq][2];?></option>
                        <?
        	                }
                        ?>
                        </select>  
                        <BR>    
                        <?}?>
                </td>
                </tr>
<?
//$registro_disciplinas: coduser | prioridade | disciplina | dias | horarios | semestre | ano  |  turno  | creditos | atendido
?>
                <tr><td> Escolha a disciplina/turno:<br>
                        <? for ($i=1;$i<7;$i++)
                                {
                                echo "<b>Prioridade ".$i.":</b> <select name='disciplina[".$i."]'>";
$select_disciplinas[$i]=pg_query("select distinct on (m.nome,lo.turno) lo.codigo,m.nome as nome,m.creditos,upper(lo.turno) as turno,lo.status,lo.turma,lo.magistral from ".$tabela." lo, disciplinas_mat m where m.codigo=lo.codigo and elimina='nao' union (select distinct on (m.nome,lo.turno) lo.codigo,m.nome as nome,m.creditos,upper(lo.turno) as turno,lo.status,lo.turma,lo.magistral from ".$tabela." lo, disciplinas_mat m, oferta_grupos_magistral_teoria og where og.codigo_1=lo.codigo and og.codigo=m.codigo and elimina='nao') order by nome,turno");// em 23/04/2014
				$cor_de_fundo="#FFFFFF";
                                if (($num_disc==0) or ($registro_disciplinas[$i-1]['disciplina']==0)) echo "<option value=\"_0\" selected>Escolher uma disciplina</option>";
                                while($registro2[$i]=pg_fetch_row($select_disciplinas[$i]))
					{
					$creditos_a=creditos_magistral($registro2[$i][0],$registro2[$i][5]);		
					if($registro2[$i][6]=="teoria") $creditos=2*strlen($registro2[$i][3]) ; 
						else 
						{
						if ($registro2[$i][6]=="exercicios") $creditos=$creditos_a['exercicios']; else $creditos=$registro2[$i][2];
						}
                                        if ($cor_de_fundo=="#FFFFFF") $cor_de_fundo="#BEBEBE"; else $cor_de_fundo="#FFFFFF";
                                        if (($registro2[$i][0]==$registro_disciplinas[$i-1]['disciplina']) and ($registro2[$i][3]==strtoupper($registro_disciplinas[$i-1]['turno']))) $selected="selected"; else $selected=""; 
// corecao do 24/04/2014
					  echo "<option value=\"".$registro2[$i][0]."_".$registro2[$i][3]."_".$registro2[$i][6]."_".$creditos."\" style=\"COLOR: #000000; BACKGROUND-COLOR: ".$cor_de_fundo."\" ".$selected.">".$registro2[$i][3].":  ".$registro2[$i][0]."-".$registro2[$i][1]." (".$creditos." ".$registro2[$i][6].")</option>";
                                        }
                                echo "</select><br>";
                                }
                        ?>
                </td></tr>
<tr><td>No preenchimento das escolhas, n&atilde;o pode haver duas prioridades iguais. Al&eacute;m disso, todas as prioridades devem ser preenchidas.<br><br></td></tr>
        <tr><td>Atua&ccedil;&atilde;o em disciplinas no esquema magistral:</td></tr>
        <tr><td><b>C&aacute;lculo 1:</b>  Teoria (c&oacute;digo 113034001) (turno DDN, por exemplo, significa duas aulas diurnas e uma noturna <!input type=checkbox name='magistral_teoria[113034]' <? echo $ck_c1_teoria;?>>); Exerc&iacute;cios (c&oacute;digo 113034) <!input type=checkbox name='magistral_exercicios[113034]'  <? echo $ck_c1_exos;?>>)</td></tr>
        <tr><td><b>Matem&aacute;tica 1:</b>  Teoria (c&oacute;digo 113018001) <!input type=checkbox name='magistral_teoria[113018]'  <? echo $ck_m1_teoria;?>>); Exerc&iacute;cios(c&oacute;digo 113018) <!input type=checkbox name='magistral_exercicios[113018]'  <? echo $ck_m1_exos;?>>)</td></tr>
        <tr><td><b>Introdu&ccedil;&atilde;o &agrave; Matem&aacute;tica Superior:</b>  Teoria (c&oacute;digo 113107001) <!input type=checkbox name='magistral_teoria[113701]'  <? echo $ck_ims_teoria;?>>); Exerc&iacute;cios (c&oacute;digo 113107) <!input type=checkbox name='magistral_exercicios[113701]'  <? echo $ck_ims_exos;?>>)</td></tr> 
<?
// corrigido em 24/04/2014
?>
        <tr><td><br><br></td></tr>
	<tr><td>
	<a href="correcao_escolha_prof/atuacao_noturno.php?semestre=<? echo $semestre;?>&ano=<? echo $ano;?>">Veja rela&ccedil;&atilde;o de atua&ccedil;&otilde;es no Noturno</a>
	</td></tr>
<?
	if ($encaminhada=="nova")
	{
?>
        <tr>
        <td align=center>
        <input type=submit name='registra' value="Confirmar op&ccedil;&otilde;es">
        <!input type=reset name='limpa' value="Limpar formul&aacute;rio">
        <input type=hidden name='semestre' value="<? echo $semestre;?>">
        <input type=hidden name='ano' value="<? echo $ano;?>">
        <input type=hidden name='professor' value="<? echo $coduser;?>">
        </td>
        </tr>
<?
	}
?>	
        </table>
        </form>
        </BODY>
        </HTML>

<?
}

if (!isset($_POST['submit']))
{
$select_profs=pg_query("select coduser,name,firstname from users where coduser in (select coduser from profs where situacao='ativo') order by name");

//$select_oferta=pg_query("select * from oferta_acusa_lista where encaminhada='nova' order by ano ,semestre desc");
$select_oferta=pg_query("select * from oferta_acusa_lista order by ano desc,semestre desc");
//$tab_disciplinas=pg_fetch_all($select_disciplinas);

?>
  <body>
      <table class=big>
   <form method="POST" name="formu" action="corrige_escolha_professor.php">
      <tr>
        <td class=header align=center colspan=2>
        <h1>Ficha de Prefer&ecirc;ncias &ndash; <? echo $semestre;?>&ordm;/ <? echo $ano;?></h1>
        </td>
      </tr>
      <tr>
              <td>Professor:
                        <select name='professor'>
				<option value="todos" selected> -- selecionar todos -- </option>
                                <?      
                                while ($registro_0=pg_fetch_row($select_profs))
                                {
                                ?>
                                <option value="<? echo $registro_0[0];?>"> <? echo $registro_0[1]." ".$registro_0[2];?></option>
                                <?
                                }
                                ?>
                                </select>  
                        </td>
        </tr>
        <td>Selecione a lista de ofertas correspondente: <select name='lista_oferta'>
				<?
				while ($registro_1=pg_fetch_row($select_oferta))
					{?>
					<option value="<? echo $registro_1[0]."/".$registro_1[1]."/".$registro_1[2];?>"><? echo $registro_1[0]."/".$registro_1[1];?></option>
					<?}?>
					</select></td>
        </tr>
        <tr>
<td align=center>
<input type=submit name='submit' value="Confirmar op&ccedil;&otilde;es">
</td>
</tr>
</form>
</table>
</BODY>
</HTML>

<?
}
?>

