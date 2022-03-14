<?php

require_once $ROOT_PATH.'model/dao.php';


class DisciplinesDAO extends DAO {

	const GRADUATION = 'grad';
	const POSTGRADUATION = 'pgrad';

	private $attributeMapOLT;

	function __construct() {
		parent::__construct();

		$this->attributeMap["id"] = "codigo";
		$this->attributeMap["name"] = "nome";
		$this->attributeMap["credits"] = "creditos";
		$this->attributeMap["type"] = "status";

		$this->table = "disciplinas_mat";

		$this->attributeMapOLT = $this->attributeMap;
		$this->attributeMapOLT["year"] = "lol_year";
		$this->attributeMapOLT["semester"] = "lol_seme";
		$this->attributeMapOLT["status"] = "lol_stat";
	}



    public function oltFilter($filter, $order = null, $offset = null, $limit = null) {
		$where = $this->whereFromFilter($filter, $this->attributeMapOLT);

		$order = $this->orderBy($order, $this->attributeMapOLT);

		if(strlen($limit) > 0)
			$limit = "LIMIT $limit";

		if(strlen($offset) > 0)
			$offset = "OFFSET $offset";

		$sql = "SELECT DISTINCT ".$this->attributesSelect($this->attributeMapOLT)."
				FROM ($this->table
					 INNER JOIN lo_offer_list_temporary ON codigo = lol_cdis)
				$where $order $limit $offset";

		$res = $this->_db->query($sql);

		if($this->_db->errorInfo($res)) {
			print_r($res);
			throw new Exception("Select error: $sql");
		}

		$list = $res->fetchAll(MDB2_FETCHMODE_OBJECT);

		return $list;
	}

}
