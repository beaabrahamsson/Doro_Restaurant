/*
 * @Author: Beatrice Abrahamsson
 * @Email: beaabrahamsson6@gmail.com
 * @Date: 2022-05-21 17:05:35
 * @Last Modified by: Beatrice Abrahamsson
 * @Last Modified time: 2022-05-28 16:47:10
 * @Description: Description
 */

"use strict";

//Variables
let contacturl = 'https://studenter.miun.se/~beab2100/writeable/dt173g/Projekt/Webbtjanst/contactapi.php';

const contactFname = document.getElementById('contact-fname');
const contactLname = document.getElementById('contact-lname');
const contactPhone = document.getElementById('contact-phone');
const contactEmail = document.getElementById('contact-email');
const contactMessage = document.getElementById('contact-message');
const contactButton = document.getElementById('contactButton');
const contactAlert = document.getElementById('contact-alert');

//If contactButton exists, add event listener
if(contactButton) {
    contactButton.addEventListener("click", sendMessage);
}

//Add new booking 
function sendMessage(e) {
    e.preventDefault();

    let fname = contactFname.value;
    let lname = contactLname.value;
    let phone = contactPhone.value;
    let email = contactEmail.value;
    let message = contactMessage.value;

    let jsonStr = JSON.stringify({
        "fname": fname,
        "lname": lname,
        "phone": phone,
        "email": email,
        "message": message
    });

    if (fname == 0 || lname == 0 || phone == 0 || email == 0 || message == 0) {
        contactAlert.innerHTML = "<p class='message'>Fyll i namn, telefonnummer, e-post och meddelande!</p>";
    } else {
        fetch(contacturl, {
            method: "POST", 
            headers: {
                "content-type": "application/json"
            },
            body: jsonStr
        })
        .then(response => response.json())
        .then(data => clearContactForm())
        .catch(err => console.log(err));
    }
}

//Clear form and set meaage
function clearContactForm() {
    contactFname.value = "";
    contactLname.value = "";
    contactPhone.value = "";
    contactEmail.value = "";
    contactMessage.value = "";

    contactAlert.innerHTML = "<p class='message'>Meddelande skickat!</p>";
}
  