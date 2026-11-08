<?php

require_once $ROOT_PATH.'viewController/vc.php';
require_once $ROOT_PATH.'utils/linkUT.php';


class MAListVC extends VC {

	function __construct() {
		parent::__construct();

		GLOBAL $ROOT_PATH;

		$this->tplBody = new HTML_Template_Sigma($ROOT_PATH . 'template/maintainActivities');
		$this->tplBody->loadTemplateFile('maList.tpl');

		$this->useJSJQueryDataTable();
		$this->useJS('pages/maintainActivities/maList.js');

		$links = new stdClass();
		$links->new_activity = LinkUT::activitiesEdit("");
		$this->fillObjectBody($links, "link_");
	}

	public function fillActivitiesList($activitiesList) {
		foreach($activitiesList as $activity) {
			$activity2 = clone $activity;
			$activity2->link_edit = LinkUT::activitiesEdit($activity->id);

			$this->fillObjectBody($activity2, "activity_", "add_activity");
		}
	}

	protected function fillBody() {
		parent::fillBody(NULL);
	}

	protected function getTitle() {
		return "Manter Atividades";
	}
}