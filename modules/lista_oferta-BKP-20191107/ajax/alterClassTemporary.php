<?php
require_once dirname(__FILE__).'/../conf/default.php';
require_once $ROOT_PATH.'utils/moduleUT.php';

$return = new stdClass();

if (ModuleUT::haveUserLogged($ID_MODULE)) {
	require_once $ROOT_PATH.'modelController/offerListTemporaryMC.php';
	require_once $ROOT_PATH.'modelController/semesterMC.php';

	$oltMC = new OfferListTemporaryMC();
	if ($_POST && isset($_POST['remove'])) {
		$id = $_POST['remove'];

		$oltMC->deactivate($id);

		$return->success = true;
		$return->message = "Removido com sucesso";
	} elseif ($_POST && isset($_POST['update'])) {
		$id = $_POST['update'];

		$class = new stdClass();
		$class->discipline = $_POST['discipline_id'];
		$class->class = $_POST['class'];
		$class->period = $_POST['period'];
		$class->schedule = $_POST['schedule'];
		$class->classroom = $_POST['classroom'];

		$return->success = true;
		$return->message = "Atualizado com sucesso";

		$return->response = array($oltMC->update($class, $id));
	} elseif ($_POST && isset($_POST['insert'])) {
		$semesterMC = new SemesterMC();
		$semester = $semesterMC->last();

		$class = new stdClass();
		$class->discipline = $_POST['discipline_id'];
		$class->class = $_POST['class'];
		$class->period = $_POST['period'];
		$class->schedule = $_POST['schedule'];
		$class->classroom = $_POST['classroom'];
		$class->year = $semester->year;
		$class->semester = $semester->semester;
		$class->status = DAO::ACTIVE;

		$return->success = true;
		$return->message = "Inserido com sucesso";

		$return->response = array($oltMC->insert($class));
	}
} else {
	$return->success = false;
	$return->message = "Sem permissão.";
}

echo json_encode($return);
?>