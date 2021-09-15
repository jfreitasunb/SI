<?php
require_once dirname(__FILE__) . '/../../conf/default.php';

$ID_MODULE = $ID_MODULE_SECRETARY_POST;

require_once $ROOT_PATH . 'modelController/tableItemMC.php';

$type = TableItemDAO::ACTIVITY_POSTGRADUATE;

require_once $ROOT_PATH . 'module/granted_credits.php';
