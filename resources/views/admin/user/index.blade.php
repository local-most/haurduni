@extends('layouts.admin')
@section('title', 'Users')

@section('content')
<div class="row">
	<div class="col-sm-12">
		<div class="card">
			<div class="card-header">
				<div class="float-left">
					<a href="{{ route('admin.user') }}?status=1">Tervalidasi</a> <span class="badge {{ $status == 1 ? 'badge-success' : 'badge-secondary' }}">{{ $validate_count }}</span>
					|
					<a href="{{ route('admin.user') }}?status=0">Belum Tervalidasi</a> <span class="badge {{ $status == 0 ? 'badge-success' : 'badge-secondary' }}">{{ $not_validate_count }}</span>
				</div>
			</div>
			<div class="card-body">
				@if( session('msg') )
				<?php $msg = session('msg'); ?>
				<div class="alert alert-{{ $msg['type'] }} alert-remove">
					{!! $msg['text'] !!}
				</div>
				@endif
				<div class="table-responsive">
					<table id="table" class="table table-bordered table-hover table-sm" width="100%">
						<thead>
							<tr class="text-center">
								<th>No</th>
								<th>Aksi</th>
								<th>Nama</th>
								<th>Email</th>
								<th>Nomor HP</th>
								<th>Alamat</th>
								<th>Profile</th>
								{{-- <th>KTP</th> --}}
								@if($status == 0)
								<th class="text-center">Alasan</th>
								@endif
							</tr>
						</thead>
						<tbody>
							@foreach($user as $row)
							<tr>
								<td class="text-center">{{ $loop->iteration }}</td>
								<td class="text-center" width="150px">
									<button type="button" class="btn btn-sm btn-success btn-validate-terima mt-1 mb-1" data-id="{{ $row->id }}"><i class="fa fa-check"></i></button>
									<button type="button" class="btn btn-sm btn-warning btn-validate-tolak mt-1 mb-1" data-id="{{ $row->id }}"><i class="fa fa-times"></i></button>
									<button type="button" class="btn btn-sm btn-danger btn-delete mt-1 mb-1" data-id="{{ $row->id }}"><i class="fas fa-trash"></i></button>
								</td>
								<td class="text-center">{{ $row->nama }} </td>
								<td class="text-center">{{ $row->email ? $row->email : '-' }} </td>
								<td class="text-center">{{ $row->nohp ? $row->nohp : '-' }} </td>
								<td class="text-left">{{ $row->alamat ? $row->alamat : '-' }}</td>
								<td class="text-center">
									@if($row->foto)
                                        <a href="{{ asset($row->foto) }}" target="_blank">
                                        	<img src="{{ asset($row->foto) }}" class="image-cropper mb-2" width="100px" height="100px">
                                        </a>
                                    @else
                                        <img src="{{ asset('default.png') }}" class="image-cropper mb-2" id="preview-foto" width="100px">
                                    @endif
								</td>
								{{-- <td class="text-center">
									@if($row->ktp)
                                        <a href="{{ asset($row->ktp) }}" target="_blank">
                                        	<img src="{{ asset($row->ktp) }}" class="image-cropper mb-2" width="100px" height="100px">
                                        </a>
                                    @else
                                        <img src="{{ asset('default-ktp.png') }}" class="image-cropper mb-2" id="preview-ktp" width="100px" height="100px">
                                    @endif
								</td> --}}
								@if($status == 0)
								<td class="text-left">{{ $row->alasan }}</td>
								@endif
							</tr>
							@endforeach
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</div>
</div>
@endsection

@push('js')
<script>

	$(document).ready(function() {

		$('#table thead tr').clone(true).appendTo( '#table thead' );
		$('#table thead tr:eq(1) th').each( function (i) {
			var title = $(this).text();

			if (title !== 'No' && title !== 'Aksi') {
				$(this).html('<input class="form-control" style="font-size:13px;" type="text" placeholder="Cari" />' );
			}else{
				$(this).html('');
			}

			$('input', this).on('keyup change', function () {
				if (table.column(i).search() !== this.value) {
					table
					.column(i)
					.search(this.value)
					.draw();
				}
			});
		});

		var table = $('#table').DataTable( {
			orderCellsTop: true,
			fixedHeader: true
		});

		$.ajaxSetup({
			headers: {
				'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
			}
		});

		$(document).on('click','.btn-delete', function(e) {
			e.preventDefault();
			var id = $(this).data('id');
			Swal.fire({
				title: 'Hapus User?',
				text: 'Data User akan dihapus!',
				icon: 'warning',
				showLoaderOnConfirm: true,
				showCancelButton: true,
				confirmButtonColor: '#3085d6',
				confirmButtonText: 'Ya, Hapus!',
				cancelButtonColor: '#d33',
				cancelButtonText: 'Batal',
				preConfirm: () => {
					return fetch('user/'+ id, {
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
				if (result.value) {
					Swal.fire({
						title: 'Terhapus!',
						text: 'Data User telah dihapus.',
						icon: 'success',
						onClose: function() {
							location.reload();
						}
					});
				}
			});
		});

		$(document).on('click','.btn-validate-terima', function(e) {
			e.preventDefault();
			var id = $(this).data('id');
			Swal.fire({
				title: 'Verifikasi Akun?',
				text: 'Akun akan diterima!',
				icon: 'warning',
				showLoaderOnConfirm: true,
				showCancelButton: true,
				confirmButtonColor: '#3085d6',
				confirmButtonText: 'Ya, Verifikasi!',
				cancelButtonColor: '#d33',
				cancelButtonText: 'Batal',
				preConfirm: () => {
					return fetch('user/'+ id, {
						headers: {
							"X-CSRF-Token": $('meta[name="csrf-token"]').attr('content')
						},
						method: 'put'
					}).then(res => {
						if (!res.ok) {
							throw new Error(res.statusText);
						}
						return res.json();
					}).catch(err => console.error(err));
				},
				allowOutsideClick: () => !Swal.isLoading()
			}).then(function(result) {
				if (result.value) {
					Swal.fire({
						title: 'Terverifikasi!',
						text: 'Akun telah diverifikasi.',
						icon: 'success',
						onClose: function() {
							location.reload();
						}
					});
				}
			});
		});

		$(document).on('click','.btn-validate-tolak', function(e) {
			e.preventDefault();
			var id = $(this).data('id');
			Swal.fire({
				title: 'Tuliskan alasan kenapa ditolak',
				input: 'text',
				inputAttributes: {
					autocapitalize: 'off'
				},
				showLoaderOnConfirm: true,
				showCancelButton: true,
				confirmButtonColor: '#3085d6',
				confirmButtonText: 'Ya, Tolak',
				cancelButtonColor: '#d33',
				cancelButtonText: 'Kembali',
				preConfirm: (alasan) => {
					return fetch('user/'+id+'/'+alasan, {
						headers: {
							"X-CSRF-Token": $('meta[name="csrf-token"]').attr('content')
						},
						method: 'put'
					}).then(res => {
						if (!res.ok) {
							throw new Error(res.statusText);
						}
						return res.json();
					}).catch(err => console.error(err));
				},
				allowOutsideClick: () => !Swal.isLoading()
			}).then(function(result) {
				if (result.value) {
					Swal.fire({
						title: 'Dibatalkan!',
						text: 'Akun telah ditolak.',
						icon: 'success',
						onClose: function() {
							location.reload();
						}
					});
				}
			});
		});

	});

</script>
@endpush
