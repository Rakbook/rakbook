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
if(isset($_POST['date'])){
	$date = $_POST['date'];
}
else{
	$date = strtotime("last monday", strtotime("tomorrow"));
}

if(isset($_POST['day'])){
	$day = $_POST['day'];
}
else{
	$day = 0;
}

if(isset($_POST['hwname'])){
	$hwname = $_POST['hwname'];
}
else{
	$hwname = 'Nie znaleziono';
}


function printdesc(string $name){
    $result = easyQuery('SELECT link FROM zadania WHERE content=? AND accepted=1', 's', $name);

    while($row=$result->fetch_assoc()){
        echo '<span class="desc">'.$row['link'].'</span>';
    }
}

?>

<div class="dayPopupBackground"><div id="homeworkTitle"> <?php echo $hwname; ?> </div><div id="homeworkContent"><?php echo printdesc($hwname);?></div><div id="navdiv"><div id="back">«</div><div id="close">x</div></div></div>
</div>
