<?php

session_start();
if(isset($_SESSION['loggedin']))
{
	if($_SESSION['loggedin']==true)
	{
		header("Location: main.php");
		die();
	}
}else
{
	
	require_once("dbcredentials.php");
	require_once('dbutils.php');
	
	if(isset($_COOKIE['remembercookie']))
	{
		$explodedcookie=explode(':', $_COOKIE['remembercookie']);
		$selector=$explodedcookie[0];
		$validator=$explodedcookie[1];
		
		$result=easyQuery('SELECT * FROM authtokens WHERE selector=?', "s", $selector);
		
		if($result->num_rows>0)
		{
			$row=$result->fetch_assoc();
			if(hash_equals($row['validatorhash'], hash('sha256', $validator)))
			{
				$_SESSION['loggedin']=true;
				$_SESSION['userid']=$row['userid'];
				$_SESSION['authtokenselector']=$row['selector'];
				easyQuery('UPDATE authtokens SET expires=DATE_ADD(NOW(), INTERVAL 7 DAY) WHERE selector=?', "i", $_SESSION['authtokenselector']);
                setcookie("remembercookie", $_COOKIE['remembercookie'], time()+3600*24*7);
				header('Location: main.php');
				die();
			}else
			{
				easyQuery('DELETE FROM authtokens WHERE id=?', "i", $row['id']);
			}
		}
		
		setcookie('remembercookie', '', time()-3600*24*7);
		header('Location: index.php');
		
	}
	
	
	if(!isset($_POST['username'])||!isset($_POST['pass']))
	{
		header("Location: index.php");
		die();
	}
	
	
	$_SESSION['loginattemptname']=$_POST['username'];
	$_SESSION['loginattemptpass']=$_POST['pass'];
	
	$loginsuccess=true;
	$usernotfound=false;
	$passincorrect=false;
	$usernotactivated=false;
	
	
	
	$result=easyQuery("SELECT id, user_name, user_pass, activated FROM users WHERE user_name=?", "s", $_POST['username']);
	
	
	
	
	if($result->num_rows>0)
	{
		
		$row=$result->fetch_assoc();
		
		if(password_verify($_POST['pass'], $row['user_pass']))
		{
			$loginsuccess=true;
			$_SESSION['loggedin']=true;
			$_SESSION['userid']=$row['id'];
			$passincorrect=false;
		}else
		{
			$loginsuccess=false;
			$passincorrect=true;
		}
		
		if($row['activated']==1)
		{
			$usernotactivated=false;
		}else if($row['activated']==0)
		{
			$usernotactivated=true;
			$loginsuccess=false;
		}
		
		
		
	}else
	{
		$usernotfound=true;
		$loginsuccess=false;
	}
	
	if($loginsuccess)
	{
		$_SESSION['loggedin']=true;
		
		
		if(isset($_POST['remember']))
		{
			$selector=bin2hex(random_bytes(9));
			$validator=bin2hex(random_bytes(32));
			$validatorhash=hash('sha256', $validator);
			$cookieval=$selector.':'.$validator;
			
			setcookie("remembercookie", $cookieval, time()+3600*24*7);
			
			easyQuery("INSERT INTO authtokens (userid, selector, validatorhash, expires) VALUES (?, ?, ?, DATE_ADD(NOW(), INTERVAL 7 DAY))", "iss", $_SESSION['userid'], $selector, $validatorhash);
			$_SESSION['authtokenselector']=$selector;
		}
		
		
		header("Location: main.php");
		die();
	}else
	{
		if($passincorrect||$usernotfound)
		{
			$_SESSION['loginerr']="Nie znaleziono w bazie takiej kombinacji danych uwierzytelniających";
		}else if($usernotactivated)
		{
			$_SESSION['registrationsuccess']=true;
			header('Location: registrationsuccess.php');
			die();
		}else
		{
			$_SESSION['loginerr']="Podczas próby logowania wystąpił niezidentyfikowany problem";
		}
		
		
		header("Location: index.php");
		die();
	}
	
	
}


?>
