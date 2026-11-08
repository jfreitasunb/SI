<?php

require_once $ROOT_PATH.'model/dao.php';

class GrantedCreditsBO {
    /**
     * @var int
     */
    public $id;

	/**
	 * @var int
	 */
	var $teacher;

	/**
	 * @var int
	 */
	var $activity;

	/**
	 * @var int
	 */
	public $year;

	/**
	 * @var int
	 */
	public $semester;

	/**
	 * @var int
	 */
	var $credits;

	/**
	 * @var string
	 */
	var $teacher_name;

	/**
	 * @var string
	 */
	var $teacher_last_name;

    /**
     * @var string
     */
    var $activity_description;

	/**
	 * @var int
	 */
	var $group_id;

    /**
     * @var string
     */
    var $group;
}

class GrantedCreditsDAO extends DAO {

	const ACTIVITY_POST_CLASS = 1;
	const ACTIVITY_POST_ORIENTATION_MASTERS = 2;
	const ACTIVITY_POST_ORIENTATION_PHD = 3;
	const ACTIVITY_PUBLICATIONS = 25;

	private $attributeMapJoined;

	/**
	 * ActivitiesDAO constructor.
	 */
	function __construct() {
		parent::__construct();

		$this->attributeMap["id"] = "lgc_c" . "lgc";
		$this->attributeMap["teacher"] = "lgc_cod" . "user";
		$this->attributeMap["activity"] = "lgc_c" . "lac";
		$this->attributeMap["year"] = "lgc_year";
		$this->attributeMap["semester"] = "lgc_s" . "eme";
		$this->attributeMap["credits"] = "lgc_cred";
		$this->attributeMap["status"] = "lgc_stat";
		$this->attributeMap["extra"] = "lgc_extr";

		$this->attributeMapJoined = $this->attributeMap;

		$this->attributeMapJoined["teacher_name"] = "name";
		$this->attributeMapJoined["teacher_last_name"] = "firstname";
		$this->attributeMapJoined["activity_id"] = "lac_clac";
		$this->attributeMapJoined["activity_description"] = "lac_desc";
		$this->attributeMapJoined["group_type"] = "lti_clta";
		$this->attributeMapJoined["group_id"] = "lti_sval";
		$this->attributeMapJoined["group_description"] = "lti_valu";
		$this->attributeMapJoined["discipline_name"] = "nome";
		$this->attributeMapJoined["discipline_credits"] = "creditos";

		$this->table = "lo_granted_credits";
	}


	/**
	 * @param array[string] $filter
	 * @param array[string] $order or null
	 * @param array[string] $offset or null
	 * @param array[string] $limit or null
	 * @return array[GrantedCreditsBO]
	 * @throws Exception
	 */
	public function filterWithUserActivityGroup($filter, $order = null, $offset = null, $limit = null) {
		$where = $this->whereFromFilter($filter, $this->attributeMapJoined);

		$order = $this->orderBy($order, $this->attributeMapJoined);

		if(strlen($limit) > 0)
			$limit = "LIMIT $limit";

		if(strlen($offset) > 0)
			$offset = "OFFSET $offset";

		$sql = "SELECT ".$this->attributesSelect($this->attributeMapJoined)."
				FROM (((($this->table
					 INNER JOIN users AS U           ON coduser  = lgc_coduser)
					 INNER JOIN lo_activities        ON lac_clac = lgc_clac)
					 INNER JOIN lo_table_item        ON lti_sval = lac_grou)
					 LEFT  JOIN disciplinas_mat AS D ON lac_clac = ".GrantedCreditsDAO::ACTIVITY_POST_CLASS." AND D.codigo::varchar = lgc_extr)
				$where
				$order
				$limit
				$offset";

		$res = $this->_db->prepare($sql);

        $res->execute();


		$list = $res->fetchAll(PDO::FETCH_OBJ);

		return $list;
	}


	/**
	 * @param array[string] $filter
	 * @param integer $minCredits
	 * @param array[string] $order or null
	 * @param array[string] $offset or null
	 * @param array[string] $limit or null
	 * @return array[GrantedCreditsBO]
	 * @throws Exception
	 */
	public function filterWithMinCredits($filter, $minCredits, $order = null, $offset = null, $limit = null) {
		$where = $this->whereFromFilter($filter, $this->attributeMapJoined);

		$order = $this->orderBy($order, $this->attributeMapJoined);

		if(strlen($limit) > 0)
			$limit = "LIMIT $limit";

		if(strlen($offset) > 0)
			$offset = "OFFSET $offset";

        $minCredits = 10;
		$sql = "SELECT ".$this->attributesSelect($this->attributeMapJoined)."
				FROM (((($this->table
					 INNER JOIN users AS U           ON coduser  = lgc_coduser)
					 INNER JOIN lo_activities        ON lac_clac = lgc_clac)
					 INNER JOIN lo_table_item        ON lti_sval = lac_grou)
					 LEFT  JOIN disciplinas_mat AS D ON lac_clac = ".GrantedCreditsDAO::ACTIVITY_POST_CLASS." AND D.codigo::varchar = lgc_extr)
				$where AND ".$this->attributeMap['credits']." > $minCredits
				$order
				$limit
				$offset";

		$res = $this->_db->prepare($sql);

        $res->execute();


		$list = $res->fetchAll(PDO::FETCH_OBJ);

		return $list;
	}

	/**
	 * @param array[string] $filter
	 * @return array[integer]
	 * @throws Exception
	 */
	public function numberOfCredits($filter) {
		$where = $this->whereFromFilter($filter);

		$sql = "SELECT sum(".$this->attributeMap['credits'].") as credits
			FROM $this->table
			$where";

		$res = $this->_db->prepare($sql);

        $res->execute();


		$list = $res->fetchAll(PDO::FETCH_OBJ);

		return $list;
	}
}
