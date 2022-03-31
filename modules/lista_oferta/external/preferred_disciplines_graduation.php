<?php
require_once dirname(__FILE__).'/../conf/default.php';

require_once $ROOT_PATH.'modelController/semesterMC.php';
require_once $ROOT_PATH.'modelController/professorMC.php';

$semesterMC = new SemesterMC();
$semester = $semesterMC->last();

session_start();

if ($_POST && isset($_POST['logout'])) {
	session_unset();
	session_destroy();
}

$vc = NULL;
if (strcmp($semester->status, SemesterDAO::STATUS_STAGE_2) == 0 || strcmp($semester->status, SemesterDAO::STATUS_CLOSED) == 0) {
	if (!isset($_SESSION["user"]) && $_POST && isset($_POST['login']) && isset($_POST['password'])) {
		require_once $ROOT_PATH.'modelController/unixMC.php';

		$password = $_POST['password'];

		$unixMC = new UnixMC();
		$unixUser = $unixMC->getEmployeeByLogin($_POST['login']);

		if ($ENCRYPTED_PASSWORDS) {
			$password = crypt($password, $unixUser->password);
		}

		if (!strcmp($password, $unixUser->password)) {

			$professorMC = new ProfessorMC();
			$professor = $professorMC->get($unixUser->user_id);

			$unixUser->type2 = isset($professor->type) ? $professor->type : "";
			$unixUser->status = isset($professor->status) ? $professor->status : "";

			$_SESSION["user"] = serialize($unixUser);
		}
	}

	if (!isset($_SESSION["user"])) {
		require_once $ROOT_PATH.'viewController/preferredDisciplinesGraduation/pdgNotLoggedInVC.php';

		$vc = new PDGNotLoggedInVC();
		$vc->setSemester($semester);
	} else{
		$user = unserialize($_SESSION["user"]);
		 //p($user);

		if (strcmp($user->type2, ProfessorDAO::TYPE_PROFESSOR) == 0 && strcmp($user->status, DAO::ACTIVE) == 0) {
			if (strcmp($semester->status, SemesterDAO::STATUS_STAGE_2) == 0) {
				require_once $ROOT_PATH.'viewController/preferredDisciplinesGraduation/pdgLoggedVC.php';
				require_once $ROOT_PATH.'modelController/preferredDisciplinesGraduationMC.php';
				require_once $ROOT_PATH.'modelController/offerListTemporaryMC.php';
				require_once $ROOT_PATH.'modelController/grantedCreditsMC.php';
				require_once $ROOT_PATH.'utils/magisterialUT.php';

				$vc = new pdgLoggedVC();

				$pdgMC = new PreferredDisciplinesGraduationMC();
				$listPDG = $pdgMC->getUserSemester($user, $semester);

				$chosen = array();
				$valid = true;
				if ($_POST && isset($_POST['alter_disciplines'])) {
					$preferred = array();
					foreach ($_POST as $key => $value) {
						if(strpos($key, "discipline_") !== false && strpos($key, "discipline_") == 0) {
							$key_2 = substr($key, 11);

							if (!isset($preferred[$key_2])) {
								$preferred[$key_2] = new stdClass();
							}
							$split = explode("-", $value);

							if (isset($chosen[$value])) {
								$valid = false;
								break;
							}
							$chosen[$value] = true;

							$preferred[$key_2]->discipline = $split[1];
							$preferred[$key_2]->period = $split[0];

							if (count($split) > 2) {
								$preferred[$key_2]->type = $split[2];
							} else {
								$preferred[$key_2]->type = null;
							}
						} else if (strpos($key, "quantity_") !== false && strpos($key, "quantity_") == 0) {
							$key_2 = substr($key, 9);
							if (!isset($preferred[$key_2])) {
								$preferred[$key_2] = new stdClass();
							}
							if ($key_2 == 1) {
								$preferred[$key_2]->quantity = $value;
							} else {
								$preferred[$key_2]->quantity = 1;
							}
						}
					}
					if ($valid) {
						$pdgMC->changeUserSemester($preferred, $user, $semester, $listPDG);
						$listPDG = $pdgMC->getUserSemester($user, $semester);

						$vc->setSaved();
					} else {
						$vc->setError();
					}

				}
				$oltMC = new OfferListTemporaryMC();
				$listLOTemp = $oltMC->getListDistinctDisciplines($semester);

				$listLOTemp = MagisterialUT::modifyListDisciplines($listLOTemp);

				$listPDG = MagisterialUT::adjustPreferredDisciplines($listPDG);

				$grantedCreditsMC = new GrantedCreditsMC();
				$listGrantedCredits = $grantedCreditsMC->listBySemesterProfessor($semester, $user->user_id);
				$grantedCreditsMC->completeActivityDescription($listGrantedCredits);

				$vc->setSemester($semester);
				$vc->fillDisciplines($listLOTemp, $listPDG);
				$vc->setGrantedCredits($listGrantedCredits);
			} else {
				//Semestre fechado. Exibir agenda do professor
				require_once $ROOT_PATH.'viewController/preferredDisciplinesGraduation/pdgScheduleVC.php';

				require_once $ROOT_PATH.'processing/professorPR.php';

				$listProfessors = ProfessorPR::activeProfessorsWithCredits($semester);

				$professor = $listProfessors[$user->user_id];

				$vc = new PDGScheduleVC();
				$vc->fillScheduleOfProfessor($professor);
			}
		} else {
			require_once $ROOT_PATH . 'viewController/genericMessageVC.php';

			$vc = new GenericMessageVC();
			$vc->setTitle("Lista de oferta do MAT/UnB");
			$vc->message("Usuário $user->login não tem autorização para acesso.");

			session_unset();
			session_destroy();
		}
	}
} else {
	require_once $ROOT_PATH . 'viewController/genericMessageVC.php';

	$vc = new GenericMessageVC();
	$vc->setTitle("Lista de oferta do MAT/UnB");
	$vc->message("Seleção de disciplinas não está disponível.");
}

$vc->close();
?>
