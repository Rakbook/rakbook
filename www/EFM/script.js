const c = document.getElementById("Canvas");
const context = c.getContext("2d");
var size = parseInt(document.getElementById("baseShape").value);
var width = 420/(size+2);
var baseX = Math.floor((420-size*width)/2);
var canvasData = [];
var iter = parseInt(document.getElementById("iterInput").value);

function drawSGrid(){
  context.strokeStyle = "#d3d3d3";
  context.lineWidth = 2;
  context.fillStyle = "#ffffff";

  context.fillRect(0, 0, 420, 420);

  let x = 0;
  let y = 0;
  width = 420/(size+2);

  context.beginPath();
  context.moveTo(0, 0);
  context.lineTo(420, 0);

  for(let j=0; j<size+2; j++){
    context.moveTo(x, y);
    for(let i=0; i<size+2; i++){

      context.lineTo(x, y+width);
      context.lineTo(x+width, y+width);
      context.moveTo(x+width, y);
      x=x+width;
    }
    context.lineTo(x, y+width);
    y=y+width;
    x=0;
  }
  context.stroke();
}


function clearAll(){
  context.fillStyle = "#ffffff";
  context.fillRect(0, 0, 840, 840);
}


function rgbToHex(r, g, b) {
    return ((r << 16) | (g << 8) | b).toString(16);
}

function addS(e){
  var pos = getMousePos(Canvas, e);
  let p = context.getImageData(pos.x, pos.y, 1, 1).data;
  let hex = "#" + ("000000" + rgbToHex(p[0], p[1], p[2])).slice(-6);

  width = 420/(size+2);
  var xpos = Math.floor(pos.x/width);
  var ypos = Math.floor(pos.y/width);
  baseX = Math.floor((420-size*width)/2);

  if(size!=0){
    if(hex == "#ffffff" || hex == "#cb4335"){
      context.fillStyle = "#2993DA";
      context.fillRect(xpos*width+1, ypos*width+1, width-2, width-2);
    }
    else{
      if(pos.x > baseX && pos.x < baseX+size*width && pos.y > baseX && pos.y < baseX+size*width){
        context.fillStyle = "#cb4335";
        context.fillRect(xpos*width+1, ypos*width+1, width-2, width-2);
      }
      else{
      context.fillStyle = "#ffffff";
      context.fillRect(xpos*width+1, ypos*width+1, width-2, width-2);
      }
    }
  }
}

function getMousePos(canvas, evt) {
    var rect = canvas.getBoundingClientRect();
    return {
        x: (evt.clientX - rect.left) / (rect.right - rect.left) * canvas.width,
        y: (evt.clientY - rect.top) / (rect.bottom - rect.top) * canvas.height
    };
}

Canvas.addEventListener('click', addS, false);

function createBaseShape(){
  width = 420/(size+2);
  baseX = Math.floor((420-size*width)/2);
  context.fillStyle = "#CB4335";

  for(let j=1; j<size+1; j++){
    for(let i=1; i<size+1; i++){
      context.fillRect(i*baseX+1, j*baseX+1, baseX-2, baseX-2);
    }
  }
}

function makeArray(){
  canvasData = new Array(size+2);

  for (let i = 0; i < size+2; i++) {
    canvasData[i] = new Array(size+2);
  }
}

function getData(){
  let middle = width/2;
  makeArray();
  for(let i=0; i<size+2; i++){
    for(let j=0; j<size+2; j++){
      let p = context.getImageData(middle+i*width, middle+j*width , 1, 1).data;
      let hex = "#" + ("000000" + rgbToHex(p[0], p[1], p[2])).slice(-6);
      canvasData[i][j] = hex;
    }
  }
  console.log(canvasData);
}

function drawPiece(pointX, pointY, sWidth, it){
  for(let i=0; i<size+2; i++){
    for(let j=0; j<size+2; j++){
      if(canvasData[i][j] == "#2993da"){
        if((iter-it)%2==0){
          context.fillStyle = "#2993da";
        }
        else {
          context.fillStyle = "#cb4335";
        }
        context.fillRect(pointX+sWidth*i-sWidth, pointY+sWidth*j-sWidth, sWidth, sWidth);
      }
    }
  }
}

function drawFractalPieces(pointX, pointY, sWidth, it){
  for(let i=0; i<size+2; i++){
    for(let j=0; j<size+2; j++){
      if(canvasData[j][i] == "#2993da"){
        if(it > 0){
        drawPiece(pointX, pointY, sWidth, it);
        }
      }
    }
  }
  for(let i=0; i<size+2; i++){
    for(let j=0; j<size+2; j++){
      if(canvasData[j][i] == "#2993da"){
        if(it > 0){
          drawFractalPieces(pointX+sWidth*(j-1), pointY+sWidth*(i-1), sWidth/size, it-1);
        }
      }
    }
  }
}


