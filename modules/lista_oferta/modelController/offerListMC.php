<?php

require_once $ROOT_PATH.'modelController/mc.php';
require_once $ROOT_PATH.'model/offerListDAO.php';


class OfferListMC extends MC {

	function __construct() {
		$this->DAO = new OfferListDAO();
	}

	public function pastSemesters() {
		$order['year'] = DAO::ORDER_DESCENDANT;
		$order['semester'] = DAO::ORDER_DESCENDANT;

		$list = $this->DAO->filterDistinctSemesters($order);

		return $list;
	}

	public function classesOfSemester($semester) {
		$filter['semester'] = $semester->semester;
		$filter['year'] = $semester->year;

		$list = $this->DAO->filter($filter);

		return $list;
	}

	private function clearSemester($semester) {
		$filter['semester'] = $semester->semester;
		$filter['year'] = $semester->year;

		$this->DAO->delete($filter);
	}

	public function insertClassesAtSemester($classes, $semester) {
		$this->clearSemester($semester);

		foreach ($classes as $class) {
			$insert = new stdClass();
			$insert->discipline = $class->discipline;
			$insert->class = $class->class;
			$insert->period = $class->period;
			$insert->schedule = $class->schedule;
			$insert->year = $semester->year;
			$insert->semester = $semester->semester;

			$this->DAO->insert($insert);
		}
	}
}
