<?php
if (!defined("__ALLOW_INCLUDE__")) {
		exit("Obsolete content");
}
require_once(__DIR__ . "/MSzTableColumn.php");
class MSzTableRenderer  {

	private $tableData;
	private $tableHeader;
	private $validStyleSources;
	private $styleClasses;
	private $caption;
	private $ids = [];

	public const ST_TABLE = "ST_TABLE";
	public const ST_HEADER = "ST_HEADER";
	public const ST_ROW = "ST_ROW";
	//public const ST_FOOTER = "ST_FOOTER";



	public function __construct($tableHeader, $tableData, $caption = null ) {
		$this -> setTableHeader($tableHeader);	
		$this -> setTableData($tableData);
		if (isset($caption)) {
			$this->caption = htmlspecialchars($caption);
		}
		$this->validStyleSources = [
			self::ST_TABLE,
			self::ST_HEADER,
			self::ST_ROW
		];
	}

	public function setTableData($tableData) {
		if (!isset($tableData)) {
			throw new Exception('Table Data is not set!');
		}
		if (!is_array($tableData)) {
			throw new Exception('Table Data Parameter is not an array!');
		}
		if (count($tableData) === 0) {
			throw new Exception('Table Data Parameter array is empty!');
		}
		$types = [];
		foreach ($this->tableHeader as $column) {
			$types[$column->getColumnId()] = $column->getColumnType();
		}
		foreach ($tableData as $row) {
			//TODO  validation before rendering
		}
		$this->tableData = $tableData;
	}

	public function setTableHeader($tableHeader) {
		if (!isset($tableHeader)) {
			throw new Exception('Table Headers are not set!');
		}
		if (!is_array($tableHeader)) {
			throw new Exception('Table Headers Parameter is not an array!');
		}
		if (count($tableHeader) === 0) {
			throw new Exception('Table Headers Parameter array is empty!');
		}
		$this->ids = array();
		$titles = array();
		foreach ($tableHeader as $value) {
			if (!$value instanceof MSzTableColumn) {
				throw new Exception('The Table Headers array contains invalid items!');
			}
			if (in_array($value->getColumnId(), $this->ids)) {
				throw new Exception('The Table Headers id array contains duplicate items!');
			}
			//error_log("Push to aray: " . $value->getColumnId() . " Title: " . $value->getColumnTitle());
			array_push($this->ids, $value->getColumnId());
			if (in_array($value->getColumnTitle(), $titles)) {
				throw new Exception('The Table Headers title array contains duplicate items!');
			}
			array_push($titles, $value->getColumnTitle());
		}

		$this->tableHeader = $tableHeader;
	}

	public function setStyles($stylesArray) {

		if (!isset($stylesArray)) {
			throw new Exception("Styles array is missing");
		}
		if (!is_array($stylesArray)) {
			throw new Exception("Function parameter must be an array");
		}
		if (empty($stylesArray)) {
			throw new Exception("Styles array is empty!");
		}

		foreach ($stylesArray as $key => $value) {

			if (!isset($key) || is_numeric($key)) {
				throw new Exception("Style array has wrong format. <<Style source>> => <<classes>> format should be used.");
			}
			if (!in_array($key, $this->validStyleSources) && !in_array($key, $this->ids)) {
				throw new Exception("Invalid style source!");
			}
			
			$internalStyles = $this->checkValidStyleset($value, "Style");
			$this->styleClasses[$key] =  htmlspecialchars($internalStyles, ENT_QUOTES);
		}
	}

	private function getStyle($source) {
		if (isset($this->styleClasses[$source])) {
			return $this->styleClasses[$source];
		} else {
			return "";
		}
		
		
	}

	private function checkValidStyleset($string) {
		$stringToCheck = str_replace(' ', '', $string);
		if (!ctype_alnum($stringToCheck)) {
			throw new Exception("Style name must be alfanumerical!");
		}
		return $string;
	}


	public function doRendering() {
		$this->renderHeader();
		$this->renderRows();
		$this->renderFooter();
	}

	private function renderHeader() {

		$tableStyle = $this->getStyle(self::ST_TABLE);
		$tableHeaderStyle = $this->getStyle(self::ST_HEADER);
		
		echo '<table class="' . $tableStyle . '">';
		$this->renderCaption();
		echo '<tr  class="' . $tableHeaderStyle . '">';  
		foreach ($this->tableHeader as $column) {
			$id = $column->getColumnId();
			$style = "";
			if ($this->getStyle($id) !== null) {
				$style = 'class="' . $this->getStyle($id) . '" ';
			}
			
		  	echo '<th id="'. $id . '" ' . $style . '>'.$column->getColumnTitle()."</th>" ;
		 }  
		
  		echo "</tr>";
	}

	private function renderCaption() {
		if (isset($this->caption)) {
			echo "<caption>". $this->caption . "</caption>";
		}
	}

	private function renderRows() {
		$rowStyle = $this->getStyle(self::ST_ROW);
		foreach ($this->tableData as $row) {
			echo '<tr  class="' . $rowStyle . '">'; 
			foreach ($this->tableHeader as $column) {
				$id = $column->getColumnId();

				$styleToPrint = "";
				if ($this->getStyle($id) !== null ) {
					$styleToPrint = 'class="' . $this->getStyle($id) . '" ';
				}
				$cellRenderer = $column->getRenderer();
				$secondaryParameterId = $cellRenderer->getSecondaryParameterId();
				if ($cellRenderer->validate($row[$id])) {
					if (!isset($row[$id])  || strlen($row[$id]) == 0) {
						error_log("MSzTableRenderer::renderRows | data is missing from table column " . $id);
						echo "<td " . $styleToPrint . " >";
						continue;
					}
					if (isset($secondaryParameterId)) {
						if (!isset($row[$secondaryParameterId]) || strlen($row[$secondaryParameterId]) == 0) {
							error_log("MSzTableRenderer::renderRows | secondary data is missing from table column " . $id);
							echo "<td " . $styleToPrint . " >";
							continue;
						}
						echo "<td " . $styleToPrint . " >". $cellRenderer->render($row[$id], $row[$secondaryParameterId], $styleToPrint) . "</td>"; 
					} else {
						echo "<td " . $styleToPrint . " >". $cellRenderer->render($row[$id], null, $styleToPrint) . "</td>"; 
					}
					
					
				} else {
					echo "<td>Invalid data: " . $row[$id] . "</td>";
				}
				
				
			}
			echo "</tr>";
		}
		
		
		
	}

	private function renderFooter() {
		echo "</table>";
	}
}
?>