<?php

require_once("dbcredentials.php");

/*
Drobna funkcja do szybkich, prostych i (mam nadzieję) bezpiecznych zapytań sql,
która jest może nie do końca najbardziej optymalnym rozwiązaniem, ale jak każdy będzie sam musiał martwić się o ochronę nad wstrzykiwaniem sql to może wyjść coś bardzo niedobrego

	użycie:
		w pliku php w którym chcecie tego użyć musi być linijka require_once("dbutils.php");
		jeśli w zapytaniu SQL nie ma parametrów to użycie wygląda tak:
		
easyQuery("query you want to put here SELECT * FROM users");

		jeśli w zapytaniu są parametry to użycie wygląda np. tak:
		
easyQuery("query you want to put here but parameters are as question marks UPDATE users redaktor=? WHERE id=?", "ii", $someredactorvariable, $someid);

		najpierw jest zapytanie potem string który określa jakich typów są parametry(i integer d double s string b blob), a potem po przecinkach są parametry
		
	funkcja zwraca obiekt klasy mysqli_result przy zapytaniach SELECT https://www.php.net/manual/en/class.mysqli-result.php
   w innych przypadkach zwraca false
	
				
W tej funkcji można jakieś przyjemne dla oka wyrzucanie użytkownikowi błędu na twarz zrobić zamiast die("Coś się zepsuło");


przykład: 
		$result=easyQuery("SELECT * FROM users WHERE isadmin=?", "i", 0);
		while($row = $result->fetch_assoc())
		{
			print_r($row);
			echo "<br>";
		}
*/

function easyQuery(string $query, string $paramstring="", ...$params)
{
	global $dbserver;
	global $dbuser;
	global $dbpassword;
	global $dbname;
	
	
	$conn = new MySQLi($dbserver, $dbuser, $dbpassword, $dbname);

	if($conn->connect_errno)
	{
		http_response_code(500);
		die("Nie udało się połączyć z bazą danych");
		die("Coś się zepsuło");
	}
	
	
	if(!$conn->set_charset("utf8"))
	{
		http_response_code(500);
		die("Nie udało się ustawić kodowania na utf-8");
		die("Coś się zepsuło");
	}
	
	
	
	if(!$stmt=$conn->prepare($query))
	{
		http_response_code(500);
		die("Nie udało się przygotować zapytania");
		die("Coś się zepsuło");
	}
	
	if($paramstring!="")
	{
		if(!$stmt->bind_param($paramstring, ...$params))
		{
			http_response_code(500);
			die("Nie udało się dołączyć parametru");
			die("Coś się zepsuło");
		}
	}
	
	
	if(!$stmt->execute())
	{
		http_response_code(500);
		die("Nie udało się wykonać zapytania");
		die("Coś się zepsuło");
	}
	$inserted = $conn->insert_id;
	$result=$stmt->get_result();
	if($conn->errno)
	{
		http_response_code(500);
		die("Nie udało się pozyskać wyniku zapytania");
		die("Coś się zepsuło");
	}
	
	$stmt->close();
	
	$conn->close();
	
	if($result===false)
	{
		return $inserted;
	}
	return $result;
}

?>
