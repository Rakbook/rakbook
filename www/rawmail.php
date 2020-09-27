<?php
header("Content-Type: text/plain");
session_start();
if(!isset($_SESSION['loggedin'])&&$_SESSION['loggedin']!=true)
{
	
	header("Location: index.php");
	die();
	
}
if(!isset($_GET['mailuid']))
{
	die("Nie podano potrzebnych informacji do wyświetlenia żródła");
}

require_once("mailmanagement.php");
		

$mailuid='';

if(is_numeric($_GET['mailuid'])) {
    
	$inbox = imap_open($mailserver, $maillogin, $mailpass);
	
	if(!$inbox)
	{
		die("Nie udało się połączyć z serwerem pocztowym");
		die("Coś się zepsuło");
	}
	
	$mid=imap_msgno($inbox, (int)$_GET['mailuid']);
	echo getrawmail($inbox, $mid);
	

} else {
    die('MID musi być liczbą');
}







?>
