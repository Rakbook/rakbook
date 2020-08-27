<?php
require_once( 'dependencies.php' );

class Quote
{
	public $id;
	public $author;
	public $quote;
	public $rating;
	
	function __construct(int $id, string $author='', string $quote='', int $uploader=0, int $rating=0)
    {
        $this->id=$id;
		$this->author=$author;
		$this->quote=$quote;
		$this->rating=$rating;
    }
}

$id = validatetoken();

if($_SERVER['REQUEST_METHOD'] === 'GET')
{
	$query='SELECT cytaty.id, autor, cytat, uploaderid, IFNULL(SUM(quotelikes.value), 0) AS likes, IFNULL((SELECT quotelikes.value FROM quotelikes WHERE quotelikes.personid=? AND quotelikes.quoteid=cytaty.id), 0) AS currentuserlikevalue FROM `cytaty` LEFT JOIN quotelikes ON cytaty.id=quotelikes.quoteid GROUP BY cytaty.id ORDER BY cytaty.id DESC';
	
	$quotes = array();
	
	$result=easyQuery($query, "i", $id);
	if ($result->num_rows > 0)
	{
		while($row = $result->fetch_assoc())
		{

			$quotes[] = new Quote($row['id'], $row['autor'], $row['cytat'], $row['likes']);
		}
	}
	respond(json_encode($quotes));
}

if($_SERVER['REQUEST_METHOD'] === 'POST')
{
	if(isset($_POST['quote'])&&isset($_POST['author']))
	{
		$query = 'INSERT INTO cytaty (autor, cytat, uploaderid) VALUES (?, ?, ?)';
		easyQuery($query, 'ssi', $_POST['author'], htmlentities($_POST['quote']), $id);
		respond();
	}else
	{
		respond('quote and author must be sent', 400);
	}
}

?>
