/*
 * @Author: Beatrice Abrahamsson
 * @Email: beaabrahamsson6@gmail.com
 * @Date: 2022-05-25 14:57:53
 * @Last Modified by: Beatrice Abrahamsson
 * @Last Modified time: 2022-05-25 15:10:08
 * @Description: Description
 */

"use strict";

let mainurl = 'https://studenter.miun.se/~beab2100/writeable/dt173g/Projekt/Webbtjanst/mainapi.php';

//Execute init() when page loads
window.onload = init;

//initialize functions
function init() {
    getStarters();
    getMains();
    getpastas();
    getDesserts();
}

//Get main courses
function getMains() {
    fetch(mainurl)
    .then(response => {
        if(response.status != 200) {
            return;
        }
        return response.json()
        .then(data => writeMains(data))
        .catch(err => console.log(err));
    });
}

//Write main courses to DOM
function writeMains(mains) {

    if(document.getElementById("dessert-menu") !== null) {
        const mainEl = document.getElementById("main-menu");

        mains.forEach(mains => {
            mainEl.innerHTML += `<li class="name">${mains.name}</li>`;
            mainEl.innerHTML += `<li class="price">${mains.price}:-</li>`;
            mainEl.innerHTML += `<li class="desc">${mains.description}</li><br>`;
        });
    }
}