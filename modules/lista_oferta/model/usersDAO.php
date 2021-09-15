<?php

require_once $ROOT_PATH.'model/dao.php';


class UserDAO extends DAO {
	const TYPE_PROFESSOR = 'professor';

	const SITUATION_ACTIVE = 'ativo';

	const CONTRACT_TYPE_EXCLUSIVE = 'dedicacao exclusiva           ';

	private $attributeMapProf;

	private $tableProf;

	private $tableFunc;

	function __construct() {
		parent::__construct();

		$this->attributeMap["id"] = "coduser";
		$this->attributeMap["name"] = "name";
		$this->attributeMap["last_name"] = "firstname";
		$this->attributeMap["type"] = "tipo_users";
		$this->attributeMap["active"] = "is_actif";

		$this->attributeMapProf = $this->attributeMap;
		$this->attributeMapProf["id"] = "U.".$this->attributeMapProf["id"];
		$this->attributeMapProf["professor"] = $this->attributeMapProf["id"];
		$this->attributeMapProf["situation"] = "situacao";
		$this->attributeMapProf["contract_type"] = "contract_type";

		$this->table = "users";
		$this->tableProf = "profs";
		$this->tableFunc = "fonctionnaire";
	}

	public function filter($filter, $order = null, $offset = null, $limit = null) {
		$where = $this->whereFromFilter($filter, $this->attributeMapProf);

		$order = $this->orderBy($order, $this->attributeMapProf);

		if(strlen($limit) > 0)
			$limit = "LIMIT $limit";

		if(strlen($offset) > 0)
			$offset = "OFFSET $offset";

		$sql = "SELECT ".$this->attributesSelect($this->attributeMapProf)."
				FROM (($this->table AS U
					 INNER JOIN $this->tableProf AS P ON P.coduser = U.coduser)
					 LEFT  JOIN $this->tableFunc AS F ON F.coduser = U.coduser)
				$where
				$order
				$limit
				$offset";

		$res = $this->_db->query($sql);

		if($this->_db->isError($res)) {
			print_r($res);
			throw new Exception("Error: $sql");
		}

		$list = $res->fetchAll(MDB2_FETCHMODE_OBJECT);

		return $list;
	}
}