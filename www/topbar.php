<?php
  echo
  '<link rel="stylesheet" type="text/css" href="topbar.css">
   <script src="topbar.js"></script>
   <div class="topbar">
    <div class="topbarLeft">
      <img src="images/menu.svg" class="menu" onclick="OpenMenuPopup()">
      <a style="color: #FFFFFF;" href="main.php"><div id="title" class="title">Rakbook</div></a>
    </div>

    <div class="topbarRight">
      <img src="images/settings.svg" class="settings" onclick="OpenSettingsPopup()">
    </div>

    <div class="settingsPopup" id="settingspopup">
      <div class="menuContent">
        <div><a class="settingsList" href="changepass.php">Zmień Hasło</a></div>
        <div><a class="settingsList" href="support.php">Support & Creddits</a></div>
        <div><a class="settingsList" href="colorsshop.php">Sklep z Kolorami</a></div>';
        if($_SESSION['userisadmin']==1)
  			{
  			  echo '<div><a class="settingsList" href="panel.php">Panel Administracyjny</a></div>';
  			}
        echo '<div><a class="settingsList" style="color: #7aa9f9;" href="logout.php">Wyloguj się</a></div>
      </div>
    </div>

    <div class="menuPopup" id="menupopup">
      <div class="menuContent">
        <div><a class="menuList" href="announcements.php">Ogłoszenia</a></div>
        <div><a class="menuList" href="materialy.php">Materiały (mail klasowy)</a></div>
        <div><a class="menuList" href="dyzurni.php">Dyżurni</a></div>
        <div><a class="menuList" href="cytaty.php">Cytaty</a></div>
        <div><a class="menuList" href="memy.php">Memy</a></div>
        <div><a class="menuList" href="zadaniaDomowe.php">Zadania domowe</a></div>
        <div><a class="menuList" href="nodzuu.php">Nodzu</a></div>
      </div>
    </div>
  </div>';

  echo '<script> changeTitle();</script>'
?>
