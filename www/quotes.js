
// ---------------------- Mobile GUI ----------------------

function setMobileLayout(){
  var screenWidth = $(window).width();
  if(screenWidth <= 450){
    // -------------------- navbar --------------------
    document.documentElement.style.setProperty('--width', "186px");
    document.documentElement.style.setProperty('--left-width', "185px");
    document.documentElement.style.setProperty('--flex', "column");
    document.documentElement.style.setProperty('--height', "80px");
  }
  else{
    document.documentElement.style.setProperty('--width', "400px");
    document.documentElement.style.setProperty('--left-width', "195px");
    document.documentElement.style.setProperty('--flex', "row");
    document.documentElement.style.setProperty('--height', "35px");
  }

  // -------------------- quotes --------------------
  var contentwidth = screenWidth - 80;
  if(screenWidth <= 550){
    $(".quoteContent").css({'width': contentwidth - 76});
    $(".mainPanel").css({'width' : contentwidth, 'font-size' : '16px'});
    $(".scoreBackground").css({'width' : '25px', 'height' : '25px'});
    $(".votesBackground").css({'width' : '25px', 'height' : '80px'});
    document.documentElement.style.setProperty('--voteHeight', "25px");
    $(".vote").removeAttr("style");
    $(".bin").css('height', '30px');
  }
  else{
    $(".quoteContent").removeAttr("style");
    $(".mainPanel").removeAttr("style");
    $(".scoreBackground").removeAttr("style");
    $(".votesBackground").removeAttr("style");
    document.documentElement.style.setProperty('--voteHeight', "45px");
    $(".vote").removeAttr("style");
    $(".bin").removeAttr("style");
  }
}

// ---------------------- quotes sorting ----------------------

$(document).ready(function(){
  $("#sortStyleSelect").change(function(){ updateList() });
  $("#search").keyup(function(){ updateList() });

  function updateList(){
    var selectedValue = $("#sortStyleSelect").children("option:selected").val();
    var keyword = $("#search").val();
    $("#quoteBox").load("loadquotes.php", {value: selectedValue, keyword: keyword});
  }
  setMobileLayout();
});

$(window).resize(function(){
  setMobileLayout();
});
