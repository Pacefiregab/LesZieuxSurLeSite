
function goBack() {
    if (url.includes("templates") && url.includes("sessions")) {
        window.location.replace("http://localhost/templates/details");
    } else {
        window.location.replace("http://localhost/");
    }
}

function launchSession() {
    window.location = 'ui';
}
