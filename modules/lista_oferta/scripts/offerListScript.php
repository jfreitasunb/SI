<?php

require_once '../conf/default.php';

require_once $ROOT_PATH.'utils/moduleUT.php';

require_once $ROOT_PATH.'processing/professorPR.php';

require_once $ROOT_PATH.'modelController/semesterMC.php';
require_once $ROOT_PATH.'modelController/offerListTemporaryMC.php';
require_once $ROOT_PATH.'modelController/magisterialOfferListMC.php';

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

	$s->nodes++;
	if (count($s->current) > count($s->best)) {
		$s->best = $s->current;
	}
	if (count($s->best) >= $s->target || $s->nodes >= $s->nodeLimit) {
		return true;
	}

	$n = count($s->classes);
	if ($i >= $n) {
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

	return assignClasses($classes, $listProfessor, $capacity, $averageCredits, $bypass);
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

// Linhas "Opcao N" do resultado: percentual dos pedidos da opcao que foram atendidos.
// Um pedido e a N-esima escolha de um professor; e atendido se ele recebeu ao menos
// uma turma dela, na distribuicao ou antes dela ($initialServed).
function optionsSummary($optionsBest, $solutionBest, $professorsByOption, $initialServed) {
	$served = $initialServed;
	foreach ($solutionBest as $solution) {
		$served[$solution->level][$solution->professor] = true;
	}

	$lines = array();
	foreach ($optionsBest as $key => $option) {
		$requested = isset($professorsByOption[$key]) ? $professorsByOption[$key] : 0;
		$count = isset($served[$key]) ? count($served[$key]) : 0;
		$percent = $requested > 0 ? number_format(100 * $count / $requested, 1, ',', '') . '%' : '-';
		$lines[] = "Op&ccedil;&atilde;o $key: $count de $requested pedidos atendidos ($percent)";
	}
	return $lines;
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

	$creditsEachProfessor = $semester->average_credits;

	$listProfessors = ProfessorPR::activeProfessorsWithCredits($semester);


	$oltMC = new OfferListTemporaryMC();
	$tempOfferList = $oltMC->getListWithDisciplineWithoutProfessorsOfSemester($semester);
	$tempOfferList = MagisterialUT::adjustClassList($tempOfferList);

	// Creditos de todas as turmas sem professor: base dos creditos que ficam sem preencher.
	$classes = array();
	$creditsToFill = 0;
	foreach ($tempOfferList as $class) {
		if (strlen($class->professor) == 0) {
			$classes[$class->discipline . '-' . $class->period][$class->id] = $class;
			$creditsToFill += $class->discipline_credits;
		}
	}

	usort($classes, 'sortCountElements');

	$classesJson = serialize($classes);
	$listProfessorsJson = serialize($listProfessors);

	// Total de pedidos em cada opcao (todos os professores que fizeram aquela escolha,
	// inclusive os que ja tinham creditos suficientes): base do percentual de atendimento.
	$professorsByOption = array_fill(1, $QUANTITY_PREFERRED_DISCIPLINE, 0);
	foreach ($listProfessors as $professor) {
		if (isset($professor->choices)) {
			foreach ($professor->choices as $order => $choice) {
				if (isset($professorsByOption[$order])) {
					$professorsByOption[$order]++;
				}
			}
		}
	}

	// Pedidos ja atendidos antes do script: turmas que o professor ja tinha de uma
	// disciplina que ele escolheu. Ficam [opcao][professor] => true, como em optionsSummary.
	$initialServed = array();
	foreach ($listProfessors as $professor) {
		if (isset($professor->choices) && isset($professor->classes)) {
			foreach ($professor->classes as $class) {
				$key = $class->discipline . '-' . $class->period;
				foreach ($professor->choices as $order => $choice) {
					if ($choice->discipline == $key) {
						$initialServed[$order][$professor->id] = true;
						break;
					}
				}
			}
		}
	}

	$solutionBest = array();
	$creditsCountBest = 0;
	$optionsBest = array(1 => 0, 2 => 0, 3 => 0, 4 => 0, 5 => 0, 6 => 0);
	$distributionReportBest = array();

	$attemptsWithoutImprovement = 0;
	$stoppedEarly = false;
	$bestAttempt = 0;

	for ($j = 0; $j < $OFFER_LIST_QUANTITY_ATTEMPTS; $j++) {
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
			$bestAttempt = $j + 1;
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

	echo "<pre>Tentativas: $attemptsRun (melhor na $bestAttempt"
		. ($stoppedEarly ? "; parou ap&oacute;s $OFFER_LIST_ATTEMPTS_WITHOUT_IMPROVEMENT sem melhora" : "") . ")";
	echo "\nTurmas Preenchidas: " . count($solutionBest);
	echo "\nCr&eacute;ditos Preenchidos: $creditsCountBest";
	echo "\nCr&eacute;ditos N&atilde;o Preenchidos: " . ($creditsToFill - $creditsCountBest) . "\n";

	foreach (optionsSummary($optionsBest, $solutionBest, $professorsByOption, $initialServed) as $line) {
		echo "\n" . $line;
	}
	echo "</pre>";
} else {
	p("Sem permiss&atilde;o para acessar o m&oacute;dulo ou semestre n&atilde;o est&aacute; na etapa de distribui&atilde;&atilde;o da LO.");
}