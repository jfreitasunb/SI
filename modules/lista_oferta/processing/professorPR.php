<?php

require_once $ROOT_PATH.'utils/creditsUT.php';
require_once $ROOT_PATH.'utils/magisterialUT.php';
require_once $ROOT_PATH.'utils/utilUT.php';

require_once $ROOT_PATH.'modelController/offerListTemporaryMC.php';
require_once $ROOT_PATH.'modelController/userMC.php';
require_once $ROOT_PATH.'modelController/professorMC.php';
require_once $ROOT_PATH.'modelController/preferredDisciplinesGraduationMC.php';
require_once $ROOT_PATH.'modelController/nightShiftMC.php';

class ProfessorPR {
	static public function activeProfessorsWithCredits($semester) {
		$professorMC = new ProfessorMC();
		$listProfessors = $professorMC->listActiveExclusive($semester);
		$listProfessors = UtilUT::changeKey($listProfessors, "professor");

		$oltMC = new OfferListTemporaryMC();
		$tempOfferList = $oltMC->getListWithDisciplineOfSemesterAndDiscipline($semester);
		$tempOfferList = UtilUT::changeKey($tempOfferList);
		$tempOfferList = MagisterialUT::adjustClassList($tempOfferList);

		$professorsCredits = CreditsUT::listProfessorsCredits($semester);

		foreach ($tempOfferList as $class) {
			$class->schedule2 = str_replace('-', ' ', $class->schedule);

			if (strlen($class->professor)) {
				if (!isset($listProfessors[$class->professor]->schedule_description)) {
					$listProfessors[$class->professor]->schedule_description = "";
				}
				$listProfessors[$class->professor]->schedule_description .= ' ' . $class->schedule2;

				// $classObj = new stdClass();
				// $classObj->id = $class->id;
				// $classObj->discipline = $class->discipline;
				// $classObj->period = $class->period;

				$listProfessors[$class->professor]->classes[$class->id] = $class;

				$hoursArray = explode('-', $class->schedule);
				
				foreach ($hoursArray as $hour) {
					if (!isset($listProfessors[$class->professor]->schedule[$hour])) {
						$listProfessors[$class->professor]->schedule[$hour] = $class->id;
					}
				}
			}
		}

		// p($listProfessors);

		$pdgMC = new PreferredDisciplinesGraduationMC();
		$preferredDisciplines = $pdgMC->getListBySemester($semester);

		foreach($listProfessors as $professor) {
			$professor->credits = 0;
			$professor->credits_graduation = 0;
			$professor->credits_post = 0;
			$professor->credits_extra = 0;
			if (isset($professorsCredits[$professor->id])) {
				foreach($professorsCredits[$professor->id] as $key => $credit) {
					$professor->credits += $credit;
					$key = "credits_" . $key;
					$professor->$key = $credit;
				}
			}
			$professor->credits_class = $professor->credits_graduation + $professor->credits_post;
			if (isset($preferredDisciplines[$professor->id])) {
				$professor->choices = array();
				foreach ($preferredDisciplines[$professor->id] as $key => $discipline) {
					$type = strlen($discipline->type) ? "-$discipline->type" : "";
					$key2 = "option$key";
					$professor->$key2 = $discipline->discipline . $type . "-" . $discipline->period;
					$professor->choices[$key] = new stdClass();
					$professor->choices[$key]->discipline = $professor->$key2;
					$professor->choices[$key]->quantity = $discipline->quantity;

					$key2 = "quantity-option$key";
					$professor->$key2 = $discipline->quantity;
				}
			}
		}

		return $listProfessors;
	}

