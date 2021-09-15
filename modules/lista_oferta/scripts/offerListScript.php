<?php

require_once '../conf/default.php';

require_once $ROOT_PATH.'utils/moduleUT.php';

require_once $ROOT_PATH.'processing/professorPR.php';

require_once $ROOT_PATH.'modelController/semesterMC.php';
require_once $ROOT_PATH.'modelController/offerListTemporaryMC.php';
require_once $ROOT_PATH.'modelController/magisterialOfferListMC.php';

function exchange($list, $classes, $professors, $averageCredits, $type, $bypass) {
	$return = array();

	if (strcmp($type, "p") == 0) {
		$quantity = count($classes);
		$quantityOpposite = count($professors);
	} else {
		$quantity = count($professors);
		$quantityOpposite = count($classes);
	}

	if (count($list) < $quantity) {
		for ($i = 0; $i < $quantityOpposite; $i++) {
			$listTmp = $list;

			if (strcmp($type, "p") == 0) {
				$classesCopy = $classes;
				$professorsCopy = $professors;
				$listTmp[] = $professorsCopy[$i];
				array_splice($professorsCopy, $i, 1);
			} else {
				$classesCopy = $classes;
				$professorsCopy = $professors;
				$listTmp[] = $classesCopy[$i];
				array_splice($classesCopy, $i, 1);
			}

			$r = exchange($listTmp, $classesCopy, $professorsCopy, $averageCredits, $type, $bypass);

			if (count($r) == $quantity) {
				return $r;
			}

			if (count($r) > count($return)) {
				$return = $r;
			}
		}
	} else {
		if (strcmp($type, "p") == 0) {
			$listProfessors = & $list;
			$listClasses = & $classes;
		} else {
			$listClasses = & $list;
			$listProfessors = & $professors;
		}
		for ($i = 0; $i < $quantity; $i++) {
			if (ProfessorPR::professorCanGetClass($listProfessors[$i], $listClasses[$i], $averageCredits, $bypass)) {
				ProfessorPR::addTemporaryClassToProfessor($listClasses[$i], $listProfessors[$i]);
				$obj = new stdClass();
				$obj->class = $listClasses[$i]->id;
				$obj->professor = $listProfessors[$i]->id;
//				$obj->schedule = $listClasses[$i]->schedule;
				$return[] = $obj;
			}
		}

		for ($i = 0; $i < $quantity; $i++) {
			ProfessorPR::cleanTemporaryClassFromProfessor($listProfessors[$i]);
		}
	}
	return $return;
}

function suggestDistribution($classes, $professors, $averageCredits, $bypass = false) {
	$listProfessor = array();
	foreach ($professors as $professor) {
		$class = array_values($classes);
		if (ProfessorPR::creditsProfessorNeed($professor->professor, $averageCredits) >= $class[0]->discipline_credits) {
			for ($i = 0; $i < $professor->quantity; $i++) {
				$listProfessor[] = $professor->professor;
			}
		}
	}

	shuffle($classes);
	shuffle($listProfessor);

	if (count($classes) > count($listProfessor)) {
		$type = "c";
	} else {
		$type = "p";
	}

	return exchange(array(), $classes, $listProfessor, $averageCredits, $type, $bypass);
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

//TODO: Se estiver na etapa do semestre que deva rodar, e se o usuario tiver permissão para executar o script
if(strcmp($semester->status, SemesterDAO::STATUS_STAGE_3) == 0 && ($DEVELOPMENT || ModuleUT::haveUserLogged($ID_MODULE))) {

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

// $OFFER_LIST_QUANTITY_ATTEMPTS = 1;
	for ($j = 0; $j < $OFFER_LIST_QUANTITY_ATTEMPTS; $j++) {
		$classes = unserialize($classesJson);
		$listProfessors = unserialize($listProfessorsJson);

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

		if (count($solution) > count($solutionBest)) {
//			echo "M0.1<br>";
			$solutionBest = $solution;
			$creditsCountBest = $creditsCount;
			$optionsBest = $options;
			$distributionReportBest = $distributionReport;
		} elseif (count($solution) == count($solutionBest)) {
//			echo "M0<br>";
			if($creditsCount > $creditsCountBest) {
//				echo "M0.2<br>";
				$solutionBest = $solution;
				$creditsCountBest = $creditsCount;
				$optionsBest = $options;
				$distributionReportBest = $distributionReport;
			} elseif($creditsCount == $creditsCountBest) {
//				echo "M1<br>";
				if ($options[1] > $optionsBest[1]) {
//					echo "M1.1<br>";
					$solutionBest = $solution;
					$creditsCountBest = $creditsCount;
					$optionsBest = $options;
					$distributionReportBest = $distributionReport;
				} elseif ($options[1] == $optionsBest[1]) {
//					echo "M2<br>";
					if ($options[2] > $optionsBest[2]) {
//						echo "M2.1<br>";
						$solutionBest = $solution;
						$creditsCountBest = $creditsCount;
						$optionsBest = $options;
						$distributionReportBest = $distributionReport;
					} elseif ($options[2] == $optionsBest[2]) {
//						echo "M3<br>";
						if ($options[3] > $optionsBest[3]) {
//							echo "M3.1<br>";
							$solutionBest = $solution;
							$creditsCountBest = $creditsCount;
							$optionsBest = $options;
							$distributionReportBest = $distributionReport;
						} elseif ($options[3] == $optionsBest[3]) {
//							echo "M4<br>";
							if ($options[4] > $optionsBest[4]) {
//								echo "M4.1<br>";
								$solutionBest = $solution;
								$creditsCountBest = $creditsCount;
								$optionsBest = $options;
								$distributionReportBest = $distributionReport;
							} elseif ($options[4] == $optionsBest[4]) {
//								echo "M5<br>";
								if ($options[5] > $optionsBest[5]) {
//									echo "M5.1<br>";
									$solutionBest = $solution;
									$creditsCountBest = $creditsCount;
									$optionsBest = $options;
									$distributionReportBest = $distributionReport;
								} elseif ($options[5] == $optionsBest[5]) {
//									echo "M6<br>";
									if ($options[6] > $optionsBest[6]) {
//										echo "M6.1<br>";
										$solutionBest = $solution;
										$creditsCountBest = $creditsCount;
										$optionsBest = $options;
										$distributionReportBest = $distributionReport;
									}
								}
							}
						}
					}
				}
			}
		}
	}
		
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

	echo "<pre>Turmas Preenchidas: " . count($solutionBest);
	echo "\nCr&eacute;ditos Preenchidos: $creditsCountBest\n";

	foreach ($optionsBest as $key => $option) {
		echo "\nOp&ccedil;&atilde;o $key: $option";
	}
	echo "</pre>";
} else {
	p("Sem permiss&atilde;o para acessar o m&oacute;dulo ou semestre n&atilde;o est&aacute; na etapa de distribui&atilde;&atilde;o da LO.");
}