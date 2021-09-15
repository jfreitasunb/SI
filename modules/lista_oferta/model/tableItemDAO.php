<?php

require_once $ROOT_PATH.'model/dao.php';


class TableItemDAO extends DAO {
	const PERIOD = '1';
	const COURSE_TYPE = '2';
	const ACTIVITY_GRADUATION = '4';
	const ACTIVITY_POSTGRADUATE = '5';

	function __construct() {
		parent::__construct();

		$this->attributeMap["id"] = "lti_c" . "lti";
		$this->attributeMap["table"] = "lti_c" . "lta";
		$this->attributeMap["value"] = "lti_v" . "alu";
		$this->attributeMap["short_value"] = "lti_s" . "val";

		$this->table = "lo_table_item";
	}


	/**
	 * @return array[stdClass]
	 * @throws Exception
	 */
	public function getListAllGroupActivities() {
		$sql = "SELECT ".$this->attributesSelect().",
					lta_desc || ' - ' || lti_v" . "alu AS long_value
				FROM $this->table 
					INNER JOIN lo_table ON lta_c" . "lta = lti_c" . "lta
				WHERE lti_c" . "lta = 4 OR  lti_c" . "lta = 5
				ORDER BY lta_desc, lti_v" . "alu";

		$res = $this->_db->query($sql);

		if($this->_db->isError($res)) {
			print_r($res);
			throw new Exception("Select error: $sql");
		}

		$list = $res->fetchAll(MDB2_FETCHMODE_OBJECT);

		return $list;
	}
}