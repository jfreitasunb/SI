<?php

require_once $ROOT_PATH.'utils/utilUT.php';

require_once $ROOT_PATH.'modelController/magisterialDisciplineMC.php';
require_once $ROOT_PATH.'modelController/magisterialTheoryGroupsMC.php';
require_once $ROOT_PATH.'modelController/magisterialOfferListMC.php';
require_once $ROOT_PATH.'modelController/offerListTemporaryMC.php';

class MagisterialUT {

	const THEORY_SHORT_DESCRIPTION = 'TEORIA';
	const EXERCISE_SHORT_DESCRIPTION = 'EXERC&Iacute;CIO';
	const THEORY_DESCRIPTION = 'MAGISTRAL TEORIA';
	const EXERCISE_DESCRIPTION = 'MAGISTRAL EXERC&Iacute;CIO';

	/**
	 * @param array $disciplineList
	 * @return array
     */
	static public function modifyListDisciplines($disciplineList) {
		GLOBAL $MODULE_MAGISTERIAL;

		if (!$MODULE_MAGISTERIAL) {
			return $disciplineList;
		}

		$return = array();

		$discipline = array_values($disciplineList);
		$discipline = $discipline[0];

		$semester = new stdClass();
		$semester->year = $discipline->year;
		$semester->semester = $discipline->semester;

		$magisterialOfferListMC = new MagisterialOfferListMC();

		$magisterialOfferList = $magisterialOfferListMC->listBySemesterGroupedByMagisterialAndPeriod($semester);

		foreach ($disciplineList as $value) {
			if (isset($magisterialOfferList[$value->discipline]) && $magisterial = $magisterialOfferList[$value->discipline]) {
				$exercise = clone $value;
				$exercise->discipline_name .= " ".self::EXERCISE_DESCRIPTION;
				if (isset($value->id)) {
					$exercise->id .= "-" . MagisterialDisciplineDAO::EXERCISE;
				}
				$exercise->discipline .= "-" . MagisterialDisciplineDAO::EXERCISE;

				$v = array_values($magisterial["E"][$value->period]);
				$exercise->quantity = count($v);

				$v = $v[0];
				$exercise->discipline_credits = $v->discipline_credits;

				$return[] = $exercise;

				$theory = clone $value;
				$theory->discipline_name .= " ".self::THEORY_DESCRIPTION;
				if (isset($value->id)) {
					$theory->id .= "-" . MagisterialDisciplineDAO::THEORY;
				}
				$theory->discipline .= "-" . MagisterialDisciplineDAO::THEORY;

				$v = array_values($magisterial["T"][$value->period]);
				$theory->quantity = count($v);

				$v = $v[0];
				$theory->discipline_credits = $v->discipline_credits;

				$return[] = $theory;
			} else {
				$return[] = $value;
			}
		}
		return $return;
	}

	/**
	 * @param array $disciplines
	 * @return array
     */
	static public function modifyDisciplines($disciplines) {
		GLOBAL $MODULE_MAGISTERIAL;

		if (!$MODULE_MAGISTERIAL) {
			return $disciplines;
		}

		$return = array();

		$discipline = array_values($disciplines);
		$discipline = $discipline[0];

		$semester = new stdClass();
		$semester->year = $discipline->year;
		$semester->semester = $discipline->semester;

		$magisterialDisciplineMC = new MagisterialDisciplineMC();

		$magisterialDisciplinesList = $magisterialDisciplineMC->disciplineKeyFromSemester($semester);

		foreach ($disciplines as $discipline) {
			if (isset($magisterialDisciplinesList[$discipline->id]) && $magisterial = $magisterialDisciplinesList[$discipline->id]) {
				$exercise = clone $discipline;

				$exercise->id .= "-" . MagisterialDisciplineDAO::EXERCISE;
				$exercise->name .= " " . self::EXERCISE_SHORT_DESCRIPTION;
				$exercise->credits = $magisterial->exercises_quantity;

				$return[] = $exercise;

				$theory = clone $discipline;

				$theory->id .= "-" . MagisterialDisciplineDAO::THEORY;
				$theory->name .= " " . self::THEORY_SHORT_DESCRIPTION;
				$theory->credits = $magisterial->theory_quantity;

				$return[] = $theory;
			} else {
				$return[] = $discipline;
			}
		}
		return $return;
	}

