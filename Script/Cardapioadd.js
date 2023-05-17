var alertDiv = document.getElementById("alert");
  alertDiv.style.display = "block";
  var audio = new Audio("./Audio/tethys.mp3");
  audio.play();

  if (window.history.pushState) {
    window.history.pushState(null, null, window.location.href);
    window.onpopstate = function(event) {
      window.history.pushState(null, null, window.location.href);
    };
  }