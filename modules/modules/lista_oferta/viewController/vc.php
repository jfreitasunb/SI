<?php

require_once 'HTML/Template/Sigma.php';


/**
 * A VC is a abstract class to be implemented by ViewControllers.
 * @author Phelippe Amorim <amorim.phelippe@gmail.com>
 * @package si_lo
 */
abstract class VC {
	/**
	 * @var string
	 */
	protected $root;

	/**
	 * @var string
	 */
	protected $root_path;

	/**
	 * @var string
	 */
	protected $root_main;

	/**
	 * @var HTML_Template_Sigma
	 */
	protected $tplBody;

	/**
	 * @var HTML_Template_Sigma
	 */
	private $tplMain;

	/**
	 * @var HTML_Template_Sigma
	 */
	protected $tplAlert;

	/**
	 * @var SemesterTO
	 */
	protected $semester = null;

	/**
	 * @var array
	 */
	private $css;

	/**
	 * @var array
	 */
	protected $tplJS;

	/**
	 * @var array
	 */
	private $externalJS;




	function __construct() {
		GLOBAL $ROOT, $ROOT_PATH, $ROOT_MAIN;

		$this->root = $ROOT;
		$this->root_path = $ROOT_PATH;
		$this->root_main = $ROOT_MAIN;

		$this->css = Array();
		$this->tplJS = Array();
		$this->externalJS = Array();

		$this->tplMain = new HTML_Template_Sigma($this->root_path.'template/header_footer');
		$this->tplMain->loadTemplateFile('main.tpl');

		$this->useCSS($this->root_main."global/gra"."fic.css", FALSE);
		$this->useCSS("generic.css");
	}

	/**
	 * Fill body template with objects array
	 * @param array $list
	 * @param string $prefix
	 * @param string $parse
	 * @param stdClass $objectMaster
	 * @param string $prefixMaster
	 * @param string $parseMaster
	 */
	protected function fillListBody($list, $prefix = "", $parse = null, $objectMaster = null, $prefixMaster = "", $parseMaster = null) {
		$this->fillList($this->tplBody, $list, $prefix, $parse, $objectMaster, $prefixMaster, $parseMaster);
	}

	/**
	 * Fill body template with object
	 * @param stdClass $obj
	 * @param string $prefix
	 * @param string $parse
	 */
	protected function fillObjectBody($obj, $prefix = "", $parse = null) {
		$this->fillObject($this->tplBody, $obj, $prefix, $parse);
	}

	/**
	 * Fill template with objects array
	 * @param HTML_Template_Sigma $tpl
	 * @param array $list
	 * @param string $prefix
	 * @param string $parse
	 * @param stdClass $objectMaster
	 * @param string $prefixMaster
	 * @param string $parseMaster
	 */
	protected function fillList($tpl, $list, $prefix = "", $parse = null, $objectMaster = null, $prefixMaster = "", $parseMaster = null) {
		foreach($list as $obj) {
			$this->fillObject($tpl, $obj, $prefix, $parse);
		}
		if($objectMaster !== null) {
			$this->fillObject($tpl, $objectMaster, $prefixMaster, $parseMaster);
		}
	}

	/**
	 * Fill template with object
	 * @param HTML_Template_Sigma $tpl
	 * @param stdClass $obj
	 * @param string $prefix
	 * @param string $parse
	 */
	protected function fillObject($tpl, $obj, $prefix = "", $parse = null) {
		if($obj !== null) {
			foreach($obj as $name => $value) {
				$tpl->setVariable(array(
					$prefix.$name  => $value
				));
			}
			if(strlen($parse)) {
				$tpl->parse($parse);
			}
		}
	}

	/**
	 * Insert template on main template and show
	 */
	public function close()
	{
		$this->fillBody();

		if (count($this->tplJS)) {
			foreach ($this->tplJS as $tjs) {
				$this->tplMain->setVariable(array(
					'cod'.'igo_js' => $tjs->get()
				));
				$this->tplMain->parse('add_js');
			}
		}

		if (count($this->externalJS)) {
			foreach ($this->externalJS as $ejs) {
				$this->tplMain->setVariable(array(
					'external_js' => $ejs
				));
				$this->tplMain->parse('add_external_js');
			}
		}

		if (count($this->css)) {
			foreach ($this->css as $css) {
				$this->tplMain->setVariable(array(
					'css' => $css
				));
				$this->tplMain->parse('add_css');
			}
		}

		$this->tplMain->setVariable(array(
			'ROOT'  => $this->root,
			'ROOT_MAIN'  => $this->root_main,
			'page_title'  => $this->getTitle(),
		));

		$this->tplMain->show();
	}

	/**
	 * Set semester for exhibition on title
	 * @param SemesterTO $semester
	 */
	public function setSemester($semester) {
		$this->semester = $semester;
	}

