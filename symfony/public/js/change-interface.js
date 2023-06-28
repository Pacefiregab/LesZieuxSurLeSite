
    var data = document.querySelector('#template_data');

    var rowReverse = data.dataset.reverseRow;
    var white_color = data.dataset.whiteColor;

var r = document.querySelector(':root');

//Change row order
    console.log('reverse row: ' + rowReverse);
    if (rowReverse == 'true') {
        document.querySelector('.rowReversable :nth-child(1)').classList.add('order-2');
        document.querySelector('.rowReversable :nth-child(2)').classList.add('order-1');
    }

//Change white color
    console.log('white color: ' + white_color);
    var root = document.querySelector(':root');
    root.style.setProperty('--white-color', white_color);


