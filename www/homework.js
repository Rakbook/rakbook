
function findColor(element){
  var classList = $(element).attr('class').split(/\s+/);
  var colors = ["blue", "red", "yellow", "green", "jadeite"];
  for(let i = 0; i < colors.length; i++){
    if($.inArray( colors[i], classList) != -1){
      return colors[i];
    }
  }
}

function setmargin(){

  document.documentElement.style.setProperty('--margin', 0 + "px");
  var margin = $(document).height() - $("#homeworkContainer").height();
  document.documentElement.style.setProperty('--margin', margin/4 + "px");
}

function onLoad(){

  $(".dayPanel").click(function(){
    $(".dayPanel").css("pointer-events", "none");
    var daytitle = $(this).children(".day").html();

    var color = findColor(this);
    $("#dayPopup").removeClass();
    $("#dayPopup").addClass(color);
    day = $(this)[0].id;

    $("#homeworkContent").load('loadHomeworkList.php #homeworkContent', {date: date, day: day});

    $(".dayPopupBackground").children("#homeworkTitle").html(daytitle);
    $("#dayPopup").css("display", "flex");

  });

  $("#close").click(function(){
    $("#dayPopup").css("display", "none");
    $(".dayPanel").css("pointer-events", "auto");
  });

  $("#previous").click(function(){
    date = date - 604800;
    $(".content").load( "loadHomeworkList.php", {date: date, day: day});
    console.log(date);
  });

  $("#next").click(function(){
    date = date + 604800;
    $(".content").load( "loadHomeworkList.php", {date: date, day: day});
    console.log(date);
  });

  $("#info").click(function(){
    alert("info kiedyś będzie");
  });

  setmargin();
  $(window).resize(function() {
    setmargin();
  });
}
