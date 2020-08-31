$(document).ready(function() {

  $(".dayPanel").click(function(){
    $(".dayPanel").css("pointer-events", "none");
    var day = $(this).children(".day").html();
    $(".dayPopup").children(".text").html('Kliknąłeś ' + day);
    $(".dayPopup").css("display", "flex");

  });

  $("#close").click(function(){
    $(".dayPopup").css("display", "none");
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
