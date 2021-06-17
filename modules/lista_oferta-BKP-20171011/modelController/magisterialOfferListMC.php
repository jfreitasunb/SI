<?php

require_once $ROOT_PATH.'modelController/mc.php';
require_once $ROOT_PATH.'model/magisterialOfferListDAO.php';

require_once $ROOT_PATH.'utils/utilUT.php';

class MagisterialOfferListMC extends MC
{
	function __construct()
	{
		$this->DAO = & new MagisterialOfferListDAO();
	}

	public function listBySemester($semester) {
		$filter['year'] = $semester->year;
		$filter['semester'] = $semester->semester;

		$order['discipline'] = DAO::ORDER_ASCENDANT;
		$order['type'] = DAO::ORDER_ASCENDANT;
		$order['class'] = DAO::ORDER_ASCENDANT;

		$list = & $this->DAO->filter($filter, $order);

		$aux = array();
		foreach ($list as $object) {
			$classes = explode('-', $object->class);
			$aux[$object->discipline][$object->type][$classes[0]] = $object;
		}
		return $aux;
	}

	public function insert($offerClass) {
		$insert = new stdClass();
		$insert->discipline = $offerClass->discipline;
		$insert->class = $offerClass->class;
		$insert->schedule = $offerClass->schedule;
		$insert->period = $offerClass->period;
		$insert->year = $offerClass->year;
		$insert->semester = $offerClass->semester;
		$insert->type = $offerClass->type;

		return $this->DAO->insert($insert);
	}

	public function updateProfessor($offerClass, $professor) {
		$filter['id'] = $offerClass;

		$update['professor'] = UtilUT::data($professor);

		$this->DAO->update($update, $filter);
	}

	public function removeProfessorOfClass($offerClass) {
		$this->updateProfessor($offerClass, null);
	}

	public function listByProfessorSemester($professor, $semester) {
		$filter['year'] = $semester->year;
		$filter['semester'] = $semester->semester;
		$filter['professor'] = UtilUT::data($professor);

		$order['discipline'] = DAO::ORDER_ASCENDANT;
		$order['type'] = DAO::ORDER_ASCENDANT;
		$order['class'] = DAO::ORDER_ASCENDANT;

		return $this->DAO->filter($filter, $order);
	}

	public function clearAllProfessors($semester) {
		$filter['year'] = $semester->year;
		$filter['semester'] = $semester->semester;

		$update['professor'] = null;

		$this->DAO->update($update, $filter);
	}
}