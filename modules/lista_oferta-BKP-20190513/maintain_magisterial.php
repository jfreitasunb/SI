<?php
require_once 'conf/default.php';

require_once $ROOT_PATH.'utils/moduleUT.php';

ModuleUT::validateUserModule($ID_MODULE);

require_once $ROOT_PATH.'modelController/semesterMC.php';
require_once $ROOT_PATH.'modelController/magisterialDisciplineMC.php';

$semesterMC = new SemesterMC();
$semester = $semesterMC->last();

$magisterialDisciplineMC = new MagisterialDisciplineMC();

if (isset($_GET["discipline"])) {
	require_once $ROOT_PATH.'modelController/offerListTemporaryMC.php';
	require_once $ROOT_PATH.'modelController/magisterialTheoryGroupsMC.php';

	require_once $ROOT_PATH.'viewController/maintainMagisterial/mmTheoryGroupsVC.php';

	$disciplineID = $_GET["discipline"];

	$magisterialDiscipline = $magisterialDisciplineMC->fromDisciplineAndSemester($disciplineID, $semester);

	if ($magisterialDiscipline !== null) {
		$oltMC = new OfferListTemporaryMC();
		$classes = $oltMC->getClassesOfDisciplineAtSemester($disciplineID, $semester);

		$mtgMC = new MagisterialTheoryGroupsMC();
		$mtgMC->updateBasedOnTemporaryOfferList($classes, $semester, $disciplineID);

		$groups = $mtgMC->fromSemesterAndDisciplineClassKey($semester, $disciplineID);

		$schedules = array();
		foreach ($classes as $class) {
			$times = explode("-", $class->schedule);
			foreach ($times as $time) {
				$schedules[$class->class][$time] = true;
			}
		}

		$classesGrouped = $mtgMC->fromSemesterAndDisciplineGroupedByGroup($semester, $disciplineID);

		$vc = new MMTheoryGroupsVC($magisterialDiscipline);
		$vc->setSemester($semester);
		$vc->setClasses($classes, $groups);
		$vc->setClassesGrouped($classesGrouped, $schedules);
	} else {
		require_once $ROOT_PATH . 'viewController/genericMessageVC.php';

		$vc = new GenericMessageVC();
		$vc->setTitle("Agrupamento de Teoria - ".$magisterialDiscipline->name);
		$vc->message("Disciplina não é Magistral");
	}
} else {
	require_once $ROOT_PATH.'modelController/disciplinesMC.php';

	require_once $ROOT_PATH.'viewController/maintainMagisterial/mmDisciplinesVC.php';

	$vc = new MMDisciplinesVC();

	$magisterialDisciplines = $magisterialDisciplineMC->fromSemester($semester);

	$disciplinesMC = new DisciplinesMC();
	$listDisciplines = $disciplinesMC->graduationDisciplines();

	$vc->setMagisterialDisciplines($magisterialDisciplines);
	$vc->fillDisciplines($listDisciplines);
	$vc->setSemester($semester);
}

$vc->close();
?>