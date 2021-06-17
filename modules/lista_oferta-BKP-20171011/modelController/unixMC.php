<?php

require_once $ROOT_PATH.'modelController/mc.php';
require_once $ROOT_PATH.'model/unixDAO.php';


class UnixMC extends MC {
	/**
	 * UnixMC constructor.
     */
	function __construct() {
		$this->DAO = & new UnixDAO();
	}

	/**
	 * @param string $login
	 * @return UnixBO or null
     */
	public function getEmployeeByLogin($login) {
		return $this->getByLoginAndType($login, UnixDAO::TYPE_EMPLOYEE);
	}

	/**
	 * @param string $login
	 * @param string $type
	 * @return UnixBO or null
     */
	private function getByLoginAndType($login, $type) {
		$filter['type'] = $type;
		$filter['login'] = $login;

		$list = & $this->DAO->filter($filter);

		if (count($list) > 0) {
			return $list[0];
		}
		return NULL;
	}
}