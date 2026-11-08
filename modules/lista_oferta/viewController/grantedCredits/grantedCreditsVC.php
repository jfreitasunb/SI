<?php

require_once $ROOT_PATH.'viewController/vc.php';
require_once $ROOT_PATH.'utils/linkUT.php';


class GrantedCreditsVC extends VC {

	const JS_GENERAL = 'general';

	private $saved = null;

	function __construct() {
		parent::__construct();

		$this->tplBody = new HTML_Template_Sigma($this->root_path.'template/grantedCredits');
		$this->tplBody->loadTemplateFile('gcMain.tpl');

		$this->useJSJQueryValidate();
		$this->useJSJQueryDataTable();
		$this->useJSJQueryUI();

		$tpl = new HTML_Template_Sigma($this->root_path.'js/pages/grantedCredits');
		$tpl->loadTemplateFile('grantedCredits.js');

		$linkJS = new stdClass();
		$linkJS->groups_activities = LinkUT::ajaxGroupsActivities();
		$linkJS->granted_credits = LinkUT::ajaxGrantedCredits();
		$linkJS->other_field_granted_credits = LinkUT::ajaxOtherFieldGrantedCredits();

		$this->fillObject($tpl, $linkJS, "url_");

		$this->tplJS[self::JS_GENERAL] = $tpl;
	}

	public function setGrantedCredits($listGrantedCredits) {
		$this->fillListBody($listGrantedCredits, "granted_credit_", "add_granted_credit");
	}

	public function setActivityGroup($activityGroup) {
		$this->fillListBody($activityGroup, "group_", "add_group");
	}

	public function setTeacherList($teacherList) {
		$this->fillListBody($teacherList, "teacher_", "add_teacher");
	}

	protected function fillBody($form = true) { // assinatura compativel com VC (PHP 8)
		parent::fillBody(false);

		$tpl = new HTML_Template_Sigma($this->root_path.'template/grantedCredits');
		$tpl->loadTemplateFile('gcAlertDelete.tpl');

		$this->addBodyToMainTemplate($tpl->get());
	}

	protected function getTitle() {
		return "Concess&atilde;o de Carga";
	}

	protected function alertMessage() {
		if ($this->saved !== null) {
			$o = $this->saved;
			return "Atribuido carga $o->credits para $o->teacher_name $o->teacher_last_name por $o->group_description.";
		}
		return null;
	}

	public function setMessage($inserted) {
		$this->saved = $inserted;
	}
}
