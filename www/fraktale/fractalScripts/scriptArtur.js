var ratio;
var a;

function doAllArtur() {
	ratio = 1.0 / 2;
	stopien = 10;
	a = canvas.width * 0.3;
	
	let mc = new MovableCanvas("canvas");
	mc.setDrawing(redraw, {});
}

function circle(scaleFactor, totalScaleFactor, mc){
	let context = mc.context;
	if(totalScaleFactor * a * mc.scale < 1 || !circleVisible(a*totalScaleFactor*2*mc.scale, mc)) return;

	context.lineWidth = 10;
	context.beginPath();

	var baseSize = a;

	context.scale(scaleFactor, scaleFactor);
	context.arc(0, 0, baseSize, 0, 2 * Math.PI);
	context.closePath();
	context.fillStyle = "#f0f0f0";
	context.fill();
	context.stroke();

	let nC = baseSize / Math.sqrt(2) * 2;
	let x = baseSize * Math.sqrt(3) / 2;
	let y = -baseSize / 2;

	context.save();
	context.scale(1, 2);
	context.beginPath();
	context.arc(-x, y, baseSize / 4, Math.PI / 2, Math.PI);
	context.stroke();
	context.closePath();
	context.scale(1, 0.5);

	context.translate(-nC, -nC);
	context.rotate(2 * Math.PI - 1, 0);

	circle(scaleFactor, scaleFactor * totalScaleFactor, mc);

	context.restore();

	context.save();
	context.scale(1, 2);
	context.beginPath();
	context.arc(x, y, baseSize / 4, 0, Math.PI / 2);
	context.stroke();
	context.closePath();
	context.scale(1, 0.5);

	context.translate(nC, -nC);
	context.rotate(1, 0);

	circle(scaleFactor, scaleFactor * totalScaleFactor, mc);

	context.restore();

}

function redraw(params, mc){

	mc.context.lineWidth = 1;
	mc.context.save();
	mc.context.translate(mc.context.canvas.width/2, mc.context.canvas.height*0.6);
	circle(0.5, 1, mc);
	mc.context.restore();
	mc.context.beginPath();
	mc.context.stroke();
}

function circleVisible(r, mc)
{
	let cw = mc.context.canvas.width;
	let ch = mc.context.canvas.height;
	let absolute = mc.absolutePoint(0, 0);
	if(absolute.x>cw+r||absolute.x<0-r||absolute.x>ch+r||absolute.x<0-r) return false;
	return true;
}
