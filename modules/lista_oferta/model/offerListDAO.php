<?php

require_once $ROOT_PATH.'model/dao11.php';


class OfferListDAO extends DAO1x1 {

	private $attributeMapCompact;

	function __construct() {
		parent::__construct();

		$this->attributeMapCompact["semester"] = "semestre";
		$this->attributeMapCompact["year"] = "ano";

		$this->attributeMap = $this->attributeMapCompact;
		$this->attributeMap["discipline"] = "disciplina";
		$this->attributeMap["class"] = "turma";
		$this->attributeMap["period"] = "turno";
		$this->attributeMap["professor"] = "professor";
		$this->attributeMap["schedule"] = "horarios";
		$this->attributeMap["classroom"] = "sala";

		$this->table = "oferta_lista_de_ofertas";
	}

	public function filterDistinctSemesters($order = NULL) {
		$order = $this->orderBy($order);

		$sql = "SELECT DISTINCT ".$this->attributesSelect($this->attributeMapCompact)." FROM $this->table
				GROUP BY ".$this->attributeMapCompact["semester"].", ".$this->attributeMapCompact["year"]."
				$order";

		$res = $this->_db->query($sql);

		if($this->_db->isError($res)) {
			print_r($res);
			throw new Exception("Erro: $sql");
		}

		$list = $res->fetchAll(MDB2_FETCHMODE_OBJECT);

		return $list;
	}
}