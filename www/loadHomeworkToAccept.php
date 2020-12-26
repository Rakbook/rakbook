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
		echo '<div class="homework"><label class="fakeCheckbox">
				<input class="acceptCheckbox" type="checkbox" name="'.$row['id'].'" value="'.$row['id'].'"/>
			  </label><span>'.$row['category']." - ".$row['content'].'</span></div>';
		}
		echo "<div id=\"subbar\" class=\"horizontal\">
		  <input class=\"subicon green accept\" name=\"homeworksub\" type=\"submit\" value=\"\" disabled></input>
		  <input class=\"subicon red reject\" name=\"reject\" type=\"submit\" value=\"\" disabled></input>
		</form></div></div>";
    }
    else{
  		echo "Brak zadań do zaakceptowania";
	  }
  }
  echo "<script> var selected = 0; toggleDirection(); </script>";
?>

<div class="dayPopupBackground"><div id="homeworkTitle">Zadania do zaakceptownaia</div><div id="homeworkContent"><?php loadList(); ?></div><div id="navdiv"><div id="close">x</div></div></div>


