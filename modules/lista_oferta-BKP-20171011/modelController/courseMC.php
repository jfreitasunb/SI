<?php

require_once $ROOT_PATH.'modelController/mc.php';
require_once $ROOT_PATH.'model/courseDAO.php';


class CourseMC extends MC {

	/**
	 * CourseMC constructor.
     */
	function __construct() {
		$this->DAO = & new CourseDAO();
	}

	public function getCoursesList() {
		$filter = Array();
		$order['name'] = DAO::ORDER_DESCENDANT;

		$list = $this->DAO->filterWithType($filter, $order);

		return $list;
	}

	public function insert($course) {
		return $this->DAO->insert($course);
	}
}
