<?php

require_once $ROOT_PATH.'viewController/vc.php';


class ProfessorCreditsVC extends VC {

	function __construct() {
		parent::__construct();

		GLOBAL $ROOT_PATH;

		$this->tplBody = & new HTML_Template_Sigma($ROOT_PATH.'template');
		$this->tplBody->loadTemplateFile('professorsCredits.tpl');

		$this->useJSJQuery();
		$this->useJSJQueryDataTable();
		$this->useJS('pages/professorCredits.js');
	}

	/**
	 * Fill list of professors and credtis on template
	 * @param array $listProfessors
	 * @param array $arrayCreditsSemesterProfessors
	 */
	public function fillProfessors($listProfessors, $arrayCreditsSemesterProfessors) {
		foreach ($listProfessors as $professor) {
			if (isset($arrayCreditsSemesterProfessors[$professor->id])) {
				$professor->credits = $arrayCreditsSemesterProfessors[$professor->id]->credits;
			}
			$professor->description = $professor->name." ".$professor->last_name;
			//$professor->name = $professor->last_name." ".$professor->name;
			$this->fillObjectBody($professor, "professor_", "add_professor");
		}
	}

	protected function getTitle() {
		return "Créditos dos Professores";
	}
}