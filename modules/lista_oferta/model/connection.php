<?php

class Connection {
	private static $instance;

	private function __construct() {

	}

	/**
	 * @return MDB2_Driver_pgsql
	 * @throws Exception
     */
	public static function getInstance() {
		if (!isset(self::$instance)) {
        	GLOBAL $DB;
        	$db = $DB;

	        $dsn = array(
				'phptype'  => 'pgsql',
				'username' => $db["user"],
				'password' => $db["password"],
				'hostspec' => $db["host"],
				'database' => $db["dbname"],
				'port'     => $db["dbport"],
			);

			$options = array(
	            'debug'       => 2,
	            'portability' => DB_PORTABILITY_ALL,
				//'disable_smart_seqname' => false
            );

            try{
                $pdo = new PDO("pgsql:host=".$dsn['hostspec'].";port=".$dsn['port'].";dbname=".$dsn['database'].";user=".$dsn['username'].";password=".$dsn['password']);
            }catch (\PDOException $e){
                throw new \PDOException($e->getMessage(), (int)$e->getCode());
            }
            //$mdb2 = new MDB2();

			//self::$instance = $mdb2->connect($dsn, $options);

			//if ($mdb2->isError(self::$instance)) {
			//	print_r(self::$instance);
				//die($this->_db->getMessage());
			//	throw new Exception("Erro de acesso ao banco");
			//}

			//if(isset($CHARSET))
			//	self::$instance->setCharset($CHARSET);

			//self::$instance->loadModule('Extended', null, false);
			//self::$instance->setFetchMode(MDB2_FETCHMODE_ASSOC);
		}
        //return self::$instance;
        return $pdo;
	}
}

?>
