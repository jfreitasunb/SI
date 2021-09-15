<?php
require_once dirname(__FILE__).'/../conf/default.php';

require_once $ROOT_PATH.'utils/moduleUT.php';

$return = new stdClass();
$return->success = false;

if (ModuleUT::haveUserLogged($ID_MODULE) || ModuleUT::haveUserLogged($ID_MODULE_SECRETARY_GRADUATION) || ModuleUT::haveUserLogged($ID_MODULE_SECRETARY_POST)) {
	$request = json_decode(file_get_contents('php://input'));

	switch ($_SERVER['REQUEST_METHOD']) {
		case 'DELETE':
			if (isset($request->id)) {
				require_once $ROOT_PATH . 'modelController/grantedCreditsMC.php';

				$grantedCreditsMC = new GrantedCreditsMC();
				$grantedCreditsMC->delete($request->id);

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

echo json_encode($return);
