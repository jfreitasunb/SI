<?php

require_once $ROOT_PATH.'modelController/mc.php';
require_once $ROOT_PATH.'model/offerListDAO.php';


class OfferListMC extends MC {

	function __construct() {
		$this->DAO = & new OfferListDAO();
	}

	public function pastSemesters() {
		$order['year'] = DAO::ORDER_DESCENDANT;
		$order['semester'] = DAO::ORDER_DESCENDANT;

		$list = & $this->DAO->filterDistinctSemesters($order);

		return $list;
	}

	public function classesForSemester($semester) {
		$filter['semester'] = $semester->semester;
		$filter['year'] = $semester->year;

		$list = & $this->DAO->filter($filter);

		return $list;
	}


}