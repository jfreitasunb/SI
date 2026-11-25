<?php
require_once 'conf/default.php';

require_once $ROOT_PATH.'utils/moduleUT.php';
require_once $ROOT_PATH . 'utils/utilUT.php';

require_once $ROOT_PATH.'modelController/courseMC.php';

ModuleUT::validateUserModule($ID_MODULE);

$courseMC = new CourseMC();

$vc = NULL;

if (isset($_GET["id"])) {
	require_once $ROOT_PATH.'modelController/tableItemMC.php';
	require_once $ROOT_PATH.'viewController/maintainCourse/mcEditVC.php';

	$tableItemMC = new TableItemMC();
	$courseTypes = $tableItemMC->getListCourseTypes();

	$vc = new MCEditVC();

	$courseSelected = null;
	if (strlen($_GET["id"])) {
		$courseSelected = $courseMC->get($_GET["id"]);
	}

	$vc->fillCourse($courseTypes, $courseSelected);
} else {
	require_once $ROOT_PATH.'viewController/maintainCourse/mcListVC.php';

	$vc = new MCListVC();

	if ($_POST) {
		// Reautenticacao obrigatoria no servidor (nao confiar apenas na validacao JS).
		$senha_conf = isset($_POST['password']) ? (string)$_POST['password'] : '';
		$login_sess = isset($_SESSION['login']) ? (string)$_SESSION['login'] : '';
		if ($login_sess === '' || $senha_conf === '' || login_bloqueado($login_sess) || !verif_pass_login($login_sess, $senha_conf)) {
			if ($login_sess !== '') {
				login_falhou($login_sess);
			}
			http_response_code(403);
			die(error("Senha incorreta ou muitas tentativas. Operacao cancelada."));
		}
		login_sucesso($login_sess);

		$courseForm = UtilUT::postToObject($_POST, array('id', 'name', 'credits', 'type_key'));


		if (isset($_POST['update'])) {
			$courseMC->insertUpdate($courseForm);
			$vc->setDiscipline($courseForm, true);
		} else {
			$courseMC->insert($courseForm);
			$vc->setDiscipline($courseForm);
		}
	}

	$coursesList = $courseMC->getCoursesList();

	$vc->fillCoursesList($coursesList);
}

$vc->close();
