<?php
require_once dirname(__FILE__).'/../conf/default.php';

require_once $ROOT_PATH.'utils/moduleUT.php';
require_once $ROOT_PATH.'utils/creditsUT.php';

$return = & new stdClass();

if (ModuleUT::haveUserLogged($ID_MODULE)) {
	require_once $ROOT_PATH.'modelController/offerListTemporaryMC.php';
	require_once $ROOT_PATH.'modelController/magisterialOfferListMC.php';

	$oltMC = new OfferListTemporaryMC();
	$magisterialMC = new MagisterialOfferListMC();

	switch ($_SERVER['REQUEST_METHOD']) {
		case 'DELETE':
			if (isset($_GET['class'])) {
				$class = null;
				$classID = explode('-', $_GET['class']);
				if (count($classID) == 1) {
					$class = $oltMC->get($_GET['class']);

					$oltMC->removeProfessorOfClass($_GET['class']);
				} else {
					$classID = $classID[0];
					$class = $magisterialMC->get($classID);

					$magisterialMC->removeProfessorOfClass($classID);
				}
				$return->success = true;
				$return->message = "Removido o professor";
				$return->credits = CreditsUT::creditsOfProfessorAtSemester($class->professor, $class);
				$return->professor = $class->professor;
			} else {
				$return->success = false;
				$return->message = "Falta de parâmetros";
			}
			break;
		case 'POST':
			if (isset($_GET['class']) && isset($_GET['professor'])) {
				$class = null;
				$classID = explode('-', $_GET['class']);
				if (count($classID) == 1) {
					$class = $oltMC->get($_GET['class']);

					$oltMC->updateProfessor($_GET['class'], $_GET['professor']);
				} else {
					$classID = $classID[0];
					$class = $magisterialMC->get($classID);

					$magisterialMC->updateProfessor($classID, $_GET['professor']);
				}

				$return->success = true;
				$return->message = "Atualizado o professor";
				$return->credits = CreditsUT::creditsOfProfessorAtSemester($_GET['professor'], $class);
				$return->professor = $_GET['professor'];
			} else {
				$return->success = false;
				$return->message = "Falta de parâmetros";
			}
			break;
		default:
			$return->success = false;
			$return->message = "Erro1.";
			break;
	}
} else {
	$return->success = false;
	$return->message = "Sem permissão.";
}

echo json_encode($return);