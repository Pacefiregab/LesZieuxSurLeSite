(function ($) {

    "use strict";

    // MENU
    $('.navbar-collapse a').on('click', function () {
        $(".navbar-collapse").collapse('hide');
    });

    // CUSTOM LINK
    $('.smoothscroll').click(function () {
        var el = $(this).attr('href');
        var elWrapped = $(el);
        var header_height = $('.navbar').height();

        scrollToDiv(elWrapped, header_height);
        return false;

        function scrollToDiv(element, navheight) {
            var offset = element.offset();
            var offsetTop = offset.top;
            var totalScroll = offsetTop - navheight;

            $('body,html').animate({
                scrollTop: totalScroll
            }, 300);
        }
    });

    $(document).on('keydown', function (event) {
        // TODO change
        if (event.key == 'i' && event.ctrlKey) {
            initEventCapture();
        };

        headerHeight = $('[name=header_hidden]').val ? 85 : 0;
    });
})(window.jQuery);

let startDate = Date.now()/1000; //default data
let endDate;

let isSuccess = false;

let eyeRecord = []
let clickRecord = []
let scrollRecord = []
let mouseRecord = []

let sreenWidth = 1920
let screenHeight = 1080
let headerHeight = 85

let scrollPosition = 0
let windowWidth = document.body.clientWidth;
let windowHeight = document.body.clientHeight;

const flag = $('input[name="flag"]').val();
const duration = $('input[name="duration"]').val();

function initEventCapture() {
    // wait to connect
    const ws = new WebSocket("ws://localhost:8887", ["Tobii.Interaction"])
    ws.onopen = () => {
        ws.send('startGazePoint');
        startDate = Date.now()/1000;
        startMouseRecord();
        setTimeout(() => sendRecord(ws), duration == '' ? 120000 : duration*1000)
    }

    ws.onmessage = (m) => treatMessage(m);

    ws.onclose = () => {
        console.log('close');
        $(document).off();
        eyeRecord = []
        clickRecord = []
        scrollRecord = []
        mouseRecord = []
        isSuccess = false
    }

    console.log(flag)

    $(document).on('click', function (event) {
        clickRecord.push({
            X: event.pageX, Y: event.pageY, time: event.timeStamp,
        })

        const $target = $(event.target);

        if ($target.data('flag') === flag) {
            isSuccess = true;
            sendRecord(ws);
        }
    });

    $(document).on('scroll', function (event) {
        scrollPosition = window.scrollY
        scrollRecord.push({
            Y: scrollPosition, X: 0, time: event.timeStamp,
        })
    });
}

function startMouseRecord(){
    window.addEventListener('mousemove', (event) => {
        mouseRecord.push({
            x: event.clientX, y: event.clientY + scrollPosition, time: Date.now()
        })
    });
}

function treatMessage(message) {
    const msg = JSON.parse(message.data);
    const { eyeX, eyeY } = processEyePosition(msg.data.X, msg.data.Y);

    $('.navbar-brand').html(eyeX + ' : ' + eyeY);

    if (eyeX || eyeY) {
        eyeRecord.push({
            X: eyeX, Y: eyeY, time: msg.data.Timestamp,
        })
    }
}

function sendRecord(ws) {
    ws.close();
    endDate = Date.now()/1000;
    $.ajax({
        url: "https://localhost/trackings/create",
        type: "POST",
        method: "POST",
        data: {
            eyeRecord: JSON.stringify(eyeRecord),
            clickRecord: JSON.stringify(clickRecord),
            scrollRecord: JSON.stringify(scrollRecord),
            mouseRecord: JSON.stringify(mouseRecord),
            windowHeight,
            windowWidth,
            startDate,
            endDate,
            isSuccess,
            session_id: $('input[name="session_id"]').val(),
        }
    })
        .then((data) => {
            ws.close();
            window.location.href = data.redirect;
        })
}

function processEyePosition(eyeX, eyeY) {
    let iX;
    if (eyeX < 0) {
        //si la position de l'oeil est négative en largeur, alors on est en dehors de l'écran
        iX = 0;
    } else if (eyeX > sreenWidth) {
        //si la position de l'oeil est supérieur à la taille de la fenêtre, alors on est en dehors de l'écran
        iX = sreenWidth;
    } else {
        iX = Math.floor(eyeX);
    }


    let iY;
    if (eyeY < 0) {
        //si la position de l'oeil est négative en hauteur, alors on est en dehors de l'écran
        iY = 0;
    } else {
        //sinon, on ajoute la valeur du eye tracker avec la valeur de scroll
        iY = Math.floor(eyeY) + scrollPosition;
    }

    return { eyeX: iX, eyeY: iY }
}
