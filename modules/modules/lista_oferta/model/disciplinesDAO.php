<?php

require_once $ROOT_PATH.'model/dao.php';


class DisciplinesDAO extends DAO {

	function __construct() {
		parent::__construct();

		$this->attributeMap["id"] = "codigo";
		$this->attributeMap["name"] = "nome";
		$this->attributeMap["credits"] = "creditos";
		$this->attributeMap["type"] = "status";

		$this->table = "disciplinas_mat";
	}
}