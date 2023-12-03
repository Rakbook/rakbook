<?php
session_start();
if (!isset($_SESSION['loggedin']) && $_SESSION['loggedin'] != true) {
	header("Location: index.php");
	die();
}

require_once("dbutils.php");
include("requestuserdata.php");

# check for quotes waiting to be removed
if (!empty($_POST['postToRemove'])) {
	if(($_SESSION['redaktor']==0) && ($_SESSION['userisadmin']==0))
	{
		header("Location: main.php");
		die();
	}
	$postID = $_POST['postToRemove'];
	$query = "DELETE FROM cytaty WHERE id=?";
	easyQuery($query, "i", $postID);

	# set quote modification marker
	$_SESSION['quoteModification'] = "remove";
	# redirect
	header("Location: cytaty.php");
	die();
}

?>

<!DOCTYPE html>
<html>
<head>
	<?php require('standardHead.php'); ?>
	<link rel="stylesheet" type="text/css" href="quotestyles.css">
	<link rel="stylesheet" type="text/css" href="quotes.css">
	<link rel="stylesheet" type="text/css" href="divColors.css">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
	<script src="quotelikes.js"></script>
	<script src="quotes.js"></script>
</head>
<body>
	<div class="container">
		<?php require('topbar.php') ?>
		<div class="content">
			<div class="coverBar">
				<div class="optionBar">
					<div class="left">
						<div onclick="location.href='newquote.php'" class="plusButton">+</div>
						<select id="sortStyleSelect" class="sortDropdown">
							<option value="new">Najnowsze</option>
							<option value="best">Najlepsze</option>
							<option value="old">Najstarsze</option>
							<option value="worst">Najgorsze</option>
							<option value="author">Autor alfabetycznie</option>
						</select>
					</div>
					<input type="text" id="search" class="keywordInput" placeholder="Wyszukaj coś" autocomplete="off"></input>
				</div>
			</div>
			<div class="alertBox">
				<?php
				if (isset($_SESSION['quoteModification'])) {
					if ($_SESSION['quoteModification'] == "add") {
						echo "Pomyślnie dodano nowy cytat!<br>";
					}
					if ($_SESSION['quoteModification'] == "remove") {
						echo "Pomyślnie usunięto cytat!<br>";
					}
					unset($_SESSION['quoteModification']);
				}
				?>
			</div>
			<div id=quoteBox> <?php require('loadquotes.php'); ?> </div>
		</div>
	</div>
</body>
</html>
