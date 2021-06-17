<?php

require_once $ROOT_PATH.'model/dao11.php';
require_once $ROOT_PATH.'model/tableItemDAO.php';

class CourseBO {
	/**
	 * @var int
	 */
	public $id;

	/**
	 * @var string
	 */
	var $name;

	/**
	 * @var string
	 */
	var $credits;

	/**
	 * @var string
	 */
	var $type_key;

	/**
	 * @var string
	 */
	var $type;
}

class CourseDAO extends DAO1x1 {

	const GRADUATION = "grad";
	const POSTGRADUATE = "pgrad";

	private $attributeMapType;

	/**
	 * CourseDAO constructor.
	 */
	function __construct() {
		parent::__construct();

		$this->attributeMap["id"] = "cod" . "igo";
		$this->attributeMap["name"] = "nome";
		$this->attributeMap["credits"] = "credit" . "os";
		$this->attributeMap["type_key"] = "status";

		$this->attributeMapType = $this->attributeMap;

		$this->attributeMapType["type"] = "lti_v" . "alu";

		$this->table = "dis" . "cip" . "li" . "nas_mat";
	}

	/**
	 * @param array[string] $filter
	 * @param array[string] $order or null
	 * @param int $offset or null
	 * @param int $limit or null
	 * @return array[CourseBO]
	 * @throws Exception
	 */
	public function filter($filter, $order = null, $offset = null, $limit = null) {
		return parent::filter($filter, $order, $offset, $limit);
	}


	/**
	 * @param array[string] $filter
	 * @param array[string] $order or null
	 * @param array[string] $offset or null
	 * @param array[string] $limit or null
	 * @return array[CourseBO]
	 * @throws Exception
	 */
	public function filterWithType($filter, $order = null, $offset = null, $limit = null) {
		$filter['lti_c' . 'lta'] = TableItemDAO::COURSE_TYPE;

		$where = $this->whereFromFilter($filter, $this->attributeMapType);

		$order = & $this->orderBy($order, $this->attributeMapType);

		if(strlen($limit) > 0)
			$limit = "LIMIT $limit";

		if(strlen($offset) > 0)
			$offset = "OFFSET $offset";

		$sql = "SELECT ".$this->attributesSelect($this->attributeMapType)."
				FROM ($this->table
					 INNER JOIN lo_table_item ON lti_s" . "val = status)
				$where
				$order
				$limit
				$offset";

		$res = & $this->_db->query($sql);

		if($this->_db->isError($res)) {
			print_r($res);
			throw new Exception("Error: $sql");
		}

		$list = & $res->fetchAll(MDB2_FETCHMODE_OBJECT);

		return $list;
	}
}