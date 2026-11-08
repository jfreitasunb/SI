<?php

require_once $ROOT_PATH.'modelController/mc.php';
require_once $ROOT_PATH.'model/creditsSemesterDAO.php';


class CreditsSemesterMC extends MC {

	/**
	 * CreditsSemesterMC constructor.
     */
	function __construct() {
		$this->DAO = new CreditsSemesterDAO();
	}


    /**
     * @param $semester
     * @return array
     * @throws Exception
     */
    public function getListWithProfessors($semester) {
		$filter['year'] = $semester->year;
		$filter['semester'] = $semester->semester;

		$order['user_name'] = DAO::ORDER_ASCENDANT;
		$order['user_last_name'] = DAO::ORDER_ASCENDANT;

		$list = $this->DAO->filterWithUser($filter, $order);

		return $list;
	}


	public function getArrayKeyUserIdWithProfessors($semester) {
		$list = $this->getListWithProfessors($semester);

		$return = Array();
		if (count($list)) {
			foreach ($list as $creditsSemesterProfessor) {
				$return[$creditsSemesterProfessor->user_id] = $creditsSemesterProfessor;
			}
		}

		return $return;
	}


	public function insertUpdate($arrayIdsProfessorsCredits, $semester = NULL, $listCreditsSemesterProfessors = NULL) { // $semester opcional: compativel com MC (PHP 8)
		if ($listCreditsSemesterProfessors !== NULL && count($listCreditsSemesterProfessors)) {
			$filter['year'] = $semester->year;
			$filter['semester'] = $semester->semester;

			foreach ($listCreditsSemesterProfessors as $creditsSemesterProfessor) {
				$user_id = $creditsSemesterProfessor->user_id;
				if (isset($arrayIdsProfessorsCredits[$user_id]) &&
					$arrayIdsProfessorsCredits[$user_id] != $creditsSemesterProfessor->credits) {

					$filter['user_id'] = $user_id;

					$fields['credits'] = $arrayIdsProfessorsCredits[$user_id];

					$this->DAO->update($fields, $filter);
				}

				unset($arrayIdsProfessorsCredits[$user_id]);
			}
		} if (count($arrayIdsProfessorsCredits)) {
			$this->insertAll($arrayIdsProfessorsCredits, $semester);
		}
	}


	private function insertAll($arrayIdsProfessorsCredits, $semester) {
		$insert['year'] = $semester->year;
		$insert['semester'] = $semester->semester;

		foreach ($arrayIdsProfessorsCredits as $professorId => $credits) {
			$insert['user_id'] = $professorId;
			$insert['credits'] = $credits;
			$this->DAO->insert($insert);
		}
	}
}