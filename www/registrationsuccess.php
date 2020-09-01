<?php
session_start();
if(!isset($_SESSION['registrationsuccess'])){
	header('Location: index.php');
	die();
}

unset($_SESSION['registrationsucces']);
?>

<!doctype html>
<html>
<head>
<?php require('standardHead.php'); ?>
</head>
<body>
	<div style="display: flex; justify-content: center; align-items: center; font-size: 20px; flex-direction: column; height: 100vh">
		Rejestracja oczekuje na potwierdzenie przez administratorów serwisu (najczęściej czas oczekiwania ~1 minuta)<br>
		Jeśli ten system rejestracji Ci nie odpowiada, możesz nas zwyzywać wysyłając maila na adres support@rakbook.pl<br>
		W przeciwnym wypadku czekaj cierpliwie<br>
		<a href="index.php">Wróć do strony głównej</a>
	</div>
</body>
</html>

<?php
session_unset();
session_destroy();
?>
