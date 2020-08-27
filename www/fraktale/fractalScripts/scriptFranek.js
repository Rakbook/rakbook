var canv;
var ctx;

var _a;
var ratio;
var iterations;

var itInput;
var ratioInput;

class Point {
  constructor(x, y) {
    this.x = x;
    this.y = y;
  }
}

function doAllFranek() {
  Setup();
  Draw();
}

function Setup() {
  canv = document.getElementById('canvas');
  ctx = canv.getContext('2d');
  _a = (canv.width - 20) / 2;
  ratio = 0.75;
  iterations = 6;
  var height = 0;
  var a = _a;
  for(var i = 0; i < iterations; i++) {
    height += a;
    a *= ratio;
  }
  height += 20;
  canv.height = height;

  itInput = document.getElementById('it');
  itInput.oninput = function() {
    iterations = this.value;
  }
  ratioInput = document.getElementById('ratio');
  ratioInput.oninput = function() {
    ratio = this.value;
  }
}

function CanvasSetup() {
  var height = 0;
  var a = _a;
  for(var i = 0; i < iterations; i++) {
    height += a;
    a *= ratio;
  }
  height += 20;
  canv.height = height;
}

function Draw() {
  CanvasSetup();
  ctx.clearRect(0, 0, canv.width, canv.height);

  ctx.fillStroke = "black";
  ctx.beginPath();

  var p0 = new Point(_a + 10, 0 + 10); // +1, for the bottom line to be visible
  DrawFractal(p0, _a, 1, iterations);
  ctx.stroke();
}

function DrawFractal(p, a, dir, it) {
  if(it > 0) {
    var alpha = 90 + dir * 90; // left or right
    DrawLine(p, a, alpha);
    DrawArc(p, a, alpha, 90, dir);

    var p2 = GetPoint(p, a, 90);
    DrawFractal(p2, a * ratio, dir * -1, it - 1);
  }
}

function DrawArc(p, a, alpha1, alpha2, dir) {
  alpha1 *= -1; // -, because canvas coordinates are flipped
  alpha2 *= -1; // -, because canvas coordinates are flipped
  dir = AngleDir(-dir); // -, because canvas coordinates are flipped
  ctx.arc(p.x, canv.height - p.y, a, DegToRad(alpha1), DegToRad(alpha2), dir);
}

function DrawLine(p1, a, alpha) {
  var p2 = GetPoint(p1, a, alpha);
  moveTo(p1);
  lineTo(p2);
  return p2;
}

function GetPoint(p1, a, alpha) {
  var p2 = new Point(p1.x + a * Math.cos(DegToRad(alpha)), p1.y + a * Math.sin(DegToRad(alpha)));
  return p2;
}

function DegToRad(alpha) {
  return alpha * Math.PI / 180;
}

function AngleDir(dir) {
  if(dir > 0) {
    return true;
  }
  return false;
}

function moveTo(p) {
  ctx.moveTo(p.x, canv.height - p.y);
}

function lineTo(p) {
  ctx.lineTo(p.x, canv.height - p.y);
}
