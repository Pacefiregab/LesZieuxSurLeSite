
function goBack() {
    const url = window.location.href;
    if (url.includes("templates")) {
        window.location.replace("http://localhost/templates/details");
    } else {
        window.location.replace("http://localhost/");
    }
}

function launchSession() {
    const entity = document.querySelector("[name=entityForLaunch]")?.value
    const entityType = document.querySelector("[name=entityType]")?.value
    const url = entity ? '/' + entity + '/' + entityType : '';
    window.location.replace("http://localhost/ui" + url);
}
