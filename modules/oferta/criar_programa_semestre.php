<?
include("head_oferta.php");
/* CRIAR/ALTERAR OFERTA DO SEMESTRE/ANO:
1- entrar com semestre e ano;
2- checa tabela oferta_acusa_lista: 
	se nao existir, eliminar dados da tabela oferta_lista_de_ofertas_nova, declarar em oferta_acusa_lista;
3- exibir a tela com a lista tirada de oferta_lista_de_ofertas_nova e as opcoes de correcoa/alteracao;
4- registrar em oferta_lista_de_ofertas_nova as alteracoes feitas.

Ok 27/04/12

*/
// Funcoes incluidas em 20/04/2014:
function muda_horarios_turmas_magistral($semestre,$ano) 
{
// roda na hora de rodar a lista; monta a tabela oferta_lista_de_ofertas_nova com todas as turmas 
// do magistral (exercicio+teoria) separadas com seus respectvos horarios.
// Mudar os horários das disciplinas magistrais na tabela oferta_lista_de_ofertas_nova para que sejam apenas as turmas de exercícios + 
// inserir turmas com código da disciplina.001 e turma correspondente como sendo turma do magistral. 

$seleciona_turmas_oferta=db_query("select codigo,turma,horarios,turno,magistral from oferta_lista_de_ofertas_nova where ano=? and semestre=? and codigo in (select codigo from oferta_disciplinas_magistral where ano=? and semestre=?)", array($ano, $semestre, $ano, $semestre)) or die("problema 01 em muda_horarios_turmas_magistral");

$seleciona_magistral=db_query("select * from  oferta_disciplinas_magistral where ano=? and semestre=?", array($ano, $semestre)) or die("problema 02 em muda_horarios_turmas_magistral");  
$array_magistral=array();
while($res_magistral=db_fetch_row($seleciona_magistral))
	{
	$array_magistral[$res_magistral[0]]['teoria']=$res_magistral[1];
	$array_magistral[$res_magistral[0]]['exercicios']=$res_magistral[2];
	}

// para cada linha de $seleciona_turmas_oferta, muda o horario de exercicios e cria a turma correspondente de teoria:

$array_turno_magistral=cria_turno_magistral($semestre,$ano); // define um array de turnos para codigo/grupo do magistral.


while($turma=db_fetch_row($seleciona_turmas_oferta))
{
$pega_horario_magistral=db_query("select horario from oferta_grupos_magistral_teoria where codigo=? and turmas=? and ano=? and semestre=?", array($turma[0], $turma[1], $ano, $semestre));
$array_horario_teoria=array();
$num=db_num_rows($pega_horario_magistral);
$res_horario=db_fetch_all($pega_horario_magistral);
//print_r($res_horario);
for($i=0;$i<$num;$i++)
//while($res_horario=db_fetch_row($pega_horario_magistral))
	{
//	$horario_teoria=db_result($pega_horario_magistral,0,0);
	$array_horario_teoria[$i]=$res_horario[$i]['horario'];
	}
$horario_teoria=$array_horario_teoria[0];
if(count($array_horario_teoria)>1) {for($j=1;$j<count($array_horario_teoria);$j++) {$horario_teoria.="-".$array_horario_teoria[$j];}}
echo $horario_teoria."--/--";
$horario_exercicios=str_replace($horario_teoria."-", "", $turma[2]);

// determina o turno do grupo da aula teorica:
$query_grupo=db_query("select grupo from oferta_grupos_magistral_teoria where codigo=? and turmas=? and ano=? and semestre=?", array($turma[0], $turma[1], $ano, $semestre));
$grupo=db_result($query_grupo,0,0);

// muda os horarios:
list($muda_horarios, $muda_horarios__p) = array("update oferta_lista_de_ofertas_nova set magistral='exercicios', horarios=? where turma=? and codigo=?", array($horario_exercicios, $turma[1], $turma[0]));
list($insere_horarios, $insere_horarios__p) = array("insert into oferta_lista_de_ofertas_nova (codigo,turma,horarios,turno,professor,semestre,ano,status,elimina,magistral) values (?,?,?,?,'0',?,?,'fixa','nao','teoria')", array($turma[0].'001', $turma[1], $horario_teoria, $array_turno_magistral[$turma[0]][$grupo], $semestre, $ano));

echo $muda_horarios."<br>";
//echo $insere_horarios."<br>"; // depuracao: imprimia o SQL na pagina

$query_muda_horarios=db_query($muda_horarios, $muda_horarios__p) or die("problema 03 em muda_horarios_turmas_magistral");
$query_insere_horarios=db_query($insere_horarios, $insere_horarios__p) or die("problema 04 em muda_horarios_turmas_magistral");

} //fim do do while
} // fim da funcao muda_horarios_turmas_magistral


