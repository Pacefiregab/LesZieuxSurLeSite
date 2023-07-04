document.addEventListener("DOMContentLoaded", function () {

    if (document.querySelector("[name=heatmapEye]").value == false) {
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
const heatMapTypeSelector = document.querySelector("[name=heatMapType]:checked")
const dataSelector = heatMapTypeSelector ? heatMapTypeSelector.value : "heatmapEye";
const mapData = document.querySelector(`[name=${dataSelector}]`).value;
if (mapData != false) {
    // setFullScreen();
    let heatmapContainer = document.body;
    heatmapData = {
        max: 30, data: JSON.parse(mapData),
    };

    heatmapInstance = h337.create({
        container: heatmapContainer,
    });
    heatmapInstance.setData(heatmapData);

    document.querySelectorAll("[name=heatMapType]").forEach((element) => {
        element.addEventListener("change", function (e) {
            let dataSelector = e.target.value;
            let mapData = document.querySelector(`[name=${dataSelector}]`).value;
            console.log(mapData);
            heatmapInstance.setData({
                max: 30, data: JSON.parse(mapData),
            });
        });
    });
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
