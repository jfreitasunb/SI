<?php

require_once $ROOT_PATH.'modelController/mc.php';
require_once $ROOT_PATH.'model/magisterialDisciplineDAO.php';

require_once $ROOT_PATH.'utils/utilUT.php';


class MagisterialDisciplineMC extends MC
{
	function __construct()
	{
		$this->DAO = new MagisterialDisciplineDAO();
	}

	/**
	 * @param SemesterTO $semester
	 * @return array
	 * @throws Exception
	 */
	function fromSemester($semester) {
		$filter['year'] = $semester->year;
		$filter['semester'] = $semester->semester;

		$order['name'] = DAO::ORDER_ASCENDANT;

		$list = $this->DAO->filter($filter, $order);

		if (!count($list)) {
			$list = array();
		}
		return $list;
	}

	/**
	 * @param stdClass $discipline
	 * @param SemesterTO $semester
	 * @return stdClass
	 * @throws Exception
	 */
	function fromDisciplineAndSemester($discipline, $semester) {
		$filter['year'] = $semester->year;
		$filter['semester'] = $semester->semester;
		$filter['discipline'] = UtilUT::data($discipline);

		$order['name'] = DAO::ORDER_ASCENDANT;

		$list = $this->DAO->filter($filter, $order);

		if (count($list)) {
			return $list[0];
		}
		return null;
	}

	/**
	 * @param SemesterTO $semester
	 * @return array
	 */
	public function disciplineKeyFromSemester($semester) {
		$list = $this->fromSemester($semester);

		return UtilUT::changeKey($list, "discipline");
	}

    /**
     * @param $magisterialDiscipline
     * @throws Exception
	 * @return stdClass
     */
    public function insert($magisterialDiscipline) {
		$insert = array();
		$insert["discipline"] = $magisterialDiscipline->discipline;
		$insert["theory_quantity"] = $magisterialDiscipline->theory_quantity;
		$insert["exercises_quantity"] = $magisterialDiscipline->exercises_quantity;
		$insert["semester"] = $magisterialDiscipline->semester;
		$insert["year"] = $magisterialDiscipline->year;

		$magisterialDiscipline = $this->DAO->insert($insert);

		return $this->get($magisterialDiscipline->id);
	}

	/**
	 * @param stdClass $magisterialDiscipline
	 * @param string $id
	 * @return stdClass
	 * @throws Exception
	 */
	public function update($magisterialDiscipline, $id) {
		$filter['id'] = $id;

		$update['discipline'] = $magisterialDiscipline->discipline;
		$update['theory_quantity'] = $magisterialDiscipline->theory_quantity;
		$update['exercises_quantity'] = $magisterialDiscipline->exercises_quantity;

		$this->DAO->update($update, $filter);

		return $this->get($id);
	}

	public function delete($id) {
		$filter['id'] = $id;

		$this->DAO->delete($filter);
	}

    /**
     * @param SemesterTO $semesterOld
     * @param SemesterTO $semesterNew
     * @throws Exception
     */
    public function cloneFromSemesterToSemester($semesterOld, $semesterNew) {
        $disciplines = $this->fromSemester($semesterOld);

        foreach ($disciplines as $discipline) {
            $discipline->year = $semesterNew->year;
            $discipline->semester = $semesterNew->semester;

            $this->insert($discipline);
        }
	}
}