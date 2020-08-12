<?php
if (!defined("__ALLOW_INCLUDE__")) {
		exit("Obsolete content");
}
require_once(__DIR__ . "/MSzTableColumn.php");
class MSzTableRenderer  {

	private $tableData;
	private $tableHeader;



	public function __construct($tableHeader, $tableData ) {
		$this -> setTableHeader($tableHeader);	
		$this -> setTableData($tableData);
		
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
		$ids = array();
		$titles = array();
		foreach ($tableHeader as $value) {
			if (!$value instanceof MSzTableColumn) {
				throw new Exception('The Table Headers array contains invalid items!');
			}
			if (in_array($value->getColumnId(), $ids)) {
				throw new Exception('The Table Headers id array contains duplicate items!');
			}
			array_push($ids, $value->getColumnId());
			if (in_array($value->getColumnTitle(), $titles)) {
				throw new Exception('The Table Headers title array contains duplicate items!');
			}
			array_push($titles, $value->getColumnTitle());
		}

		$this->tableHeader = $tableHeader;
	}

	public function doRendering() {
		$this->renderHeader();
		$this->renderRows();
		$this->renderFooter();
	}

	private function renderHeader() {
		echo "<table>";
		echo "<tr>";  
		foreach ($this->tableHeader as $column) {
			
		  	echo '<th id="'. $column->getColumnId() . '">'.$column->getColumnTitle()."</th>" ;
		 }  
		
  		echo "</tr>";
	}

	private function renderRows() {
		
		foreach ($this->tableData as $row) {
			echo "<tr>"; 
			foreach ($this->tableHeader as $column) {
				$id = $column->getColumnId();
				$cellRenderer = $column->getRenderer();
				$secondaryParameterId = $cellRenderer->getSecondaryParameterId();				
				if ($cellRenderer->validate($row[$id])) {
					if (isset($secondaryParameterId)) {
						echo "<td>". $cellRenderer->render($row[$id], $row[$secondaryParameterId]) . "</td>"; 
					} else {
						echo "<td>". $cellRenderer->render($row[$id]) . "</td>"; 
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