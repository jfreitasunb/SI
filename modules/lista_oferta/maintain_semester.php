<?php
require_once 'conf/default.php';

require_once $ROOT_PATH.'utils/moduleUT.php';
require_once $ROOT_PATH.'utils/utilUT.php';
require_once $ROOT_PATH.'utils/magisterialUT.php';

ModuleUT::validateUserModule($ID_MODULE);

require_once $ROOT_PATH.'modelController/professorMC.php';
require_once $ROOT_PATH.'modelController/semesterMC.php';
require_once $ROOT_PATH.'modelController/offerListMC.php';
require_once $ROOT_PATH.'modelController/offerListTemporaryMC.php';
require_once $ROOT_PATH.'modelController/emuralTriggerMC.php';
require_once $ROOT_PATH.'modelController/grantedCreditsMC.php';

$semesterMC = new SemesterMC();
$semester = $semesterMC->last();

$olMC = new OfferListMC();
$oltMC = new OfferListTemporaryMC();

$created = false;
$saved = false;
$missingProfessor = 0;

if (isset($_GET["revive"]) && strcmp($semester->status, SemesterDAO::STATUS_CLOSED) == 0) {
	$semester->status = SemesterDAO::STATUS_STAGE_3;

	$semester = $semesterMC->update($semester);
}

if ($_POST) {
	$postData = UtilUT::postToObject($_POST, array('year', 'semester', 'beginning', 'end', 'status', 'average_credits', 'reduction_credits', 'publications_threshold'));
	$postData->beginning = UtilUT::convertDateToSQL($postData->beginning);
	$postData->end = UtilUT::convertDateToSQL($postData->end);

	$emuralTriggerMC = new EmuralTriggerMC();

	if ($postData->year && $postData->semester) {

		$clone = explode('/', $_POST["clone"]);

		$semesterCloned = new SemesterTO();
		$semesterCloned->year = $clone[0];
		$semesterCloned->semester = $clone[1];

		$semesterBefore = $semesterMC->last();

		$semesterMC->create($postData);

		$semester = $semesterMC->last();

		$classes = $olMC->classesOfSemester($semesterCloned);

		foreach ($classes as $class) {
			$class->year = $postData->year;
			$class->semester = $postData->semester;
			unset($class->professor);
		}

		$oltMC->insertByCloning($classes);
		MagisterialUT::cloneFromSemesterToSemester($semesterCloned, $semester);

		$gcMC = new GrantedCreditsMC();
		$gcMC->cloneFromSemesterToSemester($semesterBefore, $semester);

		$professorMC = new ProfessorMC();
		$professorMC->cloneFromSemesterToSemester($semesterBefore, $semester);
		ModuleUT::updateNightShift($semester);

		$created = true;

		$emuralTriggerMC->create($postData);
	} else {

		if (strcmp($postData->status, SemesterDAO::STATUS_CLOSED) == 0) {
			$classes = $oltMC->getListWithDisciplineOfSemesterAndDiscipline($semester);
			$tempOfferList = UtilUT::changeKey($classes);
			$tempOfferList = MagisterialUT::adjustClassList($tempOfferList);

			foreach ($tempOfferList as $class) {
				if (strlen($class->professor) == 0) {
					$missingProfessor++;
				}
			}

			if ($missingProfessor == 0) {

				MagisterialUT::professorsExerciseToClass($classes);

				$olMC->insertClassesAtSemester($classes, $semester);

				$emuralTriggerMC->finish($semester);

				ModuleUT::updateNightShift($semester);
			}
		}

		if ($missingProfessor == 0) {
			$postData->id = $semester->id;

			$semester = $semesterMC->update($postData);

			$saved = true;
		}
	}
}

$vc = null;

if (strcmp($semester->status, SemesterDAO::STATUS_CLOSED) == 0) {
	require_once $ROOT_PATH.'viewController/maintainSemester/msCreateVC.php';

	$listRealSemesters = $olMC->pastSemesters();

	$vc = new MSCreateVC();
	$vc->fillPreviousSemestersList($listRealSemesters);
} else {
	require_once $ROOT_PATH.'viewController/maintainSemester/msDetailsVC.php';
	require_once $ROOT_PATH.'modelController/grantedCreditsMC.php';

	$grantedCreditsMC = new GrantedCreditsMC();
	$professorMC = new ProfessorMC();

	$graduationCredits = $oltMC->getCreditsOfSemester($semester);
	$gcAll = $grantedCreditsMC->quantityCreditsBySemesterActivity($semester);
	$gcPostClass = $grantedCreditsMC->quantityCreditsBySemesterActivity($semester, GrantedCreditsDAO::ACTIVITY_POST_CLASS);
	$gcPostClass += $grantedCreditsMC->quantityCreditsBySemesterActivity($semester, GrantedCreditsDAO::ACTIVITY_POST_ORIENTATION_MASTERS);
	$gcPostClass += $grantedCreditsMC->quantityCreditsBySemesterActivity($semester, GrantedCreditsDAO::ACTIVITY_POST_ORIENTATION_PHD);
	$users = $professorMC->listActiveExclusive($semester);
	$publicationsCreditsAboveThreshold = $grantedCreditsMC->publicationsCreditsAboveThreshold($semester, $semester->publications_threshold);


	$credits = new stdClass();
	$credits->class_graduation = UtilUT::formatNumber($graduationCredits);
	$credits->class_post = UtilUT::formatNumber($gcPostClass);
	$credits->other = UtilUT::formatNumber($gcAll - $gcPostClass);
	$credits->total = UtilUT::formatNumber($graduationCredits + $gcAll - $semester->reduction_credits);
	$credits->professors = UtilUT::formatNumber(count($users));
	$credits->mean = UtilUT::formatNumber($credits->total / $credits->professors);
	$credits->publications_credits_above_threshold = UtilUT::formatNumber($publicationsCreditsAboveThreshold);

	$stages = $semesterMC->stages();

	$vc = new MSDetailsVC();
	$vc->setSemester($semester);
	$vc->setStages($stages);
	$vc->setCredits($credits);

	$vc->setMissingProfessor($missingProfessor);

	if ($created) {
		$vc->created();
	} elseif ($saved) {
		$vc->saved();
	}
}

$vc->close();
