document.addEventListener("DOMContentLoaded", function () {
    
    if (document.querySelector("[name=heatmap]").value == false) {
        $("#startModal").modal("show");
        $("#startModal").on("hidden.bs.modal", function (e) {
            setFullScreen();
            document.querySelector("body").classList.remove("modal_open");
            setTimeout(initEventCapture, 1000);
        });
    }
});

let data = JSON.parse(document.querySelector("[name=template_data]").value);

if (Object.keys(data).length > 0) {
    var white_color = data.whiteColor;
    var dark_color = data.darkColor;
    var primary_color = data.primaryColor;
    var secondary_color = data.secondaryColor;

    var root = document.querySelector(":root");
    //Change white color
    root.style.setProperty("--white-color", white_color);
    //Change black color
    root.style.setProperty("--dark-color", dark_color);
    //Change primary color
    root.style.setProperty("--primary-color", primary_color);
    //Change secondary color
    root.style.setProperty("--secondary-color", secondary_color);
}
//Charge heatmap
if (document.querySelector("[name=heatmap]").value != false) {
  setFullScreen();
    // Obtenez une référence à la div contenant la heatmap
    var heatmapContainer = document.body;
    heatmapData = {
        max: 30,
        data: JSON.parse(document.querySelector("[name=heatmap]").value),
    };

    // Créez une instance de Heatmap.js
    var heatmapInstance = h337.create({
        container: heatmapContainer,
    });

    // Configurez vos données de heatmap (vous devrez les fournir selon vos besoins)

    // Ajoutez les données de la heatmap à l'instance de Heatmap.js
    heatmapInstance.setData(heatmapData);
}

function setFullScreen() {
    var element = document.documentElement;
    if (element.requestFullscreen) {
        element.requestFullscreen();
    } else if (element.mozRequestFullScreen) {
        element.mozRequestFullScreen();
    } else if (element.webkitRequestFullscreen) {
        element.webkitRequestFullscreen();
    } else if (element.msRequestFullscreen) {
        element.msRequestFullscreen();
    }
}
