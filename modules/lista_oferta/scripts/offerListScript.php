<?php

require_once '../conf/default.php';

require_once $ROOT_PATH.'utils/moduleUT.php';

require_once $ROOT_PATH.'processing/professorPR.php';

require_once $ROOT_PATH.'modelController/semesterMC.php';
require_once $ROOT_PATH.'modelController/offerListTemporaryMC.php';
require_once $ROOT_PATH.'modelController/magisterialOfferListMC.php';

// ===== MEDICAO TEMPORARIA (remover depois de analisar) =====
// Conta os nos da busca (assignSearch) e o tempo de cada suggestDistribution(),
// agregados por grupo (disciplina-periodo) e fase. O relatorio sai no fim da
// pagina e no log de erros, mesmo se o script estourar o tempo.
$PROF = array(
	'start' => microtime(true), 'setup' => 0.0, 'attempts' => 0,
	'calls' => 0, 'leaves' => 0, 'ctx' => '', 'groups' => array(), 'enabled' => false,
);

function profileReport() {
	global $PROF;
	if (!$PROF['enabled']) return;

	$total = microtime(true) - $PROF['start'];
	$inGroups = 0.0;
	foreach ($PROF['groups'] as $g) $inGroups += $g['time'];

	$groups = $PROF['groups'];
	uasort($groups, function ($a, $b) { return $b['time'] <=> $a['time']; });

	$lines = array();
	$lines[] = sprintf("MEDICAO offerListScript: %.1f s no total | carga inicial %.2f s | %d tentativa(s) iniciada(s) | %.1f s em suggestDistribution",
		$total, $PROF['setup'], $PROF['attempts'], $inGroups);
	if ($PROF['attempts'] > 0) {
		$lines[] = sprintf("Media por tentativa: %.3f s | busca: %s nos, %s folhas",
			($total - $PROF['setup']) / $PROF['attempts'], number_format($PROF['calls'], 0, ',', '.'), number_format($PROF['leaves'], 0, ',', '.'));
	}
	$lines[] = "";
	$lines[] = sprintf("%-28s %6s %9s %8s %8s %6s %6s %6s %14s %12s",
		"grupo [fase]", "%tempo", "tempo(s)", "max(ms)", "chamadas", "turmas", "vagas", "profs", "nos busca", "max nos");
	$n = 0;
	foreach ($groups as $key => $g) {
		if (++$n > 40) { $lines[] = "... (" . (count($groups) - 40) . " grupos a mais)"; break; }
		$lines[] = sprintf("%-28s %5.1f%% %9.2f %8.1f %8d %6d %6d %6d %14s %12s",
			$key, $inGroups > 0 ? 100 * $g['time'] / $inGroups : 0, $g['time'], 1000 * $g['max_time'], $g['n'],
			$g['max_classes'], $g['max_slots'], $g['max_profs'],
			number_format($g['calls'], 0, ',', '.'), number_format($g['max_leaves'], 0, ',', '.'));
	}
	$lines[] = "";
	$lines[] = "turmas/vagas/profs = maior tamanho visto do grupo (vagas = soma das turmas que os professores aceitam).";
	$lines[] = "max nos = maior numero de nos visitados pela busca numa unica chamada.";

	$text = implode("\n", $lines);
	error_log($text);
	echo "<pre>" . htmlspecialchars($text, ENT_QUOTES, 'UTF-8') . "</pre>";
}
register_shutdown_function('profileReport');
// ===== FIM MEDICAO TEMPORARIA =====

// Limite de seguranca por grupo: nos visitados pela busca. Com os grupos atuais
// a busca usa poucos; se estourar, devolve a melhor solucao encontrada ate ali.
$DISTRIBUTION_SEARCH_NODE_LIMIT = 200000;

