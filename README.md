# MSzTableRenderer
PHP Table renderer. 

1) About

This table renderer is a sideproduct of my hobby project. I'm using ots of tables in it, so it makes sense to create a table renderer.
Since it's a hobby project I'm created an own instead of using an exisitng one.

2) Usage

//create columns
$column1 = new MSzTableColumn("id1", "Test 1", MSzTableColumn::INTEGER_TYPE);
$column2 = new MSzTableColumn("id2", "Test 2", MSzTableColumn::STRING_TYPE);
$column3 = new MSzTableColumn("id3", "Test 1", MSzTableColumn::STRING_TYPE);

//Create data
$tableData = array(
			array("id1" =>"3", "id2" => "apple", "id3" => "nothing"),
			array("id1" =>"1", "id2" => "pear", "id3" => "universe")
);

/create render instance
tr = new MSzTableRenderer([$column1, $column2, $column3], $tableData);
//render table
$tr->doRendering();

3) MSzTableColumn

3.1) Constructor
ublic function __construct($columnId, $columnTitle, $type, $editable = false)
where 
colimId:     will be set as id if the column
columnTitle: the title of the column
type:        Colum type. Values: STRING_TYPE, INTEGER_TYPE, DATE_TYPE, BOOLEAN_TYPE, BUTTON_TYPE (only string and integer are implemented)
editable:    wheter the field content is editable (not yet implemented)

3.2) Methods
-getColumnId
-getColumnTitle
-getColumnType
-getEditable
-getValidTypes: Valid column types in an array for validation


4) MSzTableRenderer

4.1) Constructor
public function __construct($tableHeader, $tableData ) {
where
tableHeader: Array of columns 
tableData:  array of displayed data. Every must have teh following format: ("columnId1" => "data", "columnId2" => "data", ... , "columnIdn" => "data" )

4.2) Methods
-setTableData
-setTableHeader
-doRendering




