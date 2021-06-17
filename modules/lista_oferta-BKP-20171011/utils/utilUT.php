<?php

class UtilUT {
	/**
	 * @param $list array
	 * @param $key String
	 * @return array
	 */
	static public function changeKey($list, $key = "id") {
		$return = array();
		foreach ($list as $object) {
			$return[$object->$key] = $object;
		}
		return $return;
	}

	/**
	 * @param $data
	 * @param $key String
	 * @return array
	 */
	static public function data($data, $key = "id") {
		$return = $data;
		if (is_array($data))
			$return = $data[$key];
		elseif (is_object($data))
			$return = $data->$key;
		return $return;
	}

	/**
	 * @param $method array
	 * @param $values array
	 * @return stdClass
	 */
	static public function postToObject($method, $values) {
		$obj = new stdClass();
		foreach($values as $key) {
			if (isset($method[$key]) && strlen($method[$key]) > 0) {
				$obj->$key = $method[$key];
			} else {
				$obj->$key = null;
			}
		}

		return $obj;
	}

	/**
	 * @param $date string Data que está no formato YYYY-MM-DD
	 * @return string Data formatada para DD/MM/YYYY
	 */
	static public function convertDateToBR($date) {
		$parts = explode("-", $date);
		return $parts[2]."/".$parts[1]."/".$parts[0];
	}

	/**
	 * @param $date string Data que está no formato DD/MM/YYYY
	 * @return string Data formatada para YYYY-MM-DD
	 */
	static public function convertDateToSQL($date) {
		$parts = explode("/", $date);
		return $parts[2]."-".$parts[1]."-".$parts[0];
	}
}