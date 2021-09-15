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

		session_start();
		db_connect();

		if ($DEVELOPMENT || secure($_SESSION['login'], $_SESSION['passwd'], $moduleID)) {
			return TRUE;
		}
		return FALSE;
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