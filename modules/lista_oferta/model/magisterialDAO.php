<?php

require_once $ROOT_PATH.'model/dao.php';


class MagisterialDAO extends DAO {

	const THEORY = 'T';
	const EXERCISE = 'E';

	private $amTheoryGroups;

	private $theoryGroupsTable;

	function __construct() {
		parent::__construct();

		$this->attributeMap["id"] = "id";
		$this->attributeMap["discipline"] = "codigo";
		$this->attributeMap["theory_quantity"] = "teoria";
		$this->attributeMap["exercises_quantity"] = "exercicios";
		$this->attributeMap["semester"] = "semestre";
		$this->attributeMap["year"] = "ano";

		$this->table = "oferta_disciplinas_magistral";

		$this->amTheoryGroups["id"] = "id";
		$this->amTheoryGroups["group"] = "grupo";
		$this->amTheoryGroups["discipline"] = "codigo";
		$this->amTheoryGroups["class"] = "turmas";
		$this->amTheoryGroups["schedule"] = "horario";
		$this->amTheoryGroups["semester"] = "semestre";
		$this->amTheoryGroups["year"] = "ano";

		$this->theoryGroupsTable = "oferta_grupos_magistral_teoria";
	}


	/**
	 * @param SemesterDAO $semester
	 * @return array[stdClass]
	 * @throws Exception
	 */
	public function theoryGroups($semester) {
		$sql = "SELECT ".$this->attributesSelect($this->amTheoryGroups)."
		FROM $this->theoryGroupsTable
		WHERE ano = $semester->year AND
			semestre = $semester->semester
		ORDER BY codigo, turmas";

		$res = $this->_db->prepare($sql);

        $res->execute();

		//if($this->_db->isError($res)) {
		//	print_r($res);
		//	throw new Exception("Select error: $sql");
		//}

		$list = $res->fetchAll(PDO::FETCH_OBJ);

		return $list;
	}

	/**
	 * @param array[string] $insert
	 * @return stdClass
	 * @throws Exception
	 */
	public function insertTheoryGroup($insert) {
		$this->_db->beginTransaction();

		$res = $this->_db->prepare("SELECT NEXTVAL('".$this->theoryGroupsTable."_".$this->amTheoryGroups["id"]."_seq"."')");

        $res->execute();

		//if($this->_db->isError($res)) {
		//	print_r($res);
		//	$this->_db->rollback();
		//	throw new Exception("PK error: ".$this->theoryGroupsTable."_".$this->amTheoryGroups["id"]."_seq");
		//}
		$list = $res->fetchAll(PDO::FETCH_OBJ);

		$id = $list[0]->nextval;

		if(is_array($insert)) {
			$insert['id'] = $id;
		} else {
			$insert->id = $id;
		}

		$insertFields = $this->insertFields($insert, $this->amTheoryGroups);
		$insertValues = $this->insertValues($insert);

		$sql = "INSERT INTO $this->theoryGroupsTable $insertFields VALUES $insertValues" ;


        $res = $this->_db->prepare($sql);

        $res->execute();

		//if($this->_db->isError($res)) {
		//	print_r($res);
		//	$this->_db->rollback();
		//	throw new Exception("Insertion error: $sql");
		//}

		if ($this->_db->inTransaction()) {
			$this->_db->commit();
		}

		$return = new stdClass();

		foreach($insert as $key => $value) {
			$return->$key = $value;
		}

		return $return;
	}
}
