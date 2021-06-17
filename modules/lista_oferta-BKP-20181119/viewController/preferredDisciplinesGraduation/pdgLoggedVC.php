<?php

require_once $ROOT_PATH.'viewController/vc.php';


/**
 * A PDGLogged is the ViewController of the prefered_discipline_graduation.php when the user is logged.
 * @author Phelippe Amorim <amorim.phelippe@gmail.com>
 * @package si_lo
 */
class PDGLoggedVC extends VC {

	private $message = 0;

	function __construct() {
		parent::__construct();

		$this->tplBody = new HTML_Template_Sigma($this->root_path.'template/preferredDisciplinesGraduation');
		$this->tplBody->loadTemplateFile('pdgLogged.tpl');

		$this->useCSS("preferredDisciplinesGraduation/pdgLogged.css");

		$this->useJSJQuery();
		$this->useJSJQueryValidate();
		$this->useJSJQueryDataTable();
		$this->useJS("pages/external/preferredDisciplinesGraduation/pdgLogged.js");
	}

	/**
	 * Fill list of disciplines on template
	 * @param array $listDisciplines
	 * @param array $listDisciplinesChosen
	 */
	public function fillDisciplines($listDisciplines, $listDisciplinesChosen = NULL) {
		GLOBAL $QUANTITY_PREFERRED_DISCIPLINE, $DEFAULT_DISCIPLINE_SELECTED_QUANTITY;

		for ($i = 0; $i < $QUANTITY_PREFERRED_DISCIPLINE; $i++) {
			$obj = new stdClass();
			$obj->number = $i + 1;
			$obj->quantity = $DEFAULT_DISCIPLINE_SELECTED_QUANTITY;

			foreach ($listDisciplines as $discipline) {
				if (count($listDisciplinesChosen)) {
					if (!strcmp($listDisciplinesChosen[$i]->discipline, $discipline->discipline) &&
						!strcmp($listDisciplinesChosen[$i]->period, $discipline->period)) {
						$this->tplBody->touchBlock("exist_lo_temp_selected");
					}
					$obj->quantity = $listDisciplinesChosen[$i]->quantity;
				}
				$this->fillObjectBody($discipline, "lo_temp_", "add_lo_temp");
			}
			if ($i > 0) {
				$this->tplBody->touchBlock("quantity_is_hidden");
			}
			$this->fillObjectBody($obj, "option_", "add_option");
		}
	}

	public function setGrantedCredits($listGrantedCredits) {
		if (count($listGrantedCredits)) {
			$total = 0;
			for ($i = 0; $i < count($listGrantedCredits); $i++) {
				$grantedCredits = $listGrantedCredits[$i];

				$total += $grantedCredits->credits;

				if ($i == count($listGrantedCredits) - 1) {
					$grantedCredits->total = $total;
				}
				$this->fillObjectBody($grantedCredits, "granted_credit_", "add_granted_credit");
			}
		}
	}

	protected function fillBody() {
		$form = new stdClass();
		$form->id = "disciplines_form";

		parent::fillBody($form);

		$tpl = new HTML_Template_Sigma($this->root_path.'template/preferredDisciplinesGraduation');
		$tpl->loadTemplateFile('pdgLogged_2.tpl');

		$this->addBodyToMainTemplate($tpl->get());
	}

	protected function getTitle() {
		return array("Escolha de Disciplinas", "Carga Media ".$this->semester->average_credits);
	}

	protected function alertMessage() {
		if ($this->message == 1) {
			return "Escolhas de disciplinas salvas com sucesso.";
		} elseif ($this->message == 2) {
			return "Não foi possível salvar pois suas escolhas repetiram opções.";
		}
		return null;
	}

	public function setSaved() {
		$this->message = 1;
	}

	public function setError() {
		$this->message = 2;
	}
}
