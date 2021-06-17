<?php

require_once $ROOT_PATH.'modelController/mc.php';
require_once $ROOT_PATH.'model/offerListTemporaryDAO.php';

require_once $ROOT_PATH.'utils/utilUT.php';

class OfferListTemporaryMC extends MC {

	function __construct() {
		$this->DAO = new OfferListTemporaryDAO();
	}

	public function getWithDisciplineById($id) {
		$return = null;
		if(strlen($id) > 0) {
			$filter["id"] = $id;

			$list_obj = $this->DAO->filterWithDiscipline($filter);

			if(count($list_obj)) {
				$return = $list_obj[0];
			}
		}

		return $return;
	}

	public function getListWithDisciplineOfSemester($semester) {
		$filter['year'] = $semester->year;
		$filter['semester'] = $semester->semester;
		$filter['status'] = DAO::ACTIVE;

		$order['discipline_name'] = DAO::ORDER_ASCENDANT;
		$order['class'] = DAO::ORDER_ASCENDANT;

		$list = $this->DAO->filterWithDiscipline($filter, $order);

		if (count($list)) {
			return $list;
		}
		return array();
	}

	public function getListWithDisciplineWithoutProfessorsOfSemester($semester) {
		$filter['year'] = $semester->year;
		$filter['semester'] = $semester->semester;
		$filter['status'] = DAO::ACTIVE;
		$filter['professor'] = null;

		$order['discipline_name'] = DAO::ORDER_ASCENDANT;
		$order['period'] = DAO::ORDER_ASCENDANT;
		$order['class'] = DAO::ORDER_ASCENDANT;

		$list = $this->DAO->filterWithDiscipline($filter, $order);

		if (count($list)) {
			return $list;
		}
		return array();
	}

	public function insertByCloning($offerList) {
		foreach ($offerList as $class) {
			$this->DAO->insert($class);
		}
	}

	public function getListDistinctDisciplines($semester) {
		$filter['year'] = $semester->year;
		$filter['semester'] = $semester->semester;
		$filter['status'] = DAO::ACTIVE;

		$order['discipline_name'] = DAO::ORDER_ASCENDANT;
		$order['period'] = DAO::ORDER_ASCENDANT;

		$list = $this->DAO->filterDistinctDiscipline($filter, $order);

		if (count($list)) {
			return $list;
		}
		return array();
	}

	public function deactivate($id) {
		$filter['id'] = $id;

		$update['status'] = DAO::INACTIVE;

		$this->DAO->update($update, $filter);
	}

	public function update($class, $id) {
		$filter['id'] = $id;

		$update['discipline'] = $class->discipline;
		$update['class'] = $class->class;
		$update['period'] = $class->period;
		$update['schedule'] = $class->schedule;
		$update['classroom'] = $class->classroom;

		$this->DAO->update($update, $filter);

		return $this->getWithDisciplineById($id);
	}

	public function insert($insert) {
		$ret = $this->DAO->insert($insert);

		return $this->getWithDisciplineById($ret->id);
	}

	public function updateProfessor($id, $professor) {
		$filter['id'] = $id;

		$update['professor'] = UtilUT::data($professor);

		$this->DAO->update($update, $filter);
	}

	public function removeProfessorOfClass($id) {
		$this->updateProfessor($id, null);
	}

	public function listBySemesterProfessor($semester, $professor) {
		$filter['year'] = $semester->year;
		$filter['semester'] = $semester->semester;
		$filter['status'] = DAO::ACTIVE;
		$filter['professor'] = UtilUT::data($professor);

		$order['discipline_name'] = DAO::ORDER_ASCENDANT;
		$order['class'] = DAO::ORDER_ASCENDANT;

		$list = $this->DAO->filterWithDiscipline($filter, $order);

		if (count($list)) {
			return $list;
		}
		return array();
	}

	public function clearAllProfessors($semester) {
		$filter['year'] = $semester->year;
		$filter['semester'] = $semester->semester;

		$update['professor'] = null;

		$this->DAO->update($update, $filter);
	}

	/**
	 * @param SemesterTO $semester
	 * @return integer
	 * @throws Exception
	 */
	public function getCreditsOfSemester($semester) {
		$filter['year'] = $semester->year;
		$filter['semester'] = $semester->semester;

		$credits = $this->DAO->numberOfCredits($filter);

		if (count($credits)) {
			return $credits[0]->credits;
		}
		return 0;
	}
}