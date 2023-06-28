let data = JSON.parse(document.querySelector('[name=template_data]').value);

console.log(data);

    var white_color = data.dataset.whiteColor;
    var dark_color = data.dataset.darkColor;
    var primary_color = data.dataset.primaryColor;
    var secondary_color = data.dataset.secondaryColor;




    var root = document.querySelector(':root');
//Change white color    
    root.style.setProperty('--white-color', white_color);
//Change black color
    root.style.setProperty('--dark-color', dark_color);
//Change primary color
    root.style.setProperty('--primary-color', primary_color);
//Change secondary color
    root.style.setProperty('--secondary-color', secondary_color);



