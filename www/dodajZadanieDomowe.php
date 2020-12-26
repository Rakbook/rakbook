<?php

session_start();
if(!isset($_SESSION['loggedin'])&&$_SESSION['loggedin']!=true)
{
	header("Location: index.php");
	die();
}

include("requestuserdata.php");
require_once('userinfo.php');
require_once('dbutils.php');

?>

<!DOCTYPE html>
<html>
<head>
  <?php require('standardHead.php'); ?>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
  <link rel="stylesheet" type="text/css" href="homework.css">
  <link rel="stylesheet" type="text/css" href="divColors.css">
  <script src="homework.js"></script>
</head>
<body>
	<div class="container">
    	<?php require('topbar.php') ?>
    	<div class="content">
			<div id="homeworkContainer">
				<div class="titlePanel">
				<?php
					// total mess but works
					$total = 0;

					if(isset($_POST['category']) && strlen($_POST['category']) > 0){
						$cat = "\"".$_POST['category']. "\"";
					}
					else{
						$cat = "\"\"";
						$total++;
					}

					if(isset($_POST['title']) && strlen($_POST['title']) > 0){
						$title = "\"".$_POST['title']. "\"";
					}
					else{
						$title = "\"\"";
						$total++;
					}

					if(isset($_POST['date']) && $_POST['date'] != NULL){
						$date = "\"" .$_POST['date']. "\"";
					}
					else{
						$date = "null";
						$total++;
					}

					if(isset($_POST['desc']) && strlen($_POST['desc']) > 0){
						$desc = "\"".$_POST['desc']."\"";
					}
					else{
						$desc = "\"\"";
						$total++;
					}
					if($total == 4){ echo "Dodaj zadanie domowe"; }
					echo "<script>var cat=".$cat."; var title=".$title."; var date=".$date."; var desc=".$desc.";</script>";

					if(isset($_POST['category']) && strlen($_POST['category']) > 0){
						if(isset($_POST['title']) && strlen($_POST['title']) > 0){
							if(isset($_POST['date']) && $_POST['date'] != NULL){
								easyQuery('INSERT INTO zadania (category, content, link, date) VALUES (?, ?, ?, ?)', 'ssss', $_POST['category'], $_POST['title'], $_POST['desc'], $_POST['date']);
								header('Location: zadaniaDomowe.php');
							}
							else{
								if($total != 4){ echo "<span style=\"color: #E74C3C;\">Nie podano daty!</span>"; }
							}
						}
						else{
							if($total != 4){ echo "<span style=\"color: #E74C3C;\">Nie podano tytułu!</span>"; }
				 		}
					}
					else{
						if($total != 4){ echo "<span style=\"color: #E74C3C;\">Nie podano lekcji!</span>"; }
					}
				?>
				</div>
				<form action="" method="post">
					<div class="addHomework"><div class="addHomeworkBackground">
						<div class="wrapper">
							<input type="text" id="kategoria" class="homeworkInput" name="category" placeholder="Lekcja" autocomplete="off">
							<input type="date" id="data" class="homeworkInput short" name="date">
						</div>
						<input type="text" id="tytul" class="homeworkInput responsive" name="title" placeholder="Tytuł" autocomplete="off">
						<div style="width: 100%; display: flex; align-items: stretch; flex-grow: 2;"><textarea id="opis" name="desc" class="homeworkTextarea" placeholder="Opis…"></textarea></div>
					</div></div>
					<button type="submit" class="addHomeworkButton big">dodaj</button>
				</form>
  			</div>
		</div>
	</div>
	<script> setInputs(); </script>
</body>
</html>
