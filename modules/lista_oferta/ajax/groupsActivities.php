<?php
require_once dirname(__FILE__).'/../conf/default.php';
require_once $ROOT_PATH.'utils/moduleUT.php';

header('Content-Type: application/json; charset=utf-8');
header('X-Content-Type-Options: nosniff');

// Exige usuario autenticado em um dos modulos que usam a tela de creditos concedidos.
if (!(ModuleUT::haveUserLogged($ID_MODULE) || ModuleUT::haveUserLogged($ID_MODULE_SECRETARY_GRADUATION) || ModuleUT::haveUserLogged($ID_MODULE_SECRETARY_POST))) {
	echo json_encode(array('success' => false, 'message' => 'Acesso negado.'), JSON_HEX_TAG | JSON_HEX_AMP | JSON_HEX_APOS | JSON_HEX_QUOT);
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

	$return->success = true;
	$return->data = $listActivities;
} else {
	$return->success = false;
	$return->message = "Sem Grupo.";
}

echo json_encode($return, JSON_HEX_TAG | JSON_HEX_AMP | JSON_HEX_APOS | JSON_HEX_QUOT);
