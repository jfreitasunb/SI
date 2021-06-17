<?php

require_once $ROOT_PATH.'modelController/mc.php';
require_once $ROOT_PATH.'model/usersDAO.php';


class UserMC extends MC
{
	function __construct()
	{
		$this->DAO = & new UsersDAO();
	}

	public function activeTeachersList()
	{
		$filter['type'] = UsersDAO::TYPE_PROFESSOR;
		$filter['active'] = TRUE;
		$filter['situation'] = UsersDAO::SITUATION_ACTIVE;

		$order['name'] = DAO::ORDER_ASCENDANT;
		$order['last_name'] = DAO::ORDER_ASCENDANT;

		$listProfessors = & $this->DAO->filter($filter, $order);

		return $listProfessors;
	}
}