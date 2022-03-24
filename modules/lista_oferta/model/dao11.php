<?php

require_once $ROOT_PATH.'model/dao.php';

abstract class DAO1x1 extends DAO {
	public function insert($insert) {
		$this->_db->beginTransaction();

		$sql = "INSERT INTO $this->table ".$this->insertFields($insert)." VALUES ".$this->insertValues($insert);

		$res = $this->_db->prepate($sql);

        $res->execute();

		if($this->_db->isError($res)) {
			//print_r($res);
			$this->_db->rollback();
			throw new Exception("Error: $sql");
		}

		if ($this->_db->inTransaction()) {
			$this->_db->commit();
		}

		$return = new stdClass();

		foreach ($insert as $key => $value) {
			$return->$key .= $value;
		}

		return $return;
	}
}
