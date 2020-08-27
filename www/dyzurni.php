<?php

function getnamefromnr($nr)
{
	$row=easyQuery("SELECT user_name, color FROM users WHERE user_nrwdzienniku=?", "i", $nr)->fetch_assoc();
	if(is_null($row)) return formatnamewithcolorid(NULL, NULL);
	return formatnamewithcolorid($row['user_name'], $row['color']);
}

session_start();
if(!isset($_SESSION['loggedin'])&&$_SESSION['loggedin']!=true)
{
	header("Location: index.php");
	die();
}

include("requestuserdata.php");
require_once("dbutils.php");
require_once('userinfo.php');
?>

<!DOCTYPE html>
<html>
<head>
  <?php require('standardHead.php'); ?>
	<link rel="stylesheet" type="text/css" href="colorsshopstyles.css">
	<link rel="stylesheet" type="text/css" href="dyzurni.css">
	<script src="GUIscaling.js"></script>
</head>
<body>
  <div class="container">
    <?php require('topbar.php') ?>
    <div class="content">
      <p class="headline">Dyżurni</p>
			<?php
				echo '<p style="font-size: 24px; margin:0">Dzisiaj jest ';
				echo date("d.m.y");
				echo '</p>';
				$personsInClass = 33;
				$dateShift = 30;
				$y = $personsInClass;
				echo '<table id="dyzTable" class="tabela" cellspacing="0" cellpadding="0">';
				echo '<tr><td class="podkresl week"</td>tydzień</td><td class="podkresl number">nr</td><td class="podkresl username">uczeń</td><td class="podkresl number">nr</td><td class="podkresl username">uczeń</td></tr>';
				$date = strtotime("last monday", strtotime("tomorrow"));

				for ($i=0; $i <17 ; $i++){
					echo "<tr>";
					$z = (date("W")+$i+$dateShift) / $y;
					$z = $z %2;
					$x = (date("W")+$i+$dateShift) % $y;
					$jeden = (($x*2)%$personsInClass)+1;
					$dwa = ((($x*2)+1)%$personsInClass)+1;
					echo '<td class="week">';
					if($i == 0){
						echo 'Obecny';
					}
					else{
						$date = strtotime("+7 days", $date);
 						echo date("d.m.y", $date);
					}
					echo '</td><td class="number">';
					echo $jeden;
					echo '</td><td class="username">';
					echo getnamefromnr($jeden);
					echo "</td>";
					echo '<td class="number">';
					echo $dwa;
					echo '</td><td class="username">';
					echo getnamefromnr($dwa);
					echo "</td>";
					echo "</tr>";
				}
				echo '<tr><td class="podkresl"</td></td><td class="podkresl"></td><td class="podkresl"></td><td class="podkresl"></td><td class="podkresl"></td></tr>';
				echo "</table>";
			?>
			<script>rescaleDyzurniGUI(dyzTable)</script>
  	</div>
	</div>
</body>
</html>
