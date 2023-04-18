@extends('layouts.second_home')
@section('title', 'Pembayaran')
@push('css')
<link rel="stylesheet" href="{{ asset('css/select2.min.css') }}">
<link rel="stylesheet" href="{{ asset('css/select2-bootstrap4.min.css') }}">
<style type="text/css">
    .select2-selection__choice {
        background-color: #3b4a6b !important;
        color: white !important;
    }
</style>
@endpush
@section('content')

<div class="p-5">
    <div class="row">
        <div class="col-sm-4">
            <div class="card">
                <div class="card-body">
                    <h6><b>Metode Pembayaran</b></h6>
                    <div>
                        <small>Bank Tujuan</small>
                        <br>
                        <img class="mt-2 mb-2" src="{{ asset('bca.svg') }}" width="100px">
                        <br>
                        <b>{{ '2996738399' }}</b> a.n (PT. Harapan Mulya)
                    </div>
                    <br>
                    <div>Jumlah yang harus dibayar</div>
                    <?php
                    if($order->total_harga >= 200000 && $order->total_harga < 5000000){
                        $total_bayar = 'Rp'.number_format($order->total_tagihan, 0,'.','.');
                    }else if($order->total_harga >= 5000000){
                        $total_bayar = 'Rp'.number_format($order->total_harga, 0,'.','.');
                    }else{
                        $total_bayar = 'Rp'.number_format($order->total_tagihan, 0,'.','.');
                    }
                    ?>
                    <div style="color: orange;"><h4>{{ $total_bayar }}</h4></div>
                </div>
            </div>
        </div>
        <div class="col-sm-8">
            <div class="card">
                <div class="card-body">
                    <?php
                        $tanggalSekarang = strtotime(date('Y-m-d'));
                        $tanggalOrder = strtotime(date('Y-m-d', strtotime('+3 day', strtotime($order->tanggal))));
                    ?>
                    <h6><b>Unggah Bukti Pembayaran</b></h6>
                    @if($tanggalSekarang > $tanggalOrder && $order->bukti_pembayaran == NULL)
                    <div class="alert btn-danger">
                        <small>Pembayaran kamu di blokir karena melebihi batas waktu (3 Hari)<a href="{{ route('home') }}" style="color: orange;"> Kembali ke halaman utama</a></small>
                    </div>
                    @else
                    <form action="{{ route('pembelian.upload.pembayaran', $order->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group">
                            @if($order->bukti_pembayaran)
                            <img src="{{ asset($order->bukti_pembayaran) }}" class="img-fluid mb-2" id="preview-bukti" width="200px">
                            @else
                            <img src="" class="img-fluid mb-2" id="preview-bukti" width="200px">
                            @endif
                            <input type="file" name="bukti_pembayaran" class="form-control" required accept="image/*" onchange="loadImage(event, 'preview-bukti')">
                        </div>
                        <div class="form-group">
                            <button type="submit" class="btn btn-success btn-sm"><i class="fa fa-paper-plane" aria-hidden="true"></i> Kirim</button>
                        </div>
                    </form>
                    @endif

                    @if($msg)
                    <div class="alert btn-info">
                        <small>{{ $msg }} ! <a href="{{ route('home') }}" style="color: orange;">Kembali ke halaman utama</a></small>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
@push('js')
<script src="{{ asset('js/select2.full.min.js') }}"></script>
<script type="text/javascript">
    var loadImage = function(e, targetPreview) {
        var output = document.getElementById(targetPreview);
        output.src = URL.createObjectURL(event.target.files[0]);
        output.onload = function() {
            URL.revokeObjectURL(output.src);
        }
    };
</script>
@endpush