	static public function creditsOfProfessorAtSemester($professor, $semester) {
		GLOBAL $MODULE_MAGISTERIAL;

		$credits = 0;
		if ($MODULE_MAGISTERIAL) {
			$magisterialDisciplineMC = new MagisterialDisciplineMC();
			$listMagisterial = $magisterialDisciplineMC->disciplineKeyFromSemester($semester);

			$magisterialOfferListMC = new MagisterialOfferListMC();
			$listClasses = $magisterialOfferListMC->listByProfessorSemester($professor, $semester);

			foreach ($listClasses as $class) {
				$credits += $class->type == MagisterialDisciplineDAO::EXERCISE ? $listMagisterial[$class->discipline]->exercises_quantity :
					$listMagisterial[$class->discipline]->theory_quantity;
			}
		}
		return $credits;
	}

	static public function adjustPreferredDisciplines($listPD) {
		GLOBAL $MODULE_MAGISTERIAL;

		$return = array();
		if ($MODULE_MAGISTERIAL) {
			foreach ($listPD as $preferredDiscipline) {
				if (strlen($preferredDiscipline->type)) {
					$preferredDiscipline->discipline .= "-$preferredDiscipline->type";
				}
				$return[] = $preferredDiscipline;
			}
		} else {
			$return = $listPD;
		}
		return $return;
	}

