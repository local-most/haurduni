@extends('layouts.admin')
@section('title', 'Laporan')

@section('content')
<div class="row">
	<div class="col-sm-6">
		<div class="card">
			<div class="card-body">
				@if( session('msg') )
				<?php $msg = session('msg'); ?>
				<div class="alert alert-{{ $msg['type'] }} alert-remove">
					{!! $msg['text'] !!}
				</div>
				@endif
				<div class="text-left mb-2">
					Rekap Transaksi
				</div>
				<form action="{{ route('laporan.cetak') }}" method="GET">
					@csrf
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
						<div class="col-auto">
							<button class="btn btn-success btn-sm mb-2" type="submit">Cetak Excel</button>
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>
	<div class="col-sm-12">
		<div class="card">
			<div class="card-body">
				<canvas id="myChart" height="100px"></canvas>
			</div>
		</div>
	</div>
</div>
@endsection

@push('js')
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js" ></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script type="text/javascript">

	let chart = null

	$(document).ready(function(){
		getChart()
	})

	$('#bulan').on('change', function() {
		chart.destroy()
		getChart()
	});

	$('#tahun').on('change', function() {
		chart.destroy()
		getChart()
	});

	async function getChart() {
		const res = await $.get('{{ route("laporan.get") }}', {
			bulan: $('#bulan').val(),
			tahun: $('#tahun').val()
		})
		showChart(res.tanggals, res.total_transaksi)
	}

	function showChart(tanggals, total_transaksi) {
		const data = {
			labels: tanggals,
			datasets: [{
				label: 'Transaction',
				backgroundColor: 'rgb(255, 99, 132)',
				borderColor: 'rgb(255, 99, 132)',
				data: total_transaksi,
			}]
		};

		const config = {
			type: 'line',
			data: data,
			options: {}
		};

		chart = new Chart(
			document.getElementById('myChart'),
			config
		);
	}
  
</script>
@endpush
