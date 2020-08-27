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
  <div class="container">
    <?php require('topbar.php') ?>
    <div class="content">
      <script type="text/javascript">
 				var czass=0;
				var a = 1;

				function stopp() {
					<?php
						for ($i=0; $i < 35; $i++) {
							echo "nodzu".$i.".load();\n";
							echo "nodzu".$i.".pause();\n";
							echo "a=0;";
						}
		 			?>
				}

				function sleep(ms) { return new Promise(resolve => setTimeout(resolve, ms)); }

				<?php
					$dir = "nodzu";
					$nodzu = scandir($dir);
					for ($i=0; $i <35 ; $i++) {
						echo "var nodzu".$i."=new Audio('nodzu/".$nodzu[$i+2]."');\n";
					}
		 		?>

			 	function wszystkoo() {
					a=1;
			 		<?php
						for ($i=0; $i < 35; $i++) {
							echo "nodzu".$i.".play();\n";
						}
			  	?>
		 		}

		 		async function wszystko() {
					a=1;
			 		<?php
 						for ($i=0; $i < 35; $i++) {
							echo "if(a){";
 							echo "nodzu".$i.".play();\n";
							echo "await sleep(nodzu".$i.".duration*1000);\n";
							echo"}";
 						}
					?>
		 		}

				async function losowo() {
					a=1;
					while(a) {
						var nr=Math.random()*350;
						nr = Math.floor(nr);
						nr = nr % 35;
						var nodz="no"+nr.toString(10);
						console.log(nodz);
						document.getElementById(nodz).click();
						await sleep(czass*1000);
					}
				}
			</script>

			<div class="headline">Nodzu to jest kozak</div>
			<p><a href="playlist.php">Dodaj nową playlistę</a></p>
			<p><a href="playlists.php">Twoje playlisty</a></p>
			<button class="supernodzu" onclick="wszystkoo()">Odtwórz wszystko W TYM SAMYM CZASIE</button>
			<button class="supernodzu" onclick="wszystko()">Odtwórz wszystko</button>
			<button class="supernodzu" onclick="stopp()">STOP!</button>
			<button class="supernodzu" onclick="losowo()">Odtwarzanie losowe</button>
			<ul class="listanodzu">
				<?php
					$tytuly = array("Co będzie dalej", "Co się stanie co powstanie", "Czego", "Dziękuję", "Dziękuję, oczywiście, tak", "Gra wstępna nie może trwać za długo", "Hehehehehehe", "Ja zbieram takie różne głupoty", "Kółko zawsze może być kwadracikiem, lub odwrotnie", "Może nie będę komentował", "Na końcu o tym opowiem", "Na ogół tak jest", "Nie", "Nie przyniosłem prac uczniów", "Nie ufajcie lepiej policzcie", "Nie no oczywiście że nie", "No to teraz najtrudniejsze zadanie na świecie", "Oj ta siódemka tkwi w głowie niektórym mocno", "Porządnie jak model", "Prosze państwa", "Przy pomocy komputera", "Tak", "Tak bywa, naprawdę", "Takie to niezmiernie łatwe", "To było w cezasie", "To ja", "To jest zaraźliwe", "W Biedronce za 3.50", "W cezasie naszym", "W cudzysłowiu", "Widzę że sala jest przekonana", "Wracamy do tej atrakcyjniejszej dzisiaj formy", "Wszyscy widzimy że trzy, ale faktycznie tylko dwie", "Wszystko jest kwestią mojej wyobraźni", "Z umiejętnością zrealizowania tak postawionego zadania");

					for ($i=0; $i <35 ; $i++) {
						echo "<li><button id=\"no".$i."\" class=\"nodzubutton\" onclick=\"nodzu".$i.".play(); czass=nodzu".$i.".duration\">".$tytuly[$i]."</button></li>";
					}
	 			?>
			</ul>
			Źródło cytatów: <a href="https://www.youtube.com/watch?v=54pHe7YZdRM">https://www.youtube.com/watch?v=54pHe7YZdRM</a>
    </div>
  </div>
</body>
</html>
