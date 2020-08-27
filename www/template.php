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

	<!-- here add links to files -->

</head>
<body>
  <div class="container">
    <?php require('topbar.php') ?>
    <div class="content">

    <!-- here put page content -->

    </div>
  </div>
</body>
</html>
