/**
 * 
 * @title : informationList.js
 * @brief : front pagination of informations
 * 
 */

var informations = Array.from(document.getElementsByClassName('information'));
if (informations.length > 10) {
    for (let i = 10; i < informations.length; ++i) {
        informations[i].classList.add('noDisplay');
    }
}

document.getElementById('nbArticleR').innerText = 'Il reste encore ' + Array.from(document.querySelectorAll('.information.noDisplay')).length + ' information(s) à afficher';

var buttonMoreInfos = document.getElementById('moreButton');
if(document.querySelectorAll('.information.noDisplay').length == 0) {
    buttonMoreInfos.remove();
} else {
    buttonMoreInfos.addEventListener('click', function() {
        var noDInfo = Array.from(document.querySelectorAll('.information.noDisplay'))
        var i = 0;
        while (i < noDInfo.length && i < 10) {
            noDInfo[i].classList.remove('noDisplay');
            ++i;
        }
        document.getElementById('nbArticleR').innerText = 'Il reste encore ' + Array.from(document.querySelectorAll('.information.noDisplay')).length + ' à afficher';
        if(document.querySelectorAll('.information.noDisplay').length == 0) {
            buttonMoreInfos.remove();
        }
        // go to first show article
        window.location.href = '#'+noDInfo[0].id;
        
    });
}
