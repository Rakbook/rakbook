<?php

session_start();
if(!isset($_SESSION['loggedin'])&&$_SESSION['loggedin']!=true)
{
	header("Location: index.php");
	die();
}

include("requestuserdata.php");
require_once('userinfo.php');
if(isset($_POST["pnazwa"]))
{
if((strlen($_POST["kontent"])/2)>40)
{
	header("Location: playlist.php");
}else{
	if(getusersrakcoins($_SESSION['userid'])<20)
	{
			$komunikat = "Masz za mało <img src=\"images/Rakcoin.svg\" class=\"RakcoinImage\">!";
	}else{
$komunikat = "Pomyślnie utworzono nową playlistę! Możesz ją teraz zobaczyć <a href=\"playlists.php\">tutaj</a>";
require_once("dbutils.php");
easyQuery("INSERT INTO playlisty (nazwa, autor, zawartosc) VALUES (?, ?, ?)", "sis", $_POST["pnazwa"], $_SESSION['userid'], $_POST["kontent"]);
unset($_POST["pnazwa"]);
unset($_POST["kontent"]);
giverakcoins($_SESSION['userid'], -20);
	}

}
}else{
if(isset($_POST['todelete']))
{
$result=easyQuery("SELECT * FROM playlisty WHERE id=?", "i", $_POST['todelete']);
$row = $result->fetch_assoc();
if($row["autor"]!=$_SESSION['userid']){
	$komunikat = "Nie kombinuj dziubeczku";
}	else{
easyQuery("DELETE FROM playlisty WHERE id=?", "i", $_POST['todelete']);
giverakcoins($_SESSION['userid'], 15);
$komunikat = "Pomyślnie usunięto playlistę. Zwracamy ci 15 <img src=\"images/Rakcoin.svg\" class=\"RakcoinImage\">!";
}
}else{


	header("Location: playlist.php");
}}
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
    <div class="content"><p>
<?php
echo $komunikat;
 ?></p>
    </div>
  </div>
</body>
</html>
