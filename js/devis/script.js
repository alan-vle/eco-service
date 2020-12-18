function check(selectedobject) {
    var choix = selectedobject.value;
    var inputchoix = document.getElementById("autrechoix");
    inputchoix.style.visibility = (choix == "autres" ) ? "visible" : "hidden";
   }

function check1_1(selectedobject) {
    var choix1_1 = selectedobject.value;
    var inputchoix1_1 = document.getElementById("autrechoix1_1");
    inputchoix1_1.style.visibility = (choix1_1 == "autres1_1" ) ? "visible" : "hidden";
   }

function check1_2(selectedobject) {
    var choix1_2 = selectedobject.value;
    var inputchoix1_2 = document.getElementById("autrechoix1_2");
    inputchoix1_2.style.visibility = (choix1_2 == "autres1_2" ) ? "visible" : "hidden";
   }

function check2(selectedobject) {
    var choix2 = selectedobject.value;
    var inputchoix2 = document.getElementById("autrechoix2");
    inputchoix2.style.visibility = (choix2 == "autres2" ) ? "visible" : "hidden";
   }