//

function cria_turno_magistral($semestre,$ano)
{
// cria um array de codigo,grupo,turno.
$turnos_magistral=array();

$diurno=array('208','210','214','216','308','310','314','316','408','410','414','416','508','510','514','516','608','610','614','616');
$noturno=array('219','221','319','321','419','421','519','521','619','621','708','710');

$pega_magistral=db_query("select codigo from oferta_disciplinas_magistral where semestre=? and ano=?", array($semestre, $ano));

while($codigo=db_fetch_row($pega_magistral))
	{
//	$codigo0=$codigo[0];
	$pega_horarios_codigo=db_query("select distinct on(grupo,horario) grupo,horario from oferta_grupos_magistral_teoria where codigo=? and ano=? and semestre=? order by grupo,horario", array($codigo[0], $ano, $semestre));
	while($res=db_fetch_row($pega_horarios_codigo))
		{
		if(in_array($res[1],$diurno)) $turnos_magistral[$codigo[0]][$res[0]]="D".$turnos_magistral[$codigo[0]][$res[0]];
		if(in_array($res[1],$noturno)) $turnos_magistral[$codigo[0]][$res[0]].="N";
		}
	}
return $turnos_magistral;
} // fim cria_turno_magistral


////// fim da inclusao das funcoes

?>

<html>
  <header>
    <link type="text/css" rel="stylesheet" href="../../global/grafic.css">
<meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
  </header>

<?

if (!isset($_POST['registra1']) and !isset($_POST['registra2']))
{
?>
  <body>
      <table class=big>
   <form method="POST" name="formu" action="criar_programa_semestre.php">
      <tr>
        <td class=header align=center colspan=2>
        <h1>Oferta de disciplinas</h1>
        </td>
      </tr>
        <td>Insira o semestre: <input type=text name='semestre' maxlength=1 size=2></td><td>Insira o ano:<input type=text name='ano' maxlength=4 size=3></td>
        </tr>
        <tr>
<td colspan=2 align=center>
<input type=submit name='registra1' value="Confirmar op&ccedil;&otilde;es">
</td>
</tr>
</form>
</table>
</BODY>
</HTML>

<?
}

