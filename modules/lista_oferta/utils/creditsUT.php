<?php

require_once $ROOT_PATH.'modelController/grantedCreditsMC.php';
require_once $ROOT_PATH.'modelController/offerListTemporaryMC.php';

require_once $ROOT_PATH.'utils/magisterialUT.php';

class CreditsUT {
	static public function listProfessorsCredits($semester) {
		$grantedCreditsMC = new GrantedCreditsMC();
		$listGrantedCredits = $grantedCreditsMC->listBySemester($semester);

		$return = array();
		foreach ($listGrantedCredits as $grantedCredits) {
			if (!isset($return[$grantedCredits->teacher])) {
				$return[$grantedCredits->teacher] = new stdClass();
				$return[$grantedCredits->teacher]->extra = 0;
				$return[$grantedCredits->teacher]->graduation = 0;
				$return[$grantedCredits->teacher]->post = 0;
			}
			if ($grantedCredits->activity_id == GrantedCreditsDAO::ACTIVITY_POST_CLASS ||
				$grantedCredits->activity_id == GrantedCreditsDAO::ACTIVITY_POST_ORIENTATION_MASTERS ||
				$grantedCredits->activity_id == GrantedCreditsDAO::ACTIVITY_POST_ORIENTATION_PHD) {
				$return[$grantedCredits->teacher]->post += $grantedCredits->credits;
			} else {
				$return[$grantedCredits->teacher]->extra += $grantedCredits->credits;
			}
		}

		$oltMC = new OfferListTemporaryMC();
		$tempOfferList = $oltMC->getListWithDisciplineOfSemesterAndDiscipline($semester);
		$tempOfferList = MagisterialUT::adjustClassList($tempOfferList);
		foreach ($tempOfferList as $tempClass) {
			if (strlen($tempClass->professor)) {
				if (!isset($return[$tempClass->professor])) {
					$return[$tempClass->professor] = new stdClass();
					$return[$tempClass->professor]->extra = 0;
					$return[$tempClass->professor]->graduation = 0;
					$return[$tempClass->professor]->post = 0;
				}
				$return[$tempClass->professor]->graduation += $tempClass->discipline_credits;
			}
		}

		return $return;
	}


	static public function creditsOfProfessorAtSemester($professor, $semester) {
		$grantedCreditsMC = new GrantedCreditsMC();
		$gcList = $grantedCreditsMC->listBySemesterProfessor($semester, $professor);

		$credits = new stdClass();

		$credits->class = MagisterialUT::creditsOfProfessorAtSemester($professor, $semester);

		if (count($gcList)) {
			foreach ($gcList as $value) {
				if ($value->activity_id == GrantedCreditsDAO::ACTIVITY_POST_CLASS ||
					$value->activity_id == GrantedCreditsDAO::ACTIVITY_POST_ORIENTATION_MASTERS ||
					$value->activity_id == GrantedCreditsDAO::ACTIVITY_POST_ORIENTATION_PHD) {
					$credits->class += $value->credits;
				} else {
					$credits->all += $value->credits;
				}
			}
		}

		$oltMC = new OfferListTemporaryMC();
		$oltList = $oltMC->listBySemesterProfessor($semester, $professor);

		if (count($oltList)) {
			foreach ($oltList as $tempClass) {
				$credits->class += $tempClass->discipline_credits;
			}
		}

		$credits->all += $credits->class;

		return $credits;
	}
}