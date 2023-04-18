@extends('layouts.admin')
@section('title', 'Pesanan Dibatalkan')
<style type="text/css">
	.coret-text{
        text-decoration: line-through;
    }
</style>
@section('content')
<div class="row">
	<div class="col-sm-12">
		<div class="card">
			<div class="card-header">
				<div class="row">
					<div class="col-sm-12">
						<div class="float-left pt-2">
							<a href="{{ route('admin.pesanan-dibatalkan') }}?status=dibatalkan" class="{{ $status == 'dibatalkan' ? 'text-muted':'text-success' }}"> Dibatalkan
								<span class="badge badge-pill {{ $status == 'dibatalkan' ? 'badge-secondary' : 'badge-info' }}">{{ $order_dibatalkan }}</span>
							</a>
						</div>
					</div>
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
								<th class="text-center">Pesanan</th>
								<th class="text-center">Metode Pengiriman</th>
								<th class="text-center">Total</th>
							</tr>
						</tfoot>
						<thead>
							<tr class="text-center">
								<th>No</th>
								<th>Aksi</th>
								<th>Nama</th>
								<th>Pesanan</th>
								<th>Metode Pengiriman</th>
								<th>Total</th>
							</tr>
						</thead>
						<tbody>
							@foreach($order as $row)
							<?php
								$tanggalSekarang = strtotime(date('Y-m-d'));
								$tanggalOrder = strtotime(date('Y-m-d', strtotime('+3 day', strtotime($row->tanggal))));
							?>
							@if($tanggalSekarang > $tanggalOrder && $row->bukti_pembayaran == NULL)
							<tr style="background-color:#ffcbd0;">
							@else
							<tr>
							@endif
								<td class="text-center">{{ $loop->iteration }}</td>
								<td class="text-center" width="150px">
									@if($tanggalSekarang > $tanggalOrder && $row->bukti_pembayaran == NULL)
									<span class="badge badge-danger">Pesanan di blokir</span>
									@else
									<button type="button" class="btn btn-sm btn-success btn-terima mt-1 mb-1" data-id="{{ $row->id }}" data-toggle="tooltip" title="Kirim Ulang Pesanan"><i class="fa fa-check"></i></button>
									@endif
									<!-- <button type="button" class="btn btn-sm btn-danger btn-batalkan mt-1 mb-1" data-id="{{ $row->id }}" data-toggle="tooltip" title="Batalkan"><i class="fa fa-times"></i></button> -->
								</td>
								<td class="text-center">{{ $row->User->nama }} </td>
								<td>
									@php 
										$total_bayar = [];
										$ongkir = [];
									@endphp

									@foreach($row->OrderDetail as $detail)
										@php 
											$total_bayar[] = $detail->jumlah*$detail->harga;
											$ongkir[] = $detail->jumlah*$detail->Produk->Kategori->harga;
										@endphp
										<li>
											{{ $detail->Produk->nama }} {{ $detail->jumlah.' ' .$detail->Produk->Kategori->satuan}}<br>
											&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
											@if(count($detail->Produk->Diskon) > 0)
											<small>Rp</small><span style="text-decoration: line-through; font-size:10px">{{ number_format($detail->Produk->harga,0,'.','.') }}</span>
											<small>Rp</small><h5 class="d-inline">{{ number_format($detail->Produk->harga-$detail->Produk->Diskon[0]->harga,0,'.','.') }}</h5>
											@else
											<span>
													<small>Rp</small>{{ number_format($detail->Produk->harga,0,'.','.') }}
											</span>
											@endif
											<br>
											<small>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
												Catatan : {{ $detail->keterangan }}</small>
										</li>
									@endforeach
								</td>
								<td>
									@if($row->is_delivered == true)
									Dikirimkan ke : <strong>{{ $row->Wilayah ? $row->Wilayah->nama : '-' }}</strong> <br>

									<?php
				                    if($row->total_harga >= 150000 && $row->total_harga < 5000000){
				                        $isOngkir = true;
				                    }else if($row->total_harga >= 5000000){
				                        // $isOngkir = false;
																$isOngkir = true;
				                    }else{
															$isOngkir = true;
				                        // $isOngkir = false;
				                    }
				                    ?>

									Ongkir : Rp
									<h5 class="d-inline {{ !$isOngkir ? 'coret-text' : '' }}">
										{{ number_format($row->total_ongkir,0,",",".") }}
									</h5>
									<br>

									Alamat : {{ $row->User->alamat }}
									@else
									Diambil ke Toko
									@endif
								</td>
								<td class="text-right">
									<?php
				                    if($row->total_harga >= 150000 && $row->total_harga < 5000000){
				                        $total_tagihan = number_format($row->total_tagihan, 0,'.','.');
				                    }else if($row->total_harga >= 5000000){
				                        $total_tagihan = number_format($row->total_harga, 0,'.','.');
				                    }else{
				                        $total_tagihan = number_format($row->total_tagihan, 0,'.','.');
				                    }
				                    ?>
									Rp
									<h5 class="d-inline">
										{{ $total_tagihan }}
									</h5><br>
									Bukti Pembayaran : 
									@if($row->bukti_pembayaran)
									<a href="{{ asset($row->bukti_pembayaran) }}" target="_blank">Lihat</a>
									@else
									Menunggu
									@endif
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

		$(document).on('click','.btn-batalkan', function(e) {
			e.preventDefault();
			var id = $(this).data('id');
			Swal.fire({
				title: 'Tuliskan alasan kenapa dibatalkan',
				input: 'text',
				inputAttributes: {
					autocapitalize: 'off'
				},
				showLoaderOnConfirm: true,
				showCancelButton: true,
				confirmButtonColor: '#3085d6',
				confirmButtonText: 'Ya, Batalkan',
				cancelButtonColor: '#d33',
				cancelButtonText: 'Kembali',
				preConfirm: (alasan) => {
					if (alasan) {
						return fetch('pesanan-dibatalkan/'+id+'/'+alasan, {
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
					}else{
						Swal.fire(
							'Peringatan!',
							'Alasan dibatalkan tidak boleh kosong.',
							'error'
							)
					}
				},
				allowOutsideClick: () => !Swal.isLoading()
			}).then(function(result) {
				if (result.value) {
					Swal.fire({
						title: 'Dibatalkan!',
						text: 'Data Pesanan telah dibatalkan.',
						icon: 'success',
						onClose: function() {
							location.reload();
						}
					});
				}
			});
		});

		$(document).on('click','.btn-kirim', function(e) {
			e.preventDefault();
			var id = $(this).data('id');
			Swal.fire({
				title: 'Kirim Pesanan?',
				text: "apakah anda yakin semuanya sudah sesuai!",
				icon: 'warning',
				showLoaderOnConfirm: true,
				showCancelButton: true,
				confirmButtonColor: '#3085d6',
				confirmButtonText: 'Ya, Kirim',
				cancelButtonColor: '#d33',
				cancelButtonText: 'Kembali',
				preConfirm: () => {
					return fetch('kirim-pesanan/'+id, {
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
						title: 'Proses Pengiriman!',
						text: 'Data Pesanan akan dikirim.',
						icon: 'success',
						onClose: function() {
							location.reload();
						}
					});
				}
			});
		});

		$(document).on('click','.btn-terima', function(e) {
			e.preventDefault();
			var id = $(this).data('id');
			Swal.fire({
				title: 'Terima Pesanan dan proses?',
				text: "apakah anda yakin semuanya sudah sesuai!",
				icon: 'warning',
				showLoaderOnConfirm: true,
				showCancelButton: true,
				confirmButtonColor: '#3085d6',
				confirmButtonText: 'Ya, Terima',
				cancelButtonColor: '#d33',
				cancelButtonText: 'Kembali',
				preConfirm: () => {
					return fetch('terima-pesanan/'+id, {
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
						title: 'Diterima!',
						text: 'Data Pesanan telah diterima.',
						icon: 'success',
						onClose: function() {
							location.reload();
						}
					});
				}
			});
		});

		$(document).on('click','.btn-selesai', function(e) {
			e.preventDefault();
			var id = $(this).data('id');
			Swal.fire({
				title: 'Pesanan Selesai?',
				text: "apakah anda yakin semuanya sudah selesai?",
				icon: 'warning',
				showLoaderOnConfirm: true,
				showCancelButton: true,
				confirmButtonColor: '#3085d6',
				confirmButtonText: 'Ya, Selesai',
				cancelButtonColor: '#d33',
				cancelButtonText: 'Kembali',
				preConfirm: () => {
					return fetch('selesai-pesanan/'+id, {
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
						title: 'Pesanan Selesai!',
						text: 'Data Pesanan telah selesai.',
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
