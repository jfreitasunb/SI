<?php

require_once $ROOT_PATH.'model/dao.php';


class NightShiftDAO extends DAO {

	private $attributeMapCount;

	private $table2;

	function __construct() {
		parent::__construct();

		$this->attributeMap["professor"] = "A.coduser";
		$this->attributeMap["quantity"] = "quantidade";
		$this->attributeMap["year"] = "ano";
		$this->attributeMap["semester"] = "semestre";

		$this->table = "oferta_horario_noturno_acumulado_94_04";
		$this->table2 = "oferta_horarios_rodizio_noturno";
	}

	public function filter($filter, $year, $semester = null, $order = null, $offset = null, $limit = null) {
		$where = $this->whereFromFilter($filter);
		$where .= strlen($where) > 0 ? " AND " : " WHERE ";
		$where .= $this->attributeMap["year"]." < $year";
		$where .= $semester !== null ? " OR (".$this->attributeMap["year"]." = $year AND ".$this->attributeMap["semester"]." < $semester)" : "";

		$order = $this->orderBy($order);

		if(strlen($limit) > 0)
			$limit = "LIMIT $limit";

		if(strlen($offset) > 0)
			$offset = "OFFSET $offset";

		$sql = "SELECT ".$this->attributesSelect()."
				FROM (
					SELECT coduser, quantidade, 2004 AS ano, 2 AS semestre
					FROM $this->table
					UNION ALL
					SELECT coduser, disc_noturno, ano, semestre
					FROM $this->table2) AS A
				$where
				$order
				$limit
				$offset";

		$res = $this->_db->query($sql);

		if($this->_db->isError($res)) {
			p($res);
			throw new Exception("Error: $sql");
		}

		$list = $res->fetchAll(MDB2_FETCHMODE_OBJECT);

		return $list;
	}
}