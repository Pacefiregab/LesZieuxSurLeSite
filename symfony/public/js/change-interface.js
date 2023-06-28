let data = JSON.parse(document.querySelector('[name=template_data]').value);

console.log(data);

    var rowReverse = data.dataset.reverseRow;
    var white_color = data.dataset.whiteColor;
    var dark_color = data.dataset.darkColor;
    var primary_color = data.dataset.primaryColor;
    var secondary_color = data.dataset.secondaryColor;




//Change row order
    if (rowReverse == 'true') {
        document.querySelector('.rowReversable :nth-child(1)').classList.add('order-2');
        document.querySelector('.rowReversable :nth-child(2)').classList.add('order-1');
    }


    var root = document.querySelector(':root');
//Change white color    
    root.style.setProperty('--white-color', white_color);
//Change black color
    root.style.setProperty('--dark-color', dark_color);
//Change primary color
    root.style.setProperty('--primary-color', primary_color);
//Change secondary color
    root.style.setProperty('--secondary-color', secondary_color);



