<?php

session_start();
if(!isset($_SESSION['loggedin'])&&$_SESSION['loggedin']!=true)
{
	header("Location: index.php");
	die();
}

include("requestuserdata.php");
require_once('userinfo.php');

if(isset($_POST['wyslanoformularz'])
	&&isset($_POST['oldpass'])
	&&isset($_POST['password'])
	&&isset($_POST['repeatpassword']))
{
	$passincorrect=false;
	$passtoshort=false;
	$passdontmatch=false;
	$passchangesuccess=true;

	require_once("dbutils.php");

  $query="SELECT user_pass FROM users WHERE id=?";
  $result=easyQuery($query, "i", $_SESSION['userid']);

  if($result->num_rows>0){
		$row=$result->fetch_assoc();
		if(!password_verify($_POST['oldpass'], $row['user_pass']))
		{
			$passincorrect=true;
			$passchangesuccess=false;
		}
	}
	else{
		die("Stało się coś co stać się nie powinno");
  }

  $minpasslength=8;

	if(strlen($_POST['password'])<$minpasslength){
		$passtoshort=true;
		$passchangesuccess=false;
	}

	if($_POST['password']!=$_POST['repeatpassword']){
		$passdontmatch=true;
		$passchangesuccess=false;
	}

  if($passchangesuccess){
		$passhash=password_hash($_POST['password'], PASSWORD_DEFAULT);
		$query="UPDATE users SET user_pass=? WHERE id=?";
  	easyQuery($query, "si", $passhash, $_SESSION['userid']);
  }
}

?>

<!DOCTYPE html>
<html>
<head>
  <?php require('standardHead.php'); ?>
</head>
<body>
  <div class="container">
  	<?php require('topbar.php') ?>
		<link rel="stylesheet" type="text/css" href="style2.css">
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
		<div class="alertbox">
			<?php
				if(isset($passincorrect)&&$passincorrect){
					echo(" Hasło jest niepoprawne "); echo "<br/>";
				}
				if(isset($passtoshort)&&$passtoshort){
					echo(" Hasło musi mieć co najmniej ".$minpasslength." znaków"); echo "<br/>";
				}
				if(isset($passdontmatch)&&$passdontmatch){
				 	echo(" Hasła są różne"); echo "<br/>";
					}
				if(isset($passchangesuccess)&&$passchangesuccess){
					echo(" Hasło zostało zmienione"); echo "<br/>";
				}
			?>
		</div>
		<form action="" method="post" autocomplete="off" class="register">
			<div class="registerBackground">
				<div class="login-welcome" style="font-size: 4vh;">Zmień swoje hasło</div>
				<div>
					<div class="login-username">Stare hasło: &nbsp;<input type="password" name="oldpass" value=""/></div>
					<div class="login-username">Nowe hasło: &nbsp;<input type="password" name="password"/></div>
					<div class="login-username">Powtórz hasło: &nbsp;<input type="password" name="repeatpassword"/></div>
				</div>
				<input class="submit" type="submit" name="wyslanoformularz" value="Zmień hasło"/>
			</div>
		</form>
	</div>
</body>
</html>
