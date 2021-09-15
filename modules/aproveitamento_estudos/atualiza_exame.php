<?php
  include("head_aproveitamento.php");


function  atualiza_lista_exames($codigo,$periodo)
{
$mail="";
$query_mail=pg_query("select mail from mail where coduser in (select coduser from aproveitamento_prof_disc where periodo='".$periodo."' and codigo='".$codigo."')");
while ($mail0=pg_fetch_row($query_mail))
	{
	if ($mail=="") $mail.=$mail0[0]; else $mail.=",".$mail0[0];
	}

$texto="";
$query_alunos=pg_query("select nome, matricula from aproveitamento_entrada where id_entrada in (select id_entrada from aproveitamento_processos_resultados where discilpina_exame='".$codigo."' and confirmacao_aluno='".$periodo."')");
while ($alunos=pg_fetch_row($query_alunos))
        {
        $texto.="Nome: ".$alunos[0]."  Matricula: ".$alunos[1]."\r\n";
        }

$texto=wordwrap($texto,70);

// mensagem:
$subject = "Atualizacao da lista de alunos que realizarao exame especial na disciplina ".$codigo." no ".$periodo; 
$headers = "De: coordenacao de graduacao - SI";

$res_mail=mail($mail, $subject, $texto, $headers);
if ($res_mail) $devolve="mensagem enviada"; $devolve="problema no envio de mensagens";

return $devolve;
}

?>
<html>
  <header>

   <script language="javascript">
    function verif_touche(e)
        {
        if(e.keyCode)touche = e.keyCode;
        else touche = e.which;
        if((touche>=48 && touche <= 57) || (touche==8) || (touche==9)) return true;
        else return false;
        }
    </script>
    <script language=javascript src="function_js.js">
    </script>
    <script language=javascript src="formu.js">
    </script>
    <link type="text/css" rel="stylesheet" href="../../global/grafic.css">
    <meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
  </header>
  <body>
      <table class=big>

