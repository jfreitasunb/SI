<?php

require_once $ROOT_PATH.'modelController/magisterialMC.php';
require_once $ROOT_PATH.'modelController/magisterialOfferListMC.php';

class MagisterialUT {

	const THEORY_SHORT_DESCRIPTION = 'TEORIA';
	const EXERCISE_SHORT_DESCRIPTION = 'EXERCÍCIO';
	const THEORY_DESCRIPTION = 'MAGISTRAL TEORIA';
	const EXERCISE_DESCRIPTION = 'MAGISTRAL EXERCÍCIO';

	/**
	 * @param array $disciplineList
	 * @return array
     */
	static public function modifyListDisciplines($disciplineList) {
		GLOBAL $MODULE_MAGISTERIAL;

		$return = array();
		if ($MODULE_MAGISTERIAL) {
			$discipline = array_values($disciplineList);
			$discipline = $discipline[0];

			$semester = new stdClass();
			$semester->year = $discipline->year;
			$semester->semester = $discipline->semester;

			$magisterialMC = new MagisterialMC();
			$listMagisterial = $magisterialMC->arrayDisciplineKeyBySemester($semester);

			foreach ($disciplineList as $value) {
				if (isset($listMagisterial[$value->discipline]) && $magisterial = $listMagisterial[$value->discipline]) {
					$exercise = clone $value;
					$exercise->discipline_name .= " ".self::EXERCISE_DESCRIPTION;
					if (isset($value->id)) {
						$exercise->id .= "-" . MagisterialDAO::EXERCISE;
					}
					$exercise->discipline .= "-" . MagisterialDAO::EXERCISE;
					$exercise->discipline_credits = $magisterial->exercises_quantity;

					$return[] = $exercise;

					$theory = clone $value;
					$theory->discipline_name .= " ".self::THEORY_DESCRIPTION;
					if (isset($value->id)) {
						$theory->id .= "-" . MagisterialDAO::THEORY;
					}
					$theory->discipline .= "-" . MagisterialDAO::THEORY;
					$theory->discipline_credits = $magisterial->theory_quantity;
					$return[] = $theory;
				} else {
					$return[] = $value;
				}
			}
		} else {
			$return = $disciplineList;
		}
		return $return;
	}

