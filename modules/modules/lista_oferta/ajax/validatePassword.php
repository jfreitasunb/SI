<?php
session_start();

$return = new stdClass();

if ($_POST && isset($_POST['password']) && strlen($_POST['password'])) {
	if (isset($_SESSION['passwd']) && strcmp($_POST['password'], $_SESSION['passwd']) == 0) {
		$return->success = true;
		$return->message = "Senha correta";
	} else {
		$return->success = false;
		$return->message = "Senha incorreta.";
	}
} else {
	$return->success = false;
	$return->message = "Senha vazia.";
}

echo json_encode($return);
