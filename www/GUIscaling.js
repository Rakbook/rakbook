//-------------- Skalowanie GUI ---------------

// na razie tyle potem może zrobię coś uniwersalnego do wszystkiego
// tylko nie wiem czy jest to możliwe bez jakichś dziwnych bibliotek
// albo skalowania wszystkich rzeczy po kolei, a to nie jest najlepszy pomysł

function rescaleAdminGUI(){

  var defaultWidth = 550;
  var deviceWidth = screen.width;

  if(deviceWidth < defaultWidth){
    var scale = deviceWidth/defaultWidth;
    console.log(scale);

    document.body.style.fontSize = Math.floor(16*scale) + "px";

    var cells = document.getElementsByClassName('name');
    for(i = 0; i < cells.length; i++) {
      cells[i].style.width = 100*scale + 'px';
      cells[i].style.maxWidth = 100*scale + 'px';
    }

    cells = document.getElementsByClassName('redButton');
    for(i = 0; i < cells.length; i++) {
      cells[i].style.minWidth = 80*scale + 'px';
      cells[i].style.height = 35*scale + 'px';
      cells[i].style.fontSize = Math.floor(16*scale)-3 + "px";

    }

    cells = document.getElementsByClassName('greenButton');
    for(i = 0; i < cells.length; i++) {
      cells[i].style.minWidth = 80*scale + 'px';
      cells[i].style.height = 35*scale + 'px';
      cells[i].style.fontSize = Math.floor(16*scale)-3 + "px";
    }

    cells = document.getElementsByClassName('grayButton');
    for(i = 0; i < cells.length; i++) {
      cells[i].style.minWidth = 80*scale + 'px';
      cells[i].style.height = 35*scale + 'px';
      cells[i].style.fontSize = Math.floor(16*scale)-3 + "px";
    }
  }
}

function rescaleDyzurniGUI(table){
  var tableWidth = table.offsetWidth;
  var deviceWidth = screen.width;

  if(deviceWidth < tableWidth){
    var scale = deviceWidth/tableWidth;
    table.style.fontSize = Math.floor(16*scale) + "px";

    var cells = document.getElementsByClassName('username');
    for(i = 0; i < cells.length; i++) {
      cells[i].style.minWidth = 125*scale/1.25 + 'px';
      cells[i].style.maxWidth = 125*scale/1.25 + 'px';
    }

    var cells = document.getElementsByClassName('week');
    for(i = 0; i < cells.length; i++) {
      cells[i].style.minWidth = 100*scale/2 + 'px';
      cells[i].style.maxWidth = 100*scale/2 + 'px';
    }
  }
}