/**
 * Atribuicao com o maior numero possivel de turmas de um grupo (mesma
 * disciplina/periodo) a professores.
 *
 * Busca em profundidade turma a turma: atribui a turma a um professor com vaga,
 * horario livre e creditos, ou a deixa sem professor. Poda os ramos que nao
 * podem superar a melhor solucao, usando como limite superior o emparelhamento
 * maximo entre as turmas restantes e as vagas restantes. Chega ao mesmo maximo
 * da antiga enumeracao de permutacoes, sem testar permutacoes equivalentes
 * (por exemplo, as copias de um professor que escolheu varias turmas).
 *
 * $professors: professores distintos; $capacity[k]: quantas turmas o professor k aceita.
 * Retorna objetos {class, professor} com os ids, como a versao anterior.
 */
function assignClasses($classes, $professors, $capacity, $averageCredits, $bypass) {
	global $DISTRIBUTION_SEARCH_NODE_LIMIT;

	$s = new stdClass();
	$s->classes = array_values($classes);
	$s->professors = array_values($professors);
	$s->capacity = array_values($capacity);
	$s->averageCredits = $averageCredits;
	$s->bypass = $bypass;
	$s->current = array();
	$s->best = array();
	$s->target = min(count($s->classes), array_sum($s->capacity));
	$s->nodes = 0;
	$s->nodeLimit = $DISTRIBUTION_SEARCH_NODE_LIMIT;

	if ($s->target > 0) {
		assignSearch($s, 0);
	}

	$result = array();
	foreach ($s->best as $pair) {
		$obj = new stdClass();
		$obj->class = $s->classes[$pair[0]]->id;
		$obj->professor = $s->professors[$pair[1]]->id;
		$result[] = $obj;
	}
	return $result;
}

// Retorna true quando a busca deve parar (alvo atingido ou limite de nos).
function assignSearch($s, $i) {
	global $PROF; // MEDICAO TEMPORARIA
	$PROF['calls']++;

	$s->nodes++;
	if (count($s->current) > count($s->best)) {
		$s->best = $s->current;
	}
	if (count($s->best) >= $s->target || $s->nodes >= $s->nodeLimit) {
		return true;
	}

	$n = count($s->classes);
	if ($i >= $n) {
		$PROF['leaves']++; // MEDICAO TEMPORARIA
		return false;
	}

	// Poda barata, depois a exata (emparelhamento das turmas restantes).
	$have = count($s->current);
	if ($have + min($n - $i, array_sum($s->capacity)) <= count($s->best)) {
		return false;
	}
	if ($have + assignUpperBound($s, $i) <= count($s->best)) {
		return false;
	}

	$class = $s->classes[$i];
	foreach ($s->professors as $k => $professor) {
		if ($s->capacity[$k] > 0 && ProfessorPR::professorCanGetClass($professor, $class, $s->averageCredits, $s->bypass)) {
			ProfessorPR::addTemporaryClassToProfessor($class, $professor);
			$s->capacity[$k]--;
			$s->current[] = array($i, $k);

			$stop = assignSearch($s, $i + 1);

			array_pop($s->current);
			$s->capacity[$k]++;
			ProfessorPR::removeTemporaryClassFromProfessor($class, $professor);
			if ($stop) {
				return true;
			}
		}
	}

	// Turma $i fica sem professor.
	return assignSearch($s, $i + 1);
}

// Limite superior de turmas ainda atribuiveis a partir da turma $from: emparelhamento
// maximo (com a capacidade de cada professor) entre as turmas restantes e os
// professores que podem pega-las no estado atual. Ignora conflitos de horario e de
// creditos entre as proprias turmas restantes, por isso nunca subestima.
function assignUpperBound($s, $from) {
	$n = count($s->classes);
	$adj = array();
	for ($c = $from; $c < $n; $c++) {
		$adj[$c] = array();
		foreach ($s->professors as $k => $professor) {
			if ($s->capacity[$k] > 0 && ProfessorPR::professorCanGetClass($professor, $s->classes[$c], $s->averageCredits, $s->bypass)) {
				$adj[$c][] = $k;
			}
		}
	}

	$assigned = array_fill(0, count($s->professors), array());
	$matched = 0;
	for ($c = $from; $c < $n; $c++) {
		if (count($adj[$c])) {
			$seen = array();
			if (assignAugment($c, $adj, $assigned, $s->capacity, $seen)) {
				$matched++;
			}
		}
	}
	return $matched;
}

