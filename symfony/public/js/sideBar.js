function getCurrentURL() {
    return window.location.href;
}

//victor c'est de la merde
function setHrefURL(url, baliseHref) {
    if (url.includes("personas") && url.includes("sessions")) {
        baliseHref.href = "https://localhost/ui";
    } else if (url.includes("templates") && url.includes("details")) {
        baliseHref.href = "https://localhost/templates/";
    } else if (url.includes("templates")) {

        baliseHref.href = "https://localhost/templates/";

        let name = document.getElementById("name");
        let stickyHeader = document.getElementById("stickyHeader");
        let reverseRow = document.getElementById("reverseRow");
        let specialButtonForTicket = document.getElementById("specialButtonForTicket");
        let contactMapFirst = document.getElementById("contactMapFirst");
        let changeCheckBoxSelect = document.getElementById("changeCheckBoxSelect");
        let whiteColor = document.getElementById("whiteColor");
        let darkColor = document.getElementById("darkColor");
        let primaryColor = document.getElementById("primaryColor");
        let secondaryColor = document.getElementById("secondaryColor");

        //initialisé le formulaire
        name.value = "";
        stickyHeader.checked = false;
        reverseRow.checked = false;
        specialButtonForTicket.checked = false;
        contactMapFirst.checked = false;
        changeCheckBoxSelect.checked = false;
        whiteColor.checked = false;
        darkColor.checked = false;
        primaryColor.checked = false;
        secondaryColor.checked = false;




    } else {
        baliseHref.href = "https://localhost/personas/index";
        let name = document.getElementById("name");
        let libelle = document.getElementById("libelle");
        let duration = document.getElementById("duration");

        //initialisé le formulaire
        name.value = "";
        libelle.value = "";
        duration.value = "";
        flag.value = "";
    }
}

const url = getCurrentURL();
const baliseHref = document.getElementById("sidebar-add");

setHrefURL(url, baliseHref);
