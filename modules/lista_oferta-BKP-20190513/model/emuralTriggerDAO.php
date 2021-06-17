<?php

require_once $ROOT_PATH.'model/dao.php';


class EmuralTriggerDAO extends DAO {

	const EMURAL_TRIGGER_NEW = "nova";
	const EMURAL_TRIGGER_FINISHED = "colegiado";

	function __construct() {
		parent::__construct();

		$this->attributeMap["id"] = "id";
		$this->attributeMap["semester"] = "semestre";
		$this->attributeMap["year"] = "ano";
		$this->attributeMap["situation"] = "encaminhada";

		$this->table = "oferta_acusa_lista";
	}
}