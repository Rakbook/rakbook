<?php
session_start();
if (!isset($_SESSION['loggedin']) && $_SESSION['loggedin'] != true) {
	header("Location: index.php");
	die();
}

include("requestuserdata.php");


# someone has just tried to add an empty quote
if (($_SERVER['REQUEST_METHOD'] == 'POST') && (empty($_POST['nauczyciel']) || empty($_POST['content']))) {
	$_SESSION['newquoteerror'] = "Musisz wypełnić tytuł i treść";
	# clean $_POST variables
	header("Location: newquote.php");
	die();
}
# CHECK IF THE USER HAS JUST POSTED, CHECK THE INPUT, AND ADD TO THE DATABASE
if (!empty($_POST['nauczyciel']) && !empty($_POST['content'])) {
	$content = $_POST['content'];
	$content = htmlentities($content);
	$nauczyciel = $_POST['nauczyciel'];
	$query = 'INSERT INTO cytaty (autor, cytat, uploaderid) VALUES (?, ?, ?)';
	easyQuery($query, "ssi", $nauczyciel, $content, $_SESSION['userid']);

	# set quote modification marker
	$_SESSION['quoteModification'] = "add";
	# redirect
	header("Location: cytaty.php");
	die();
}


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
			<?php

			if (isset($_SESSION['newquoteerror'])) {
				echo $_SESSION['newquoteerror'];
				unset($_SESSION['newquoteerror']);
			}

			?>
			<form method="post" action="newquote.php">
				<div class="announcementsField">
					<div id="quotePreview" class="announcement">
						<input name="nauczyciel" type="text" class="announcementInput" style="text-align: center;" placeholder="Nauczyciel:"></input>
						<p class="announcmentTitle" style="font-size: 16px; display: flex; align-items: center; justify-content: center;">Nie można formatować tekstu</p>
						<div class="announcementContent" style="overflow: hidden;"><textarea type="text" name="content" class="announcementContentInput" placeholder="Tutaj treść..."></textarea></div>
						<div class="announcementInfo">
							<div>Opublikowano: <?php echo date('d.m.Y'); ?></div>
						</div>
					</div>
				</div>

				<input type="submit" name="submit" value="Dodaj cytat" class="addAnnouncementButton"></input>
			</form>
		</div>
	</div>
	<script>
		randomColorClass(quotePreview);
	</script>
</body>
</html>