<?php

require_once('dbutils.php');

function userexists($userid)
{
	if(is_int($userid)&&$userid>0&&easyQuery('SELECT id FROM users WHERE id=?', 'i', $userid)->num_rows>0) return true;
	return false;
}

function getusersrakcoins($userid)
{
	if(!is_int($userid)||$userid<1) return 0;
	if($coins=easyQuery("SELECT RakCoins FROM users WHERE id=?", "i", $userid)->fetch_assoc()['RakCoins'])
	{
		return $coins;
	}
	else
	{
		return 0;
	}
}

function giverakcoins($userid, $amount)
{
	if(!is_int($userid)||!is_int($amount)) return;
	easyQuery('UPDATE users SET RakCoins=RakCoins+? WHERE id=?', "ii", $amount, $userid);
}

function getuserscolornumber($userid)
{
	if($userid&&$number=easyQuery("SELECT color FROM users WHERE id=?", "i", $userid)->fetch_assoc()['color'])
	{
		return $number;
	}
	else
	{
		return 1;
	}
}

function getcolorclass($number)
{
	if(is_int($number)&&$number>0&&$class=easyQuery("SELECT colorclass FROM colors WHERE id=?", "i", $number)->fetch_assoc()['colorclass'])
	{
		return $class;
	}
	return 'NormalNameStyle';
}

function formatnamewithcolorclass($name, $class)
{
	if(!is_string($name))
	{
		$name='<strong>Brak Raka</strong>';
	}else
	{
		$name=htmlentities($name);
	}
	if(!is_string($class))
	{
		$class=getcolorclass(1);
	}
	return '<span class="'.$class.'">'.$name.'</span>';
}

function formatnamewithcolorid($name, $color)
{
	if(!is_int($color)||$color<1) $color=1;
	if(is_string($name))
	{
		$colorname=getcolorclass($color);
	}else
	{
		$name=NULL;
		$colorname=getcolorclass(1);
	}
	return formatnamewithcolorclass($name, $colorname);
}

function getusersformattedname($userid)
{
	if(is_int($userid)&&$row=easyQuery("SELECT user_name, color FROM users WHERE id=?", "i", $userid)->fetch_assoc())
	{
		return formatnamewithcolorid($row['user_name'], $row['color']);
	}
	return formatnamewithcolorid(NULL, 1);
}
?>
