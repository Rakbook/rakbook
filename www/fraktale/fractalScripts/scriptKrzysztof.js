var canv;
var ctx;

var _a;
var iterations;

var bgColour = 'white';
var mainColour = 'black';

var input;

class Point {
  constructor(x, y) {
    this.x = x;
    this.y = y;
  }
}

function doAllKrzysztof() {
  Setup();
  Draw();
}

function Setup() {
  canv = document.getElementById('canvas');
  ctx = canv.getContext('2d');
  _a = canv.width / 3;
  canv.height = canv.width * 2 / Math.sqrt(3);
  iterations = 4;
  input = document.getElementById('it');
  input.oninput = function() {
    iterations = this.value;
  }
}

function Draw() {
  ctx.fillStyle = bgColour;
  ctx.fillRect(0, 0, canv.width, canv.height);

  ctx.strokeStyle = mainColour;
  var p0 = new Point(_a, _a * Math.sqrt(3) / 2);

  for(var i = 0; i < 6; i++) {
    ctx.beginPath();
    var p00 = DrawLine(p0, _a, 60 * i);
    ctx.stroke();
    DrawKoch(p0, _a, 60 * i, iterations);
    p0 = p00;
  }

}

function DrawKoch(p1, a, alpha, it) {
  if(it > 0) {
    for(var i = 0; i < 6; i++) { /// to make it enough white and not grey (although quite inefficient)
      ctx.beginPath();
      var oneThird = GetPoint(p1, a / 3, alpha);
      var twoThirds = DrawLine(oneThird, a / 3, alpha);
      ctx.strokeStyle = bgColour;
      ctx.stroke();
    }

    ctx.beginPath();
    var mid1 = DrawY(oneThird, a / 3, alpha);
    var mid2 = DrawY(twoThirds, a / 3, alpha - 180);
    ctx.strokeStyle = mainColour;
    ctx.stroke();

    /// new subfractals:
    DrawKoch(oneThird, a / 3, alpha - 180, it - 1);
    DrawKoch(oneThird, a / 3, alpha + 60, it - 1);
    DrawKoch(oneThird, a / 3, alpha - 60, it - 1);

    DrawKoch(twoThirds, a / 3, alpha, it - 1);
    DrawKoch(twoThirds, a / 3, alpha + 120, it - 1);
    DrawKoch(twoThirds, a / 3, alpha - 120, it - 1);

    DrawKoch(mid1, a / 3, alpha + 90, it - 1);
    DrawKoch(mid2, a / 3, alpha - 90, it - 1);
  }
}

function DrawY(p1, a, alpha) {
  var mid = DrawLine(p1, a, alpha + 60);
  DrawLine(mid, a, alpha - 60);
  DrawLine(mid, a, alpha + 90);

  return mid;
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
