<?php

require_once $ROOT_PATH.'model/dao.php';

class UnixBO {
    /**
     * @var string
     */
    public $login;

    /**
     * @var string
     */
    var $password;

    /**
     * @var string
     */
    var $type;

    /**
     * @var string
     */
    var $user_id;
}

class UnixDAO extends DAO {

	const TYPE_EMPLOYEE = "fonctionnaire";
	const TYPE_STUDENT = "student";

	/**
	 * UnixDAO constructor.
     */
	function __construct() {
		parent::__construct();

		$this->attributeMap["login"] = "login";
		$this->attributeMap["password"] = "pas" . "swd";
		$this->attributeMap["type"] = "ta" . "be" . "la_user";
		$this->attributeMap["user_id"] = "cod" . "user";

		$this->table = "unix";
	}

    /**
     * @param array[String] $filter
     * @param array[String] $order or null
     * @param int $offset or null
     * @param int $limit or null
     * @return array[UnixBO]
     * @throws Exception
     */
    public function filter($filter, $order = null, $offset = null, $limit = null) {
        return parent::filter($filter, $order, $offset, $limit);
    }
}