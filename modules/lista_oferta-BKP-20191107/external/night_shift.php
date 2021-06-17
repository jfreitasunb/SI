<?php

require_once dirname(__FILE__) . '/../conf/default.php';

session_start();

if ($_POST && isset($_POST['logout'])) {
	session_unset();
	session_destroy();
}

if (!isset($_SESSION["user"])) {
	require_once $ROOT_PATH.'viewController/professorNightShift/pnsLoginVC.php';
	require_once $ROOT_PATH.'modelController/unixMC.php';

	$vc = new PNSLoginVC();

	if ($_POST && isset($_POST['login']) && isset($_POST['password'])) {
		$password = $_POST['password'];

		$unixMC = new UnixMC();
		$unixUser = $unixMC->getEmployeeByLogin($_POST['login']);

		if ($ENCRYPTED_PASSWORDS) {
			$password = crypt($password, $unixUser->password);
		}

		if (!strcmp($password, $unixUser->password)) {
			$_SESSION["user"] = serialize($unixUser);
		} else {
			$vc->close();
		}
	} else {
		$vc->close();
	}
}
if (isset($_SESSION["user"])) {
	$logged = true;
	require_once $ROOT_PATH . 'module/professor_night_shift.php';
}
