<?php

require_once $ROOT_PATH.'model/dao.php';


class StudentDAO extends DAO {
	const TYPE_STUDENT = 'student';

	const SITUATION_ACTIVE = 'ativo';

	const MASTERS_STUDENT = 'mestrado';
	const PHD_STUDENT = 'doutorado';

	private $attributeMapProf;

	function __construct() {
		parent::__construct();

		$this->attributeMap["id"] = "coduser";
		$this->attributeMap["name"] = "name";
		$this->attributeMap["last_name"] = "firstname";
		$this->attributeMap["type"] = "tipo_users";
		$this->attributeMap["active"] = "is_actif";

		$this->attributeMapProf = $this->attributeMap;
		$this->attributeMapProf["id"] = "U.".$this->attributeMapProf["id"];
		$this->attributeMapProf["situation"] = "status";
		$this->attributeMapProf["level"] = "formation";

		$this->table = "users";
	}

	public function filter($filter, $order = null, $offset = null, $limit = null) {
		$where = $this->whereFromFilter($filter, $this->attributeMapProf);

		$order = $this->orderBy($order, $this->attributeMapProf);

		if(strlen($limit) > 0)
			$limit = "LIMIT $limit";

		if(strlen($offset) > 0)
			$offset = "OFFSET $offset";

		$sql = "SELECT ".$this->attributesSelect($this->attributeMapProf)."
				FROM ($this->table AS U
					 INNER JOIN student AS S ON S.coduser = U.coduser)
				$where
				$order
				$limit
				$offset";

        $res = $this->_db->prepare($sql);

        $res->execute();

		//if($this->_db->isError($res)) {
		//	print_r($res);
		//	throw new Exception("Error: $sql");
		//}

		$list = $res->fetchAll(PDO::FETCH_OBJ);

		return $list;
	}
}