function makeFractal(){
  document.getElementById("buttonBar1").style.display = 'none';
  document.getElementById("buttonBar2").style.display = 'none';
  document.getElementById("buttonBar4").style.display = 'none';
  document.getElementById("buttonBar3").style.display = 'flex';
  document.getElementById("p1").style.display = 'none';
  getData();
  Canvas.width = 840;
  Canvas.height = 840;
  Canvas.style.border = null;
  let middle = 420;

  clearAll();

  context.fillStyle = "#CB4335"
  context.fillRect(middle-size/2*width, middle-size/2*width, size*width, size*width);

  Canvas.removeEventListener('click', addS, false);
  iter = parseInt(document.getElementById("iterInput").value);
  drawFractalPieces(middle-size/2*width, middle-size/2*width, width, iter);
}

function increase(object){
  if(document.getElementById(object) == document.getElementById("baseShape")){
    if(document.getElementById(object).value == 5){
      document.getElementById(object).value = 1;
    }
    else{
      document.getElementById(object).value = document.getElementById(object).value-(-1);
    }
    draw();
  }
  else{
    if(document.getElementById(object).value != 9){
      document.getElementById(object).value = document.getElementById(object).value-(-1);
    }
  }
}

function decrease(object){
  if(document.getElementById(object) == document.getElementById("baseShape")){
    if(document.getElementById(object).value == 1){
      document.getElementById(object).value = 5;
      draw();
    }
    else {
      document.getElementById(object).value =document.getElementById(object).value-1;
      draw();
    }
  }
  else if(document.getElementById(object).value != 1){
    document.getElementById(object).value =document.getElementById(object).value-1;
  }
}

function draw(){
  size = parseInt(document.getElementById("baseShape").value);
  drawSGrid();
  createBaseShape();
}

document.onload = draw();

function drawSelected(){
  for(let i=0; i<size+2; i++){
    for(let j=0; j<size+2; j++){
      if(canvasData[j][i] == "#2993da"){
        context.fillStyle = "#2993da";
        context.fillRect(width*j+1, width*i+1, width-2, width-2);
      }
      else if(canvasData[j][i] == "#cb4335"){
        context.fillStyle = "#cb4335";
        context.fillRect(width*j+1, width*i+1, width-2, width-2);
      }
    }
  }
}

function reset(){
  document.getElementById("buttonBar1").style.display = 'flex';
  document.getElementById("buttonBar2").style.display = 'flex';
  document.getElementById("buttonBar4").style.display = 'flex';
  document.getElementById("buttonBar3").style.display = 'none';
  document.getElementById("p1").style.display = 'block';
  clearAll();
  Canvas.width = 420;
  Canvas.height = 420;
  Canvas.style.border = "1px solid #d3d3d3";
  Canvas.addEventListener('click', addS, false);
  drawSGrid();
  drawSelected();
}

function loadPreset(x){
  if(x==1){
    size = 3;
    iter = 4;
    makeArray();
    canvasData = [
      ["#ffffff", "#2993da", "#ffffff", "#2993da", "#ffffff"],
      ["#2993da", "#cb4335", "#cb4335", "#cb4335", "#2993da"],
      ["#ffffff", "#cb4335", "#2993da", "#cb4335", "#ffffff"],
      ["#2993da", "#cb4335", "#cb4335", "#cb4335", "#2993da"],
      ["#ffffff", "#2993da", "#ffffff", "#2993da", "#ffffff"]];
      document.getElementById("baseShape").value = 3;
      document.getElementById("iterInput").value = 4;
  }
  else if(x==2){
    size = 3;
    iter = 4;
    makeArray();
    canvasData = [
      ["#2993da", "#2993da", "#ffffff", "#2993da", "#2993da"],
      ["#2993da", "#cb4335", "#cb4335", "#cb4335", "#2993da"],
      ["#ffffff", "#cb4335", "#cb4335", "#cb4335", "#ffffff"],
      ["#2993da", "#cb4335", "#cb4335", "#cb4335", "#2993da"],
      ["#2993da", "#2993da", "#ffffff", "#2993da", "#2993da"]];
      document.getElementById("baseShape").value = 3;
      document.getElementById("iterInput").value = 4;
  }
  else if(x==3){
    size = 2;
    iter = 6;
    makeArray();
    canvasData = [
      ["#2993da", "#ffffff", "#ffffff", "#2993da"],
      ["#ffffff", "#cb4335", "#cb4335", "#ffffff"],
      ["#ffffff", "#cb4335", "#cb4335", "#ffffff"],
      ["#2993da", "#ffffff", "#ffffff", "#2993da"]];
      document.getElementById("baseShape").value = 2;
      document.getElementById("iterInput").value = 6;
  }
  else if(x==4){
    size = 2;
    iter = 5;
    makeArray();
    canvasData = [
      ["#ffffff", "#2993da", "#ffffff", "#ffffff"],
      ["#ffffff", "#cb4335", "#cb4335", "#2993da"],
      ["#2993da", "#cb4335", "#cb4335", "#ffffff"],
      ["#ffffff", "#ffffff", "#2993da", "#ffffff"]];
      document.getElementById("baseShape").value = 2;
      document.getElementById("iterInput").value = 5;
  }
  drawSGrid();
  drawSelected();
}
