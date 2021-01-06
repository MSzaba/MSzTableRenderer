<?php
if (!defined("__ALLOW_INCLUDE__")) {
		exit("Obsolete content");
}
require_once(__DIR__ . "/MSzCell.php");
class MSzStringCell  implements MSzCell {
	public const MAX_LENGTH = "ML";
	public const ENABLE_TITLE = "ET";

	private $editable;
	private $parameters;
	private static $availableParameterList = [self::MAX_LENGTH, self::ENABLE_TITLE];

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
					throw new Exception('MSzStringCell Invalid Column parameter: ' . $parameterName);
				}
			}
			$this->parameters = $parameters;
		}
	}

	public function validate($value) {
		return isset($value) && is_string($value);
	}

	public function render($value, $secondaryValue = NULL, $style = null) {
		
		if (isset($value) && strcmp($value, MSzCell::NULL) != 0) {
			$value = strip_tags(stripslashes(strval($value)));
			if (isset($this->parameters) && isset($this->parameters[self::MAX_LENGTH]) && $this->parameters[self::MAX_LENGTH] < strlen($value)) {
				$retVal = substr($value, 0, $this->parameters[self::MAX_LENGTH]);
			} else {
				$retVal = $value;
			}
			$styleToEnter = $style ?? "";
			$title = "";
			if (isset($this->parameters) && isset($this->parameters[self::ENABLE_TITLE]) && $this->parameters[self::ENABLE_TITLE] == true) {
				$title = ' title="' . $value . '" ';
			}
			if ($this->editable) {
				return '<input type="text" value="' . $retVal . '"' . $styleToEnter . $title . '>';
			} else {
				return '<span ' . $styleToEnter .  $title . '>' . $retVal . '</span>';
			}
		} else {
			return "N/A";
		}
			
			
		
		

	}
	public function getSecondaryParameterId() {
		return null;
	}
}

?>