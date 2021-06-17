<?php
require_once 'conf/default.php';

require_once $ROOT_PATH.'utils/moduleUT.php';

ModuleUT::validateUserModule($ID_MODULE);

require_once $ROOT_PATH.'modelController/semesterMC.php';

$semesterMC = new SemesterMC();
$semester = $semesterMC->last();

if($semester->status == SemesterDAO::STATUS_STAGE_1 || $semester->status == SemesterDAO::STATUS_STAGE_2 || $DEVELOPMENT) {
	require_once $ROOT_PATH.'modelController/offerListTemporaryMC.php';
	require_once $ROOT_PATH.'viewController/maintainClasses/maintainClassesVC.php';
	require_once $ROOT_PATH.'modelController/disciplinesMC.php';
	require_once $ROOT_PATH.'modelController/tableItemMC.php';

	$oltMC = new OfferListTemporaryMC();

	$vc = new MaintainClassesVC();
	$vc->setSemester($semester);

	$tempOfferList = $oltMC->getListWithDisciplineOfSemester($semester);

	$vc->fillTemporaryOfferList($tempOfferList);

	$disciplinesMC = new DisciplinesMC();
	$listDisciplines = $disciplinesMC->graduationDisciplines();

	$vc->fillDisciplines($listDisciplines);

	$tableItemMC = new TableItemMC();
	$listPeriods = $tableItemMC->getListPeriods();

	$vc->fillPeriods($listPeriods);
} else {
	require_once $ROOT_PATH . 'viewController/genericMessageVC.php';

	$vc = new GenericMessageVC();
	$vc->message("O semestre não está na etapa de alteração ou criação de turmas.");
}


$vc->close();