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
            <span>• 27.08.20 - Rakbook jest teraz open-source - nasze <a href="https://github.com/Rakbook/rakbook">repozytorium</a></span>
						<span>• 27.08.20 - Rework strony z cytatami.</span>
						<span>• 20.08.20 - Wsparcie dla drag and drop przy dodawaniu mema.</span>
						<span>• 15.08.20 - Nowe GUI dla dyżurnych.</span>
            <span>• 14.08.20 - Nowe GUI dodawania cytatów i memeów.</span>
            <span>• 01.06.20 - Wersja alfa <a href="rakbook.apk">aplikacji.</a></span>
            <span>• 23.04.20 - Nowa szata graficzna sklepu ze stylami.</span>
      </div></div>
    </div>
  </div>
</body>
</html>
