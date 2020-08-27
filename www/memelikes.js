var likelock = false;

function addreaction(memeid, reactionval)
{
	if (likelock) return;
	likelock = true;
	var buttonscontainer = $('.reactionscontainer[data-memeid="'+memeid+'"]');
	$.post("likememe.php", {memeid: memeid, likevalue: reactionval}).done(function(data)
	{
		buttonscontainer.html(data);
		likelock = false;
		setupbuttons();
	});


}

function setupbuttons()
{
	showVotes();
	$(".vote").click(function() {
		var element = $(this);
		var memeid=element.data("entryid");
		var reactionval=element.data("reactionval");
		addreaction(memeid, reactionval);
	});
}

$(document).ready(function(){
	setupbuttons();
});