	static public function creditsOfProfessorAtSemester($professor, $semester) {
		GLOBAL $MODULE_MAGISTERIAL;

		$credits = 0;
		if ($MODULE_MAGISTERIAL) {
			$magisterialMC = new MagisterialMC();
			$listMagisterial = $magisterialMC->arrayDisciplineKeyBySemester($semester);

			$magisterialOfferListMC = new MagisterialOfferListMC();
			$listClasses = $magisterialOfferListMC->listByProfessorSemester($professor, $semester);

			foreach ($listClasses as $class) {
				$credits += $class->type == MagisterialDAO::EXERCISE ? $listMagisterial[$class->discipline]->exercises_quantity :
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
			$magisterialMC = new MagisterialMC();
			$magisterialOfferListMC = new MagisterialOfferListMC();

			$theoryGroups = $magisterialMC->theoryGroups($semester);
			$listMagisterial = $magisterialMC->arrayDisciplineKeyBySemester($semester);
			$magisterialOfferList = $magisterialOfferListMC->listBySemester($semester);

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
				$aux[$object->discipline][MagisterialDAO::EXERCISE][$object->class] = $object;
				$aux[$object->discipline][MagisterialDAO::THEORY][$auxTheoryGroups[$object->group.$object->schedule][0]->class][] = $object->class;
			}
			$theoryGroups = $aux;
//p($listMagisterial);
			foreach ($theoryGroups as $discipline => $groups) {
				foreach ($groups[MagisterialDAO::EXERCISE] as $class => $object) {

					if (!isset($magisterialOfferList[$object->discipline][MagisterialDAO::EXERCISE][$object->class])) {
//p($listClassAux);
//p($object);
						$class = clone $listClassAux[$object->discipline][$object->class];

						//remover o horário da teoria
						$theory = $theoryGroups[$class->discipline . $class->class];
						$schedule = explode('-', $class->schedule);
						unset($schedule[array_search($theory->schedule, $schedule)]);
						$class->schedule = implode("-", $schedule);
						$class->type = MagisterialDAO::EXERCISE;

						$magisterialOfferListMC->insert($class);
					} else {
//						p("Ver se troço está atualizado:");
//						p($magisterialOfferList[$object->discipline][MagisterialDAO::EXERCISE][$object->class]);
					}

					$theoryMainClass = $auxTheoryGroups[$object->group.$object->schedule][0];
					if (!isset($magisterialOfferList[$object->discipline][MagisterialDAO::THEORY][$theoryMainClass->class])) {
						$class = clone $listClassAux[$object->discipline][$object->class];

						//Arrumando as turmas e o horário para inserir
						$class->class = implode("-", $theoryGroups[$discipline][MagisterialDAO::THEORY][$theoryMainClass->class]);
						$class->schedule = $theoryMainClass->schedule;
						$class->type = MagisterialDAO::THEORY;

						$magisterialOfferListMC->insert($class);

						$magisterialOfferList[$object->discipline][MagisterialDAO::THEORY][$theoryMainClass->class] = 1;
					} else {
//						p("Ver se troço está atualizado:");
//						p($magisterialOfferList[$object->discipline][MagisterialDAO::THEORY][$theoryMainClass->class]);
					}
				}
			}

			$magisterialOfferList = $magisterialOfferListMC->listBySemester($semester);

			$lastClassId = null;
			foreach ($listClass as $class) {
				if($lastClassId !== null && $lastClassId != $class->discipline) {
					foreach ($magisterialOfferList[$lastClassId][MagisterialDAO::THEORY] as $magisterialClass) {
						$magisterialClass->id .= "-" . MagisterialDAO::THEORY;
						$magisterialClass->discipline_name .= " " . self::THEORY_SHORT_DESCRIPTION;
						$magisterialClass->discipline .= "-" . MagisterialDAO::THEORY;
						$magisterialClass->discipline_credits = $listMagisterial[$lastClassId]->theory_quantity;

						$return[$magisterialClass->id] = $magisterialClass;
					}
					foreach ($magisterialOfferList[$lastClassId][MagisterialDAO::EXERCISE] as $magisterialClass) {
						$magisterialClass->id .= "-" . MagisterialDAO::EXERCISE;
						$magisterialClass->discipline_name .= " " . self::EXERCISE_SHORT_DESCRIPTION;
						$magisterialClass->discipline .= "-" . MagisterialDAO::EXERCISE;
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
				foreach ($magisterialOfferList[$lastClassId][MagisterialDAO::THEORY] as $magisterialClass) {
					$magisterialClass->id .= "-" . MagisterialDAO::THEORY;
					$magisterialClass->discipline_name .= " " . self::THEORY_SHORT_DESCRIPTION;
					$magisterialClass->discipline .= "-" . MagisterialDAO::THEORY;
					$magisterialClass->discipline_credits = $listMagisterial[$lastClassId]->theory_quantity;

					$return[$magisterialClass->id] = $magisterialClass;
				}
				foreach ($magisterialOfferList[$lastClassId][MagisterialDAO::EXERCISE] as $magisterialClass) {
					$magisterialClass->id .= "-" . MagisterialDAO::EXERCISE;
					$magisterialClass->discipline_name .= " " . self::EXERCISE_SHORT_DESCRIPTION;
					$magisterialClass->discipline .= "-" . MagisterialDAO::EXERCISE;
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

			$magisterialOfferList = $molMC->listBySemester($semester);

			foreach ($listClass as $class) {
				if (strlen($class->professor) == 0) {
					$class->professor = $magisterialOfferList[$class->discipline]['E'][$class->class]->professor;
				}
			}
		}
	}
}


////remover o horário da teoria
//$theory = $theoryGroups[$class->discipline . $class->class];
//$schedule = explode('-', $class->schedule);
//unset($schedule[array_search($theory->schedule, $schedule)]);
//$class->schedule = implode("-", $schedule);