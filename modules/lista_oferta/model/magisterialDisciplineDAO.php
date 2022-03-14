<?php

require_once $ROOT_PATH.'model/dao.php';


class MagisterialDisciplineDAO extends DAO {

	const THEORY = 'T';
	const EXERCISE = 'E';

	private $attributeMapDisciplinesDescription;

	private $tableDiscipline;

	function __construct() {
		parent::__construct();

		$this->attributeMap["id"] = "id";
		$this->attributeMap["discipline"] = "codigo";
		$this->attributeMap["theory_quantity"] = "teoria";
		$this->attributeMap["exercises_quantity"] = "exercicios";
		$this->attributeMap["semester"] = "semestre";
		$this->attributeMap["year"] = "ano";

		$this->attributeMapDisciplinesDescription = $this->attributeMap;
		$this->attributeMapDisciplinesDescription["name"] = "nome";
		$this->attributeMapDisciplinesDescription["discipline"] = "DM.codigo";
		$this->attributeMapDisciplinesDescription["credits"] = "creditos";

		$this->table = "oferta_disciplinas_magistral";
		$this->tableDiscipline = "disciplinas_mat";
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
		$where = $this->whereFromFilter($filter, $this->attributeMapDisciplinesDescription);

		$order = $this->orderBy($order, $this->attributeMapDisciplinesDescription);

		if(strlen($limit) > 0)
			$limit = "LIMIT $limit";

		if(strlen($offset) > 0)
			$offset = "OFFSET $offset";

		$sql = "SELECT ".$this->attributesSelect($this->attributeMapDisciplinesDescription)."
				FROM ($this->table AS DM
					 INNER JOIN $this->tableDiscipline AS D ON D.codigo = DM.codigo)
				$where
				$order
				$limit
				$offset";

		$res = $this->_db->query($sql);

		if($this->_db->errorInfo($res)) {
			print_r($res);
			throw new Exception("Select error: $sql");
		}

		$list = $res->fetchAll(MDB2_FETCHMODE_OBJECT);

		return $list;
	}
}
