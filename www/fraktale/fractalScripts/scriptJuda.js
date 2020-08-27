let divisions;
let startColor;
let colorChange;

let mc;

class Point
{
	constructor(x, y)
	{
		this.x = x;
		this.y = y;
	}

	static distance(p1, p2)
	{
		let a = p1.x-p2.x;
		let b = p1.y-p2.y;
		return Math.sqrt(a*a+b*b);
	}
}

function doAllJuda() {
	divisions = 1;
	startColor = 0;
	colorChange = 1;
	
	mc = new MovableCanvas("canvas");
	mc.setDrawing(frame, {});
	
	startNormal();
}

let drawCircle = function(p1, p2, c, mc)
{
	let ctx = mc.context;
	let radius = Point.distance(p1, p2)/2;
	if(radius*mc.scale<1) return;
	let center = new Point((p1.x+p2.x)/2, (p1.y+p2.y)/2);


	ctx.save();
	ctx.translate(center.x, center.y);
	if(!circleVisible(radius*mc.scale, mc.getMatrix(), ctx.canvas.width, ctx.canvas.height))
	{
		ctx.restore();
		return;
	}

	let angle_offset = Math.atan2(p2.y-p1.y, p2.x-p1.x) * 180 / Math.PI-90;
	ctx.rotate(angle_offset*Math.PI/180);

	ctx.save();
	ctx.beginPath();
	ctx.fillStyle=getColor(c);
	ctx.arc(0, 0, radius, 0, 2*Math.PI);
	ctx.fill();
	ctx.lineWidth=1/mc.scale;
	ctx.stroke();
	ctx.restore();

	for(let i=1;i<divisions;i+=2)
	{
		let begin = pointOnCircle(radius, rotationStep(i, 180/divisions, 270));
		let end = pointOnCircle(radius, rotationStep(i+1, 180/divisions, 270));
		drawCircle(begin, end, c+colorChange, mc);
	}

	for(let i=divisions+1;i<divisions*2;i+=2)
	{
		let begin = pointOnCircle(radius, rotationStep(i, 180/divisions, 270));
		let end = pointOnCircle(radius, rotationStep(i+1, 180/divisions, 270));
		drawCircle(begin, end, c+colorChange, mc);
	}

	ctx.restore();

}

let frame = function(p, mc)
{
	let ctx = mc.context;
	let startPoint = new Point(0, -ctx.canvas.height/2*0.9);
	let endPoint = new Point(0, ctx.canvas.height/2*0.9);
	ctx.save();
	ctx.scale(1, -1);
	ctx.translate(ctx.canvas.width/2, -ctx.canvas.height/2);
	drawCircle(startPoint, endPoint, startColor, mc);
	ctx.restore();
}

function startNormal()
{
	divisions=getCircleNum()*2+1;
	startColor=getInitialColor();
	colorChange=getColorChange();
}

function getCircleNum()
{
	return parseInt(document.getElementById("circles").value, 10);
}

function getInitialColor()
{
	return parseInt(document.getElementById("initial_color").value, 10);
}

function getColorChange()
{
	return parseInt(document.getElementById("color_change").value, 10);
}


function pointOnCircle(r, a)
{
	let radians = a*Math.PI/180;
	return new Point(r*Math.cos(radians), r*Math.sin(radians));
}

function rotationStep(x, size, begin)
{
	return (x*size+begin)%360;
}

function getColor(colorId)
{
	colorId = ((colorId%16)+16)%16;
	return "#"+colorId.toString(16).repeat(6);
}

function circleVisible(r, matrix, cw, ch)
{
	let absoluteX = matrix.e;
	let absoluteY = matrix.f;
	let d = r*2;
	if(absoluteX>cw+d||absoluteX<0-d||absoluteY>ch+d||absoluteY<0-d) return false;
	return true;
}
