<?php
require_once 'conf/default.php';

require_once $ROOT_PATH.'utils/moduleUT.php';
require_once $ROOT_PATH.'utils/utilUT.php';
require_once $ROOT_PATH.'utils/magisterialUT.php';

ModuleUT::validateUserModule($ID_MODULE);

require_once $ROOT_PATH.'modelController/userMC.php';
require_once $ROOT_PATH.'modelController/semesterMC.php';
require_once $ROOT_PATH.'modelController/offerListMC.php';
require_once $ROOT_PATH.'modelController/offerListTemporaryMC.php';

$semesterMC = new SemesterMC();
$semester = $semesterMC->last();

$olMC = new OfferListMC();
$oltMC = new OfferListTemporaryMC();

$created = false;
$saved = false;
$missingProfessor = 0;

if ($_POST) {
	$postData = UtilUT::postToObject($_POST, array('year', 'semester', 'beginning', 'end', 'status', 'average_credits', 'reduction_credits', 'publications_threshold'));
	$postData->beginning = UtilUT::convertDateToSQL($postData->beginning);
	$postData->end = UtilUT::convertDateToSQL($postData->end);

	if ($postData->year && $postData->semester) {

		$clone = explode('/', $_POST["clone"]);

		$semesterCloned = new stdClass();
		$semesterCloned->year = $clone[0];
		$semesterCloned->semester = $clone[1];

		$semesterMC->create($postData);

		$semester = $semesterMC->last();

		$classes = $olMC->classesForSemester($semesterCloned);

		foreach ($classes as $class) {
			$class->year = $postData->year;
			$class->semester = $postData->semester;
			unset($class->professor);
		}

		$oltMC->insertByCloning($classes);
		$created = true;
	} else {

		if (strcmp($postData->status, SemesterDAO::STATUS_CLOSED) == 0) {
			$classes = $oltMC->getListWithDisciplineOfSemester($semester);

			$classes = $oltMC->getListWithDisciplineOfSemester($semester);
			$tempOfferList = UtilUT::changeKey($classes);
			$tempOfferList = MagisterialUT::adjustClassList($tempOfferList);

			foreach ($tempOfferList as $class) {
				if (strlen($class->professor) == 0) {
					$missingProfessor++;
				}
			}

			if ($missingProfessor == 0) {

				MagisterialUT::professorsExerciseToClass($classes);

				foreach ($classes as $class) {
					unset($class->id);
					unset($class->status);
					unset($class->discipline_id);
					unset($class->discipline_name);
					unset($class->discipline_credits);
					unset($class->discipline_type);
				}

				$olMC->insertByCloning($classes);
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
	$userMC = new UserMC();

	$graduationCredits = $oltMC->getCreditsOfSemester($semester);
	$gcAll = $grantedCreditsMC->quantityCreditsBySemesterActivity($semester);
	$gcPostClass = $grantedCreditsMC->quantityCreditsBySemesterActivity($semester, GrantedCreditsDAO::ACTIVITY_POST_CLASS);
	$gcPostClass += $grantedCreditsMC->quantityCreditsBySemesterActivity($semester, GrantedCreditsDAO::ACTIVITY_POST_ORIENTATION_MASTERS);
	$gcPostClass += $grantedCreditsMC->quantityCreditsBySemesterActivity($semester, GrantedCreditsDAO::ACTIVITY_POST_ORIENTATION_PHD);
	$users = $userMC->activeExclusiveTeachersList();
	$publicationsCreditsAboveThreshold = $grantedCreditsMC->publicationsCreditsAboveThreshold($semester, $semester->publications_threshold);


	$credits = new stdClass();
	$credits->class_graduation = UtilUT::formatNumber($graduationCredits);
	$credits->class_post = UtilUT::formatNumber($gcPostClass);
	$credits->other = UtilUT::formatNumber($gcAll - $gcPostClass);
	$credits->total = UtilUT::formatNumber($graduationCredits + $gcAll - $semester->reduction_credits);
	$credits->professors = UtilUT::formatNumber(count($users));
	$credits->mean = UtilUT::formatNumber($credits->total / $credits->professors);
	$credits->publications_credits_above_threshold = $publicationsCreditsAboveThreshold;

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