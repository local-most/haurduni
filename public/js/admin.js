/**
 * fungsi untuk memunculkan modal
 */
$('body').on('click', '.modal-show', function(e) {
  e.preventDefault();

  var that = $(this),
    url = that.attr('href'),
    title = that.attr('title'),
    buttonText = that.html();

  isLoading(that, true);

  $('#modal-title').text(title);
  $('#modal-footer').show();
  $('#modal-btn-save').text(that.hasClass('edit') ? 'Perbaharui' : 'Tambah');

  $.ajax({
    url: url,
    dataType: 'html',
    success: function(res) {
      $('#modal-body').html(res);
      
      if ($('#modal-body form textarea').hasClass('ckeditor')) {
        ckEditor();
      }

      $('#modal').modal('toggle');
      isLoading(that, false, buttonText);
    }
  });
});

/**
 * fungsi untuk menyimpan data baru
 */
$('#modal-btn-save').click(function(e) {
  e.preventDefault();

  if (window.editor !== undefined) {
    window.editor.updateSourceElement();
  }

  var form = $('#modal-body form'),
    url = form.attr('action'),
    method = 'POST',
    that = $(this),
    buttonText = that.html();

  form.find('.form-control').removeClass('is-invalid');
  form.find('.invalid-feedback').remove();
  isLoading(that, true);

  $.ajax({
    url: url,
    method: method,
    data: new FormData(form.get(0)),
    dataType: 'json',
    contentType: false,
    cache: false,
    processData: false,
    success: function() {
      form.trigger('reset');
      isLoading(that, false, buttonText);
      $('#modal').modal('toggle');
      $('#table').DataTable().ajax.reload();

      Swal.fire(
        'Berhasil!',
        'Data telah berhasil disimpan.',
        'success'
      );
    },
    error: function(xhr) {
      var xhrJSON = xhr.responseJSON;
      if ($.isEmptyObject(xhrJSON) == false) {
        $.each(xhrJSON.errors, function(key, value) {
          $('#'+ key)
            .addClass('is-invalid')
            .closest('.form-group')
            .append('<div class="invalid-feedback">'+ value[0] +'</div>');
        });
      }

      isLoading(that, false, buttonText);
      Swal.fire(
        'Gagal Tersimpan!',
        'Pastikan data diisi dengan benar!',
        'error'
      );
    }
  });
});

$('body').on('click', '.btn-destroy', function(e) {
  e.preventDefault();

  var that = $(this),
    url = that.attr('href')
    title = that.attr('title'),
    csrfToken = $('meta[name="csrf-token"]').attr('content');

  Swal.fire({
    title: 'Hapus Data?',
    text: 'Data ' + title + ' akan terhapus!',
    icon: 'warning',
    showLoaderOnConfirm: true,
    showCancelButton: true,
    confirmButtonColor: '#3085d6',
    confirmButtonText: 'Ya, Hapus!',
    cancelButtonColor: '#d33',
    cancelButtonText: 'Batal',
    preConfirm: () => {
      return fetch(url, {
        headers: {
          "X-CSRF-Token": csrfToken
        },
        method: 'delete'
        })
        .then(res => res.json())
        .catch(err => Swal.showValidationMessage(
          `Request failed: ${err}`
        ));
    },
    allowOutsideClick: () => !Swal.isLoading()
  }).then(function(result) {
    if (result.value) {
      $('#table').DataTable().ajax.reload();
      Swal.fire({
        title: 'Terhapus!',
        text: 'Data ' + title + ' berhasil dihapus',
        icon: 'success'
      });
    }
  });
});

/**
 * Untuk merubah text pada button save
 */
var isLoading = function (that, status, text = null) {
  if (status) {
    that.html(`<div class="spinner-border spinner-border-sm text-light" role="status"></div>`);
    that.addClass('disabled');
  } else {
    that.html(text);
    that.removeClass('disabled');
  }
}

/**
 * untuk inisiasi ckeditor
 */
var ckEditor = function () {
  ClassicEditor
    .create(document.querySelector('textarea.ckeditor'), {
      toolbar: {
        items: [
          'bold', 
          'italic', 
          'heading', 
          '|', 
          'bulletedList', 
          'numberedList', 
          '|', 
          'indent', 
          'outdent', 
          '|', 
          'blockQuote', 
          'undo', 
          'redo'
        ]
      },
      language: 'id',
      table: {
        contentToolbar: [
          'tableColumn', 
          'tableRow', 
          'mergeTableCells'
        ]
      }
    })
    .then(function(editor) {
      window.editor = editor;
    })
    .catch(function(error) {
      console.error(error);
  });
}
