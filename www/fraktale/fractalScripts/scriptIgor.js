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

function doAllIgor() {
  Setup();
  Draw();
}

function Setup() {
  canv = document.getElementById('canvas');
  ctx = canv.getContext('2d');
  _a = canv.width * 3 / 4;
  canv.height = canv.width;
  iterations = 5;
  input = document.getElementById('it');
  input.oninput = function() {
    iterations = this.value;
  }
}

function Draw() {
  ctx.clearRect(0, 0, canv.width, canv.height);
  ctx.strokeStyle = "black";
  ctx.beginPath();

  var p0 = new Point(canv.width / 2, 0);
  DrawFractal(p0, _a, 90, iterations);
  ctx.stroke();
}

function Clear() {
  ctx.clearRect(0, 0, canv.width, canv.height);
}


function DrawFractal(p, a, alpha, it) {
  if(it > 0) {
    var p1 = DrawLine(p, a / 2, alpha);
    var p2 = DrawLine(p1, a / 4, alpha);
    var p3 = DrawLine(p2, a / 4, alpha);

    //var pp1 = DrawLine(p1, a / 2, alpha + 90);
    //var pp2 = DrawLine(p2, a / 4, alpha - 90);
    //var pp3 = DrawLine(p3, a / 2, alpha + 90);

    DrawFractal(p1, a / 2, alpha + 90, it - 1);
    DrawFractal(p2, a / 4, alpha - 90, it - 1);
    DrawFractal(p3, a / 2, alpha + 90, it - 1);
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
