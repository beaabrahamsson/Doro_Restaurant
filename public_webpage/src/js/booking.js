/*
 * @Author: Beatrice Abrahamsson
 * @Email: beaabrahamsson6@gmail.com
 * @Date: 2022-05-25 14:57:33
 * @Last Modified by: Beatrice Abrahamsson
 * @Last Modified time: 2022-05-28 16:44:02
 * @Description: Description
 */

"use strict";

//Variables
let bookingurl = 'https://studenter.miun.se/~beab2100/writeable/dt173g/Projekt/Webbtjanst/bookingapi.php';

const bookingFname = document.getElementById('booking-fname');
const bookingLname = document.getElementById('booking-lname');
const bookingPhone = document.getElementById('booking-phone');
const bookingEmail = document.getElementById('booking-email');
const bookingDate = document.getElementById('booking-date');
const bookingTime = document.getElementById('booking-time');
const bookingGuests = document.getElementById('booking-guests');
const bookingNote = document.getElementById('booking-note');
const bookingButton = document.getElementById('booking-button');
const bookingMessage = document.getElementById('booking-message');

//If bookingButton exists, add event listener
if(bookingButton) {
    bookingButton.addEventListener("click", bookTable);
}

//Add new booking 
function bookTable(event) {
    event.preventDefault();

    let fname = bookingFname.value;
    let lname = bookingLname.value;
    let phone = bookingPhone.value;
    let email = bookingEmail.value;
    let date = bookingDate.value;
    let time = bookingTime.value;
    let guests = bookingGuests.value;
    let note = bookingNote.value;

    let jsonStr = JSON.stringify({
        "fname": fname,
        "lname": lname,
        "phone": phone,
        "email": email,
        "date": date,
        "time": time, 
        "guests": guests,
        "note": note
    });

    if (fname == 0 || lname == 0 || phone == 0 || email == 0 || date == 0 || time == 0 || guests == 0) {
        bookingMessage.innerHTML = "<p class='message'>Fyll i namn, telefonnummer, e-post, datum, tid och antal gäster!</p>";
    } else {
        fetch(bookingurl, {
            method: "POST", 
            headers: {
                "content-type": "application/json"
            },
            body: jsonStr
        })
        .then(response => response.json())
        .then(data => clearBookingForm(), sendEmail())
        .catch(err => console.log(err))
    }

}

//Clear form and send message
function clearBookingForm() {
    bookingFname.value = "";
    bookingLname.value = "";
    bookingPhone.value = "";
    bookingEmail.value = "";
    bookingDate.value = "";
    bookingTime.value = "";
    bookingGuests.value = "";
    bookingNote.value = "";

    bookingMessage.innerHTML = "<p class='message'>Bokning skickad!</p>";
}
//Send confirmation email
function sendEmail() {

    let fname = bookingFname.value;
    let email = bookingEmail.value;
    let date = bookingDate.value;
    let time = bookingTime.value;

    Email.send({
        Host : "smtp.elasticemail.com",
        Username : "beab2100@student.miun.se",
        Password : "78973454F239D1DDD889E1798A17A54DFE84",
        To : email,
        From : "beab2100@student.miun.se",
        Subject : "Bokningsbekräftelse - D'Oro",
        Body : "<html><h2>Hej, " + fname + "</h2><p>Här kommer en bekräftelse på din bokning den " + date + " klockan " + time + ".</p><br><p>Med vänliga hälsningar, D'Oro!</p></html>"
    });
}
  