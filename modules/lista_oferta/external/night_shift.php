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
	$_SESSION = array();
	session_destroy();
	session_start();
	csrf_token();
}

if (!isset($_SESSION["user"])) {
	require_once $ROOT_PATH.'viewController/professorNightShift/pnsLoginVC.php';
	require_once $ROOT_PATH.'modelController/unixMC.php';

	$vc = new PNSLoginVC();

	if ($_POST && isset($_POST['login']) && isset($_POST['password'])) {
		require_once $ROOT_PATH.'utils/moduleUT.php';
		$unixUser = ModuleUT::authenticateEmployee($_POST['login'], $_POST['password']);

		if ($unixUser !== null) {
			unset($unixUser->password);
			$_SESSION["user"] = serialize($unixUser);
			$_SESSION["lo_last_activity"] = time();
			$_SESSION["csrf_token"] = bin2hex(random_bytes(32));
		} else {
			$vc->close();
		}
	} else {
		$vc->close();
	}
}
if (isset($_SESSION["user"])) {
	if (isset($_SESSION["lo_last_activity"]) && (time() - (int)$_SESSION["lo_last_activity"]) > 1800) {
		$_SESSION = array();
		session_destroy();
		header('Location: night_shift.php', true, 302);
		exit;
	}
	$_SESSION["lo_last_activity"] = time();
	$logged = true;
	define('LO_ENTRY_AUTHORIZED', true);
	require_once $ROOT_PATH . 'module/professor_night_shift.php';
}
