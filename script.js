/**
 * Adds effects to top navigation bar
 * 2019-11-09
 * Dana Schultz
 * 
 * https://www.w3schools.com/howto/howto_js_sticky_header.asp
 */

 document.addEventListener("DOMContentLoaded", load);

 function load(){
    window.onscroll = function()  {addStickyClass()};
 }

 function addStickyClass(){
    var header = document.getElementsByTagName("nav")[0];
    var sticky = header.offsetTop;

    if (window.pageYOffset > sticky) {
        header.classList.add("sticky");
      } else {
        header.classList.remove("sticky");
      }
 }