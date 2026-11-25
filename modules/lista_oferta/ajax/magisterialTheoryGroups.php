<?php
require_once dirname(__FILE__).'/../conf/default.php';

require_once $ROOT_PATH.'utils/moduleUT.php';
require_once $ROOT_PATH.'utils/magisterialUT.php';

header('Content-Type: application/json; charset=utf-8');
header('X-Content-Type-Options: nosniff');

$return = new stdClass();

if (ModuleUT::haveUserLogged($ID_MODULE)) {
	require_once $ROOT_PATH.'modelController/magisterialTheoryGroupsMC.php';
	require_once $ROOT_PATH.'modelController/semesterMC.php';

	$semesterMC = new SemesterMC();
	$semester = $semesterMC->last();
	if ($semester->status != SemesterDAO::STATUS_STAGE_1 && $semester->status != SemesterDAO::STATUS_STAGE_2) {
		$return->success = false;
		$return->message = "Semestre fechado para alteracoes.";
		echo json_encode($return, JSON_HEX_TAG | JSON_HEX_AMP | JSON_HEX_APOS | JSON_HEX_QUOT);
		exit;
	}

	$mtgMC = new MagisterialTheoryGroupsMC();
	$request = json_decode(file_get_contents('php://input'));

	switch ($_SERVER['REQUEST_METHOD']) {
		case 'DELETE':
			if (isset($request->id)) {
				$update = new stdClass();
				$update->group = "";
				$update->time = "";

				$from = new stdClass();
				$from->id = $request->id;

				$mtgMC->update($update, $from);

				$return->success = true;
				$return->message = "Deletado com sucesso";
			} else {
				$return->success = false;
				$return->message = "Falta de parâmetros DELETE";
			}
			break;
		case 'PUT':
			$missing = false;
			if (isset($request->group) && isset($request->discipline) && isset($request->id)) {
				$update = new stdClass();
				$update->group = $request->group;

				$from = new stdClass();
				$from->id = $request->id;

				$mtgMC->update($update, $from);

				$update = new stdClass();
				$update->time = "";

				$from = new stdClass();
				$from->group = $request->group;
				$from->discipline = $request->discipline;
				$from->semester = $semester->semester;
				$from->year = $semester->year;

				$mtgMC->update($update, $from);

				$return->data = $mtgMC->timesOfGroup($semester, $request->discipline, $request->group);
				$return->success = true;
				$return->message = "Atualizado com sucesso";
			} else {
				$return->success = false;
				$return->message = "Falta de parâmetros PUT";
			}
			break;
		case 'POST':
			if (isset($request->discipline) && isset($request->id)) {
				$group = $mtgMC->lastGroup($semester, $request->discipline) + 1;

				$update = new stdClass();
				$update->group = $group;
				$update->schedule = "";

				$from = new stdClass();
				$from->id = $request->id;

				$mtgMC->update($update, $from);

				$update = new stdClass();
				$update->time = "";

				$from = new stdClass();
				$from->group = $group;
				$from->discipline = $request->discipline;
				$from->semester = $semester->semester;
				$from->year = $semester->year;

				$mtgMC->update($update, $from);

				$return->data = $mtgMC->timesOfGroup($semester, $request->discipline, $group);
				$return->success = true;
				$return->message = "Atualizado com sucesso";
			} else {
				$return->success = false;
				$return->message = "Falta de parâmetros POST";
			}
			break;
		case 'PATCH':
			if (isset($request->discipline) && isset($request->group) && isset($request->time)) {
				$from = new stdClass();
				$from->discipline = $request->discipline;
				$from->group = $request->group;
				$from->semester = $semester->semester;
				$from->year = $semester->year;

				$mtgMC->updateTimeFrom($request->time, $from);

				$return->data = $mtgMC->timesOfGroup($semester, $request->discipline, $request->group);
				$return->success = true;
				$return->message = "Atualizado com sucesso";
			} else {
				$return->success = false;
				$return->message = "Falta de parâmetros PATCH";
			}
			break;
		default:
			$return->success = false;
			$return->message = "Método não previsto.";
			break;
	}

//	MagisterialUT::updateOfferList($semester, "113042");
	MagisterialUT::updateOfferList($semester, $request->discipline);
} else {
	$return->success = false;
	$return->message = "Sem permissão.";
}

echo json_encode($return, JSON_HEX_TAG | JSON_HEX_AMP | JSON_HEX_APOS | JSON_HEX_QUOT);
