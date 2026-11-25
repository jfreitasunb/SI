<?php
require_once dirname(__FILE__).'/../conf/default.php';
require_once $ROOT_PATH.'utils/moduleUT.php';

header('Content-Type: application/json; charset=utf-8');
header('X-Content-Type-Options: nosniff');

$return = new stdClass();

if (ModuleUT::haveUserLogged($ID_MODULE)) {
	require_once $ROOT_PATH.'modelController/offerListTemporaryMC.php';
	require_once $ROOT_PATH.'modelController/semesterMC.php';

	$semesterMC = new SemesterMC();
	$semester = $semesterMC->last();
	if ($semester->status != SemesterDAO::STATUS_STAGE_1 && $semester->status != SemesterDAO::STATUS_STAGE_2) {
		$return->success = false;
		$return->message = "Semestre fechado para alteracoes.";
		echo json_encode($return, JSON_HEX_TAG | JSON_HEX_AMP | JSON_HEX_APOS | JSON_HEX_QUOT);
		exit;
	}

	$oltMC = new OfferListTemporaryMC();
	if ($_POST && isset($_POST['remove'])) {
		$id = $_POST['remove'];
		$alvo = $oltMC->get($id);
		if (!$alvo || (int)$alvo->year !== (int)$semester->year || (int)$alvo->semester !== (int)$semester->semester) {
			$return->success = false;
			$return->message = "Turma fora do semestre atual.";
			echo json_encode($return, JSON_HEX_TAG | JSON_HEX_AMP | JSON_HEX_APOS | JSON_HEX_QUOT);
			exit;
		}

		$oltMC->deactivate($id);

		$return->success = true;
		$return->message = "Removido com sucesso";
	} elseif ($_POST && isset($_POST['update'])) {
		$id = $_POST['update'];
		$alvo = $oltMC->get($id);
		if (!$alvo || (int)$alvo->year !== (int)$semester->year || (int)$alvo->semester !== (int)$semester->semester) {
			$return->success = false;
			$return->message = "Turma fora do semestre atual.";
			echo json_encode($return, JSON_HEX_TAG | JSON_HEX_AMP | JSON_HEX_APOS | JSON_HEX_QUOT);
			exit;
		}

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

echo json_encode($return, JSON_HEX_TAG | JSON_HEX_AMP | JSON_HEX_APOS | JSON_HEX_QUOT);
?>