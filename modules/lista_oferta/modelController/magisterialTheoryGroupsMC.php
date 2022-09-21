<?php

require_once $ROOT_PATH.'modelController/mc.php';
require_once $ROOT_PATH.'model/magisterialTheoryGroupsDAO.php';

require_once $ROOT_PATH.'utils/utilUT.php';


class MagisterialTheoryGroupsMC extends MC
{
	function __construct()
	{
		$this->DAO = new MagisterialTheoryGroupsDAO();
	}

	/**
	 * @param SemesterTO $semester
	 * @return array
	 * @throws Exception
	 */
	public function fromSemester($semester) {


		$filter['year'] = $semester->year;
		$filter['semester'] = $semester->semester;

		$order['discipline'] = DAO::ORDER_ASCENDANT;
		$order['class'] = DAO::ORDER_ASCENDANT;

		$list = $this->DAO->filter($filter, $order);

		if (!count($list)) {
			$list = array();
		}
		return $list;
	}

	/**
	 * @param SemesterTO $semester
	 * @param int $discipline
	 * @return array
	 * @throws Exception
	 */
	public function fromSemesterAndDisciplineClassKey($semester, $discipline) {
		$filter['year'] = $semester->year;
		$filter['semester'] = $semester->semester;
		$filter['discipline'] = $discipline;

		$order['discipline'] = DAO::ORDER_ASCENDANT;
		$order['class'] = DAO::ORDER_ASCENDANT;

		$list = $this->DAO->filter($filter, $order);

		if (!count($list)) {
			$list = array();
		}
		return UtilUT::changeKey($list, "class");
	}

	/**
	 * @param SemesterTO $semester
	 * @param stdClass $discipline
	 * @return array
	 * @throws Exception
	 */
	public function fromSemesterAndDisciplineGroupedByGroup($semester, $discipline) {
		$filter['year'] = $semester->year;
		$filter['semester'] = $semester->semester;
		$filter['discipline'] = $discipline;

		$order['group'] = DAO::ORDER_ASCENDANT;
		$order['class'] = DAO::ORDER_ASCENDANT;

		$theoryGroups = $this->DAO->filter($filter, $order);

		if (!count($theoryGroups)) {
			$theoryGroups = array();
		} else {
			$return = array();
			foreach ($theoryGroups as $group) {
				if (strlen($group->group)) {
					$return[$group->group][$group->class] = $group;
				}
			}
			$theoryGroups = $return;
		}
		return $theoryGroups;
	}

    /**
     * @param $group
     * @throws Exception
	 * @return stdClass
     */
    public function insert($group) {
		$insert = array();
		$insert["group"] = $group->group;
		$insert["discipline"] = $group->discipline;
		$insert["discipline_2"] = $group->discipline."001";
		$insert["class"] = $group->class;
		$insert["schedule"] = $group->schedule;
		$insert["semester"] = $group->semester;
		$insert["year"] = $group->year;

		return $this->DAO->insert($insert);
	}

	public function update($update, $from) {
		$fields = array();
		if (isset($update->group)) {
			if (strlen($update->group)) {
				$fields['group'] = $update->group;
			} else {
				$fields['group'] = null;
			}
		}
		if (isset($update->time)) {
			if (strlen($update->time)) {
				$fields['schedule'] = $update->time;
			} else {
				$fields['schedule'] = null;
			}
		}

		$filter = array();
		if (isset($from->year)) {
			$filter['year'] = $from->year;
		}
		if (isset($from->semester)) {
			$filter['semester'] = $from->semester;
		}
		if (isset($from->id)) {
			$filter['id'] = $from->id;
		}
		if (isset($from->group)) {
			$filter['group'] = $from->group;
		}
		if (isset($from->discipline)) {
			$filter['discipline'] = $from->discipline;
		}

		$list = $this->DAO->update($fields, $filter);

		return $list[0];
	}

