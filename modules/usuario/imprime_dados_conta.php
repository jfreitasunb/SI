<?php
require("head_user.php");
require_once("../../global/latex_pdf.php");

$coduser=$_POST['coduser'];
$senha=$_POST['senha'];
//$senha="TESTE";

//function imprime_carta_sistema_informatica($coduser,$senha)
//{ 
/*
Dados que queremos:

$LATEX_DATAABERTURA: data de abertura hoje
$LATEX_NOME: nome do usuario
$LATEX_SOBRENOME: sobrenome do usuario
$LATEX_VINCULO: vinculo do usuario com o mat
$LATEX_MATRICULA: matricula do usuario

$LATEX_DATAENCERRAMENTO: data de encerramento da conta do usuario

$LATEX_LOGIN: login do usuario
$LATEX_SENHA: senha do usuario
$LATEX_QUOTAIMPRESSAO: quota mensal de impressoa do usuario
$LATEX_QUOTAMAIL: quota de  do usuario
$LATEX_QUOTADISCO: quota de disco
$LATEX_MAIL: mail institucional do usuario

*/


//busca dos dados pessoais e da conta
$resultado_pessoais=db_query("SELECT \nus.name as nome,us.firstname as sobrenome,us.matricul as matricula,ux.login as login,ux.cota_disco as cota_disco,ux.cota_mail as cota_mail,ux.cota_impressao as cota_impressao,ux.tabela_user \nas tabela_user FROM users us, unix ux WHERE \nus.coduser=? and ux.coduser=us.coduser", array($coduser)) or die("Nao foi possivel executar a operacao. Contacte a Coordenacao de Informatica.");
	$dados_pessoais= db_fetch_array($resultado_pessoais);

$seds[LATEX_NOME]=$dados_pessoais['nome'];
$seds[LATEX_SOBRENOME]=$dados_pessoais['sobrenome'];
$seds[LATEX_MATRICULA]=$dados_pessoais['matricula'];
$seds[LATEX_LOGIN]=$dados_pessoais['login'];
$seds[LATEX_SENHA]=$senha;
$seds[LATEX_QUOTAIMPRESSAO]=$dados_pessoais['cota_impressao'];
$seds[LATEX_QUOTAMAIL]=$dados_pessoais['cota_mail'];
$seds[LATEX_QUOTADISCO]=$dados_pessoais['cota_disco'];


//busca dos dados do contrato.


if ($dados_pessoais['tabela_user']=="visitor") 
	{
	$resultado_contrato=db_query("SELECT to_char(date_begin, 'DD/MM/YYYY') as data_abertura,to_char(date_end, 'DD/MM/YYYY') as data_encerramento, tipo_visitor FROM visitor WHERE coduser=?", array($coduser)) or die("Nao foi possivel executar a operacao. Contacte a Coordenacao de Informatica.");
	$dados_contrato= db_fetch_array($resultado_contrato);
	$data_abertura=$dados_contrato['data_abertura'];
	$data_encerramento=$dados_contrato['data_encerramento'];
	$vinculo=$dados_contrato['tipo_visitor'];
	}
if ($dados_pessoais['tabela_user']=="student")
	{
	$resultado_contrato=db_query("SELECT to_char(coming_date, 'DD/MM/YYYY') as data_abertura,to_char(depart_date1,'DD/MM/YYYY') as data_encerramento, formation FROM student WHERE coduser=?", array($coduser)) or die("Nao foi possivel executar a operacao. Contacte a Coordenacao de Informatica.");
	$dados_contrato= db_fetch_array($resultado_contrato);
	$data_abertura=$dados_contrato['data_abertura'];
	$data_encerramento=$dados_contrato['data_encerramento'];
	$vinculo="Aluno de ".$dados_contrato['formation'];
	}
