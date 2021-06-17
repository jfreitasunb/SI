<?php

require_once $ROOT_PATH.'model/dao.php';

class CreditsSemesterUserBO {
	/**
	 * @var string
	 */
	public $id;

    /**
     * @var string
     */
    public $user_id;

    /**
     * @var string
     */
    public $year;

    /**
     * @var string
     */
    public $semester;

    /**
     * @var string
     */
    public $credits;

    /**
     * @var string
     */
    public $user_name;

    /**
     * @var string
     */
    public $user_last_name;

    /**
     * @var string
     */
    public $user_type;
}

class CreditsSemesterDAO extends DAO {

	private $attributeMapUser;

	/**
	 * CreditsSemesterDAO constructor.
     */
	function __construct() {
		parent::__construct();

		$this->attributeMap["id"] = "lcs" . "_c" . "lcs";
		$this->attributeMap["user_id"] = "lcs_cod" . "user";
		$this->attributeMap["year"] = "lcs_year";
		$this->attributeMap["semester"] = "lcs_s" . "eme";
		$this->attributeMap["credits"] = "lcs_cred";

		$this->attributeMapUser = $this->attributeMap;

		$this->attributeMapUser["user_name"] = "name";
		$this->attributeMapUser["user_last_name"] = "first" . "name";
		$this->attributeMapUser["user_type"] = "tip" . "o_users";

		$this->table = "lo_credits_semester";
	}


	/**
	 * @param array[string] $filter
	 * @param array[string] $order or null
	 * @param array[string] $offset or null
	 * @param array[string] $limit or null
	 * @return array[CreditsSemesterUserBO]
	 * @throws Exception
     */
	public function filterWithUser($filter, $order = null, $offset = null, $limit = null) {
		$where = $this->whereFromFilter($filter, $this->attributeMapUser);

		$order = & $this->orderBy($order, $this->attributeMapUser);

		if(strlen($limit) > 0)
			$limit = "LIMIT $limit";

		if(strlen($offset) > 0)
			$offset = "OFFSET $offset";

		$sql = "SELECT ".$this->attributesSelect($this->attributeMapUser)."
				FROM ($this->table
					 INNER JOIN users ON coduser = lcs_coduser)
				$where
				$order
				$limit
				$offset";

		$res = & $this->_db->query($sql);

		if($this->_db->isError($res)) {
			print_r($res);
			throw new Exception("Erro: $sql");
		}

		$list = & $res->fetchAll(MDB2_FETCHMODE_OBJECT);

		return $list;
	}
}