	public function updateTimeFrom($time, $from) {
		$update = new stdClass();
		$update->time = $time;

		$filter = array();
		if (isset($from->year)) {
			$filter['year'] = $from->year;
		}
		if (isset($from->semester)) {
			$filter['semester'] = $from->semester;
		}
		if (isset($from->group)) {
			$filter['group'] = $from->group;
		}
		if (isset($from->discipline)) {
			$filter['discipline'] = $from->discipline;
		}

		$mClass = $this->DAO->filter($filter, null, 0, 1);
		$mClass = $mClass[0];

		$times = array();
		$selected = explode("-", $mClass->schedule);
		foreach ($selected as $mTime) {
			if (strlen($mTime)) {
				$times[$mTime] = $mTime;
			}
		}

		if (isset($times[$time])) {
			unset($times[$time]);
		} else {
			$times[$time] = $time;
		}
		sort($times);
		$update->time = implode("-", $times);

		$this->update($update, $from);
	}

	public function delete($from) {
		$filter = array();
		$filter['year'] = $from->year;
		$filter['semester'] = $from->semester;

		if (isset($from->discipline)) {
			$filter['discipline'] = $from->discipline;
		}
		if (isset($from->id)) {
			$filter['id'] = $from->id;
		}

		$this->DAO->delete($filter);
	}

	public function updateBasedOnTemporaryOfferList($offerList, $semester, $disciplineID) {
		$groups = $this->fromSemesterAndDisciplineClassKey($semester, $disciplineID);

		$classAdd = array();
		foreach ($offerList as $class) {
			if (isset($groups[$class->class])) {
				unset($groups[$class->class]);
			} else {
				$classAdd[] = $class;
			}
		}

//		p("###################################################\nDELETAR:");
//		p($groups);
//
//		p("###################################################\nADICIONAR:");
//		p($classAdd);

		foreach ($groups as $group) {
			$this->delete($group);
		}

		foreach ($classAdd as $class) {
			$insert = new stdClass();
			$insert->group = null;
			$insert->discipline = $class->discipline;
			$insert->class = $class->class;
			$insert->schedule = null;
			$insert->semester = $semester->semester;
			$insert->year = $semester->year;

			$this->insert($insert);
		}
	}

    /**
     * @param SemesterTO $semesterOld
     * @param SemesterTO $semesterNew
     * @throws Exception
     */
    public function cloneFromSemesterToSemester($semesterOld, $semesterNew) {
        $theoryGroups = $this->fromSemester($semesterOld);

        foreach ($theoryGroups as $group) {
            $group->year = $semesterNew->year;
            $group->semester = $semesterNew->semester;

            $this->insert($group);
        }
    }

	public function lastGroup($semester, $discipline) {
		$filter['year'] = $semester->year;
		$filter['semester'] = $semester->semester;
		$filter['discipline'] = $discipline;

		$order['group'] = DAO::ORDER_DESCENDANT;

		$list = $this->DAO->filterGroupIsNotNull($filter, $order, 0, 1);

		if (count($list)) {
			return $list[0]->group;
		}
		return 0;
	}
	
	
	public function timesOfGroup($semester, $discipline, $group) {
		$filter['year'] = $semester->year;
		$filter['semester'] = $semester->semester;
		$filter['discipline'] = $discipline;
		$filter['group'] = $group;

		$list = $this->DAO->filter($filter);

		$possibleTimes = array();
		$timeTogether = array();

		$selected = explode("-", $list[0]->schedule);
		foreach ($selected as $time) {
			if (strlen($time)) {
				$timeTogether[$time] = $time;
			}
		}

		foreach ($list as $theoryGroupClass) {
			$schedule = explode("-", $theoryGroupClass->class_schedule);

			foreach ($schedule as $time) {
				if (!isset($possibleTimes[$time])) {
					$possibleTimes[$time] = 0;
				}
				$possibleTimes[$time] += 1;
			}

			$selected = explode("-", $theoryGroupClass->schedule);
			foreach ($selected as $time) {
				if (strlen($time) && !isset($timeTogether[$time])) {
					unset($timeTogether[$time]);
				}
			}
		}

		sort($timeTogether);
		$return = new stdClass();
		$return->selected = $timeTogether;
		$return->group = $group;
		$return->schedule = array();

		foreach ($possibleTimes as $time => $quantity) {
			if ($quantity == count($list)) {

				$return->schedule[] = $time;
			}
		}

		return $return;
	}
}