<?php

require_once $ROOT_PATH.'viewController/vc.php';
require_once $ROOT_PATH.'utils/linkUT.php';


class MCListVC extends VC {

	private $message = 0;
	private $discipline = null;

	function __construct() {
		parent::__construct();

		GLOBAL $ROOT_PATH;

		$this->tplBody = new HTML_Template_Sigma($ROOT_PATH . 'template/maintainCourse');
		$this->tplBody->loadTemplateFile('mcList.tpl');

		$this->useJSJQueryDataTable();
		$this->useJS('pages/maintainCourse/mcList.js');
	}

	public function fillCoursesList($courseList) {
		foreach($courseList as $course) {
			$course2 = clone $course;
			$course2->link_edit = LinkUT::courseEdit($course->id);

			$this->fillObjectBody($course2, "course_", "add_course");
		}
	}

	protected function fillBody() {
		parent::fillBody(null);

		$tpl2 = & new HTML_Template_Sigma($this->root_path.'template/maintainCourse');
		$tpl2->loadTemplateFile('mcList_2.tpl');

		$links = new stdClass();
		$links->new_course = LinkUT::courseEdit("");

		$this->fillObject($tpl2, $links, "link_");

		$this->addBodyToMainTemplate($tpl2->get());
	}

	protected function getTitle() {
		return "Manter Disciplinas";
	}

	protected function alertMessage() {
		$d = $this->discipline;
		if ($this->message == 1) {
			return "Disciplina $d->name inserida com sucesso.";
		} elseif ($this->message == 2) {
			return "Disciplina $d->name atualizada com sucesso.";
		}
		return null;
	}

	public function setDiscipline($discipline, $update = false) {
		$this->discipline = $discipline;

		if ($update) {
			$this->message = 2;
		} else {
			$this->message = 1;
		}
	}
}