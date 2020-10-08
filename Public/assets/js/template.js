  
/**
 *  @title : template.js
 * 
 */

var navbarC = document.getElementById('navbarC');
var navbarBtn = document.getElementById('navbarBtn');
var closeBtn = document.getElementById('closeBtn');

navbarBtn.addEventListener('click', function() {
    navbarC.classList.add('display');
});

closeBtn.addEventListener('click', function() {
    navbarC.classList.remove('display');
});