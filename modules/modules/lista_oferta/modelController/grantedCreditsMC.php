<?php

require_once $ROOT_PATH.'modelController/mc.php';
require_once $ROOT_PATH.'model/grantedCreditsDAO.php';

require_once $ROOT_PATH.'utils/utilUT.php';


class GrantedCreditsMC extends MC
{
	/**
	 * GrantedCreditsMC constructor.
	 */
	function __construct()
	{
		$this->DAO = new GrantedCreditsDAO();
	}

	/**
	 * @param string $id
	 * @return mixed
	 */
	public function getFullById($id) {
		$return = null;
		if(strlen($id) > 0) {
			$filter["id"] = $id;

			$list_obj = $this->DAO->filterWithUserActivityGroup($filter);

			if(count($list_obj)) {
				$return = $list_obj[0];
			}
		}
		return $return;
	}


	/**
	 * @param SemesterTO $semester
	 * @param string $type
	 * @return array [GrantedCreditsBO]
	 * @throws Exception
	 */
	public function listBySemester($semester, $type = null)
	{
		$filter['semester'] = $semester->semester;
		$filter['year'] = $semester->year;

		if ($type !== null) {
			$filter['group_type'] = $type;
		}

		$filter['status'] = DAO::ACTIVE;

		$list = $this->DAO->filterWithUserActivityGroup($filter);

		if (count($list)) {
			return $list;
		}
		return array();
	}


	/**
	 * @param stdClass $dataPosted
	 * @param SemesterTO $semester
	 * @return GrantedCreditsBO
	 * @throws Exception
	 */
	public function insert($dataPosted, $semester) {
		$insert = new stdClass();
		$insert->teacher = $dataPosted->teacher;
		$insert->activity = $dataPosted->activity;
		$insert->credits = $dataPosted->credits;
		$insert->year = $semester->year;
		$insert->semester = $semester->semester;
		$insert->extra = $dataPosted->extra;
		$insert->status = DAO::ACTIVE;

		$ret = $this->DAO->insert($insert);

		return $this->getFullById($ret->id);
	}

	public function delete($grantedCredit) {
		$fields['status'] = DAO::INACTIVE;

		$filter['id'] = UtilUT::data($grantedCredit);

		$this->DAO->update($fields, $filter);
	}


	/**
	 * @param SemesterTO $semester
	 * @param $professor
	 * @return array [GrantedCreditsBO]
	 * @throws Exception
	 */
	public function listBySemesterProfessor($semester, $professor)
	{
		$filter['semester'] = $semester->semester;
		$filter['year'] = $semester->year;
		$filter['teacher'] = UtilUT::data($professor);
		$filter['status'] = DAO::ACTIVE;

		$list = $this->DAO->filterWithUserActivityGroup($filter);

		if (count($list)) {
			return $list;
		}
		return array();
	}


	/**
	 * @param SemesterTO $semester
	 * @param integer $activity
	 * @return integer
	 * @throws Exception
	 */
	public function quantityCreditsBySemesterActivity($semester, $activity = null)
	{
		$filter['semester'] = $semester->semester;
		$filter['year'] = $semester->year;

		if ($activity !== null) {
			$filter['activity'] = $activity;
		}

		$filter['status'] = DAO::ACTIVE;

		$credits = $this->DAO->numberOfCredits($filter);

		if (count($credits)) {
			return $credits[0]->credits;
		}
		return 0;
	}


	/**
	 * @param array [GrantedCreditsBO] $list
	 */
	public function completeActivityDescription($list) {
		foreach ($list as $grantedCredits) {
			if (strlen($grantedCredits->discipline_name)) {
				$grantedCredits->activity_description .= " ($grantedCredits->discipline_name)";
			} elseif (strlen($grantedCredits->extra)) {
				$grantedCredits->activity_description .= " ($grantedCredits->extra)";
			}
		}
	}
}