<?php
require_once 'conf/default.php';

require_once $ROOT_PATH.'utils/moduleUT.php';
require_once $ROOT_PATH.'utils/utilUT.php';
require_once $ROOT_PATH.'utils/linkUT.php';

ModuleUT::validateUserModule($ID_MODULE);

require_once $ROOT_PATH.'modelController/semesterMC.php';

$semesterMC = new SemesterMC();
$semester = $semesterMC->last();

$vc = null;
$created = false;

if (strcmp($semester->status, SemesterDAO::STATUS_CLOSED) == 0){
	require_once $ROOT_PATH.'modelController/offerListMC.php';
	require_once $ROOT_PATH.'modelController/offerListTemporaryMC.php';

	require_once $ROOT_PATH.'viewController/maintainSemester/msCreateVC.php';

	$vc = new MSCreateVC();

	$offerListMC = new OfferListMC();
	$listRealSemesters = $offerListMC->pastSemesters();

	$vc->fillPreviousSemestersList($listRealSemesters);

	if ($_POST) {
		$postData = UtilUT::postToObject($_POST, array('year', 'semester', 'beginning', 'end'));
		$postData->beginning = UtilUT::convertDateToSQL($postData->beginning);
		$postData->end = UtilUT::convertDateToSQL($postData->end);

		$clone = explode('/', $_POST["clone"]);

		unset($_POST);

		$semesterCloned = new stdClass();
		$semesterCloned->year = $clone[0];
		$semesterCloned->semester = $clone[1];

		$semesterMC->create($postData);

		$semester = $semesterMC->last();

		$classes = $offerListMC->classesForSemester($semesterCloned);

		foreach ($classes as $class) {
			$class->year = $postData->year;
			$class->semester = $postData->semester;
			unset($class->professor);
		}

		$oltMC = new OfferListTemporaryMC();
		$oltMC->insertByCloning($classes);
		$created = true;
	}
}

if (strcmp($semester->status, SemesterDAO::STATUS_CLOSED) != 0) {
	require_once $ROOT_PATH.'viewController/maintainSemester/msDetailsVC.php';

	$vc = new MSDetailVC();

	if ($_POST) {
		$postData = UtilUT::postToObject($_POST, array('status', 'average_credits', 'beginning', 'end'));
		$postData->id = $semester->id;
		$postData->beginning = UtilUT::convertDateToSQL($postData->beginning);
		$postData->end = UtilUT::convertDateToSQL($postData->end);

		unset($_POST);

		$semester = $semesterMC->update($postData);

		if (strcmp($semester->status, SemesterDAO::STATUS_CLOSED) == 0) {
			/** @noinspection PhpIncludeInspection */
			require $ROOT_PATH_MAIN.substr(LinkUT::maintainSemester(), 1);
			exit();
		}

		$vc->saved();
	}
	if ($created) {
		$vc->created();
	}

	$vc->setSemester($semester);

	$stages = $semesterMC->stages();
	$vc->setStages($stages);
}

$vc->close();
