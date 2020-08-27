function ShowTable()
{
  $(function()
  {
    $('.C1').hide();
    $('.C1.' + $('#SelectC1').val()).show();
  });

  $(function()
  {
    $('.C2').hide();
    $('.C2.' + $('#SelectC2').val()).show();
  });


  $(function()
  {
    for(i=1; i<=5; i++)
    {
      $('#' + i).children("div.M").children().removeClass('Better Worse Same')
      $('#' + i).children("div.R").children().removeClass('Better Worse Same')

      var left = $('#' + i).children("div.M").find('h3.' + $('#SelectC1').val()).text();
      var right = $('#' + i).children("div.R").find('h3.' + $('#SelectC2').val()).text();

      if(left == 'TAK' || left == 'NIE')
      {
        if(left =='TAK')
        {
          left = 1;
        }
        else
        {
          left = 0;
        }
      }

      if(right == 'TAK' || right == 'NIE')
      {
        if(right =='TAK')
        {
          right = 1;
        }
        else
        {
          right = 0;
        }
      }

      left = parseFloat(left);
      right = parseFloat(right);

      if( left != right)
      {
        if(left > right)
        {
          if(i != 1)
          {
            $('#' + i).children("div.M").find('h3.' + $('#SelectC1').val()).addClass('Better');
            $('#' + i).children("div.R").find('h3.' + $('#SelectC2').val()).addClass('Worse');
          }
          else
          {
            $('#' + i).children("div.M").find('h3.' + $('#SelectC1').val()).addClass('Worse');
            $('#' + i).children("div.R").find('h3.' + $('#SelectC2').val()).addClass('Better');
          }
        }
        else
        {
          if(i != 1)
          {
            $('#' + i).children("div.R").find('h3.' + $('#SelectC2').val()).addClass('Better');
            $('#' + i).children("div.M").find('h3.' + $('#SelectC1').val()).addClass('Worse');
          }
          else
          {
            $('#' + i).children("div.R").find('h3.' + $('#SelectC2').val()).addClass('Worse');
            $('#' + i).children("div.M").find('h3.' + $('#SelectC1').val()).addClass('Better');
          }
        }
      }
      else
      {
        $('#' + i).children("div.R").find('h3.' + $('#SelectC2').val()).addClass('Same');
        $('#' + i).children("div.M").find('h3.' + $('#SelectC1').val()).addClass('Same');
      }
    }
  });


  if( $("#SelectC1").val() != 'empty' && $("#SelectC2").val() != 'empty')
  {
    document.getElementById('ComparisonTable').style.display = "flex";
    document.getElementById('Wrong').style.display = "none";
  }
  else
  {
    document.getElementById('Wrong').style.display = "block";
    document.getElementById('ComparisonTable').style.display = "none";
  }


}
