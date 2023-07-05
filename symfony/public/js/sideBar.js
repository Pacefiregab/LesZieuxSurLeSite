function getCurrentURL() {
    return window.location.href;
}

function setHrefURL(url, baliseHref) {
    if (url.includes("personas") && url.includes("sessions")) {
        baliseHref.href = "https://localhost/ui";
    }else if (url.includes("templates") && url.includes("details")) {
        baliseHref.href = "https://localhost/templates/";
    } else {
        baliseHref.href = "https://localhost/personas/index";
    }
}

const url = getCurrentURL();
const baliseHref = document.getElementById("sidebar-add");

setHrefURL(url, baliseHref);
