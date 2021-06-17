<?php

require_once $ROOT_PATH.'modelController/mc.php';
require_once $ROOT_PATH.'model/activitiesDAO.php';


class ActivitiesMC extends MC
{
	/**
	 * ActivitiesMC constructor.
	 */
	function __construct()
	{
		$this->DAO = & new ActivitiesDAO();
	}

	/**
	 * @param string $group
	 * @return array[ActivitiesBO]
	 * @throws Exception
	 */
	public function listByGroup($group)
	{
		$filter['group_key'] = $group;
		$filter['status'] = DAO::ACTIVE;

		$list = & $this->DAO->filter($filter);

		if (count($list)) {
			return $list;
		}
		return array();
	}

	/**
	 * @param boolean $status
	 * @return array[ActivitiesBO]
	 * @throws Exception
	 */
	public function listComplete($status = true)
	{
		$filter = array();
		if ($status !== null) {
			if ($status == true) {
				$filter['status'] = DAO::ACTIVE;
			} else {
				$filter['status'] = DAO::INACTIVE;
			}
		}

		$order['description'] = DAO::ORDER_DESCENDANT;

		$list = & $this->DAO->filterWithGroup($filter, $order);

		if (count($list)) {
			return $list;
		}
		return array();
	}

	/**
	 * @param string $id
	 * @return mixed
	 */
	public function getComplete($id) {
		$return = null;
		if(strlen($id) > 0) {
			$filter["id"] = $id;

			$list_obj = & $this->DAO->filterWithGroup($filter);

			if(count($list_obj)) {
				$return = & $list_obj[0];
			}
		}
		return $return;
	}

	/**
	 * @param string $group
	 * @param SemesterTO $semester
	 * @return array [ActivitiesBO]
	 * @throws Exception
	 */
	public function listByGroupAvailable($semester, $group)
	{
		$filter['group_key'] = $group;
		$filter['status'] = DAO::ACTIVE;

		$list = & $this->DAO->filterAvailable($semester, $filter);

		if (count($list)) {
			return $list;
		}
		return array();
	}
}