<?php

require_once $ROOT_PATH.'viewController/vc.php';

require_once $ROOT_PATH.'utils/utilUT.php';


class MSDetailsVC extends VC {

	private $saved = 0;

	private $missingProfessor = 0;

	function __construct() {
		parent::__construct();

		GLOBAL $ROOT_PATH;

		$this->tplBody = new HTML_Template_Sigma($ROOT_PATH.'template/maintainSemester');
		$this->tplBody->loadTemplateFile('msDetails.tpl');

		$this->useCSS("maintainSemester/msDetails.css");

		$this->useJSJQuery();
		$this->useJSJQueryValidate();
		$this->useJSJQueryUI();
		$this->useJSJQueryUIDatepicker();
		$this->useJS("pages/maintainSemester/msDetails.js");
	}

	public function fillSemesters($listSemesters) {
		$this->fillListBody($listSemesters, "semester_", "add_semester");
	}

	protected function fillBody() {
		$form = new stdClass();
		$form->id = "detail_semester_form";

		parent::fillBody($form);
	}

	public function setSemester($semester) {
		parent::setSemester($semester);

		$semester->beginning = UtilUT::convertDateToBR($semester->beginning);
		$semester->end = UtilUT::convertDateToBR($semester->end);

		$this->fillObjectBody($semester, "semester_");
	}

	public function setStages($stages) {
		foreach ($stages as $stage) {
			if (!strcmp($stage->id, $this->semester->status)) {
				$this->tplBody->touchBlock("stage_selected");
			}
			$this->fillObjectBody($stage, "stage_", "add_stage");
		}
	}

	public function setCredits($credits) {
		$this->fillObjectBody($credits, "credits_");
	}

	protected function getTitle() {
		return "Editar Semestre";
	}

	protected function alertMessage() {
		if ($this->saved == 1) {
			return "Semestre atualizado com sucesso.";
		} elseif ($this->saved == 2) {
			return "Semestre criado com sucesso.";
		} elseif ($this->missingProfessor > 0) {
			return "Não foi possível fechar o semestre pois existem $this->missingProfessor turmas que não possuem professor alocado.";
		}
		return null;
	}

	public function saved() {
		$this->saved = 1;
	}

	public function created() {
		$this->saved = 2;
	}

	public function setMissingProfessor($missingProfessor) {
		$this->missingProfessor = $missingProfessor;
	}
}