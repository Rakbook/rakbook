// Zanim zaczniemy, to kika słów o naszym sponsorze
// RaidS... tzn.
// Mateusz Sobkowiak - fenomenalny człowiek i autor tego pragramu
// Aleksander Szydłowski - autor koncepcji tego fraktala
// A teraz wracamy do odcinka
// w dzisiejsztym odcinku występują:

// fenomenalny canvas
var c;
var context;

//eleganckie parametry generacji
var defaultStartingY = 550;
var defaultCanvasSize = 800;
var defaultBaseLength = 200;
var rightAngle = 60;
var leftAngle = 60;
var k = 0.2;
var iter = 3;
var showCircles = 0;

// paid promotion
function doAllOlek() {
  c = document.getElementById("canvas");
  context = c.getContext("2d");
  canvasSize = defaultCanvasSize;
  showed = 0;
  invert = 0;
  lastInit = 0;
  window.addEventListener('resize', onPageLoad);
  onPageLoad();
}
// skip ad


// najlepsze pomocnicze funkcje
  function degToRad(x){
    return x/180*Math.PI;
  }

  function calcR(b, r, l){
    return (b + r + l)/3*k;
  }

  function clear(){
    context.clearRect(0, 0, size, size);
    //context.fillStyle = "#ffffff";
    //context.fillRect(0, 0, size, size);
  }

  let size, angleLimit;
  var canvasSize;
  var showed;
  function resize(){
    if(window.innerWidth < window.innerHeight){
      size = window.innerWidth-200;
    }
    else{
      size = window.innerHeight-200;
    }
      c.width = size;
      c.height = size;
      document.getElementById('angleSlider1').style.width = size.toString() + 'px';
      document.getElementById('angleSlider2').style.width = size.toString() + 'px';
      document.getElementById('SliderBox1').style.width = (size/2).toString() + 'px';
      document.getElementById('SliderBox2').style.width = (size/2).toString() + 'px';
      defaultStartingY = defaultStartingY*size/canvasSize;
      defaultBaseLength = defaultBaseLength*size/canvasSize;
      canvasSize = size;

      if(showed){
        init(0);
      }
  }
  var degSize, temp;
  function setAngleLimit(){
    rightAngle = parseInt(document.getElementById("angleSlider1").value);
    leftAngle = parseInt(document.getElementById("angleSlider2").value);

    init(0);

    degSize = size/2/180;
    temp = degSize*(181-leftAngle);
    document.getElementById('angleSlider1').style.width = temp.toString() + 'px';
    document.getElementById('angleSlider1').max = 180-leftAngle;

    temp = degSize*(181-rightAngle);
    document.getElementById('angleSlider2').style.width = temp.toString() + 'px';
    document.getElementById('angleSlider2').max = 180-rightAngle;

    document.getElementById('sliderValue1').innerHTML = 'Prawy kąt: ' + rightAngle.toString() +'°';
    document.getElementById('sliderValue2').innerHTML = 'Lewy kąt: ' + leftAngle.toString() + '°';
  }



  var thirdAngle, rightArmLength, leftArmLength, height, heightPoint;
  var invert;

  function calc(){
    invert = 0;
    thirdAngle = 180 - rightAngle - leftAngle;
    rightArmLength = defaultBaseLength/Math.sin(degToRad(thirdAngle))*Math.sin(degToRad(leftAngle));
    leftArmLength = defaultBaseLength/Math.sin(degToRad(thirdAngle))*Math.sin(degToRad(rightAngle));

    if(rightAngle>=90){
      height = rightArmLength * Math.sin(degToRad(rightAngle));
      heightPoint = Math.pow(leftArmLength, 2) - Math.pow(height, 2);
      heightPoint = Math.sqrt(Math.abs(heightPoint));
    }
    else{
      height = leftArmLength * Math.sin(degToRad(leftAngle));
      heightPoint = Math.pow(rightArmLength, 2) - Math.pow(height, 2);
      heightPoint = Math.sqrt(Math.abs(heightPoint));
      invert = 1;
    }
    return invert;
  }

  function onPageLoad(){
    resize();
    setAngleLimit();
  }


