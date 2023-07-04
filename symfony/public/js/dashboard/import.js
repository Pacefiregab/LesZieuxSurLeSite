
import {filtre} from "/js/sidebar/filtre.js";
import {dashboard} from "/js/dashboard/dashboard.js";

let filtre2 = new filtre('/personas/api/', (data) => {
    let dashboard2 = new dashboard(data);
});

document.addEventListener('DOMContentLoaded', function() {
    var link = document.getElementById('redirection-link');
    link.addEventListener('click', function(event) {
        event.preventDefault(); // Empêche le comportement de lien par défaut

        console.log(window.location.href)
        // Effectue la redirection en utilisant l'URL spécifiée dans l'attribut "href"
        window.location.href = link.getAttribute('href');
    });
});

