<?php
require_once dirname(__FILE__).'/../conf/default.php';
require_once $ROOT_PATH.'utils/moduleUT.php';

header('Content-Type: application/json; charset=utf-8');
header('X-Content-Type-Options: nosniff');

$return = new stdClass();
$return->success = false;

if (!ModuleUT::haveUserLogged($ID_MODULE)) {
	$return->message = "Sem permissao.";
	echo json_encode($return, JSON_HEX_TAG | JSON_HEX_AMP | JSON_HEX_APOS | JSON_HEX_QUOT);
	exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['password']) && strlen((string)$_POST['password']) > 0) {
	$login_sess = isset($_SESSION['login']) ? (string)$_SESSION['login'] : '';
	if ($login_sess !== '' && !login_bloqueado($login_sess) && verif_pass_login($login_sess, (string)$_POST['password'])) {
		login_sucesso($login_sess);
		$return->success = true;
		$return->message = "Senha correta";
	} else {
		if ($login_sess !== '') {
			login_falhou($login_sess);
		}
		$return->message = "Senha incorreta.";
	}
} else {
	$return->message = "Senha vazia.";
}

echo json_encode($return, JSON_HEX_TAG | JSON_HEX_AMP | JSON_HEX_APOS | JSON_HEX_QUOT);
