<?php
session_start();
if(isset($_SESSION['loggedin'])){
	if($_SESSION['loggedin']==true){
		header("Location: main.php");
		die();
	}
}

if(isset($_COOKIE['remembercookie'])){
	header("Location: login.php");
	die();
}
?>

<!DOCTYPE html>
<html>
<head>
	<?php require('standardHead.php'); ?>
	<link rel="stylesheet" type="text/css" href="style2.css">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
	<meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1, maximum-scale=1">
</head>
<body>
	<div class="container">
		<div class="header">Rakbook</div>
		<form class="login" action="login.php" method="post">
			<div class="loginBackground">
    		<div class="login-welcome" style="font-size: 4vh;">Logowanie</div>
				<div class="login-username">Login: &nbsp; <input type="text" name="username" value="<?php if(isset($_SESSION['loginattemptname'])) echo($_SESSION['loginattemptname']); ?>"/></div>
				<div class="login-password">Hasło: &nbsp; <input type="password" name="pass" value="<?php if(isset($_SESSION['loginattemptpass'])) echo($_SESSION['loginattemptpass']); ?>"/></div>
				<div class="login-remember"><input type="checkbox" id="ch" style="width: 15px" name="remember"><label for="ch" style="font-size: 2vh">Zapamiętaj mnie</label></div>
				<div class="login-log-in"><div style="text-align: center;"></div><input type="submit" value="Zaloguj się" class="submit"></div>
				<span><?php if(isset($_SESSION['loginerr'])) echo'<span style="font-size: 20px ">'.$_SESSION['loginerr'].'</span>'; ?></span>
				<div class="login-sign-up"><a href="register.php">Zarejestruj się</a></div>
			</div>
		</form>
		<div class="info">
			<a href="rakbook.apk">Aplikacja</a>
      <p>Rakbook używa ciasteczek do obsługi funkcjonalności logowania i trwałego logowania</p>
			<p>W przypadku jakichkolwiek problemów lub pytań można się z nami skontaktować wysyłając maila na adres support@rakbook.pl</p>
		</div>
	</div>
<script type="text/javascript">
	$(document).ready(function() {
		setTimeout(function () {
			let viewheight = $(window).height();
			let viewwidth = $(window).width();
			let viewport = document.querySelector("meta[name=viewport]");
			viewport.setAttribute("content", "height=" + viewheight + "px, width=" + viewwidth + "px, initial-scale=1.0");
		}, 300);
	});
</script>
</body>
</html>

<?php
	session_unset();
	session_destroy();
?>
