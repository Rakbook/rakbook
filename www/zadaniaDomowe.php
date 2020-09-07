<?php

session_start();
if(!isset($_SESSION['loggedin'])&&$_SESSION['loggedin']!=true){
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
  <?php require("standardHead.php"); ?>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
	<link href="https://fonts.googleapis.com/css2?family=Fredoka+One&display=swap" rel="stylesheet">
	<link rel="stylesheet" type="text/css" href="homework.css">
  <link rel="stylesheet" type="text/css" href="divColors.css">
	<script src="homework.js"></script>
</head>
<body style="min-height: 100vh;">
  <div class="container">
    <?php require("topbar.php") ?>
    <div class="content">
				<?php require('loadHomeworkList.php'); ?>
		</div>
	</div>
</body>
</html>
