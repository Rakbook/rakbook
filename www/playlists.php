<?php

session_start();
if(!isset($_SESSION['loggedin'])&&$_SESSION['loggedin']!=true)
{
	header("Location: index.php");
	die();
}

include("requestuserdata.php");
require_once('userinfo.php');

?>

<!DOCTYPE html>
<html>
<head>
  <?php require('standardHead.php'); ?>
	<link rel="stylesheet" type="text/css" href="nodzu.css">
	<script src="nodzu.js"></script>
</head>
<body>
	<script type="text/javascript">
	<?php
	$dir = "nodzu";
	$nodzu = scandir($dir);
	echo "var nodzu=[";
	for ($i=0; $i <34 ; $i++) {
		echo "new Audio('nodzu/".$nodzu[$i+2]."'),";
	}
	echo "new Audio('nodzu/".$nodzu[36]."')];";
	 ?>
	</script>
  <div class="container">
    <?php require('topbar.php') ?>
    <div class="content">
<p>Twoje playlisty:</p>
<button class="supernodzu" onclick="stop()">STOP!</button>
<table align="center">
	<tr>
		<th>Nazwa</th>
		<th>Zawartość</th>
		<th colspan="3">Akcje</th>
	</tr>

<?php
$tytuly = array("Co będzie dalej", "Co się stanie co powstanie", "Czego", "Dziękuję", "Dziękuję, oczywiście, tak", "Gra wstępna nie może trwać za długo", "Hehehehehehe", "Ja zbieram takie różne głupoty", "Kółko zawsze może być kwadracikiem, lub odwrotnie", "Może nie będę komentował", "Na końcu o tym opowiem", "Na ogół tak jest", "Nie", "Nie przyniosłem prac uczniów", "Nie ufajcie lepiej policzcie", "Nie no oczywiście że nie", "No to teraz najtrudniejsze zadanie na świecie", "Oj ta siódemka tkwi w głowie niektórym mocno", "Porządnie jak model", "Prosze państwa", "Przy pomocy komputera", "Tak", "Tak bywa, naprawdę", "Takie to niezmiernie łatwe", "To było w cezasie", "To ja", "To jest zaraźliwe", "W Biedronce za 3.50", "W cezasie naszym", "W cudzysłowiu", "Widzę że sala jest przekonana", "Wracamy do tej atrakcyjniejszej dzisiaj formy", "Wszyscy widzimy że trzy, ale faktycznie tylko dwie", "Wszystko jest kwestią mojej wyobraźni", "Z umiejętnością zrealizowania tak postawionego zadania");
$result=easyQuery("SELECT * FROM playlisty WHERE autor=?", "i", $_SESSION['userid']);
while($row = $result->fetch_assoc())
{
	echo "<td>".$row['nazwa']."</td>";
	echo "<td><select><option>Zawartość</option>";
	$zaw = explode(",", $row["zawartosc"]);
for ($i=0; $i < count($zaw) ; $i++) {
	echo "<option disabled>".$tytuly[$zaw[$i]]."</option>";
}
	echo "</select></td>";
	echo "<td><button type=\"button\" onclick=\"playplaylist('".$row['zawartosc']."')\" name=\"button\">Odtwórz</button>";
echo "<td><button type=\"button\" onclick=\"playrandom('".$row['zawartosc']."')\" name=\"button\">Odtwórz losowo</button>";
echo "<td><form action=\"newplaylist.php\" method=\"post\"><input type=\"hidden\" name=\"todelete\" value=\"".$row['id']."\"><input type=\"submit\" value =\"Usuń\"></form>";
}

 ?>
 </table>
    </div>
  </div>
</body>
</html>