// Caminho aumentante (Kuhn) com capacidade por professor.
function assignAugment($c, &$adj, &$assigned, &$capacity, &$seen) {
	foreach ($adj[$c] as $k) {
		if (isset($seen[$k])) {
			continue;
		}
		$seen[$k] = true;
		if (count($assigned[$k]) < $capacity[$k]) {
			$assigned[$k][] = $c;
			return true;
		}
		foreach ($assigned[$k] as $pos => $other) {
			if (assignAugment($other, $adj, $assigned, $capacity, $seen)) {
				$assigned[$k][$pos] = $c;
				return true;
			}
		}
	}
	return false;
}

function suggestDistribution($classes, $professors, $averageCredits, $bypass = false) {
	$first = reset($classes);

	// Professores distintos com a quantidade de turmas que escolheram (antes cada um
	// era repetido "quantity" vezes, o que multiplicava as permutacoes testadas).
	$candidates = array();
	foreach ($professors as $professor) {
		if ($first && ProfessorPR::creditsProfessorNeed($professor->professor, $averageCredits) >= $first->discipline_credits) {
			$candidates[] = array($professor->professor, $professor->quantity);
		}
	}

	// Ordem aleatoria: entre solucoes empatadas, cada tentativa encontra uma diferente.
	shuffle($classes);
	shuffle($candidates);

	$listProfessor = array();
	$capacity = array();
	foreach ($candidates as $candidate) {
		$listProfessor[] = $candidate[0];
		$capacity[] = $candidate[1];
	}

	// MEDICAO TEMPORARIA
	global $PROF;
	$key = ($first ? $first->discipline . '-' . $first->period : '?') . ' [' . $PROF['ctx'] . ']';
	$calls0 = $PROF['calls'];
	$leaves0 = $PROF['leaves'];
	$t0 = microtime(true);

	$result = assignClasses($classes, $listProfessor, $capacity, $averageCredits, $bypass);

	$dt = microtime(true) - $t0;
	if (!isset($PROF['groups'][$key])) {
		$PROF['groups'][$key] = array('n' => 0, 'time' => 0.0, 'max_time' => 0.0, 'calls' => 0, 'max_leaves' => 0,
			'max_classes' => 0, 'max_slots' => 0, 'max_profs' => 0);
	}
	$g = &$PROF['groups'][$key];
	$g['n']++;
	$g['time'] += $dt;
	$g['max_time'] = max($g['max_time'], $dt);
	$g['calls'] += $PROF['calls'] - $calls0;
	$g['max_leaves'] = max($g['max_leaves'], $PROF['calls'] - $calls0);
	$g['max_classes'] = max($g['max_classes'], count($classes));
	$g['max_slots'] = max($g['max_slots'], array_sum($capacity));
	$g['max_profs'] = max($g['max_profs'], count($listProfessor));
	unset($g);

	return $result;
}

// Cascata de desempate entre duas distribuicoes: mais turmas preenchidas, depois mais
// creditos, depois mais turmas na 1a escolha, na 2a, ... ate a 6a.
function isBetterDistribution($count, $credits, $options, $countBest, $creditsBest, $optionsBest) {
	if ($count != $countBest) {
		return $count > $countBest;
	}
	if ($credits != $creditsBest) {
		return $credits > $creditsBest;
	}
	for ($i = 1; $i <= 6; $i++) {
		if ($options[$i] != $optionsBest[$i]) {
			return $options[$i] > $optionsBest[$i];
		}
	}
	return false;
}

