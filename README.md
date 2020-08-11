# MSzTableRenderer
PHP Table renderer. 

1) About

This table renderer is a sideproduct of my hobby project. I'm using ots of tables in it, so it makes sense to create a table renderer.
Since it's a hobby project I'm created an own instead of using an exisitng one.

2) Usage

//create columns
$tableHeader = array();
$column1 = new MSzTableColumn("id1", "Test 1", MSzTableColumn::INTEGER_TYPE);
$column2 = new MSzTableColumn("id2", "Test 2", MSzTableColumn::STRING_TYPE);
$column3 = new MSzTableColumn("id3", "Test 1", MSzTableColumn::STRING_TYPE);
array_push($tableHeader, $column1);
array_push($tableHeader, $column2);
array_push($tableHeader, $column3);

//Create data
$tableData = array(
	array("id1" =>"3", "id2" => "apple", "id3" => "nothing"),
	array("id1" =>"1", "id2" => "pear", "id3" => "universe")
);

/create render instance
tr = new MSzTableRenderer($tableHeader, $tableData);
//render table
$tr->doRendering();

3) MSzTableColumn

3.1) Constructor
ublic function __construct($columnId, $columnTitle, $type, $editable = false, $parameters)
where 
colimId:     will be set as id if the column
columnTitle: the title of the column
type:        Colum type. Values: STRING_TYPE, INTEGER_TYPE, DATE_TYPE, BOOLEAN_TYPE, BUTTON_TYPE (only string and integer are implemented)
editable:    wheter the field content is editable (not yet implemented)
parameters:  Options for rendering. see later

3.2) Methods
-getColumnId
-getColumnTitle
-getColumnType
-getEditable
-getValidTypes: Valid column types in an array for validation

3.3) Parameters
New classes are appeared in the code called cell renderers, implementations as MSzCell interface.
They are responsible for validation and rendering the differnet type of data. They might have parameters, which can change how the data is rendered on the screen.
For example the MSzStringCell renderer has an constant called MAX_LENGTH, which can control the maximum lenght of the rendered string.

Example: 
$parameter = [MSzStringCell::MAX_LENGTH => 30];
$column1 = new MSzTableColumn("title", "Title, MSzTableColumn::STRING_TYPE, false, $parameter);

the parameter must be an array, and if the parameters are set the "editable" function parameter must be set as well.

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




