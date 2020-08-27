<?php
session_start();
if(!isset($_SESSION['loggedin'])&&$_SESSION['loggedin']!=true)
{
	header("Location: index.php");
	die();
}

include("requestuserdata.php");
require_once('dbutils.php');
require_once('userinfo.php');


if(isset($_GET['ponadczasowe']))
{
    if($_GET['ponadczasowe']==1)
    {
        $ponadczasowosc=1;
    }else
    {
        $ponadczasowosc=0;
    }
}else
{
    $ponadczasowosc=0;
}

if($ponadczasowosc==1)
{
    $buttonponadczasowosc=0;
    $buttonmessage='Zobacz zwykłe memy';
    $buttonstyle='normalmemeslink';
}else
{
    $buttonponadczasowosc=1;
    $buttonmessage='Zobacz Ponadczasowe Masterkawałki';
    $buttonstyle='ponadczasowememeslink';
}



?>

<!DOCTYPE html>
<html>
<head>
  <?php require('standardHead.php'); ?>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
		<script src="memelikes.js"></script>
    <link rel="stylesheet" type="text/css" href="memestyles.css">
		<link rel="stylesheet" type="text/css" href="memes.css">
		<script src="memes.js"></script>
</head>
<body>
  <div class="container">
    <?php require('topbar.php') ?>

    <div class="content">
        <p class=" headline">Memy</p>

        <form action="", method="get">
        <input type="hidden" name="ponadczasowe" value="<?php echo $buttonponadczasowosc ?>"><br>
        <button id="<?php echo $buttonstyle ?>" type="submit"><?php echo $buttonmessage ?></button>
        </form>

        <a href="uploadmeme.php">Dodaj nowego mema</a><br>

        <?php


$memeselectquery='SELECT memy.id AS id, adddate, title, file, authorid, user_name, colors.colorclass AS usercolorclass, IFNULL(SUM(memelikes.value), 0) AS likes,  IFNULL((SELECT memelikes.value FROM memelikes WHERE memelikes.person=? AND memelikes.memeid=memy.id), 0) AS currentuserlikevalue FROM `memy` LEFT JOIN memelikes ON memelikes.memeid=memy.id LEFT JOIN users ON memy.authorid=users.id LEFT JOIN colors ON users.color=colors.id WHERE ponadczasowy=?  GROUP BY memy.id ORDER BY
(IFNULL(SUM(memelikes.value), 0)-HOUR(TIMEDIFF(NOW(), adddate))/24) DESC, adddate DESC';


$result=easyQuery($memeselectquery, "ii", $_SESSION['userid'], $ponadczasowosc);

		if ($result->num_rows > 0) {

			require_once('generatelikebuttons.php');

    		while($row = $result->fetch_assoc()) {
			$memeid=$row['id'];
			$memeadddate=$row['adddate'];
			$memetitle=$row['title'];
			$memeimagepath=$row['file'];
			$memeauthorid=$row['authorid'];
			$memeauthor=formatnamewithcolorclass($row['user_name'], $row['usercolorclass']);
			$memetotallikes=$row['likes'];
			$usersgrade=$row['currentuserlikevalue'];

			echo '<div class="meme">
			<h1>'.$memetitle.'</h1><br>
			<img src="'.$memeimagepath.'"/><br>
			<h2>'.$memeauthor.'</h2><br>';
			echo '<div class="reactionscontainer" data-memeid="'.$row['id'].'">';
			echo 'Całkowita ocena: '.$memetotallikes.'<br>';
			if($row['authorid']!=$_SESSION['userid'])
			{
				echo getlikebuttons($row['id'], $row['currentuserlikevalue']);
			}
			echo '</div>';
            if($row['authorid']!=$_SESSION['userid'])
            {
                if(($_SESSION['userisadmin']||$_SESSION['redaktor'])&&$ponadczasowosc==0)
                {
                    echo '<form action="setasponadczasowy.php" method="post">
                    <input type="hidden" name="memdoupondczasowienia" value="'.$memeid.'">
                    <input type="submit" value="Przenieś mema do Ponadczasowych Masterkawałków">
                    </form>';
                }
            }else
            {

            }
			echo '<br>
			Dodany: '.date('d.m.Y G:i:s', strtotime($memeadddate)).'
			</div>';


    	}

	}else
		{
			echo('Nie ma memów o takim statusie ponadczasowości :(');
		}


?>

    </div>
  </div>
</body>
</html>
