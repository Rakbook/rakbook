<?php

session_start();

if(isset($_POST['wyslanoformularz'])
	&&isset($_POST['username'])
	&&isset($_POST['password'])
	&&isset($_POST['repeatpassword'])
	&&isset($_POST['nrdziennik']))
{
	$usernametaken=false;
	$usernametoshort=false;
	$nrwdziennikutaken=false;
	$nrwdziennikunotvalid=false;
	$passtoshort=false;
	$passdontmatch=false;
	$registrationsuccess=true;
	
	require_once('dbutils.php');

	$result = easyQuery('SELECT id FROM users WHERE user_name=?', 's', $_POST['username']);

	if($result->num_rows>0)
	{
		$usernametaken=true;
		$registrationsuccess=false;
	}

	$minusernamelength=3;
	$maxusernamelength=10;

	if(strlen($_POST['username'])<$minusernamelength||strlen($_POST['username'])>$maxusernamelength)
	{
		$usernametoshort=true;
		$registrationsuccess=false;
	}

	$dzienniknum=intval($_POST['nrdziennik']);
	$maxdzienniknum=33;
	if($dzienniknum<1||$dzienniknum>$maxdzienniknum)
	{
		if($dzienniknum!=41&&$dzienniknum!=666)
		{
			$nrwdziennikunotvalid=true;
			$registrationsuccess=false;
		}
	}

	$result=easyQuery('SELECT id FROM users WHERE user_nrwdzienniku=?', 'i', $_POST['nrdziennik']);

	if($result->num_rows>0)
	{
		$nrwdziennikutaken=true;
		$registrationsuccess=false;
	}

	$minpasslength=8;

	if(strlen($_POST['password'])<$minpasslength)
	{
		$passtoshort=true;
		$registrationsuccess=false;
	}

	if($_POST['password']!=$_POST['repeatpassword'])
	{
		$passdontmatch=true;
		$registrationsuccess=false;
	}

	if($registrationsuccess)
	{
		$passhash=password_hash($_POST['password'], PASSWORD_DEFAULT);

		$query="INSERT INTO users (user_name, user_pass, user_nrwdzienniku) VALUES(?, ?, ?)";
		easyQuery($query, "ssi", $_POST['username'], $passhash, $dzienniknum);

		$to = getenv('NEW_USER_EMAILS');
		$topic = "Nowy użytkownik!";
		$content = "Nowy użytkownik chce dołączyć do Rakbooka! Jego nazwa: ".$_POST['username'].". Jego numer w dzienniku: ".$_POST['nrdziennik'];
		mail($to, $topic, $content);

		$_SESSION['registrationsuccess']=true;
		header('Location: registrationsuccess.php');
		die();
	}
}

?>

<!DOCTYPE html>
<html>
<head>
  <?php require('standardHead.php'); ?>
	<link rel="stylesheet" type="text/css" href="style2.css">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
</head>
<body>
  <div class="container">
		<div class="alertbox">
		<?php
			if(isset($usernametaken)&&$usernametaken){
				echo(" Ta nazwa użytkownika jest zajęta "); echo '<br/>';
			}
			if(isset($usernametoshort)&&$usernametoshort){
				echo(" Nazwa musi zawierać od ".$minusernamelength." do ".$maxusernamelength." znaków"); echo '<br/>';
			}
			if(isset($nrwdziennikutaken)&&$nrwdziennikutaken){
				echo(" Ten numer w dzienniku jest zajęty "); echo '<br/>';
			}
			if(isset($nrwdziennikunotvalid)&&$nrwdziennikunotvalid){
				echo(" Numer w dzienniku musi być liczbą w zakresie od 1 do ".$maxdzienniknum); echo '<br/>';
			}
			if(isset($passtoshort)&&$passtoshort){
				echo(" Hasło musi mieć co najmniej ".$minpasslength." znaków"); echo '<br/>';
			}
			if(isset($passdontmatch)&&$passdontmatch){
				 echo(" Hasła są różne"); echo '<br/>';
			}
		?>
	</div>
    <form action="" method="post" autocomplete="off" class="register">
			<div class="registerBackground">
				<div class="login-welcome" style="font-size: 4vh;">Rakbook Rejestracja</div>
				<div>
					<div class="login-username">Login: &nbsp; <input style="width: 10vw;"type="text" name="username" value="<?php if(isset($_POST['username'])) echo($_POST['username']); ?>"/></div>
					<div class="login-username">Nr w dzienniku: &nbsp;<input style="width: 10vw;" type="number" name="nrdziennik" value="<?php if(isset($dzienniknum)) echo($dzienniknum); ?>"/></div>
					<div class="login-username">Hasło: &nbsp;<input style="width: 10vw;" type="password" name="password"/></div>
					<div class="login-username">Powtórz hasło: &nbsp;<input style="width: 10vw;" type="password" name="repeatpassword"/></div>
				</div>
      	<input class="submit" type="submit" name="wyslanoformularz" value="Zarejestruj się"/>
			</div>
		</form>
  </div>
	<script type="text/javascript">
		$(document).ready(function() {
			setTimeout(function () {
				let viewheight = $(window).height();
				let viewwidth = $(window).width();
				let viewport = document.querySelector("meta[name=viewport]");
				viewport.setAttribute("content", "height=" + viewheight + ", width=" + viewwidth + ", initial-scale=1.0");
			}, 300);
		});
	</script>
</body>
</html>
