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
  <script src="utils.js"></script>
</head>
<body>
  <div class="container">
    <?php require('topbar.php') ?>
    <div class="content">
	  <p class="headline">Support & Credits</p>
	  <h3>Napisz do supportu: support@rakbook.pl</h3>
	  <h3>Zajrzyj na kanał rakbooka na discord: <a href="https://discord.gg/YMexc5W">rakbook-feedback</a>
	  <h3>Chcesz pomóc w rozwoju rakbooka? Mamy repozytorium na <a href="https://github.com/Rakbook/rakbook">githubie</a></h3>
	  <br/><br/>
	  <h3>Użwane Grafiki:</h3>
	  <p style="margin: 5px;"><a href="https://publicdomainvectors.org/en/free-clipart/Golden-dollar-coin/83958.html">Rakcoin</a> from publicdomainvectors.org under Public Domain license - edited</p>
	  <p style="margin: 10px 5px;">All other graphics created by Rakbook Development Team. <br/> You can use them freely, but please remember to credit us somewhere in your project. The license is <a href="https://creativecommons.org/licenses/by/3.0/">CC BY 3.0</a>.</p>
	</div>
  </div>
  <script> centerContent(); </script>
</body>

</html>
