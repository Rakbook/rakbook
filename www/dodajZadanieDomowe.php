<?php

session_start();
if(!isset($_SESSION['loggedin'])&&$_SESSION['loggedin']!=true)
{
	header("Location: index.php");
	die();
}

include("requestuserdata.php");
require_once('userinfo.php');
require_once('dbutils.php');

if(isset($_POST['content'])&&isset($_POST['category'])&&isset($_POST['link']))
{
    if(strlen($_POST['content'])>0)
    {
        easyQuery('INSERT INTO zadania (category, content, link, date) VALUES (?, ?, ?, ?)', 'ssss', $_POST['category'], $_POST['content'], $_POST['link'], $_POST['date']);
        header('Location: zadaniaDomowe.php');
    }
}

?>

<!DOCTYPE html>
<html>
<head>
  <?php require('standardHead.php'); ?>
	<link rel="stylesheet" type="text/css" href="homework.css">
	<link rel="stylesheet" type="text/css" href="divColors.css">
	<script src="homework.js"></script>
</head>
<body>
  <div class="container">
    <?php require('topbar.php') ?>
    <div class="content">
      <div class="headline">Dodaj Zadanie Domowe</div>

			<div class="homeworkInfoPanel"><div class="homeworkInfoPanelBackground" style="padding-top: 10px; padding-bottom: 10px;">
      1. Pisz skrótami myślowymi! Postaraj się nie przekroczyć magicznej granicy <span style="color: #E74C3C;">40</span> znaków! <br/><br/>  2. Pamiętaj o dodaniu informacji o terminie i miejscu zamieszczenia zadania domowego. <br/><br/> 3. Korzystaj z opcji linku by stworzyć odnośnik np. do filmu na yt czy dziennika. <br/><br/> <span style="color: #2471A3;"</span> Przykład: Symetrie osiowe 20.03 (moodle)
      </div></div>

			<div class="homeworkInfoPanel"><div class="homeworkInfoPanelBackground addHomework">
			<form action="" method="post"><label for="Kategoria">Kategoria:</label>
				<select id="kategoria" class="addHomeworkInput" name="category">
          <option value="MatematykaAM">Matematyka A.M.</option>
          <option value="MatematykaBS">Matematyka B.S.</option>
          <option value="Polski">Język polski</option>
          <option value="Chemia">Chemia</option>
          <option value="Fizyka">Fizyka</option>
          <option value="PP">Podstawy przedsiębiorczości</option>
          <option value="InformatykaAK">Informatyka A.K.</option>
          <option value="InformatykaKC">Informatyka K.C.</option>
          <option value="Biologia">Biologia</option>
          <option value="AngielskiAO">Język angielski A.O.</option>
          <option value="AngielskiMN">Język angielski M.N.</option>
          <option value="NiemieckiP">Język niemiecki podstawowa</option>
          <option value="NiemieckiS">Język niemiecki średniozaawansowana</option>
          <option value="NiemieckiZ">Język niemiecki zaawansowana</option>
          <option value="Hiszpanski1">Język hiszpański 1</option>
          <option value="Hiszpanski2">Język hiszpański 2</option>
          <option value="Historia">Historia</option>
          <option value="Wos">Wiedza o społeczeństwie</option>
          <option value="Geografia">Geografia</option>
          <option value="Edb">Edukacja dla bezpieczeństwa</option>
          <option value="InneWok">Wiedza o kulturze</option>
          <option value="InneWF">Wychowanie fizyczne</option>
          <option value="Inne">Inne</option>
				</select>
				<label for="Tresc">Treść:</label> <input type="text" id="tresc" class="addHomeworkInput" name="content">
				<label for="Link">Link (opcjonalne, zalecane)</label><input type="text" id="link" class="addHomeworkInput" name="link">
				<label for="Data">Data:</label> <input type="date" id="data" class="addHomeworkInput" name="date">
			</div></div>
			<button type="submit" class="homeworkSmallButton" style="width: 80px; height: 35px; margin-left: auto; margin-right: auto; margin-top: 25px; margin-bottom: 200px;">Dodaj</button> <!-- onclick = dodaj zadanie domowe -->
    	</form>
  	</div>
	</div>
</body>
</html>
