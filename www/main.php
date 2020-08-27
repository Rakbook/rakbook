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
			<div class="headline">
        Masz <?php echo getusersrakcoins($_SESSION['userid']); ?> <img src="images/rakcoin.svg" class="rakcoinImage"> Rakcoinów!
      </div>

			<!-- here you can put some announcements, example below -->
			<div class="headline"> Dołącz na <a href="https://discord.gg/uCXf2hE">Klasowego discorda!</a></div>

			<!-- changelog -->
			<div class="changelogContainerMain">
				<p class="changelogHeader"> &nbsp; changelog </p>
				<div class="changelog">
						<!-- here you should put two most recent changes -->
						<!-- add them also to changelog.php, example below -->
						<span>• 27.08.20 - Rework strony z cytatami.</span>
						<span>• 20.08.20 - Wsparcie dla drag and drop przy dodawaniu mema.</span>
						<span style="margin: 6px; text-align: center;"><a href="changelog.php">Sprawdź wszystkie zmiany</a></span>
			</div></div>
    </div>
  </div>
</body>
</html>
