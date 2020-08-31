
function findColor(element){
  var classList = $(element).attr('class').split(/\s+/);
  var colors = ["blue", "red", "yellow", "green"];
  for(let i = 0; i < colors.length; i++){
    if($.inArray( colors[i], classList) != -1){
      return colors[i];
    }
  }
}

$(document).ready(function() {

  $(".dayPanel").click(function(){
    $(".dayPanel").css("pointer-events", "none");
    var day = $(this).children(".day").html();

    var color = findColor(this);
    $("#dayPopup").removeClass();
    $("#dayPopup").addClass(color);

    $("#dayPopup").children(".text").html('Kliknąłeś: &nbsp;"' + day + '" ');
    $("#dayPopup").css("display", "flex");

  });

  $("#close").click(function(){
    $("#dayPopup").css("display", "none");
    $(".dayPanel").css("pointer-events", "auto");
  });
});

// ------------- Zadania domowe ---------------

function showHomeworkDropdown(event){
  if(document.getElementById(event.target.id + "Dropdown").style.display == 'none'){
    document.getElementById(event.target.id + "Dropdown").style.display = 'flex';
  }
  else{
    document.getElementById(event.target.id + "Dropdown").style.display = 'none';
  }
}

function showInfo(){
  if(document.getElementById("info").style.display == 'none'){
    document.getElementById("info").style.display = 'flex';
  }
  else{
    document.getElementById("info").style.display = 'none';
  }
}
