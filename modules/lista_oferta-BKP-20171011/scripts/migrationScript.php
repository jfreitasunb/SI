<?php

require_once '../conf/default.php';

if($DEVELOPMENT && isset($_GET['year']) && isset($_GET['semester'])) {
	require_once $ROOT_PATH.'modelController/semesterMC.php';
	require_once $ROOT_PATH.'modelController/offerListMC.php';
	require_once $ROOT_PATH.'modelController/magisterialMC.php';
	require_once $ROOT_PATH.'modelController/offerListTemporaryMC.php';
	require_once $ROOT_PATH.'modelController/preferredDisciplinesGraduationMC.php';
	require_once $ROOT_PATH.'modelController/preferredDisciplinesGraduationOldMC.php';

	$semesterCloned = new stdClass();
	$semesterCloned->year = $_GET['year'];
	$semesterCloned->semester = $_GET['semester'];

	$semesterMC = new SemesterMC();
	$semester = $semesterMC->last();
	$semester->status = SemesterDAO::STATUS_STAGE_1;
	$semester->semester += 1;


	$semesterMC->create($semester);

	$offerListMC = new OfferListMC();
	$classes = $offerListMC->classesForSemester($semesterCloned);

	foreach ($classes as $class) {
		$class->year = $semester->year;
		$class->semester = $semester->semester;
		$class->class = str_replace(' ', '', $class->class);
		if (!strcmp($class->period, "Ambos")) {
			$schedule = explode("-", $class->schedule);
			$time = substr($schedule[0], 1);
			if ($time < 19) {
				$class->period = "Diurno";
			} else {
				$class->period = "Noturno";
			}
		}
		unset($class->professor);
	}

	$oltMC = new OfferListTemporaryMC();
	$oltMC->insertByCloning($classes);

	$magisterialMC = new MagisterialMC();
	$magisterialDisciplines = $magisterialMC->arrayDisciplineKeyBySemester($semesterCloned);
	foreach ($magisterialDisciplines as &$discipline) {
		$discipline->year = $semester->year;
		$discipline->semester = $semester->semester;
		$magisterialMC->insert($discipline);
	}
	$magisterialDisciplines = $magisterialMC->arrayDisciplineKeyBySemester($semester);

	$magisterialGroups = $magisterialMC->theoryGroups($semesterCloned);
	foreach ($magisterialGroups as &$group) {
		$group->year = $semester->year;
		$group->semester = $semester->semester;
		$group->class = str_replace(' ', '', $group->class);
		$magisterialMC->insertTheoryGroup($group);
	}

	$pdgoMC = new PreferredDisciplinesGraduationOldMC();
	$list = $pdgoMC->getListBySemester($semesterCloned);

	$listOld = array();
	foreach ($list as $value) {
		$discipline = $value->discipline;
		if (strlen($discipline) > 8) {
			$discipline = substr($discipline, 0, strlen($discipline) - 3);
		}
		if (isset($magisterialDisciplines[$discipline])) {
			if (strlen($value->discipline) > 8) {
				$value->discipline = $discipline;
				$value->type = "T";
			} else {
				$value->type = "E";
			}

			if (!strcasecmp($value->period, "ddd") || !strcasecmp($value->period, "dd") || !strcasecmp($value->period, "d")) {
				$value->period = "Diurno";
			}
			if (!strcasecmp($value->period, "nnn") || !strcasecmp($value->period, "nn") || !strcasecmp($value->period, "n")) {
				$value->period = "Noturno";
			}
			if (strcasecmp($value->period, "Noturno") && strcasecmp($value->period, "Diurno")) {
				$strings = array(
					'Noturno',
					'Diurno',
				);
				$key = array_rand($strings);
				$value->period = $strings[$key];
			}
		}

		$value->year = $semester->year;
		$value->semester = $semester->semester;
		$value->quantity = 1;
		$listOld[$value->user_id][$value->rank] = $value;
	}

	$pdgMC = new PreferredDisciplinesGraduationMC();
	foreach ($listOld as $key => $value) {
		$pdgMC->changeUserSemester($value, $key, $semester);
	}
//	p($magisterialGroups);
//	p($classes);
//	p($listOld);
	p("Foi");
}