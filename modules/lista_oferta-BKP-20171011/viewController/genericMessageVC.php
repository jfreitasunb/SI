<?php

require_once $ROOT_PATH . 'viewController/vc.php';


/**
 * A PDGNotLoggedIn is the ViewController of the prefered_discipline_graduation.php when user is not logged in.
 * @author Phelippe Amorim <amorim.phelippe@gmail.com>
 * @package si_lo
 */
class GenericMessageVC extends VC {

	const JS_GENERAL = 'general';

	function __construct() {
		parent::__construct();

		GLOBAL $ROOT_PATH;

		$this->tplBody = & new HTML_Template_Sigma($ROOT_PATH.'template');
		$this->tplBody->loadTemplateFile('genericMessage.tpl');
	}

	public function message($message) {
		$obj = new stdClass();
		$obj->body = $message;

		$this->fillObjectBody($obj, "message_");
	}

	protected function getTitle() {
		return "Lista de oferta do MAT/UnB";
	}
}