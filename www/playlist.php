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
<script type="text/javascript">

var chacha = document.createElement("select");
chacha.name = "selekt";
<?php
	$tytuly = array("Co będzie dalej", "Co się stanie co powstanie", "Czego", "Dziękuję", "Dziękuję, oczywiście, tak", "Gra wstępna nie może trwać za długo", "Hehehehehehe", "Ja zbieram takie różne głupoty", "Kółko zawsze może być kwadracikiem, lub odwrotnie", "Może nie będę komentował", "Na końcu o tym opowiem", "Na ogół tak jest", "Nie", "Nie przyniosłem prac uczniów", "Nie ufajcie lepiej policzcie", "Nie no oczywiście że nie", "No to teraz najtrudniejsze zadanie na świecie", "Oj ta siódemka tkwi w głowie niektórym mocno", "Porządnie jak model", "Prosze państwa", "Przy pomocy komputera", "Tak", "Tak bywa, naprawdę", "Takie to niezmiernie łatwe", "To było w cezasie", "To ja", "To jest zaraźliwe", "W Biedronce za 3.50", "W cezasie naszym", "W cudzysłowiu", "Widzę że sala jest przekonana", "Wracamy do tej atrakcyjniejszej dzisiaj formy", "Wszyscy widzimy że trzy, ale faktycznie tylko dwie", "Wszystko jest kwestią mojej wyobraźni", "Z umiejętnością zrealizowania tak postawionego zadania");
for ($i=0; $i < count($tytuly); $i++) {
	echo "var haha = document.createElement(\"option\");";
	echo "var hacha = document.createTextNode(\"$tytuly[$i]\");";
	echo "haha.value = $i;";
	echo "haha.appendChild(hacha);";
	echo "chacha.appendChild(haha);";
}
	?>
</script>
<!DOCTYPE html>
<html>
<head>
  <?php require('standardHead.php'); ?>
	<script src="nodzu.js"></script>
</head>

<body>
  <div class="Container">
    <?php require('Topbar.php') ?>

    <div class="Content">
<form class="playlista" action="newplaylist.php" id="potwierdzenie" method="post">
<p>Stworzenie playlisty kosztuje 20 <img src="images/Rakcoin.svg" class="RakcoinImage"></p>
	Nazwa playlisty: <input type="text" id="nazwap" name="pnazwa" value="">
	<input type="hidden" name="kontent" id ="plejlista" value="">
</form>
Zawartość:
<button type="button" name="nowytekst" onclick="nowyElement()">+</button>
<span color="red" id="war"></span>
	<ul id="lista" class="playlist">

	</ul>
<button type="button" name="button" id="koniecedycji" onclick="zapisz()">Zapisz Playlistę</button>
    </div>
  </div>
</body>
</html>
