/*
 * @Author: Beatrice Abrahamsson
 * @Email: beaabrahamsson6@gmail.com
 * @Date: 2022-05-25 14:57:41
 * @Last Modified by: Beatrice Abrahamsson
 * @Last Modified time: 2022-05-25 15:10:16
 * @Description: Description
 */

"use strict";

let desserturl = 'https://studenter.miun.se/~beab2100/writeable/dt173g/Projekt/Webbtjanst/dessertapi.php';

//Execute init() when page loads
window.onload = init;

//initialize functions
function init() {
    getStarters();
    getMains();
    getpastas();
    getDesserts();
}

//Get desserts
function getDesserts() {
    fetch(desserturl)
    .then(response => {
        if(response.status != 200) {
            return;
        }
        return response.json()
        .then(data => writeDesserts(data))
        .catch(err => console.log(err));
    });
}

//Write desserts to DOM
function writeDesserts(desserts) {

    if(document.getElementById("dessert-menu") !== null) {
        const dessertEl = document.getElementById("dessert-menu");
    
        desserts.forEach(desserts => {
            dessertEl.innerHTML += `<li class="name">${desserts.name}</li>`;
            dessertEl.innerHTML += `<li class="price">${desserts.price}:-</li>`;
            dessertEl.innerHTML += `<li class="desc">${desserts.description}</li><br>`;
        });
    }
}