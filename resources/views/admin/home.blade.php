@extends('layouts.admin')
@section('title', 'Dashboard')

@section('content')
<div class="row">
	<div class="col-sm-12">
		<div class="jumbotron bg-dark">
			<h1 class="display-4">Selamat Datang</h1>
			<h5><strong style="color: rgb(255, 94, 0);">Haurduni Motor</strong> Admin Management</h5>
		</div>
	</div>
	{{-- <div class="col-sm-12 mb-2">
		<div class="row">
			<div class="col-sm-4">
				<select class="custom-select custom-select-dm" name="bulan" id="bulan">
					<option @if(date('m')=='01') selected @endif value="01">Januari</option>
					<option @if(date('m')=='02') selected @endif value="02">Februari</option>
					<option @if(date('m')=='03') selected @endif value="03">Maret</option>
					<option @if(date('m')=='04') selected @endif value="04">April</option>
					<option @if(date('m')=='05') selected @endif value="05">Mei</option>
					<option @if(date('m')=='06') selected @endif value="06">Juni</option>
					<option @if(date('m')=='07') selected @endif value="07">Juli</option>
					<option @if(date('m')=='08') selected @endif value="08">Agustus</option>
					<option @if(date('m')=='09') selected @endif value="09">September</option>
					<option @if(date('m')=='10') selected @endif value="10">Oktober</option>
					<option @if(date('m')=='11') selected @endif value="11">November</option>
					<option @if(date('m')=='12') selected @endif value="12">Desember</option>
				</select>
			</div>
			<div class="col-sm-4">
				<select name='tahun' class='custom-select custom-select-dm' name='tahun' id="tahun">
					<?php for ($i=date('Y'); $i>=2020; $i--){ ?>
						<option value="{{$i}}">{{$i}}</option>
					<?php } ?>
				</select>
			</div>
		</div>
	</div>
	<div class="col-sm-6">
		<div class="card">
			<div class="card-body">
				<canvas id="transaksiPenjualan" height="100px"></canvas>
			</div>
		</div>
	</div>
	<div class="col-sm-6">
		<div class="card">
			<div class="card-body">
				<canvas id="transaksiPelanggan" height="100px"></canvas>
			</div>
		</div>
	</div>
	<div class="col-sm-12">
		<div class="card">
			<div class="card-body">
				<label for="">Transaksi Produk</label>
				<canvas id="transaksiProduk" height="100px"></canvas>
			</div>
		</div>
	</div> --}}
</div>
@endsection


@push('js')
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js" ></script>
{{-- <script src="https://cdn.jsdelivr.net/npm/chartPenjualan.js"></script>

<script type="text/javascript">

	let chartPenjualan = null
	let chartPelanggan = null
	let chartProduk = null

	$(document).ready(function(){
		getChartPenjualan()
		getChartPelanggan()
		getChartProduk()
	})

	$('#bulan').on('change', function() {
		chartPenjualan.destroy()
		chartPelanggan.destroy()
		getChartPenjualan()
		getChartPelanggan()
		getChartProduk()
	});

	$('#tahun').on('change', function() {
		chartPenjualan.destroy()
		chartPelanggan.destroy()
		getChartPenjualan()
		getChartPelanggan()
		getChartProduk()
	});

	async function getChartPenjualan() {
		const res = await $.get('{{ route("laporan.get") }}', {
			bulan: $('#bulan').val(),
			tahun: $('#tahun').val()
		})
		showChartPenjualan(res.tanggals, res.total_transaksi)
	}

	async function getChartPelanggan() {
		const res = await $.get('{{ route("laporan.get.pelanggan") }}', {
			bulan: $('#bulan').val(),
			tahun: $('#tahun').val()
		})
		showChartPelanggan(res.names, res.jumlahTransaksi)
	}

	async function getChartProduk() {
		const res = await $.get('{{ route("laporan.get.produk") }}', {
			bulan: $('#bulan').val(),
			tahun: $('#tahun').val()
		})
		showChartProduk(res.names, res.jumlahTransaksi, res.color)
	}

	function showChartPenjualan(tanggals, total_transaksi) {
		const data = {
			labels: tanggals,
			datasets: [{
				label: `Transaksi Penjualan ${this.BulanIndo($('#bulan').val())} - ${$('#tahun').val()}`,
				fill: false,
				borderColor: 'rgb(195, 0, 19)',
				tension: 0.1,
				data: total_transaksi,
			}]
		};

		const config = {
			type: 'line',
			data: data,
			options: {
				responsive: true,
				plugins: {
					legend: {
						position: 'top',
					},
				}
			}
		};

		chartPenjualan = new Chart(
			document.getElementById('transaksiPenjualan'),
			config
		);
	}

	function showChartPelanggan(names, jumlahTransaksi) {
		const data = {
			labels: names,
			datasets: [{
				label: `Total Transaksi ${this.BulanIndo($('#bulan').val())} - ${$('#tahun').val()}`,
				backgroundColor: 'rgb(14, 137, 0)',
				borderColor: 'rgb(14, 137, 0)',
				data: jumlahTransaksi,
			}]
		};

		const config = {
			type: 'bar',
			data: data,
			options: {}
		};

		chartPelanggan = new Chart(
			document.getElementById('transaksiPelanggan'),
			config
		);
	}

	function showChartProduk(names, totalTransaksi, color) {
		const data = {
			labels: names,
			datasets: [{
				label: `Produk`,
				backgroundColor: color,
				borderColor: color,
				data: totalTransaksi,
			}]
		};

		const config = {
			type: 'bar',
			data: data,
			options: {}
		};

		chartProduk = new Chart(
			document.getElementById('transaksiProduk'),
			config
		);
	}

	function BulanIndo(bulan) {
		switch(parseInt(bulan)) {
			case 1: bulan = "Januari"; break;
			case 2: bulan = "Februari"; break;
			case 3: bulan = "Maret"; break;
			case 4: bulan = "April"; break;
			case 5: bulan = "Mei"; break;
			case 6: bulan = "Juni"; break;
			case 7: bulan = "Juli"; break;
			case 8: bulan = "Agustus"; break;
			case 9: bulan = "September"; break;
			case 10: bulan = "Oktober"; break;
			case 11: bulan = "November"; break;
			case 12: bulan = "Desember"; break;
		}
		return bulan;
	}

</script> --}}
@endpush


