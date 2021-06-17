<?php
require_once 'conf/default.php';

require_once $ROOT_PATH.'utils/moduleUT.php';

ModuleUT::validateUserModule($ID_MODULE);

require_once $ROOT_PATH.'viewController/professorCreditsVC.php';
require_once $ROOT_PATH.'modelController/creditsSemesterMC.php';
require_once $ROOT_PATH.'modelController/userMC.php';

$vc = & new ProfessorCreditsVC();

$semester = & new stdClass();
$semester->year = 2016;
$semester->semester = 1;

$creditsSemesterMC = & new CreditsSemesterMC();
$arrayCreditsSemesterProfessors = $creditsSemesterMC->getArrayKeyUserIdWithProfessors($semester);

if ($_POST) {
	$arrayIdsProfessorsCredits = Array();

	foreach ($_POST as $key => $value) {
		if(strpos($key, "user_") !== false && strpos($key, "user_") == 0) {
			$arrayIdsProfessorsCredits[substr($key,5)] = $value;
		}
	}

	$creditsSemesterMC->insertUpdate($arrayIdsProfessorsCredits, $semester, $arrayCreditsSemesterProfessors);
	$arrayCreditsSemesterProfessors = $creditsSemesterMC->getArrayKeyUserIdWithProfessors($semester);
}

$userMC = & new userMC();
$listProfessors = $userMC->activeTeachersList();

$vc->setSemester($semester);
$vc->fillProfessors($listProfessors, $arrayCreditsSemesterProfessors);

$vc->close();
?>