// gwiazdy dzisiejszego wieczora
  function drawStartingTriangle(x, y, h, w, hp){
    if(invert==1){
      context.beginPath();
      context.moveTo(x+w, y);
      context.lineTo(x, y);
      context.moveTo(x+w-hp, y-h);
      context.lineTo(x, y);
      context.moveTo(x+w-hp, y-h);
      context.lineTo(x+w, y);
      context.stroke();
    }
    else{
      context.beginPath();
      context.moveTo(x, y);
      context.lineTo(x+w, y);
      context.moveTo(x+hp, y-h);
      context.lineTo(x, y);
      context.moveTo(x+hp, y-h);
      context.lineTo(x+w, y);
      context.stroke();
    }
  }

  function drawCircles(r, x, y, h, w, hp){
    if(invert){
      context.beginPath();
      context.arc(x+w, y, r, 0, 2 * Math.PI);
      context.stroke();

      context.beginPath();
      context.arc(x, y, r, 0, 2 * Math.PI);
      context.stroke();

      context.beginPath();
      context.arc(x+w-hp, y-h, r, 0, 2 * Math.PI);
      context.stroke();
    }
    else{
      context.beginPath();
      context.arc(x, y, r, 0, 2 * Math.PI);
      context.stroke();

      context.beginPath();
      context.arc(x+w, y, r, 0, 2 * Math.PI);
      context.stroke();

      context.beginPath();
      context.arc(x+hp, y-h, r, 0, 2 * Math.PI);
      context.stroke();
    }
  }

  function drawTriangle(ra, la, db, i, x, y, h, hp, inv){

    let r = calcR(ra, la, db);
    let b = r*2*Math.sin(degToRad(thirdAngle));
    let offset = Math.pow(r, 2) - Math.pow(b*0.5, 2);
        offset = Math.sqrt(Math.abs(offset));
        if(thirdAngle>90){
          offset = offset*-1;
        }
    let ratio = b/db;

    if(i>0+showCircles){
      if(invert){
        context.beginPath();
        context.moveTo(x+db+b*0.5, y+offset);
        context.lineTo(x+db-b*0.5, y+offset);
        context.moveTo(x+db+b*0.5-hp*ratio, y+offset-h*ratio);
        context.lineTo(x+db+b*0.5, y+offset);
        context.moveTo(x+db+b*0.5-hp*ratio, y+offset-h*ratio);
        context.lineTo(x+db-b*0.5, y+offset, y+offset);
        context.stroke();

        context.beginPath();
        context.moveTo(x+b*0.5, y+offset);
        context.lineTo(x-b*0.5, y+offset);
        context.moveTo(x+b*0.5-hp*ratio, y+offset-h*ratio);
        context.lineTo(x+b*0.5, y+offset);
        context.moveTo(x+b*0.5-hp*ratio, y+offset-h*ratio);
        context.lineTo(x-b*0.5, y+offset);
        context.stroke();

        context.beginPath();
        context.moveTo(x+b*0.5+db-hp, y+offset-h);
        context.lineTo(x-b*0.5+db-hp, y+offset-h);
        context.moveTo(x+b*0.5-hp*ratio+db-hp, y+offset-h*ratio-h);
        context.lineTo(x+b*0.5+db-hp, y+offset-h);
        context.moveTo(x+b*0.5-hp*ratio+db-hp, y+offset-h*ratio-h);
        context.lineTo(x-b*0.5+db-hp, y+offset-h);
        context.stroke();
      }
      else{
        context.beginPath();
        context.moveTo(x-b*0.5, y+offset);
        context.lineTo(x+b*0.5, y+offset);
        context.moveTo(x-b*0.5+hp*ratio, y+offset-h*ratio);
        context.lineTo(x-b*0.5, y+offset);
        context.moveTo(x-b*0.5+hp*ratio, y+offset-h*ratio);
        context.lineTo(x+b*0.5, y+offset);
        context.stroke();

        context.beginPath();
        context.moveTo(x-b*0.5+db, y+offset);
        context.lineTo(x+b*0.5+db, y+offset);
        context.moveTo(x-b*0.5+hp*ratio+db, y+offset-h*ratio);
        context.lineTo(x-b*0.5+db, y+offset);
        context.moveTo(x-b*0.5+hp*ratio+db, y+offset-h*ratio);
        context.lineTo(x+b*0.5+db, y+offset);
        context.stroke();

        context.beginPath();
        context.moveTo(x-b*0.5+hp, y+offset-h);
        context.lineTo(x+b*0.5+hp, y+offset-h);
        context.moveTo(x-b*0.5+hp*ratio+hp, y+offset-h*ratio-h);
        context.lineTo(x-b*0.5+hp, y+offset-h);
        context.moveTo(x-b*0.5+hp*ratio+hp, y+offset-h*ratio-h);
        context.lineTo(x+b*0.5+hp, y+offset-h);
        context.stroke();
      }
    }

    if(i>showCircles*2+1){
      if(invert){
        drawTriangle(ra*ratio, la*ratio, b, i-1-2*showCircles, x+db-b*0.5, y+offset, h*ratio, hp*ratio, inv);
        drawTriangle(ra*ratio, la*ratio, b, i-1-2*showCircles, x-b*0.5, y+offset, h*ratio, hp*ratio, inv);
        drawTriangle(ra*ratio, la*ratio, b, i-1-2*showCircles, x-b*0.5+db-hp, y+offset-h, h*ratio, hp*ratio, inv);
      }
      else{
        drawTriangle(ra*ratio, la*ratio, b, i-1-2*showCircles, x-b*0.5, y+offset, h*ratio, hp*ratio, inv);
        drawTriangle(ra*ratio, la*ratio, b, i-1-2*showCircles, x-b*0.5+db, y+offset, h*ratio, hp*ratio, inv);
        drawTriangle(ra*ratio, la*ratio, b, i-1-2*showCircles, x-b*0.5+hp, y+offset-h, h*ratio, hp*ratio, inv);
      }
    }
    else if(i%3!=0 && showCircles==1){
      drawCircles(r, x, y, h, db, hp);
    }
  }

  // inicjator występu
  var lastInit;
    function init(tr){
      lastInit = tr;
      clear();
      iter = parseInt(document.getElementById("iterInput").value); console.log(iter);
      k = parseFloat(document.getElementById("kInput").value); console.log(k);
      showCircles = document.getElementById("showCirclesBox").checked;
      calc();

      let startingX = (canvasSize-defaultBaseLength)/2;
      drawStartingTriangle(startingX, defaultStartingY, height, defaultBaseLength, heightPoint);

      if(iter > 1 && tr){
        drawTriangle(rightArmLength, leftArmLength, defaultBaseLength, iter-1, startingX, defaultStartingY, height, heightPoint, invert);
      }
      showed = 1;
    }

// prosimy o gorące brawa
// tak to już koniec :(
