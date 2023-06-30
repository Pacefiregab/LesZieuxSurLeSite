let data = JSON.parse(document.querySelector("[name=template_data]").value);
console.log(data);
if (data.length > 0) {

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
    // Obtenez une référence à la div contenant la heatmap
    var heatmapContainer = document.body;
    heatmapData = {
        max: 40,
        data: JSON.parse(document.querySelector("[name=heatmap]").value)
    }
    
    // Créez une instance de Heatmap.js
    var heatmapInstance = h337.create({
        container: heatmapContainer,
    });

    // Configurez vos données de heatmap (vous devrez les fournir selon vos besoins)

    // Ajoutez les données de la heatmap à l'instance de Heatmap.js
    heatmapInstance.setData(heatmapData);
}
