<?php
if (!defined("__ALLOW_INCLUDE__")) {
		exit("Obsolete content");
}
require_once(__DIR__ . "/MSzCell.php");
class MSzStringCell  implements MSzCell {
	public const MAX_LENGTH = "ML";

	private $editable;
	private $parameters;
	private static $availableParameterList = [self::MAX_LENGTH];

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
		}
	}

	public static function validate($value) {
		return isset($value) && is_string($value);
	}

	public function render($value, $secondaryValue = NULL) {
		
		if (isset($value) && strcmp($value, MSzCell::NULL) != 0) {
			if (isset($this->parameters) && isset($this->parameters[self::MAX_LENGTH]) && $this->parameters[self::MAX_LENGTH] < strlen($value)) {
				$value = substr($value, 0, $this->parameters[self::MAX_LENGTH]);
			}
			$retVal = strip_tags(stripslashes(strval($value)));
			if ($this->editable) {
				return '<input type="text" value="' . $retVal . '">';
			} else {
				return $retVal;
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