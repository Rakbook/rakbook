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

function loadList(){
  	$result = easyQuery('SELECT id, category, content, link, date FROM zadania WHERE accepted=0');
  	if($result->num_rows > 0){
      echo "<form method=\"POST\">";
  	  while($row=$result->fetch_assoc()){
        echo "<div class=\"homework\"><input type=\"checkbox\" name=\"".$row['id']."\" value=\"".$row['id']."\"><span>".$row['category']." - ".$row['content']."</span></div>";
  	  }
      echo "<input name=\"homeworksub\" type=\"submit\" value=\"Potwierdź\"><input name=\"reject\" type=\"submit\" value=\"Odrzuć\"></form></div>";
    }
    else{
  		echo "Ni ma";
  	}
  }
?>

<div class="dayPopupBackground"><div id="homeworkTitle">Zadania do zaakceptownaia</div><div id="homeworkContent"><?php loadList(); ?></div><div id="navdiv"><div id="close">x</div></div></div>
