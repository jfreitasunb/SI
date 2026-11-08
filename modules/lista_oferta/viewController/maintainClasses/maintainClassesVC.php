<?php

require_once $ROOT_PATH . 'viewController/vc.php';
require_once $ROOT_PATH . 'utils/linkUT.php';


class MaintainClassesVC extends VC {

	const JS_GENERAL = 'general';

	private $tplBody2;

	function __construct() {
		parent::__construct();

		GLOBAL $ROOT_PATH;

		$this->tplBody = new HTML_Template_Sigma($ROOT_PATH.'template/maintainClasses');
		$this->tplBody->loadTemplateFile('maintainClasses.tpl');

		$this->tplBody2 = new HTML_Template_Sigma($this->root_path.'template/maintainClasses');
		$this->tplBody2->loadTemplateFile('maintainClasses_2.tpl');

		$this->useCSS("maintainClasses/maintainClasses.css");

		$this->useJSJQuery();
		$this->useJSJQueryValidate();
		$this->useJSJQueryUI();
		$this->useJSJQueryDataTable();

		$tpl = new HTML_Template_Sigma($this->root_path.'js/pages/maintainClasses');
		$tpl->loadTemplateFile('maintainClasses.js');

		$linkJS = new stdClass();
		$linkJS->alter_class_temporary = LinkUT::ajaxAlterClassTemporary();

		$this->fillObject($tpl, $linkJS, "url_");

		$this->tplJS[self::JS_GENERAL] = $tpl;
	}

	public function fillTemporaryOfferList($tempOfferList) {
		$this->fillListBody($tempOfferList, "class_", "add_class");
	}

	public function fillDisciplines($listDisciplines) {
		$this->fillList($this->tplBody2, $listDisciplines, "discipline_", "add_discipline");
	}

	public function fillPeriods($listPeriods) {
		$this->fillList($this->tplBody2, $listPeriods, "period_", "add_period");
	}

	protected function fillBody() {
		parent::fillBody(NULL);

		$this->addBodyToMainTemplate($this->tplBody2->get());
	}

	protected function getTitle() {
		return "Manter Turmas";
	}
}