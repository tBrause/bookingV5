function init() {
  const clicked_button = document.querySelector("form");
  clicked_button.addEventListener("click", sendForm);
}

function vv() {
  document
    .querySelector("#submit_booking_input")
    .style.setProperty("visibility", "visible");

  /* 
  document.querySelector("#ranfrage").style.setProperty("display", "block");
  document.querySelector("form").style.setProperty("display", "block");
  document.querySelector("#impdata").style.setProperty("display", "flex");
  document.querySelector("#send").style.setProperty("display", "none");*/
}

function sendForm(e) {
  const clickedButton = e.target;
  const clickedElement = clickedButton.closest("#submit_booking_input");

  if (clickedElement) {
    document.querySelector("#ranfrage").style.setProperty("display", "none");
    document.querySelector("form").style.setProperty("height", "0px");
    document.querySelector("form").style.setProperty("overflow", "hidden");
    document.querySelector("#impdata").style.setProperty("display", "none");
    document.querySelector("#send").style.setProperty("display", "block");
  }
}

if (navigator.cookieEnabled == true) {
  console.log("Cookies erlaubt");
  //document.querySelector("#cookie").style.setProperty("display", "none");
} else if (navigator.cookieEnabled == false) {
  console.log("Cookies verboten");
  document.querySelector("#cookie").style.setProperty("display", "block");
} else {
  console.log("Verrate ich nicht.");
  document.querySelector("#cookie").style.setProperty("display", "block");
}

document.querySelector("#js").style.setProperty("display", "none");

var open_opt_kontakt = function () {
  $(document).on("click", "a[href='#open_opt_kontakt']", function () {
    $("div#option_div").css({ display: "block" });
    $("div#option_link").html(
      '<a href="#close_opt_kontakt" class="icons_booking fa-angle-double-up" style="text-decoration:none;"><span class="option_link_span">Optionale Angaben schlie&szlig;en<span></a>'
    );
  });
};

var close_opt_kontakt = function () {
  $(document).on("click", "a[href='#close_opt_kontakt']", function () {
    $("div#option_div").css({ display: "none" });
    $("div#option_link").html(
      '<a href="#open_opt_kontakt" class="icons_booking fa-angle-double-down" style="text-decoration:none;"><span class="option_link_span">Optionale Angaben<span></a>'
    );
  });
};

var icons_form = function () {
  var win_inner_width = parseInt($(window).innerWidth());

  if (win_inner_width >= 560) {
    $("div#anreise, div#abreise").addClass("icons_booking fa-calendar");
  } else {
    $("div#anreise, div#abreise").removeClass("icons_booking fa-calendar");
  }
};

$(document).ready(function () {
  $(window).trigger("resize");
  open_opt_kontakt();
  close_opt_kontakt();
  icons_form();

  init();
});

$(window).resize(function () {
  icons_form();
});

$(window).scroll(function () {
  $(".google_map iframe").css("pointer-events", "none");
});
$(document).bind("mousewheel DOMMouseScroll", function (event) {
  $(".google_map iframe").css("pointer-events", "none");
});

$(".google_map").scroll(function () {
  $(".google_map iframe").css("pointer-events", "none");
});
$(".google_map").click(function () {
  $(".google_map iframe").css("pointer-events", "auto");
});
