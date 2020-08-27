var canv;
var ctx;

var a;
var b;

var slider;
var p = 0.7;

var output;

function doAllNikodem() {
		Setup();
		output = document.getElementById("pValue");
		slider = document.getElementById("p");
		p = slider.value / 1000;
		output.innerHTML = "p = " + p;
		slider.oninput = function() {
			p = this.value / 1000;
			output.innerHTML = "p = " + p;
		Clear();
		Draw();
		}
	Clear();
	Draw();
}


function Setup() {
	canv = document.getElementById('canvas');
	if(canv.getContext('2d')) {
		ctx = canv.getContext('2d');
	}
	canv.width = 500;
	a = canv.width;
	b = Math.ceil(a * Math.sqrt(3) / 2);
	canv.height = b;
}

function Clear() {
	ctx.clearRect(0, 0, canv.width, canv.height);
}

function Draw() {
	ctx.beginPath();
	DrawPath();
	ctx.stroke();
}

function DrawPath() {
	ctx.moveTo(a/2, 0);
	ctx.lineTo(a, b);
	ctx.lineTo(0, b);
	ctx.lineTo(a/2, 0);
	var top = a / 2;
	DrawLeft(a, b, top);
	DrawRight(a, b, top);
}

function DrawLeft(a0, b0, top) {
	ctx.moveTo(top - a0 / 2 * (1 - p), b - b0 * p);
	ctx.lineTo(top + a0 * (p - 0.5), b);
	if(a0 / 2 * (1 - p) >= 0.1) {
		DrawLeft(a0 * p, b0 * p, top - a0 / 2 * (1 - p));
	}
	DrawRight(a0, b0, top);
}

function DrawRight(a0, b0, top) {
	ctx.moveTo(top + a0 / 2 * p, b - b0 * (1 - p));
	ctx.lineTo(top + a0 * (p - 0.5), b);
	if(a0 / 2 * p >= 0.1) {
		DrawLeft(a0 * (1 - p), b0 * (1 - p), top + a0 / 2 * p);
	}
}
