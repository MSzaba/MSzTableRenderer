<?php
if (!defined("__ALLOW_INCLUDE__")) {
		exit("Obsolete content");
}
require_once(__DIR__ . "/MSzCell.php");
class MSzImageCell  implements MSzCell {
	//public const PREFIX = "PREFIX";
	public const HEIGHT = "HEIGHT";
	public const WIDTH = "WIDTH";
	public const CROSSORIGIN = "CROSSORIGIN";

	private $editable;
	private $parameters;
	private static $availableParameterList = [self::HEIGHT, self::WIDTH, self::CROSSORIGIN];

	public function __construct($editable, $parameters = null) {

		if (isset($parameters)) {
			if (!is_array($parameters)) {
				throw new Exception('Column parameters must be an array!');
			}
			foreach ($parameters as $parameterName => $value) {
				if (!in_array($parameterName, self::$availableParameterList)) {
					throw new Exception('Invalid Column parameter!');
				}
				if (strcmp($parameterName, self::HEIGHT) === 0) {
					if (!isset($value)) {
						throw new Exception('HEIGHT parameter is set, vut the value is empty!');
					}
					if (!is_integer($value)) {
						throw new Exception('Invalid HEIGHT parameter type!');
					}
					if ($value <= 0) {
						throw new Exception('To small HEIGHT parameter!');
					}
				}
				if (strcmp($parameterName, self::WIDTH) === 0) {
					if (!isset($value)) {
						throw new Exception('WIDTH parameter is set, vut the value is empty!');
					}
					if (!is_integer($value)) {
						throw new Exception('Invalid WIDTH parameter type!');
					}
					if ($value <= 0) {
						throw new Exception('To small WIDTH parameter!');
					}
				}
				if (strcmp($parameterName, self::CROSSORIGIN) === 0) {
					if (!isset($value)) {
						throw new Exception('CROSSORIGIN parameter is set, vut the value is empty!');
					}
					if (!is_bool($value)) {
						throw new Exception('Invalid CROSSORIGIN parameter type!');
					}
				}
			}
			
			$this->parameters = $parameters;
		} 
	}

	public static function validate($value) {
		return isset($value) && is_string($value);
	}

	public function render($value, $secondaryValue  = NULL) {
		
		if (isset($value) && strcmp($value, MSzCell::NULL) != 0 ) {
			
			$retVal = strip_tags(stripslashes(strval($value)));
			$height = '';
			if (isset($this->parameters[self::HEIGHT])) {
				$height = ' height= "'.$this->parameters[self::HEIGHT].'px" ';
			}
			$width = '';
			if (isset($this->parameters[self::WIDTH])) {
				$width = ' width= "'.$this->parameters[self::WIDTH].'px" ';
			}
			
			$crossorigin = '';
			if (isset($this->parameters[self::CROSSORIGIN]) && $this->parameters[self::CROSSORIGIN]) {
				$crossorigin = ' crossorigin="anonymous"  ';
			}
				return '<img src="'. $retVal .'"'. $height . $width . $crossorigin . ' >';
			
		} else {
			return "N/A";
		}
			
			
		
		

	}
	public function getSecondaryParameterId() {
		return null;
	}
}

?>