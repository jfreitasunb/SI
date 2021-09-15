<?php

require_once $ROOT_PATH.'modelController/mc.php';
require_once $ROOT_PATH.'model/preferredDisciplinesGraduationOldDAO.php';

require_once $ROOT_PATH.'utils/utilUT.php';


class PreferredDisciplinesGraduationOldMC extends MC
{

	function __construct() {
		$this->DAO = new PreferredDisciplinesGraduationOldDAO();
	}

	public function getUserSemester($user, $semester) {
		$userId = UtilUT::data($user, 'user_id');

		$filter = array();
		$filter['user_id'] = $userId;
		$filter['year'] = $semester->year;
		$filter['semester'] = $semester->semester;

		$order['rank'] = DAO::ORDER_ASCENDANT;

		$list = $this->DAO->filter($filter, $order);

		return $list;
	}

	public function getListBySemester($semester) {
		$filter = array();
		$filter['year'] = $semester->year;
		$filter['semester'] = $semester->semester;

		$order['user_id'] = DAO::ORDER_ASCENDANT;
		$order['rank'] = DAO::ORDER_ASCENDANT;

		$list = $this->DAO->filter($filter, $order);

		return $list;
	}
}