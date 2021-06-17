<?php

require_once $ROOT_PATH.'viewController/vc.php';

require_once $ROOT_PATH.'utils/linkUT.php';

class ALMainVC extends VC {

	function __construct() {
		parent::__construct();

		GLOBAL $ROOT_PATH;

		$this->tplBody = new HTML_Template_Sigma($ROOT_PATH.'template/activityList');
		$this->tplBody->loadTemplateFile('alMain.tpl');

		$this->useCSS("activityList/alMain.css");
	}

	public function fillActivityList($professorList) {
		$class = 0;
		foreach ($professorList as $professor) {
			$professor->activity_count = count($professor->activity);
			if (isset($professor->activity)) {
				$this->fillObjectBody($professor, "activity_professor_");
				foreach ($professor->activity as $activity) {
					$activity->professor_row_class = $class;
					$this->fillObjectBody($activity, "activity_", "add_activity");
				}
			} else {
				$professor->row_class = $class;
				$this->fillObjectBody($professor, "activity_professor_", "add_activity");
			}

			$class = ($class + 1) % 2;
		}
	}

	protected function fillBody() {
		parent::fillBody(false);

		$tpl = new HTML_Template_Sigma($this->root_path.'template/activityList');
		$tpl->loadTemplateFile('alMain_2.tpl');

		$links = new stdClass();
		$links->activity_list = LinkUT::activityListCSV();

		$this->fillObject($tpl, $links, "url_");

		$this->addBodyToMainTemplate($tpl->get());
	}

	protected function getTitle() {
		return "Lista de Atividades";
	}
}