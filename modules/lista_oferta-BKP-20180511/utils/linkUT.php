<?php

class LinkUT {
	static private function root() {
		GLOBAL $ROOT;
		return $ROOT;
	}

	static public function ajaxAlterClassTemporary() {
		return self::root()."ajax/alterClassTemporary.php";
	}

	static public function ajaxValidatePassword() {
		return self::root()."ajax/validatePassword.php";
	}

	static public function ajaxGroupsActivities() {
		return self::root()."ajax/groupsActivities.php";
	}

	static public function ajaxGrantedCredits() {
		return self::root()."ajax/grantedCredits.php";
	}

	static public function ajaxProfessorClassTemporary() {
		return self::root()."ajax/professorClassTemporary.php";
	}

	static public function ajaxOtherFieldGrantedCredits() {
		return self::root()."ajax/otherFieldGrantedCredits.php";
	}

	static public function scriptOfferList() {
		return self::root()."scripts/offerListScript.php";
	}





	static public function activityListCSV() {
		return self::twoStepsLink("activity_list")."?csv";
	}

	static public function courseList() {
		return self::courseEdit();
	}

	static public function courseEdit($courseID = null) {
		return self::twoStepsLink("maintain_course", $courseID);
	}

	static public function activitiesList() {
		return self::activitiesEdit();
	}

	static public function maintainSemester() {
		return self::twoStepsLink("maintain_semester");
	}

	static public function activitiesEdit($courseID = null) {
		return self::twoStepsLink("maintain_activities", $courseID);
	}

	static private function twoStepsLink($name, $id = null) {
		$suffix = "";
		if (isset($id)) {
			$suffix = "?id";

			if (strlen($id)) {
				$suffix .= "=$id";
			}
		}
		return self::root()."$name.php".$suffix;
	}
}