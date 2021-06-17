<?php

// TODO: Colocar links relativos a essa variável
//$ROOT_MAIN = "/";
$ROOT_MAIN = "/";

$ROOT_PATH_MAIN = dirname(__FILE__)."/../";

//$SITE = "http://e-mural.mat.unb.br/";
$SITE = "http://192.168.122.127/";

//$CHARSET = "UTF-8";
$CHARSET = "ASCII";

$DB["user"]     = "si";
$DB["password"] = "estudos";
$DB["host"]     = "192.168.122.36";
$DB["dbname"]   = "si";
$DB["dbport"]   = "5432";

$MODULE_MAGISTERIAL = true;


$ENCRYPTED_PASSWORDS = true;
//$DEVELOPMENT = true;
$DEVELOPMENT = false;

$OFFER_LIST_QUANTITY_ATTEMPTS = 1000;
$CREDITS_PLUS_AVERAGE = 2;

function p($thing, $pre = true) {
	if ($pre)
		echo "<pre>";
	print_r($thing);
	if ($pre)
		echo "</pre>\n";
}
