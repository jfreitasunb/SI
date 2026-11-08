<?php

require_once $ROOT_PATH.'viewController/vc.php';
require_once $ROOT_PATH.'utils/linkUT.php';


class MPMainVC extends VC {

	private $saved = false;

	private $contractType = array();

	function __construct() {
		parent::__construct();

		GLOBAL $ROOT_PATH;

		$this->contractType[ProfessorDAO::CONTRACT_TYPE_EXCLUSIVE] = 'Dedicacao Exclusiva';
		$this->contractType[ProfessorDAO::CONTRACT_TYPE_SUBSTITUTE_DR40] = 'Substituto';
		$this->contractType[ProfessorDAO::CONTRACT_TYPE_SUBSTITUTE_GR40] = 'Substituto';
		$this->contractType[ProfessorDAO::CONTRACT_TYPE_SUBSTITUTE_MS20] = 'Substituto';
		$this->contractType[ProfessorDAO::CONTRACT_TYPE_SUBSTITUTE_MS40] = 'Substituto';

		$this->tplBody = new HTML_Template_Sigma($ROOT_PATH . 'template/maintainProfessors');
		$this->tplBody->loadTemplateFile('mpMain.tpl');

		$this->useJSJQueryDataTable();
		$this->useJS('pages/maintainProfessors/mpMain.js');
	}

	public function fillProfessorsList($professorList) {
		$total = array('de' => 0, 'sb' => 0);
		$actives = array('de' => 0, 'sb' => 0);;
		foreach ($professorList as $professor) {
			if ($professor->status == DAO::ACTIVE) {
				$this->tplBody->touchBlock("professor_status_enable");
				// $actives ++;
				if (!strcmp($professor->contract_type, ProfessorDAO::CONTRACT_TYPE_EXCLUSIVE)) {
					$total['de'] ++;
					$actives['de'] ++;
				} else {
					$total['sb'] ++;
					$actives['sb'] ++;
				}
			} else {
				if (!strcmp($professor->contract_type, ProfessorDAO::CONTRACT_TYPE_EXCLUSIVE)) {
					$total['de'] ++;
				} else {
					$total['sb'] ++;
				}
			}
			$professor->contract_type = $this->contractType[$professor->contract_type];
			$this->fillObjectBody($professor, "professor_", "add_professor");
		}

		$obj = new stdClass();
		$obj->total_de = $total['de'];
		$obj->total_sb = $total['sb'];
		$obj->total = $obj->total_de + $obj->total_sb;

		$obj->actives_de = $actives['de'];
		$obj->actives_sb = $actives['sb'];
		$obj->actives = $obj->actives_de + $obj->actives_sb;

		$this->fillObjectBody($obj, "professor_count_");
	}

	public function saved() {
		$this->saved = true;
	}

	protected function alertMessage() {
		if ($this->saved) {
			return "Professores ativos atualizados com sucesso.";
		}
		return null;
	}

	protected function fillBody($form = true) { // assinatura compativel com VC (PHP 8)
		parent::fillBody(true);
	}

	protected function getTitle() {
		return "Manter Professores";
	}
}