<?php

session_start();

setcookie('remembercookie', '', time()-3600*24*7);

if(isset($_SESSION['authtokenselector']))
{
	require_once('dbutils.php');

	easyQuery('DELETE FROM authtokens WHERE selector=?', "i", $_SESSION['authtokenselector']);
}



session_unset();
session_destroy();

header("Location: index.php");

?>
