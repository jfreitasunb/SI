<?php

require_once $ROOT_PATH.'modelController/mc.php';
require_once $ROOT_PATH.'model/preferredDisciplinesGraduationDAO.php';

require_once $ROOT_PATH.'utils/utilUT.php';


class PreferredDisciplinesGraduationMC extends MC
{

	function __construct() {
		$this->DAO = new PreferredDisciplinesGraduationDAO();
	}

	public function getUserSemester($user, $semester) {
		$userId = UtilUT::data($user, 'user_id');

		$filter = array();
		$filter['user_id'] = $userId;
		$filter['year'] = $semester->year;
		$filter['semester'] = $semester->semester;

		$order['rank'] = DAO::ORDER_ASCENDANT;

		$list = $this->DAO->filter($filter, $order);

		return $list;
	}

	public function changeUserSemester($postData, $user, $semester, $listPDG = NULL) {
		$userId = UtilUT::data($user, 'user_id');

		if (count($listPDG)) {
			foreach ($listPDG as $pd) {
				$filter = array();
				$filter['id'] = $pd->id;

				$fields = array();
				$fields['discipline'] = $postData[$pd->rank]->discipline;
				$fields['quantity'] = strlen($postData[$pd->rank]->quantity) > 0 ? $postData[$pd->rank]->quantity : 1;
				$fields['period'] = $postData[$pd->rank]->period;
				if (isset($postData[$pd->rank]->type)) {
					$fields['type'] = $postData[$pd->rank]->type;
				} else {
					$fields['type'] = null;
				}

				$this->DAO->update($fields, $filter);
			}
		} else {
			$insert = array();
			$insert['user_id'] = $userId;
			$insert['year'] = $semester->year;
			$insert['semester'] = $semester->semester;

			foreach ($postData as $rank => $discipline) {
				$insert['rank'] = $rank;
				$insert['discipline'] = $discipline->discipline;
				$insert['quantity'] = strlen($discipline->quantity) > 0 ? $discipline->quantity : 1;
				$insert['period'] = $discipline->period;
				if (isset($discipline->type)) {
					$insert['type'] = $discipline->type;
				} else {
					unset($insert['type']);
				}

				$this->DAO->insert($insert);
			}
		}
	}

	public function getListBySemester($semester) {
		$filter = array();
		$filter['year'] = $semester->year;
		$filter['semester'] = $semester->semester;

		$order['user_id'] = DAO::ORDER_ASCENDANT;
		$order['rank'] = DAO::ORDER_ASCENDANT;

		$list = $this->DAO->filter($filter, $order);

		$return = null;
		if (count($list)) {
			foreach ($list as $value) {
				$return[$value->user_id][$value->rank] = $value;
			}
		}

		return $return;
	}

	public function cloneFromSemesterToSemester($semesterOld, $semesterNew) {
		$filter = array();
		$filter['year'] = $semesterOld->year;
		$filter['semester'] = $semesterOld->semester;

		$order['user_id'] = DAO::ORDER_ASCENDANT;
		$order['rank'] = DAO::ORDER_ASCENDANT;

		$list = $this->DAO->filter($filter, $order);
		
		foreach ($list as $choice) {
			$choice->year = $semesterNew->year;
			$choice->semester = $semesterNew->semester;

			$this->DAO->insert($choice);
		}
	}
}