if (isset($_POST['registra1']) and !isset($_POST['registra2']))
{
$semestre=$_POST['semestre'];
$ano=$_POST['ano'];
if (!ctype_digit((string)$semestre) || !ctype_digit((string)$ano)) {
	die(error("Semestre/ano invalido."));
}

?>

  <body>
      <table class=big>
      <form method="POST" name="formu" action="criar_programa_semestre.php">
         <tr>
        <td class=header align=center>
        <h1> Lista de Ofertas do <? echo h($semestre);?>&ordm;/ <? echo h($ano);?></h1>
        </td>
      </tr>
         <tr><td class=data align=center>
        <table border>
        <tr><td><b>Disciplina</b></td><td><b>C&oacute;digo</b></td><td><b>Turma</b></td><td><b>Vagas</b></td><td><b>Turno</b></td><td><b>Hor&aacute;rios</b></td><td><b>Salas</b></td><td><b>Reservas</b></td><td><b>Status</b></td></tr>
        <tr></tr>

<?
//disciplina | codigo | turma | vagas |  turno  |  horarios   | salas | reserva |  status | professor

// tabela oferta_semestres: | codigo | turma | vagas |  turno  |  horarios   | salas | reserva |  status | semestre 

$tabela_a="oferta_lista_de_ofertas_nova";

	$query_checa_oferta_acusa_lista=db_query("select * from oferta_acusa_lista where semestre=? and ano=?", array($semestre, $ano)); 
	$num_oferta_acusa_lista=db_num_rows($query_checa_oferta_acusa_lista);

	if ($num_oferta_acusa_lista==0)
		{
		//limpa tabela de rascunho da lista:
		$query_limpa_provisoria=db_query("delete from ".$tabela_a, array()) or die ("Problema de acesso ao banco");
		//Insere na tabela de rascunho as disciplinas fixas
		list($query_insere_tabela_provisoria, $query_insere_tabela_provisoria__p) = array("insert into ".$tabela_a." (codigo,turma,vagas,turno,horarios,salas,reserva,status,professor,elimina,semestre,ano) select codigo,turma,vagas,turno,horarios,salas,reserva,status,'0','nao',?,? from oferta_semestres where semestre=? or semestre='12'", array($semestre, $ano, $semestre));
		echo $query_insere_tabela_provisoria;
		$insere_tabela_provisoria=db_query($query_insere_tabela_provisoria, $query_insere_tabela_provisoria__p)  or die ("Problema de acesso ao banco");
		//
		if($insere_tabela_provisoria)
			{
			$insere_acusa_lista=db_query("insert into oferta_acusa_lista values(?,?,'nova')", array($semestre, $ano));
			}
		/*
		alteração criada em 20/04/2014 com o objetivo de incluir no programa do semestre as turmas de teoria do magistral das várias disciplinas
		com seus horarios proprios e modificar os horarios das turmas de exercicios.
		Dessa foirma, a tela de escolha dos professors ja contempla essas turmas. Essas alterações não aparecem na tela de impressão anterior. 
		*/
		muda_horarios_turmas_magistral($semestre,$ano);
		}
	

		list($query_oferta, $query_oferta__p) = array("select m.nome as disciplina, lo.* from ".$tabela_a." lo, disciplinas_mat m where lo.codigo=m.codigo and lo.status='fixa' and elimina='nao' union (select  m.nome as disciplina, lo.* from ".$tabela_a." lo, disciplinas_mat m, oferta_grupos_magistral_teoria og where lo.codigo=og.codigo_1 and og.codigo=m.codigo and lo.turma=og.turmas and lo.status='fixa' and elimina='nao' and lo.semestre=og.semestre and lo.ano=og.ano) order by disciplina,turma", array());
	$oferta=db_query($query_oferta, $query_oferta__p);
//disciplina | codigo | turma | vagas |  turno  |  horarios   | salas | reserva |  status | professor
        $cor_de_fundo="#FFFFFF";
        while ($registro=db_fetch_row($oferta))
                {
                if ($cor_de_fundo=="#FFFFFF") $cor_de_fundo="#D0D0D0"; else $cor_de_fundo="#FFFFFF";
?>
                <tr bgcolor="<? echo $cor_de_fundo;?>">
                <td><? echo $registro[0];?></td>
                <td><? echo $registro[1];?></td>
                <td><? echo $registro[2];?></td>
                <td><? echo $registro[3];?></td>
                <td><? echo $registro[4];?></td>
                <td><? echo $registro[5];?></td>
                <td><? echo $registro[6];?></td>
                <td><? echo $registro[7];?></td>
                <td><? echo $registro[8];?></td>
                </tr>
<?
                }

        // optativas
        list($query_oferta, $query_oferta__p) = array("select m.nome as disciplina, lo.* from ".$tabela_a." lo, disciplinas_mat m where lo.codigo=m.codigo  and lo.status='optativa' order by disciplina", array());
        $oferta=db_query($query_oferta, $query_oferta__p);
//disciplina | codigo | turma | vagas |  turno  |  horarios   | salas | reserva |  status | professor
  	$cor_de_fundo="#FFFFFF";
	$contador=0;
	while ($registro=db_fetch_row($oferta))
		{
	        if ($cor_de_fundo=="#FFFFFF") $cor_de_fundo="#D0D0D0"; else $cor_de_fundo="#FFFFFF";
		?>		
		<tr bgcolor="<? echo $cor_de_fundo;?>">
        	<td colspan=2><select name='optativas[]'>
			<?
			$query_disciplinas_mat[$contador]=db_query("select codigo,nome,creditos from disciplinas_mat where status='grad' order by nome", array());
			while ($registro2[$contador]=db_fetch_row($query_disciplinas_mat[$contador])) 
				{
				if ($registro2[$contador][0]==$registro[1]) $selected="selected"; else $selected="";?>
				<option value="<? echo $registro2[$contador][0];?>" <? echo $selected;?>><? echo $registro2[$contador][0]."/".$registro2[$contador][1];?></option>
				<?}
			?>
		</td>
        	<td><input type=text name='turma[]' value="<? echo $registro[2];?>" maxlength=1 size=1></td>
        	<td><input type=text name='vagas[]' value="<? echo $registro[3];?>" maxlength=2 size=1></td>
        	<td><input type=text name='turno[]' value="<? echo $registro[4];?>" maxlength=7 size=6></td>
        	<td><input type=text name='horarios[]' value="<? echo $registro[5];?>" maxlength=11 size=10></td>
        	<td><input type=text name='salas[]' value="<? echo $registro[6];?>"></td>
        	<td><input type=text name='reserva[]' value="<? echo $registro[7];?>"></td>
        	<td><input type=text name='status[]' value="<? echo $registro[8];?>" maxlength=8 size=7></td>
	        </tr>
<?			
		$contador=$contador+1;
		}
?>
	</table>
	</td></tr>
	<tr>
	<td align=center>
	<input type=submit name='registra2' value="Confirmar op&ccedil;&otilde;es">
	<input type=hidden name='registra1' value="ok">
	<input type=hidden name='tabela' value="<? echo $tabela_a;?>">
	</td>
	</tr>
	</form>
	</table>
	</BODY>
	</HTML>
<?
}


