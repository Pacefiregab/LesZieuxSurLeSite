function getCurrentURL () {
    return window.location.href;
}

function setHrefURL(url, baliseHref) {
    if(url.includes("personas") && url.includes("sessions")) {
        baliseHref.href = "https://localhost/ui";
    }
    else if (url.includes("dashboard")) {
        baliseHref.href = "https://localhost/personas/index";
    }
}

const url = getCurrentURL();
const baliseHref = document.getElementById("sidebar-add");

setHrefURL(url, baliseHref);
