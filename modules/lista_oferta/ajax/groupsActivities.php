<?php
require_once dirname(__FILE__).'/../conf/default.php';
require_once $ROOT_PATH.'utils/moduleUT.php';

// Exige usuario autenticado em um dos modulos que usam a tela de creditos concedidos.
if (!(ModuleUT::haveUserLogged($ID_MODULE) || ModuleUT::haveUserLogged($ID_MODULE_SECRETARY_GRADUATION) || ModuleUT::haveUserLogged($ID_MODULE_SECRETARY_POST))) {
	echo json_encode(array('success' => false, 'message' => 'Acesso negado.'));
	exit;
}

$method = $_POST;

$return = new stdClass();

if ($method && isset($method['group'])) {
	require_once $ROOT_PATH.'modelController/activitiesMC.php';

	require_once $ROOT_PATH.'modelController/semesterMC.php';

	$semesterMC = new SemesterMC();
	$semester = $semesterMC->last();

	$activitiesMC = new ActivitiesMC();
	$listActivities = $activitiesMC->listByGroupAvailable($semester, $method['group']);

	foreach ($listActivities as $activity) {
		$activity->description = mb_convert_encoding($activity->description, "HTML-ENTITIES", $CHARSET);
	}

	$return->success = true;
	$return->data = $listActivities;
} else {
	$return->success = false;
	$return->message = "Sem Grupo.";
}

echo json_encode($return);
