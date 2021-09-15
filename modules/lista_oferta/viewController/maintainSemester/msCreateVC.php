<?php

require_once $ROOT_PATH.'viewController/vc.php';


class MSCreateVC extends VC {

	function __construct() {
		parent::__construct();

		GLOBAL $ROOT_PATH;

		$this->tplBody = new HTML_Template_Sigma($ROOT_PATH.'template/maintainSemester');
		$this->tplBody->loadTemplateFile('msCreate.tpl');

		$this->useJSJQuery();
		$this->useJSJQueryValidate();
		$this->useJSJQueryUI();
		$this->useJSJQueryUIDatepicker();
		$this->useJS("pages/maintainSemester/msCreate.js");
	}

	public function fillPreviousSemestersList($listSemesters) {
		$this->fillListBody($listSemesters, "semester_", "add_semester");
	}

	protected function fillBody() {
		$form = new stdClass();
		$form->id = "create_semester_form";

		parent::fillBody($form);

		$tpl = new HTML_Template_Sigma($this->root_path.'template/maintainSemester');
		$tpl->loadTemplateFile('msCreate_2.tpl');

		$this->addBodyToMainTemplate($tpl->get());
	}

	protected function getTitle() {
		return "Criar Semestre";
	}
}