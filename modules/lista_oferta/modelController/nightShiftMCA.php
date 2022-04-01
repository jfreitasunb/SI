<?php

require_once $ROOT_PATH.'modelController/mc.php';
require_once $ROOT_PATH.'model/nightShiftDAOA.php';


class NightShiftMC extends MC
{
	function __construct()
	{
		$this->DAO = new NightShiftDAOA();
	}

	public function listUntilSemesterA($semester)
	{
		$semesterSem = $semester->semester == 2? $semester->semester : null;

		$listProfessors = $this->DAO->filter(null, $semester->year, $semesterSem);
		return $listProfessors;
	}

}
