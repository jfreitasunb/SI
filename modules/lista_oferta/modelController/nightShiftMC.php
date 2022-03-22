<?php

require_once $ROOT_PATH.'modelController/mc.php';
require_once $ROOT_PATH.'model/nightShiftDAO.php';


class NightShiftMC extends MC
{
	function __construct()
	{
		$this->DAO = new NightShiftDAO();
	}

	public function listUntilSemester($semester)
	{
		$semesterSem = $semester->semester == 2? $semester->semester : null;

		$listProfessors = $this->DAO->filter(null, $semester->year, $semesterSem);
		return $listProfessors;
	}
}
