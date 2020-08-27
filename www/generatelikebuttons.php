<?php

function makebutton(int $id, int $val, string $src){
    return '<img src="'.$src.'"style="height: 0px;" class="vote"  data-reactionval="'.$val.'" data-entryid="'.$id.'">';
}

function getlikebuttons(int $id, int $currentlike){
  $likebuttonsrc = 'images/grayArrowUp.svg';
  $dislikebuttonsrc = 'images/grayArrowDown.svg';

	$button1val = 1;
	$button2val = -1;

	if($currentlike > 0){
		$button1val = 0;
    $likebuttonsrc = 'images/greenArrow.svg';
	}

	if($currentlike < 0){
		$button2val = 0;
    $dislikebuttonsrc = 'images/redArrow.svg';
	}

	$button1 = makebutton($id, $button1val, $likebuttonsrc);
	$button2 = makebutton($id, $button2val, $dislikebuttonsrc);

	return $button1.$button2;
}

?>
