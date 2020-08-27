<?php
//error_reporting(E_ALL ^ E_WARNING ^ E_NOTICE);
session_start();
if(!isset($_SESSION['loggedin'])&&$_SESSION['loggedin']!=true)
{
	header("Location: index.php");
	die();
}

include("requestuserdata.php");

?>

<!DOCTYPE html>
<html>
<head>
  <?php require('standardHead.php'); ?>
	<link rel="stylesheet" type="text/css" href="mail.css">
</head>
<body>
  <div class="container">
    <?php require('topbar.php') ?>
    <div class="content">
      <p class="headline">Tu będą materiały od nauczycieli</p>

        <?php

		require_once("mailmanagement.php");


		$inbox = imap_open($mailserver, $maillogin, $mailpass);
		if(!$inbox)
		{
		die("Nie udało się połączyć z serwerem pocztowym");
		die("Coś się zepsuło");
		}

	  	if($_SESSION['redaktor']&&isset($_POST['mailtodelete'])&&is_numeric($_POST['mailtodelete']))
		{
			deleteMail($inbox, (int)$_POST['mailtodelete']);
		}


		$emails=imap_sort($inbox, SORTDATE, 1);



		foreach ($emails as $mail)
		{
			$m=new Mail($inbox, $mail);

			echo "<ul>";
			echo "<li>Od: " . $m->from. "</li>";
			echo "<li>Temat: " . $m->subject . "</li>";
			echo "<li>Data: " . (isset($m->date) ? date('d.m.Y H:i:s', $m->date) : "niedostępna") . "</li>";

			echo "<li class=\"wiadomosc\">Treść: ".$m->message."</li>";
			echo "<li>Załączniki:<br>";
			if(empty($m->attachments)) echo 'brak';
			else
			{
				foreach($m->attachments as $a)
				{
					echo $a->generateLink().'<br>';
				}
			}
			echo "</li>";
				if($_SESSION['redaktor'])
				{
			echo '<br> <li><form action="" method="POST"> <input type="hidden" name="mailtodelete" value="'.$m->uid.'"/> <input type="submit" value="Usuń"/> </form> </li>';
				}
			echo "</ul><br/><hr>";

		}
?>

    </div>
  </div>
</body>
</html>
