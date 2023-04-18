@extends('layouts.admin')
@section('title', 'Profil')

@section('content')
  @php $user = auth()->user() @endphp
  <div class="row">
    <div class="col-12">
      <div class="card card-outline card-orange">
        <div class="card-header">
          <h3 class="card-title">{{ $user->name }}</h3>
        </div>
        <div class="card-body">
          <form id="form-store" method="post">
            <div class="form-group">
              <label for="name">Nama Lengkap</label>
              <input type="text" class="form-control" name="name" value="{{ $user->name }}">
              <small class="text-danger" id="error-name"></small>
            </div>
            <div class="form-group">
              <label for="username">Username</label>
              <input type="text" class="form-control" name="username" value="{{ $user->username }}">
              <small class="text-danger" id="error-username"></small>
            </div>
            <div class="form-group">
              <label for="password_old">Password Lama</label>
              <input type="password" class="form-control" name="password_old">
              <small class="text-danger" id="error-password_old"></small>
            </div>
            <br>
            <div class="alert alert-warning" role="alert">
              <div class="form-group">
                <label for="password_new">Password Baru</label>
                <input type="password" class="form-control" name="password_new">
                <small class="text-danger" id="error-password_new"></small>
              </div>
              <div class="form-group">
                <label for="password_new_confirmation">Konfirmasi Password Baru</label>
                <input type="password" class="form-control" name="password_new_confirmation">
                <small class="text-danger" id="error-password_new_confirmation"></small>
              </div>
            </div>
            <div class="text-right pt-2">
              <button type="submit" class="btn btn-primary" id="btn-store">Perbaharui</button>&nbsp;
              <button type="reset" class="btn btn-danger">Reset</button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
@endsection

@push('js')
  <script>
    $(document).ready(function() {
      $.ajaxSetup({
        headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
      });

      $('#form-store').on('submit', function(e) {
        e.preventDefault();
        
        Swal.fire({
          title: 'Perbaharui Profil?',
          text: 'Data Profil akan disimpan!',
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

            $.ajax({
              url: `{{ route('admin.pengaturan.users.updateProfile') }}`,
              method: 'post',
              data: new FormData($('#form-store').get(0)),
              dataType: 'json',
              contentType: false,
              cache: false,
              processData: false,
              success: function(res) {
                if(res.status) {
                  $('#form-store').trigger('reset');
                  Swal.fire({
                    title: 'Berhasil!',
                    text: 'Data profil telah diperbaharui!',
                    icon: 'success',
                    onClose: function() {
                      location.reload();
                    }
                  });
                } else {
                  Swal.fire('Data Profil Gagal Diperbaharui!', res.text, 'error');
                }
              },
              error: function(err) {
                Swal.fire('Data Profil Gagal Diperbaharui!', 'Pastikan semua input diisi!', 'error');
                changeButton(false);
                
                let { name, username, password_old, password_new, password_new_confirmation } = err.responseJSON.errors;
                $('#error-name').html(name);
                $('#error-username').html(username);
                $('#error-password_old').html(password_old);
                $('#error-password_new').html(password_new);
                $('#error-password_new_confirmation').html(password_new_confirmation);
              },
              complete: function(data) {
                changeButton(false);
              }
            });
          }
        });
      });

      function clearError() {
        $('#error-name').html('');
        $('#error-username').html('');
        $('#error-password_old').html('');
        $('#error-password_new').html('');
        $('#error-password_new_confirmation').html('');
      }

      function changeButton(status) {
        if (status) {
          $('#btn-store').html(`<div class="spinner-border spinner-border-sm text-light" role="status"></div>`);
          $('#btn-store').prop('disabled', true);
        } else {
          $('#btn-store').html('Perbaharui');
          $('#btn-store').prop('disabled', false);
        }
      }

    });
  </script>
@endpush