if ($dados_pessoais['tabela_user']=="fonctionnaire")
	{
	$resultado_contrato=db_query("SELECT to_char(contract_date, 'DD/MM/YYYY') as data_abertura,to_char(contract_end, 'DD/MM/YYYY') as data_encerramento, statut, contract_type FROM fonctionnaire WHERE coduser=?", array($coduser)) or die("Nao foi possivel executar a operacao. Contacte a Coordenacao de Informatica.");
	$dados_contrato= db_fetch_array($resultado_contrato);
	$data_abertura=$dados_contrato['data_abertura'];
	$data_encerramento=$dados_contrato['data_encerramento'];
	$vinculo=$dados_contrato['statut']."-".$dados_contrato['contract_type'];
	}

	$seds[LATEX_DATAABERTURA]=$data_abertura;
	$seds[LATEX_DATAENCERRAMENTO]=$data_encerramento;
	$seds[LATEX_VINCULO]=$vinculo;


//busca do alias
	$resultado_alias=db_query("SELECT alias FROM aliases WHERE coduser=?", array($coduser)) or die("Nao foi possivel executar a operacao. Contacte a Coordenacao de Informatica.");
	$dados_alias= db_fetch_array($resultado_alias);

	$seds[LATEX_MAIL]=$dados_alias['alias']."@mat.unb.br";

//busca outros mails
	$resultado_mails=db_query("SELECT mail FROM mail WHERE coduser=? and mail not like '%mat.unb.br'", array($coduser)) or die ("Nao foi possivel executar a operacao. Contacte a Coordenacao de Informatica.");
        $dados_mails= db_fetch_all($resultado_mails);
	$num_mails=db_num_rows($resultado_mails);
	if ($num_mails==0) $seds[LATEX_OUTROSMAILS]="favor cadastrar outro mail"; 
	else 
 	     {
	     	for ($i=0;$i<$num_mails; $i++) 
		    {
		    if ($i==0) $seds[LATEX_OUTROSMAILS]=$dados_mails[0]['mail']; else $seds[LATEX_OUTROSMAILS].=", ".$dados_mails[$i]['mail'];
		    }
	     }


//###########################################################################################
/*
        $seds[LATEXDESTINO]=mb_convert_encoding($palavra_destino[0],"ISO-8859-1","UTF-8");
        $seds[LATEXVIA]=mb_convert_encoding($coluna[11],"ISO-8859-1","UTF-8");
        $seds[LATEXCOMCOPIA]=mb_convert_encoding($coluna[15],"ISO-8859-1","UTF-8");
        $seds[LATEXASSUNTO]=mb_convert_encoding($coluna[7],"ISO-8859-1","UTF-8");
        $seds[LATEXANEXO]=mb_convert_encoding($coluna[8],"ISO-8859-1","UTF-8");
        $seds[LATEXVOCATIVO]=mb_convert_encoding($coluna[10],"ISO-8859-1","UTF-8");
        $seds[LATEXMENSAGEM]=addslashes(mb_convert_encoding($coluna[4],"ISO-8859-1","UTF-8"));
        $seds[LATEXDESFECHO]=mb_convert_encoding($coluna[5],"ISO-8859-1","UTF-8");
       	$seds[LATEXNASSINATURA]=$palavra_assinatura[3]." ".mb_convert_encoding($palavra_assinatura[0]." ".$palavra_assinatura[1],"ISO-8859-1","UTF-8");
	$seds[LATEXCASSINATURA]=mb_convert_encoding($palavra_assinatura[2],"ISO-8859-1","UTF-8");
*/
        $arquivo="carta.tex";

        // Os campos da carta são texto puro (nome, login, senha...): escapa para LaTeX.
        foreach ($seds as $colchete => $valor)
		{
		$seds[$colchete]=str_replace("sem_vinculo",'sem vínculo',$seds[$colchete]);
		$seds[$colchete]=str_replace("cao",'ção',$seds[$colchete]);
		$seds[$colchete]=latex_escape($seds[$colchete]);
		}

	// Gera o PDF sem passar pelo shell (ver global/latex_pdf.php)
	$pdf = gera_pdf_latex("./modelo_tex/".$arquivo, $seds);
	if ($pdf === false) die("N\xe3o foi poss\xedvel gerar o documento.");
	Header("Content-type: application/pdf");
	echo h($pdf);
//}

?>
