// ------------- Topbar ---------------

function OpenSettingsPopup() {
  var popup = document.getElementById("settingspopup");
  popup.classList.toggle("show");
  var menu = document.getElementById("menupopup");
  if (menu.classList.contains("show")) {
    menu.classList.toggle("show");
  }
}

function OpenMenuPopup() {
  var menu = document.getElementById("menupopup");
  menu.classList.toggle("show");
  var popup = document.getElementById("settingspopup");
  if (popup.classList.contains("show")) {
    popup.classList.toggle("show");
  }
}

// for small screens
function changeTitle(){
  var deviceWidth = screen.width;
  if(deviceWidth < 320){
    document.getElementById('title').innerHTML = "Rak…";
  }
  else{
    document.getElementById('title').innerHTML = "Rakbook";
  }
}

window.onresize = changeTitle;
