@extends('layouts.admin')
@section('title', 'Daftar Pesanan Baru')

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
					<div class="col-sm-4">
						<div class="float-left pt-2">
							<a href="{{ route('admin.daftar-pesanan') }}" class="text-success"> Pesanan
								<span class="badge badge-pill badge-info">{{ count($order) }}</span>
							</a>
							|
							<strong>
								<span class="badge badge-success">{{ bulanIndo($bulan).'/'.$tahun }}</span>
							</strong>
						</div>
					</div>
					<div class="col-sm-8">
						<div class="float-right">
							<form action="" method="GET">
								<div class="row">
									<div class="col-sm-5">
										<select class="form-control d-inline" name="bulan">
											@foreach(listBulan() as $row)
											<option @if($bulan == $row->value) selected @endif value="{{ $row->value }}">{{ $row->nama }}</option>
											@endforeach
										</select>
									</div>	
									<div class="col-sm-4">
										<select class="form-control d-inline" name="tahun">
											@foreach(listTahun(1) as $row)
											<option @if($tahun == $row->tahun) selected @endif value="{{ $row->tahun }}">{{ $row->tahun }}</option>
											@endforeach
										</select>
									</div>	
									<div class="col-sm-3">
										<button type="submit" class="btn btn-primary">Terapkan</button>
									</div>	
								</div>
							</form>
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
					<table id="table" class="table table-bordered table-hover table-sm" width="100%">
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
									<button type="button" class="btn btn-sm btn-danger btn-batalkan mt-1 mb-1" data-id="{{ $row->id }}" data-toggle="tooltip" title="Batalkan"><i class="fa fa-times"></i></button>
									@else
									<button type="button" class="btn btn-sm btn-danger btn-batalkan mt-1 mb-1" data-id="{{ $row->id }}" data-toggle="tooltip" title="Batalkan"><i class="fa fa-times"></i></button>
									<button type="button" class="btn btn-sm btn-success btn-terima mt-1 mb-1" data-id="{{ $row->id }}" data-toggle="tooltip" title="Terima Pesanan"><i class="fa fa-check"></i></button>
									@endif
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
											{{ $detail->Produk->nama }} x{{ $detail->jumlah.' ' .$detail->Produk->Kategori->satuan}}<br>
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
															$isOngkir = true;
															// $isOngkir = false;
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
					return fetch('daftar-pesanan/'+id+'/'+alasan, {
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
						text: 'Data Pesanan telah dibatalkan.',
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

	});

</script>
@endpush
