<?php
require_once dirname(__FILE__).'/../conf/default.php';

require_once $ROOT_PATH.'modelController/semesterMC.php';

require_once $ROOT_PATH.'processing/professorPR.php';

require_once $ROOT_PATH.'viewController/professorNightShift/pnsMainVC.php';

$semesterMC = new SemesterMC();
$semester = $semesterMC->last();

$vc = new PNSMainVC();
$vc->setSemester($semester);

$professors = ProfessorPR::professorNightShift($semester);
$vc->fillProfessorsList($professors);

if (isset($logged) && $logged) {
	$vc->setLogged($logged);
}

$vc->close();
