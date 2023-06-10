/*
 * @Author: Beatrice Abrahamsson
 * @Email: beaabrahamsson@hotmail.com
 * @Date: 2022-05-27 17:23:12
 * @Last Modified by: Beatrice Abrahamsson
 * @Last Modified time: 2022-05-28 16:47:19
 * @Description: Description
 */

"use strict";

//Variables
let reviewurl = 'https://studenter.miun.se/~beab2100/writeable/dt173g/Projekt/Webbtjanst/reviewapi.php';

const reviewFname = document.getElementById('review-fname');
const reviewLname = document.getElementById('review-lname');
const reviewPhone = document.getElementById('review-phone');
const reviewEmail = document.getElementById('review-email');
const reviewMessage = document.getElementById('review-message');
const reviewButton = document.getElementById('reviewButton');
const reviewAlert = document.getElementById('review-alert');

//If reviewButton exists, add event listener
if(reviewButton) {
    reviewButton.addEventListener("click", sendReview);
}

//Add new review 
function sendReview(e) {
    e.preventDefault();

    let fname = reviewFname.value;
    let lname = reviewLname.value;
    let phone = reviewPhone.value;
    let email = reviewEmail.value;
    let message = reviewMessage.value;

    let jsonStr = JSON.stringify({
        "fname": fname,
        "lname": lname,
        "phone": phone,
        "email": email,
        "message": message
    });

    if (fname == 0 || lname == 0 || phone == 0 || email == 0 || message == 0) {
        reviewAlert.innerHTML = "<p class='message'>Fyll i namn, telefonnummer, e-post och omdöme!</p>";
    } else {
        fetch(reviewurl, {
            method: "POST", 
            headers: {
                "content-type": "application/json"
            },
            body: jsonStr
        })
        .then(response => response.json())
        .then(data => clearReviewForm())
        .catch(err => console.log(err));
    }
}

//Clear form and set meaage
function clearReviewForm() {
    reviewFname.value = "";
    reviewLname.value = "";
    reviewPhone.value = "";
    reviewEmail.value = "";
    reviewMessage.value = "";

    reviewAlert.innerHTML = "<p class='message'>Omdöme skickat!</p>";
}
  