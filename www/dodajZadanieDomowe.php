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

if(isset($_POST['content'])&&isset($_POST['category'])&&isset($_POST['link']))
{
    if(strlen($_POST['content'])>0)
    {
        easyQuery('INSERT INTO zadania (category, content, link, date) VALUES (?, ?, ?, ?)', 'ssss', $_POST['category'], $_POST['content'], $_POST['link'], $_POST['date']);
        header('Location: zadaniaDomowe.php');
    }
}

?>

<!DOCTYPE html>
<html>
<head>
  <?php require('standardHead.php'); ?>
	<link rel="stylesheet" type="text/css" href="homework.css">
	<link rel="stylesheet" type="text/css" href="divColors.css">
	<script src="homework.js"></script>
</head>
<body>
  <div class="container">
    <?php require('topbar.php') ?>
    <div class="content">
      <div class="headline">Dodaj Zadanie Domowe</div>

			<div class="homeworkInfoPanel"><div class="homeworkInfoPanelBackground addHomework">
			<form action="" method="post">
				<label for="Kategoria">Lekcja:</label><input type="text" id="kategoria" class="addHomeworkInput" name="category">
				<label for="Tresc">Treść:</label> <input type="text" id="tresc" class="addHomeworkInput" name="content">
				<label for="Link">Link (opcjonalne, zalecane)</label><input type="text" id="link" class="addHomeworkInput" name="link">
				<label for="Data">Data:</label> <input type="date" id="data" class="addHomeworkInput" name="date">
			</div></div>
			<button type="submit" class="homeworkSmallButton" style="width: 80px; height: 35px; margin-left: auto; margin-right: auto; margin-top: 25px; margin-bottom: 200px;">Dodaj</button>
  	</div>
	</div>
</body>
</html>
