class MovableCanvas{
	context
	
	scale = 1;
	xShift = 0;
	yShift = 0;
	
	isMoving = false;
	movingX = 0;
	movingY = 0;

	refresh = false;
	refreshLock = false;
	
	drawingFunction;
	drawingProperties;
	
	setCorrectSize()
	{
		let dw = this.context.canvas.clientWidth;
		let dh = this.context.canvas.clientHeight;
		
		if(this.context.canvas.width != dw || this.context.canvas.height != dh)
		{
			this.context.canvas.width = dw;
			this.context.canvas.height = dh;
			this.refresh = true;
		}
	}
	
	frame()
	{
		this.setCorrectSize();
		if(!this.refresh || this.refreshLock) return;
		this.refreshLock = true;
		this.refresh = false;
		this.context.save();
		this.context.resetTransform();
		this.context.clearRect(0, 0, this.context.canvas.width, this.context.canvas.height);
		this.context.translate(this.xShift, -this.yShift);
		this.context.scale(this.scale, this.scale);
		this.drawingFunction(this.drawingproperties, this)
		this.context.restore();
		this.refreshLock = false;
	}
	
	constructor(canvasId)
	{
		let canvas = document.getElementById(canvasId);	
		
		this.context = canvas.getContext("2d");
		
		window.addEventListener('mouseup', e=>{
			this.isMoving = false;
			this.refresh = true;
		});

		canvas.addEventListener('mousemove', e=>{
			if(this.isMoving)
			{
			this.xShift+=e.offsetX-this.movingX;
			this.yShift-=e.offsetY-this.movingY;
			this.refresh = true;
			}
			this.movingX = e.offsetX;
			this.movingY = e.offsetY;
		});

		canvas.addEventListener('mousedown', e=>{
			this.isMoving = true;
			this.movingX = e.offsetX;
			this.movingY = e.offsetY;
		})

		canvas.addEventListener('wheel', e=>
		{
			e.preventDefault();
			let scaleMultiplyer = 1+(e.deltaY >0 ? -1 : 1)*0.05;
			let mposx = this.movingX;
			let mposy = this.movingY;
			this.scale*=scaleMultiplyer;
			this.xShift*=scaleMultiplyer;
			this.yShift*=scaleMultiplyer;
			this.xShift+=mposx*(1-scaleMultiplyer);
			this.yShift-=mposy*(1-scaleMultiplyer);
			this.refresh=true;
		})
		
		setInterval(this.frame.bind(this), 30);
	}
	
	setDrawing(f, p)
	{
		this.drawingFunction = f;
		this.drawingProperties = p;
		this.refresh = true;
	}
	
	static point(x, y)
	{
		return {x:x, y:y};
	}
	
	getMatrix()
	{
		return this.context.getTransform();
	}
	
	static absolutePointMatrix(x, y, matrix)
	{
		let absoluteX = x * matrix.a + y * matrix.c + matrix.e;
		let absoluteY = x * matrix.b + y * matrix.d + matrix.f;
		return MovableCanvas.point(absoluteX, absoluteY);
	}
	
	absolutePoint(x, y)
	{
		let matrix = this.getMatrix();
		return this.constructor.absolutePointMatrix(x, y, matrix);
	}
	
	absolutePointVisible(x, y)
	{
		let cw = this.context.canvas.width;
		let ch = this.context.canvas.height;
		if(x>cw||x<0||y>ch||y<0) return false;
		return true;
	}
	
	relativePointVisibleMatrix(x, y, mtrix)
	{
		let p = this.constructor.absolutePointMatrix(x, y, matrix);
		this.absolutePointVisible(p.x, p.y);
	}
	
	relativePointVisible(x, y)
	{
		let p = this.absolutePoint(x, y);
		return this.absolutePointVisible(p.x, p.y);
	}
}
