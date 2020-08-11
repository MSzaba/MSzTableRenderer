<?php
if (!defined("__ALLOW_INCLUDE__")) {
		exit("Obsolete content");
}
interface MSzCell {
	public const NULL = "NULL";

	public static function validate($value);
	public function __construct($editable, $parameters =  null);
	public function render($value);
	
}

?>