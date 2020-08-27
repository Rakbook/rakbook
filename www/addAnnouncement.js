
$(document).ready(function () {
  var selectedcolor = 'blue';
  $('select[name=colorSelector]').change(function()
  {
      var color =  $('select[name=colorSelector]').val();
      document.getElementById("announcementPreview").classList.remove(selectedcolor);
      document.getElementById("announcementPreview").classList.add(color);
      selectedcolor = color;
    });
});
