<?php

require_once $ROOT_PATH.'viewController/vc.php';

require_once $ROOT_PATH.'utils/linkUT.php';

class ALMainVC extends VC {

	private $order;

	function __construct() {
		parent::__construct();

		GLOBAL $ROOT_PATH;

		$this->tplBody = new HTML_Template_Sigma($ROOT_PATH.'template/activityList');
		$this->tplBody->loadTemplateFile('alMain.tpl');

		$this->useCSS("activityList/alMain.css");

		$this->useJSJQuery();
		$this->useJS("pages/activityList/alMain.js");
	}

	public function fillActivityList($professorList) {
		$class = 0;
		foreach ($professorList as $professor) {
			if (count($professor->activity) == 0) {
				$activity = new stdClass();
				$activity->credits = "-";

				$professor->activity[] = $activity;
			}

			$professor->row_class = $class;

			$this->fillListBody($professor->activity, "activity_", "add_activity", $professor, "activity_professor_", "add_professor");

			$class = ($class + 1) % 2;
		}
	}

	public function fillSemestersList($listSemesters, $selectedSemester) {
		foreach ($listSemesters as $semester) {
			if ($semester->year == $selectedSemester->year && $semester->semester == $selectedSemester->semester) {
				$this->tplBody->touchBlock("semester_selected");
			}
			$this->fillObjectBody($semester, "semester_", "add_semester");
		}
	}

	public function setOrder($order) {
		$this->order = $order;
	}

	public function setEmpty() {
		$this->fillObjectBody($this->semester, "empty_semester_");
	}

	protected function fillBody() {
		parent::fillBody(false);

		$tpl = new HTML_Template_Sigma($this->root_path.'template/activityList');
		$tpl->loadTemplateFile('alMain_2.tpl');

		$links = new stdClass();
		$links->activity_list_csv = LinkUT::activityListCSV($this->semester, $this->order);
		$links->activity_list_order = LinkUT::activityListOrder($this->semester, $this->order);

		$this->fillObject($tpl, $links, "url_");

		$this->addBodyToMainTemplate($tpl->get());
	}

	protected function getTitle() {
		return "Lista de Atividades";
	}
}