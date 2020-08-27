

function doAllCollapse() {
  var buttons = document.getElementsByClassName("collapsible");


  for (var i = 0; i < buttons.length; i++) {
    buttons[i].addEventListener("click", function() {
      this.classList.toggle("active");
      var content = this.nextElementSibling;
      if (content.style.maxHeight) {
        content.style.maxHeight = null;
      } else {
        content.style.maxHeight = content.scrollHeight + "px";
      }
    });
  }

  var button = document.getElementsByClassName("collapsible2");
  for (i = 0; i < button.length; i++) {
    button[i].addEventListener("click", function() {
      this.classList.toggle("active");
      var content = this.nextElementSibling;
      if (content.style.display === "block") {
        content.style.display = "none";
      } else {
        content.style.display = "block";
      }
    });
  }
}
