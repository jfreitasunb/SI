<?php
require_once dirname(__FILE__) . '/../../conf/default.php';

$ID_MODULE = $ID_MODULE_SECRETARY_GRADUATION;

require_once $ROOT_PATH . 'modelController/tableItemMC.php';

$type = TableItemDAO::ACTIVITY_GRADUATION;

require_once $ROOT_PATH . 'module/granted_credits.php';
