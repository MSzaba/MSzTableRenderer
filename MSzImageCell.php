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
				throw new Exception('MSzImageCell | Column parameters must be an array!');
			}
			foreach ($parameters as $parameterName => $value) {
				if (!in_array($parameterName, self::$availableParameterList)) {
					throw new Exception('MSzImageCell | Invalid Column parameter: ' . $parameterName);
				}
				if (strcmp($parameterName, self::HEIGHT) === 0) {
					if (!isset($value)) {
						throw new Exception('MSzImageCell | HEIGHT parameter is set, vut the value is empty!');
					}
					if (!is_integer($value)) {
						throw new Exception('MSzImageCell | Invalid HEIGHT parameter type!');
					}
					if ($value <= 0) {
						throw new Exception('MSzImageCell | To small HEIGHT parameter!');
					}
				}
				if (strcmp($parameterName, self::WIDTH) === 0) {
					if (!isset($value)) {
						throw new Exception('MSzImageCell | WIDTH parameter is set, vut the value is empty!');
					}
					if (!is_integer($value)) {
						throw new Exception('MSzImageCell | Invalid WIDTH parameter type!');
					}
					if ($value <= 0) {
						throw new Exception('MSzImageCell | To small WIDTH parameter!');
					}
				}
				if (strcmp($parameterName, self::CROSSORIGIN) === 0) {
					if (!isset($value)) {
						throw new Exception('MSzImageCell | CROSSORIGIN parameter is set, vut the value is empty!');
					}
					if (!is_bool($value)) {
						throw new Exception('MSzImageCell | Invalid CROSSORIGIN parameter type!');
					}
				}
			}
			
			$this->parameters = $parameters;
		} 
	}

	public function validate($value) {
		return isset($value) && is_string($value);
	}

	public function render($value, $secondaryValue  = NULL, $style = null) {
		
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
			$styleToPrint = "";
			if (isset($style)) {
				$styleToPrint = " " . $style . " ";
			}
			$crossorigin = '';
			if (isset($this->parameters[self::CROSSORIGIN]) && $this->parameters[self::CROSSORIGIN]) {
				$crossorigin = ' crossorigin="anonymous"  ';
			}
				return '<img src="'. $retVal .'"'. $height . $width . $crossorigin . $styleToPrint . ' >';
			
		} else {
			return "N/A";
		}
			
			
		
		

	}
	public function getSecondaryParameterId() {
		return null;
	}
}

?>