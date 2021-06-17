<?php

require_once $ROOT_PATH.'modelController/mc.php';
require_once $ROOT_PATH.'model/professorDAO.php';


class ProfessorMC extends MC
{
	function __construct()
	{
		$this->DAO = new ProfessorDAO();
	}

	public function listProfessors($semester)
	{
		$filter['type'] = ProfessorDAO::TYPE_PROFESSOR;
		$filter['active'] = TRUE;
		$filter['situation'] = ProfessorDAO::SITUATION_ACTIVE;
		$filter['year'] = $semester->year;
		$filter['semester'] = $semester->semester;

		$order['name'] = DAO::ORDER_ASCENDANT;
		$order['last_name'] = DAO::ORDER_ASCENDANT;

		$listProfessors = $this->DAO->filter($filter, $order);

		return $listProfessors;
	}

	public function listActive($semester)
	{
		$filter['type'] = ProfessorDAO::TYPE_PROFESSOR;
		$filter['active'] = TRUE;
		$filter['situation'] = ProfessorDAO::SITUATION_ACTIVE;
		$filter['status'] = DAO::ACTIVE;
		$filter['year'] = $semester->year;
		$filter['semester'] = $semester->semester;

		$order['name'] = DAO::ORDER_ASCENDANT;
		$order['last_name'] = DAO::ORDER_ASCENDANT;

		$listProfessors = $this->DAO->filter($filter, $order);

		return $listProfessors;
	}

	public function listActiveExclusive($semester)
	{
		$filter['type'] = ProfessorDAO::TYPE_PROFESSOR;
		$filter['active'] = TRUE;
		$filter['situation'] = ProfessorDAO::SITUATION_ACTIVE;
		$filter['contract_type'] = ProfessorDAO::CONTRACT_TYPE_EXCLUSIVE;
		$filter['status'] = DAO::ACTIVE;
		$filter['year'] = $semester->year;
		$filter['semester'] = $semester->semester;

		$order['name'] = DAO::ORDER_ASCENDANT;
		$order['last_name'] = DAO::ORDER_ASCENDANT;

		$listProfessors = $this->DAO->filter($filter, $order);

		return $listProfessors;
	}

	private function insert($professor)
	{
		$insert = array();
		$insert['professor'] = $professor->professor;
		$insert['year'] = $professor->year;
		$insert['semester'] = $professor->semester;
		$insert['status'] = $professor->status;

        $this->DAO->insert($insert);
	}

	private function update($professor)
	{
		$update = array();
		$update['status'] = $professor->status;

		$filter = array();
		$filter['professor'] = $professor->professor;
		$filter['year'] = $professor->year;
		$filter['semester'] = $professor->semester;

		$return = $this->DAO->update($update, $filter);
	}

    /**
     * @param SemesterTO $semesterOld
     * @param SemesterTO $semesterNew
     */
    public function cloneFromSemesterToSemester($semesterOld, $semesterNew)
    {
        $listProfessors = $this->listProfessors($semesterOld);

        foreach ($listProfessors as $professor) {
			$professor->year = $semesterNew->year;
			$professor->semester = $semesterNew->semester;
        	
			$this->insert($professor);
        }
    }

    public function insertListInSemester($listProfessors, $semester)
    {
        foreach ($listProfessors as $professor) {
			$professor->year = $semester->year;
			$professor->semester = $semester->semester;
			$professor->status = DAO::ACTIVE;
        	
			$this->insert($professor);
        }
    }

    public function updateProfessors($listProfessors, $semester)
    {
        foreach ($listProfessors as $professor) {
			$professor->status = $professor->status ? DAO::ACTIVE : DAO::INACTIVE;
			$professor->year = $semester->year;
			$professor->semester = $semester->semester;
        	
			$this->update($professor);
        }
    }
}
