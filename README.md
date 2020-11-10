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
type:        Colum type. Values: STRING_TYPE, INTEGER_TYPE, DATE_TYPE, BOOLEAN_TYPE, BUTTON_TYPE, URL_TYPE, IMAGE_TYPE, BOOLEAN_TYPE (date is not yet implemented)
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

5) Column Types and their parameters
5.1) STRING_TYPE
It is designed to display siple text.
There is one parameter: 
MSzStringCell::MAX_LENGTH - it controls the maximum allowed lenght of the printed sting.

5.2) INTEGER_TYPE
It is designed to display integer. It has no parameter

5.3) URL_TYPE
It displays an url in the trable. It uses a secondary parameter. THe main will be used as text of the link, the secondary will be used as content of the hred HTTP attribute.
It has one parameter:
MSzURLCell::PREFIX - this may contain an URL which will be used as prefix of the secondary parameter. 
Usage:

$tableData = array(
	array("linkText" =>"Text1", "articleId" => "51475532"),
	array("linkText" =>"Text2", "articleId" => "53730258")
);
$parameter = [MSzURLCell::PREFIX => "https://www.bbc.com/sport/football/",
	MSzCell::SECONDARY_PARAMETER => "articleId"
];
$column1 = new MSzTableColumn("linkText", "Sport Articles", MSzTableColumn::URL_TYPE, false, $parameter);
$tr = new MSzTableRenderer([$column1], $tableData);
$tr->doRendering();

5.4) IMAGE_TYPE
This cell renderer can show an image in a cell.
It has 3 parameters:
MSzImageCell::HEIGHT -sets the height of the image in pixel
MSzImageCell::WIDTH -sets the tidth of the image in pixel
MSzImageCell::CROSSORIGIN -sets crossorigin="anonymous" parameter fro the image if it is set to true

5.5) BOOLEAN_TYPE
This cell renderer displays a bboolean value as a checkbox
Due to limitation of the HTML framework the editable flag sets the disabled status of the element.

Example:
$tableData = array(
	array("one" => true, "two" => false),
	array("one" => false, "two" => true)
);
		
$column1 = new MSzTableColumn("one", "Editable", MSzTableColumn::BOOLEAN_TYPE, true); //the cell is editable
$column2 = new MSzTableColumn("two", "Not editable", MSzTableColumn::BOOLEAN_TYPE); //the cell is not editable
$tr = new MSzTableRenderer([$column1, $column2], $tableData);
$tr->doRendering();

6) Styling

The table can handle styling information. There are four different area where the styling information can be added:
-Table (added to the <table> tag)
-Header (added to the first <tr> tag)
-Row (added to the following <tr> tags)
-Column (added to the affected <th> and <td> tags)
	
Example:

$tr = new MSzTableRenderer($tableHeader, $dataToDisplay); 
$tr->setStyles([
	MSzTableRenderer::ST_TABLE => "tableStyle", 
	MSzTableRenderer::ST_HEADER => "tableHeaderStyle",
	MSzTableRenderer::ST_ROW => "tableRowStyle",
	"columnToHide" => "hideBelow640"
]);
$tr->doRendering();

In the example first we create a Table Renderer instance with previously created data. Then we call the setStyles method with an array.
For the Whole table we set the stlye "tableStyle", for the header we set "tableHeaderStyle" and for the rows we set "tableRowStlye".
At the end we set an extra class for the column "columnToHide": "hideBelow640".
These stlyes must be defined in the available css files!

This way the table can support mobile devices and tablets. Those colums, which are not requred on the screen in lower resolution can be hidden.
