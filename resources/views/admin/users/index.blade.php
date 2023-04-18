@extends('layouts.admin')
@section('title', 'Admin')

@section('content')
  <div class="row">
    <div class="col-12">
      <div class="card card-outline card-orange">
        <div class="card-header">
          <h3 class="card-title">Daftar Admin</h3>
          <div class="card-tools">
            <button type="button" class="btn btn-tool bg-primary" data-toggle="modal" data-target="#modal-create">Tambah Admin</a>
          </div>
        </div>
        <div class="card-body">
          <table id="table" class="table table-bordered table-hover table-sm">
            <thead>
              <tr class="text-center">
                <th>Nama Lengkap</th>
                <th>Username</th>
                <th width="12%">Aksi</th>
              </tr>
            </thead>
          </table>
        </div>
      </div>
    </div>
  </div>

  <div class="modal fade" id="modal-create" tabindex="-1">
    <div class="modal-dialog modal-lg modal-dialog-scrollable">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Admin Baru</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <form method="post" id="form-store">
          <div class="modal-body" id="modal-body">
            <div class="form-group">
              <label for="name">Nama Lengkap</label>
              <input type="text" class="form-control" name="name">
              <small class="text-danger" id="error-name"></small>
            </div>
            <div class="form-group">
              <label for="username">Username</label>
              <input type="text" class="form-control" name="username">
              <small class="text-danger" id="error-username"></small>
            </div>
            <div class="form-group">
              <label for="password">Password</label>
              <input type="password" class="form-control" name="password">
              <small class="text-danger" id="error-password"></small>
            </div>
          </div>
          <div class="modal-footer">
            <button type="submit" class="btn btn-primary" id="btn-store">Simpan</button>&nbsp;
            <button type="button" class="btn btn-default" data-dismiss="modal">Tutup</button>
          </div>
        </form>
      </div>
    </div>
  </div>
@endsection

@push('js')
  <script>
    $(document).ready(function() {
      var table = $('#table').DataTable({
        responsive: true,
        processing: true,
        serverSide: true,
        ajax: `{{ route('admin.pengaturan.users.data') }}`,
        columns: [
          {data: 'name', name: 'name'},
          {data: 'username', name: 'username', class: 'text-center'},
          {data: 'action', name: 'action', orderable: false, searchable: false, class: 'text-center'},
        ]
      });

      $.ajaxSetup({
        headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
      });

      $('#form-store').on('submit', function(e) {
        e.preventDefault();
        
        Swal.fire({
          title: 'Simpan Admin?',
          text: 'Data Admin akan ditambahkan!',
          icon: 'warning',
          showCancelButton: true,
          confirmButtonColor: '#3085d6',
          confirmButtonText: 'Ya, Simpan!',
          cancelButtonColor: '#d33',
          cancelButtonText: 'Batal'
        }).then(function(result) {
          if (result.value) {
            changeButton(true);
            clearError();

            $.ajax({
              url: `{{ route('admin.pengaturan.users.store') }}`,
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
                    text: 'Data admin baru telah disimpan!',
                    icon: 'success',
                    onClose: function() {
                      $('#modal-create').modal('toggle');
                      table.ajax.reload(false,null);
                    }
                  });
                }
              },
              error: function(err) {
                Swal.fire('Data Admin Gagal Disimpan!', 'Pastikan semua input diisi!', 'error');
                changeButton(false);
                
                let { name, username, password } = err.responseJSON.errors;
                $('#error-name').html(name);
                $('#error-username').html(username);
                $('#error-password').html(password);
              },
              complete: function(data) {
                changeButton(false);
              }
            });
          }
        });
      });

      $('body').on('click', '.btn-delete', function(e) {
        e.preventDefault()
        var id = $(this).data('id');
        Swal.fire({
          title: 'Hapus Admin?',
          text: 'Data admin akan dihapus!',
          icon: 'warning',
          showLoaderOnConfirm: true,
          showCancelButton: true,
          confirmButtonColor: '#3085d6',
          confirmButtonText: 'Ya, Hapus!',
          cancelButtonColor: '#d33',
          cancelButtonText: 'Batal',
          preConfirm: () => {
            return fetch('users/'+ id, {
              headers: {
                "X-CSRF-Token": $('meta[name="csrf-token"]').attr('content')
              },
              method: 'delete'
            }).then(res => {
              if (!res.ok) {
                throw new Error(res.statusText);
              }
              return res.json();
            }).catch(err => console.error(err));
          },
          allowOutsideClick: () => !Swal.isLoading()
        }).then(function(result) {
          if (result.value.status) {
            table.ajax.reload();
            Swal.fire('Terhapus!', 'Data admin telah dihapus.', 'success');
          } else {
            Swal.fire('Terhapus!', result.value.message, 'error');
          }
        });
      });

      function clearError() {
        $('#error-name').html('');
        $('#error-username').html('');
        $('#error-password').html('');
      }

      function changeButton(status) {
        if (status) {
          $('#btn-store').html(`<div class="spinner-border spinner-border-sm text-light" role="status"></div>`);
          $('#btn-store').prop('disabled', true);
        } else {
          $('#btn-store').html('Simpan');
          $('#btn-store').prop('disabled', false);
        }
      }

    });
  </script>
@endpush
