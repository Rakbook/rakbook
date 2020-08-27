<?php

session_start();

require_once('dbutils.php');
require_once('userinfo.php');

if(isset($_POST['memdoupondczasowienia']))
{
    $id=intval($_POST['memdoupondczasowienia']);
    if($id>0)
    {
        $author=easyQuery('SELECT authorid FROM memy WHERE id=?', "i", $id)->fetch_assoc()['authorid'];
        if($author!=$_SESSION['userid'])
        {
            easyQuery('UPDATE memy SET ponadczasowy=1 WHERE id=?', "i", $id);
            giverakcoins($author, 100);
        }
        
        header('Location: memy.php');
        die();
    }
}
header('Location: index.php');


?>
