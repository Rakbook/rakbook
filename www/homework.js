
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

  var daytitle;

  $(document).off("click");

  $(document).on('click', '.dayPanel', function(){
    $(".dayPanel").css("pointer-events", "none");
    daytitle = $(this).children(".day").html();

    var color = findColor(this);
    $("#dayPopup").removeClass();
    $("#dayPopup").addClass(color);
    day = $(this)[0].id;

    $("#homeworkContent").empty();
    $("#homeworkTitle").empty();

    $(document).on('load', '#homeworkContent', function(){ onLoad(); });
    $("#homeworkContent").load('loadHomeworkList.php #homeworkContent', {date: date, day: day});
    $("#homeworkTitle").html(daytitle);
    $("#dayPopup").css("display", "flex");

  });

  $(document).on('click', '.homework', function(){
    var hwname = $(this).html();
    hwname = hwname.split(/- (.+)/)[1];
    $(document).on('load', '#dayPopup', function(){ onLoad(); });
    $("#dayPopup").load('loadHomeworkDesc.php', {date: date, day: day, hwname: hwname});
  });

  $(document).on('click', '#close', function(){
    $("#dayPopup").css("display", "none");
    $(".dayPanel").css("pointer-events", "auto");
  });

  $(document).on('click', '#back', function(){
    $(document).on('load', '#homeworkContent', function(){ onLoad(); });
    $("#navdiv").load('loadHomeworkList.php #navdiv');
    $("#homeworkContent").load('loadHomeworkList.php #homeworkContent', {date: date, day: day});
    $("#homeworkTitle").html(daytitle);
    $("#dayPopup").css("display", "flex");
  });

  $(document).click(function(event){
    if(!$(event.target).closest("#dayPopup, .dayPanel").length){
      $("#dayPopup").css("display", "none");
      $(".dayPanel").css("pointer-events", "auto");
    }
  });

  $(document).on('click', '#previous', function(){
    date = date - 604800;
    $(document).on('load', '.content', function(){ onLoad(); });
    $(".content").load( "loadHomeworkList.php", {date: date, day: day});
    console.log(date);
  });

  $(document).on('click', '#next', function(){
    date = date + 604800;
    $(document).on('load', '.content', function(){ onLoad(); });
    $(".content").load( "loadHomeworkList.php", {date: date, day: day});
    console.log(date);
  });

  $(document).on('click', '#info', function(){
    alert("info kiedyś będzie");
  });

  setmargin();
  $(window).resize(function() {
    setmargin();
  });
}

$( document ).ready(function() {
    onLoad();
});
