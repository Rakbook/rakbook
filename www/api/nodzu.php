<?php
require_once( 'dependencies.php' );
validatetoken();

class Nodzu
{
	public $name;
	public $audiofile;
	
	function __construct($n, $f)
	{
		$this->name=$n;
		$this->audiofile=$f;
	}
}

$tytuly = array("Co będzie dalej", "Co się stanie co powstanie", "Czego", "Dziękuję", "Dziękuję, oczywiście, tak", "Gra wstępna nie może trwać za długo", "Hehehehehehe", "Ja zbieram takie różne głupoty", "Kółko zawsze może być kwadracikiem, lub odwrotnie", "Może nie będę komentował", "Na końcu o tym opowiem", "Na ogół tak jest", "Nie", "Nie przyniosłem prac uczniów", "Nie ufajcie lepiej policzcie", "Nie no oczywiście że nie", "No to teraz najtrudniejsze zadanie na świecie", "Oj ta siódemka tkwi w głowie niektórym mocno", "Porządnie jak model", "Prosze państwa", "Przy pomocy komputera", "Tak", "Tak bywa, naprawdę", "Takie to niezmiernie łatwe", "To było w cezasie", "To ja", "To jest zaraźliwe", "W Biedronce za 3.50", "W cezasie naszym", "W cudzysłowiu", "Widzę że sala jest przekonana", "Wracamy do tej atrakcyjniejszej dzisiaj formy", "Wszyscy widzimy że trzy, ale faktycznie tylko dwie", "Wszystko jest kwestią mojej wyobraźni", "Z umiejętnością zrealizowania tak postawionego zadania");

$dir = "../nodzu";
$nodzu = scandir($dir);



$nodze=array();

foreach($tytuly as $i => $tytul)
{
	$nodze[]=new Nodzu($tytul, 'http://www.rakbook.pl/nodzu/'.$nodzu[$i+2]);
}

respond(json_encode($nodze));

?>
