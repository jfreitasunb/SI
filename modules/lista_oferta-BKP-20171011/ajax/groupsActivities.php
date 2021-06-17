<?php
require_once dirname(__FILE__).'/../conf/default.php';

$method = $_POST;

$return = & new stdClass();

if ($method && isset($method['group'])) {
	require_once $ROOT_PATH.'modelController/activitiesMC.php';

	require_once $ROOT_PATH.'modelController/semesterMC.php';

	$semesterMC = new SemesterMC();
	$semester = $semesterMC->last();

	$activitiesMC = new ActivitiesMC();
	$listActivities = $activitiesMC->listByGroupAvailable($semester, $method['group']);

	$return->success = true;
	$return->data = $listActivities;
} else {
	$return->success = false;
	$return->message = "Sem Grupo.";
}

echo json_encode($return);
