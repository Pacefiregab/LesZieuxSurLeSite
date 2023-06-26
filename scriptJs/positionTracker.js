// ==UserScript==
// @name position Tracker
// @namespace Script Runner Pro
// @match *://*/*
// @grant none
// ==/UserScript==

document.addEventListener('keydown', function (event) {
    if (event.key == 'i' && event.ctrlKey) {
        // on scroll down or up event
        window.addEventListener('scroll', function (event) {
            console.log('scroll', window.scrollY);
            console.log('timeStamp', event.timeStamp);

            //TODO call api

        })
    }
});
