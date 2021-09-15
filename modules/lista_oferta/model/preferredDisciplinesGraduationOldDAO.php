<?php

require_once $ROOT_PATH.'model/dao.php';


class PreferredDisciplinesGraduationOldDAO extends DAO {

	function __construct() {
		parent::__construct();

		$this->attributeMap["user_id"] = "coduser";
		$this->attributeMap["discipline"] = "disciplina";
		$this->attributeMap["rank"] = "prioridade";
		$this->attributeMap["period"] = "turno";
		$this->attributeMap["year"] = "ano";
		$this->attributeMap["semester"] = "semestre";

		$this->table = "oferta_escolha_disciplina";
	}
}