<?php

require_once $ROOT_PATH.'model/dao.php';


class PreferredDisciplinesGraduationDAO extends DAO {

	function __construct() {
		parent::__construct();

		$this->attributeMap["id"] = "pdg_cpdg";
		$this->attributeMap["user_id"] = "pdg_coduser";
		$this->attributeMap["year"] = "pdg_year";
		$this->attributeMap["semester"] = "pdg_seme";
		$this->attributeMap["rank"] = "pdg_rank";
		$this->attributeMap["quantity"] = "pdg_quan";
		$this->attributeMap["type"] = "pdg_type";
		$this->attributeMap["period"] = "pdg_peri";

		//TODO Verificar qual vai ser a tabela pra isso aqui, e depois adicionar a Constraint FK na tabela
		$this->attributeMap["discipline"] = "pdg_disc";

		$this->table = "lo_preferred_disciplines_graduation";
	}
}