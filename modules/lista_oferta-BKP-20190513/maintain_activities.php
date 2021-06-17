<?php
require_once 'conf/default.php';

require_once $ROOT_PATH.'utils/moduleUT.php';
require_once $ROOT_PATH.'utils/utilUT.php';

require_once $ROOT_PATH.'modelController/activitiesMC.php';

ModuleUT::validateUserModule($ID_MODULE);

$activitiesMC = new ActivitiesMC();

$vc = NULL;

if (isset($_GET["id"])) {
	require_once $ROOT_PATH.'modelController/tableItemMC.php';
	require_once $ROOT_PATH.'viewController/maintainActivities/maEditVC.php';

	$tableItemMC = new TableItemMC();
	$groups = $tableItemMC->getListAllGroupActivities();

	$vc = new MAEditVC();

	if (strlen($_GET["id"])) {
		$activitySelected = $activitiesMC->get($_GET["id"]);
		$vc->fillActivity($activitySelected);
	}

	$vc->fillGroup($groups);
} else {
	require_once $ROOT_PATH.'viewController/maintainActivities/maListVC.php';

	if ($_POST) {
		$activityForm = UtilUT::postToObject($_POST, array('id', 'group_key', 'description', 'credits', 'maximum'));

		$activitiesMC->insertUpdate($activityForm);
	}

	$activitiesList = $activitiesMC->listComplete();

	$vc = new MAListVC();
	$vc->fillActivitiesList($activitiesList);
}

$vc->close();
