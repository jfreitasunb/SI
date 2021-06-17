<?php

require_once $ROOT_PATH.'modelController/mc.php';
require_once $ROOT_PATH.'model/disciplinesDAO.php';


class DisciplinesMC extends MC
{
	const GRADUATION = 'grad';
	const POSTGRADUATION = 'pgrad';

	function __construct()
	{
		$this->DAO = new DisciplinesDAO();
	}

	public function graduationDisciplines()
	{
		$filter['type'] = self::GRADUATION;

		$order['name'] = DAO::ORDER_ASCENDANT;

		$list = $this->DAO->filter($filter, $order);

		return $list;
	}

	public function graduationPost()
	{
		$filter['type'] = self::POSTGRADUATION;

		$order['name'] = DAO::ORDER_ASCENDANT;

		$list = $this->DAO->filter($filter, $order);

		return $list;
	}
}