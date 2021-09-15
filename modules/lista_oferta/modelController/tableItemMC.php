<?php

require_once $ROOT_PATH.'modelController/mc.php';
require_once $ROOT_PATH.'model/tableItemDAO.php';


class TableItemMC extends MC {

	function __construct() {
		$this->DAO = new TableItemDAO();
	}

	private function getListOfTable($type) {
		$filter['table'] = $type;
		$order['value'] = DAO::ORDER_ASCENDANT;

		$list = $this->DAO->filter($filter, $order);
		return $list;
	}

	public function getListPeriods() {
		return $this->getListOfTable(TableItemDAO::PERIOD);
	}

	public function getListCourseTypes() {
		return $this->getListOfTable(TableItemDAO::COURSE_TYPE);
	}

	public function getListGroupActivitiesGraduation() {
		return $this->getListOfTable(TableItemDAO::ACTIVITY_GRADUATION);
	}

	public function getListGroupActivitiesPostGraduation() {
		return $this->getListOfTable(TableItemDAO::ACTIVITY_POSTGRADUATE);
	}

	public function getListAllGroupActivities() {
		return $this->DAO->getListAllGroupActivities();
	}
}