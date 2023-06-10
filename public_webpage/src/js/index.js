/*
 * @Author: Beatrice Abrahamsson
 * @Email: beaabrahamsson6@gmail.com
 * @Date: 2022-05-25 14:57:47
 * @Last Modified by: Beatrice Abrahamsson
 * @Last Modified time: 2022-05-25 15:05:11
 * @Description: Description
 */

"use strict";

//Toggle between showing and hiding the navigation menu links when the user clicks on the hamburger menu icon
function mobileMenu() {
    var links = document.getElementById("links");
    if (links.style.display === "block") {
      links.style.display = "none";
    } else {
      links.style.display = "block";
    }
  }