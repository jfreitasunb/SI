<?php
require_once dirname(__FILE__).'/../conf/default.php';

require_once $ROOT_PATH.'utils/moduleUT.php';
require_once $ROOT_PATH.'utils/magisterialUT.php';


$return = new stdClass();

if (ModuleUT::haveUserLogged($ID_MODULE)) {
	require_once $ROOT_PATH.'modelController/magisterialTheoryGroupsMC.php';
	require_once $ROOT_PATH.'modelController/magisterialDisciplineMC.php';
	require_once $ROOT_PATH.'modelController/semesterMC.php';

	$semesterMC = new SemesterMC();
	$semester = $semesterMC->last();

	$mdMC = new MagisterialDisciplineMC();
	$request = json_decode(file_get_contents('php://input'));

	switch ($_SERVER['REQUEST_METHOD']) {
		case 'DELETE':
			if (isset($request->id)) {
				MagisterialUT::removeDisciplineAtSemester($request->id, $semester);

				$return->success = true;
				$return->message = "Removido com sucesso";
			} else {
				$return->success = false;
				$return->message = "Falta de parâmetros DELETE";
			}
			break;
		case 'PUT':
			$id = $request->id;

			$class = new stdClass();
			$class->discipline = $request->discipline;
			$class->theory_quantity = $request->theory_quantity;
			$class->exercises_quantity = $request->exercises_quantity;

			$return->success = true;
			$return->message = "Atualizado com sucesso";

			$return->data = $mdMC->update($class, $id);
			break;
		case 'POST':
			$class = new stdClass();
			$class->discipline = $request->discipline;
			$class->theory_quantity = $request->theory_quantity;
			$class->exercises_quantity = $request->exercises_quantity;
			$class->year = $semester->year;
			$class->semester = $semester->semester;

			$return->data = $mdMC->insert($class);
			$return->success = true;
			$return->message = "Inserido com sucesso";
			break;
		default:
			$return->success = false;
			$return->message = "Método não previsto.";
			break;
	}
} else {
	$return->success = false;
	$return->message = "Sem permissão.";
}

echo json_encode($return);
?>