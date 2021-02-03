<?php
if (!defined("__ALLOW_INCLUDE__")) {
		exit("Obsolete content");
}
require_once(__DIR__ . "/MSzCell.php");
class MSzURLCell  implements MSzCell {
	public const PREFIX = "PREFIX";

	private $editable;
	private $parameters;
	private static $availableParameterList = [self::PREFIX, MSzCell::SECONDARY_PARAMETER];

	public function __construct($editable, $parameters = null) {

		if (isset($parameters)) {
			if (!is_array($parameters)) {
				throw new Exception('MSzURLCell | Column parameters must be an array!');
			}
			foreach ($parameters as $parameterName => $value) {
				if (!in_array($parameterName, self::$availableParameterList)) {
					throw new Exception('MSzURLCell | Invalid Column parameter: ' . $parameterName);
				}
			}
			if (!array_key_exists (self::PREFIX, $parameters)) {
				throw new Exception('MSzURLCell | PREFIX parameter is not set!');
			}
			
			if (filter_var($parameters[self::PREFIX], FILTER_VALIDATE_URL) === FALSE) {
				throw new Exception('MSzURLCell | PREFIX parameter is not an URL!');
			}
			if (!array_key_exists (MSzCell::SECONDARY_PARAMETER, $parameters)) {
				throw new Exception('MSzURLCell | SECONDARY_PARAMETER parameter is not set!');
			}
			$this->parameters = $parameters;
		} else {
			throw new Exception('MSzURLCell | Parameters are not set!');
		}
	}

	public function validate($value) {
		return isset($value) && is_string($value);
	}

	public function render($value, $secondaryValue  = NULL, $style = null) {
		if (!isset($secondaryValue) || strlen($secondaryValue) === 0 ||  strcmp($secondaryValue, MSzCell::NULL) == 0) {
			throw new Exception('Invalid or missing secondary render parameter!');
		}
		if (isset($value) && strcmp($value, MSzCell::NULL) != 0 ) {
			
			$retVal1 = strip_tags(stripslashes(strval($value)));
			$retVal2 = strip_tags(stripslashes(strval($secondaryValue)));
			$styleToEnter = $style ?? "";
			
				return '<a href="'.$this->parameters[self::PREFIX] . $retVal2.'"' . $styleToEnter .'>' . $retVal1 . '</a>';
			
		} else {
			return "N/A";
		}
			
			
		
		

	}
	public function getSecondaryParameterId() {
		return $this->parameters[MSzCell::SECONDARY_PARAMETER];
	}
}

?>