	static public function creditsProfessorNeed($professor, $averageCredits) {
		global $CREDITS_MIN_GRADUATION, $CREDITS_MIN_CLASS, $CREDITS_PLUS_AVERAGE;
		$credits = 0;

		$credits_graduation = $professor->credits_graduation;
		$credits_graduation += isset($professor->credits_tmp) ? $professor->credits_tmp : 0;

		if ($credits_graduation < $CREDITS_MIN_GRADUATION) {
			$credits = $CREDITS_MIN_GRADUATION - $credits_graduation;
		}

		if (($credits + $credits_graduation + $professor->credits_post) < $CREDITS_MIN_CLASS) {
			$credits = $CREDITS_MIN_CLASS - $credits_graduation - $professor->credits_post;
		}

		if (($credits + $credits_graduation + $professor->credits_post + $professor->credits_extra) < $averageCredits) {
			$credits = $averageCredits - $credits_graduation - $professor->credits_post - $professor->credits_extra;
		}

		if ($credits > 0) {
			$credits += $CREDITS_PLUS_AVERAGE;
		}

		return $credits;


//		if ($professor->credits_graduation >= 4) {
//			if ($professor->credits_graduation + $professor->credits_post >= 8) {
//				if ($professor->credits >= $quantity) {
//					return false;
//				}
//			}
//		}
//		return true;
	}

	static public function professorCanGetClass($professor, $class, $averageCredits, $bypass) {
		if ($bypass || $class->discipline_credits <= self::creditsProfessorNeed($professor, $averageCredits)) {
			$hoursArray = explode('-', $class->schedule);
//			p($hoursArray);
//			p($professor);
			foreach ($hoursArray as $hour) {
//				p("Quase pode");
				if (isset($professor->schedule[$hour]) || isset($professor->scheduleTmp[$hour])) {
//					p("Não pode");
					return false;
				}
			}
//			p("Agora pode sempre");
			return true;
		}
//		p("Não pode");
		return false;
	}

	static public function addTemporaryClassToProfessor($class, &$professor) {
		$hoursArray = explode('-', $class->schedule);
		foreach ($hoursArray as $hour) {
			$professor->scheduleTmp[$hour] = $class->id;
		}
		$professor->credits_tmp = $class->discipline_credits;
	}

	static public function cleanTemporaryClassFromProfessor(&$professor) {
		$professor->scheduleTmp = array();
		$professor->credits_tmp = 0;
	}

	static public function addClassToProfessor($class, &$professor) {
		$hoursArray = explode('-', $class->schedule);
		foreach ($hoursArray as $hour) {
			$professor->schedule[$hour] = $class->id;
		}
		$professor->credits += $class->discipline_credits;
		$professor->credits_graduation += $class->discipline_credits;
	}

	static public function professorNightShift($semester) {
		$userMC = new userMC();
		$listProfessors = $userMC->activeTeachersList();
		$listProfessors = UtilUT::changeKey($listProfessors);
		$listProfessors = UtilUT::changeValue($listProfessors, "total_points", 0);
		$listProfessors = UtilUT::changeValue($listProfessors, "year");
		$listProfessors = UtilUT::changeValue($listProfessors, "semester");

		$nightShiftMC = new NightShiftMC();
		$nightShiftPoints = $nightShiftMC->listUntilSemester($semester);
		foreach ($nightShiftPoints as $nightShift) {
			if (isset($listProfessors[$nightShift->professor]) && $nightShift->quantity > 0) {
				$professor = $listProfessors[$nightShift->professor];
				$professor->total_points += $nightShift->quantity;

				if ($nightShift->year > $professor->year || ($nightShift->semester == 2 && $nightShift->year == $professor->year)) {
					$professor->year = $nightShift->year;
					$professor->semester = $nightShift->semester;
				}
			}
		}
		usort($listProfessors, function($a, $b)
		{
			if ($a->total_points > $b->total_points) {
				return true;
			} elseif ($a->total_points < $b->total_points) {
				return false;
			}

			if ($a->year > $b->year) {
				return true;
			} elseif ($a->year < $b->year) {
				return false;
			}

			if ($a->semester > $b->semester) {
				return true;
			} elseif ($a->semester < $b->semester) {
				return false;
			}

			return strcmp($a->name.$a->last_name, $b->name.$b->last_name);
		});
		return $listProfessors;
	}

	static public function updateActiveProfessors($semester)
	{
		$userMC = new userMC();
		$listProfessorsSI = UtilUT::changeKey($userMC->activeTeachersList());

		$professorMC = new ProfessorMC();
		$listActiveProfessors = $professorMC->listProfessors($semester);

		foreach ($listActiveProfessors as $professor) {
			if (isset($listProfessorsSI[$professor->professor])) {
				unset($listProfessorsSI[$professor->professor]);
			}
		}

		$professorMC->insertListInSemester($listProfessorsSI, $semester);
	}
}
