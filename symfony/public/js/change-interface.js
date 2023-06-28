let data = JSON.parse(document.querySelector('[name=template_data]').value);


    var white_color = data.whiteColor;
    var dark_color = data.darkColor;
    var primary_color = data.primaryColor;
    var secondary_color = data.secondaryColor;

    var root = document.querySelector(':root');
//Change white color    
    root.style.setProperty('--white-color', white_color);
//Change black color
    root.style.setProperty('--dark-color', dark_color);
//Change primary color
    root.style.setProperty('--primary-color', primary_color);
//Change secondary color
    root.style.setProperty('--secondary-color', secondary_color);



