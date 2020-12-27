
function findColor(element){
  var classList = $(element).attr('class').split(/\s+/);
  var colors = ["blue", "red", "yellow", "green", "jadeite"];
  for(let i = 0; i < colors.length; i++){
    if($.inArray( colors[i], classList) != -1){
      return colors[i];
    }
  }
}

function randomColor(){
  var colors = ["blue", "red", "yellow", "green", "jadeite", "orange", "purple"];
  var rand = Math.floor(Math.random() * colors.length);
  return colors[rand];
}

function setmargin(){
  var margin = $(document).height() - $("#homeworkContainer").height();
  document.documentElement.style.setProperty('--margin', margin/4 + "px");
}

function setInputs(){
  $("#tytul").val(title);
  $("#opis").val(desc);
  $("#data").val(date);
  $("#kategoria").val(cat);
}

function trackSelected(change){
  selected += change;
  if(selected > 0){
    $(".subicon").prop('disabled', false);
  }
  else{
    $(".subicon").prop('disabled', true);
  }
}

function toggleDirection() {
  if($("#dayPopup").width() < 550){
    $("#subbar").removeClass();
    $("#subbar").addClass("vertical");

    $("#homeworkTitle").html("Zadania do <br/> zaakceptowania");

  }
  else{
    $("#subbar").removeClass();
    $("#subbar").addClass("horizontal");

    $("#homeworkTitle").html("Zadania do zaakceptowania");
  }
}

function onLoad(){

  var daytitle;
  var color;
  var prev;

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
    prev = "homework";
  });

  $(document).on('click', '.homework', function(){
    if(!$(event.target).closest(".fakeCheckbox").length){
      var hwid = $(this).attr('value');
      //console.log(hwid);
      $(document).on('load', '#dayPopup', function(){ onLoad(); });
      $("#dayPopup").load('loadHomeworkDesc.php', {hwid: hwid});
    }
  });

  $(document).on('click', '#close', function(){
    $("#dayPopup").css("display", "none");
    $(".dayPanel").css("pointer-events", "auto");
    $("#back").css("display", "none");
  });

  $(document).on('click', '#back', function(){

    if(prev == "accept"){
      $("#dayPopup").load('loadHomeworkToAccept.php');
      $("#dayPopup").removeClass();
      $("#dayPopup").addClass(color);
    }
    else{
      $(document).on('load', '#homeworkContent', function(){ onLoad(); });
      $("#navdiv").load('loadHomeworkList.php #navdiv');
      $("#homeworkContent").load('loadHomeworkList.php #homeworkContent', {date: date, day: day});
      $("#homeworkTitle").html(daytitle);
    }
    $("#dayPopup").css("display", "flex");
  });

  $(document).click(function(event){
    if(!$(event.target).closest("#dayPopup, .dayPanel, #accept").length){
      $("#dayPopup").css("display", "none");
      $(".dayPanel").css("pointer-events", "auto");
      $("#back").css("display", "none");
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

  $(document).on('click', '#accept', function(){
    $("#dayPopup").load('loadHomeworkToAccept.php');
    $("#dayPopup").removeClass();
    color = randomColor();
    $("#dayPopup").addClass(color);
    $("#dayPopup").css("display", "flex");
    prev = "accept";
  });

  $(document).on('click', '#info', function(){
    alert('Lista zadań domowych w formie kalendarza. Przy każdym dniu znajduję się numer z ilością zadań na ten dzień, kliknij konkretny dzień by zobaczyć pełną listę. W widoku listy kliknięcie na zadanie domowe otworzy jego opis. Strzałki po prawej pozwalają na poruszanie się pomiędzy tygodniami, a data wskazuje obecnie wybrany tydzień. By dodać zadanie domowe, kliknij przycisk z "+" po lewej.');
  });

  $(document).on('click', '.acceptCheckbox', function(){
    if($(this).prop('checked')){
      $(this).parent().addClass("check");
      trackSelected(1);
    }
    else{
      $(this).parent().removeClass("check");
      trackSelected(-1);
    }
  });

  setmargin();
  $(window).resize(function(){
    setmargin();
    toggleDirection();
  });
}

$(document).ready(function(){
    onLoad();
    $(".addHomework").addClass(randomColor());
});
