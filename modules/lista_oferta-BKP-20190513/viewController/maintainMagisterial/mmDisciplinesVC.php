<?php

require_once $ROOT_PATH . 'viewController/vc.php';
require_once $ROOT_PATH . 'utils/linkUT.php';


class MMDisciplinesVC extends VC {

	const JS_GENERAL = 'general';

	private $tplBody2;

	function __construct() {
		parent::__construct();

		GLOBAL $ROOT_PATH;

		$this->tplBody = new HTML_Template_Sigma($ROOT_PATH.'template/maintainMagisterial');
		$this->tplBody->loadTemplateFile('mmDisciplines.tpl');

		$this->tplBody2 = new HTML_Template_Sigma($this->root_path.'template/maintainMagisterial');
		$this->tplBody2->loadTemplateFile('mmDisciplinesForm.tpl');

		$this->useCSS("maintainMagisterial/mmDisciplines.css");

		$this->useJSJQuery();
		$this->useJSJQueryValidate();
		$this->useJSJQueryUI();
		$this->useJSJQueryDataTable();

		$tpl = new HTML_Template_Sigma($this->root_path.'js/pages/maintainMagisterial');
		$tpl->loadTemplateFile('mmDisciplines.js');

		$linkJS = new stdClass();
		$linkJS->magisterial_discipline = LinkUT::ajaxMagisterialDiscipline();

		$this->fillObject($tpl, $linkJS, "url_");

		$this->tplJS[self::JS_GENERAL] = $tpl;



		// $this->useJS('pages/maintainMagisterial/mmDisciplines.js');
	}
	
	public function setMagisterialDisciplines($disciplines) {
		$this->fillListBody($disciplines, "discipline_", "add_discipline");
	}

	public function fillDisciplines($listDisciplines) {
		$this->fillList($this->tplBody2, $listDisciplines, "discipline_", "add_discipline");
	}

	protected function fillBody() {
		parent::fillBody(NULL);

		$this->addBodyToMainTemplate($this->tplBody2->get());
	}

	protected function getTitle() {
		return "Disciplinas Magistrais";
	}
}