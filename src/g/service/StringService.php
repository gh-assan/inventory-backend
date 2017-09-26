<?php

namespace g\service;

class StringService {
	
	// return a string with front and back spaces removed and encodes HTML chars
	public static function sanitize($data) {
		
		if (is_array($data) ) {
			foreach ($data as $key => $value) {
				$data[$key]= self::sanitize($value);
			}
		}	
		else if (is_object($data) ) {
			foreach ($data as $key => $value) {
				$data->$key= self::sanitize($value);
			}
		}else{		
			$data = trim($data);
			$data = htmlspecialchars($data, ENT_QUOTES);
		}
		return $data;
	}
	
	public function is_empty($str){
		
		$result = true;		
		
		
		if (is_array($str) ) {
			foreach ($str as $key => $value) {
				$result = $result && $this->is_empty($value);
			}
		}
		else if (isset($str) && (string) $str !== '') {
			// variable set, not empty string, not falsy
			$result =  false;
		}
				
		return $result;
	}
	
}