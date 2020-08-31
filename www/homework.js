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
