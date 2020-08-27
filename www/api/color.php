<?php
require_once( 'dependencies.php' );
validatetoken();

class Color
{
	public $id;
	public $hex;
	
	function __construct($id, $hex)
	{
		$this->id=$id;
		$this->hex=$hex;
	}
}

$result = easyQuery('SELECT id, hex FROM colors');
$colors = array();
while($row = $result->fetch_assoc())
{
	$colors[]=new Color($row['id'], $row['hex']);
}

respond(json_encode($colors));

?>