var framefenster = document.getElementsByClassName("ergebnis");
var auto_resize_timer = window.setInterval("autoresize_frames()", 50);
function autoresize_frames() {
  for (var i = 0; i < framefenster.length; ++i) {
    if (framefenster[i].contentWindow.document.body) {
      var framefenster_size =
        framefenster[i].contentWindow.document.body.offsetHeight;
      if (document.all && !window.opera) {
        framefenster_size =
          framefenster[i].contentWindow.document.body.scrollHeight;
      }
      framefenster[i].style.height = framefenster_size + 20 + "px";
    }
  }
}
