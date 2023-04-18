$('#testimonial').owlCarousel({
  items: 1,
  autoPlay: true,
  slideSpeed: 300,
  loop: true,
  autoPlayHoverPause: true,
  singleItem: true
});

// when icon close on promo box clicked
// it make promo box hide/close 
$('#promo-box__close').click(function(e) {
  e.preventDefault();
  $('#promo-box').hide();
});

// event for countdown promo box
// date from attribute with name data-date in element promo box 
$('#countdown').countdown($('#countdown').data('date'))
  .on('update.countdown', function(e) {
    $(this).find('#countdown__days')
      .text(e.strftime('%D'))
    $(this).find('#countdown__hours')
      .text(e.strftime('%H'))
    $(this).find('#countdown__minutes')
      .text(e.strftime('%M'))
    $(this).find('#countdown__seconds')
      .text(e.strftime('%S'))
});

// event click for read more button
// when button 'read more' has clicked
// div with description__few-text's class will hide
// then div with description__all-text's class will show
$('.description__few-text a').click(function (e) {
  e.preventDefault();
  $('.description__few-text').hide();
  $('.description__all-text').show();
});

// event submit on form with id = form-subscribe
$('#form-subscribe').submit(function (e) {
  e.preventDefault();
  var form = $(this),
    url = form.attr('action'),
    method = form.attr('method'),
    data = new FormData(form.get(0));

  $.ajax({
    url,
    method,
    data,
    dataType: 'json',
    contentType: false,
    cache: false,
    processData: false,
    success: function (res) {
      $('#email').val('');

      if (!res.status) {
        return Swal.fire(
          'Terjadi Kesalahan!',
          res.message,
          'error'
        );
      }

      return Swal.fire(
        'Berhasil!',
        'Anda telah berhasil mendaftar, silahkan periksa email anda untuk melakukan konfirmasi.',
        'success'
      );
    },
    error: function (xhr) {
      var xhrJSON = xhr.responseJSON;
      if ($.isEmptyObject(xhrJSON) == false) {
        Swal.fire(
          'Terjadi Kesalahan!',
          xhrJSON.errors.email[0],
          'error'
        );
      }
    }
  });
});
