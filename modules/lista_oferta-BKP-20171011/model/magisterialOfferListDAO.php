<?php

require_once $ROOT_PATH.'model/dao.php';


class MagisterialOfferListDAO extends DAO {

	function __construct() {
		parent::__construct();
		$this->attributeMap["id"] = "lom_clom";
		$this->attributeMap["discipline"] = "lom_cdis";
		$this->attributeMap["professor"] = "lom_coduser";
		$this->attributeMap["class"] = "lom_clas";
		$this->attributeMap["schedule"] = "lom_sche";
		$this->attributeMap["period"] = "lom_peri";
		$this->attributeMap["year"] = "lom_year";
		$this->attributeMap["semester"] = "lom_seme";
		$this->attributeMap["type"] = "lom_type";

		$this->attributeMap["discipline_id"] = "codigo";
		$this->attributeMap["discipline_name"] = "nome";
		$this->attributeMap["discipline_credits"] = "creditos";
		$this->attributeMap["discipline_type"] = "status";

		$this->table = "lo_offer_list_magisterial";
	}


	/**
	 * @param array[string] $filter
	 * @param array[string] $order or null
	 * @param int $offset or null
	 * @param int $limit or null
	 * @return array[stdClass]
	 * @throws Exception
	 */
	public function filter($filter, $order = null, $offset = null, $limit = null) {
		$where = $this->whereFromFilter($filter);

		$order = & $this->orderBy($order);

		if(strlen($limit) > 0)
			$limit = "LIMIT $limit";

		if(strlen($offset) > 0)
			$offset = "OFFSET $offset";

		$sql = "SELECT ".$this->attributesSelect()." 
		FROM $this->table
			INNER JOIN disciplinas_mat ON ".$this->attributeMap['discipline_id']." = ".$this->attributeMap['discipline']."
		$where $order $limit $offset";

		$res = & $this->_db->query($sql);

		if($this->_db->isError($res)) {
			print_r($res);
			throw new Exception("Select error: $sql");
		}

		$list = & $res->fetchAll(MDB2_FETCHMODE_OBJECT);

		return $list;
	}
}