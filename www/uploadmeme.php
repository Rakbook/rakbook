<?php

session_start();
if(!isset($_SESSION['loggedin'])&&$_SESSION['loggedin']!=true)
{
	header("Location: index.php");
	die();
}

require_once('dbutils.php');
?>

<!DOCTYPE html>
<html>
<head>
  <?php require('standardHead.php'); ?>
	<link rel="stylesheet" type="text/css" href="divColors.css">
	<link rel="stylesheet" type="text/css" href="announcements.css">
	<link rel="stylesheet" type="text/css" href="memes.css">
	<script src="memes.js"></script>
</head>
<body>
  <div class="container">
    <?php require('topbar.php') ?>

    <div class="content">
      <p class="headline">Dodaj mema</p>
				<div class="memeBoxField">
        	<form method="post" action="" enctype="multipart/form-data">
          	<div id="memeBox" class="box">
            	<input type="text" name="title"class="announcementInput" style="text-align: center;" placeholder="Wprowadź tutuł" autocomplete="off"></input>
							<div class="alertBox">
							<?php

								if(isset($_FILES["fileToUpload"])){
									$target_dir = "memy/";

									if (is_uploaded_file($_FILES['fileToUpload']['tmp_name'])){
										$allowed = array('gif', 'png', 'jpg', 'jpeg', 'jfif');
										$imageFileType = strtolower(pathinfo($_FILES['fileToUpload']['name'], PATHINFO_EXTENSION));

										if(in_array($imageFileType, $allowed)){
											if(getimagesize($_FILES["fileToUpload"]["tmp_name"])!==false){
												if ($_FILES["fileToUpload"]["size"] <= 5*1024*1024){
													$filehash=sha1_file($_FILES["fileToUpload"]["tmp_name"]);
													$target_file = $target_dir . $filehash .'.'. $imageFileType;

													if(easyQuery("SELECT id FROM memy WHERE file=?","s", $target_file)->fetch_assoc()){
														echo 'Ten mem już istnieje!';
													}
													else{
														if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)){
															easyQuery("INSERT INTO memy (authorid, title, file) VALUES (?, ?, ?)", "iss", $_SESSION['userid'], htmlentities($_POST['title']), $target_file);
															echo 'Mem został wysłany pomyślnie';
															header('Location: memy.php');
														}
														else{
															echo 'Nie udało się wysłać mema';
														}
													}
												}
												else{
													echo('Plik może mieć maksymalnie 5MB!');
												}
											}
											else{
												echo('To nie jest obraz!');
											}
										}
										else{
											echo('Dozwolone są tylko rozszerzenia gif png jpg!');
										}
									}
									else{
										echo('Nie wybrano pliku!');
									}
								}
								?>
							</div>
            	<div class="announcementContent" style="overflow: hidden; height: 80px;">
								<label id="upload-label" for="file-upload" class="memeInput"><span class="click">Kliknij</span> &nbsp;albo przenieś plik</label><input id="file-upload" type="file" accept="image/x-png,image/gif,image/jpeg" name="fileToUpload" onchange="zmienNazwe();"></input></div>
						</div>
          	<input type="submit" name="submit" value="Dodaj mema" class="addAnnouncementButton"></input>
      	</form>
			</div>
    </div>
  </div>
	<script> randomColorClass(memeBox); trigger();  scale(); window.addEventListener('resize', scale); </script>
</body>
</html>