<?php
if(!isset($_POST['confirmar']))
{
if (!isset($_POST['incluir']) or (isset($_POST['incluir']) and empty($_POST['unbdoc']) and (empty($_POST['matricula_1']) or empty($_POST['matricula_2']))))
{
?>
  <form method="POST" name="formu" action="atualiza_exame.php"  onsubmit="return valid_form()">
      <tr>
        <td class=header align=center>
          <h1>Inclus&atilde;o de Processo de Aproveitamento de Estudos</h1>
        </td>
      </tr>
      <tr>
        <td align=center><table class=form><tr>
    <td colspan=4 class=header align=center>
      <b>Atualiza&ccedil;&atilde;o de dados de aproveitamento de estudos:</b></td>
          </tr>
	<tr><td><b>Procura por UnBDoc: </b></td><td><input type="text" name='unbdoc' size=6 onkeypress="return verif_touche(event);">/<select name='ano_unbdoc'>
<?php
        $ano_atual=date(Y);
        $ano_fim=$ano_atual+2;
	$ano_inicio=$ano_atual-2;
        for ($indice_ano=$ano_inicio;$indice_ano<$ano_fim+1;$indice_ano++)
                {
                if ($indice_ano==$ano_atual) $selected="selected"; else $selected="";
                echo "<option value='".$indice_ano."' ".$selected." >".$indice_ano."</option>";
                }
?>      
        </select></td>
</tr>
          <tr>
            <td><b>Procura por matr&iacute;cula do aluno: </b></td>
            <td><input type=text name='matricula_1' maxlength=2 size=1 onkeypress="return verif_touche(event);">/
<input type=text name='matricula_2' maxlength=10 size=6 onkeypress="return verif_touche(event);">
           </td>
        </tr> 
	</table>
	  </td>
	  </tr>
      <tr>
        <td align=center>
          <input type=submit name='incluir' value="Confirmar">
        </td>
      </form>
<?php
}

if ((isset($_POST['incluir']) and !empty($_POST['unbdoc'])) or (isset($_POST['incluir']) and !empty($_POST['matricula_1']) and !empty($_POST['matricula_2'])))
{
$procura="";

	if (!empty($_POST['unbdoc'])) 
		{
		$unbdoc=$_POST['unbdoc']."/".$_POST['ano_unbdoc'];
		$procura="unbdoc='".$unbdoc."'";
		}
	else
		{
		if (!empty($_POST['matricula_1']) and !empty($_POST['matricula_2'])) 
			{
			$matricula=$_POST['matricula_1']."/".$_POST['matricula_2'];
			if ($procura=="") $procura="matricula='".$matricula."'"; else $procura.=" or matricula='".$matricula."'";
			}
		}
	$recupera_dados_pessoais=pg_query("select * from aproveitamento_entrada where ".$procura) or die ("problema de conexao com o banco");
	$dados_pessoais=pg_fetch_array($recupera_dados_pessoais);
	$recupera_aproveitamento=pg_query("select * from aproveitamento_processos_resultados where id_entrada='".$dados_pessoais['id_entrada']."'");
//	$num_aproveitamento=pg_num_rows($recupera_aproveitamento);
	
//	$ano=date(Y);
//	$anop=$ano+1;

// inicio formulario	
?>
	<form method="POST" name="formu2" action="atualiza_exame.php"  onsubmit="return valid_form()">
      <tr>
        <td class=header align=center>
          <h1>Inclus&atilde;o de Processo de Aproveitamento de Estudos</h1>
        </td>
      </tr>
      <tr>
        <td align=center><table class=form><tr>
    <td colspan=4 class=header align=center>
      <b>Atualiza&ccedil;&atilde;o de dados de aproveitamento de estudos:</b></td>
          </tr>
        <tr><td><b>UnBDoc:</b> <?php echo $dados_pessoais['unbdoc'];?></td>
	</tr>
          <tr>
            <td><b>Aluno:</b> <?php echo $dados_pessoais['nome'];?></td><td> <b>Matr&iacute;cula:</b> <?php echo $dados_pessoais['matricula'];?></td>
	</tr>
	<tr>
<?php $fone=explode("_",$dados_pessoais['fone']);?>
	<td><b>Fone:</b> (<?php echo $fone[0];?>)<?php echo $fone[1];?></td><td> <b>E-mail:</b> <?php echo $dados_pessoais['mail'];?></td>


	</tr>
	<tr><td><br><br></td><td></td><td></td><td><td></td></tr>
		<tr><td align=center colspan=4><b>Dados do aproveitamento</b></td>
		<tr>
		<td><b>Tipo</b></td><td><b>discilpina</b></td><td><b>Resultado do exame</b></td><td><b>Per&iacute;odo confirmado</b></td>
		</tr>
		<tr>
                <td></td><td></td><td></td><td><b>para realiza&ccedil;&atilde;o do exame</b></td>
                </tr>
<?php
// id_entrada | tipo | discilpina_exame | topicos | resultado_exame | confirmacao_aluno 
	while ($registro=pg_fetch_row($recupera_aproveitamento))
		{
		 $confirmacao=explode("/",$registro[5]); 
		?>
		<tr><td><?php echo $registro[1];?></td><td><?php echo $registro[2];?></td>
		   <td><select name='resultado[<?php echo $registro[2];?>]'>
			<option value="" <?php if (empty($registro[4])) echo "selected";?>>--</option>
			<option value="aprovado" <?php if ($registro[4]=="aprovado") echo "selected";?>>Aprovado</option>
			<option value="reprovado" <?php if ($registro[4]=="reprovado") echo "selected";?>>Reprovado</option>
			<option value="nao compareceu" <?php if ($registro[4]=="nao compareceu") echo "selected";?>>N&atilde;o compareceu</option>
			</select></td>
		    <td><select name='confirmacao_semestre[<?php echo $registro[2];?>]'>
			<option value="" <?php if ($confirmacao[0]=="") echo "selected";?>>--</option>
			<option value="1" <?php if ($confirmacao[0]=="1") echo "selected";?>>1</option>
			<option value="2" <?php if ($confirmacao[0]=="2") echo "selected";?>>2</option>
			</select>/<select name='confirmacao_ano[<?php echo $registro[2];?>]'>
				  <option value="" <?php if ($confirmacao[1]=="") echo "selected";?>>--</option>
					<?php
					for ($ano=date(Y)-8;$ano<date(Y)+2;$ano++)
						{?>
						<option value="<?php echo $ano;?>" <?php if ($confirmacao[1]==$ano) echo "selected";?>><?php echo $ano;?></option>
						<?php }?>
				    </select></td>
		<?php
		}
?>
        </table>
	 </td>
          </tr>
      <tr>
        <td align=center>
	  <input type=hidden name='id_entrada' value="<?php echo $dados_pessoais['id_entrada'];?>">
          <input type=submit name='confirmar' value="Confirmar">
        </td>
      </form>
<?php
// fim formulario

}
?> 
      </table>
  </body>
</html>

<?php
}

if(isset($_POST['confirmar']))
{
$id_entrada=$_POST['id_entrada'];
$resultado=$_POST['resultado'];
$confirmacao_semestre=$_POST['confirmacao_semestre'];
$confirmacao_ano=$_POST['confirmacao_ano'];

$recupera_aproveitamento=pg_query("select * from aproveitamento_processos_resultados where id_entrada='".$id_entrada."'");
while ($registro=pg_fetch_row($recupera_aproveitamento))
                {
		if (($confirmacao_semestre[$registro[2]]=="") and ($confirmacao_ano[$registro[2]]=="")) $confirmacao=""; else $confirmacao=$confirmacao_semestre[$registro[2]]."/".$confirmacao_ano[$registro[2]];
		if ($registro[4]=="")
			{
			$query_update="update aproveitamento_processos_resultados set resultado_exame='".$resultado[$registro[2]]."' ,confirmacao_aluno='".$confirmacao."' where id_entrada='".$id_entrada."' and discilpina_exame='".$registro[2]."'";
	//		echo $query_update;
			$res_query=pg_query($query_update) or die ("problemas de conexao com o banco");
			if ($res_query) echo "dados atualizados com sucesso\r\n";
			}
		if ($confirmacao!="") {$atualiza=atualiza_lista_exames($registro[2],$confirmacao); echo $atualiza;}
		}
		
}

pg_close($idconn);
?>
