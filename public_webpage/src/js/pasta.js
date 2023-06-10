/*
 * @Author: Beatrice Abrahamsson
 * @Email: beaabrahamsson6@gmail.com
 * @Date: 2022-05-25 14:57:59
 * @Last Modified by: Beatrice Abrahamsson
 * @Last Modified time: 2022-05-25 15:10:35
 * @Description: Description
 */

"use strict";

let pastaurl = 'https://studenter.miun.se/~beab2100/writeable/dt173g/Projekt/Webbtjanst/pastaapi.php';

//Execute init() when page loads
window.onload = init;

//initialize functions
function init() {
    //Läsa in kurser
    getStarters();
    getMains();
    getpastas();
    getDesserts();
}

//Get pastas
function getpastas() {
    fetch(pastaurl)
    .then(response => {
        if(response.status != 200) {
            return;
        }
        return response.json()
        .then(data => writePastas(data))
        .catch(err => console.log(err));
    });
}

//Write pastas to DOM
function writePastas(pasta) {

    if(document.getElementById("dessert-menu") !== null) {
        const pastaEl = document.getElementById("pasta-menu");

        pasta.forEach(pasta => {
            pastaEl.innerHTML += `<li class="name">${pasta.name}</li>`;
            pastaEl.innerHTML += `<li class="price">${pasta.price}:-</li>`;
            pastaEl.innerHTML += `<li class="desc">${pasta.description}</li><br>`;
        });
    }
}