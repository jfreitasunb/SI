<?
/* CRIAR/ALTERAR OFERTA DO SEMESTRE/ANO:
1- entrar com semestre e ano;
2- checa tabela oferta_acusa_lista: 
	se nao existir, criar uma tabela oferta_lista_de_ofertas_semestre_ano, declarar em oferta_acusa_lista;
3- exibir a tela com a lista tirada de oferta_lista_de_ofertas_semestre_ano e as opcoes de correcoa/alteracao;
4- registrar em oferta_lista_de_ofertas_semestre_ano as alteracoes feitas.

Ok 27/04/12

*/
include("head_oferta.php");
?>

<html>
  <header>
    <link type="text/css" rel="stylesheet" href="../../global/grafic.css">
<meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
  </header>

<?

if (!isset($_POST['registra']))
{
$query_acusa_lista=pg_query("select * from oferta_acusa_lista where encaminhada='nova' order by ano desc, semestre");
$query_disciplinas=pg_query("select * from disciplinas_mat order by nome");
?>
  <body>
      <table class=big>
   <form method="POST" name="formu" action="incluir_nova_disc_turma.php">
      <tr>
        <td class=header align=center colspan=2>
        <h1>Inclus&atilde;o de nova disciplina/turma</h1>
        </td>
      </tr>
	<tr>
        <td>Escolha a lista: 
		<select name='lista'>
        	<?
	        while ($registro=pg_fetch_row($query_acusa_lista))
        	{
	        ?>
        	<option  value="<? echo $registro[0]."_".$registro[1];?>"> <? echo $registro[0];?> &ordm;/ <? echo $registro[1];?></option>
	        <?
        	}
	        ?>
		</select>
	</td>
        </tr>
	<tr><td><table border>
		<tr><td colspan="7"><b>Inclua a Disciplina/Turma</b></td></tr>
		<tr><td>Disciplina/C&oacute;digo</td><td>Turma</td><td>Vagas</td><td>Turno</td><td>Hor&aacute;rios</td><td>reserva</td><td>status</td></tr>
		<tr><td><select name='disciplina'>
			<?
			while ($registro_disc=pg_fetch_row($query_disciplinas))
			{
			?>
			<option value="<? echo $registro_disc[0];?>"><? echo $registro_disc[0];?>/<? echo $registro_disc[1];?></option>
			<?}?>
			</select></td>
		<td><input type=text name='turma' maxlength=1 size=1></td>
		<td><input type=text name='vagas' maxlength=2 size=1></td>
		<td><select name='turno'><option value="Diurno">Diurno</option>
					 <option value="Noturno">Noturno</option></select></td>
		<td><input type=text name='horarios' maxlength=11></td>
		<td><input type=text name='reserva' size=20></td>
		<td><select name='status'><option value="fixa">Hor&aacute;rio fixo</option>
                                         <option value="optativa">Optativa</option></select></td>
		<td><select name='status_oferta'><option value="1">Semestre 1</option>
	                                         <option value="2">Semestre 2</option>
	                                         <option value="12">Semestres 1 e 2</option></select></td>
		</tr>
	</table>
	</tr>
        <tr>
<td align=center>
<input type=submit name='registra' value="Confirmar op&ccedil;&otilde;es">
</td>
</tr>
</form>
</table>
</BODY>
</HTML>

<?
}

if (isset($_POST['registra']))
{
$lista=explode("_",$_POST['lista']);
$semestre=$lista[0];
$ano=$lista[1];


$disciplina=$_POST['disciplina'];
$turma=$_POST['turma'];
$vagas=$_POST['vagas'];
$turno=$_POST['turno'];
$horarios=$_POST['horarios'];
$reserva=$_POST['reserva'];
$status=$_POST['status'];
$status_oferta=$_POST['status_oferta'];

$tabela_oferta="oferta_lista_de_ofertas_nova";
$tabela_base="oferta_semestres";
//
$query_checa=pg_query("select * from ".$tabela_oferta." where codigo='".$disciplina."' and turma='".$turma."' and semestre='".$semestre."' and ano='".$ano."'");
$res_disc=pg_num_rows($query_checa);

if ($res_disc!=0) 
	{// mensagem: ja existe a turma nessa disciplina
	echo "A turma ".$turma." da disciplina ".$disciplina." j&aacute; existe na oferta do ".$semestre."/".$ano;
	}
else 
	{//verifica se existe na tabela de referencia: 
	$query_checa_1=pg_query("select * from ".$tabela_base." where codigo='".$disciplina."' and turma='".$turma."' and turno='".$turno."'");
	$res_disc_1=pg_num_rows($query_checa_1);

 	if ($res_disc_1!=0) // corrigido em 13/04/2012
        	{// mensagem: ja existe a turma nessa disciplina
        	echo "A turma ".$turma." da disciplina ".$disciplina." j&aacute; existe nas tabelas base.";
        	}
	else 
		{
		if ($status=="fixa")
			{
			if ($res_disc_1==0) {$insere_disciplina_1=pg_query("insert into ".$tabela_base." values('".$disciplina."','".$turma."','".$vagas."','".$turno."','".$horarios."','','".$reserva."','".$status."','".$status_oferta."')") or die ("problemas de conexao");
					     echo "A turma ".$turma." da disciplina ".$disciplina." foi inserida na tabela oferta_semestre_1.";
					     }
			}
		}
	$insere_disciplina_semestre="insert into ".$tabela_oferta." values('".$disciplina."','".$turma."','".$vagas."','".$turno."','".$horarios."','','".$reserva."','".$status."','0','nao','".$semestre."','".$ano."')";
	echo $insere_disciplina_semestre;
	$res_insere_disciplina=pg_query($insere_disciplina_semestre) or die ("problema de conexao com o banco");
	echo "A turma ".$turma." da disciplina ".$disciplina." foi inserida na tabela da lista de oferta do ".$semestre."/".$ano;
		
	}	

}

pg_close($idconn);

?>

