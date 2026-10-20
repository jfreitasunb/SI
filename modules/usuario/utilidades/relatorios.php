<?php
require("head_user.php");
//  include("funcoes_gera_arquivos.php");

/////////
  function cor($i)
	{
	if (is_int($i/2)) return ("#00BFFF"); else return("#FFFFFF"); 
	}
//
function relatorio($query_pesquisa,$dados_pessoais,$dados_profissionais,$dados_academicos,$orientacao)
{
	$result=db_query($query_pesquisa);
	$retorna=db_fetch_all($result);
	$linhas=db_num_rows($result);

	if (!empty($retorna)) 
	{
	$colunas=0;
	$cabecalho="";
	if (!empty($dados_pessoais) or 	$num_dados_pessoais==1) 
		{$colunas=$colunas+1; $cabecalho=$cabecalho."<td><b> Dados pessoais </b></td>";} 
		else {$colunas=1;$cabecalho=$cabecalho."<td><b> Nome </b></td>";}

	if (!empty($dados_profissionais) or $num_dados_profissionais==1) {$colunas=$colunas+1;  $cabecalho=$cabecalho."<td><b> Dados profissionais 
</b></td>";}

	if (!empty($dados_academicos) or $num_dados_academicos==1)
		{
		if (count($dados_academicos)>1 or (!in_array("orientandos",$dados_academicos) and count($dados_academicos)>=1))
			{
			$colunas=$colunas+1;
			$cabecalho=$cabecalho."<td><b> Dados acad&ecirc;micos </b></td>";
			}
		if (in_array("orientandos",$dados_academicos) or !empty($orientacao)) 
			{
			$colunas=$colunas+1;
			$cabecalho=$cabecalho."<td><b> Orientandos </b></td>";
			} 
		}
	?>
	<tr><td>
	<table border class=form align=center>
	<tr>
	<td colspan=<?php echo $colunas ?> class=header align=center>Resultado da pesquisa: foram encontrados  <?php echo $linhas ?> dados </td>
	</tr>
	<tr>
	<?php echo $cabecalho ?>
	</tr> 
	<?php
	$j=0;
	$cor_anterior="#00BFFF";
	for ($i=0; $i< $linhas; $i++)
		{
		$dados=$retorna[$i];
		if ($i>0) $usuario_anterior=$retorna[$i-1]['coduser']; else $usuario_anterior=$dados['coduser'];
// selecao da cor de fundo:
		if ($cor_anterior=="#00BFFF") $nova_cor="#FFFFFF"; else $nova_cor="#00BFFF";
		if (($dados['coduser']==$usuario_anterior) and $i>0) {$j=$j+1; $cor=$cor_anterior;} else {$j=0; $cor=$nova_cor; 
$cor_anterior=$nova_cor;}
//
	?>
		<tr bgcolor="<?php echo $cor ?>"> 
	<?php


		
//coduser |  name  | firstname | matricul | cpf | identity | phone_work | phone_home |  adresse | cp | city | is_actif | tipo_users
		$nome=mb_convert_encoding($dados['name'],"ISO-8859-1","UTF-8")." ".mb_convert_encoding($dados['firstname'],"ISO-8859-1","UTF-8");
		echo "<td align=\"left\" valign=\"top\"> <b>Nome:</b> $nome <br> \n"; 
		if (!empty($dados_pessoais))
		{
		if (in_array("endereco_res", $dados_pessoais))
			{$endereco=mb_convert_encoding($dados['adresse'],"ISO-8859-1","UTF-8").",".$dados['cp'].",".mb_convert_encoding($dados['city'],"ISO-8859-1","UTF-8");
			echo "<b>Endere&ccedil;o:</b> $endereco <br> \n"; 
			}
		if (in_array("e_mails", $dados_pessoais))
			{
			$emails="";
			$cod_usuario=$dados['coduser'];
			$select_e_mails="select mail from mail where mail.coduser=".db_quote($cod_usuario)."";
			$query_e_mails=db_query($select_e_mails);
			$e_mails=db_fetch_all($query_e_mails);
			for ($k=0; $k<db_num_rows($query_e_mails);$k++) 
				{$dado_mail=$e_mails[$k];
				if (!empty($emails)) $emails=$emails.",".$dado_mail['mail'];
				else $emails=$dado_mail['mail'];
				}
			echo "<b>E-mails:</b> $emails <br>\n"; 
			}
		if (in_array("telefones", $dados_pessoais)) {$phone=$dados['phone_home']; echo "<b> Fone: $phone </b> <br>\n";}
		if (in_array("identificacao", $dados_pessoais)) 
			{$identificacao="cpf:".$dados['cpf'].", ID:".$dados['identity']; 
			echo "<b> Identifica&ccedil;&atilde;o:</b> $identificacao <br>\n";
			}
		}
		echo "</td> \n"; 
////////////////////
		if (!empty($dados_profissionais))
		{echo "<td align=\"left\" valign=\"top\">";
		if (in_array("matricula", $dados_profissionais)) 
			{$matricula=$dados['matricula']; 
			echo "<b>Matr&iacute;cula: </b> $matricula <br>\n"; 
			}
		if (in_array("contrato", $dados_profissionais))
			{$contrato="sem vinculo";
			if (!empty($dados['contract_type'])) $contrato=$dados['contract_type'];
			if ($dados['tipo_users']=="student") $contrato="aluno";
			echo "<b>Contrato:</b> $contrato <br> \n"; 
			}
		if (in_array("nivel", $dados_profissionais))
			{$nivel="";
			if (!empty($dados['niveau_fonctionnel'])) $nivel=$dados['niveau_fonctionnel'];
			if (!empty($dados['formation'])) $nivel=$dados['formation'];
			echo "<b>N&iacute;vel:</b> $nivel <br> \n"; 
			}
		if (in_array("data_admissao", $dados_profissionais))
			{
			if (!empty($dados['contract_date'])) $data_admissao=explode("-",$dados['contract_date']);
			if (!empty($dados['coming_date'])) $data_admissao=explode("-",$dados['coming_date']);
			if (!empty($dados['date_begin'])) $data_admissao=explode("-",$dados['date_begin']);
			$data_adm=$data_admissao[2]."/".$data_admissao[1]."/".$data_admissao[0];
			echo "<b>Data de admiss&atilde;o:</b> $data_adm <br> \n"; 
			}
		if (in_array("data_desliga", $dados_profissionais))
			{
			if (!empty($dados['contract_end'])) $data_desliga=explode("-",$dados['contract_end']);
			if (!empty($dados['depart_date1'])) $data_desliga=explode("-",$dados['depart_date1']);
			if (!empty($dados['date_end'])) $data_desliga=explode("-",$dados['date_end']);
			$data_desl=$data_desliga[2]."/".$data_desliga[1]."/".$data_desliga[0];
			echo "<b>Data de desligamento:</b> $data_desl <br>\n"; 
			}
		if (in_array("situacao", $dados_profissionais))
			{$situacao="";
			if (!empty($dados['situacao'])) $situacao=$dados['situacao'];
			if (!empty($dados['status'])) $situacao=$dados['status'];
			echo "<b>Situa&ccedil;&atilde;o:</b> $situacao <br>\n"; 
			}
		echo "</td> \n"; 
		}
/////////////////////

		if (!empty($dados_academicos)) 
		{
		if (count($dados_academicos)>1 or (!in_array("orientandos",$dados_academicos) and count($dados_academicos)>=1)) echo "<td align=\"left\" valign=\"top\">";
		if (in_array("especialidade", $dados_academicos))
			{$especialidade="esp. indefinido";
			if (!empty($dados['area_atuacao'])) $especialidade=$dados['area_atuacao'];
			if (!empty($dados['speciality'])) $especialidade=$dados['speciality'];
			if (!empty($dados['area_visitor'])) $especialidade=$dados['area_visitor'];
			echo "<b>Especialidade:</b> $especialidade <br>\n"; 
			}
		if (in_array("tipo_bolsa", $dados_academicos))
			{$bolsista="sem bolsa";
			if (!empty($dados['bolsa_prof'])) $bolsista=$dados[' bolsa_prof'];
			if (!empty($dados['bolsa_aluno'])) $bolsista=$dados['bolsa_aluno'];
			echo "<b>Bolsista:</b> $bolsista <br>\n"; 
			}
		if (in_array("orientador", $dados_academicos))
			{$orientador="";
			if (!empty($dados['fim_credenciamento']) and !empty($dados['tipo_credenciamento'])) // incluido em 18/10/2018; se for o caso, usar: and date("d/m/Y")<=$dados['fim_credenciamento'] no if.
				{
				if($dados['tipo_credenciamento']=="ambos") $tipo_credenciamento="mestrado e no doutorado"; else $tipo_credenciamento=$dados['tipo_credenciamento'];
				$orientador=mb_convert_encoding($dados['name'],"ISO-8859-1","UTF-8")." 
".mb_convert_encoding($dados['firstname'],"ISO-8859-1","UTF-8")." credenciado para orientar no ".$tipo_credenciamento." at&eacute; ".$dados['fim_credenciamento'];
				} // fim incluido em 18/10/2018
			if (!empty($dados['orientador_name']) and !empty($dados['orientador_firstname'])) 
				{$orientador=mb_convert_encoding($dados['orientador_name'],"ISO-8859-1","UTF-8")." 
".mb_convert_encoding($dados['orientador_firstname'],"ISO-8859-1","UTF-8");
				}
			 else  if(!empty($dados['orientador_do_aluno']))
				{
				 $select_orientador="select name, firstname from users where 
coduser=".db_quote($dados['orientador_do_aluno'])."";
				 $query_orientateur=db_query($select_orientador);
				 $orientador_pg=db_fetch_array($query_orientateur);
				 if ($orientador_pg['name']=="root") $orientador="cpg"; else 
$orientador=mb_convert_encoding($orientador_pg['name'],"ISO-8859-1","UTF-8")." 
".mb_convert_encoding($orientador_pg['firstname'],"ISO-8859-1","UTF-8");
				}
			
			echo "<b>Orientador:</b> $orientador <br>\n"; 
			}
		if (in_array("orientandos", $dados_academicos) or !empty($orientacao))
			{
			echo "<td align=\"left\" valign=\"top\">\n"; 
			$condicao_orientacao="";
                        for ($k=0; $k<4 ;$k++)
                            {
                            if (!empty($orientacao[$k]))
                                      {
                                      if(!empty($condicao_orientacao)) $condicao_orientacao=$condicao_orientacao." or std.formation=".db_quote($orientacao[$k])."";
                                      else $condicao_orientacao="std.formation=".db_quote($orientacao[$k])."";
                                      }
                            }
			if (!empty($dados['orientateur']))
				{
				if (empty($condicao_orientacao)) 
				$select_orientando="select orientando.name, orientando.firstname, orientando.matricul, std.formation, std.status from users orientando, student std where std.orientateur=".db_quote($dados['coduser'])." and orientando.coduser=std.coduser order by std.formation, orientando.name";
				else 
				$select_orientando="select orientando.name, orientando.firstname, orientando.matricul, std.formation, std.status from 
users orientando, student std where std.orientateur=".db_quote($dados['coduser'])." and orientando.coduser=std.coduser and (".$condicao_orientacao.") order by 
std.formation,orientando.name";
				$query_orientando=db_query($select_orientando);
        	                $dados_orientandos=db_fetch_all($query_orientando);		
				$num_orientandos=db_num_rows($query_orientando);
				for ($k=0; $k< $num_orientandos; $k++)			
					{
					$dados_do_orientando=$dados_orientandos[$k];
					$orientando=mb_convert_encoding($dados_do_orientando['name'],"ISO-8859-1","UTF-8")."
".mb_convert_encoding($dados_do_orientando['firstname'],"ISO-8859-1","UTF-8");
					$matricula=$dados_do_orientando['matricul'];
					$formacao=$dados_do_orientando['formation'];
					$status_do_orientando=$dados_do_orientando['status'];
					echo "<b>Orientando:</b> $orientando <br>\n";
					echo "<b>matr&iacute;cula:</b> $matricula <br>\n";
					echo "<b>curso:</b> $formacao <br>\n";
					echo "<b>situa&ccedil;&atilde;o:</b> $status_do_orientando <br>\n"; 
					echo "<br>\n";
					}
				}
			echo "</td> \n"; 
			}
		echo "</td> \n"; 
		}

//
//orientando.name, orientando.firstname, orientando.matricul, std.formation
//////////////////////////


	?>
		</tr>
	<?php		
		}
	?>
	</table>
	<?php
	}
	else 
	{
	?>
		<table class=form align=center>
	        <tr>
	        <td class=header align=center colspan=1><h1>N&atilde;o h&aacute; dados dispon&iacute;veis para esta pesquisa</h1> </td></tr>
		</table>
	<?php
	}
	
}
////////////
?>
<html>
<header>
   <script language="javascript">
    <script language=javascript src="function_js.js">
    </script>
    <script language=javascript src="formu.js">
    </script>
    <link type="text/css" rel="stylesheet" href="../../global/grafic.css">
  </header>
<body>
<table class=big>
      <tr>
        <td class=header align=center>
          <h1>Pesquisa de usu&aacute;rios</h1>
        </td>
      </tr>
<?php
      ////////////////// VERIFICA SE O FORMULARIO ESTA PREENCHIDO ////////////////////////////////////////////////
if(!isset($_POST['enviar'])) // Se campos do formulario estiverem em branco, faça .....
	{
?>
<form name="relatorio_usuarios" method="POST" action="relatorios.php"><p>
<tr>
        <td align=center>
          <table class=form>
          <tr>
        <td><b> Nome do usu&aacute;rio :</b> </td><td><select size="1" name="usuario">
				<option value="todos">Todos os usu&aacute;rios</option>
				<?php                                   		 	// gera a lista de usuarios registrados
				$res = db_query("SELECT * FROM users where name<>'root' order by name");
				while($registro = db_fetch_row($res)) 				//enquanto houver registro escreva
					{
					$coduser = $registro[0];  		         	// primeira coluna da tabela usuario
					$titulo = $registro[1]." ".$registro[2];         	// segunda coluna da tabela usuario
					echo "<option value=\"$coduser\">$titulo</option>\n"; 	//Escreva o codigo e o nome do usuario
					}
				?>
				</select>
	</tr>
	<tr>
	<td colspan=3 class=header align=center><b>Sele&ccedil;&atilde;o de categoria profissional:</b></td>
	</tr>
	<tr>
	<td><b>Pesquisa de Funcion&aacute;rios</b></td><td><b> Pesquisa de Professores </b></td><td><b>Pesquisa de Alunos </b></td>
	</tr>
	<tr><td VALIGN="top"><INPUT TYPE=CHECKBOX NAME="tipo_funcionarios[]" value="dedicacao exclusiva">Dedicacao exclusiva<br>
		<INPUT TYPE=CHECKBOX NAME="tipo_funcionarios[]" value="prestador servico">Prestadores de servi&ccedil;os<br>
		<INPUT TYPE=CHECKBOX NAME="tipo_funcionarios[]" value="estagiario tec">Estagi&aacute;rio t&eacute;cnico<br>
		<INPUT TYPE=CHECKBOX NAME="tipo_funcionarios[]" value="estagiario grad">Estagi&aacute;rio de gradua&ccedil;&atilde;o
	    </td>
	    <td VALIGN="top"><INPUT TYPE=CHECKBOX NAME="tipo_professores[]" value="substituto">Professor substituto<br>
		<INPUT TYPE=CHECKBOX NAME="tipo_professores[]" value="assistente">Professor assistente<br>
		<INPUT TYPE=CHECKBOX NAME="tipo_professores[]" value="adjunto">Professor adjunto<br>
		<INPUT TYPE=CHECKBOX NAME="tipo_professores[]" value="associado">Professor associado<br>
		<INPUT TYPE=CHECKBOX NAME="tipo_professores[]" value="titular">Professor titular<br>
    		<INPUT TYPE=CHECKBOX NAME="tipo_professores[]" value="professor voluntario">Professor volunt&aacute;rio<br> <!corrigido em 18/10/2018>
		<INPUT TYPE=CHECKBOX NAME="tipo_professores[]" value="pesquisador associado">Pesquisador associado<br> <!corrigido em 18/10/2018>
		<INPUT TYPE=CHECKBOX NAME="tipo_professores[]" value="visitante">Professor visitante
	   </td>
           <td VALIGN="top"><INPUT TYPE=CHECKBOX NAME="tipo_alunos[]" value="graduacao">Aluno de gradua&ccedil;&atilde;o<br>
	       <INPUT TYPE=CHECKBOX NAME="tipo_alunos[]" value="extensao">Aluno de extens&atilde;o<br>
	       <INPUT TYPE=CHECKBOX NAME="tipo_alunos[]" value="especializacao">Aluno de especializa&ccedil;&atilde;o<br>  
	       <INPUT TYPE=CHECKBOX NAME="tipo_alunos[]" value="verao">Aluno da escola ver&atilde;o<br> 
	       <INPUT TYPE=CHECKBOX NAME="tipo_alunos[]" value="mestrado">Aluno de mestrado<br>  
	       <INPUT TYPE=CHECKBOX NAME="tipo_alunos[]" value="doutorado">Aluno de doutorado
	  </td> 
	</tr>
	<tr>
	<td colspan=3 class=header align=center><b>Sele&ccedil;&atilde;o de Tipo de dados a serem retornados:</b></td>
	</tr>
	<tr>
	<td><b>Dados pessoais:</b></td><td><b>Dados profissionais: </b></td><td><b>Dados acad&ecirc;micos:</b></td>
	</tr>
	<tr>
	<td VALIGN="top"><INPUT TYPE=CHECKBOX NAME="dados_pessoais[]" value="nome">Nome e sobrenome<br>
	    <INPUT TYPE=CHECKBOX NAME="dados_pessoais[]" value="endereco_res">Endere&ccedil;o residencial<br>
	    <INPUT TYPE=CHECKBOX NAME="dados_pessoais[]" value="e_mails">e-mails<br>
	    <INPUT TYPE=CHECKBOX NAME="dados_pessoais[]" value="telefones">Telefones<br>    
	    <INPUT TYPE=CHECKBOX NAME="dados_pessoais[]" value="identificacao">Documentos de identifica&ccedil;&atilde;o
	</td> 
	<td VALIGN="top"><INPUT TYPE=CHECKBOX NAME="dados_profissionais[]" value="matricula">Matr&iacute;cula<br>
	    <INPUT TYPE=CHECKBOX NAME="dados_profissionais[]" value="contrato">Tipo contratual<br>
            <INPUT TYPE=CHECKBOX NAME="dados_profissionais[]" value="nivel">N&iacute;vel<br>
	    <INPUT TYPE=CHECKBOX NAME="dados_profissionais[]" value="data_admissao">Data de admiss&atilde;o<br>
	    <INPUT TYPE=CHECKBOX NAME="dados_profissionais[]" value="data_desliga">Data de desligamento<br>
	    <INPUT TYPE=CHECKBOX NAME="dados_profissionais[]" value="situacao">Situa&ccedil;&atilde;o
	</td>
	<td VALIGN="top"><INPUT TYPE=CHECKBOX NAME="dados_academicos[]" value="especialidade">Especialidade<br>
	    <INPUT TYPE=CHECKBOX NAME="dados_academicos[]" value="tipo_bolsa">Tipo de bolsa<br>
            <INPUT TYPE=CHECKBOX NAME="dados_academicos[]" value="orientador">Professor orientador<br>
	    <INPUT TYPE=CHECKBOX NAME="dados_academicos[]" value="orientandos">Alunos Orientandos
	</td>
	</tr>
	<tr></tr><tr></tr>
	<tr>
	<td colspan=3 class=header align=center><b>Pesquisar por:</b></td>
	</tr>
	<tr>
	<td><b>Ano de admiss&atilde;o:</b> <input type="text" NAME="ano_admissao" size="3"> </td>
	<td><b>Ano de desligamento:</b> <input type="text" NAME="ano_saida" size="3"> </td>
	<td><b>Matr&iacute;cula:</b> <input type="text" NAME="matricula" size="6"> </td>
	</tr>
	<tr>
	<td><b>Telefone:</b> <input type="text" NAME="telefone" size="7"> </td>
	<td><b>Cidade:</b><input type="text" name="cidade" size="25"></td>
	<td></td>
	</tr>
	<tr>
	<td VALIGN="top"><b>Situa&ccedil;&atilde;o:</b> <br>
		<INPUT TYPE=CHECKBOX NAME="situacao[]" value="ativo">Matriculado <br>
		<INPUT TYPE=CHECKBOX NAME="situacao[]" value="aposentado">Professor aposentado<br>
		<INPUT TYPE=CHECKBOX NAME="situacao[]" value="redistribuido">Professor redistribuido<br>
		<INPUT TYPE=CHECKBOX NAME="situacao[]" value="titulado">Titulado<br>
		<INPUT TYPE=CHECKBOX NAME="situacao[]" value="desligado">Desligado<br>
		<INPUT TYPE=CHECKBOX NAME="situacao[]" value="abandono">Abandonou o curso
	</td>
	<td VALIGN="top"><b>Tipo contratual:</b> <br>
		<INPUT TYPE=CHECKBOX NAME="tipo_contrato[]" value="sem vinculo">Sem Vinculo <br>
		<INPUT TYPE=CHECKBOX NAME="tipo_contrato[]" value="dedicacao exclusiva">Dedicacao exclusiva<br>
		<INPUT TYPE=CHECKBOX NAME="tipo_contrato[]" value="prestador servico">Prestador de servico<br>
		<INPUT TYPE=CHECKBOX NAME="tipo_contrato[]" value="substituto gr40">Substituto GR40<br>
		<INPUT TYPE=CHECKBOX NAME="tipo_contrato[]" value="substituto dr40">Substituto DR40<br>
		<INPUT TYPE=CHECKBOX NAME="tipo_contrato[]" value="substituto ms20">Substituto MS20<br>
		<INPUT TYPE=CHECKBOX NAME="tipo_contrato[]" value="substituto ms40">Substituto MS40<br>
		<INPUT TYPE=CHECKBOX NAME="tipo_contrato[]" value="professor voluntario">Professor volunt&aacute;rio<br> <!corrigido em 18/10/2018>
		<INPUT TYPE=CHECKBOX NAME="tipo_contrato[]" value="pesquisador associado">Pesquisador associado<br> <!corrigido em 18/10/2018>
	</td>
	<td VALIGN="top"><b>Orienta&ccedil;&atilde;o:</b><br>
		<INPUT TYPE=CHECKBOX NAME="orientacao[]" value="doutorado">Orientador de doutorado<br>
                <INPUT TYPE=CHECKBOX NAME="orientacao[]" value="mestrado">Orientador de mestrado<br>
		<INPUT TYPE=CHECKBOX NAME="orientacao[]" value="especializacao">Orientador de especializa&ccedil;&atilde;o<br>
		<INPUT TYPE=CHECKBOX NAME="orientacao[]" value="graduacao">Orientador de gradua&ccedil;&atilde;o
	</td>
	</tr>
	<tr>
	<td VALIGN="top"><b>Pesquisa por &aacute;reas:</b><br> 
	       <INPUT TYPE=CHECKBOX NAME="area[]" value="esp. indefinido">Sem Especialidade<br>
	       <INPUT TYPE=CHECKBOX NAME="area[]" value="algebra">Algebra<br>
	       <INPUT TYPE=CHECKBOX NAME="area[]" value="teoria dos numeros">Teoria dos N&uacute;meros<br>
	       <INPUT TYPE=CHECKBOX NAME="area[]" value="analise">Analise<br>
	       <INPUT TYPE=CHECKBOX NAME="area[]" value="geometria">Geometria<br>
	       <INPUT TYPE=CHECKBOX NAME="area[]" value="fisica matematica">F&iacute;sica Matem&aacute;tica<br>
	       <INPUT TYPE=CHECKBOX NAME="area[]" value="computacao">Teoria da Computa&ccedil;&atilde;o<br>
	       <INPUT TYPE=CHECKBOX NAME="area[]" value="probabilidade">Probabilidade<br>
	       <INPUT TYPE=CHECKBOX NAME="area[]" value="historia matematica">Hist&oacute;ria da Matem&aacute;tica
	</td>
	<td VALIGN="top"><b>Pesquisa por orientandos:</b><br>
	    <INPUT TYPE=CHECKBOX NAME="orientando[]" value="pibic">Orientandos PIBIC<br>
	    <INPUT TYPE=CHECKBOX NAME="orientando[]" value="pibid">Orientandos PIBID<br>
	    <INPUT TYPE=CHECKBOX NAME="orientando[]" value="graduacao">Orientandos de gradua&ccedil;&atilde;o<br>
	    <INPUT TYPE=CHECKBOX NAME="orientando[]" value="extensao">Orientandos de extens&atilde;o<br>
	    <INPUT TYPE=CHECKBOX NAME="orientando[]" value="especializacao">Orientandos de especializa&ccedil;&atilde;o<br>
	    <INPUT TYPE=CHECKBOX NAME="orientando[]" value="mestrado">Orientandos de mestrado<br>  
	    <INPUT TYPE=CHECKBOX NAME="orientando[]" value="doutorado">Orientandos de doutorado  
	</td>
	<td VALIGN="top"><b>Pesquisa por tipo de bolsa:</b><br>
		<INPUT TYPE=CHECKBOX NAME="bolsa[]" value="sem bolsa">Sem Bolsa<br>    
		<INPUT TYPE=CHECKBOX NAME="bolsa[]" value="cnpq">Bolsistas CNPq<br>    
		<INPUT TYPE=CHECKBOX NAME="bolsa[]" value="capes">Bolsistas CAPES<br>
		<INPUT TYPE=CHECKBOX NAME="bolsa[]" value="femat">Bolsistas FEMAT<br>        
		<INPUT TYPE=CHECKBOX NAME="bolsa[]" value="fap">Bolsistas FAP<br>    
		<INPUT TYPE=CHECKBOX NAME="bolsa[]" value="monitoria">Monitoria<br>
		<INPUT TYPE=CHECKBOX NAME="bolsa[]" value="outros">Outros
	</td> 
	</tr>
	</table><br>
	<input type="submit" value="Pesquisar" name="enviar"> <input type="reset" value="Limpar!">
	</form>
	</body>
	</html>
<?php
	}
	////////////////////////////////////////////////////////////////////////////////////////////////////////////////////// 
else	////////////////// Pesquisa do pessoal ///////////////////////////////////////////////////////////////////////////
{	//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	$usuario=$_POST['usuario']; 				// host 
	$tipo_funcionarios=$_POST['tipo_funcionarios'];      	// de 0 a 3: prestador servico, estagiario tec, estagiario grad 
	 							// busca na tabela fonctionnaire.contract_type
	$tipo_professores=$_POST['tipo_professores']; 		// de 0 a 5: substituto,assistente,adjunto,associado,titular,visitante
								// busca na tabela fonctionnaire.statut e na tabela profs.niveau_fonctionnel e visitor
	$tipo_alunos=$_POST['tipo_alunos']; 			// de 0 a 5: graduacao,extensao,especializacao,verao,mestrado,doutorado
								// busca na tabela student.formation
	$dados_pessoais=$_POST['dados_pessoais']; 		// de 0 a 4: nome,endereco_res,e_mails,telefones,identificacao
								// busca na tabela users
	$dados_profissionais=$_POST['dados_profissionais'];	// de 0 a 5:
								// matricula,contrato,nivel,data_admissao,data_desliga,situacao
								// NAS TABELAS FONCTIONNAIRE, VISITOR E STUDENT
	$dados_academicos=$_POST['dados_academicos']; 		// de 0 a 3: especialidade,tipo_bolsa,orientador,orientandos
								//tabelas student e profs
	$ano_admissao=$_POST['ano_admissao'];			// tabelas student, visitor e fonctionnaire
	$ano_saida=$_POST['ano_saida'];				// tabelas student, visitor e fonctionnaire
	$matricula=$_POST['matricula'];				// tabelas student e users
	$telefone=$_POST['telefone'];				// tabela users
	$cidade=$_POST['cidade'];				// tabela users

	$situacao=$_POST['situacao']; 				// de 0 a 5: ativo,aposentado,redistribuido,titulado,desligado,abandono
								//tabelas profs e student
	$tipo_contrato=$_POST['tipo_contrato']; // de 0 a 6:
				//sem vinculo,dedicacao exclusiva,prestador servico,substituto gr40,substituto dr40,substituto ms20,substituto ms40
								// tabela fonctionnaire (sem vinculo só em visitor)
	$orientacao=$_POST['orientacao'];			// de 0 a 3: orienta_d,orienta_m,orienta_e,orienta_g
								// pesquisa na tabela student em rela. a a tabela profs.
	$area=$_POST['area'];			// de 0 a 8:
				// indefinido,algebra,teoria_numeros,analise,geometria,fisica_matematica,computacao,probabilidade,historia_matematica
								// tabelas student e profs
	$orientando=$_POST['orientando']; 	// de 0 a 6: pibic,pibid,graduacao,extensao,especializacao,mestrado,doutorado
								// pesquisa na tabela student em rela. a a tabela profs.
	$bolsa=$_POST['bolsa']; 		// de 0 a 6: sem_bolsa,cnpq,capes,femat,fap,monitoria,outros
								// tabelas student e profs.





// users: 	   coduser |  name  | firstname | matricul | cpf | identity | phone_work | phone_home |  adresse | cp | city | is_actif | tipo_users 
// fonctionnaire:  contract_date |         contract_type          |  statut   | contract_end
// profs: 	   orientateur |    area_atuacao     | niveau_fonctionnel | bolsista  |   situacao
// visitor: 	   date_begin |  date_end  | tipo_visitor |  area_atuacao 
// student:  	   coming_date | depart_date1 |   speciality    | orientateur | status | formation | bolsista  | matricul

// tipo_users=visitor, administrativo, professor, student.
// mail:   mail             | coduser 

// este query retorna uma array com todos os dados necessários de todas as tabelas usadas. 

//$dado_select="users.coduser,users.name,users.firstname,users.matricul as matricula,users.cpf,users.identity,users.phone_work,users.phone_home,users.adresse,users.cp,users.city,users.is_actif,users.tipo_users,fonctionnaire.contract_date,fonctionnaire.contract_type,fonctionnaire.statut,fonctionnaire.contract_end,profs.orientateur,profs.area_atuacao,profs.niveau_fonctionnel,profs.bolsista 
//as bolsa_prof,profs.situacao as situacao_prof,visitor.date_begin,visitor.date_end,visitor.tipo_visitor,visitor.area_atuacao as area_visitor,student.coming_date,student.depart_date1,student.speciality,student.orientateur as orientador_do_aluno,student.status,student.formation,student.bolsista as bolsa_aluno,student.matricul as matricula_aluno"; 
//	$tabela_select="(((users left outer join fonctionnaire on users.coduser=fonctionnaire.coduser) left outer join profs on users.coduser=profs.coduser) left outer join visitor on users.coduser=visitor.coduser) left outer join student on users.coduser=student.coduser";
$dado_select="users.coduser,users.name,users.firstname,users.matricul as matricula,users.cpf,users.identity,users.phone_work,users.phone_home,users.adresse,users.cp,users.city,users.is_actif,users.tipo_users,fonctionnaire.contract_date,fonctionnaire.contract_type,fonctionnaire.statut,fonctionnaire.contract_end,profs.orientateur,profs.area_atuacao,profs.niveau_fonctionnel,profs.bolsista 
as bolsa_prof,profs.situacao as situacao_prof,visitor.date_begin,visitor.date_end,visitor.tipo_visitor,visitor.area_atuacao as area_visitor,student.coming_date,student.depart_date1,student.speciality,student.orientateur as orientador_do_aluno,student.status,student.formation,student.bolsista as bolsa_aluno,student.matricul as matricula_aluno, FORMAT(orientateur.date_fin,'dd/MM/yyyy') as fim_credenciamento, orientateur.orientacao as tipo_credenciamento"; // corrigido em 18/10/2018
	$tabela_select="((((users left outer join fonctionnaire on users.coduser=fonctionnaire.coduser) left outer join profs on users.coduser=profs.coduser) left outer join visitor on users.coduser=visitor.coduser) left outer join student on users.coduser=student.coduser) left outer join orientateur on users.coduser=orientateur.coduser";// corrigido em 18/10/2018
	$condicao_select=" users.coduser<>'0'";
	if ($usuario!="todos") $condicao_select="users.coduser=".db_quote($usuario)."";	

//	$ordenacao="name ASC, tipo_users, formation";


// pesquisa por ano de admissao
	if (!empty($_POST['ano_admissao'])) 
		{
		$num_dados_profissionais=1;
		if (!empty($condicao_select)) 
			$condicao_select=$condicao_select." and ( contract_date like ".db_quote($_POST['ano_admissao'].'%')." or date_begin like ".db_quote($_POST['ano_admissao'].'%')." or coming_date like ".db_quote($_POST['ano_admissao'].'%').")"; 
		else 
			$condicao_select=" (contract_date like ".db_quote($_POST['ano_admissao'].'%')." or date_begin like ".db_quote($_POST['ano_admissao'].'%')." or coming_date like ".db_quote($_POST['ano_admissao'].'%').")";
		}

// pesquisa por ano de saida
	if (!empty($_POST['ano_saida'])) 
		{
		$num_dados_profissionais=1;
		if (!empty($condicao_select)) 
			$condicao_select=$condicao_select." and (contract_end like ".db_quote($_POST['ano_saida'].'%')." or date_end like ".db_quote($_POST['ano_saida'].'%')." or depart_date1 like ".db_quote($_POST['ano_saida'].'%').")"; 
		else 
			$condicao_select=" (contract_end like ".db_quote($_POST['ano_saida'].'%')." or date_end like ".db_quote($_POST['ano_saida'].'%')." or depart_date1 like ".db_quote($_POST['ano_saida'].'%').")";
		}

// pesquisa por matricula			
	if (!empty($_POST['matricula'])) 
		{
		$num_dados_profissionais=1;
		if (!empty($condicao_select)) 
			$condicao_select=$condicao_select." and (users.matricul=".db_quote($_POST['matricula'])." or student.matricul=".db_quote($_POST['matricula']).")";
		 else 
			$condicao_select=" (users.matricul=".db_quote($_POST['matricula'])." or student.matricul=".db_quote($_POST['matricula']).")";
		}

// pesquisa por telefone
	if (!empty($_POST['telefone'])) 
		{
		$num_dados_pessoais=1;
		if (!empty($condicao_select)) 
			$condicao_select=$condicao_select." and users.phone_home=".db_quote($_POST['telefone']).""; 
		else 
			$condicao_select=" users.phone_home=".db_quote($_POST['telefone'])."";	
		}	

// pesquisa por cidade	
	if (!empty($_POST['cidade'])) 
		{
		$num_dados_pessoais=1;
		if (!empty($condicao_select)) 
			$condicao_select=$condicao_select." and users.city=".db_quote($_POST['cidade']).""; 
		else 
			$condicao_select=" users.city=".db_quote($_POST['cidade'])."";	
		}		
	
// pesquisa por situacao
	$condicao_situacao="";
	for ($i=0; $i< 6; $i++)
		{
		if (!empty($situacao[$i])) 
			{
			$num_dados_profissionais=1;
			if (!empty($condicao_situacao)) $condicao_situacao=$condicao_situacao." or profs.situacao=".db_quote($situacao[$i])." or student.status=".db_quote($situacao[$i]).""; 
			else $condicao_situacao=" profs.situacao=".db_quote($situacao[$i])." or student.status=".db_quote($situacao[$i])."";
			}
		}
	if (!empty($condicao_situacao)) 
		{if (!empty($condicao_select)) $condicao_select=$condicao_select." and (".$condicao_situacao.")"; 
		else $condicao_select=" (".$condicao_situacao.")";
		}

// pesquisa por tipo de contrato
	$condicao_tipo_contrato="";
	for ($i=0; $i< 9; $i++) //for ($i=0; $i< 7; $i++) corrigido em 18/10/2018
		{
		if (!empty($tipo_contrato[$i])) 
			{
			$num_dados_profissionais=1;
			if (!empty($condicao_tipo_contrato)) $condicao_tipo_contrato=$condicao_tipo_contrato." or fonctionnaire.contract_type=".db_quote($tipo_contrato[$i])." or visitor.tipo_visitor=".db_quote($tipo_contrato[$i]).""; 
			else $condicao_tipo_contrato=" fonctionnaire.contract_type=".db_quote($tipo_contrato[$i])." or visitor.tipo_visitor=".db_quote($tipo_contrato[$i])."";
			}
		}
	if (!empty($condicao_tipo_contrato)) 
		{if (!empty($condicao_select)) $condicao_select=$condicao_select." and (".$condicao_tipo_contrato.")"; 
		else $condicao_select=" (".$condicao_tipo_contrato.")";
		}

// pesquisa por orientador
//	if (!empty($orientacao)) 
//		{
//		$dado_select=$dado_select.",orientando.name as nome_orientando, orientando.firstname as sobrenome_orientando, orientando.matricul as 
//matricula_orientando, std.formation as formacao_orientando";
//		$tabela_select=$tabela_select.", users orientando, student std ";
//		$condicao_orientacao="";
//		for ($i=0; $i< 4; $i++)
//			{
//			if (!empty($orientacao[$i])) 
//				{if (!empty($condicao_orientacao)) $condicao_orientacao=$condicao_orientacao." or (orientando.coduser=std.coduser and 
//std.orientateur=users.coduser and std.formation=".db_quote($orientacao[$i]).")"; 
//				else $condicao_orientacao="(orientando.coduser=std.coduser and std.orientateur=users.coduser and 
//std.formation=".db_quote($orientacao[$i]).")";
//				}
//			}
//		if (!empty($condicao_select)) $condicao_select=$condicao_select." and (".$condicao_orientacao.")"; 
//		else $condicao_select=" (".$condicao_orientacao.")";
//		}
		
// pesquisa por area
	$condicao_area="";
	for ($i=0; $i< 9; $i++)
		{
		if (!empty($area[$i])) 
			{
			$num_dados_academicos=1;
			if (!empty($condicao_area)) $condicao_area=$condicao_area." or student.speciality=".db_quote($area[$i])." or profs.area_atuacao=".db_quote($area[$i])." or visitor.area_atuacao=".db_quote($area[$i]).""; 
			else $condicao_area=" student.speciality=".db_quote($area[$i])." or profs.area_atuacao=".db_quote($area[$i])." or visitor.area_atuacao=".db_quote($area[$i])."";
			}
		}
	if (!empty($condicao_area)) 
		{if (!empty($condicao_select)) $condicao_select=$condicao_select." and (".$condicao_area.")"; 
		else $condicao_select=" (".$condicao_area.")";
		}

// pesquisa por orientando
	if (!empty($orientando)) 
		{
		$num_dados_academicos=1;
		$dado_select=$dado_select.",orientador.name as orientador_name, orientador.firstname as orientador_firstname ";
		$tabela_select=" users orientador, profs prof_orientador,".$tabela_select;
		$condicao_orientando="";
		for ($i=0; $i< 7; $i++)
			{
			if (!empty($orientando[$i])) 
				{if (!empty($condicao_orientando)) $condicao_orientando=$condicao_orientando." or (student.formation=".db_quote($orientando[$i])." and orientador.coduser=student.orientateur and prof_orientador.coduser=student.orientateur and prof_orientador.orientateur='true')"; 
				else $condicao_orientando=" (student.formation=".db_quote($orientando[$i])." and orientador.coduser=student.orientateur and prof_orientador.coduser=student.orientateur and prof_orientador.orientateur='true')";
				}
			}
		if (!empty($condicao_orientando)) 
			{if (!empty($condicao_select)) $condicao_select=$condicao_select." and (".$condicao_orientando.")"; 
			else $condicao_select=" (".$condicao_orientando.")";
			}
		}


// pesquisa por bolsa
	$condicao_bolsa="";
	for ($i=0; $i< 7; $i++)
		{
		if (!empty($bolsa[$i])) 
			{
			$num_dados_academicos=1;
			if (!empty($condicao_bolsa)) $condicao_bolsa=$condicao_bolsa." or (profs.bolsista=".db_quote($bolsa[$i])." or student.bolsista=".db_quote($bolsa[$i]).")"; 
			else $condicao_bolsa="(profs.bolsista=".db_quote($bolsa[$i])." or student.bolsista=".db_quote($bolsa[$i]).")";
			}
		}
	if (!empty($condicao_bolsa)) 
		{if (!empty($condicao_select)) $condicao_select=$condicao_select." and (".$condicao_bolsa.")"; 
		else $condicao_select=" (".$condicao_bolsa.")";
		}


// pesquisa de funcionarios
	$condicao_tipo_funcionarios="";
	for ($i=0; $i< 4; $i++)
		{
		if (!empty($tipo_funcionarios[$i])) 
			{
			if (!empty($condicao_tipo_funcionarios)) $condicao_tipo_funcionarios=$condicao_tipo_funcionarios." or (fonctionnaire.statut='administrativo' and  fonctionnaire.contract_type=".db_quote($tipo_funcionarios[$i]).")"; 
			else $condicao_tipo_funcionarios=" (fonctionnaire.statut='administrativo' and  fonctionnaire.contract_type=".db_quote($tipo_funcionarios[$i]).")";
			}
		}
	if (!empty($condicao_tipo_funcionarios)) 
		{if (!empty($condicao_select)) $condicao_select=$condicao_select." and (".$condicao_tipo_funcionarios.")"; 
		else $condicao_select=" (".$condicao_tipo_funcionarios.")";
		}

// pesquisa de professores: de 0 a 5: substituto,assistente,adjunto,associado,titular,visitante
	if(!empty($tipo_professores))
	{
	$condicao_tipo_professores="";
	if (in_array("substituto", $tipo_professores)) 
			{if (!empty($condicao_tipo_professores)) $condicao_tipo_professores=$condicao_tipo_professores." or 
(fonctionnaire.statut='professor' and  fonctionnaire.contract_type like 'substituto%')"; 
			else $condicao_tipo_professores=" (fonctionnaire.statut='professor' and  fonctionnaire.contract_type like 'substituto%')";
			}
	if (in_array("assistente", $tipo_professores)) 
			{if (!empty($condicao_tipo_professores)) $condicao_tipo_professores=$condicao_tipo_professores." or 
(fonctionnaire.statut='professor' and profs.niveau_fonctionnel like 'assistente%')"; 
			else $condicao_tipo_professores=" (fonctionnaire.statut='professor' and profs.niveau_fonctionnel like 'assistente%')";
			}
	if (in_array("adjunto", $tipo_professores)) 
			{if (!empty($condicao_tipo_professores)) $condicao_tipo_professores=$condicao_tipo_professores." or 
(fonctionnaire.statut='professor' and profs.niveau_fonctionnel like 'adjunto%')"; 
			else $condicao_tipo_professores=" (fonctionnaire.statut='professor' and profs.niveau_fonctionnel like 'adjunto%')";
			}
	if (in_array("associado", $tipo_professores)) 
			{if (!empty($condicao_tipo_professores)) $condicao_tipo_professores=$condicao_tipo_professores." or 
(fonctionnaire.statut='professor' and profs.niveau_fonctionnel like 'associado%')"; 
			else $condicao_tipo_professores=" (fonctionnaire.statut='professor' and profs.niveau_fonctionnel like 'associado%')";
			}
	if (in_array("titular", $tipo_professores)) 
			{if (!empty($condicao_tipo_professores)) $condicao_tipo_professores=$condicao_tipo_professores." or 
(fonctionnaire.statut='professor' and profs.niveau_fonctionnel like 'titular')"; 
			else $condicao_tipo_professores=" (fonctionnaire.statut='professor' and profs.niveau_fonctionnel like 'titular')";
			}
	if (in_array("pesquisador associado", $tipo_professores)) 
			{if (!empty($condicao_tipo_professores)) $condicao_tipo_professores=$condicao_tipo_professores." or 
(fonctionnaire.statut='professor' and fonctionnaire.contract_type='pesquisador associado')"; 
			else $condicao_tipo_professores=" (fonctionnaire.statut='professor' and fonctionnaire.contract_type='pesquisador associado')";
			} // acrescentado em 18/10/2018
	if (in_array("professor voluntario", $tipo_professores)) 
			{if (!empty($condicao_tipo_professores)) $condicao_tipo_professores=$condicao_tipo_professores." or 
(fonctionnaire.statut='professor' and fonctionnaire.contract_type='professor voluntario')"; 
			else $condicao_tipo_professores=" (fonctionnaire.statut='professor' and fonctionnaire.contract_type='professor voluntario')";
			} // acrescentado em 18/10/2018
	if (in_array("visitante", $tipo_professores)) 
			{if (!empty($condicao_tipo_professores)) $condicao_tipo_professores=$condicao_tipo_professores." or (users.tipo_users='visitor')"; 
			else $condicao_tipo_professores=" (users.tipo_users='visitor')";
			}
	if (!empty($condicao_tipo_professores)) 
		{if (!empty($condicao_select)) $condicao_select=$condicao_select." and (".$condicao_tipo_professores.")"; 
		else $condicao_select=" (".$condicao_tipo_professores.")";
		}
	}

// pesquisa de aluno
	$condicao_tipo_alunos="";
	for ($i=0; $i< 6; $i++)
		{
		if (!empty($tipo_alunos[$i])) 
			{if (!empty($condicao_tipo_alunos)) $condicao_tipo_alunos=$condicao_tipo_alunos." or (users.tipo_users='student' and student.formation=".db_quote($tipo_alunos[$i]).")"; 
			else $condicao_tipo_alunos=" (users.tipo_users='student' and student.formation=".db_quote($tipo_alunos[$i]).")";
			}
		}
	if (!empty($condicao_tipo_alunos)) 
		{if (!empty($condicao_select)) $condicao_select=$condicao_select." and (".$condicao_tipo_alunos.")"; 
		else $condicao_select=" (".$condicao_tipo_alunos.")";
		}

	if (!empty($condicao_select)) $query_pesquisa="select ".$dado_select." from ".$tabela_select." where ".$condicao_select." order by users.name"; 
	else $query_pesquisa="select ".$dado_select." from ".$tabela_select." order by users.name";


///////////////////////////////////

//	$res_pesquisa=db_query($query_pesquisa);
//	$linhas_pesquisa=db_num_rows($res_pesquisa);
//	$data_pesquisa=db_fetch_array($res_pesquisa,0);

// escrever os dados ordenados!!
//
//		<html>
//		  <header>
//		    <link type="text/css" rel="stylesheet" href="../../global/grafic.css">
//		    <script language="JavaScript" src="navig_js.js"></script>
//		    <script language="javascript" src="formu.js"></script>
//		   </header>
//		  <body>
//
//		  <table class=big>
//		  <tr>
//
//		      <td class=header align=center>
//      	<h1>Relat&oacute;rio de pesquisa</h1>
//      		</td>
//		</tr>
		relatorio($query_pesquisa,$dados_pessoais,$dados_profissionais,$dados_academicos,$orientacao);
?> 		
		<br> 
		</table>
		</body>
		</html>
<?php
}
db_close($idconn);
?>
