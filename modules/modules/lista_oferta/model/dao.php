<?php

require_once $ROOT_PATH.'model/connection.php';

require_once 'MDB2.php';

/**
 * This class must be extended by others DAO classes.
 * (ie. DAO: Data Access Object).
 *
 * @author Paulo Angelo <pa@mat.unb.br>
 * @author Phelippe Amorim <amorim.phelippe@gmail.com>
 */
define('DB_PORTABILITY_ALL', 0);

abstract class DAO {

	const ORDER_ASCENDANT = 'ASC';
	const ORDER_DESCENDANT = 'DESC';

	const INSERTED = 0;
	const UPDATED = 1;

	const ACTIVE = 'active';
	const INACTIVE = 'inactive';

	/**
     * This variable is a DB connection
	 *
 	 * @var MDB2_Driver_pgsql
 	 */
	protected $_db;

	protected $attributeMap;

	protected $table;

	/**
	 * DAO constructor.
     */
	function __construct()
	{
		$this->_db = Connection::getInstance();
	}


    /**
     * @param array[string] $filter
     * @param array[string] $attributes or null
     * @return string
     */
    protected function whereFromFilter($filter, $attributes = null) {
		if($attributes === null) {
			$attributes = $this->attributeMap;
		}

		$where = "";

		if(count($filter)) {
			foreach($filter as $key => $value)
			{
				if (array_key_exists($key, $attributes)) {
					$field = $attributes[$key];
				} else {
					$field = $key;
				}
				$field = pg_escape_string($field);
				if($value === null) {
					$sqlValue = "IS NULL";
				} else {
					$sqlValue = "= '".pg_escape_string($value)."'";
				}
				$where .= " $field $sqlValue AND";
			}
		}

		if(strlen($where)>0)
		{
			$where = " WHERE ".substr($where, 0, strlen($where) - 3);
		}

		return $where;
	}


    /**
     * @param array[string] $order
     * @param array[string] $attributes or null
     * @return string
     */
    protected function orderBy($order, $attributes = null) {
		if ($attributes === null) {
			$attributes = $this->attributeMap;
		}

        $orderBy = "";
		if($order != null) {
			foreach($order as $key => $value)
			{
				if (array_key_exists($key, $attributes)) {
					$field = $attributes[$key];
				} else {
					$field = $key;
				}
				$orderBy .= " ".pg_escape_string($field)." ".pg_escape_string($value).",";
			}
		}

		if(strlen($orderBy) > 0)
		{
			$orderBy = " ORDER BY ".substr($orderBy, 0, strlen($orderBy) - 1);
		}

		return $orderBy;
	}


	/**
	 * @param array[string] $fields
	 * @param array[string] $attributes or null
	 * @return string
	 */
    protected function updateSet($fields, $attributes = null) {
		if($attributes === null) {
			$attributes = $this->attributeMap;
		}
		$return = "";

		foreach($fields as $key => $value)
		{
			if($value === null) {
				$return .= " ".$attributes[$key]." = null,";
			} else {
				$return .= " ".$attributes[$key]." = '".pg_escape_string($value)."',";
			}
		}

		$return = substr($return, 0, strlen($return) - 1);

		return $return;
	}


    /**
	 * @param array[string] $attributes or null
     * @return string
     */
    protected function attributesSelect($attributes = null) {
		if($attributes === null) {
			$attributes = $this->attributeMap;
		}
		$select = "";

		foreach($attributes as $key => $value)
		{
			$select .= " ".pg_escape_string($value)." AS $key,";
		}

		return substr($select, 0, strlen($select) - 1);
	}


	/**
	 * @param array[string] $fields
	 * @param array[string] $attributes or null
	 * @return string
	 */
    protected function insertFields($fields, $attributes = null) {
		if($attributes === null) {
			$attributes = $this->attributeMap;
		}

		$return = "(";

		foreach($fields as $key => $value)
		{
			$return .= $attributes[pg_escape_string($key)].", ";
		}

		$return = substr($return, 0, strlen($return) - 2).")";

		return $return;
	}


