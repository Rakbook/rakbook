<?php

session_start();
if(!isset($_SESSION['loggedin'])&&$_SESSION['loggedin']!=true)
{
	header("Location: index.php");
	die();
}

include("requestuserdata.php");
require_once('userinfo.php');

?>

<!DOCTYPE html>
<html>
<head>
  <?php require('standardHead.php'); ?>
	<link rel="stylesheet" type="text/css" href="nodzu.css">
	<script src="nodzu.js"></script>
</head>
<body>
  <div class="container">
    <?php require('topbar.php') ?>
    <div class="content">
<h1>Streszeczenia</h1>
<p>Inteligentne narzędzie do generowania streszczeń tekstu (kompresja stratna)</p>
<p>Stopień kompresji: <span id="stopien"></span>%</p>
<div class="slidecontainer">
  0% <input type="range" min="1" max="100" value="50" class="slider" id="myRange"> 100%
</div>
<textarea name="streszczenie" id="kompresja" class=streszczeniee></textarea> <br>
<button type="button" name="kompresja"  class="komp" onclick="kompresja()">Kompresuj!</button>
<script type="text/javascript">
var slider = document.getElementById("myRange");
var output = document.getElementById("stopien");
output.innerHTML = slider.value;

slider.oninput = function() {
	output.innerHTML = this.value;
}
</script>
<p id="fajnie"></p>
    </div>
  </div>
</body>
</html>
