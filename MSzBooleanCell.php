<?php
if (!defined("__ALLOW_INCLUDE__")) {
		exit("Obsolete content");
}
require_once(__DIR__ . "/MSzCell.php");
class MSzBooleanCell  implements MSzCell {
	public const ACCEPTED_TRUE = "AT";
	public const ACCEPTED_FALSE = "AF";

	private $editable;
	public $parameters;
	private static $availableParameterList = [self::ACCEPTED_FALSE, self::ACCEPTED_TRUE];

	public function __construct($editable, $parameters = null) {
		if (!isset($editable)) {
			throw new Exception('Editable parameter is not set!');
		}
		if (!is_bool($editable)) {
			throw new Exception('Editable parameter is not a boolean!');
		}
		$this->editable = $editable;
		
		if (isset($parameters)) {
			if (!is_array($parameters)) {
				throw new Exception('Column parameters must be an array!');
			}
			foreach ($parameters as $parameterName => $value) {
				if (!in_array($parameterName, self::$availableParameterList)) {
					throw new Exception('Invalid Column parameter!');
				}
				
			}
			$this->parameters = $parameters;
			//error_log("Parameters are set: " . print_r($this->parameters, true));
		}
	}

	public function validate($value) {
		//echo "Value is boolean: " . is_bool($value)  . " value itself: " . $value ? "true" : "false" . "<BR>";
		//error_log("Value is boolean: " . is_bool($value)  . " value itself: " . $value ? "true" : "false" . "<BR>");
		$result = $this->determinateBooleanValue($value);
		if ($result === null) {
			return false;
		}
		return true;
	}

	public function render($value, $secondaryValue = NULL) {
		$readonly = "";
		if (!$this->editable) {
			$readonly = " disabled ";
		} 
		//echo "Value is boolean: " . is_bool($value)  . " value itself: " . $value ? "true" : "false";
		if ($this->determinateBooleanValue($value)) {
			//error_log("render true for value " . $value);
			return '<input type="checkbox" checked ' . $readonly . '">';
		} else {
			//error_log("render false for value " . $value);
			return '<input type="checkbox" ' . $readonly . '">';
		}
		

	}
	public function getSecondaryParameterId() {
		return null;
	}

	private function determinateBooleanValue($value) {
		if (!isset($value)) {
			return null;
		}
		//error_log("process value: " . $value);
		
		
		if (isset($this->parameters)) {

			if (isset($this->parameters[self::ACCEPTED_TRUE]) ) {
				//error_log("accepted true is set");
				$listOfTrue = $this->parameters[self::ACCEPTED_TRUE];
				
				if (in_array($value, $listOfTrue, true)) {
					//error_log("in true array: " . $value);
					return true;
				}
				
			} 
			if (isset($this->parameters[self::ACCEPTED_FALSE])) {
				//error_log("accepted false is set");
				$listOfFalse = $this->parameters[self::ACCEPTED_FALSE];
				if (in_array($value, $listOfFalse, true)) {
					//error_log("in false array: " . $value);
					//error_log("false array: " . print_r($listOfFalse, true));
					return false;
				}
			}
		}
		if (is_bool($value)) {
			//error_log("boolean: " . ($value === true ? "true" : "false"));
			return $value;
		}
		//error_log("Last boolean: " . $value ? "true" : "false");
		return $value == true;
		
	}

}