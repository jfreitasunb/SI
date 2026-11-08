<?php

require_once $ROOT_PATH.'model/dao.php';


class OfferListTemporaryDAO extends DAO {
	private $attributeMapDiscipline;
	private $disciplineTable;

	private $attributeMapProfessor;
	private $professorTable;

	function __construct() {
		parent::__construct();

		$this->attributeMap["id"] = "lol_clol";
		$this->attributeMap["discipline"] = "lol_cdis";
		$this->attributeMap["professor"] = "lol_coduser";
		$this->attributeMap["class"] = "lol_clas";
		$this->attributeMap["period"] = "lol_peri";
		$this->attributeMap["schedule"] = "lol_sche";
		$this->attributeMap["year"] = "lol_year";
		$this->attributeMap["semester"] = "lol_seme";
		$this->attributeMap["status"] = "lol_stat";
		$this->attributeMap["classroom"] = "lol_croo";

		$this->attributeMapDiscipline = $this->attributeMap;
		$this->attributeMapDiscipline["discipline_id"] = "codigo";
		$this->attributeMapDiscipline["discipline_name"] = "nome";
		$this->attributeMapDiscipline["discipline_credits"] = "creditos";
		$this->attributeMapDiscipline["discipline_type"] = "status";

		$this->attributeMapProfessor = $this->attributeMapDiscipline;
		$this->attributeMapProfessor["professor_id"] = "coduser";
		$this->attributeMapProfessor["professor_name"] = "name";
		$this->attributeMapProfessor["professor_last_name"] = "firstname";

		$this->table = "lo_offer_list_temporary";
		$this->disciplineTable = "disciplinas_mat";
		$this->professorTable = "users";
	}

	public function filterWithDiscipline($filter, $order = null, $offset = null, $limit = null) {
		$where = $this->whereFromFilter($filter, $this->attributeMapDiscipline);

		$order = $this->orderBy($order, $this->attributeMapDiscipline);

		if(strlen($limit) > 0)
			$limit = "LIMIT $limit";

		if(strlen($offset) > 0)
			$offset = "OFFSET $offset";

		$sql = "SELECT ".$this->attributesSelect($this->attributeMapDiscipline)."
			FROM $this->table INNER JOIN $this->disciplineTable ON ".$this->attributeMapDiscipline['discipline_id']." = ".$this->attributeMapDiscipline['discipline']."
		$where $order $limit $offset";

        $res = $this->_db->prepare($sql);

        $res->execute();


		$list = $res->fetchAll(PDO::FETCH_OBJ);

		return $list;
	}

	public function filterWithDisciplineAndProfessor($filter, $order = null, $offset = null, $limit = null) {
		$where = $this->whereFromFilter($filter, $this->attributeMapProfessor);

		$order = $this->orderBy($order, $this->attributeMapProfessor);

		if(strlen($limit) > 0)
			$limit = "LIMIT $limit";

		if(strlen($offset) > 0)
			$offset = "OFFSET $offset";

		$sql = "SELECT ".$this->attributesSelect($this->attributeMapProfessor)."
			FROM (($this->table
			INNER JOIN $this->disciplineTable ON ".$this->attributeMapProfessor['discipline_id']." = ".$this->attributeMapProfessor['discipline'].")
			 LEFT JOIN $this->professorTable  ON  ".$this->attributeMapProfessor['professor_id']." = ".$this->attributeMapProfessor['professor'].")
		$where $order $limit $offset";

        $res = $this->_db->prepare($sql);

        $res->execute();


		$list = $res->fetchAll(PDO::FETCH_OBJ);

		return $list;
	}

	public function filterDistinctDiscipline($filter, $order = null, $offset = null, $limit = null) {
		//$att["id"] = $this->attributeMapDiscipline["id"];
		$att["discipline"] = $this->attributeMapDiscipline["discipline"];
		$att["period"] = $this->attributeMapDiscipline["period"];
		$att["year"] = $this->attributeMapDiscipline["year"];
		$att["semester"] = $this->attributeMapDiscipline["semester"];
		$att["discipline_id"] = $this->attributeMapDiscipline["discipline_id"];
		$att["discipline_name"] = $this->attributeMapDiscipline["discipline_name"];
		$att["discipline_credits"] = $this->attributeMapDiscipline["discipline_credits"];
		$att["status"] = $this->attributeMapDiscipline["status"];
		$att["quantity"] = "count(*)";

		$where = $this->whereFromFilter($filter, $att);

		$order = $this->orderBy($order, $att);

		if(strlen($limit) > 0)
			$limit = "LIMIT $limit";

		if(strlen($offset) > 0)
			$offset = "OFFSET $offset";

		$sql = "SELECT ".$this->attributesSelect($att)."
			FROM $this->table INNER JOIN $this->disciplineTable ON ".$att['discipline_id']." = ".$att['discipline']."
		$where
		GROUP BY ".$att["discipline"].", ".$att["period"].", ".$att["year"].", ".$att["semester"].", ".
			$att["discipline_id"].", ".$att["discipline_name"].", ".$att["discipline_credits"].", ".$att["status"]."
		$order $limit $offset";

		$res = $this->_db->prepare($sql);

        $res->execute();


		$list = $res->fetchAll(PDO::FETCH_OBJ);

		return $list;
	}

	public function numberOfCredits($filter) {
		$where = $this->whereFromFilter($filter, $this->attributeMapDiscipline);

		$sql = "SELECT sum(".$this->attributeMapDiscipline['discipline_credits'].") as credits
			FROM $this->table INNER JOIN $this->disciplineTable ON ".$this->attributeMapDiscipline['discipline_id']." = ".$this->attributeMapDiscipline['discipline']."
			$where";

        $res = $this->_db->prepare($sql);

        $res->execute();


		$list = $res->fetchAll(PDO::FETCH_OBJ);

		return $list;
	}
}
