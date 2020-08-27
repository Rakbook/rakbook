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

function doAllMaya() {
  Setup();
  Draw();
}

function Setup() {
  canv = document.getElementById('canvas');
  ctx = canv.getContext('2d');
  _a = canv.width / 3;
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

  var p0 = new Point(_a, _a);
  var p = DrawSquare(p0, _a);
  for(var i = 0; i < 4; i++) {
    DrawFractal(p[i], _a, 45 + 90 * i, iterations);
  }
  ctx.stroke();
}

function DrawSquare(p0, a) {
  var p = [];
  p[0] = DrawLine(p0, a, 0);
  p[1] = DrawLine(p[0], a, 90);
  p[2] = DrawLine(p[1], a, 180);
  p[3] = DrawLine(p[2], a, 270);
  return p;
}

function DrawFractal(p, a, alpha, it) {
  if(it > 0) {
    var aa = a / Math.sqrt(2);
    var p2 = DrawLine(p, aa, alpha);
    DrawLine(p2, aa, alpha + 90);

    DrawFractal(p, aa, alpha - 45, it - 1);
    DrawFractal(p2, aa, alpha + 45, it - 1);
  }
}

function DrawLine(p1, a, alpha) {
  var p2 = new Point(p1.x + a * Math.cos(alpha * Math.PI / 180), p1.y + a * Math.sin(alpha * Math.PI / 180));

  moveTo(p1);
  lineTo(p2);
  return p2;
}

function moveTo(p) {
  ctx.moveTo(p.x, canv.height - p.y);
}

function lineTo(p) {
  ctx.lineTo(p.x, canv.height - p.y);
}
