<?php
if (!defined("__ALLOW_INCLUDE__")) {
		exit("Obsolete content");
}
require_once(__DIR__ . "/MSzCell.php");
class MSzURLCell  implements MSzCell {
	public const PREFIX = "PREFIX";
	public const FIX_URL = "FIX_URL";

	private $editable;
	private $parameters;
	private static $availableParameterList = [self::PREFIX, self::FIX_URL, MSzCell::SECONDARY_PARAMETER];

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
			$prefixExists = array_key_exists (self::PREFIX, $parameters);
			$fixURLExists = array_key_exists (self::FIX_URL, $parameters);
			if (!$prefixExists && !$fixURLExists) {
				throw new Exception('MSzURLCell | PREFIX or FIX_URL parameter must be set!');
			}
			if ($prefixExists) {
				if (filter_var(utf8_decode  ($parameters[self::PREFIX]), FILTER_VALIDATE_URL) === FALSE) {
					//throw new Exception('MSzURLCell | PREFIX parameter is not an URL: ' . utf8_decode   ($parameters[self::PREFIX]));
				}
				if (!array_key_exists (MSzCell::SECONDARY_PARAMETER, $parameters)) {
					throw new Exception('MSzURLCell | SECONDARY_PARAMETER parameter is not set!');
				}
			} else {
				if (filter_var(utf8_decode  ($parameters[self::FIX_URL]), FILTER_VALIDATE_URL) === FALSE) {
					//throw new Exception('MSzURLCell | PREFIX parameter is not an URL: ' . utf8_decode   ($parameters[self::PREFIX]));
				}
			}
			
			
			$this->parameters = $parameters;
		} else {
			throw new Exception('MSzURLCell | Parameters are not set!');
		}
	}

	public function validate($value) {
		return isset($value) && is_string($value) || is_numeric($value);
	}

	public function render($value, $secondaryValue  = NULL, $style = null) {
		if (isset($this->parameters[self::PREFIX])) {
			if (!isset($secondaryValue) || strlen($secondaryValue) === 0 ||  strcmp($secondaryValue, MSzCell::NULL) == 0) {
				throw new Exception('Invalid or missing secondary render parameter!');
			}
		}
		
		if (isset($value) && strcmp($value, MSzCell::NULL) != 0 ) {
			
			$retVal1 = strip_tags(stripslashes(strval($value)));
			
			$styleToEnter = $style ?? "";
			$link = "";
			if (isset($this->parameters[self::PREFIX])) {
				$retVal2 = strip_tags(stripslashes(strval($secondaryValue)));
				$link = utf8_decode  ($this->parameters[self::PREFIX]) . $retVal2;
			} else {
				$link = utf8_decode  ($this->parameters[self::FIX_URL]);
			}
			
				return '<a href="'. $link .'"' . $styleToEnter .'>' . $retVal1 . '</a>';
			
		} else {
			return "N/A";
		}
			
			
		
		

	}
	public function getSecondaryParameterId() {
		if (array_key_exists(MSzCell::SECONDARY_PARAMETER, $this->parameters)) {
			return $this->parameters[MSzCell::SECONDARY_PARAMETER];
		} else {
			return null;
		}
		
		
	}
}

?>