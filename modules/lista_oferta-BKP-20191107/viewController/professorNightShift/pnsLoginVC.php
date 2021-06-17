<?php

require_once $ROOT_PATH.'viewController/vc.php';


class PNSLoginVC extends VC {

	const JS_GENERAL = 'general';

	function __construct() {
		parent::__construct();

		GLOBAL $ROOT_PATH;

		$this->tplBody = new HTML_Template_Sigma($ROOT_PATH.'template');
		$this->tplBody->loadTemplateFile('login.tpl');
	}

	protected function getTitle() {
		return "Atuação no Noturno";
	}
}