<?php

session_start();
if(!isset($_SESSION['loggedin'])&&$_SESSION['loggedin'] != true){
	header("Location: index.php");
	die();
}

require_once('dbutils.php');

if(isset($_POST['likedquoteid'])&&isset($_POST['likevalue'])){
	require_once('generatelikebuttons.php');

  $likedquote = intval($_POST['likedquoteid']);
  $recevedlikeval = intval($_POST['likevalue']);
  $likeval = 0;
  if($recevedlikeval > 0){
    $likeval = 1;
  }
	else if($recevedlikeval == 0){
    $likeval = 0;
  }
	else if($recevedlikeval < 0){
    $likeval=-1;
  }

  if($likedquote > 0){
    $query = 'SELECT uploaderid FROM cytaty WHERE id=?';
    if($autor = easyQuery($query, "i", $likedquote)->fetch_assoc()['uploaderid']){
      if($autor!=$_SESSION['userid']){
        $result = easyQuery('SELECT value FROM quotelikes WHERE personid=? AND quoteid=?', "ii", $_SESSION['userid'], $likedquote);
        if($result->num_rows>0){
          $lastgrade = $result->fetch_assoc()['value'];
          easyQuery("UPDATE quotelikes SET value=? WHERE quoteid=? AND personid=?","iii", $likeval, $likedquote, $_SESSION['userid']);
        }
				else{
          $lastgrade = 0;
          easyQuery("INSERT INTO quotelikes (personid, quoteid, value) VALUES (?, ?, ?)", "iii", $_SESSION['userid'], $likedquote, $likeval);
        }
        $difference = $likeval - $lastgrade;
        easyQuery("UPDATE users SET RakCoins= RakCoins+? WHERE id=?", "ii", $difference, $autor);
        $reward = 0;
          if($likeval != $lastgrade && $lastgrade == 0){
          $reward = 1;
        }
				else if($likeval != $lastgrade && $likeval == 0){
          $reward = -1;
        }
        if($reward != 0){
        	easyQuery("UPDATE users SET RakCoins= RakCoins+? WHERE id=?", "ii", $reward, $_SESSION['userid']);
        }

				$likes  = easyQuery("SELECT IFNULL(SUM(quotelikes.value), 0) AS likes FROM quotelikes RIGHT JOIN cytaty ON quotelikes.quoteid=cytaty.id WHERE cytaty.id=? GROUP BY cytaty.id", "i", $likedquote)->fetch_assoc()['likes'];
				echo '<script> $(\'.leftPanel[data-quoteid="'.$likedquote.'"]\').children(".scoreBackground").html('.$likes.') </script>';
				echo getlikebuttons($likedquote, $likeval);
      }
    }
	}
}

?>
