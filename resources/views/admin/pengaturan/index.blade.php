@extends('layouts.admin')
@section('title', 'Tentang Kami')

@section('content')
<div class="row">
  <div class="col-12">
    <form method="post" id="form-store" enctype="multipart/form-data">
      @method('put')
      <div class="card card-outline card-blue">
        <div class="card-header">
          <h3 class="card-title" id="card-title">Tentang Kami</h3>
        </div>
        <div class="card-body">
          <div class="form-group">
            <label for="description">Foto</label><br>
            @if($aboutus->images)
            <img src="{{ asset($aboutus->images) }}" width="200px" id="preview-foto">
            @else
            <img src="{{ asset('default-ktp.png') }}" id="preview-foto" width="200px;">
            @endif
            <br>
            <br>
            <input type="file" name="image" class="form-control" onchange="loadImage(event, 'preview-foto')">
          </div>
          <div class="form-group">
            <label for="description">Deskripsi Tentang Kami</label>
            <textarea rows="8" name="description" id="description" class="form-control">{{ $aboutus->description }}</textarea>
            <small class="text-danger" id="error-description"></small>
          </div>
          <div class="form-group">
            <div class="input-group">
              <div class="input-group-prepend">
                <span class="input-group-text"><i class="fab fa-facebook-square"></i></span>
              </div>
              <input type="text" class="form-control" id="facebook" name="link_facebook" value="{{ $social->facebook->link }}" placeholder="Link Facebook">
            </div>
            <small class="text-danger" id="error-facebook"></small>
          </div>
          <div class="form-group">
            <div class="input-group">
              <div class="input-group-prepend">
                <span class="input-group-text"><i class="fab fa-twitter-square"></i></span>
              </div>
              <input type="text" class="form-control" id="twitter" name="link_twitter" value="{{ $social->twitter->link }}" placeholder="Link Facebook">
            </div>
            <small class="text-danger" id="error-twitter"></small>
          </div>
          <div class="form-group">
            <div class="input-group">
              <div class="input-group-prepend">
                <span class="input-group-text"><i class="fab fa-instagram-square"></i></span>
              </div>
              <input type="text" class="form-control" id="instagram" name="link_instagram" value="{{ $social->instagram->link }}" placeholder="Link Facebook">
            </div>
            <small class="text-danger" id="error-instagram"></small>
          </div>
          <div class="form-group">
            <div class="input-group">
              <div class="input-group-prepend">
                <span class="input-group-text"><i class="fab fa-youtube"></i></span>
              </div>
              <input type="text" class="form-control" id="youtube" name="link_youtube" value="{{ $social->youtube->link }}" placeholder="Link Facebook">
            </div>
            <small class="text-danger" id="error-youtube"></small>
          </div> 
        </div> 
        <div class="card-footer">
          <div class="text-right pt-3">
            <button type="submit" class="btn btn-primary" id="btn-store">Perbaharui</button>&nbsp;
            <a href="{{ url()->current() }}" class="btn btn-danger">Reset</a>
          </div>
        </div>
      </div>
    </form>
  </div>
</div>
@endsection

@push('js')
<script>
  ClassicEditor.create(document.querySelector('textarea#description'), {
    toolbar: {
      items: ['bold', 'italic', 'heading', '|', 'bulletedList', 'numberedList', '|', 'indent', 'outdent', '|', 'blockQuote', 'insertTable', 'undo', 'redo']
    },
    language: 'id',
    table: {
      contentToolbar: ['tableColumn', 'tableRow', 'mergeTableCells']
    }
  })
  .then(function(editor) {
    window.editor = editor;
  })
  .catch(function(error) {
    console.error(error);
  });

  $('#form-store').on('submit', function(e) {
    e.preventDefault();

    Swal.fire({
      title: 'Perbaharui Data?',
      text: 'Data akan disimpan.',
      icon: 'warning',
      showCancelButton: true,
      confirmButtonColor: '#3085d6',
      confirmButtonText: 'Ya, Perbaharui!',
      cancelButtonColor: '#d33',
      cancelButtonText: 'Batal'
    }).then(function(result) {
      if (result.value) {
        changeButton(true);
        clearError();

        $.ajaxSetup({
          headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          }
        });

        $.ajax({
          url: `{{ route('admin.tentang.update') }}`,
          method: 'post',
          data: new FormData($('#form-store').get(0)),
          dataType: 'json',
          contentType: false,
          cache: false,
          processData: false,
          success: function(res) {
            if(res.status) {
              Swal.fire({
                title: 'Berhasil!',
                text: 'Data telah disimpan!',
                icon: 'success'
              });
            }
            changeButton(false);
          },
          error: function(err) {
            Swal.fire(
              'Data Gagal Disimpan!',
              'Pastikan semua input diisi!',
              'error'
              );
            changeButton(false);
            let { 
              description
            } = err.responseJSON.errors;
            $('#error-description').html(phone);
          }
        });
      }
    });
  });

  function changeButton(status){
    if (status) {
      $('#btn-store').html(`<div class="spinner-border spinner-border-sm text-light" role="status"></div>`);
      $('#btn-store').prop('disabled', true);
    } else {
      $('#btn-store').html('Perbaharui');
      $('#btn-store').prop('disabled', false);
    }
  }
  function clearError(isModal = false) {
    $('#error-content').html('');
  }
  var loadImage = function(e, isCreate = false) {
    var output = document.getElementById(isCreate ? 'preview-foto' : 'preview-image-edit');
    output.src = URL.createObjectURL(event.target.files[0]);
    output.onload = function() {
      URL.revokeObjectURL(output.src);
    }
  };
</script>
@endpush

