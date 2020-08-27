var canv;
var ctx;

var a;
var b;

var slider;
var p = 0.7;
var iterations = 20;

function doAllmain() {
  document.addEventListener("DOMContentLoaded", function() {
    Setup();
    slider = document.getElementById("p");
    p = slider.value / 1000;
    slider.oninput = function() {
      p = this.value / 1000;
    }
    setInterval(function() {
      Clear();
      Draw(iterations);
    }, 50);

  });
}

function doAllExplanation() {
  document.addEventListener("DOMContentLoaded", function() {
    p = 0.7;
    Setup2('canvas1');
    Draw(0);

    Setup2('canvas2');
    Draw(1);

    Setup2('canvas3');
    Draw(2);
  });
}

function Setup() {
  canv = document.getElementById('canvas');
  if(canv.getContext('2d')) {
    ctx = canv.getContext('2d');
  }
  a = canv.width;
  b = Math.ceil(a * Math.sqrt(3) / 2);
  canv.height = b;
}

function Setup2(id) {
  canv = document.getElementById(id);
  if(canv.getContext('2d')) {
    ctx = canv.getContext('2d');
  }
  a = canv.width;
  b = Math.ceil(a * Math.sqrt(3) / 2);
  canv.height = b;
}

function Clear() {
  ctx.fillStyle = "white";
  ctx.fillRect(0, 0, canv.width, canv.height);
}

function Draw(it) {
  ctx.fillStyle = "black";
  ctx.beginPath();
  DrawPath(it);
  ctx.stroke();
}

function DrawPath(it) {
  ctx.moveTo(a/2, 0);
  ctx.lineTo(a, b);
  ctx.lineTo(0, b);
  ctx.lineTo(a/2, 0);
  var top = a / 2;
  DrawLeft(a, b, it, top);
  DrawRight(a, b, it, top);
}

function DrawLeft(a0, b0, it, top) {
  ctx.moveTo(top - a0 / 2 * (1 - p), b - b0 * p);
  ctx.lineTo(top + a0 * (p - 0.5), b);
  if(it > 0) {
    DrawLeft(a0 * p, b0 * p, it - 1, top - a0 / 2 * (1 - p));
  }
  DrawRight(a0, b0, it - 1, top);
}

function DrawRight(a0, b0, it, top) {
  ctx.moveTo(top + a0 / 2 * p, b - b0 * (1 - p));
  ctx.lineTo(top + a0 * (p - 0.5), b);
  if(it > 0) {
    DrawLeft(a0 * (1 - p), b0 * (1 - p), it - 1, top + a0 / 2 * p);
  }
}
