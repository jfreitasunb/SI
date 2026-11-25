<?php
require_once dirname(__FILE__).'/../conf/default.php';

require_once $ROOT_PATH.'utils/moduleUT.php';

header('Content-Type: application/json; charset=utf-8');
header('X-Content-Type-Options: nosniff');

$return = new stdClass();
$return->success = false;

$isAdmin = ModuleUT::haveUserLogged($ID_MODULE);
$isGrad  = !$isAdmin && ModuleUT::haveUserLogged($ID_MODULE_SECRETARY_GRADUATION);
$isPost  = !$isAdmin && !$isGrad && ModuleUT::haveUserLogged($ID_MODULE_SECRETARY_POST);

if ($isAdmin || $isGrad || $isPost) {
	$request = json_decode(file_get_contents('php://input'));

	switch ($_SERVER['REQUEST_METHOD']) {
		case 'DELETE':
			if (isset($request->id) && ctype_digit((string)$request->id)) {
				require_once $ROOT_PATH . 'modelController/grantedCreditsMC.php';
				require_once $ROOT_PATH . 'modelController/semesterMC.php';
				require_once $ROOT_PATH . 'model/tableItemDAO.php';

				$semesterMC = new SemesterMC();
				$semester = $semesterMC->last();
				if ($semester->status != SemesterDAO::STATUS_STAGE_1 && $semester->status != SemesterDAO::STATUS_STAGE_2) {
					$return->message = "Semestre fechado para alteracoes.";
					break;
				}

				$grantedCreditsMC = new GrantedCreditsMC();
				$credit = $grantedCreditsMC->getFullById((int)$request->id);
				if (!$credit) {
					$return->message = "Registro nao encontrado.";
					break;
				}
				if ((int)$credit->year !== (int)$semester->year || (int)$credit->semester !== (int)$semester->semester) {
					$return->message = "Nao e permitido alterar creditos de outro semestre.";
					break;
				}
				if (!$isAdmin) {
					$tipoEsperado = $isPost ? TableItemDAO::ACTIVITY_POSTGRADUATE : TableItemDAO::ACTIVITY_GRADUATION;
					if ((string)$credit->group_type !== (string)$tipoEsperado) {
						$return->message = "Sem autorizacao para alterar creditos desta secretaria.";
						break;
					}
				}

				$grantedCreditsMC->delete((int)$request->id);

				$return->success = true;
				$return->message = "Sucesso.";
			} else {
				$return->message = "Falta o ID.";
			}
			break;
		default:
			$return->message = "Erro.";
			break;
	}
} else {
	$return->message = "Sem autorização para acesso.";
}

echo json_encode($return, JSON_HEX_TAG | JSON_HEX_AMP | JSON_HEX_APOS | JSON_HEX_QUOT);
