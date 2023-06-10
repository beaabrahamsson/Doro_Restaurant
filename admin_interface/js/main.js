/*
 * @Author: Beatrice Abrahamsson
 * @Email: beaabrahamsson@hotmail.com
 * @Date: 2022-05-23 21:16:47
 * @Last Modified by: Beatrice Abrahamsson
 * @Last Modified time: 2022-05-25 11:53:47
 * @Description: Description
 */

"use strict";

//Function to show/hide the mobile menu */
function mobileMenu() {
    let menu = document.getElementById("links");
    if (menu.style.display === "block") {
      menu.style.display = "none";
    } else {
      menu.style.display = "block";
    }
  }

  function validateNewStarter() {
    let message = document.getElementById("starterMessage");
    let name = document.forms["newStarter"]["name"].value;
    let price = document.forms["newStarter"]["price"].value;
    let desc = document.forms["newStarter"]["desc"].value;
    if (name == "" || price == "" || desc == "") {
        if (name == "") {
            message.innerHTML += "<p class='error'>Fyll i namn på förrätt</p>"
        }
        if (price == "") {
            message.innerHTML += "<p class='error'>Fyll i pris på förrätt</p>"
        }
        if (desc == "") {
            message.innerHTML += "<p class='error'>Fyll i beskrivning av förrätt</p>"
        }
        return false;
    } else {
        return true;
    }
}

function validateNewPasta() {
    let message = document.getElementById("pastaMessage");
    let name = document.forms["newPasta"]["name"].value;
    let price = document.forms["newPasta"]["price"].value;
    let desc = document.forms["newPasta"]["desc"].value;
    if (name == "" || price == "" || desc == "") {
        if (name == "") {
            message.innerHTML += "<p class='error'>Fyll i namn på pastarätt</p>"
        }
        if (price == "") {
            message.innerHTML += "<p class='error'>Fyll i pris på pastarätt</p>"
        }
        if (desc == "") {
            message.innerHTML += "<p class='error'>Fyll i beskrivning av pastarätt</p>"
        }
        return false;
    } else {
        return true;
    }
}

function validateNewMain() {
    let message = document.getElementById("mainMessage");
    let name = document.forms["newMain"]["name"].value;
    let price = document.forms["newMain"]["price"].value;
    let desc = document.forms["newMain"]["desc"].value;
    if (name == "" || price == "" || desc == "") {
        if (name == "") {
            message.innerHTML += "<p class='error'>Fyll i namn på huvudrätt</p>"
        }
        if (price == "") {
            message.innerHTML += "<p class='error'>Fyll i pris på huvudrätt</p>"
        }
        if (desc == "") {
            message.innerHTML += "<p class='error'>Fyll i beskrivning av huvudrätt</p>"
        }
        return false;
    } else {
        return true;
    }
}


  function validateNewDessert() {
    let message = document.getElementById("dessertMessage");
    let name = document.forms["newDessert"]["name"].value;
    let price = document.forms["newDessert"]["price"].value;
    let desc = document.forms["newDessert"]["desc"].value;
    if (name == "" || price == "" || desc == "") {
        if (name == "") {
            message.innerHTML += "<p class='error'>Fyll i namn på efterätt</p>"
        }
        if (price == "") {
            message.innerHTML += "<p class='error'>Fyll i pris på efterätt</p>"
        }
        if (desc == "") {
            message.innerHTML += "<p class='error'>Fyll i beskrivning av efterätt</p>"
        }
        return false;
    } else {
        return true;
    }
}
    
    
  