<?php

require_once $ROOT_PATH.'modelController/mc.php';
require_once $ROOT_PATH.'model/disciplinesDAO.php';


class DisciplinesMC extends MC
{
	function __construct()
	{
		$this->DAO = new DisciplinesDAO();
	}

	public function graduationDisciplines()
	{
		$filter['type'] = DisciplinesDAO::GRADUATION;

		$order['name'] = DAO::ORDER_ASCENDANT;

		$list = $this->DAO->filter($filter, $order);

		return $list;
	}

	public function graduationPost()
	{
		$filter['type'] = DisciplinesDAO::POSTGRADUATION;

		$order['name'] = DAO::ORDER_ASCENDANT;

		$list = $this->DAO->filter($filter, $order);

		return $list;
	}

	public function graduationDisciplinesOferedOnSemester($semester) {
		$filter['type'] = DisciplinesDAO::GRADUATION;
		$filter['status'] = DAO::ACTIVE;
		$filter['semester'] = $semester->semester;
		$filter['year'] = $semester->year;

		$order['name'] = DAO::ORDER_ASCENDANT;

		$list = $this->DAO->oltFilter($filter, $order);

		return $list;
	}
}