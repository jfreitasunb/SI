<?php

require_once $ROOT_PATH.'modelController/mc.php';
require_once $ROOT_PATH.'model/semesterDAO.php';


class SemesterMC extends MC {
	/**
	 * SemesterMC constructor.
     */
	function __construct() {
		$this->DAO = new SemesterDAO();
	}

	/**
	 * @return SemesterTO
     */
	public function last() {
		$order["year"] = DAO::ORDER_DESCENDANT;
		$order["semester"] = DAO::ORDER_DESCENDANT;
		$order["id"] = DAO::ORDER_DESCENDANT;

		$list = $this->DAO->filter(NULL, $order, 0, 1);

		if (count($list) ) {
			return $list;
		}
		return NULL;
	}

	/**
	 * @return SemesterTO[]
     */
	public function allSemesters() {
		$order["year"] = DAO::ORDER_DESCENDANT;
		$order["semester"] = DAO::ORDER_DESCENDANT;
		$order["id"] = DAO::ORDER_DESCENDANT;

		$list = $this->DAO->filter(NULL, $order);

		if (!count($list)) {
			return array();
		}
		return $list;
	}

	/**
	 * @param stdClass|SemesterTO $postData
	 * @return SemesterTO
     */
	public function create($postData) {
		$insert = array();
		$insert['year'] = $postData->year;
		$insert['semester'] = $postData->semester;
		$insert['status'] = SemesterDAO::STATUS_STAGE_1;
		$insert['beginning'] = $postData->beginning;
		$insert['end'] = $postData->end;

		return $this->DAO->insert($insert);
	}

	/**
	 * @param stdClass|SemesterTO $semester
	 * @return SemesterTO
	 */
	public function update($semester) {
		$update = array();
		$update["beginning"] = $semester->beginning;
		$update["end"] = $semester->end;
		$update["status"] = $semester->status;
		$update["reduction_credits"] = $semester->reduction_credits;
		$update["publications_threshold"] = $semester->publications_threshold;
		if (isset($semester->average_credits) && strlen($semester->average_credits)) {
			$update["average_credits"] = $semester->average_credits;
		} else {
			$update["average_credits"] = null;
		}

		$filter = array();
		$filter["id"] = $semester->id;

		$return = $this->DAO->update($update, $filter);
		return $return[0];
	}

	/**
	 * @return array
	 */
	public function stages() {
		$stages = array();
		$stage = new stdClass();
		$stage->id = SemesterDAO::STATUS_STAGE_1;
		$stage->description = "Etapa 1";
		$stages[] = $stage;
		unset($stage);

		$stage = new stdClass();
		$stage->id = SemesterDAO::STATUS_STAGE_2;
		$stage->description = "Etapa 2";
		$stages[] = $stage;
		unset($stage);

		$stage = new stdClass();
		$stage->id = SemesterDAO::STATUS_STAGE_3;
		$stage->description = "Etapa 3";
		$stages[] = $stage;
		unset($stage);

		$stage = new stdClass();
		$stage->id = SemesterDAO::STATUS_CLOSED;
		$stage->description = "Fechado";
		$stages[] = $stage;
		unset($stage);

		return $stages;
	}
}
