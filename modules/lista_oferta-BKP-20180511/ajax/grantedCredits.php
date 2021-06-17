<?php
require_once dirname(__FILE__).'/../conf/default.php';

require_once $ROOT_PATH.'utils/moduleUT.php';

$return = new stdClass();

if (ModuleUT::haveUserLogged($ID_MODULE)) {
	switch ($_SERVER['REQUEST_METHOD']) {
		case 'DELETE':
			if (isset($_GET['id'])) {
				require_once $ROOT_PATH . 'modelController/grantedCreditsMC.php';

				$grantedCreditsMC = new GrantedCreditsMC();
				$grantedCreditsMC->delete($_GET['id']);

				$return->success = true;
				$return->message = "Sucesso.";
			} else {
				$return->success = false;
				$return->message = "Falta o ID.";
			}
			break;
		default:
			$return->success = false;
			$return->message = "Erro.";
			break;
	}
} else {
	$return->success = false;
	$return->message = "Sem altorização para acesso.";
}

echo json_encode($return);
