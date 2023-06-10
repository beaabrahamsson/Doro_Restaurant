/*
 * @Author: Beatrice Abrahamsson
 * @Email: beaabrahamsson6@gmail.com
 * @Date: 2022-05-25 14:58:05
 * @Last Modified by: Beatrice Abrahamsson
 * @Last Modified time: 2022-05-25 15:11:12
 * @Description: Description
 */

"use strict";

let starterurl = 'https://studenter.miun.se/~beab2100/writeable/dt173g/Projekt/Webbtjanst/starterapi.php';

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

//Get starters
function getStarters() {
    fetch(starterurl)
    .then(response => {
        if(response.status != 200) {
            return;
        }
        return response.json()
        .then(data => writeStarters(data))
        .catch(err => console.log(err));
    });
}

//Write starters to DOM
function writeStarters(starters) {

    if(document.getElementById("dessert-menu") !== null) {
        const starterEl = document.getElementById("starter-menu");

        starters.forEach(starter => {
            starterEl.innerHTML += `<li class="name">${starter.name}</li>`;
            starterEl.innerHTML += `<li class="price">${starter.price}:-</li>`;
            starterEl.innerHTML += `<li class="desc">${starter.description}</li><br>`;
        });
    }
}