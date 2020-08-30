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
</head>
<body>
  <div class="Container">
    <?php require('Topbar.php') ?>

    <div class="Content">
      <!-- Tutaj fajne rzeczy -->
    </div>
  </div>
</body>
</html>
