function getCurrentURL () {
    return window.location.href;
}

function setHrefURL(url, baliseHref) {
    if(url.includes("personas") && url.includes("sessions")) {
        baliseHref.href = "https://localhost/ui";
    }
}

const url = getCurrentURL();
const baliseHref = document.getElementById("sidebar-add");

setHrefURL(url, baliseHref);