	static public function adjustClassList($listClass) {
		GLOBAL $MODULE_MAGISTERIAL;

		$return = array();
		if ($MODULE_MAGISTERIAL) {
			$semester = array_values($listClass);
			$semester = $semester[0];
			$magisterialDisciplineMC = new MagisterialDisciplineMC();
			$magisterialTGMC = new MagisterialTheoryGroupsMC();
			$magisterialOfferListMC = new MagisterialOfferListMC();

			$theoryGroups = $magisterialTGMC->fromSemester($semester);
			$listMagisterial = $magisterialDisciplineMC->disciplineKeyFromSemester($semester);
			$magisterialOfferList = $magisterialOfferListMC->listBySemesterGroupedByMagisterial($semester);

			$listClassAux = array();
			foreach ($listClass as $object) {
				if (isset($listMagisterial[$object->discipline])) {
					$class = clone $object;

					$listClassAux[$class->discipline][$class->class] = $class;
				}
			}

			$aux = array();
			$auxTheoryGroups = array();
			foreach ($theoryGroups as $object) {
				$auxTheoryGroups[$object->group.$object->schedule][] = $object;
				$aux[$object->discipline][MagisterialDisciplineDAO::EXERCISE][$object->class] = $object;
				$aux[$object->discipline][MagisterialDisciplineDAO::THEORY][$auxTheoryGroups[$object->group.$object->schedule][0]->class][] = $object->class;
			}
			$theoryGroups = $aux;
//p($listMagisterial);
			foreach ($theoryGroups as $discipline => $groups) {
				foreach ($groups[MagisterialDisciplineDAO::EXERCISE] as $class => $object) {

					if (!isset($magisterialOfferList[$object->discipline][MagisterialDisciplineDAO::EXERCISE][$object->class])) {
//p($listClassAux);
//p($object);
						$class = clone $listClassAux[$object->discipline][$object->class];

						//remover o horário da teoria
						$theory = $theoryGroups[$class->discipline . $class->class];
						$schedule = explode('-', $class->schedule);
						unset($schedule[array_search($theory->schedule, $schedule)]);
						$class->schedule = implode("-", $schedule);
						$class->type = MagisterialDisciplineDAO::EXERCISE;

						$magisterialOfferListMC->insert($class);
					} else {
//						p("Ver se troço está atualizado:");
//						p($magisterialOfferList[$object->discipline][MagisterialDAO::EXERCISE][$object->class]);
					}

					$theoryMainClass = $auxTheoryGroups[$object->group.$object->schedule][0];
					if (!isset($magisterialOfferList[$object->discipline][MagisterialDisciplineDAO::THEORY][$theoryMainClass->class])) {
						$class = clone $listClassAux[$object->discipline][$object->class];

						//Arrumando as turmas e o horário para inserir
						$class->class = implode("-", $theoryGroups[$discipline][MagisterialDisciplineDAO::THEORY][$theoryMainClass->class]);
						$class->schedule = $theoryMainClass->schedule;
						$class->type = MagisterialDisciplineDAO::THEORY;

						$magisterialOfferListMC->insert($class);

						$magisterialOfferList[$object->discipline][MagisterialDisciplineDAO::THEORY][$theoryMainClass->class] = 1;
					} else {
//						p("Ver se troço está atualizado:");
//						p($magisterialOfferList[$object->discipline][MagisterialDAO::THEORY][$theoryMainClass->class]);
					}
				}
			}

			$magisterialOfferList = $magisterialOfferListMC->listBySemesterGroupedByMagisterial($semester);

			$lastClassId = null;
			foreach ($listClass as $class) {
				if($lastClassId !== null && $lastClassId != $class->discipline) {
					foreach ($magisterialOfferList[$lastClassId][MagisterialDisciplineDAO::THEORY] as $magisterialClass) {
						$magisterialClass->id .= "-" . MagisterialDisciplineDAO::THEORY;
						$magisterialClass->discipline_name .= " " . self::THEORY_SHORT_DESCRIPTION;
						$magisterialClass->discipline .= "-" . MagisterialDisciplineDAO::THEORY;
						$magisterialClass->discipline_credits = $listMagisterial[$lastClassId]->theory_quantity;

						$return[$magisterialClass->id] = $magisterialClass;
					}
					foreach ($magisterialOfferList[$lastClassId][MagisterialDisciplineDAO::EXERCISE] as $magisterialClass) {
						$magisterialClass->id .= "-" . MagisterialDisciplineDAO::EXERCISE;
						$magisterialClass->discipline_name .= " " . self::EXERCISE_SHORT_DESCRIPTION;
						$magisterialClass->discipline .= "-" . MagisterialDisciplineDAO::EXERCISE;
						$magisterialClass->discipline_credits = $listMagisterial[$lastClassId]->exercises_quantity;

						$return[$magisterialClass->id] = $magisterialClass;
					}

					$lastClassId = null;
				}

				if (!isset($listMagisterial[$class->discipline])) {
					$return[$class->id] = $class;
				} else {
					$lastClassId = $class->discipline;
				}
			}
			if($lastClassId !== null) {
				foreach ($magisterialOfferList[$lastClassId][MagisterialDisciplineDAO::THEORY] as $magisterialClass) {
					$magisterialClass->id .= "-" . MagisterialDisciplineDAO::THEORY;
					$magisterialClass->discipline_name .= " " . self::THEORY_SHORT_DESCRIPTION;
					$magisterialClass->discipline .= "-" . MagisterialDisciplineDAO::THEORY;
					$magisterialClass->discipline_credits = $listMagisterial[$lastClassId]->theory_quantity;

					$return[$magisterialClass->id] = $magisterialClass;
				}
				foreach ($magisterialOfferList[$lastClassId][MagisterialDisciplineDAO::EXERCISE] as $magisterialClass) {
					$magisterialClass->id .= "-" . MagisterialDisciplineDAO::EXERCISE;
					$magisterialClass->discipline_name .= " " . self::EXERCISE_SHORT_DESCRIPTION;
					$magisterialClass->discipline .= "-" . MagisterialDisciplineDAO::EXERCISE;
					$magisterialClass->discipline_credits = $listMagisterial[$lastClassId]->exercises_quantity;

					$return[$magisterialClass->id] = $magisterialClass;
				}
			}
		} else {
			$return = $listClass;
		}

		return $return;
	}

	/**
	 * @param array $listClass
	 */
	static public function professorsExerciseToClass($listClass) {
		GLOBAL $MODULE_MAGISTERIAL;

		if ($MODULE_MAGISTERIAL) {
			$semester = array_values($listClass);
			$semester = $semester[0];
			$molMC = new MagisterialOfferListMC();

			$magisterialOfferList = $molMC->listBySemesterGroupedByMagisterial($semester);

			foreach ($listClass as $class) {
				if (strlen($class->professor) == 0) {
					$class->professor = $magisterialOfferList[$class->discipline]['E'][$class->class]->professor;
				}
			}
		}
	}

