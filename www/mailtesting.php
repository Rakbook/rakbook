<html>
<head>
 	<meta charset="UTF-8"/>
</head>
<body>

<?php
	require_once("mailmanagement.php");
	
	
	
	
	
	$inbox = imap_open($mailserver, $maillogin, $mailpass);
	if(!$inbox)
	{
		die("Nie udało się połączyć z serwerem pocztowym");
		die("Coś się zepsuło");
	}
	
	$emails=imap_sort($inbox, SORTDATE, 1);
	
	foreach ($emails as $mail)
	{
		$m=new Mail($inbox, $mail);
		print_r($m);
	}
?>
	
</body>
