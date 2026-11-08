<?php

require_once $ROOT_PATH.'viewController/vc.php';

require_once $ROOT_PATH.'utils/linkUT.php';


class OfferListVC extends VC {

	private $professorsTPL = array();

	const JS_GENERAL = 'general';

	private $credits;

	function __construct() {
		parent::__construct();

		$this->tplBody = new HTML_Template_Sigma($this->root_path.'template/offerList');
		$this->tplBody->loadTemplateFile('olOfferList.tpl');

		$this->useCSS("offerList/olOfferList.css");

		$this->useJSJQueryUI();
		$this->useJS("pages/offerList/olOfferList.js");

		$tpl = new HTML_Template_Sigma($this->root_path.'js/pages/offerList');
		$tpl->loadTemplateFile('olOfferListVariables.js');

		$linkJS = new stdClass();
		$linkJS->professor_class_temporary = LinkUT::ajaxProfessorClassTemporary();
		$linkJS->script_offer_list = LinkUT::scriptOfferList();

		$this->fillObject($tpl, $linkJS, "url_");

		$this->tplJS[self::JS_GENERAL] = $tpl;
	}

	public function fillClasses($classesList) {
		
		$last = reset($classesList);

		foreach($classesList as $class) {
			if (strcmp($class->discipline, $last->discipline) != 0) {
				$this->tplBody->parse("add_class_group");
				$last = $class;
			}
			if (strlen($class->professor)) {
				$class->professor_block = $this->professorsTPL[$class->professor];
			}
			$class->discipline_period = "$class->discipline-$class->period";

			if (isset($class->scheduleShock) && $class->scheduleShock) {
				$this->tplBody->touchBlock("schedule_shock_block");
			}

			$this->fillObjectTemplateAsProperty($this->tplBody, $class, "class_", "add_class", array("professor_block" => true));
		}
	}

	public function fillProfessors($listProfessors) {
		$tpl_all = new HTML_Template_Sigma($this->root_path.'template/offerList');
		$tpl_all->loadTemplateFile('olProfessorList.tpl');

		foreach($listProfessors as $professor) {
			$tpl = new HTML_Template_Sigma($this->root_path . 'template/offerList');
			$tpl->loadTemplateFile('olProfessorList.tpl');

			if (!isset($professor->choices)) {
				$professor->name = "* " . $professor->name;
			}

			$this->fillObject($tpl_all, $professor, "professor_", "add_professor");

			$this->fillObject($tpl, $professor, "professor_");

			$this->professorsTPL[$professor->professor] = $tpl->get();
		}

		$tpl_all->touchBlock("exist_comment");

		$this->tplBody->setVariable(array(
			"professor_list"  => $tpl_all->get()
		));
	}

	public function setCredits($credits) {
		$this->credits = $credits;
	}

	protected function fillBody($form = true) { // assinatura compativel com VC (PHP 8)
		parent::fillBody(false);

		$tplDistribute = new HTML_Template_Sigma($this->root_path.'template/offerList');
		$tplDistribute->loadTemplateFile('olDistribute.tpl');

		$link = new stdClass();
		$link->script_offer_list = LinkUT::scriptOfferList();

		$this->fillObject($tplDistribute, $link, "url_");

		$credits = new stdClass();
		$credits->professors = $this->credits->numberOfProfessors;
		$credits->system = $this->credits->creditsSystem;
		$credits->coordinator = $this->credits->creditsCoordinator;

		$this->fillObject($tplDistribute, $credits, "credits_");

		$this->addBodyToMainTemplate($tplDistribute->get());
	}

	protected function getTitle() {
		return "Lista de Oferta";
	}
}