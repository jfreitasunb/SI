<?php
require_once dirname(__FILE__).'/../conf/default.php';
require_once $ROOT_PATH.'utils/moduleUT.php';

// Exige usuario autenticado em um dos modulos que usam a tela de creditos concedidos.
if (!(ModuleUT::haveUserLogged($ID_MODULE) || ModuleUT::haveUserLogged($ID_MODULE_SECRETARY_GRADUATION) || ModuleUT::haveUserLogged($ID_MODULE_SECRETARY_POST))) {
	echo json_encode(array('success' => false, 'message' => 'Acesso negado.'));
	exit;
}

require_once $ROOT_PATH.'modelController/grantedCreditsMC.php';

$method = $_POST;

$return = new stdClass();

if ($method && isset($method['activity'])) {

	$data = null;
	$title = null;
	switch ($method['activity']) {
		case GrantedCreditsDAO::ACTIVITY_POST_CLASS:
			require_once $ROOT_PATH.'modelController/disciplinesMC.php';

			$disciplinesMC = new DisciplinesMC();
			$list = $disciplinesMC->graduationPost();

			$data = array();
			foreach ($list as $item) {
				$obj = new stdClass();
				$obj->key = $item->id;
				$obj->description = $item->name;
				$obj->credits = $item->credits;

				$data[] = $obj;
				unset($obj);
			}
			$title = "Disciplina";
			break;
		case GrantedCreditsDAO::ACTIVITY_POST_ORIENTATION_MASTERS:
			require_once $ROOT_PATH.'modelController/studentMC.php';
			$studentMC = new StudentMC();
			$list = $studentMC->activeMastersStudentsList();

			$data = array();
			foreach ($list as $item) {
				$obj = new stdClass();
				$obj->key = "$item->name $item->last_name";
				$obj->description = $obj->key;
				$obj->credits = "";

				$data[] = $obj;
				unset($obj);
			}
			$title = "Aluno";
			break;
		case GrantedCreditsDAO::ACTIVITY_POST_ORIENTATION_PHD:
			require_once $ROOT_PATH.'modelController/studentMC.php';
			$studentMC = new StudentMC();
			$list = $studentMC->activePHDStudentsList();

			$data = array();
			foreach ($list as $item) {
				$obj = new stdClass();
				$obj->key = "$item->name $item->last_name";
				$obj->description = $obj->key;
				$obj->credits = "";

				$data[] = $obj;
				unset($obj);
			}
			$title = "Aluno";
			break;
		default:
			$data = null;
	}

	$return->success = true;
	$return->title = $title;
	$return->data = $data;
} else {
	$return->success = false;
	$return->message = "Sem Grupo.";
}
//p($return);
echo json_encode($return);
