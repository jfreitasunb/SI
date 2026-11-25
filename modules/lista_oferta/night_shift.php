<?php
require_once 'conf/default.php';

require_once $ROOT_PATH.'utils/moduleUT.php';

ModuleUT::validateUserModule($ID_MODULE);

define('LO_ENTRY_AUTHORIZED', true);
require_once $ROOT_PATH . 'module/professor_night_shift.php';