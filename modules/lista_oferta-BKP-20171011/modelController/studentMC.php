<?php

require_once $ROOT_PATH.'modelController/mc.php';
require_once $ROOT_PATH.'model/studentDAO.php';


class StudentMC extends MC
{
	function __construct()
	{
		$this->DAO = & new StudentDAO();
	}

	public function activeMastersStudentsList()
	{
		return $this->activeStudentsList(StudentDAO::MASTERS_STUDENT);
	}

	public function activePHDStudentsList()
	{
		return $this->activeStudentsList(StudentDAO::PHD_STUDENT);
	}

	public function activeStudentsList($level = null)
	{
		$filter['type'] = StudentDAO::TYPE_STUDENT;
		$filter['active'] = TRUE;
		$filter['situation'] = StudentDAO::SITUATION_ACTIVE;
		if (isset($level) && strlen($level)) {
			$filter['level'] = $level;
		}

		$order['name'] = DAO::ORDER_ASCENDANT;
		$order['last_name'] = DAO::ORDER_ASCENDANT;

		$list = & $this->DAO->filter($filter, $order);

		return $list;
	}
}