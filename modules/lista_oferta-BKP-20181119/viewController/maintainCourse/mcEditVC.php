<?php

require_once $ROOT_PATH.'viewController/vc.php';
require_once $ROOT_PATH.'utils/linkUT.php';


class MCEditVC extends VC {

	const JS_GENERAL = 'general';

	function __construct() {
		parent::__construct();

		GLOBAL $ROOT_PATH;

		$this->tplBody = new HTML_Template_Sigma($ROOT_PATH . 'template/maintainCourse');
		$this->tplBody->loadTemplateFile('mcEdit.tpl');

		//$this->useJSJQuery();
		$this->useJSJQueryValidate();
		//$this->useJS('pages/maintainCourse/mcEdit.js');

		$tpl = new HTML_Template_Sigma($this->root_path.'js/pages/maintainCourse');
		$tpl->loadTemplateFile('mcEdit.js');

		$linkJS = new stdClass();
		$linkJS->validate_password = LinkUT::ajaxValidatePassword();

		$this->fillObject($tpl, $linkJS, "url_");

		$this->tplJS[self::JS_GENERAL] = $tpl;
	}

	public function fillCourse($types, $course = null) {
		$save_button = new stdClass();
		if ($course != null) {
			$this->fillObjectBody($course, "course_");
			$this->tplBody->touchBlock("is_discipline_update");

			$save_button->save_label = "Salvar";
		} else {
			$save_button->save_label = "Inserir";
		}
		$this->fillObjectBody($save_button);

		foreach($types as $type) {
			if ($course != null && !strcmp($type->short_value, $course->type_key)) {
				$this->tplBody->touchBlock("type_selected");
			}
			$this->fillObjectBody($type, "type_", "add_type");
		}
	}

	protected function fillBody() {
		$form = new stdClass();
		$form->id = "course_form";
		$form->action = LinkUT::courseList();

		parent::fillBody($form);
	}

	protected function getBackURL() {
		return LinkUT::courseList();
	}

	protected function getTitle() {
		return "Manter Disciplina";
	}
}