	/**
	 * @param SemesterTO $oldSemester
	 * @param SemesterTO $newSemester
	 */
	static public function cloneFromSemesterToSemester($oldSemester, $newSemester)
	{
		$magisterialDisciplineMC = new MagisterialDisciplineMC();
		$magisterialTGMC = new MagisterialTheoryGroupsMC();
		$mOfferListMC = new MagisterialOfferListMC();

		$magisterialDisciplineMC->cloneFromSemesterToSemester($oldSemester, $newSemester);
		$magisterialTGMC->cloneFromSemesterToSemester($oldSemester, $newSemester);
		$mOfferListMC->cloneFromSemesterToSemester($oldSemester, $newSemester);
	}


	static public function classesOfDiscipline($disciplineId, $semester) {
		$array = explode("-", $disciplineId);
		if (count($array) > 1) {
			$magisterialOfferListMC = new MagisterialOfferListMC();
			return $magisterialOfferListMC->listByDisciplineTypeSemester($array[0], $array[1], $semester);
		} else {
			$offerListTemporaryMC = new OfferListTemporaryMC();
			return $offerListTemporaryMC->getClassesAndProfessorOfDisciplineAtSemester($array[0], $semester);
		}
	}

	static public function removeDisciplineAtSemester($magisterialDisciplineID, $semester) {
		$mDisciplineMC = new MagisterialDisciplineMC();
		$mTheoryGroupMC = new MagisterialTheoryGroupsMC();
		$mOfferListMC = new MagisterialOfferListMC();

		$magisterialDiscipline = $mDisciplineMC->get($magisterialDisciplineID);

		$from = new stdClass();
		$from->discipline = $magisterialDiscipline->discipline;
		$from->semester = $semester->semester;
		$from->year = $semester->year;

		$mOfferListMC->delete($from);

		$mTheoryGroupMC->delete($from);

		$mDisciplineMC->delete($magisterialDisciplineID);
	}

