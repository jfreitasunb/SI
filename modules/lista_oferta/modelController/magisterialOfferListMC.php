<?php

require_once $ROOT_PATH.'modelController/mc.php';
require_once $ROOT_PATH.'modelController/magisterialDisciplineMC.php';

require_once $ROOT_PATH.'model/magisterialOfferListDAO.php';

require_once $ROOT_PATH.'utils/utilUT.php';

class MagisterialOfferListMC extends MC
{
	function __construct()
	{
		$this->DAO = new MagisterialOfferListDAO();
	}

	public function listBySemesterAndDiscipline($semester, $disciplineID = null) {
		$filter['year'] = $semester->year;
		$filter['semester'] = $semester->semester;

		if (!is_null($disciplineID)) {
			$filter['discipline'] = $disciplineID;
		}

		$order['discipline'] = DAO::ORDER_ASCENDANT;
		$order['type'] = DAO::ORDER_ASCENDANT;
		$order['class'] = DAO::ORDER_ASCENDANT;

		$list = $this->DAO->filter($filter, $order);

		return $list;
	}

	public function listBySemesterGroupedByMagisterial($semester) {
		$list = $this->listBySemesterAndDiscipline($semester);

		$magisterialDisciplineMC = new MagisterialDisciplineMC();
		$listMagisterial = $magisterialDisciplineMC->disciplineKeyFromSemester($semester);

		$aux = array();
		foreach ($list as $object) {
			if (strcmp($object->type, "E") == 0) {
				$object->discipline_credits = $listMagisterial[$object->discipline]->exercises_quantity;
			} else {
				$object->discipline_credits = $listMagisterial[$object->discipline]->theory_quantity;
			}
			$classes = explode('-', $object->class);
			$aux[$object->discipline][$object->type][$classes[0]] = $object;
		}

		return $aux;
	}

	public function listBySemesterGroupedByMagisterialAndPeriod($semester) {
		$list = $this->listBySemesterAndDiscipline($semester);

		$magisterialDisciplineMC = new MagisterialDisciplineMC();
		$listMagisterial = $magisterialDisciplineMC->disciplineKeyFromSemester($semester);

		$aux = array();
		foreach ($list as $object) {
			if (strcmp($object->type, "E") == 0) {
				$object->discipline_credits = $listMagisterial[$object->discipline]->exercises_quantity;
			} else {
				$object->discipline_credits = $listMagisterial[$object->discipline]->theory_quantity;
			}
			$classes = explode('-', $object->class);
			$aux[$object->discipline][$object->type][$object->period][$classes[0]] = $object;
		}

		return $aux;
	}

	public function insert($offerClass) {
		$insert = new stdClass();
		$insert->discipline = $offerClass->discipline;
		$insert->class = $offerClass->class;
		$insert->schedule = $offerClass->schedule;
		$insert->period = $offerClass->period;
		$insert->year = $offerClass->year;
		$insert->semester = $offerClass->semester;
		$insert->type = $offerClass->type;

		return $this->DAO->insert($insert);
	}

	public function delete($from) {
		$filter = array();
		if (isset($from->id)) {
			$filter['id'] = $from->id;
		} else {
			$filter['year'] = $from->year;
			$filter['semester'] = $from->semester;

			if (isset($from->discipline)) {
				$filter['discipline'] = $from->discipline;
			}
		}

		$this->DAO->delete($filter);
	}

	public function updateProfessor($offerClass, $professor) {
		$filter['id'] = $offerClass;

		$update['professor'] = UtilUT::data($professor);

		$this->DAO->update($update, $filter);
	}

	public function updateSchedule($offerClass, $schedule) {
		$filter['id'] = UtilUT::data($offerClass);

		$update['schedule'] = $schedule;

		$this->DAO->update($update, $filter);
	}

	public function removeProfessorOfClass($offerClass) {
		$this->updateProfessor($offerClass, null);
	}

	public function listByProfessorSemester($professor, $semester) {
		$filter['year'] = $semester->year;
		$filter['semester'] = $semester->semester;
		$filter['professor'] = UtilUT::data($professor);

		$order['discipline'] = DAO::ORDER_ASCENDANT;
		$order['type'] = DAO::ORDER_ASCENDANT;
		$order['class'] = DAO::ORDER_ASCENDANT;

		return $this->DAO->filter($filter, $order);
	}

	public function clearAllProfessors($semester) {
		$filter['year'] = $semester->year;
		$filter['semester'] = $semester->semester;

		$update['professor'] = null;

		$this->DAO->update($update, $filter);
	}

	public function listByDisciplineTypeSemester($disciplineId, $type, $semester) {
		$filter['year'] = $semester->year;
		$filter['semester'] = $semester->semester;
		$filter['discipline'] = $disciplineId;
		$filter['type'] = $type;

		$order['discipline'] = DAO::ORDER_ASCENDANT;
		$order['type'] = DAO::ORDER_ASCENDANT;
		$order['class'] = DAO::ORDER_ASCENDANT;

		return $this->DAO->filterWithProfessor($filter, $order);
	}

	/**
	 * @param SemesterTO $semesterOld
	 * @param SemesterTO $semesterNew
	 * @throws Exception
	 */
	public function cloneFromSemesterToSemester($semesterOld, $semesterNew) {
		$theoryGroups = $this->listBySemesterAndDiscipline($semesterOld);

		foreach ($theoryGroups as $offer) {
			$offer->year = $semesterNew->year;
			$offer->semester = $semesterNew->semester;
			unset($offer->id);
			unset($offer->professor);

			$this->insert($offer);
		}
	}
}