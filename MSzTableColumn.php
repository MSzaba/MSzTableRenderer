<?php
if (!defined("__ALLOW_INCLUDE__")) {
		exit("Obsolete content NewsHandler");
}
require_once(__DIR__ . "/MSzIntegerCell.php");
require_once(__DIR__ . "/MSzStringCell.php");
class MSzTableColumn {
	const STRING_TYPE = "STRING";
	const INTEGER_TYPE = "INTEGER";
	const DATE_TYPE = "DATE";
	const BOOLEAN_TYPE = "BOOL";
	const BUTTON_TYPE = "BUTTON";
	const URL_TYPE = "URL";
	private $columnId; 
	private $columnTitle;
	private $type;
	private $editable;
	private $cellRenderer;
	private $parameters;

	public function __construct($columnId, $columnTitle, $type, $editable = false, $parameters = null) {
		if (!isset($columnId)) {
			throw new Exception('Column id is not set!');
		}
		if (!isset($columnTitle)) {
			throw new Exception('Column title is not set!');
		}
		if (!isset($type)) {
			throw new Exception('Column type is not set!');
		}
		if (!in_array($type, $this->getValidTypes())) {
			throw new Exception('Column type is invalid:' . $type);
		}
		$this -> columnId = $columnId;
		$this -> columnTitle = $columnTitle;
		$this -> type = $type;	
		$this -> editable = $editable;
		$this->cellRenderer = self::createRenderer($type, $editable, $parameters);
		if (isset($parameters)) {
			$this->parameters = $parameters;
		}
	}

	public function getColumnId() {
		return $this->columnId;
	}

	public function getColumnTitle() {
		return $this->columnTitle;
	}
	public function getColumnType() {
		return $this->type;
	}
	public function getEditable() {
		return $this->editable;
	}
	public function getValidTypes() {
		return [self::STRING_TYPE, self::DATE_TYPE, self::BOOLEAN_TYPE, self::INTEGER_TYPE];
	}

	public function getRenderer() {
		return $this->cellRenderer;
	}

	private static function createRenderer($type, $editable, $parameters = null) {
		switch ($type) {
			case self::STRING_TYPE:
				return new MSzStringCell($editable, $parameters);
				
			case self::INTEGER_TYPE:
				return new MSzIntegerCell($editable, $parameters);
				
			case self::DATE_TYPE:
				# code...
				break;
			case self::BOOLEAN_TYPE:
				# code...
				break;
			case self::BUTTON_TYPE:
				# code...
				break;
				
			case self::URL_TYPE:
				//return new MSzURLCell($editable, $parameters);
				break;
			
			default:
				# code...
				break;
		}
	}
} 

?>