if (isset($_POST['registra2']))
{
$optativas=$_POST['optativas'];
$turma=$_POST['turma'];
$vagas=$_POST['vagas'];
$turno=$_POST['turno'];
$horarios=$_POST['horarios'];
$salas=$_POST['salas'];
$reserva=$_POST['reserva'];
$status=$_POST['status'];

// Nome de tabela nao pode ser parametro de SQL: so aceita a tabela que o
// proprio formulario envia (campo oculto 'tabela' = $tabela_a).
$tabelas_permitidas = array('oferta_lista_de_ofertas_nova');
$tabela = isset($_POST['tabela']) ? (string)$_POST['tabela'] : '';
if (!in_array($tabela, $tabelas_permitidas, true)) {
	die(error("Tabela invalida."));
}

for ($i=0;$i<count($optativas);$i++)
	{
	list($query_update, $query_update__p) = array("update ".$tabela." set turma=?, vagas=?, turno=?,horarios=?,salas=?,reserva=?, status=? where codigo=?", array($turma[$i], $vagas[$i], $turno[$i], $horarios[$i], $salas[$i], $reserva[$i], $status[$i], $optativas[$i]));
//	echo $query_update;
	$res=db_query($query_update, $query_update__p) or die("problemas com a conexao ao banco de dados");
	echo "Dados atualizados";
	}


}

db_close($idconn);
?>


