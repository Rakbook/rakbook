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
    <?php require('oldTopbar.php') ?>

    <div class="content">
      <div class="hello"> Witaj <?php echo getusersformattedname($_SESSION['userid']); ?>!</div>
			<div class="headline">
        Masz <?php echo getusersrakcoins($_SESSION['userid']); ?> <img src="images/rakcoin.svg" class="rakcoinImage"> Rakcoinów!
      </div>

			<!--Ogłoszenia tutaj-->

			<div class="headline"> Dołącz na <a href="https://discord.gg/uCXf2hE">Klasowego discorda!</a></div>

			<!--Change Log-->
			<div class="changelogContainer">
				<p class="changelogHeader"> &nbsp; change log </p>
				<div class="changelog">
					<!-- Na razie trzeba manualnie dopisywać -->
					<!-- Na tej liście powinny znajdować się tylko dwa najnowsze -->
					<!-- Pamętaj, żeby dodać też do changeLog.php -->
					<p style="text-align: left; margin-left: 10px; line-height: 1.5; margin-bottom:0">
						• 15.08.20 - Nowe GUI dla dyżurnych.</br>
            • 14.08.20 - Nowe GUI dodawania cytatów i memów.
          </p>
					<p style="margin: 6px;"><a href="changelog.php">Sprawdź wszystkie zmiany</a></p>
			</div></div>
    </div>
  </div>
</body>
</html>
