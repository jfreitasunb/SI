<?php
require_once 'conf/default.php';

require_once $ROOT_PATH.'utils/moduleUT.php';

ModuleUT::validateUserModule($ID_MODULE);

require_once $ROOT_PATH.'processing/professorPR.php';

require_once $ROOT_PATH.'modelController/semesterMC.php';

require_once $ROOT_PATH.'viewController/professorSchedule/psMainVC.php';

$semesterMC = new SemesterMC();
$semester = $semesterMC->last();

$listProfessors = ProfessorPR::activeProfessorsWithCredits($semester);

$selectedProfessor = null;
if ($_GET && isset($_GET["professor"])) {
	$selectedProfessor = $listProfessors[$_GET["professor"]];
} else {
	$selectedProfessor = array_values($listProfessors);
	$selectedProfessor = $selectedProfessor[0];
}

$vc = new PSMainVC();
$vc->fillProfessors($listProfessors, $selectedProfessor);
$vc->setSemester($semester);

$vc->close();
