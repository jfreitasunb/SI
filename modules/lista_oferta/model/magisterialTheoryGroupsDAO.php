<?php

require_once $ROOT_PATH.'model/dao.php';


class MagisterialTheoryGroupsDAO extends DAO {

	private $oltTable;

	function __construct() {
		parent::__construct();
		$this->attributeMap["id"] = "id";
		$this->attributeMap["group"] = "grupo";
		$this->attributeMap["discipline"] = "codigo";
		$this->attributeMap["discipline_2"] = "codigo_1";
		$this->attributeMap["class"] = "turmas";
		$this->attributeMap["schedule"] = "horario";
		$this->attributeMap["semester"] = "semestre";
		$this->attributeMap["year"] = "ano";

		$this->attributeMap["class_schedule"] = "lol_sche";
		$this->attributeMap["class_period"] = "lol_peri";

		$this->table = "oferta_grupos_magistral_teoria";
		$this->oltTable = "lo_offer_list_temporary";
	}

	public function filter($filter, $order = null, $offset = null, $limit = null) {
		$where = $this->whereFromFilter($filter);

		$order = $this->orderBy($order);

		if(strlen($limit) > 0)
			$limit = "LIMIT $limit";

		if(strlen($offset) > 0)
			$offset = "OFFSET $offset";

		$sql = "SELECT ".$this->attributesSelect()."
				FROM $this->table
					 LEFT JOIN $this->oltTable ON lol_year = ano AND lol_seme = semestre AND turmas = lol_clas AND lol_cdis = codigo
				$where
				$order
				$limit
				$offset";


		$res = $this->_db->prepare($sql);

        $res->execute();

		if($this->_db->errorInfo($res)) {
			print_r($res);
			throw new Exception("Error: $sql");
		}

		$list = $res->fetchAll(PDO::FETCH_OBJ);

		return $list;
	}

	public function filterGroupIsNotNull($filter, $order = null, $offset = null, $limit = null) {
		$where = $this->whereFromFilter($filter);

		$order = $this->orderBy($order);

		if(strlen($limit) > 0)
			$limit = "LIMIT $limit";

		if(strlen($offset) > 0)
			$offset = "OFFSET $offset";

		$sql = "SELECT ".$this->attributesSelect()."
				FROM $this->table
					 LEFT JOIN $this->oltTable ON lol_year = ano AND lol_seme = semestre AND turmas = lol_clas AND lol_cdis = codigo
				$where AND grupo IS NOT NULL
				$order
				$limit
				$offset";

		$res = $this->_db->prepare($sql);

        $res->execute();

		if($this->_db->isError($res)) {
			print_r($res);
			throw new Exception("Error: $sql");
		}

		$list = $res->fetchAll(PDO::FETCH_OBJ);

		return $list;
	}
}
