<?php

require_once $ROOT_PATH.'model/dao.php';

class ActivitiesBO {
    /**
     * @var int
     */
    public $id;

	/**
	 * @var int
	 */
	var $group_key;

    /**
     * @var string
     */
    var $description;

	/**
	 * @var int
	 */
	var $maximum;

	/**
	 * @var int
	 */
	var $credits;

    /**
     * @var string
     */
    var $status;

    /**
     * @var string
     */
    var $group;
}

class ActivitiesDAO extends DAO {

	private $attributeMapGroup;

	/**
	 * ActivitiesDAO constructor.
	 */
	function __construct() {
		parent::__construct();

		$this->attributeMap["id"] = "lac_c" . "lac";
		$this->attributeMap["group_key"] = "lac_g" . "rou";
		$this->attributeMap["description"] = "lac_desc";
		$this->attributeMap["credits"] = "lac_cred";
		$this->attributeMap["maximum"] = "lac_maxi";
		$this->attributeMap["status"] = "lac_stat";

		$this->attributeMapGroup = $this->attributeMap;

		$this->attributeMapGroup["group"] = "lti_v" . "alu";
		$this->attributeMapGroup["responsible"] = "lta_desc";
		$this->attributeMapGroup["responsible_id"] = "lta_c" . "lta";


		$this->table = "lo_activities";
	}


	/**
	 * @param array[string] $filter
	 * @param array[string] $order or null
	 * @param array[string] $offset or null
	 * @param array[string] $limit or null
	 * @return array[ActivitiesBO]
	 * @throws Exception
	 */
	public function filterWithGroup($filter, $order = null, $offset = null, $limit = null) {
		$where = $this->whereFromFilter($filter, $this->attributeMapGroup);

		$order = $this->orderBy($order, $this->attributeMapGroup);

		if(strlen($limit) > 0)
			$limit = "LIMIT $limit";

		if(strlen($offset) > 0)
			$offset = "OFFSET $offset";

		$sql = "SELECT ".$this->attributesSelect($this->attributeMapGroup)."
				FROM ($this->table
					 INNER JOIN lo_table_item ON lti_s" . "val = lac_grou)
					 INNER JOIN lo_table      ON lta_c" . "lta = lti_c" . "lta
				$where
				$order
				$limit
				$offset";

		$res = $this->_db->query($sql);

		if($this->_db->errorInfo($res)) {
			print_r($res);
			throw new Exception("Error: $sql");
		}

		$list = $res->fetchAll(MDB2_FETCHMODE_OBJECT);

		return $list;
	}


	/**
	 * @param $semester
	 * @param array [string] $filter
	 * @param int $offset or null
	 * @param int $limit or null
	 * @return array [stdClass]
	 * @throws Exception
	 */
	public function filterAvailable($semester, $filter, $order = null, $offset = null, $limit = null) {
		$where = $this->whereFromFilter($filter);
		if (strlen($where) > 0) {
			$where .= " AND";
		} else {
			$where = "WHERE";
		}
		$where .= " (lac_maxi is null OR lac_maxi > amount)";

		$order = $this->orderBy($order);

		if(strlen($limit) > 0)
			$limit = "LIMIT $limit";

		if(strlen($offset) > 0)
			$offset = "OFFSET $offset";

		unset($this->attributeMap["id"]);

		$sql = "SELECT
					amount, T.lac_clac AS id, ".$this->attributesSelect()."
				FROM (
					SELECT
						COUNT(DISTINCT lgc_clgc) AS amount,
						lac_clac,
						lgc_year,
						lgc_seme
					FROM $this->table
						LEFT JOIN lo_granted_credits ON
							lac_clac = lgc_clac AND
							lgc_stat = 'active' AND
							lgc_year = $semester->year AND
							lgc_seme = $semester->semester
					GROUP BY lac_clac, lgc_year, lgc_seme) AS am INNER JOIN $this->table AS T ON T.lac_clac = am.lac_clac
				$where
				$order
				$limit
				$offset";

		$res = $this->_db->query($sql);

		if($this->_db->isError($res)) {
			print_r($res);
			throw new Exception("Select error: $sql");
		}

		$list = $res->fetchAll(MDB2_FETCHMODE_OBJECT);

		return $list;
	}
}
