<?php
require_once dirname(__FILE__).'/../conf/default.php';

require_once $ROOT_PATH . 'utils/moduleUT.php';
require_once $ROOT_PATH . 'utils/utilUT.php';

require_once $ROOT_PATH . 'modelController/semesterMC.php';

ModuleUT::validateUserModule($ID_MODULE);


$semesterMC = new SemesterMC();
$semester = $semesterMC->last();

$vc = NULL;

//TODO Verificar se vai ter hora para inserir / modificar(Status do semestre)
if(isset($type) && ($semester->status == SemesterDAO::STATUS_STAGE_1 || $semester->status == SemesterDAO::STATUS_STAGE_2 || $DEVELOPMENT)) {
//if(isset($type) || $DEVELOPMENT) {
	require_once $ROOT_PATH.'viewController/grantedCredits/grantedCreditsVC.php';
	require_once $ROOT_PATH.'modelController/grantedCreditsMC.php';
	require_once $ROOT_PATH.'modelController/professorMC.php';

	$tableItemMC = new TableItemMC();
	if ($type == TableItemDAO::ACTIVITY_POSTGRADUATE) {
		$activityGroupGraduation = $tableItemMC->getListGroupActivitiesPostGraduation();
	} else {
		$activityGroupGraduation = $tableItemMC->getListGroupActivitiesGraduation();
	}

	$professorMC = new ProfessorMC();
	$teacherList = $professorMC->listActiveExclusive($semester);

	$grantedCreditsMC = new GrantedCreditsMC();
	$credit = null;
	if (isset($_GET["credit"]) && strlen($_GET["credit"])) {
		$credit = $grantedCreditsMC->getFullById($_GET["credit"]);
	}

	p($credit);


	$inserted = null;
	if ($_POST) {
		$dataPosted = UtilUT::postToObject($_POST, array('teacher', 'activity', 'credits', 'extra'));

		$inserted = $grantedCreditsMC->insert($dataPosted, $semester);
	}

	$listGrantedCredits = $grantedCreditsMC->listBySemester($semester, $type);
	$grantedCreditsMC->completeActivityDescription($listGrantedCredits);

	$vc = new GrantedCreditsVC();
	$vc->setSemester($semester);
	$vc->setActivityGroup($activityGroupGraduation);
	$vc->setTeacherList($teacherList);
	$vc->setGrantedCredits($listGrantedCredits);
	$vc->setMessage($inserted);
} else {
	require_once $ROOT_PATH.'viewController/genericMessageVC.php';

	$vc = new GenericMessageVC();
	$vc->setTitle("Concessão de Carga");
	$vc->message("O semestre não está na etapa de concesão de créditos.");
}

$vc->close();
