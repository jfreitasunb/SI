<?php

require_once $ROOT_PATH.'viewController/vc.php';
require_once $ROOT_PATH.'utils/linkUT.php';


class MAEditVC extends VC {

	const JS_GENERAL = 'general';

	private $activity;

	function __construct() {
		parent::__construct();

		GLOBAL $ROOT_PATH;

		$this->tplBody = new HTML_Template_Sigma($ROOT_PATH . 'template/maintainActivities');
		$this->tplBody->loadTemplateFile('maEdit.tpl');

		$this->useJSJQueryValidate();
		$this->useJS('pages/maintainActivities/maEdit.js');
	}

	public function fillActivity($activity) {
		$this->fillObjectBody($activity, "activity_");
		$this->activity = $activity;
	}

	public function fillGroup($groupList) {
		foreach($groupList as $group) {
			if ($this->activity != null && !strcmp($this->activity->group_key, $group->short_value)) {
				$this->tplBody->touchBlock("group_selected");
			}
			$this->fillObjectBody($group, "group_", "add_group");
		}
	}

	protected function fillBody() {
		$form = new stdClass();
		$form->id = "activity_form";
		$form->action = LinkUT::activitiesList();

		parent::fillBody($form);
	}

	protected function getBackURL() {
		return LinkUT::activitiesList();
	}

	protected function getTitle() {
		return "Manter Atividades";
	}
}