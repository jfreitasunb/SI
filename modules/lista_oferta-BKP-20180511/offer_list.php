<?php
require_once 'conf/default.php';

require_once $ROOT_PATH.'utils/moduleUT.php';

//TODO $ID_MODULE must have the right id
//$ID_MODULE = xxxx

ModuleUT::validateUserModule($ID_MODULE);

require_once $ROOT_PATH.'modelController/semesterMC.php';

$semesterMC = new SemesterMC();
$semester = $semesterMC->last();

if($semester->status != SemesterDAO::STATUS_CLOSED || $DEVELOPMENT) {
	require_once $ROOT_PATH.'utils/magisterialUT.php';
	require_once $ROOT_PATH.'utils/utilUT.php';
	require_once $ROOT_PATH.'processing/professorPR.php';
	require_once $ROOT_PATH.'modelController/offerListTemporaryMC.php';
	require_once $ROOT_PATH.'viewController/offerList/olOfferListVC.php';

	$oltMC = new OfferListTemporaryMC();

	if ($_POST && isset($_POST['clean'])) {
		require_once $ROOT_PATH.'modelController/magisterialOfferListMC.php';

		$molMC = new MagisterialOfferListMC();
		$molMC->clearAllProfessors($semester);
		$oltMC->clearAllProfessors($semester);
	}

	$listProfessors = ProfessorPR::activeProfessorsWithCredits($semester);

	$tempOfferList = $oltMC->getListWithDisciplineOfSemester($semester);
	$tempOfferList = UtilUT::changeKey($tempOfferList);
	$tempOfferList = MagisterialUT::adjustClassList($tempOfferList);

	foreach ($tempOfferList as $class) {
		$class->schedule2 = str_replace('-', ' ', $class->schedule);

		if (strlen($class->professor)) {

			$hoursArray = explode('-', $class->schedule);
			foreach ($hoursArray as $hour) {
				if (isset($listProfessors[$class->professor]->schedule[$hour]) && $listProfessors[$class->professor]->schedule[$hour] != $class->id) {
					$tempOfferList[$listProfessors[$class->professor]->schedule[$hour]]->scheduleShock = true;
					$tempOfferList[$class->id]->scheduleShock = true;
				}
			}
		}
	}
//p($listProfessors);
	$vc = new OfferListVC();
	$vc->fillProfessors($listProfessors);
	$vc->fillClasses($tempOfferList);
} else {
	require_once $ROOT_PATH . 'viewController/genericMessageVC.php';

	$vc = new GenericMessageVC();
	$vc->message("O semestre não está na etapa de distribuição das turmas.");
}

$vc->close();
