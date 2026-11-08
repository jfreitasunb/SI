<?php

//require_once $ROOT_PATH_MAIN.'global/function_php.php';

class ModuleUT {
	/**
	 * @param $moduleID integer
	 * @return bool
	 */
	static public function haveUserLogged($moduleID) {
		global $DEVELOPMENT, $ROOT_PATH_MAIN;

		require_once $ROOT_PATH_MAIN.'global/function_php.php';

		require_once $ROOT_PATH_MAIN.'global/sessao_cookie.php';
		if (session_status() === PHP_SESSION_NONE) {
			session_start();
		}
		db_connect();

		// A senha nunca fica em sessao: secure('', '') valida a sessao autenticada
		// (flag + vinculo de IP) e a permissao no modulo.
		if ($DEVELOPMENT || secure('', '', $moduleID)) {
			return TRUE;
		}
		return FALSE;
	}

	/**
	 * Autentica um funcionario (tabela unix) pelo login/senha do formulario,
	 * com limite de tentativas no banco (global/limite_login.php).
	 * @param $login string
	 * @param $password string
	 * @return UnixBO|null usuario autenticado, ou null (senha errada, inexistente ou bloqueado)
	 */
	static public function authenticateEmployee($login, $password) {
		global $ROOT_PATH, $ROOT_PATH_MAIN, $ENCRYPTED_PASSWORDS;

		require_once $ROOT_PATH_MAIN.'global/function_php.php';
		require_once $ROOT_PATH.'modelController/unixMC.php';

		$login = (string)$login;
		$password = (string)$password;
		if ($login === '' || $password === '' || login_bloqueado($login)) {
			return null;
		}

		$unixMC = new UnixMC();
		$unixUser = $unixMC->getEmployeeByLogin($login);
		$hash = ($unixUser && isset($unixUser->password)) ? (string)$unixUser->password : '';

		$ok = false;
		if ($hash !== '') {
			$calculado = $ENCRYPTED_PASSWORDS ? (string)crypt($password, $hash) : $password;
			$ok = hash_equals($hash, $calculado);
		}

		if (!$ok) {
			login_falhou($login);
			return null;
		}
		login_sucesso($login);
		session_regenerate_id(true);
		return $unixUser;
	}

	/**
	 * @param $moduleID integer
	 */
	static public function validateUserModule($moduleID) {
		global $DEVELOPMENT, $ROOT_PATH_MAIN;
		if(!$DEVELOPMENT) {
			/** @noinspection PhpUnusedLocalVariableInspection */
			$idmodule = $moduleID;
			require_once $ROOT_PATH_MAIN.'global/header.php';
		}
	}

	/**
	 * @param $semester SemesterTO
	 */
	static public function updateNightShift($semester) {
		global $ROOT_PATH_MAIN;

		require_once $ROOT_PATH_MAIN.'modules/oferta/funcoes.php';

		atualiza_rodizio_noturno($semester->semester, $semester->year);
	}
}