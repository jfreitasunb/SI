<?php

require_once $ROOT_PATH.'model/dao.php';


class MagisterialOfferListDAO extends DAO {
	private $attributeMapDiscipline;
	private $disciplineTable;

	private $attributeMapProfessor;
	private $professorTable;

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

		$this->attributeMapDiscipline = $this->attributeMap;
		$this->attributeMapDiscipline["discipline_id"] = "codigo";
		$this->attributeMapDiscipline["discipline_name"] = "nome";
		$this->attributeMapDiscipline["discipline_credits"] = "creditos";
		$this->attributeMapDiscipline["discipline_type"] = "status";

		$this->attributeMapProfessor = $this->attributeMapDiscipline;
		$this->attributeMapProfessor["professor_id"] = "coduser";
		$this->attributeMapProfessor["professor_name"] = "name";
		$this->attributeMapProfessor["professor_last_name"] = "firstname";

		$this->table = "lo_offer_list_magisterial";
		$this->disciplineTable = "disciplinas_mat";
		$this->professorTable = "users";
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
		$where = $this->whereFromFilter($filter, $this->attributeMapDiscipline);

		$order = $this->orderBy($order, $this->attributeMapDiscipline);

		if(strlen($limit) > 0)
			$limit = "LIMIT $limit";

		if(strlen($offset) > 0)
			$offset = "OFFSET $offset";

		$sql = "SELECT ".$this->attributesSelect($this->attributeMapDiscipline)."
		FROM $this->table
			INNER JOIN $this->disciplineTable ON ".$this->attributeMapDiscipline['discipline_id']." = ".$this->attributeMapDiscipline['discipline']."
		$where $order $limit $offset";

		$res = $this->_db->query($sql);

		if($this->_db->errorInfo($res)) {
			print_r($res);
			throw new Exception("Select error: $sql");
		}

		$list = $res->fetchAll(MDB2_FETCHMODE_OBJECT);

		return $list;
	}


	/**
	 * @param array[string] $filter
	 * @param array[string] $order or null
	 * @param int $offset or null
	 * @param int $limit or null
	 * @return array[stdClass]
	 * @throws Exception
	 */
	public function filterWithProfessor($filter, $order = null, $offset = null, $limit = null) {
		$where = $this->whereFromFilter($filter, $this->attributeMapProfessor);

		$order = $this->orderBy($order, $this->attributeMapProfessor);

		if(strlen($limit) > 0)
			$limit = "LIMIT $limit";

		if(strlen($offset) > 0)
			$offset = "OFFSET $offset";

		$sql = "SELECT ".$this->attributesSelect($this->attributeMapProfessor)."
		FROM (($this->table
			INNER JOIN $this->disciplineTable ON ".$this->attributeMapProfessor['discipline_id']." = ".$this->attributeMapProfessor['discipline'].")
			 LEFT JOIN $this->professorTable  ON ".$this->attributeMapProfessor['professor_id']."  = ".$this->attributeMapProfessor['professor'].")
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
