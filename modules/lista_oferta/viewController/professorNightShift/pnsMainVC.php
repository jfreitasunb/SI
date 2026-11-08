<?php

require_once $ROOT_PATH.'viewController/vc.php';

require_once $ROOT_PATH.'utils/linkUT.php';


class PNSMainVC extends VC {

	private $selectedProfessor;

	private $logged = false;

	function __construct() {
		parent::__construct();

		$this->tplBody = new HTML_Template_Sigma($this->root_path.'template/professorNightShift');
		$this->tplBody->loadTemplateFile('pnsMain.tpl');

		$this->useCSS("professorNightShift/pnsMain.css");

		$this->useJSJQuery();
		$this->useJSJQueryDataTable();
		$this->useJS('pages/professorNightShift/pnsMain.js');
	}

	public function fillProfessorsList($professors) {
		$rank = 1;
		foreach ($professors as $professor) {
			$professor->rank = $rank;
			$this->fillObjectBody($professor, "professor_", "add_professor");
			$rank += 1;
		}
	}

	public function setLogged($logged) {
		$this->logged = $logged;
	}

	protected function fillBody($form = true) { // assinatura compativel com VC (PHP 8)
		parent::fillBody(false);

		if ($this->logged) {
			$tpl = new HTML_Template_Sigma($this->root_path.'template');
			$tpl->loadTemplateFile('logout.tpl');

			$this->addBodyToMainTemplate($tpl->get());
		}
	}

	protected function getTitle() {
		return "Atua&ccedil;&atilde;o no Noturno";
	}
}