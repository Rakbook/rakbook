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

function printcat(string $cat)
{
    $result=easyQuery('SELECT content, link FROM zadania WHERE category=?', 's', $cat);

    while($row=$result->fetch_assoc())
    {
        echo '<a target="blank" href="'.$row['link'].'"><div class="homeworkRedirect">• '.$row['content'].'</div></a>';
    }
}

function countcat(string $cat)
{
    $result=easyQuery('SELECT COUNT(id) AS count FROM zadania WHERE category=?', 's', $cat);
    return $result->fetch_assoc()['count'];
}

?>

<!DOCTYPE html>
<html>
<head>
  <?php require('standardHead.php'); ?>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
	<link rel="stylesheet" type="text/css" href="homework.css">
  <link rel="stylesheet" type="text/css" href="announcementColors.css">
	<script src="homework.js"></script>
</head>
<body>
  <div class="container">
    <?php require('topbar.php') ?>
    <div class="content">
      <div class="headline">Zadania Domowe</div>

      <div class="homeworkButtonPanel">
				<div class="homeworkSmallButton" onclick="showInfo()">i</div>
        <?php
          if($_SESSION['redaktor']||$_SESSION['userisadmin'])
          {
						echo '<a href="dodajZadanieDomowe.php"><div class="homeworkSmallButton">+</div></a>';
          }
				?>
				<div style="width: 200px; font-size: 24px;"> <-- Przeczytaj info </div>
      </div>

      <div class="homeworkInfoPanel" id="info" style="display: none;"><div class="homeworkInfoPanelBackground">
      Znajdziesz tu informacje o wszystkich obecnych zadaniach domowych. Kliknij lekcję by rozwinąć listę. Liczba po prawej stronie wskazuje całkowitą liczbę zadań byś łatwo mógł ocenić czy pojawiło się jakieś nowe zadanie od ostatniego czasu sprawdzenia.<br/><span style="color: #C0392B">Niektóre zadania są jednocześnie linkami!</span><br/><br/>Jeśli coś ci się nie zgadza lub czegoś brakuje <a style="color: #2471A3;" href="support.php">napisz do nas!</a>
      </div></div>

      <div class="homework" style="margin-bottom: 200px;">
        <div class="homeworkBox">
          <div class="homeworkPanelContainer">
            <div class="homeworkPanel blue" onclick="showHomeworkDropdown(event)" id="matma">Matematyka</div>
            <div class="homeworkNumber blue"><div class="homeworkNumberBackground"><?php echo countcat('MatematykaAM')+countcat('MatematykaBS'); ?></div></div>
          </div>
          <div class="homeworkDropdown blue" id="matmaDropdown" style="display: none"><div class="homeworkDropdownBackground">
						<div class="homeworkRedirect">A.M.:</div>
            <?php printcat('MatematykaAM') ?>
						<div class="homeworkRedirect">B.S.:</div>
            <?php printcat('MatematykaBS') ?>
          </div></div>
        </div>

        <div class="homeworkBox">
          <div class="homeworkPanelContainer">
            <div class="homeworkPanel red" onclick="showHomeworkDropdown(event)" id="polski">Język Polski</div>
            <div class="homeworkNumber red"><div class="homeworkNumberBackground"><?php echo countcat('Polski'); ?></div></div>
          </div>
          <div class="homeworkDropdown red" id="polskiDropdown" style="display: none"><div class="homeworkDropdownBackground">
            <?php printcat('Polski') ?>
          </div></div>
        </div>

        <div class="homeworkBox">
          <div class="homeworkPanelContainer">
            <div class="homeworkPanel green" onclick="showHomeworkDropdown(event)" id="chemia">Chemia</div>
            <div class="homeworkNumber green"><div class="homeworkNumberBackground"><?php echo countcat('Chemia');?></div></div>
          </div>
          <div class="homeworkDropdown green" id="chemiaDropdown" style="display: none"><div class="homeworkDropdownBackground">
            <?php printcat('Chemia') ?>
          </div></div>
        </div>

        <div class="homeworkBox">
          <div class="homeworkPanelContainer">
            <div class="homeworkPanel yellow" onclick="showHomeworkDropdown(event)" id="fizyka" >Fizyka</div>
            <div class="homeworkNumber yellow"><div class="homeworkNumberBackground"><?php echo countcat('Fizyka');?></div></div>
          </div>
          <div class="homeworkDropdown yellow" id="fizykaDropdown" style="display: none"><div class="homeworkDropdownBackground">
            <?php printcat('fizyka') ?>
          </div></div>
        </div>

        <div class="homeworkBox">
          <div class="homeworkPanelContainer">
            <div class="homeworkPanel green" onclick="showHomeworkDropdown(event)" id="pp">Podstawy przedsiębiorczości</div>
            <div class="homeworkNumber green"><div class="homeworkNumberBackground"><?php echo countcat('PP');?></div></div>
          </div>
          <div class="homeworkDropdown green" id="ppDropdown" style="display: none"><div class="homeworkDropdownBackground">
            <?php printcat('PP') ?>
          </div></div>
        </div>

        <div class="homeworkBox">
          <div class="homeworkPanelContainer">
            <div class="homeworkPanel blue" onclick="showHomeworkDropdown(event)" id="informatyka">Informatyka</div>
            <div class="homeworkNumber blue"><div class="homeworkNumberBackground"><?php echo countcat('InformatykaAK')+countcat('InformatykaKC');?></div></div>
          </div>
          <div class="homeworkDropdown blue" id="informatykaDropdown" style="display: none"><div class="homeworkDropdownBackground">
            <div class="homeworkRedirect">Grupa A.K.:</div>
            <?php printcat('InformatykaAK') ?>
            <div class="homeworkRedirect">Grupa K.C.:</div>
            <?php printcat('InformatykaKC') ?> <!-- tego typu rzeczy można wywalić i po prostu ktoś to doda później -->
          </div></div>
        </div>

        <div class="homeworkBox">
          <div class="homeworkPanelContainer">
            <div class="homeworkPanel green" onclick="showHomeworkDropdown(event)" id="biologia">Biologia</div>
            <div class="homeworkNumber green"><div class="homeworkNumberBackground"><?php echo countcat('Biologia')?></div></div>
          </div>
          <div class="homeworkDropdown green" id="biologiaDropdown" style="display: none"><div class="homeworkDropdownBackground">
              <?php printcat('biologia') ?>
          </div></div>
        </div>

        <div class="homeworkBox">
          <div class="homeworkPanelContainer">
            <div class="homeworkPanel red" onclick="showHomeworkDropdown(event)" id="angielski">Język Angielski</div>
            <div class="homeworkNumber red"><div class="homeworkNumberBackground"><?php echo countcat('AngielskiAO')+countcat('AngielskiMN');?></div></div>
          </div>
          <div class="homeworkDropdown red" id="angielskiDropdown" style="display: none"><div class="homeworkDropdownBackground">
            <div class="homeworkRedirect">Grupa A.O.:</div>
            <?php printcat('AngielskiAO') ?>
            <div class="homeworkRedirect">Grupa M.N.:</div>
            <?php printcat('AngielskiMN') ?>
          </div></div>
        </div>

        <div class="homeworkBox">
          <div class="homeworkPanelContainer">
            <div class="homeworkPanel blue" onclick="showHomeworkDropdown(event)" id="niemiecki">Język Niemiecki</div>
            <div class="homeworkNumber blue"><div class="homeworkNumberBackground"><?php echo countcat('NiemieckiP')+countcat('NiemieckiS')+countcat('NiemieckiZ');?></div></div>
          </div>
          <div class="homeworkDropdown blue" id="niemieckiDropdown" style="display: none"><div class="homeworkDropdownBackground">
            <div class="homeworkRedirect">Grupa podstawowa:</div>
            <?php printcat('NiemieckiP') ?>
            <div class="homeworkRedirect">Grupa średniozaawansowana:</div>
            <?php printcat('NiemieckiS') ?>
            <div class="homeworkRedirect">Grupa zaawansowana:</div>
            <?php printcat('NiemieckiZ') ?>
          </div></div>
        </div>

        <div class="homeworkBox">
          <div class="homeworkPanelContainer">
            <div class="homeworkPanel yellow" onclick="showHomeworkDropdown(event)" id="hiszpanski">Język Hiszpański</div>
            <div class="homeworkNumber yellow"><div class="homeworkNumberBackground"><?php echo countcat('Hiszpanski1')+countcat('Hiszpanski2');?></div></div>
          </div>
          <div class="homeworkDropdown yellow" id="hiszpanskiDropdown" style="display: none"><div class="homeworkDropdownBackground">
              <div class="homeworkRedirect">Hiszp1:</div>
            <?php printcat('Hiszpanski1') ?>
              <div class="homeworkRedirect">Hiszp2:</div>
              <?php printcat('Hiszpanski2') ?>
          </div></div>
        </div>

        <div class="homeworkBox">
          <div class="homeworkPanelContainer">
            <div class="homeworkPanel red" onclick="showHomeworkDropdown(event)" id="historia">Historia</div>
            <div class="homeworkNumber red"><div class="homeworkNumberBackground"><?php echo countcat('Historia');?></div></div>
          </div>
          <div class="homeworkDropdown red" id="historiaDropdown" style="display: none"><div class="homeworkDropdownBackground">
              <?php printcat('historia') ?>
          </div></div>
        </div>

        <div class="homeworkBox">
          <div class="homeworkPanelContainer">
            <div class="homeworkPanel blue" onclick="showHomeworkDropdown(event)" id="wos">Wiedza o społeczeństwie</div>
            <div class="homeworkNumber blue"><div class="homeworkNumberBackground"><?php echo countcat('Wos')?></div></div>
          </div>
          <div class="homeworkDropdown blue" id="wosDropdown" style="display: none"><div class="homeworkDropdownBackground">
              <?php printcat('Wos') ?>
          </div></div>
        </div>

        <div class="homeworkBox">
          <div class="homeworkPanelContainer">
            <div class="homeworkPanel yellow" onclick="showHomeworkDropdown(event)" id="geografia">Geografia</div>
            <div class="homeworkNumber yellow"><div class="homeworkNumberBackground"><?php echo countcat('Geografia');?></div></div>
          </div>
          <div class="homeworkDropdown yellow" id="geografiaDropdown" style="display: none"><div class="homeworkDropdownBackground">
              <?php printcat('geografia') ?>
          </div></div>
        </div>

        <div class="homeworkBox">
          <div class="homeworkPanelContainer">
            <div class="homeworkPanel green" onclick="showHomeworkDropdown(event)" id="edb">Edukacja dla bezpieczeństwa</div>
            <div class="homeworkNumber green"><div class="homeworkNumberBackground"><?php echo countcat('Edb');?></div></div>
          </div>
          <div class="homeworkDropdown green" id="edbDropdown" style="display: none"><div class="homeworkDropdownBackground">
            <?php printcat('Edb') ?>
          </div></div>
        </div>

        <div class="homeworkBox">
          <div class="homeworkPanelContainer">
            <div class="homeworkPanel yellow" onclick="showHomeworkDropdown(event)" id="inne">Inne</div>
            <div class="homeworkNumber yellow"><div class="homeworkNumberBackground"><?php echo countcat('InneWok')+countcat('InneWF')+countcat('Inne');?></div></div>
          </div>
          <div class="homeworkDropdown yellow" id="inneDropdown" style="display: none"><div class="homeworkDropdownBackground">
            <div class="homeworkRedirect">Wiedza o kulturze:</div>
            <?php printcat('InneWok') ?>
            <div class="homeworkRedirect">Wychowanie fizyczne:</div>
            <?php printcat('InneWF') ?>
              <div class="homeworkRedirect">Inne:</div>
              <?php printcat('Inne') ?>
          </div></div>
        </div>
      </div>
    </div>
  </div>
</body>
</html>
