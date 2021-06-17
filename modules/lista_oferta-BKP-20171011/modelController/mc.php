<?php

class MC {
	/**
	 * @var DAO
	 */
	protected $DAO;

	/**
	 * @param string $id
	 * @return mixed
	 */
	public function get($id) {
		$return = null;
		if(strlen($id) > 0) {
			$filter["id"] = $id;

			$list_obj = & $this->DAO->filter($filter);

			if(count($list_obj)) {
				$return = & $list_obj[0];
			}
		}
		return $return;
	}

	public function insertUpdate($value) {
		if (isset($value->id) && strlen($value->id) > 0) {
			$filter['id'] = $value->id;
			$this->DAO->update($value, $filter);
			return DAO::UPDATED;
		} else {
			$this->DAO->insert($value);
			return DAO::INSERTED;
		}
	}
}