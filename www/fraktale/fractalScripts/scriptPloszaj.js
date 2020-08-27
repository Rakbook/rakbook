var canv;
var ctx;

var _a;
var iterations;

var input;

class Point {
  constructor(x, y) {
    this.x = x;
    this.y = y;
  }
}

function doAllPloszaj() {
  Setup();
  Draw();
}

function Setup() {
  canv = document.getElementById('canvas');
  ctx = canv.getContext('2d');
  _a = canv.width - 10;
  canv.height = canv.width;
  iterations = 11;
  input = document.getElementById('it');
  input.oninput = function() {
    iterations = this.value;
  }
}

function Draw() {
  ctx.clearRect(0, 0, canv.width, canv.height);
  ctx.fillStyle = "black";
  ctx.beginPath();
  DrawLine(new Point(5, _a), _a, 0);
  var p0 = new Point(_a / 2 + 5, _a);

  DrawFractal(p0, _a, iterations);

  ctx.stroke();
}

function DrawFractal(p, a, it) {
  if(it > 0) {
    DrawLine(p, a, -90);
    var p2 = GetPoint(p, a / 4, 0);
    DrawFractal(p2, a / 2, it - 1);
  }
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
