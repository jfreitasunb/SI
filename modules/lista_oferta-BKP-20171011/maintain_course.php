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

	$vc = & new MCListVC();

	if ($_POST) {
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
