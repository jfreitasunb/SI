<?php

// TODO: Colocar links relativos a essa variável
//$ROOT_MAIN = "/";
$ROOT_MAIN = "http://192.168.122.71/si/";

$ROOT_PATH_MAIN = dirname(__FILE__)."/../";

//$SITE = "http://e-mural.mat.unb.br/";
$SITE = "http://192.168.122.36/";

//$CHARSET = "UTF-8";
$CHARSET = "ASCII";

// Banco: mesma configuracao do resto do sistema (global/db_config.php ou
// variaveis SI_DB_*; ver global/db_config_func.php). Nada de senha/host aqui.
require_once dirname(__FILE__)."/../global/db_config_func.php";
$_db_cfg = db_config();
$DB["user"]     = $_db_cfg['user'];
$DB["password"] = (string)$_db_cfg['passwd'];
$DB["host"]     = $_db_cfg['host'];
$DB["dbname"]   = $_db_cfg['dbname'];
$DB["dbport"]   = $_db_cfg['port'];
unset($_db_cfg);

$MODULE_MAGISTERIAL = true;


$ENCRYPTED_PASSWORDS = true;
//$DEVELOPMENT = true;
$DEVELOPMENT = false;

$OFFER_LIST_QUANTITY_ATTEMPTS = 10000;
$CREDITS_PLUS_AVERAGE = 2;

function p($thing, $pre = true) {
	if ($pre)
		echo "<pre>";
	print_r($thing);
	if ($pre)
		echo "</pre>\n";
}
