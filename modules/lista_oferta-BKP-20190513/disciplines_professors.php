<?php
require_once 'conf/default.php';

require_once $ROOT_PATH.'utils/moduleUT.php';
require_once $ROOT_PATH.'utils/magisterialUT.php';
require_once $ROOT_PATH.'utils/utilUT.php';

ModuleUT::validateUserModule($ID_MODULE);

require_once $ROOT_PATH.'modelController/semesterMC.php';
require_once $ROOT_PATH.'modelController/disciplinesMC.php';
require_once $ROOT_PATH.'modelController/offerListTemporaryMC.php';

require_once $ROOT_PATH.'viewController/disciplinesProfessors/dpMainVC.php';

$semesterMC = new SemesterMC();
$semester = $semesterMC->last();

$vc = new DPMainVC();
$vc->setSemester($semester);

$disciplinesMC = new DisciplinesMC();
$disciplinesList = $disciplinesMC->graduationDisciplinesOferedOnSemester($semester);
$disciplinesList = MagisterialUT::modifyDisciplines($disciplinesList);
$disciplinesList = UtilUT::changeKey($disciplinesList);

$selectedDiscipline = null;
$isMagisterial = false;
$magisterialArray = null;

if (isset($_GET["discipline"])) {
	$selectedDiscipline = $disciplinesList[$_GET["discipline"]];
} else {
	$selectedDiscipline = array_values($disciplinesList);
	$selectedDiscipline = $selectedDiscipline[0];
}

$vc->fillDisciplines($disciplinesList, $selectedDiscipline->id);
$vc->setSelectedDiscipline($selectedDiscipline);

$classes = MagisterialUT::classesOfDiscipline($selectedDiscipline->id, $semester);

$vc->fillClasses($classes);

$vc->close();
?>
