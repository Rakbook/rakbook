<?php

require_once("dbcredentials.php");
require_once('dbutils.php');
	
	
	

	$query="SELECT * FROM users WHERE id=?";
	
	$result=easyQuery($query, "i", $_SESSION['userid']);
	
	if($result->num_rows>0)
	{
		
		$row=$result->fetch_assoc();
		
		$_SESSION['username']=$row['user_name'];
		$_SESSION['userid']=$row['id'];
		$_SESSION['usernrwdzienniku']=$row['user_nrwdzienniku'];
		$_SESSION['userisadmin']=$row['isadmin'];
		$_SESSION['redaktor']=$row['redaktor'];
		
	}else
	{
		echo("Nie znaleziono użytkownika");
	}
	
?>
