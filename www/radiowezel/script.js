function refresh()
{
    $('#refreshbutton').hide();
    let resultlist=$( "#result" );
    resultlist.empty();
    let pages=parseInt($('#pages').val());
    if(pages<1)
    {
        alert("liczba stron musi byc dodatnia");
        return;
    }
    let filtermask=0;
    if($('#waiting').prop('checked'))
    {
        filtermask|=1<<0;
    }
    if($('#rejected').prop('checked'))
    {
        filtermask|=1<<1;
    }
    if($('#accepted').prop('checked'))
    {
        filtermask|=1<<2;
    }
    $.get( "getsuggestions.php?pages="+pages+"&filter="+filtermask, function( data ) {
        if(!Array.isArray(data))
        {
            alert("błąd");
            return;
        }
        for (let i = 0; i < data.length; ++i) {
            let styling='waiting';
            if(data[i].status==-1) styling='rejected';
            else if(data[i].status==1) styling='accepted';
            resultlist.append('<li class="'+styling+'"><a href="'+data[i].url+'">'+data[i].name+'</a><br></li>');
        }
        $('#refreshbutton').show();
      });
}