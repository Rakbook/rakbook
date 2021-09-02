<?php
session_start();
if (!isset($_SESSION['loggedin']) && $_SESSION['loggedin'] != true) {
	header("Location: index.php");
	die();
}

require_once("dbutils.php");
include("requestuserdata.php");

if (!empty($_POST['teacher'])) {
	$teacher = $_POST['teacher'];
	$number = 1;
	if (!empty($_POST['number'])) {
		$n = intval($_POST['number']);
		if ($n>0) {
			$number = $n;
		}
	}
	$query = "INSERT INTO maturas (teacher, number) VALUES (?, ?)";
	easyQuery($query, "si", $teacher, $number);

	$_SESSION['maturaModification'] = "add";
	header("Location: maturacounter.php");
	die();
}
if (!empty($_POST['removeId'])) {
	if(!(($_SESSION['redaktor']==1)||($_SESSION['userisadmin']==1)))
	{
		header("Location: main.php");
		die();
	}
	$id = $_POST['removeId'];
	$query = "DELETE FROM maturas WHERE id=?";
	easyQuery($query, "i", $id);

	$_SESSION['maturaModification'] = "remove";
	header("Location: maturacounter.php");
	die();
}
if (!empty($_POST['acceptId'])) {
	if(!(($_SESSION['redaktor']==1)||($_SESSION['userisadmin']==1)))
	{
		header("Location: main.php");
		die();
	}
	$id = $_POST['acceptId'];
	$query = "UPDATE maturas SET accepted=1 WHERE id=?";
	easyQuery($query, "i", $id);

	$_SESSION['maturaModification'] = "accept";
	header("Location: maturacounter.php");
	die();
}
?>

<!DOCTYPE html>
<html>
<head>
	<?php require('standardHead.php'); ?>
</head>
<body>
	<div class="container">
		<?php require('topbar.php') ?>
		<div class="content">
			Po lekcji można wpisać ile razy nauczyciel użył słowa "matura" lub podobnego
			<div>
				<?php
				if (isset($_SESSION['maturaModification'])) {
					if ($_SESSION['maturaModification'] == "add") {
						echo "Pomyślnie dodano maturę! Matura oczekuje na zatwierdzenie przez redaktora<br>";
					}
					if ($_SESSION['maturaModification'] == "remove") {
						echo "Pomyślnie usunięto maturę!<br>";
					}
					unset($_SESSION['maturaModification']);
				}
				?>
			</div>
			<form method="post" action="">
				<input type="text" name="teacher" placeholder="nauczyciel"></input>
				<input type="number" name="number" value="1" min="1"></input>
				<input type="submit" name="submit" value="Dodaj maturę"></input>
			</form>
			<?php
			if (($_SESSION['redaktor']==1)||($_SESSION['userisadmin']==1)) {
				echo('<script>
					function remove(id) {
						document.getElementById("remove").value = id;
						document.forms["remove-form"].submit();
					}
					function accept(id) {
						document.getElementById("accept").value = id;
        				document.forms["accept-form"].submit();
					}
				</script>');
				echo('<form method="post" action="" name="accept-form">
				<input type="hidden" name="acceptId" value="0" id="accept"/>
				</form>');
				echo('<form method="post" action="" name="remove-form">
				<input type="hidden" name="removeId" value="0" id="remove"/>
				</form>');
			}
			?>
			<div><?php
			if (($_SESSION['redaktor']==1)||($_SESSION['userisadmin']==1))
			{
				$result = easyQuery("SELECT * FROM maturas ORDER BY id DESC");
			} else {
				$result = easyQuery("SELECT * FROM maturas WHERE accepted=1 ORDER BY id DESC");
			}
			echo('Liczba matur: '
			.easyQuery('SELECT SUM(number) AS maturas FROM maturas WHERE accepted=1')->fetch_assoc()['maturas']);
			while ($row = $result->fetch_assoc()) {
				echo('<div>');
				$datetime = new DateTime($row['date']);
				$tz = new DateTimeZone('Europe/Warsaw');
				$datetime->setTimezone($tz);
				echo($row['number'].' razy ');
				echo(htmlentities($row['teacher']).' dodano '.$datetime->format('d.m.Y G:i:s'));
				if (($_SESSION['redaktor']==1)||($_SESSION['userisadmin']==1)) {
					echo('<button type="button" onclick="remove('.$row['id'].')">Usuń</button>');
					if($row['accepted']==0) echo('<button type="button" onclick="accept('.$row['id'].')">Zatwierdź</button>');
				}
				echo('</dev>');
			}
			?> </div>
		</div>
	</div>
</body>
</html>