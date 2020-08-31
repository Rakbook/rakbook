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

function printcat(string $cat)
{
    $result=easyQuery('SELECT content, link FROM zadania WHERE category=?', 's', $cat);

    while($row=$result->fetch_assoc())
    {
        echo '<a target="blank" href="'.$row['link'].'"><div class="homeworkRedirect">• '.$row['content'].'</div></a>';
    }
}

function countcat(string $cat)
{
    $result=easyQuery('SELECT COUNT(id) AS count FROM zadania WHERE category=?', 's', $cat);
    return $result->fetch_assoc()['count'];
}


?>

<!DOCTYPE html>
<html>
<head>
  <?php require('standardHead.php'); ?>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
	<link rel="stylesheet" type="text/css" href="homework.css">
  <link rel="stylesheet" type="text/css" href="announcementColors.css">
	<script src="homework.js"></script>
</head>
<body>
  <div class="container">
    <?php require('topbar.php') ?>
    <div class="content">
      <div class="headline">Zadania Domowe</div>
		<!-- v1
			<div class="homeworkContainer">
				<div class="dayPanel green"><div class="day">Dzisiaj</div><div class="number"><div class="numberBackground">1</div></div></div>
				<div class="dayPanel blue"><div class="day">Jutro</div><div class="number"><div class="numberBackground">0</div></div></div>
				<div class="dayPanel yellow"><div class="day">Środa</div><div class="number"><div class="numberBackground">4</div></div></div>
				<div class="dayPanel yellow"><div class="day">Czwartek</div><div class="number"><div class="numberBackground">0</div></div></div>
				<div class="dayPanel yellow"><div class="day">Piątek</div><div class="number"><div class="numberBackground">2</div></div></div>
			</div>
			<div class="dayPopup red"><div class="text"></div><div id="close">Zamknij mnie</div></div>
		--><!-- v2 -->
		<div class="homeworkContainer">
			<div class="dayPanel green"><div class="day">Dzisiaj</div><div class="number"><div class="numberBackground">1</div></div></div>
			<div class="dayPanel blue"><div class="day">Jutro</div><div class="number"><div class="numberBackground">0</div></div></div>
			<div class="dayPanel red"><div class="day">Ten tydzień</div><div class="number"><div class="numberBackground">4</div></div></div>
			<div class="dayPanel yellow"><div class="day">zadania długoterminowe</div><div class="number"><div class="numberBackground">0</div></div></div>
		</div>
		<div class="dayPopup green"><div class="text"></div><div id="close">Zamknij mnie</div></div>
		</div>
	</div>
</body>
</html>
