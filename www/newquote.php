<?php
session_start();
if(!isset($_SESSION['loggedin'])&&$_SESSION['loggedin']!=true)
{
	header("Location: index.php");
	die();
}

include("requestuserdata.php");

?>

<!DOCTYPE html>
<html>
<head>
  <?php require('standardHead.php'); ?>
	<link rel="stylesheet" type="text/css" href="announcements.css">
	<link rel="stylesheet" type="text/css" href="divColors.css">
	<script src="memes.js"></script>
</head>
<body>
  <div class="container">
    <?php require('topbar.php') ?>
    <div class="content">
    	<p class="headline">Dodaj nowy cytat</p>
			<form method="post" action="cytaty.php">
			<div class="announcementsField">
				<div id="quotePreview" class="announcement">
		    	<input name="nauczyciel" type="text" class="announcementInput" style="text-align: center;" placeholder="Nauczyciel:"></input>
		     	<p class="announcmentTitle" style="font-size: 16px; display: flex; align-items: center; justify-content: center;">Nie można formatować tekstu</p>
		     	<div class="announcementContent" style="overflow: hidden;"><textarea type="text" name="content" class="announcementContentInput" placeholder="Tutaj treść..."></textarea></div>
		     	<div class="announcementInfo"> <div>Opublikowano: <?php echo date('d.m.Y'); ?></div></div>
				</div>
			</div>

			<input type="submit" name="submit" value="Dodaj cytat" class="addAnnouncementButton"></input>
		</form>
  	</div>
	</div>
	<script> randomColorClass(quotePreview); </script>
</body>
</html>
