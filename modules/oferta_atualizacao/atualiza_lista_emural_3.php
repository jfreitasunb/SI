<?PHP
require("head_oferta.php");
exige_post();
exige_escrita();

// Grava o professor de exercicio escolhido em atualiza_lista_emural_2.php para cada
// turma do e-mural (oferta_lista_de_ofertas) e mostra uma mensagem com o resultado.

$e_mural = isset($_POST['e_mural']) && is_array($_POST['e_mural']) ? $_POST['e_mural'] : array();
$semestre = isset($_POST['semestre']) ? (string)$_POST['semestre'] : '';
$ano = isset($_POST['ano']) ? (string)$_POST['ano'] : '';

// Mensagem final: $erro (HTML ja escapado) se algo falhou; senao $sucesso e $alteradas.
$erro = '';
$sucesso = '';
$alteradas = array();
$avisos = array();

if (!in_array($semestre, array('0', '1', '2'), true) || !preg_match('/^\d{4}$/', $ano)) {
	$erro = "Semestre ou ano inv&aacute;lido. Volte e escolha a lista novamente.";
} elseif (!count($e_mural)) {
	$erro = "Nenhuma turma foi enviada. Volte, marque os professores de exerc&iacute;cio e confirme.";
} else {
	$pdo = db_connect();
	// Tudo numa transacao: se uma atualizacao falhar, nenhuma fica gravada.
	db_lanca_excecoes(true);
	try {
		$pdo->beginTransaction();

		// Professor atual de cada turma, para gravar so o que mudou.
		$atual = array();
		foreach (db_fetch_all(db_query("select disciplina, turma, professor from oferta_lista_de_ofertas where semestre=? and ano=?", array($semestre, $ano))) as $linha) {
			$atual[$linha['disciplina']][$linha['turma']] = (string)$linha['professor'];
		}

		$nomes = array();
		foreach (db_fetch_all(db_query("select coduser, name||' '||firstname as nome from users", array())) as $linha) {
			$nomes[$linha['coduser']] = $linha['nome'];
		}

		$sem_mudanca = 0;
		foreach ($e_mural as $disciplina => $turmas) {
			if (!is_array($turmas) || !ctype_digit((string)$disciplina)) {
				continue;
			}
			foreach ($turmas as $turma => $professor) {
				$turma = (string)$turma;
				$professor = (string)$professor;
				if (!ctype_digit($professor)) {
					continue;
				}
				if (!isset($atual[$disciplina][$turma])) {
					$avisos[] = "Disciplina ".h($disciplina).", turma ".h($turma).": n&atilde;o est&aacute; no e-mural de $semestre/$ano; ignorada.";
					continue;
				}
				if ($atual[$disciplina][$turma] === $professor) {
					$sem_mudanca++;
					continue;
				}
				db_query("update oferta_lista_de_ofertas set professor=? where disciplina=? and turma=? and semestre=? and ano=?",
					array($professor, $disciplina, $turma, $semestre, $ano));
				$alteradas[] = "Disciplina ".h($disciplina).", turma ".h($turma).": "
					. h(isset($nomes[$professor]) ? $nomes[$professor] : "coduser ".$professor);
			}
		}

		$pdo->commit();

		$sucesso = "E-mural da lista ".h($semestre)."/".h($ano)." atualizado com sucesso: "
			. count($alteradas)." turma(s) com professor de exerc&iacute;cio alterado, "
			. $sem_mudanca." sem altera&ccedil;&atilde;o.";
	} catch (Throwable $e) {
		if ($pdo->inTransaction()) {
			$pdo->rollBack();
		}
		error_log("atualiza_lista_emural_3 ($semestre/$ano): " . $e->getMessage());
		$erro = "O e-mural da lista ".h($semestre)."/".h($ano)." n&atilde;o foi atualizado e nada foi alterado no banco. "
			. "Erro: ".h($e->getMessage());
		$alteradas = array();
	}
	db_lanca_excecoes(false);
}

// A tabela .form usa fonte de 10px (grafic.css): o resultado usa uma maior.
$estilo = 'style="font-size: 16px; line-height: 1.5; padding: 8px 12px;"';
?>
<html>
  <header>
    <link type="text/css" rel="stylesheet" href="../../global/grafic.css">
<meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
  </header>
  <body>
      <table class=big>
	<tr>
        <td class=header align=center>
        <h1> Lista de Ofertas do <?php echo h($semestre);?>&ordm;/ <?php echo h($ano);?></h1>
        </td>
	</tr>
<?php if ($erro !== '') { ?>
	<tr><td <?php echo $estilo; ?>><b>Erro:</b> <?php echo $erro; ?></td></tr>
<?php } else { ?>
	<tr><td <?php echo $estilo; ?>><?php echo $sucesso; ?></td></tr>
<?php if (count($alteradas)) { ?>
	<tr><td <?php echo $estilo; ?>><b>Turmas alteradas:</b><ul>
<?php foreach ($alteradas as $alterada) { ?>
		<li><?php echo $alterada; ?></li>
<?php } ?>
	</ul></td></tr>
<?php } ?>
<?php if (count($avisos)) { ?>
	<tr><td <?php echo $estilo; ?>><b>Avisos (<?php echo count($avisos); ?>):</b><ul>
<?php foreach ($avisos as $aviso) { ?>
		<li><?php echo $aviso; ?></li>
<?php } ?>
	</ul></td></tr>
<?php } ?>
<?php } ?>
	<tr><td align=center <?php echo $estilo; ?>><a href="atualiza_lista_emural.php">Voltar</a></td></tr>
      </table>
  </body>
</html>
<?php
db_close($idconn);
?>
