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

    if($result->num_rows>0)
	{
		$row=$result->fetch_assoc();
		if(!password_verify($_POST['oldpass'], $row['user_pass']))
		{
			$passincorrect=true;
			$passchangesuccess=false;
		}
	}else
	{
		die("Stało się coś co stać się nie powinno");
    }

    $minpasslength=8;

	if(strlen($_POST['password'])<$minpasslength)
	{
		$passtoshort=true;
		$passchangesuccess=false;
	}

	if($_POST['password']!=$_POST['repeatpassword'])
	{
		$passdontmatch=true;
		$passchangesuccess=false;
	}

    if($passchangesuccess)
	{
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
    <div class="content">
			<form action="" method="post" autocomplete="off">
				<div class="headline"> Zmień swoje hasło </div>
				<div class="newinputfield">
					Stare hasło: &nbsp;<input type="password" name="oldpass" value=""/>
					<?php if(isset($passincorrect)&&$passincorrect){ echo(" Hasło jest niepoprawne "); } ?>
				</div>
				<div class="newinputfield">
					Nowe hasło: &nbsp;<input type="password" name="password"/>
					<?php if(isset($passtoshort)&&$passtoshort){ echo(" Hasło musi mieć co najmniej ".$minpasslength." znaków"); } ?>
				</div>
				<div class="newinputfield">
					Powtórz hasło: &nbsp;<input type="password" name="repeatpassword"/>
					<?php if(isset($passdontmatch)&&$passdontmatch){ echo(" Hasła są różne"); } ?>
				</div>
				<input class="loginbutton" type="submit" name="wyslanoformularz" value="Zmień hasło"/>
				<?php if(isset($passchangesuccess)&&$passchangesuccess){ echo(" Hasło zostało zmienione"); } ?>
			</form>
  	</div>
	</div>
</body>
</html>
