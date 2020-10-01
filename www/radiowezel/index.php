<!DOCTYPE HTML>
<html lang="pl">
<head>
	<meta charset="utf-8">
	<title>Radiowęzeł sugestie</title>
	<link rel="stylesheet" href="style.css">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
	<script src="script.js"></script>
</head>
<body>
	<input type="number" id="pages" min="1" value="1"> Ilość stron<br>
	<input type="checkbox" id="waiting" onchange="refresh()" checked> Oczekujące
	<input type="checkbox" id="rejected" onchange="refresh()" checked> Odrzucone
	<input type="checkbox" id="accepted" onchange="refresh()" checked> Zatwierdzone <br>
	<input type="button" id="refreshbutton" onclick="refresh()" value="odśwież">
	<div id="result">



	</div>

</body>
</html>