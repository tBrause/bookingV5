function init() {
  //const eventButton = document.querySelector(".myInput");
  //eventButton.addEventListener("click", myFunction);
}

function myFunction() {
  /* Get the text field */
  var copyText = document.querySelector(".myInput");

  /* Select the text field */
  copyText.select();
  copyText.setSelectionRange(0, 99999); /* For mobile devices */

  /* Copy the text inside the text field */
  navigator.clipboard.writeText(copyText.value);

  /* Alert the copied text */
  //alert("Copied the text: " + copyText.value);
  console.log("Copied the text");
}

init();

/*
let copybutton = document.querySelector("button[data-copy]");

copybutton.addEventListener("click", function (e) {
  let target = e.target;
  let copyText = document.getElementById("myInput");

  let copytarget = target.dataset.copy;
  let inp = copytarget ? document.querySelector(copytarget) : null;
  if (inp && inp.select) {
    inp.select();
    try {
      //document.execCommand("copy");
      inp.blur();
    } catch (err) {
      document.querySelector(".msg").innerHTML = "Kopieren mit Ctrl/Cmd + C";
      console.log("Copied the text");
    }
  }
});
*/

/**  wenn dann diese fct
let copybutton = document.querySelector("button[data-copy]");
console.log(copybutton);

copybutton.addEventListener("click", function (e) {
  let target = e.target;
  let copytarget = target.dataset.copy;
  console.log(copytarget);

  let imp = copytarget ? document.querySelector(copytarget) : null;
  imp.select();
  console.log(imp.value);

  
});
*/

// Copy the text inside the text field => war in der fct
//navigator.clipboard.writeText(imp.value);
