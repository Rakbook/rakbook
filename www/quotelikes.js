function addreaction(quoteid, reactionval, likelock = false){
	if (likelock) return;
	var buttonscontainer = $('.leftPanel[data-quoteid="'+quoteid+'"]').children(".votesBackground");
	$.post("likequote.php", {likedquoteid: quoteid, likevalue: reactionval}).done(function(data)
	{
		buttonscontainer.html(data);
		setupbuttons(true);
	});
}

function setupbuttons(likelock = false){
	setMobileLayout();
	$(".vote").click(function() {
		var element = $(this);
		var quoteid = element.data("entryid");
		var reactionval = element.data("reactionval");
	addreaction(quoteid, reactionval);
	});
}

function callMe(){ //♫ so...  ...maybe? ♫
	$('#quoteBox').ready(function(){
		setupbuttons();
	});
}
