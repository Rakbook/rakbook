<?php

require_once('dbutils.php');
if(!isset($_SESSION['loggedin']))
{
	session_start();
}
if(!isset($_SESSION['loggedin'])&&$_SESSION['loggedin']!=true)
{
	header("Location: index.php");
	die();
}

if(isset($_POST['hwid'])){
	$hwid = $_POST['hwid'];
}
else{
	$hwid = '-1';
}

function printdesc($id){
    $result = easyQuery('SELECT link FROM zadania WHERE id=?','s', $id);

    while($row=$result->fetch_assoc()){
        echo '<span class="desc"> '.nl2br(htmlentities($row['link'])).' </span>';
	}
}

function printname($id){
	$count = 0;
    $result = easyQuery('SELECT content FROM zadania WHERE id=?','s', $id);

    while($row=$result->fetch_assoc()){
		$count++;
        echo nl2br(htmlentities($row['content']));
	}
	if($count == 0){
		echo "Nie znaleziono takiego zadania";
	}
}

?>

<div class="dayPopupBackground"><div id="homeworkTitle"> <?php printname($hwid); ?> </div><div id="homeworkContent"><?php printdesc($hwid); ?></div><div id="navdiv"><div id="back">«</div><div id="close">x</div></div></div>
</div>
