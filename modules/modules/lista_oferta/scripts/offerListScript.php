<?php

require_once '../conf/default.php';

require_once $ROOT_PATH.'utils/moduleUT.php';

require_once $ROOT_PATH.'processing/professorPR.php';

require_once $ROOT_PATH.'modelController/semesterMC.php';
require_once $ROOT_PATH.'modelController/offerListTemporaryMC.php';
require_once $ROOT_PATH.'modelController/magisterialOfferListMC.php';

function exchange($list, $classes, $professors, $averageCredits, $type) {
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

			$r = exchange($listTmp, $classesCopy, $professorsCopy, $averageCredits, $type);

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
			if (ProfessorPR::professorCanGetClass($listProfessors[$i], $listClasses[$i], $averageCredits)) {
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

function suggestDistribution($classes, $professors, $averageCredits) {
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

	return(exchange(array(), $classes, $listProfessor, $averageCredits, $type));
}

function sortCountElements($item1, $item2) {
	$c1 = count($item1);
	$c2 = count($item2);
	if ($c1 == $c2) return 0;
	return ($c1 < $c2) ? -1 : 1;
}

function confirmSolutions($solutions, &$classes, $keyClass, &$disciplinesChosen, $level) {
	foreach ($solutions as $solution) {
		$class = $classes[$keyClass][$solution->class];
		unset($classes[$keyClass][$solution->class]);

		$professor = $disciplinesChosen[$class->discipline . '-' . $class->period][$level][$solution->professor]->professor;
		ProfessorPR::addClassToProfessor($class, $professor);

		$disciplinesChosen[$class->discipline . '-' . $class->period][$level][$solution->professor]->quantity --;
		if ($disciplinesChosen[$class->discipline . '-' . $class->period][$level][$solution->professor]->quantity == 0) {
			unset($disciplinesChosen[$class->discipline . '-' . $class->period][$level][$solution->professor]);
		}
	}
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

	for ($j = 0; $j < $OFFER_LIST_QUANTITY_ATTEMPTS; $j++) {
		$classes = unserialize($classesJson);
		$listProfessors = unserialize($listProfessorsJson);

		//TODO começa aqui o loop
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

				if (count($class) >= $count) {

					$temporarySolution = suggestDistribution($class, $disciplinesChosen[$key][1], $creditsEachProfessor);

					$solution = array_merge($solution, $temporarySolution);

					confirmSolutions($temporarySolution, $classes, $keyClass, $disciplinesChosen, 1);
					$options[1] += count($temporarySolution);

					if (!count($classes[$keyClass])) {
						$remove[] = $keyClass;
					}
				} else {

					//TODO: distribuir apenas para os professores que escolheram mais que uma turma da disciplina.
					$professors = $disciplinesChosen[$key][1];
					shuffle($professors);
					foreach ($professors as $professor) {

						if (count($class) > 0 && $professor->quantity > 1) {

							$temporarySolution = suggestDistribution($class, array($professor), $creditsEachProfessor);

							$solution = array_merge($solution, $temporarySolution);

							confirmSolutions($temporarySolution, $classes, $keyClass, $disciplinesChosen, 1);
							$options[1] += count($temporarySolution);

							if (!count($classes[$keyClass])) {
								$remove[] = $keyClass;
							}
						}
					}
				}
			}
		}

		for ($t = count($remove) - 1; $t >= 0; $t--) {
			unset($classes[$remove[$t]]);
		}

		//TODO: Distrubir as turmas indo do 1 para a 6 escolha
		for ($i = 1; $i <= $QUANTITY_PREFERRED_DISCIPLINE; $i++) {
			$remove = array();
			foreach ($classes as $keyClass => $class) {
				$c = array_values($class);
				$c = $c[0];
				$key = $c->discipline . '-' . $c->period;

				if (isset($disciplinesChosen[$key][$i])) {
					$temporarySolution = suggestDistribution($class, $disciplinesChosen[$key][$i], $creditsEachProfessor);

					$solution = array_merge($solution, $temporarySolution);

					confirmSolutions($temporarySolution, $classes, $keyClass, $disciplinesChosen, $i);
					$options[$i] += count($temporarySolution);

					if (!count($classes[$keyClass])) {
						$remove[] = $keyClass;
					}
				}
			}

			for ($t = count($remove) - 1; $t >= 0; $t--) {
				unset($classes[$remove[$t]]);
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
		} elseif (count($solution) == count($solutionBest)) {
//			echo "M0<br>";
			if($creditsCount > $creditsCountBest) {
//				echo "M0.2<br>";
				$solutionBest = $solution;
				$creditsCountBest = $creditsCount;
				$optionsBest = $options;
			} elseif($creditsCount == $creditsCountBest) {
//				echo "M1<br>";
				if ($options[1] > $optionsBest[1]) {
//					echo "M1.1<br>";
					$solutionBest = $solution;
					$creditsCountBest = $creditsCount;
					$optionsBest = $options;
				} elseif ($options[1] == $optionsBest[1]) {
//					echo "M2<br>";
					if ($options[2] > $optionsBest[2]) {
//						echo "M2.1<br>";
						$solutionBest = $solution;
						$creditsCountBest = $creditsCount;
						$optionsBest = $options;
					} elseif ($options[2] == $optionsBest[2]) {
//						echo "M3<br>";
						if ($options[3] > $optionsBest[3]) {
//							echo "M3.1<br>";
							$solutionBest = $solution;
							$creditsCountBest = $creditsCount;
							$optionsBest = $options;
						} elseif ($options[3] == $optionsBest[3]) {
//							echo "M4<br>";
							if ($options[4] > $optionsBest[4]) {
//								echo "M4.1<br>";
								$solutionBest = $solution;
								$creditsCountBest = $creditsCount;
								$optionsBest = $options;
							} elseif ($options[4] == $optionsBest[4]) {
//								echo "M5<br>";
								if ($options[5] > $optionsBest[5]) {
//									echo "M5.1<br>";
									$solutionBest = $solution;
									$creditsCountBest = $creditsCount;
									$optionsBest = $options;
								} elseif ($options[5] == $optionsBest[5]) {
//									echo "M6<br>";
									if ($options[6] > $optionsBest[6]) {
//										echo "M6.1<br>";
										$solutionBest = $solution;
										$creditsCountBest = $creditsCount;
										$optionsBest = $options;
									}
								}
							}
						}
					}
				}
			}
		}
	}

	$magisterialMC = new MagisterialOfferListMC();
	foreach ($solutionBest as $solution) {
		$parts = explode('-', $solution->class);
		if (count($parts) > 1) {
			$magisterialMC->updateProfessor($parts[0], $solution->professor);
		} else {
			$oltMC->updateProfessor($parts[0], $solution->professor);
		}
	}

	p($solutionBest);
	echo "<pre>Turmas Preenchidas: " . count($solutionBest);
	echo "\nCr&eacute;ditos Preenchidos: $creditsCountBest\n";

	foreach ($optionsBest as $key => $option) {
		echo "\nOp&atilde;&atilde;o $key: $option";
	}
	echo "</pre>";
} else {
	p("Sem permiss&atilde;o para acessar o m&oacute;dulo ou semestre n&atilde;o est&aacute; na etapa de distribui&atilde;&atilde;o da LO.");
}