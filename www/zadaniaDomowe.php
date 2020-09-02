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
  <link rel="stylesheet" type="text/css" href="divColors.css">
	<script src="homework.js"></script>
</head>
<body style="min-height: 100vh;">
  <div class="container">
    <?php require('topbar.php') ?>
    <div class="content">
			<div class="homeworkContainer">
				<div class="navPanel"><div class="buttonBar"> <div class="homeworkButton small" style="font-family: serif;">i</div><div class="homeworkButton small">+</div><div class="homeworkButton big"><?php echo date('d.m.Y');?></div> </div></div>
				<div class="titlePanel"> Zadania Domowe</div>
				<div class="homeworkRow">
					<div class="dayPanel green"><div class="day">Dzisiaj</div><div class="number"><div class="numberBackground">1</div></div></div>
					<div class="dayPanel blue"><div class="day">Jutro</div><div class="number"><div class="numberBackground">0</div></div></div>
				</div><div class="homeworkRow">
					<div class="dayPanel red"><div class="day">Ten tydzień</div><div class="number"><div class="numberBackground">4</div></div></div>
					<div class="dayPanel yellow"><div class="day">Zadania długoterminowe</div><div class="number"><div class="numberBackground">0</div></div></div>
				</div>
				<div id="dayPopup" class="green"><div class="dayPopupBackground"><div id="homeworkTitle"></div><div id="homeworkContent">Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum. Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum. Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</div><div id="close">Zamknij mnie</div></div></div>
			</div>
		</div>
	</div>
</body>
</html>
