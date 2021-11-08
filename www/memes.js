// ------------- Losowe Kolorki ---------------
function randomColorClass(elementID){
  var colors = ["blue", "red", "yellow", "green", "jadeite", "orange", "purple"];
  elementID.classList.add(colors[Math.floor(Math.random() * colors.length)]);
}

//---------------- Fake Input -----------------

function zmienNazwe(){
  var nazwa = document.getElementById('file-upload').value;
  if(nazwa == ""){
      nazwa = "Kliknij albo przenieś plik";
  }
  document.getElementById('upload-label').innerHTML = nazwa;
}

function uploadFile(e){
  e.stopPropagation();
  e.preventDefault();
  document.getElementById('file-upload').files = e.dataTransfer.files;
  zmienNazwe();
}

function highlight(e){
  e.stopPropagation();
  e.preventDefault();
  document.getElementById('upload-label').classList.add("highlight");
}

function unhighlight(e){
  e.stopPropagation();
  e.preventDefault();
  document.getElementById('upload-label').classList.remove("highlight");
}

function allowDrop(e){
  e.stopPropagation();
  e.preventDefault();
}

function trigger(){
  var fakeInput = document.getElementById('upload-label');
  fakeInput.addEventListener('drop', uploadFile, false);
  fakeInput.addEventListener("dragenter", highlight, false);
  fakeInput.addEventListener("dragleave", unhighlight, false);
  fakeInput.addEventListener("dragover", allowDrop, false);
}

//--------------- GUI scaling -----------------

function scale(){
  var deviceWidth = screen.width;

  if(deviceWidth <= 460){
    document.documentElement.style.setProperty('--width', "340px");
    document.documentElement.style.setProperty('--font-size', "16px");
  }
  else{
    document.documentElement.style.setProperty('--width', "400px");
    document.documentElement.style.setProperty('--font-size', "18px");
  }
}

function showVotes(){
  $(".vote").removeAttr("style");
}

$(document).ready(function(){
	showVotes();
});
