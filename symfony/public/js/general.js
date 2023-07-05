
function goBack() {
    const url = window.location.href;
    if (url.includes("templates")) {
        window.location.replace("http://localhost/templates/details");
    } else {
        window.location.replace("http://localhost/");
    }
}

function launchSession() {
    window.location.replace("http://localhost/ui");
}
