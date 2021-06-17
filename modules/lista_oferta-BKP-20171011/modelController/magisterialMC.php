<?php

require_once $ROOT_PATH.'modelController/mc.php';
require_once $ROOT_PATH.'model/magisterialDAO.php';

require_once $ROOT_PATH.'utils/utilUT.php';


class MagisterialMC extends MC
{
	function __construct()
	{
		$this->DAO = & new MagisterialDAO();
	}

	public function arrayDisciplineKeyBySemester($semester) {
		$filter['year'] = $semester->year;
		$filter['semester'] = $semester->semester;

		$list = & $this->DAO->filter($filter);

		return UtilUT::changeKey($list, "discipline");
	}

	public function theoryGroups($semester) {
		$list = & $this->DAO->theoryGroups($semester);

		if (!count($list)) {
			$list = array();
		}
		return $list;
	}

	public function insert($magisterial) {
		$insert = array();
		$insert["discipline"] = $magisterial->discipline;
		$insert["theory_quantity"] = $magisterial->theory_quantity;
		$insert["exercises_quantity"] = $magisterial->exercises_quantity;
		$insert["semester"] = $magisterial->semester;
		$insert["year"] = $magisterial->year;

		$this->DAO->insert($insert);
	}

	public function insertTheoryGroup($group) {
		$insert = array();
		$insert["group"] = $group->group;
		$insert["discipline"] = $group->discipline;
		$insert["class"] = $group->class;
		$insert["schedule"] = $group->schedule;
		$insert["semester"] = $group->semester;
		$insert["year"] = $group->year;

		$this->DAO->insertTheoryGroup($insert);
	}
}