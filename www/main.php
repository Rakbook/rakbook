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
	<link rel="stylesheet" type="text/css" href="changelog.css">
</head>
<body>
  <div class="container">
    <?php require('topbar.php') ?>
    <div class="content">
      <div class="hello"> Witaj <?php echo getusersformattedname($_SESSION['userid']); ?>!</div>
			<div class="headline">Masz <?php echo getstyledrakcoins(getusersrakcoins($_SESSION['userid'])); ?></div>

			<!-- here you can put some announcements, example below -->
			<!-- <div class="headline"> Dołącz na <a href="https://discord.gg/uCXf2hE">Klasowego discorda!</a></div> -->
			<div class="headline" style="color: gold;">Nowy kolor już dostępny! <a href="colorsshop.php">Sprawdź sklep</a>!</div>

			<!-- changelog -->
			<div class="changelogContainerMain">
				<p class="changelogHeader"> &nbsp; changelog </p>
				<div class="changelog">
						<!-- changes loaded from changelog.html -->
						<?php
						$myfile = fopen("changelog.html", "r");
						$content = fread($myfile,filesize("changelog.html"));
						fclose($myfile);
						$content = preg_split('/\n/', $content);
						echo "<span>".$content[0]."</span>";
						echo "<span>".$content[1]."</span>";
						?>
						<span style="margin: 6px; text-align: center;"><a href="changelog.php">Sprawdź wszystkie zmiany</a></span>
			</div></div>
    </div>
  </div>
</body>
</html>