	static public function updateOfferList($semester, $disciplineID = null) {
		$mDisciplineMC = new MagisterialDisciplineMC();
		$mTheoryGroupMC = new MagisterialTheoryGroupsMC();
		$mOfferListMC = new MagisterialOfferListMC();

		$mDisciplines = $mDisciplineMC->disciplineKeyFromSemester($semester);

		if (!is_null($disciplineID)) {
			if (isset($mDisciplines[$disciplineID])) {
				$mDisciplines = array($mDisciplines[$disciplineID]);
			} else {
				$mDisciplines = array();
			}
		}
		foreach ($mDisciplines as $discipline) {
			$theoryClasses = $mTheoryGroupMC->fromSemesterAndDisciplineClassKey($semester, $discipline->discipline);
			$cpClasses = $mOfferListMC->listBySemesterAndDiscipline($semester, $discipline->discipline);

			$classes = array();
			foreach ($cpClasses as $class) {
				if (isset($classes[$class->type.$class->class])) {
					$classes[$class->id] = $class;
				} else {
					$classes[$class->type . $class->class] = $class;
				}
			}
			unset($cpClasses);

			//Agrupa as turmas de teoria e atualiza o horário das turmas de Exercícios
			$groups = array();
			$cpTheoryClasses = $theoryClasses;
			foreach ($cpTheoryClasses as $tClass) {
				if (!isset($groups[$tClass->group])) {
					$group = new stdClass();
					$group->class = $tClass->class;
					$group->schedule = $tClass->schedule;
					$group->discipline = $tClass->discipline;
					$group->period = $tClass->class_period;
					$group->year = $tClass->year;
					$group->semester = $tClass->semester;

					$groups[$tClass->group] = $group;
				} elseif (!is_null($groups[$tClass->group]) && $groups[$tClass->group]->schedule != $tClass->schedule) {
					$groups[$tClass->group] = null;
				} else {
					$groups[$tClass->group]->class .= "-".$tClass->class;
				}

				//Atualiza o horário das turmas de Exercícios
				if (isset($classes[MagisterialDisciplineDAO::EXERCISE.$tClass->class])) {
					if ($classes[MagisterialDisciplineDAO::EXERCISE.$tClass->class]->schedule != self::removeTimeFromSchedule($tClass->schedule, $tClass->class_schedule)) {
						//p("  MUDAR TURMA EXERCICIO: $tClass->class, HORÁRIO DE: ".$classes[MagisterialDisciplineDAO::EXERCISE.$tClass->class]->schedule." PARA: ".self::removeTimeFromSchedule($tClass->schedule, $tClass->class_schedule));

						$mOfferListMC->updateSchedule($classes[MagisterialDisciplineDAO::EXERCISE.$tClass->class], self::removeTimeFromSchedule($tClass->schedule, $tClass->class_schedule));
					}
					unset($classes[MagisterialDisciplineDAO::EXERCISE.$tClass->class]);
					unset($theoryClasses[$tClass->class]);
				}
			}

			// Atualiza o horário das turmas de Teoria
			$groups = UtilUT::changeKey($groups, "class");
			$cpGroups = $groups;
			foreach ($cpGroups as $group) {
				if (isset($classes[MagisterialDisciplineDAO::THEORY.$group->class])) {
					if ($classes[MagisterialDisciplineDAO::THEORY.$group->class]->schedule != $groups[$group->class]->schedule) {
						//p("  MUDAR TURMA    TEORIA: $group->class HORÁRIO DE: ".$classes[MagisterialDisciplineDAO::THEORY.$group->class]->schedule." PARA: ".$group->schedule);

						$mOfferListMC->updateSchedule($classes[MagisterialDisciplineDAO::THEORY.$group->class], $group->schedule);
					}
					unset($classes[MagisterialDisciplineDAO::THEORY.$group->class]);
					unset($groups[$group->class]);
				}
			}

			//Cria as turmas de Exercícios
			foreach ($theoryClasses as $tClass) {
				//p("  CRIAR TURMA EXERCICIO: ".$tClass->class."   HORÁRIO: ".self::removeTimeFromSchedule($tClass->schedule, $tClass->class_schedule));

				$offerClass = new stdClass();
				$offerClass->discipline = $tClass->discipline;
				$offerClass->class = $tClass->class;
				$offerClass->schedule = self::removeTimeFromSchedule($tClass->schedule, $tClass->class_schedule);
				$offerClass->period = $tClass->class_period;
				$offerClass->year = $tClass->year;
				$offerClass->semester = $tClass->semester;
				$offerClass->type = MagisterialDisciplineDAO::EXERCISE;

				$mOfferListMC->insert($offerClass);
			}

			//Cria as turmas de Teoria
			foreach ($groups as $group) {
				//p("  CRIAR TURMA    TEORIA: ".$group->class." HORÁRIO: ".$group->schedule);

				$offerClass = new stdClass();
				$offerClass->discipline = $group->discipline;
				$offerClass->class = $group->class;
				$offerClass->schedule = $group->schedule;
				$offerClass->period = $group->period;
				$offerClass->year = $group->year;
				$offerClass->semester = $group->semester;
				$offerClass->type = MagisterialDisciplineDAO::THEORY;

				$mOfferListMC->insert($offerClass);
			}

			//Remove as turmas de Teoria e Exercícios
			foreach ($classes as $class) {
				//p("REMOVER TURMA: ".$class->class." ID: ".$class->id);
				$from = new stdClass();
				$from->id = $class->id;

				$mOfferListMC->delete($from);
			}
		}
	}

	static private function removeTimeFromSchedule($time, $schedule, $debug = false) {
		if ($debug) p("############### INICIO DEBUG ###############");
		if ($debug) p("$schedule <==> $time");

		$scheduleAux = explode("-", $schedule);
		$time = explode("-", $time);

		$schedule = array();
		foreach ($scheduleAux as $sch) {
			if (strlen($sch)) {
				$schedule[$sch] = $sch;
			}
		}

		foreach ($time as $tm) {
			if (strlen($tm) && isset($schedule[$tm])) {
				unset($schedule[$tm]);
			}
		}

		$schedule = implode("-", $schedule);

		if ($debug) p("RESULTADO: $schedule");
		if ($debug) p("################ FIM  DEBUG ################");
		return $schedule;
	}
}


////remover o horário da teoria
//$theory = $theoryGroups[$class->discipline . $class->class];
//$schedule = explode('-', $class->schedule);
//unset($schedule[array_search($theory->schedule, $schedule)]);
//$class->schedule = implode("-", $schedule);
