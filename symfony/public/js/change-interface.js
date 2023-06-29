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

  // Créez une instance de Heatmap.js
  var heatmapInstance = h337.create({
    container: heatmapContainer,
  });

  // Configurez vos données de heatmap (vous devrez les fournir selon vos besoins)
  var heatmapData = {
    max: 20, // Valeur maximale pour l'échelle de couleur
    data: [
      { x: 513, y: 512, value: 1  },
      { x: 512, y: 511, value: 1  },
      { x: 511, y: 510, value: 1  },
      { x: 510, y: 507, value: 1  },
      { x: 510, y: 506, value: 1  },
      { x: 510, y: 505, value: 1  },
      { x: 509, y: 499, value: 1  },
      { x: 508, y: 498, value: 1  },
      { x: 509, y: 494, value: 1  },
      { x: 509, y: 492, value: 1  },
      { x: 509, y: 491, value: 1  },
      { x: 509, y: 492, value: 1  },
      { x: 491, y: 483, value: 1  },
      { x: 490, y: 483, value: 1  },
      { x: 489, y: 482, value: 1  },
      { x: 485, y: 475, value: 1 },
      { x: 484, y: 474, value: 1  },
      { x: 483, y: 473, value: 1  },
      { x: 482, y: 474, value: 1  },
      { x: 482, y: 476, value: 1  },
      { x: 482, y: 480, value: 1  },
      { x: 482, y: 481, value: 1  },
      { x: 483, y: 482, value: 1  },
      { x: 484, y: 483, value: 1  },
      { x: 485, y: 483, value: 1  },
      { x: 486, y: 484, value: 1  },
      { x: 486, y: 484, value: 1  },
      { x: 486, y: 485, value: 1  },
      { x: 487, y: 485, value: 1  },
      { x: 488, y: 485, value: 1  },
      { x: 488, y: 486, value: 1  },
      { x: 488, y: 486, value: 1 },
      { x: 488, y: 487, value: 1  },
      { x: 487, y: 484, value: 1  },
      { x: 486, y: 483, value: 1  },
      { x: 485, y: 480, value: 1 },
      { x: 484, y: 477, value: 1  },
      { x: 484, y: 475, value: 1  },
      { x: 485, y: 477, value: 1  },
      { x: 487, y: 480, value: 1  },
      { x: 488, y: 482, value: 1  },
      { x: 488, y: 482, value: 1  },
      { x: 487, y: 482, value: 1  },
      { x: 487, y: 483, value: 1 },
      { x: 490, y: 485, value: 1  },
      { x: 491, y: 483, value: 1  },
      { x: 491, y: 483, value: 1  },
      { x: 490, y: 484, value: 1 },
      { x: 490, y: 483, value: 1  },
      { x: 490, y: 483, value: 1  },
      { x: 490, y: 483, value: 1  },
      { x: 495, y: 482, value: 1  },
      { x: 495, y: 482, value: 1  },
      { x: 494, y: 482, value: 1  },
      { x: 492, y: 481, value: 1  },
      { x: 492, y: 481, value: 1  },
      { x: 491, y: 481, value: 1  },
      { x: 492, y: 482, value: 1  },
      { x: 492, y: 481, value: 1 },
      { x: 492, y: 481, value: 1  },
      { x: 492, y: 480, value: 1 },
      { x: 492, y: 480, value: 1  },
      { x: 492, y: 479, value: 1 },
      { x: 492, y: 479, value: 1  },
      { x: 492, y: 479, value: 1  },
      { x: 492, y: 478, value: 1  },
      { x: 492, y: 478, value: 1  },
      { x: 492, y: 477, value: 1  },
      { x: 493, y: 476, value: 1  },
      { x: 492, y: 477, value: 1 },
      { x: 492, y: 476, value: 1  },
      { x: 494, y: 476, value: 1  },
      { x: 495, y: 478, value: 1  },
      { x: 496, y: 478, value: 1  },
      { x: 495, y: 478, value: 1  },
      { x: 496, y: 478, value: 1  },
      { x: 496, y: 478, value: 1  },
      { x: 496, y: 478, value: 1  },
      { x: 495, y: 478, value: 1  },
      { x: 495, y: 477, value: 1  },
      { x: 496, y: 476, value: 1  },
      { x: 496, y: 476, value: 1  },
      { x: 495, y: 475, value: 1  },
      { x: 494, y: 475, value: 1  },
      { x: 494, y: 475, value: 1  },
      { x: 492, y: 474, value: 1  },
      { x: 490, y: 474, value: 1  },
      { x: 489, y: 474, value: 1  },
      { x: 489, y: 476, value: 1  },
      { x: 490, y: 477, value: 1  },
      { x: 492, y: 476, value: 1  },
      { x: 492, y: 476, value: 1  },
      { x: 491, y: 475, value: 1  },
      { x: 490, y: 475, value: 1  },
      { x: 488, y: 467, value: 1  },
      { x: 488, y: 468, value: 1 },
      { x: 488, y: 465, value: 1  },
      { x: 490, y: 465, value: 1  },
      { x: 490, y: 462, value: 1  },
      { x: 492, y: 471, value: 1 },
      { x: 492, y: 471, value: 1  },
      { x: 491, y: 464, value: 1  },
      { x: 491, y: 459, value: 1  },
      { x: 488, y: 456, value: 1  },
      { x: 485, y: 456, value: 1  },
      { x: 477, y: 455, value: 1  },
      { x: 467, y: 448, value: 1  },
      { x: 465, y: 447, value: 1  },
      { x: 462, y: 445, value: 1  },
      { x: 462, y: 445, value: 1  },
      { x: 460, y: 444, value: 1  },
      { x: 458, y: 440, value: 1  },
      { x: 458, y: 439, value: 1  },
      { x: 458, y: 449, value: 1  },
      { x: 438, y: 442, value: 1  },
      { x: 395, y: 441, value: 1  },
      { x: 395, y: 450, value: 1  },
      { x: 420, y: 461, value: 1  },
      { x: 540, y: 487, value: 1  },
      { x: 468, y: 456, value: 1  },
      { x: 465, y: 457, value: 1  },
      { x: 460, y: 458, value: 1  },
      { x: 459, y: 462, value: 1  },
      { x: 458, y: 463, value: 1  },
      { x: 455, y: 465, value: 1 },
      { x: 455, y: 469, value: 1  },
      { x: 456, y: 470, value: 1  },
      { x: 460, y: 473, value: 1  },
    ],
  };

  // Ajoutez les données de la heatmap à l'instance de Heatmap.js
  heatmapInstance.setData(heatmapData);
}
