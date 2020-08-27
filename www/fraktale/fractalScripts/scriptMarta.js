var canv;
var ctx;

var _a;
var _alpha;
var iterations;

var sliderAlpha;
var output;


class Point {
  constructor(x, y) {
    this.x = x;
    this.y = y;
  }
}

function doAllMarta() {
  Setup();
  output = document.getElementById("alphaValue");
  sliderAlpha = document.getElementById("p");
  _alpha = parseInt(sliderAlpha.value);
  output.innerHTML = "alfa = " + _alpha;
  sliderAlpha.oninput = function() {
    _alpha = parseInt(this.value);
    output.innerHTML = "alfa = " + _alpha;
  }
  setInterval(function() {
    Clear();
    Draw();
  }, 100);
}

function Setup() {
  canv = document.getElementById('canvas');
  ctx = canv.getContext('2d');
  _a = canv.width / 4;
  canv.height = canv.width;
  iterations = 3;
}

function Draw() {
  ctx.fillStyle = "black";
  ctx.beginPath();

  var p0 = new Point(_a * 2, _a * 2);
  for(var i = 0; i < 5; i++) {
    DrawFractal(p0, _a, i * 72, iterations);
  }
  ctx.stroke();
}

function Clear() {
  ctx.clearRect(0, 0, canv.width, canv.height);
}


function DrawFractal(p, a, alpha, it) {
  if(it > 0) {
    DrawY(p, a / 3, alpha + _alpha);
    DrawY(p, a / 3, alpha - _alpha);
    var p2 = DrawLine(p, a, alpha);
    DrawY(p2, a / 2, alpha + _alpha);
    DrawY(p2, a / 2, alpha - _alpha);
    var p3 = GetPoint(p, a / 2, alpha);

    DrawFractal(p3, a / 2, alpha + _alpha, it - 1);
    DrawFractal(p3, a / 2, alpha - _alpha, it - 1);
  }
}

function DrawY(p1, a, alpha) {
  var p2 = DrawLine(p1, a, alpha);
  DrawLine(p2, a / 2, alpha + _alpha);
  DrawLine(p2, a / 2, alpha - _alpha);
}

function DrawLine(p1, a, alpha) {
  var p2 = GetPoint(p1, a, alpha);
  moveTo(p1);
  lineTo(p2);
  return p2;
}

function GetPoint(p1, a, alpha) {
  var p2 = new Point(p1.x + a * Math.cos(alpha * Math.PI / 180), p1.y + a * Math.sin(alpha * Math.PI / 180));
  return p2;
}

function moveTo(p) {
  ctx.moveTo(p.x, canv.height - p.y);
}

function lineTo(p) {
  ctx.lineTo(p.x, canv.height - p.y);
}
