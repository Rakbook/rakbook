<?php
session_start();
if(!isset($_SESSION['loggedin'])&&$_SESSION['loggedin']!=true)
{
	header("Location: index.php");
	die();
}

include("requestuserdata.php");
if($_SESSION['userisadmin']==0)
{
	header("Location: main.php");
	die();
}

	require_once('userinfo.php');
	require_once('dbutils.php');

?>

<!DOCTYPE html>
<html>
<head>
  <?php require('standardHead.php'); ?>
	<link rel="stylesheet" type="text/css" href="colorsshopstyles.css">
	<script src="GUIscaling.js"></script>
</head>
<body>
  <div class="container">
    <?php require('topbar.php') ?>

    <div class="content">
      <p class="headline">Panel Administracyjny</p>

			<?php
  			if(isset($_POST["idToChangePass"])){
					$tochangepass = $_POST["idToChangePass"];
					$randpass=rand();
					$passhash=password_hash($randpass, PASSWORD_DEFAULT);
					$query = "UPDATE users SET user_pass=? WHERE id=?";
        	easyQuery($query, "si", $passhash, $tochangepass);
        	echo "Ustawiono nowe hasło na: ".$randpass;
				}

  			if(isset($_POST["idToActivate"])){
  				$toActivate = $_POST["idToActivate"];
    			$query = "UPDATE users SET activated=1 WHERE id=?";
    			easyQuery($query, "i", $toActivate);
    			echo "Pomyślnie aktywowano użytkownika!";
  			}

  			if(isset($_POST["idToReject"])){
			    $toReject = $_POST["idToReject"];
    			$query = "DELETE FROM users WHERE id=?";
    			easyQuery($query, "i", $toReject);
    			echo "Pomyślnie odrzucono prośbę użytkownika! (Jeeeeej!)";
  			}

  			if(isset($_POST['changeAdmin'])){
    			$kto = $_POST['changeAdmin'];
    			if($_POST['isadminn'] == 0){
		      	$xx=1;
      			$c=2;
    			}
					else{
      			$xx=0;
      			$c=1;
    			}
    			$query = "UPDATE users SET isadmin=?, color=? WHERE id=?";
    			easyQuery($query, "iii", $xx, $c, $kto);
  			}

  			if(isset($_POST['changeRedaktor'])){
    			$kto = $_POST['changeRedaktor'];
    			if($_POST['isRedaktorr'] == 0){
      			$xx=1;
      			$c=3;
    			}
					else{
      			$xx=0;
      			$c=1;
    			}
    			$query = "UPDATE users SET redaktor=?, color=? WHERE id=?";
    			easyQuery($query, "iii", $xx, $c, $kto);
  			}
    	?>

      <p stlye="font-size: 20px;">Użytkownicy oczekujący na zatwierdzenie:</p>

      <?php
      	$query="SELECT id, user_name, user_nrwdzienniku, activated FROM users WHERE activated=0";
        $result=easyQuery($query);

      	if ($result->num_rows > 0) {
    			echo "<table class=\"tabela\"><tr><th class=\"name\">nick</th><th>nr</th><th colspan=\"2\">co zrobić?</th></tr>";
    			while($row = $result->fetch_assoc()) {
        		echo "<tr><td class=\"name\">". $row["user_name"]. "</td><td>" . $row["user_nrwdzienniku"]. "</td><td> <form action=\"\" method=\"post\"><input type=\"hidden\" name=\"idToActivate\" value=\"".$row['id']."\"/><input type=\"submit\" value=\"Aktywuj\" CLASS=\"greenButton\"/></form></td><td><form action=\"\" method=\"post\"><input type=\"hidden\" name=\"idToReject\" value=\"" .$row['id']."\"/><input type=\"submit\" value=\"Odrzuć\" class=\"redButton\"/></form></td></tr>";
    			}
    			echo "</table>";
				}
				else {
   			echo "<br> Nie ma nieaktywowanych użytkowników :)";
				}
      ?>
      <p>Lista aktywnych użytkowników:</p>

    	<?php
        $query="SELECT users.id AS id, user_name, user_nrwdzienniku, isadmin, redaktor, colors.colorclass AS colorclass FROM users LEFT JOIN colors ON color=colors.id WHERE activated=1 ORDER BY users.id ASC";
        $result=easyQuery($query);
        if ($result->num_rows > 0){
    			echo '<table class="tabela" cellspacing="0" cellpadding="0" style="margin-bottom: 0">';
					echo '<tr><th class="name" style="width:100px; max-width: 100px;">&nbsp;nick</th><th>nr</th><th>admin</th><th>redaktor</th><th>Losuj nowe hasło</th></tr>
					<tr style="height: 10px;"></th>';
    			while($row = $result->fetch_assoc()){
        		echo "<tr>
						<td class='name' style='overflow:hidden;'>". formatnamewithcolorclass($row["user_name"], $row['colorclass']) . "</td>
						<td style='width: 35px;'>" . $row["user_nrwdzienniku"]. "</td>
						<td>";

						$ButtonStyle="redButton";
						$ButtonValue="Nie";

						if($row['isadmin'] == 1){
							$ButtonStyle="greenButton";
							$ButtonValue="Tak";
						}

						echo "<form method=\"post\" action=\"panel.php\"><input type=\"hidden\" name=\"changeAdmin\" value=\"".$row['id']."\"><input type=\"hidden\" name=\"isadminn\" value=\"".$row['isadmin']."\"><input type=\"submit\" name=\"adminOpposite\" class='".$ButtonStyle."' value='".$ButtonValue."'></form>
						</td>
						<td>";

						$ButtonStyle="redButton";
						$ButtonValue="Nie";
						if($row['redaktor'] == 1){
							$ButtonStyle="greenButton";
							$ButtonValue="Tak";
						}
						echo "<form method=\"post\" action=\"panel.php\"><input type=\"hidden\" name=\"changeRedaktor\" value=\"".$row['id']."\"><input type=\"hidden\" name=\"isRedaktorr\" value=\"".$row['redaktor']."\"><input type=\"submit\" name=\"redaktorOpposite\" class='".$ButtonStyle."' value='".$ButtonValue."'></form></td>
						</td>
						<td><form method=\"post\" action=\"panel.php\"><input type=\"hidden\" name=\"idToChangePass\" value=\"".$row['id']."\"><input type=\"submit\" name=\"randnewpass\" class=\"grayButton\" value=\"Wylosować nowe hasło?\"></form></td>
						</tr>";
    			}
    			echo '<tr><td class="podkresl"></td><td class="podkresl"></td><td class="podkresl"></td><td class="podkresl"></td><td class="podkresl"></td></tr></table><p style="margin-bottom: 200px; margin-top: 0">Liczba aktywnych użytkowników wynosi '.$result->num_rows;'</p>';
				}
				else{
   				echo "<br> Nie ma aktywnych użytkowników :(";
				}
      ?>

			<script> rescaleAdminGUI(); </script>
    </div>
  </div>
</body>
</html>
