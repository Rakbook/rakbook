<?php
session_start();
if(!isset($_SESSION['loggedin'])&&$_SESSION['loggedin']!=true)
{
	header("Location: index.php");
	die();	
}

require_once('dbutils.php');

if(isset($_POST['memeid'])&&isset($_POST['likevalue']))
{
	require_once('generatelikebuttons.php');

    $likedmeme=intval($_POST['memeid']);
	$recevedlikeval=intval($_POST['likevalue']);
    $likeval=0;
    if($recevedlikeval>0)
    {
        $likeval=1;
    }elseif($recevedlikeval==0)
    {
        $likeval=0;
    }elseif($recevedlikeval<0)
    {
        $likeval=-1;
    }


    if($likedmeme>0)
    {
        $query='SELECT authorid FROM memy WHERE id=?';
        if($autor=easyQuery($query, "i", $likedmeme)->fetch_assoc()['authorid'])
        {
            if($autor!=$_SESSION['userid'])
            {
                $result=easyQuery('SELECT value FROM memelikes WHERE person=? AND memeid=?', "ii", $_SESSION['userid'], $likedmeme);
                if($result->num_rows>0)
                {
                    $lastgrade=$result->fetch_assoc()['value'];
                    easyQuery("UPDATE memelikes SET value=? WHERE memeid=? AND person=?","iii", $likeval, $likedmeme, $_SESSION['userid']);
                }else
                {
                    $lastgrade=0;
                    easyQuery("INSERT INTO memelikes (person, memeid, value) VALUES (?, ?, ?)","iii", $_SESSION['userid'], $likedmeme, $likeval);
                }
                $difference=$likeval-$lastgrade;
                easyQuery("UPDATE users SET RakCoins= RakCoins+? WHERE id=?", "ii", $difference, $autor);
                $reward=0;
                if($likeval!=$lastgrade&&$lastgrade==0)
                {
                    $reward=1;
                }elseif($likeval!=$lastgrade&&$likeval==0)
                {
                    $reward=-1;
                }

                if($reward!=0)
                {
                    easyQuery("UPDATE users SET RakCoins= RakCoins+? WHERE id=?", "ii", $reward, $_SESSION['userid']);
                }
				
				$likes=easyQuery("SELECT IFNULL(SUM(memelikes.value), 0) AS likes FROM memelikes RIGHT JOIN memy ON memelikes.memeid=memy.id WHERE memy.id=? GROUP BY memy.id", "i", $likedmeme)->fetch_assoc()['likes'];
				echo 'Całkowita ocena: '.$likes.'<br>';
				if($autor!=$_SESSION['userid'])
				{
					echo getlikebuttons($likedmeme, $likeval);
				}
				
            }

        }
    }




}

?>
