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

function doAllKallas() {
  Setup();
  Draw();
}

function Setup() {
  canv = document.getElementById('canvas');
  ctx = canv.getContext('2d');
  _a = canv.width / 2;
  canv.height = canv.width;
  iterations = 4;

  input = document.getElementById('it');
  input.oninput = function() {
    iterations = this.value;
  }
}

function Draw() {
  ctx.clearRect(0, 0, canv.width, canv.height);

  ctx.fillStyle = "black";
  ctx.beginPath();

  var p0 = new Point(_a / 2, _a / 2);
  var a = _a;
  for(var i = 0; i < iterations; i++) {
    DrawFractal(p0, a);
    p0.x += a / 4;
    p0.y += a / 4;
    a /= 2;
  }
  ctx.stroke();
}


function DrawFractal(p, a) {
  var p2 = p;
  for(var i = 0; i < 4; i++) {
    p2 = DrawLine(p2, a * 3 / 8, i * 90);
    p2 = DrawLine(p2, a / 4, i * 90 - 60);
    p2 = DrawLine(p2, a / 4, i * 90 + 60);
    p2 = DrawLine(p2, a * 3 / 8, i * 90);
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
