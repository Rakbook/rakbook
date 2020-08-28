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
	<link rel="stylesheet" type="text/css" href="changelog.css">
</head>
<body>
  <div class="container">
    <?php require('topbar.php') ?>

    <div class="content">
      <div class="changelogContainer">
        <p class="changelogHeader"> &nbsp; changelog </p>
        <div class="changelog">
          <!-- changes are in changelog.html -->
          <?php
            $myfile = fopen("changelog.html", "r");
            $content = fread($myfile,filesize("changelog.html"));
            fclose($myfile);
            $content = preg_split('/\n/', $content);
            for ($i=0; $i < count($content); $i++) { 
              echo "<span>".$content[$i]."</span>";
            }

          ?>
      </div></div>
    </div>
  </div>
</body>
</html>
