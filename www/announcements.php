
<?php

session_start();
if(!isset($_SESSION['loggedin'])&&$_SESSION['loggedin']!=true)
{
	header("Location: index.php");
	die();
}

include("requestuserdata.php");
require_once('userinfo.php');

if(isset($_POST['ogloszenietitle'])&&isset($_POST['ogloszenietekst']))
    {
        $title=$_POST['ogloszenietitle'];
        $content=$_POST['ogloszenietekst'];

        if(strlen($title)<1||strlen($content)<1)
        {
            $_SESSION['ogloszenieadderror']='Musisz wypełnić tytuł i treść';
            header('Location: addAnnouncement.php');
            die();
        }else
        {

            $color='blue';
            if(isset($_POST['colorSelector']))
            {
                $color=htmlentities($_POST['colorSelector']);
            }
            $pinned=0;
            if(isset($_POST['pin']))
            {
                $pinned=1;
            }
            $expires=NULL;
            if(isset($_POST['expires'])&&strlen($_POST['expires'])>0)
            {
                $expires=$_POST['expires'];
            }
            $query = "INSERT INTO ogloszenia (title, text, pinned, autor, colorclass, expirydate) VALUES (?, ?, ?, ?, ?, ?)";
            easyQuery($query, "ssiiss", $title, $content, $pinned, $_SESSION['userid'], $color, $expires);

        }
    }

?>

<!DOCTYPE html>
<html>
<head>
  <?php require('standardHead.php'); ?>
	<link rel="stylesheet" type="text/css" href="announcementColors.css">
	<link rel="stylesheet" type="text/css" href="announcements.css">
</head>
<body>
  <div class="container">
    <?php require('topbar.php') ?>
    <div class="content">
			<div class="headline" style="margin-bottom: 10px;">Tablica Ogłoszeń</div>
     	<?php
    		if($_SESSION['redaktor']||$_SESSION['userisadmin']){
	   			echo '<a class="add" href="addAnnouncement.php">Dodaj nowe ogłoszenie</a>';
    		}
    		if(isset($_POST['postToRemove'])){
        	$query = "DELETE FROM ogloszenia WHERE id=?";
        	easyQuery($query, "i", $_POST['postToRemove']);
        	echo "<br>Pomyślnie usunięto ogłoszenie!<br>";
    		}
      ?>
			<div class="announcementsField">
      	<?php
					$query='SELECT ogloszenia.id, title, text, pinned, date, user_name, color, expirydate, colorclass FROM ogloszenia LEFT JOIN users ON ogloszenia.autor=users.id ORDER BY pinned DESC, id DESC';
      		$result=easyQuery($query);
      		if ($result->num_rows > 0){
    				while($row = $result->fetch_assoc()){
            	$expires=$row['expirydate'];
            	if(is_null($expires)){
              	$expires='Nieokreślono';
            	}
							else{
              	$expires=date('d.m.Y', strtotime($expires));
            	}

            	echo '
            		<div class="announcement '.$row['colorclass'].'">
            		<p class="announcmentTitle">';
            		if($row['pinned']){
                	echo '<img src="images/pin.svg" class="pinImage">';
            		}
            		echo $row['title'].'</p>
            		<p class="announcmentTitle" style="font-size: 16px;">Trwa do: '.$expires.'</p>
            		<div class="announcementContent">'.$row['text'].'</div>
            		<div class="announcementInfo"> <div>Opublikowano: '.date('d.m.Y', strtotime($row['date'])).'</div>';
            		if($_SESSION['redaktor']||$_SESSION['userisadmin']){
									echo '<form action="" method="post">';
                	echo '<input type="hidden" value="'.$row['id'].'" name="postToRemove">';
                	echo '<input type="submit" value="Usuń ogłoszenie" class="removeAnnouncementButton">';
                	echo '</form>';
            		}
            		echo '</div>
            	</div>';
        		}
      		}
      	?>
			</div>
		</div>
	</div>
</body>
</html>
