var ratio;
var a;

var kInput;

var mc;

function doAllMarcin() {

  mc = new MovableCanvas("canvas");

  kInput = document.getElementById('k');
  kInput.oninput = function() {
    ratio = 1.0 / this.value;
	mc.refresh = true;
  }
  ratio = 1.0/kInput.value;
  a = canvas.width * 0.7;
  mc.setDrawing(draw, {});
  mc.refresh = true;
}

function draw(p, mc)
{
	mc.context.save();
	mc.context.translate(mc.context.canvas.width/2, mc.context.canvas.height/2);
	let triangleStart = [[-a/2, a * Math.sqrt(3) / 4.0], [0.0, -a * Math.sqrt(3) / 4.0], [a/2, a * Math.sqrt(3) / 4.0]];
	drawTriangle(triangleStart, 5000);
	mc.context.restore();
}

function drawTriangle(triangle, stepsLeft)
{
	if(triangleSize(triangle)*mc.scale<1 || stepsLeft<1) return;
	let a = triangle[0], b = triangle[1], c = triangle[2];
	mc.context.beginPath();
	mc.context.lineWidth = 1/mc.scale;
	mc.context.moveTo(a[0], a[1]);
	mc.context.lineTo(b[0], b[1]);
	mc.context.lineTo(c[0], c[1]);
	mc.context.lineTo(a[0], a[1]);
	mc.context.stroke();
	drawTriangle(newTriangle(triangle), stepsLeft-1);
}

function newTriangle(triangle){
	let a = triangle[0], b = triangle[1], c = triangle[2];
	
	let newA = [(b[0] - a[0]) * ratio + a[0], (b[1] - a[1]) * ratio + a[1]];
	let newB = [(c[0] - b[0]) * ratio + b[0], (c[1] - b[1]) * ratio + b[1]];
	let newC = [(a[0] - c[0]) * ratio + c[0], (a[1] - c[1]) * ratio + c[1]];
	
	return [newA, newB, newC];
}

function triangleSize(triangle)
{
	let a = triangle[0], b = triangle[1];
	return Math.sqrt(Math.pow(a[0]-b[0],2) + Math.pow(a[1]-b[1], 2));
}