function sortCountElements($item1, $item2) {
	$c1 = count($item1);
	$c2 = count($item2);
	if ($c1 == $c2) return 0;
	return ($c1 < $c2) ? -1 : 1;
}

function confirmSolutions(&$solutions, &$classes, $keyClass, &$disciplinesChosen, $level) {
	foreach ($solutions as $solution) {
		$class = $classes[$keyClass][$solution->class];
		unset($classes[$keyClass][$solution->class]);

		$professor = $disciplinesChosen[$class->discipline . '-' . $class->period][$level][$solution->professor]->professor;
		ProfessorPR::addClassToProfessor($class, $professor);

		$disciplinesChosen[$class->discipline . '-' . $class->period][$level][$solution->professor]->quantity --;
		if ($disciplinesChosen[$class->discipline . '-' . $class->period][$level][$solution->professor]->quantity == 0) {
			unset($disciplinesChosen[$class->discipline . '-' . $class->period][$level][$solution->professor]);
		}
		$solution->level = $level;
	}
}

function prepareReport($tempOfferList, $classes, $temporarySolution, $listProfessors, $type, $choice) {
	$objMaster = new stdClass();
	$objMaster->type = $type;
	$objMaster->choice = $choice;

	$tmpSolution = array();
	foreach ($temporarySolution as $sol) {
		$tmpSolution[$sol->professor][] = $sol->class;

		$class = $tempOfferList[$sol->class];
		$objMaster->classesBefore[] = $class->discipline_name." ".$class->class." - ".$class->schedule;
	}

	foreach ($classes as $class) {
		$objMaster->classesBefore[] = $class->discipline_name." ".$class->class." - ".$class->schedule;
		$objMaster->classesAfter[] = $class->discipline_name." ".$class->class." - ".$class->schedule;
	}

	sort($objMaster->classesBefore);

	foreach ($tmpSolution as $professorKey => $classesKey) {
		$professor = $listProfessors[$professorKey];

		$obj = new stdClass();
		$obj->name = $professor->id." - ".$professor->name." ".$professor->last_name;
		$obj->classes = array();
		$obj->schedule = $professor->schedule;

		foreach ($classesKey as $classKey) {
			$class = $tempOfferList[$classKey];
			$obj->classes[] = $class->discipline_name." ".$class->class." - ".$class->schedule;
		}
		sort($obj->classes);

		$objMaster->professors[] = $obj;
	}
	return $objMaster;
}

$semesterMC = new SemesterMC();
$semester = $semesterMC->last();

