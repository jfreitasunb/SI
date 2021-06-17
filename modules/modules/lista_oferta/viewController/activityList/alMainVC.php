<?php

require_once $ROOT_PATH.'viewController/vc.php';


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
//				$this->fillListBody($professor->activity, "activity_", "add_activity");
			} else {
				$professor->row_class = $class;
				$this->fillObjectBody($professor, "activity_professor_", "add_activity");
			}

			$class = ($class + 1) % 2;
		}
	}

	protected function getTitle() {
		return "Lista de Atividades";
	}
}