function doAllWojtek() {
  draw();
}

function changeMode(mode)
{
  if(mode == 1)
  {
    document.getElementById("clik").style.display = "none";
    document.getElementById("real").oninput = function(){draw()};
    document.getElementById("real").onchange = "";
    document.getElementById("imag").oninput = function(){draw()};
    document.getElementById("imag").onchange = "";
    document.getElementById("it").oninput = function(){draw()};
    document.getElementById("it").onchange = "";
    document.getElementById("res").oninput = function(){draw()};
    document.getElementById("res").onchange = "";
    document.getElementById("zoom").oninput = function(){draw()};
    document.getElementById("zoom").onchange = "";
    document.getElementById("ox").oninput = function(){draw()};
    document.getElementById("ox").onchange = "";
    document.getElementById("oy").oninput = function(){draw()};
    document.getElementById("oy").onchange = "";
  }
  if(mode == 2)
  {
    document.getElementById("clik").style.display = "none";
    document.getElementById("real").oninput = "";
    document.getElementById("real").onchange = function(){draw()};
    document.getElementById("imag").oninput = "";
    document.getElementById("imag").onchange = function(){draw()};
    document.getElementById("it").oninput = "";
    document.getElementById("it").onchange = function(){draw()};
    document.getElementById("res").oninput = "";
    document.getElementById("res").onchange = function(){draw()};
    document.getElementById("zoom").oninput = "";
    document.getElementById("zoom").onchange = function(){draw()};
    document.getElementById("ox").oninput = "";
    document.getElementById("ox").onchange = function(){draw()};
    document.getElementById("oy").oninput = "";
    document.getElementById("oy").onchange = function(){draw()};

  }
  if(mode == 3)
  {
    document.getElementById("clik").style.display = "block";
    document.getElementById("real").oninput = "";
    document.getElementById("real").onchange = "";
    document.getElementById("imag").oninput = "";
    document.getElementById("imag").onchange = "";
    document.getElementById("it").oninput = "";
    document.getElementById("it").onchange = "";
    document.getElementById("res").oninput = "";
    document.getElementById("res").onchange = "";
    document.getElementById("zoom").oninput = "";
    document.getElementById("zoom").onchange = "";
    document.getElementById("ox").oninput = "";
    document.getElementById("ox").onchange = "";
    document.getElementById("oy").oninput = "";
    document.getElementById("oy").onchange = "";
  }
}


function draw()
{

  var image = document.getElementById("canvas");
  var ctx = image.getContext("2d");
  ctx.fillStyle = "#0BACA0";
  //ctx.fillRect(-resolution, -resolution, resolution, resolution);
  var real = document.getElementById("real").value / 100.0;
  var imag = document.getElementById("imag").value / 100.0;
  var iterations = document.getElementById("it").value;
  var resolution = document.getElementById("res").value;
  document.getElementById('canvas').height = resolution;
  document.getElementById('canvas').width = resolution;
  var complex_range = document.getElementById("zoom").value / 100.0;;
  var offsetX = document.getElementById("ox").value / 10.0;
  var offsetY = document.getElementById("oy").value / 10.0;
  var useColors = true;
  //-0.32 - 0.63i looks nice
  //0.15 + 0.59i
  //-0.76 + (0+/-0.2) i
  //0.31 - 0.71i, with power 5


  for (var i = 0; i < resolution; i++)
  {
    for (var j = 0; j < resolution; j++)
    {
      var preal = ((i * complex_range) /resolution) - complex_range / 2.0 - offsetX/complex_range;
      var pimag = ((j * complex_range) / resolution) - complex_range / 2.0 - offsetY / complex_range;
      var xx = false;
      var k;
      for (k = 0; k < iterations; k++)
      {

        prealtemp = preal;
        preal = preal * preal - pimag * pimag + real;
        pimag = 2 * prealtemp * pimag + imag;

        if (preal * preal + pimag * pimag > 16)
        {
          xx = true;
          break;
        }
      }
      if (xx)
      {
        // if(useColors)
        //{
        if (((256 * k / iterations)) < 50)
        {

          //ctx.filStyle = 'rgb(${49 * (k / 5) / 256}, ${117 * (k / 5) / 256}, ${202 * (k / 5) / 256})';
          ctx.fillStyle = `rgb(${49 * (k / 5)},${117 * (k / 5)},${202 * (k / 5)})`;
          ctx.fillRect(i, j, 1, 1);
        }

        else
        {
          if (((256 * k / iterations)) > 200)
          {
            ctx.fillStyle = `rgb(${255 * (10/k)},${205 * (10/k)},${97 * ( 10/k)})`;
            ctx.fillRect(i, j, 1, 1);
          }

          else
          {
            ctx.fillStyle = `rgb(${( 256 *  30 /  k) -  100},${0},${20 * ( k /  5)})`;
            ctx.fillRect(i, j, 1, 1);
          }

        }
        //    }
        //  else
        //   {
        //var q = "rgb(" + Math.round(256*k/iterations) + "," + Math.round(256*k/iterations) + "," + Math.round(256*k/iterations) + ")";
        //ctx.fillStyle = q;
        // ctx.fillStyle = 'rgb(256,0,0)';
        //  ctx.fillStyle = `rgb(${(256*k)/iterations},${(256*k)/iterations},${(256*k)/iterations})`;
        // console.log(q);
        //ctx.fillStyle = `rgba(${49 * k/5},${20},${k*50},1)`;
        //    ctx.fillRect(i, j, 1, 1);
        // console.log(k);
        //   }



      }
      else
      {
        ctx.fillStyle = 'rgb(0,0,0)';
        ctx.fillRect(i, j, 1, 1);
      }


    }
  }
}
