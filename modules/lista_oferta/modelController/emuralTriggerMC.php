<?php

require_once $ROOT_PATH.'modelController/mc.php';
require_once $ROOT_PATH.'model/emuralTriggerDAO.php';


class EmuralTriggerMC extends MC
{
	function __construct()
	{
		$this->DAO = new EmuralTriggerDAO();
	}

	/**
	 * @param stdClass|SemesterTO $semester
	 * @return stdClass
	 */
	public function create($semester) {
		$insert = array();
		$insert['year'] = $semester->year;
		$insert['semester'] = $semester->semester;
		$insert['situation'] = EmuralTriggerDAO::EMURAL_TRIGGER_NEW;

		return $this->DAO->insert($insert);
	}

	/**
	 * @param stdClass|SemesterTO $semester
	 * @return stdClass
	 */
	public function finish($semester)
	{
		$filter = array();
		$filter['year'] = $semester->year;
		$filter['semester'] = $semester->semester;

		$update['situation'] = EmuralTriggerDAO::EMURAL_TRIGGER_FINISHED;

		return $this->DAO->update($update, $filter);
	}
}
