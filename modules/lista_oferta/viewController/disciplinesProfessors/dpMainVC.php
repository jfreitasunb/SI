<?php

require_once $ROOT_PATH . 'viewController/vc.php';


class DPMainVC extends VC {

	private $selectedDiscipline;

	function __construct() {
		parent::__construct();

		GLOBAL $ROOT_PATH;

		$this->tplBody = new HTML_Template_Sigma($ROOT_PATH.'template/disciplinesProfessors');
		$this->tplBody->loadTemplateFile('dpMain.tpl');

		$this->useCSS("disciplinesProfessors/dpMain.css");

		$this->useJSJQuery();
		$this->useJSJQueryDataTable();
		$this->useJS('pages/disciplinesProfessors/dpMain.js');
	}

	public function fillDisciplines($listDisciplines, $selected) {
		foreach ($listDisciplines as $discipline) {
			if ($discipline->id == $selected) {
				$this->tplBody->touchBlock("discipline_selected");
			}
			$this->fillObjectBody($discipline, "discipline_", "add_discipline");
		}
	}

	public function fillClasses($classes) {
		$this->fillListBody($classes, "class_", "add_class");
	}

	public function setSelectedDiscipline($discipline) {
		$this->selectedDiscipline = $discipline;
	}

	protected function fillBody($form = true) { // assinatura compativel com VC (PHP 8)
		parent::fillBody(NULL);
	}

	protected function getTitle() {
		return array("Professores em Disciplinas", $this->selectedDiscipline->name);
	}
}