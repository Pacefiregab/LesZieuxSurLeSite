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
    if (event.key == 'i' && event.ctrlKey) {
      // on scroll down or up event
      $(document).on('scroll', function (event) {
        sendTrackingData(event)
      })
    }

    $(document).on('click', function (event) {
      sendTrackingData(event)
    });
  });
})(window.jQuery);

function sendTrackingData(event) {
  $.ajax({
    url: '127.0.0.1/tracking',
    type: 'POST',
  }).json({
    'flag': $(this).data('flag') || null,
    'type': 'click',
    'date': new Date(),
    'x': event.pageX,
    'y': event.pageY,
  }).then(function (response) {
    console.log(response);
  });
}



