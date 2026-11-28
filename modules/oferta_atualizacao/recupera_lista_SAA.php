<?php
require("head_oferta.php");
//include ("recupera_lista_SAA_2.php");
include("manipula_arquivo_lista_de_ofertas.php");


/*
1- mostrar a lista de documentos - dropdown de documentos por categoria: select - deixar as atas de lado (serão tratadas em outro formulário) escolhe o documento.
2- selciona um ou mais arquivos para upload. o documento esta mostrado na pagina com possibilidade de voltar e mudar o documento.
3- registra a seleção; só pode ser arquivo do tipo ... e de um certo tamanho
4- salva o(s) arquivo(s) no diretorio de anexos. Renomear o arquivo: id_documentador_X.extensao em que X é o numero do anexo
5- inscreve na tabela admin_anexos: id_documentador, nome_do_arquivo, nome_diretorio(anexos,audios)

------ para audios das atas
1) O usuário faz o upload para um diretório específico;
2) O usuário abre a tela do sistema, digita as informações de data e outras coisas. O SI apresenta os arquivos que estão no diretório do servidor para o usuário selecionar qual ele enviou.
3) Após confirmação do usuário, o SI renomeia o arquivo e muda ele para a pasta correta, onde o usuário não teria acesso nem via FTP.
-------

*/



?>
<html>
<header>

<script language="javascript">

      var count=1;

      function cache_tout()
      {
        document.getElementById("entete1").style.visibility="hidden";
        document.getElementById("entete2").style.visibility="hidden";
<?php
        for($i=1;$i<21;$i++)
          echo "document.getElementById(\"id".$i."\").style.visibility=\"hidden\";";
?>
      }

      function compte(nb)
      {
        count=1;
        if (nb>20)
          nb=20;
        cache_tout();
        for(i=0;i<nb;i++)
          montre();
      }
 function champsok()
      {
        if (document.forms["formu"].mod_name.value.length == 0)
        {
          alert("Le champs correpsondant au nom du module est obligatoire. Veuillez le renseigner, svp.");
          document.forms["formu"].mod_name.focus();
          return false;
        }
        if (document.forms["formu"].mod_url.value.length == 0)
        {
          alert("Le champs correpsondant a l'url du module est obligatoire. Veuillez le renseigner, svp.");
          document.forms["formu"].mod_url.focus();
          return false;
        }
        if (document.forms["formu"].descr.value.length == 0)
        {
          alert("Le champs correpsondant a la description du module est obligatoire. Veuillez le renseigner, svp.");
          document.forms["formu"].mod_name.focus();
          return false;
        }
        return true;
      }

    </script>
    <!script language=javascript src="./scripts_uploads/function_js.js">
    <!/script>
    <!script language=javascript src="formu.js">
    <!/script>
    <link type="text/css" rel="stylesheet" href="../../global/grafic.css">
<meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
  </header>
<body>
<table class=big>
      <tr>
        <td class=header align=center>
          <h1>Departamento de Matem&aacute;tica</h1>
        </td>
	</tr>
        <tr>
        <td align=center>
               <title>Atualiza&ccedil;&atilde;o da Lista de Ofertas</title>
        <table class=form>

<?php
if (!isset($_POST['continuar']))
{
//$query_acusa_lista=pg_query("select * from oferta_acusa_lista order by ano desc,semestre desc");
$query_acusa_lista=db_query("select * from oferta_acusa_lista where encaminhada<>'nova' order by ano desc,semestre desc", array()); //CORRIGIDO EM 18/12/2014
?>
   <form method="POST" name="formu" action="recupera_lista_SAA.php"  enctype="multipart/form-data">
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
        <option name='lista' value="<?php echo h($registro[0])."_".h($registro[1]);?>"> <?php echo h($registro[0]);?> &ordm;/ <?php echo h($registro[1]);?></option>
        <?php
        }
        ?>
        </tr>
	<tr></tr><tr></tr><tr></tr><tr></tr><tr></tr>
	<tr><td colspan=2><b><h3>Escolha o arquivo .txt da lista de ofertas do MAT, obtido do SIGRA -> Planejamento -> oferta -> OFELST:</h3></b></td></tr>
	<tr><td>Arquivo Lista de ofertas:</td><td><input type=file name='arquivo[]'></td></tr>
	<tr></tr><tr></tr><tr></tr><tr></tr><tr></tr>
	<tr></tr><tr></tr><tr></tr><tr></tr><tr></tr>

