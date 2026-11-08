<?php

require_once dirname(__FILE__) . '/../conf/default.php';

require_once $ROOT_PATH_MAIN.'global/sessao_cookie.php';
session_start();
// CSRF: valida POSTs e injeta o token nos formularios (paginas sem header.php).
require_once $ROOT_PATH_MAIN.'global/function_php.php';
csrf_valida();
csrf_token();
ob_start('csrf_injeta');

if ($_POST && isset($_POST['logout'])) {
	session_unset();
	session_destroy();
}

if (!isset($_SESSION["user"])) {
	require_once $ROOT_PATH.'viewController/professorNightShift/pnsLoginVC.php';
	require_once $ROOT_PATH.'modelController/unixMC.php';

	$vc = new PNSLoginVC();

	if ($_POST && isset($_POST['login']) && isset($_POST['password'])) {
		require_once $ROOT_PATH.'utils/moduleUT.php';
		$unixUser = ModuleUT::authenticateEmployee($_POST['login'], $_POST['password']);

		if ($unixUser !== null) {
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
	require_once $ROOT_PATH . 'module/professor_night_shift_old.php';
}