// Exige POST + sessao autenticada no modulo (impede CSRF via GET e DoS por navegacao).
if (strtoupper($_SERVER['REQUEST_METHOD'] ?? 'GET') === 'POST'
	&& strcmp($semester->status, SemesterDAO::STATUS_STAGE_3) == 0
	&& ModuleUT::haveUserLogged($ID_MODULE)) {

	// As $OFFER_LIST_QUANTITY_ATTEMPTS tentativas estouram os 30 s padrao do PHP-FPM.
	// Manter alinhado com fastcgi_read_timeout no nginx.
	set_time_limit(600);
	$PROF['enabled'] = true; // MEDICAO TEMPORARIA

	$creditsEachProfessor = $semester->average_credits;

	$listProfessors = ProfessorPR::activeProfessorsWithCredits($semester);


	$oltMC = new OfferListTemporaryMC();
	$tempOfferList = $oltMC->getListWithDisciplineWithoutProfessorsOfSemester($semester);
	$tempOfferList = MagisterialUT::adjustClassList($tempOfferList);

	$classes = array();
	foreach ($tempOfferList as $class) {
		if (strlen($class->professor) == 0) {
			$classes[$class->discipline . '-' . $class->period][$class->id] = $class;
		}
	}

	usort($classes, 'sortCountElements');

	$classesJson = serialize($classes);
	$listProfessorsJson = serialize($listProfessors);

	$solutionBest = array();
	$creditsCountBest = 0;
	$optionsBest = array(1 => 0, 2 => 0, 3 => 0, 4 => 0, 5 => 0, 6 => 0);
	$distributionReportBest = array();

	$attemptsWithoutImprovement = 0;
	$stoppedEarly = false;

	$PROF['setup'] = microtime(true) - $PROF['start']; // MEDICAO TEMPORARIA
	for ($j = 0; $j < $OFFER_LIST_QUANTITY_ATTEMPTS; $j++) {
		$PROF['attempts'] = $j + 1; // MEDICAO TEMPORARIA
		$classes = unserialize($classesJson, array('allowed_classes' => array('stdClass')));
		$listProfessors = unserialize($listProfessorsJson, array('allowed_classes' => array('stdClass')));

		//começa aqui o loop
		$disciplinesChosen = array();
		foreach ($listProfessors as $professor) {
			if (isset($professor->choices)) {
				foreach ($professor->choices as $order => $choice) {
					if (ProfessorPR::creditsProfessorNeed($professor, $creditsEachProfessor) > 0) {
						$obj = new stdClass();
						$obj->professor = $professor;
						$obj->quantity = $choice->quantity;
						$disciplinesChosen[$choice->discipline][$order][$professor->id] = $obj;
					}
				}
			}
		}

		$solution = array();
		$options = array(1 => 0, 2 => 0, 3 => 0, 4 => 0, 5 => 0, 6 => 0);
		$distributionReport = array();

		$remove = array();
		foreach ($classes as $keyClass => $class) {
			$count = 0;
			$c = array_values($class);
			$c = $c[0];
			$key = $c->discipline . '-' . $c->period;

			if (isset($disciplinesChosen[$key][1])) {
				foreach ($disciplinesChosen[$key][1] as $choice) {
					$count += $choice->quantity;
				}

				//Distribuir apenas para os professores que escolheram mais que uma turma da disciplina.
				$professors = $disciplinesChosen[$key][1];
				shuffle($professors);

				//Distribuir apenas para disciplinas que sejam de 6 créditos.
				if ($c->discipline_credits == 6) {
					$professorsList = array();
					foreach ($professors as $professor) {
						if ($professor->quantity > 1) {
							$professorsList[] = $professor;
						}
					}

					$PROF['ctx'] = '6cr'; // MEDICAO TEMPORARIA
					$temporarySolution = suggestDistribution($classes[$keyClass], $professorsList, $creditsEachProfessor, true);

					$solution = array_merge($solution, $temporarySolution);

					$options[1] += count($temporarySolution);
					confirmSolutions($temporarySolution, $classes, $keyClass, $disciplinesChosen, 1);

					if (!count($classes[$keyClass])) {
						$remove[] = $keyClass;
					}

					if ($DISTRIBUTION_REPORT && count($temporarySolution)) {
						$distributionReport[] = prepareReport($tempOfferList, $classes[$keyClass], $temporarySolution, $listProfessors, 0, 1);
					}
				}
			}
		}

		foreach ($remove as $keyClass) {
			unset($classes[$keyClass]);
		}

		//Distribir as turmas indo do 1 para a 6 escolha
		for ($i = 1; $i <= $QUANTITY_PREFERRED_DISCIPLINE; $i++) {
			$remove = array();
			foreach ($classes as $keyClass => $class) {
				$c = array_values($class);
				$c = $c[0];
				$key = $c->discipline . '-' . $c->period;

				if (isset($disciplinesChosen[$key][$i])) {
					$PROF['ctx'] = 'op' . $i; // MEDICAO TEMPORARIA
					$temporarySolution = suggestDistribution($classes[$keyClass], $disciplinesChosen[$key][$i], $creditsEachProfessor);

					$solution = array_merge($solution, $temporarySolution);

					$options[$i] += count($temporarySolution);
					confirmSolutions($temporarySolution, $classes, $keyClass, $disciplinesChosen, $i);

					if (!count($classes[$keyClass])) {
						$remove[] = $keyClass;
					}

					if ($DISTRIBUTION_REPORT && count($temporarySolution)) {
						$distributionReport[] = prepareReport($tempOfferList, $classes[$keyClass], $temporarySolution, $listProfessors, 1, $i);
					}
				}
			}

			foreach ($remove as $keyClass) {
				unset($classes[$keyClass]);
			}
		}

		$creditsCount = 0;
		foreach ($solution as $class) {
			$creditsCount += $tempOfferList[$class->class]->discipline_credits;
		}

		if (isBetterDistribution(count($solution), $creditsCount, $options, count($solutionBest), $creditsCountBest, $optionsBest)) {
			$solutionBest = $solution;
			$creditsCountBest = $creditsCount;
			$optionsBest = $options;
			$distributionReportBest = $distributionReport;
			$attemptsWithoutImprovement = 0;
		} else {
			$attemptsWithoutImprovement++;
		}

		// Parada antecipada: a melhor distribuicao nao muda ha N tentativas seguidas.
		if ($OFFER_LIST_ATTEMPTS_WITHOUT_IMPROVEMENT > 0 && $attemptsWithoutImprovement >= $OFFER_LIST_ATTEMPTS_WITHOUT_IMPROVEMENT) {
			$stoppedEarly = true;
			break;
		}
	}
	$attemptsRun = $j + ($stoppedEarly ? 1 : 0);
		
	$magisterialDisciplineMC = new MagisterialOfferListMC();
	foreach ($solutionBest as $solution) {
		$parts = explode('-', $solution->class);
		if (count($parts) > 1) {
			$magisterialDisciplineMC->updateProfessor($parts[0], $solution->professor);
		} else {
			$oltMC->updateProfessor($parts[0], $solution->professor);
		}
	}

	if ($DISTRIBUTION_REPORT) {
		foreach ($distributionReportBest as $report) {
			if ($report->type == 0) {
				p("_______ 6 CRÉDITOS PRIMEIRA ESCOLHA ________");
			} else {
				p("_________ DISTRIBUICAO NORMAL (".$report->choice.") __________");
			}
			
			p("_______ TURMAS ANTES DA DISTRIBUICAO _______");
			foreach ($report->classesBefore as $class) {
				p($class);
			}
			
			foreach ($report->professors as $professor) {
				p("________________ PROFESSOR _________________");
				p($professor->name);

				foreach ($professor->classes as $class) {
					p("  ".$class);
				}

				p($professor->schedule);
			}
			
			p("___________ TURMAS QUE SOBRARAM ____________");
			foreach ($report->classesAfter as $class) {
				p($class);
			}

			p("############################################");
			p(" ");
		}

		$distribution = array();
		foreach ($solutionBest as $solution) {
			$professor = $listProfessors[$solution->professor];
			$class = $tempOfferList[$solution->class];

			$distribution[] = $professor->name." ".$professor->last_name." (".$solution->level.") - ".$class->discipline_name." ".$class->class." (".$class->discipline_credits.") - ".$class->schedule;
		}

		sort($distribution);

		foreach ($distribution as $dist) {
			p($dist);
		}
	}

	echo "<pre>Tentativas: $attemptsRun" . ($stoppedEarly ? " (parou apos $OFFER_LIST_ATTEMPTS_WITHOUT_IMPROVEMENT sem melhora)" : "");
	echo "\nTurmas Preenchidas: " . count($solutionBest);
	echo "\nCr&eacute;ditos Preenchidos: $creditsCountBest\n";

	foreach ($optionsBest as $key => $option) {
		echo "\nOp&ccedil;&atilde;o $key: $option";
	}
	echo "</pre>";
} else {
	p("Sem permiss&atilde;o para acessar o m&oacute;dulo ou semestre n&atilde;o est&aacute; na etapa de distribui&atilde;&atilde;o da LO.");
}