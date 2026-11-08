<?php

require_once $ROOT_PATH.'viewController/vc.php';


class PDGScheduleVC extends VC {

	private $selectedProfessor;

	function __construct() {
		parent::__construct();

		$this->tplBody = new HTML_Template_Sigma($this->root_path.'template/preferredDisciplinesGraduation');
		$this->tplBody->loadTemplateFile('pdgSchedule.tpl');

		$this->useCSS("preferredDisciplinesGraduation/pdgSchedule.css");
	}

	public function fillScheduleOfProfessor($professor) {
		$this->selectedProfessor = $professor;

		$next = true;
		$scheduleTable = array();

		// Criação da tabela de horários
		for ($day = 2; $day < 8; $day++) { 
			for ($time = 8; $time < 23; $time++) {
				$timeDesc = (int)sprintf("%d%'.02d", $day, $time);
				if (isset($professor->schedule[$timeDesc]) && $classID = $professor->schedule[$timeDesc]) {
					$scheduleTable[$day][$time] = $professor->classes[$classID]->discipline_name . " " . $professor->classes[$classID]->class;
						$next = false;
				} else {
					if ($next) {
						$scheduleTable[$day][$time] = "";
					} else {
						$next = true;
					}
				}
			}
		}

		for ($time = 8; $time < 23; $time++) {
			$obj = new stdClass();
			$obj->value = sprintf("%'.02d:00", $time);;

			$this->fillObjectBody($obj, "schedule_cell_", "add_schedule_cell");

			for ($day = 2; $day < 8; $day++) {
				if (isset($scheduleTable[$day][$time])) {
					if (strlen($scheduleTable[$day][$time]) > 1) {
						$this->tplBody->touchBlock("schedule_cell_real");
					}
					$obj = new stdClass();
					$obj->value = $scheduleTable[$day][$time];

					$this->fillObjectBody($obj, "schedule_cell_", "add_schedule_cell");
				}
			}
			$this->tplBody->parse("add_schedule_row");
		}
	}

	protected function fillBody($form = true) { // assinatura compativel com VC (PHP 8)
		parent::fillBody(false);
	}

	protected function getTitle() {
		return array("Agenda Professor", $this->selectedProfessor->name." ".$this->selectedProfessor->last_name);
	}
}