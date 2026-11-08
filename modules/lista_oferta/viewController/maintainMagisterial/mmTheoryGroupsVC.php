<?php

require_once $ROOT_PATH.'viewController/vc.php';

require_once $ROOT_PATH.'utils/linkUT.php';


class MMTheoryGroupsVC extends VC {

	const JS_GENERAL = 'general';

	private $discipline;

	private $classesTPL = array();

	function __construct($discipline) {
		parent::__construct();

		GLOBAL $ROOT_PATH;

		$discipline->theory_quantity /= 2;
		$this->discipline = $discipline;

		$this->tplBody = new HTML_Template_Sigma($ROOT_PATH.'template/maintainMagisterial');
		$this->tplBody->loadTemplateFile('mmTheoryGroups.tpl');

		$this->useCSS("maintainMagisterial/mmTheoryGroups.css");

		$this->useJSJQuery();
		$this->useJSJQueryUI();

		$tpl = new HTML_Template_Sigma($this->root_path.'js/pages/maintainMagisterial');
		$tpl->loadTemplateFile('mmTheoryGroups.js');

		$linkJS = new stdClass();
		$linkJS->magisterial_theory_groups = LinkUT::ajaxMagisterialTheoryGroups();

		$this->fillObject($tpl, $linkJS, "url_");
		$this->fillObject($tpl, $discipline, "discipline_");

		$this->tplJS[self::JS_GENERAL] = $tpl;
	}

	public function setClasses($classes, $groups) {
		foreach($classes as $class) {
			$tpl = new HTML_Template_Sigma($this->root_path.'template/maintainMagisterial');
			$tpl->loadTemplateFile('mmClass.tpl');

			if(isset($groups[$class->class])) {
				$class->group = $groups[$class->class]->group;
				$class->id = $groups[$class->class]->id;
			} else {
				unset($class->id);
			}

			$this->fillObject($tpl, $class, "class_");

			$this->classesTPL[$class->class] = $tpl->get();

			$obj = new stdClass();
			$obj->class = $tpl->get();

			$this->fillObjectTemplateAsProperty($this->tplBody, $obj, "", "add_class", array("class" => true));
		}
	}

	public function setClassesGrouped($classesGrouped, $classes) {
		foreach($classesGrouped as $classesGroup) {
			$classGroup = array_values($classesGroup);
			$classGroup = $classGroup[0];
			$group = new stdClass();
			$group->group = $classGroup->group;

			$group->scheduleSelected = array();
			$selected = explode("-", $classGroup->schedule);
			foreach ($selected as $time) {
				if (strlen($time)) {
					$group->scheduleSelected[$time] = true;
				}
			}
			$group->schedule = $classes[$classGroup->class];

			foreach($classesGroup as $classGroup) {
				$classSchedule = $classes[$classGroup->class];

				foreach ($group->schedule as $time => $true) {
					if (!isset($classSchedule[$time])) {
						unset($group->schedule[$time]);
					}
				}

				$classTemplate = new stdClass();
				$classTemplate->group_class = $this->classesTPL[$classGroup->class];

				$this->fillObjectTemplateAsProperty($this->tplBody, $classTemplate, "", "add_group_class", array("group_class" => true));
			}

			if (count($group->schedule) >= $this->discipline->theory_quantity) {
				foreach ($group->schedule as $time => $true) {
					$obj = new stdClass();
					$obj->time = $time;

					if (isset($group->scheduleSelected[$time])) {
						$this->tplBody->touchBlock("time_selected");
					}
					$this->fillObjectBody($obj, "time_", "add_time");
				}
				if (count($group->scheduleSelected) < $this->discipline->theory_quantity) {
					$obj = new stdClass();
					$obj->quantity = $this->discipline->theory_quantity - count($group->scheduleSelected);
					
					$this->fillObjectBody($obj, "more_");
				} elseif (count($group->scheduleSelected) > $this->discipline->theory_quantity) {
					$obj = new stdClass();
					$obj->quantity = count($group->scheduleSelected) - $this->discipline->theory_quantity;

					$this->fillObjectBody($obj, "less_");
				}
			} else {
				$this->tplBody->touchBlock("time_error");
			}

			$this->fillObjectBody($group, "group_", "add_group");
		}
	}

	function fillBody($form = true) {
		parent::fillBody(false);
	}

	protected function getBackURL() {
		return LinkUT::magisterialDiscipline();
	}

	protected function getTitle() {
		return "Agrupamento de Teoria - ".$this->discipline->name;
	}
}