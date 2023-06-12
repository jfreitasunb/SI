<?php
require_once 'conf/default.php';

require_once $ROOT_PATH.'utils/moduleUT.php';

require_once $ROOT_PATH.'modelController/semesterMC.php';
require_once $ROOT_PATH.'modelController/offerListTemporaryMC.php';
require_once $ROOT_PATH.'modelController/grantedCreditsMC.php';
require_once $ROOT_PATH.'modelController/userMC.php';

require_once $ROOT_PATH.'utils/magisterialUT.php';
require_once $ROOT_PATH.'utils/utilUT.php';

require_once $ROOT_PATH.'viewController/activityList/alMainVC.php';


ModuleUT::validateUserModule($ID_MODULE);

$semesterMC = new SemesterMC();
$semesters = $semesterMC->allSemesters();

if ($_GET && isset($_GET["semester"])) {
	$semesterData = explode("-", $_GET["semester"]);
	$semester = new SemesterTO();
	$semester->year = $semesterData[0];
	$semester->semester = $semesterData[1];
} else {
	$semester = $semesters[0];
}


$order = false;
if ($_GET && isset($_GET["order"])) {
	$order = true;
}

$oltMC = new OfferListTemporaryMC();
$offerList = $oltMC->getListWithDisciplineOfSemesterAndDiscipline($semester);
$offerList = MagisterialUT::adjustClassList($offerList);

$userMC = new userMC();
$professorList = $userMC->activeTeachersList();
$professorList = UtilUT::changeKey($professorList);

foreach ($professorList as $professor) {
	$professor->credits_total = 0;
}


foreach ($offerList as $offer) {
	$obj = new stdClass();
	$obj->activity = "Gradua&ccedil;&atildeo";
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

$vc = new ALMainVC();
$vc->setOrder($order);
$vc->setSemester($semester);
$vc->fillSemestersList($semesters, $semester);

if (count($grantedCreditsList)) {
	foreach ($grantedCreditsList as $grantedCredit) {
		$obj = new stdClass();
		if (strcmp($grantedCredit->activity, GrantedCreditsDAO::ACTIVITY_POST_CLASS) == 0) {
			$obj->activity = "P&oacute;s-Gradua&ccedil;&atilde;o";
			$obj->description = $grantedCredit->discipline_name;
			$obj->code = $grantedCredit->extra;
		} else {
			$obj->activity = $grantedCredit->group_description;
			$obj->description = $grantedCredit->activity_description;
		}
		$obj->credits = round($grantedCredit->credits, 2);

		$professorList[$grantedCredit->teacher]->credits_total += $obj->credits;
		$professorList[$grantedCredit->teacher]->activity[] = $obj;
		unset($obj);
	}

	if ($_GET && isset($_GET["csv"])) {
		$file = "lista_de_atividade_".$semester->year."_".$semester->semester.".csv";
		header('Content-Type: text/csv; charset=utf-8');
		header("Content-Disposition: attachment; filename=$file");

		$output = fopen('php://output', 'w');

		fputcsv($output, array('Professor','Atividade','Descrição','Código','Turma','Turno','Horários','Carga','Total'));

		foreach ($professorList as $professor) {
			$name = "$professor->name $professor->last_name";
			$credits = "$professor->credits_total";
			if (isset($professor->activity)) {
				foreach ($professor->activity as $activity) {
					fputcsv($output, array($name,"$activity->activity","$activity->description","$activity->code","$activity->class","$activity->period","$activity->schedule","$activity->credits",$credits));
					$name = " ";
					$credits = '';
				}
			} else {
				fputcsv($output, array($name,'','','','','','','',$credits));
			}
		}

		exit();
	}

	$vc->fillActivityList($professorList);
} else {
	$vc->setEmpty();
}


$vc->close();