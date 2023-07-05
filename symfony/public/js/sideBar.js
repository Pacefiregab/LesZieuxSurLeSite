function getCurrentURL() {
    return window.location.href;
}

function setHrefURL(url, baliseHref) {
    if (url.includes("personas") && url.includes("sessions")) {
        baliseHref.href = "https://localhost/ui";
    } else {
        //TODO faire la distinction entre le redirect vers les détais du persona ou de l'interface. Nécessite l'attente de la nouvelle liste
        baliseHref.href = "https://localhost/personas/index";
    }
}

const url = getCurrentURL();
const baliseHref = document.getElementById("sidebar-add");

setHrefURL(url, baliseHref);
