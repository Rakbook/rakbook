<?php


function assigncolor($userid, $colorid)
{
	$query = "UPDATE users SET color=? WHERE id=?";
	easyQuery($query, "ii", $colorid, $userid);
}


function givecolor($userid, $colorid)
{
	if(easyQuery('SELECT colorpurchase.id FROM colorpurchase WHERE buyerid=? AND colorid=?',"ii", $userid, $colorid)->num_rows===0)
	{
		easyQuery('INSERT INTO colorpurchase (buyerid, colorid) VALUES (?, ?)', "ii", $userid, $colorid);
	}
}


?>
