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
</head>
<body>
  <div class="container">
    <?php require('topbar.php') ?>
    <div class="content">
			<p class="headline">Support & Creddits</p>
			<h3>Napisz do supportu: support@rakbook.pl</h3>
			<h3>Zajrzyj na kanał rakbooka na discord: <a href="https://discord.gg/YMexc5W">rakbook-feedback</a>
			<!---<h3>Chcesz pomóc w rozwoju rakbooka? Mamy repozytorium na <a href="https://github.com/LifeHasNoPurpose/rakbook">githubie</a></h3>-->
			<br/><br/><br/>
			<h3>Użwane Grafiki:</h3>
			<p style="margin: 5px;"><a href="https://commons.wikimedia.org/wiki/File:Cog_font_awesome.svg">Settings icon</a> by Dave Gandy under Creative Commons Attribution-Share Alike 3.0 Unported license</p>
			<p style="margin: 5px;"><a href="https://commons.wikimedia.org/wiki/File:Toicon-icon-stone-pin.svg">Pin icon</a> by Shannon E Thomas/toicon.com  under Creative Commons Attribution 4.0 International license</p>
			<p style="margin: 5px;"><a href="https://publicdomainvectors.org/en/free-clipart/Golden-dollar-coin/83958.html">Rakcoin</a> from publicdomainvectors.org under Public Domain license, edited by Mateusz Sobkowiak</p>
			<p style="margin: 5px;">Menu icon by Mateusz Sobkowiak</p>
	  </div>
  </div>
</body>
</html>
