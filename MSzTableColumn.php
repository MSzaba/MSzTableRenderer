<?php
if (!defined("__ALLOW_INCLUDE__")) {
		exit("Obsolete content NewsHandler");
}
class MSzTableColumn {
	const STRING_TYPE = "STRING";
	const INTEGER_TYPE = "INTEGER";
	const DATE_TYPE = "DATE";
	const BOOLEAN_TYPE = "BOOL";
	const BUTTON_TYPE = "BUTTON";
	private $columnId; 
	private $columnTitle;
	private $type;
	private $editable;

	public function __construct($columnId, $columnTitle, $type, $editable = false) {
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
	}

	public function getColumnId() {
		return $this->columnId;
	}

	public function getColumnTitle() {
		return $this->columnTitle;
	}
	public function getColumnType() {
		return $this->columnType;
	}
	public function getEditable() {
		return $this->editable;
	}
	public function getValidTypes() {
		return [self::STRING_TYPE, self::DATE_TYPE, self::BOOLEAN_TYPE, self::INTEGER_TYPE];
	}
} 

?>