    /**
     * @param array[string] $fields
     * @return string
     */
    protected function insertValues($fields) {
		$return = "(";

		foreach($fields as $value)
		{
			if(strlen($value) != 0)
				$return .= "'".pg_escape_string($value)."',";
			else
				$return .= "null,";
		}

		$return = substr($return, 0, strlen($return) - 1).")";

		return $return;
	}

	protected function disconnect() {
		$this->_db->disconnect();
	}


    /**
     * @param array[string] $filter
     * @param array[string] $order or null
     * @param int $offset or null
     * @param int $limit or null
     * @return array[stdClass]
     * @throws Exception
     */
    public function filter($filter, $order = null, $offset = null, $limit = null) {
		$where = $this->whereFromFilter($filter);

		$order = $this->orderBy($order);

		if(strlen($limit) > 0)
			$limit = "LIMIT $limit";

		if(strlen($offset) > 0)
			$offset = "OFFSET $offset";

		$sql = "SELECT ".$this->attributesSelect()." FROM $this->table $where $order $limit $offset";

		$res = $this->_db->query($sql);

		if($this->_db->isError($res)) {
			print_r($res);
			throw new Exception("Select error: $sql");
		}

		$list = $res->fetchAll(MDB2_FETCHMODE_OBJECT);

		return $list;
	}


    /**
     * @param array[string] $insert
     * @return stdClass
     * @throws Exception
     */
    public function insert($insert) {
		$this->_db->beginTransaction();

		$res = $this->_db->query("SELECT NEXTVAL('".$this->table."_".$this->attributeMap["id"]."_seq"."')");

		if($this->_db->isError($res)) {
			print_r($res);
			$this->_db->rollback();
			throw new Exception("PK error: ".$this->table."_".$this->attributeMap["id"]."_seq");
		}
		$list = $res->fetchAll(MDB2_FETCHMODE_OBJECT);

		$id = $list[0]->nextval;

//		$id = $this->_db->nextID($this->table);
//		if($this->_db->isError($id)) {
//			print_r($id);
//			throw new Exception("PK error");
//		}

		if(is_array($insert)) {
			$insert['id'] = $id;
		} else {
			$insert->id = $id;
		}

        $insertFields = $this->insertFields($insert);
        $insertValues = $this->insertValues($insert);

        $sql = "INSERT INTO $this->table $insertFields VALUES $insertValues" ;

		$res = $this->_db->query($sql);

		if($this->_db->isError($res)) {
			print_r($res);
			$this->_db->rollback();
			throw new Exception("Insertion error: $sql");
		}

		if ($this->_db->inTransaction()) {
			$this->_db->commit();
		}

		$return = new stdClass();

		foreach($insert as $key => $value) {
			$return->$key = $value;
		}

		return $return;
	}


    /**
     * @param array[string] $fields
     * @param array[string] $filter or null
	 * @return stdClass
     * @throws Exception
     */
    public function update($fields, $filter = null) {
		$where = $this->whereFromFilter($filter);

		$set = $this->updateSet($fields);

		$sql = "UPDATE $this->table SET $set $where";
		//echo $sql."<br>"; return;

		$res = $this->_db->query($sql);

		if($this->_db->isError($res)) {
			print_r($res);
			throw new Exception("Error: $sql");
		}

		return $this->filter($filter);
	}


    /**
     * @param array[string] $filter
     * @throws Exception
     */
    public function delete($filter) {
		$where = $this->whereFromFilter($filter);

		$sql = "DELETE FROM $this->table $where";

		$res = $this->_db->query($sql);

		if($this->_db->isError($res)) {
			print_r($res);
			throw new Exception("Error: $sql");
		}
	}


    /**
     * @param $sql
     * @return array[anyClass]
     * @throws Exception
     */
    public function runSQL($sql) {
		$res = $this->_db->query($sql);

		if($this->_db->isError($res)) {
			print_r($res);
			throw new Exception("Sql error: $sql");
		}

		return $res;
	}
}