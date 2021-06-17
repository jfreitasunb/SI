<?php
require_once 'conf/default.php';

require_once $ROOT_PATH.'utils/moduleUT.php';

ModuleUT::validateUserModule($ID_MODULE);

require_once $ROOT_PATH.'modelController/semesterMC.php';

$semesterMC = new SemesterMC();
$semester = $semesterMC->last();

if($semester->status == SemesterDAO::STATUS_CLOSED || $DEVELOPMENT) {
	require_once $ROOT_PATH.'modelController/offerListTemporaryMC.php';
	require_once $ROOT_PATH.'modelController/grantedCreditsMC.php';
	require_once $ROOT_PATH.'modelController/userMC.php';
	require_once $ROOT_PATH.'viewController/activityList/alMainVC.php';
	require_once $ROOT_PATH.'utils/magisterialUT.php';
	require_once $ROOT_PATH.'utils/utilUT.php';

	$oltMC = new OfferListTemporaryMC();
	$offerList = $oltMC->getListWithDisciplineOfSemester($semester);
	$offerList = MagisterialUT::adjustClassList($offerList);

	$userMC = new userMC();
	$professorList = $userMC->activeTeachersList();
	$professorList = UtilUT::changeKey($professorList);

	foreach ($professorList as $professor) {
		$professor->credits_total = 0;
	}

	foreach ($offerList as $offer) {
		$obj = new stdClass();
		$obj->activity = "Gradua&ccedil;&atilde;o";
		$obj->description = $offer->discipline_name;
		$obj->code = $offer->discipline_id;
		$obj->class = $offer->class;
		$obj->period = $offer->period;
		$obj->schedule = $offer->schedule;
		$obj->credits = $offer->discipline_credits;

		$professorList[$offer->professor]->credits_total += $offer->discipline_credits;
		$professorList[$offer->professor]->activity[] = $obj;
		unset($obj);
	}

	$gcMC = new GrantedCreditsMC();
	$grantedCreditsList = $gcMC->listBySemester($semester);
	$gcMC->completeActivityDescription($grantedCreditsList);


	foreach ($grantedCreditsList as $grantedCredit) {
		$obj = new stdClass();
		if (strcmp($grantedCredit->activity, GrantedCreditsDAO::ACTIVITY_POST_CLASS) == 0) {
			$obj->activity = "P&oacute;s Gradua&ccedil;&atilde;o";
			$obj->description = $grantedCredit->discipline_name;
			$obj->code = $grantedCredit->extra;
		} else {
			$obj->activity = $grantedCredit->group_description;
			$obj->description = $grantedCredit->activity_description;
		}
		$obj->credits = $grantedCredit->credits;

		$professorList[$grantedCredit->teacher]->credits_total += $grantedCredit->credits;
		$professorList[$grantedCredit->teacher]->activity[] = $obj;
		unset($obj);

	}

	$vc = new ALMainVC();
	$vc->fillActivityList($professorList);
} else {
	require_once $ROOT_PATH . 'viewController/genericMessageVC.php';

	$vc = new GenericMessageVC();
	$vc->message("O semestre n&atilde;o est&aacute; na etapa de visualiza&ccedil;&atilde;o da lista de atividades.");
}


$vc->close();