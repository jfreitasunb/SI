<?php

require_once $ROOT_PATH.'model/dao.php';


class ProfessorDAO extends DAO {
	const TYPE_PROFESSOR = 'professor';

	const SITUATION_ACTIVE = 'ativo';

	const CONTRACT_TYPE_EXCLUSIVE       = 'dedicacao exclusiva           ';
	const CONTRACT_TYPE_SUBSTITUTE_MS20 = 'substituto ms20               ';
	const CONTRACT_TYPE_SUBSTITUTE_MS40 = 'substituto ms40               ';
	const CONTRACT_TYPE_SUBSTITUTE_GR40 = 'substituto gr40               ';
	const CONTRACT_TYPE_SUBSTITUTE_DR40 = 'substituto dr40               ';

	private $attributeMapExtended;

	private $tableUser;

	private $tableProf;

	private $tableFunc;

	function __construct() {
		parent::__construct();

		$this->attributeMap["id"] = "lap_clap";
		$this->attributeMap["professor"] = "lap_coduser";
		$this->attributeMap["year"] = "lap_year";
		$this->attributeMap["semester"] = "lap_seme";
		$this->attributeMap["status"] = "lap_stat";

		$this->attributeMapExtended = $this->attributeMap;
		$this->attributeMapExtended["name"] = "name";
		$this->attributeMapExtended["id"] = "lap_coduser";
		$this->attributeMapExtended["last_name"] = "firstname";
		$this->attributeMapExtended["type"] = "tipo_users";
		$this->attributeMapExtended["active"] = "is_actif";

		$this->attributeMapExtended["situation"] = "situacao";

		$this->attributeMapExtended["contract_type"] = "contract_type";


		$this->table = "lo_active_professors";
		$this->tableUser = "users";
		$this->tableProf = "profs";
		$this->tableFunc = "fonctionnaire";
	}

	public function filter($filter, $order = null, $offset = null, $limit = null) {
		$where = $this->whereFromFilter($filter, $this->attributeMapExtended);

		$order = $this->orderBy($order, $this->attributeMapExtended);

		if(strlen($limit) > 0)
			$limit = "LIMIT $limit";

		if(strlen($offset) > 0)
			$offset = "OFFSET $offset";

		$sql = "SELECT ".$this->attributesSelect($this->attributeMapExtended)."
				FROM ((($this->table AS A
					 INNER JOIN $this->tableUser AS U ON U.coduser = A.lap_coduser)
					 INNER JOIN $this->tableProf AS P ON P.coduser = A.lap_coduser)
					 LEFT  JOIN $this->tableFunc AS F ON F.coduser = A.lap_coduser)
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
}