<!--	COMENTADO EM 18/12/2014
	<tr><td colspan=2><b><h3>Escolha o arquivo .txt da Lista de disciplinas lecionadas pelos professores do MAT, obtido do SIGRA -> Planejamento -> oferta -> OFEDLP:</h3></b></td></tr>
	<tr><td>Arquivo Lista de disciplinas lecionadas:</td><td><input type=file name='arquivo[]'></td></tr>
-->
	<tr><td colspan=2 align=center><input type="submit" name='continuar' value="Confirmar" /></td></tr>
</form>
</table>
</td></tr>
</table>
</body>
</html>
<?php
}

if (isset($_POST['continuar']) and !isset($_POST['confirmar']))
{
exige_escrita();
$nome=array();
$manipula=array();
$lista=explode("_",isset($_POST['lista']) ? (string)$_POST['lista'] : '');
$semestre=isset($lista[0]) ? $lista[0] : '';
$ano=isset($lista[1]) ? $lista[1] : '';
if (!in_array($semestre, array('0', '1', '2'), true) || !preg_match('/^\d{4}$/', $ano)) {
	http_response_code(400);
	die(error("Semestre ou ano invalido."));
}


// Pasta onde o arquivo vai ser salvo (relativa ao modulo, sem caminho fixo de usuario)
$pasta = __DIR__ . '/listas_SAA/';
$tamanho_maximo = 1024 * 1024 * 2; // 2 MB
$nome_final = "lista_de_ofertas_".$semestre."_".$ano.".txt";

$erros_upload = array(
	UPLOAD_ERR_INI_SIZE   => 'o arquivo &eacute; maior do que o limite do servidor',
	UPLOAD_ERR_FORM_SIZE  => 'o arquivo &eacute; maior do que o limite do formul&aacute;rio',
	UPLOAD_ERR_PARTIAL    => 'o envio foi interrompido no meio',
	UPLOAD_ERR_NO_FILE    => 'nenhum arquivo foi escolhido',
	UPLOAD_ERR_NO_TMP_DIR => 'o servidor n&atilde;o tem pasta tempor&aacute;ria para uploads',
	UPLOAD_ERR_CANT_WRITE => 'o servidor n&atilde;o conseguiu gravar o arquivo',
	UPLOAD_ERR_EXTENSION  => 'uma extens&atilde;o do PHP bloqueou o envio',
);

// Mensagem final: $erro (HTML ja escapado) se algo falhou; senao $sucesso e $avisos.
$erro = '';
$sucesso = '';
$avisos = array();

$arquivo = isset($_FILES['arquivo']) ? $_FILES['arquivo'] : null;
$codigo_erro = ($arquivo && isset($arquivo['error'][0])) ? (int)$arquivo['error'][0] : UPLOAD_ERR_NO_FILE;

if ($codigo_erro !== UPLOAD_ERR_OK) {
	$erro = "N&atilde;o foi poss&iacute;vel enviar o arquivo: "
		. (isset($erros_upload[$codigo_erro]) ? $erros_upload[$codigo_erro] : "erro ".$codigo_erro) . ".";
} elseif (strtolower(pathinfo($arquivo['name'][0], PATHINFO_EXTENSION)) !== 'txt') {
	$erro = "Envie o arquivo .txt da lista de ofertas exportado do SIGAA.";
} elseif ($arquivo['size'][0] > $tamanho_maximo) {
	$erro = "O arquivo enviado &eacute; muito grande; o limite &eacute; 2 MB.";
} elseif (!upload_mime_ok($arquivo['tmp_name'][0], 'txt')) {
	$erro = "O conte&uacute;do do arquivo n&atilde;o &eacute; texto; envie o .txt exportado do SIGAA.";
} elseif (!move_uploaded_file($arquivo['tmp_name'][0], $pasta.$nome_final)) {
	$erro = "O servidor n&atilde;o conseguiu gravar o arquivo na pasta listas_SAA; verifique a permiss&atilde;o de escrita.";
} elseif (!testa_arquivo_sigaa($semestre, $ano, $nome_final)) {
	@unlink($pasta.$nome_final);
	$erro = "O arquivo n&atilde;o parece ser a lista de ofertas do SIGAA: ele precisa conter as disciplinas MAT0025, MAT0022 e MAT0010.";
}

if ($erro === '') {
	set_time_limit(60);
	$pdo = db_connect();
	// Tudo numa transacao: se uma etapa falhar, nada fica gravado pela metade.
	db_lanca_excecoes(true);
	$etapa = "lendo o arquivo";
	try {
		$pdo->beginTransaction();

		$array_linhas = manipula_arquivo_sigaa_atualiza_lista($semestre, $ano, $nome_final);
		if (!count($array_linhas)) {
			throw new RuntimeException("nenhuma turma do MAT foi encontrada no arquivo.");
		}

		$etapa = "gravando as turmas (oferta_lista_sigra)";
		db_query("delete from oferta_lista_sigra where semestre=? and ano=?", array($semestre, $ano));
		$sigra = processa_linhas_sigaa($array_linhas, $semestre, $ano);

		$etapa = "registrando os cr&eacute;ditos do rod&iacute;zio noturno";
		$rodizio = registra_rodizio_noturno_sigaa($array_linhas, $semestre, $ano);

		$etapa = "montando a lista do e-mural (oferta_lista_de_ofertas)";
		db_query("delete from oferta_lista_de_ofertas where semestre=? and ano=?", array($semestre, $ano));
		monta_ofertas_emural($semestre, $ano);

		$etapa = "atualizando oferta_semestres";
		atualiza_oferta_semestres($semestre, $ano);

		$pdo->commit();

		$sucesso = "Lista de ofertas ".h($semestre)."/".h($ano)." atualizada com sucesso: "
			. $sigra['turmas']." registro(s) de turma gravado(s). Rod&iacute;zio noturno: "
			. $rodizio['inseridos']." cr&eacute;dito(s) novo(s), ".$rodizio['existentes']." j&aacute; existia(m).";
		$avisos = array_values(array_unique(array_merge($sigra['avisos'], $rodizio['ignorados'])));
	} catch (Throwable $e) {
		if ($pdo->inTransaction()) {
			$pdo->rollBack();
		}
		error_log("recupera_lista_SAA ($semestre/$ano, $etapa): " . $e->getMessage());
		$erro = "A lista ".h($semestre)."/".h($ano)." n&atilde;o foi atualizada e nada foi alterado no banco. "
			. "O erro ocorreu ".$etapa.": ".h($e->getMessage());
	}
	db_lanca_excecoes(false);
}
// O topo da pagina (titulo "Departamento de Matematica" e a tabela .form) ja foi
// impresso acima, para o formulario e para o resultado; aqui entram so as linhas.
// A tabela .form usa fonte de 10px (grafic.css): o resultado usa uma maior.
$estilo = 'style="font-size: 16px; line-height: 1.5; padding: 8px 12px;"';
?>
		<tr><td class=header align=center><h1>Corre&ccedil;&atilde;o da Lista de Oferta de Disciplinas</h1></td></tr>
<?php if ($erro !== '') { ?>
		<tr><td <?php echo $estilo; ?>><b>Erro:</b> <?php echo $erro; ?></td></tr>
<?php } else { ?>
		<tr><td <?php echo $estilo; ?>><?php echo $sucesso; ?></td></tr>
<?php if (count($avisos)) { ?>
		<tr><td <?php echo $estilo; ?>><b>Avisos (<?php echo count($avisos); ?>):</b><ul>
<?php foreach ($avisos as $aviso) { ?>
			<li><?php echo h($aviso); ?></li>
<?php } ?>
		</ul></td></tr>
<?php } ?>
<?php } ?>
		<tr><td align=center <?php echo $estilo; ?>><a href="recupera_lista_SAA.php">Voltar</a></td></tr>
	</table>
	</td></tr>
</table>
</body>
</html>
<?php
}

db_close($idconn);
?>