	/**
	 * Get semester object as string
	 * @return string
	 */
	protected function getSemesterAsString() {
		return $this->semester->year."/".$this->semester->semester;
	}

	/**
	 * Get table template
	 * @param mixed $form
	 * @return HTML_Template_Sigma
	 */
	protected function getTableTPL($form = null) {
		$tpl = new HTML_Template_Sigma($this->root_path.'template/header_footer');
		$tpl->loadTemplateFile('table_body.tpl');

		if ($form !== null && $form !== false) {
			$validate = new stdClass();
			if (is_array($form)) {
				if (!isset($form['method'])) {
					$form['method'] = 'POST';
				}
				if (isset($form['id'])) {
					$validate->id = $form['id'];
				}
			} else if (is_object($form)) {
				if (!isset($form->method)) {
					$form->method = 'POST';
				}
				if (isset($form->id)) {
					$validate->id = $form->id;
				}
			} else {
				$form = array();
				$form['method'] = 'POST';
			}
			$this->fillObject($tpl, $form, "form_");
			$tpl->touchBlock("exist_form");

//			if (isset($validate->id)) {
//				$tpl_form_validate = new HTML_Template_Sigma($this->root_path.'js');
//				$tpl_form_validate->loadTemplateFile('formValidate.js');
//				$this->fillObject($tpl_form_validate, $validate, "validate_");
//
//				$this->tplJS[] = $tpl_form_validate;
//			}
		}

		$h1 = $this->getTitle();
		if ($this->semester !== null) {
			$h1 .= " - ".$this->getSemesterAsString();
		}

		$tpl->setVariable(array(
			'h1'  => $h1
		));

		if (($backURL = $this->getBackURL()) !== null) {
			$tpl->setVariable(array(
				'url_navigation_back'  => $backURL
			));
		}

		return $tpl;
	}

	/**
	 * Function where the body is filled
	 * @param bool $form
	 */
	protected function fillBody($form = true) {
		$tplTable = $this->getTableTPL($form);

		$tplTable->setVariable(array(
			'table_body'  => $this->tplBody->get()
		));

		$this->addBodyToMainTemplate($tplTable->get());

		if (strlen($this->alertMessage())) {
			$this->useJSJQueryUI();

			$tpl = new HTML_Template_Sigma($this->root_path.'template/header_footer');
			$tpl->loadTemplateFile('alert.tpl');

			$tpl->setVariable(array(
				'message'  => $this->alertMessage()
			));

			$this->addBodyToMainTemplate($tpl->get());
		}
	}

	protected function addBodyToMainTemplate($block) {
		$this->tplMain->setVariable(array(
			'body'  => $block
		));
		$this->tplMain->parse('add_body');
	}

	private function hasJS($js) {
		if (in_array($js, $this->externalJS)) {
			return true;
		}
		return false;
	}

	protected function useJS($js) {
		$js = $this->root."js/".$js;
		if (!$this->hasJS($js)) {
			$this->externalJS[] = $js;
		}
	}

	/**
	 * Add Lib JS
	 * @param string $libJS Name of file lib
	 */
	private function useLibJS($libJS) {
		$this->useJS("lib/".$libJS);
	}

	protected function useJSJQuery() {
		$this->useLibJS("jquery-1.11.3.js");
	}

	protected function useJSJQueryValidate() {
		$this->useJSJQuery();
		$this->useLibJS("jquery-validate.js");
		$this->useJS("messagesValidate.js");
	}

	protected function useJSJQueryUI() {
		$this->useJSJQuery();
		$this->useLibJS("jquery-ui.js");
		$this->useCSS("js/jquery-ui.css");
	}

	protected function useJSJQueryUIDatepicker() {
		$this->useJSJQueryUI();
		$this->useLibJS("jquery-ui-date"."picker-pt-BR.js");
	}

	protected function useJSJQueryDataTable() {
		$this->useJSJQuery();
		$this->useLibJS("jquery-data"."table.js");
		$this->useCSS("js/jquery-data"."table.css");
	}

	private function hasCSS($css, $rootPathCSS = TRUE) {
		if ($rootPathCSS && in_array($this->root."css/".$css, $this->css) ||
			!$rootPathCSS && in_array($css, $this->css)) {
			return true;
		}
		return false;
	}

	protected function useCSS($css, $rootPathCSS = TRUE) {
		if (!$this->hasCSS($css, $rootPathCSS)) {
			if ($rootPathCSS) {
				$this->css[] = $this->root."css/".$css;
			} else {
				$this->css[] = $css;
			}
		}
	}

	protected function alertMessage() {
		return null;
	}

	protected function getBackURL() {
		return null;
	}
	/**
	 * Abstract get page's title
	 * @return string
	 */
	abstract protected function getTitle();
}