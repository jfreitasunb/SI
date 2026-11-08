<?php
require_once 'conf/default.php';

require_once $ROOT_PATH.'utils/moduleUT.php';

ModuleUT::validateUserModule($ID_MODULE);

require_once $ROOT_PATH.'modelController/semesterMC.php';

$semesterMC = new SemesterMC();
$semester = $semesterMC->last();


if($semester->status != SemesterDAO::STATUS_CLOSED) {
	require_once $ROOT_PATH.'viewController/maintainProfessors/mpMainVC.php';
	require_once $ROOT_PATH.'modelController/professorMC.php';

	require_once $ROOT_PATH.'processing/professorPR.php';

	$professorMC = new ProfessorMC();

	$saved = false;
	if ($_POST) {
		$professorsStatus = Array();

		foreach ($_POST as $key => $value) {
			if(strpos($key, "status_") !== false && strpos($key, "status_") == 0) {
				$obj = new stdclass();
				$obj->professor = substr($key, 7);
				$obj->status = $value;

				$professorsStatus[] = $obj;
			}
		}
		$professorMC->updateProfessors($professorsStatus, $semester);
		$saved = true;
	}

	ProfessorPR::updateActiveProfessors($semester);

	$listProfessors = $professorMC->listProfessors($semester);
	
	$vc = new MPMainVC();
	$vc->setSemester($semester);
	$vc->fillProfessorsList($listProfessors);

	if($saved) {
		$vc->saved();
	}
} else {
	require_once $ROOT_PATH.'viewController/genericMessageVC.php';

	$vc = new GenericMessageVC();
	$vc->setTitle("Manter Professores");
	$vc->message("O semestre está fechado.");
}

$vc->close();
?>