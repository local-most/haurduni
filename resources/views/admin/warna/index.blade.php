@extends('layouts.admin')
@section('title', 'Warna')

@section('content')
<div class="row">
	<div class="col-sm-12">
		<div class="card">
			<div class="card-header">
				<div class="float-left">
					<a href="{{ route('admin.warna') }}" class="{{ $is_trash ? 'text-success':'text-muted' }}"> All
						<span class="badge badge-pill badge-info">{{ $warna_count }}</span>
					</a>
					&nbsp; | &nbsp;
					<a href="{{ route('admin.warna') }}?status=trash" class="{{ $is_trash ? 'text-muted':'text-danger' }}">
						Trash
						<span class="badge badge-pill badge-danger">{{ $trash_count }}</span>
					</a>
				</div>
				<div class="float-right">
					<a href="{{ route('admin.warna.create') }}" class="btn btn-primary btn-sm">Tambah Data</a>
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
					<table id="table" class="table table-bordered table-hover table-sm">
						<tfoot id="search">
							<tr>
								<th>No</th>
								<th class="text-center">Aksi</th>
								<th class="text-center">Nama</th>
							</tr>
						</tfoot>
						<thead>
							<tr class="text-center">
								<th>No</th>
								<th>Aksi</th>
								<th>Nama</th>
								<th>Warna</th>
							</tr>
						</thead>
						<tbody>
							@foreach($records as $row)
							<tr>
								<td class="text-center">{{ $loop->iteration }}</td>
								<td class="text-center" width="150px">
									@if($row->deleted_at == null)
									<a href="{{ route('admin.warna.edit', $row->id) }}" class="btn btn-success btn-sm mt-1 mb-1"><i class="fas fa-edit"></i></a>
									<button type="button" class="btn btn-sm btn-danger btn-delete mt-1 mb-1" data-id="{{ $row->id }}"><i class="fas fa-trash"></i></button>
									@else
									<button type="button" title="restore" class="btn btn-success btn-restore btn-sm" data-id="{{ $row->id }}">Restore</button>
									<button type="button" title="destroy" class="btn btn-danger btn-destroy btn-sm" data-id="{{ $row->id }}">Destroy</button>
									@endif
								</td>
								<td class="text-center">{{ ucwords($row->nama) }} </td>
								<td class="text-center">
									<div class="card" style="background-color:{{ $row->value }}">
										<div class="card-body">
										{{ $row->value }}
										</div>
									</div>
								</td>
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
				title: 'Hapus Warna?',
				text: 'Data Warna akan dihapus!',
				icon: 'warning',
				showLoaderOnConfirm: true,
				showCancelButton: true,
				confirmButtonColor: '#3085d6',
				confirmButtonText: 'Ya, Hapus!',
				cancelButtonColor: '#d33',
				cancelButtonText: 'Batal',
				preConfirm: () => {
					return fetch('warna/'+ id +'/delete', {
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
						title: 'Terhapus!',
						text: 'Data Warna telah dihapus.',
						icon: 'success',
						onClose: function() {
							location.reload();
						}
					});
				}
			});
		});

		$(document).on('click','.btn-destroy', function(e) {
			e.preventDefault();
			var id = $(this).data('id');
			Swal.fire({
				title: 'Hapus Warna?',
				text: 'Data Warna akan dihapus permanent!',
				icon: 'warning',
				showLoaderOnConfirm: true,
				showCancelButton: true,
				confirmButtonColor: '#3085d6',
				confirmButtonText: 'Ya, Hapus!',
				cancelButtonColor: '#d33',
				cancelButtonText: 'Batal',
				preConfirm: () => {
					return fetch('warna/'+ id +'/destroy', {
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
						text: 'Data Warna telah dihapus permanent.',
						icon: 'success',
						onClose: function() {
							location.reload();
						}
					});
				}
			});
		});

		$(document).on('click','.btn-restore', function(e) {
			e.preventDefault();
			var id = $(this).data('id');
			Swal.fire({
				title: 'Kembalikan Warna?',
				text: 'Data Warna akan dikembalikan!',
				icon: 'warning',
				showLoaderOnConfirm: true,
				showCancelButton: true,
				confirmButtonColor: '#3085d6',
				confirmButtonText: 'Ya, Kembalikan!',
				cancelButtonColor: '#d33',
				cancelButtonText: 'Batal',
				preConfirm: () => {
					return fetch('warna/'+ id +'/restore', {
						headers: {
							"X-CSRF-Token": $('meta[name="csrf-token"]').attr('content')
						},
						method: 'post'
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
						text: 'Data Warna telah dikembalikan',
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
