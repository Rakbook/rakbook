<?php
session_start();
if(!isset($_SESSION['loggedin'])&&$_SESSION['loggedin']!=true)
{
	header("Location: index.php");
	die();
}

require_once("dbutils.php");
include("requestuserdata.php");

?>

<!DOCTYPE html>
<html>
<head>
  <?php require('standardHead.php'); ?>
  <link rel="stylesheet" type="text/css" href="quotestyles.css">
	<link rel="stylesheet" type="text/css" href="quotes.css">
	<link rel="stylesheet" type="text/css" href="announcementColors.css">
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
					if(!empty($_POST['nauczyciel'])&&!empty($_POST['content'])){
						$content = $_POST['content'];
				  	$content = htmlentities($content);
			  		$nauczyciel = $_POST['nauczyciel'];
			  		$query = 'INSERT INTO cytaty (autor, cytat, uploaderid) VALUES (?, ?, ?)';
			  		easyQuery($query, "ssi", $nauczyciel, $content, $_SESSION['userid']);
			  		echo "Pomyślnie dodano nowy cytat!<br>";
					}

					if(!empty($_POST['postToRemove'])){
						$postID = $_POST['postToRemove'];
			  		$query = "DELETE FROM cytaty WHERE id=?";
			  		easyQuery($query, "i", $postID);
			  		echo "Pomyślnie usunięto cytat!<br>";
					}
				?>
		</div>
			<div id=quoteBox> <?php require('loadquotes.php'); ?> </div>
		</div>
  </div>
</body>
</html>
