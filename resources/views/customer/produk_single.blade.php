@extends('layouts.home')
@section('title', 'Home')
@push('css')
<link rel="stylesheet" type="text/css" href="{{ asset('rating/css/star-rating-three.css') }}">
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
<style type="text/css">
    .input-jumlah{
        border: 1px solid #ccc;
        border-radius: 4px;
        width: 80px;
        height: 27px;
        font-size: 12px;
        text-align: center;
    }
</style>
<!-- shop section -->
<section class="shop_section" style="margin-bottom: 200px; margin-top: 50px;">
    <div class="container">
        <div class="row">
            <div class="col-md-4">
                <div class="box">
                    <a href="">
                        <div class="img-box">
                            <img src="{{ asset($produk->foto) }}" alt="">
                        </div>
                        <div class="text-center">
                            <small><i>*Jika produk tidak tersedia di etalase, dapat menghubungi untuk Pre Order</i></small>
                        </div>
                    </a>
                </div>
            </div>
            <div class="col-md-4 pt-4">
                <h4><b>{{ strtoupper($produk->nama) }}</b></h4>
                <small class="d-block" style="margin-bottom: 20px;">Terjual {{ $terjual }} | Tersedia {{ $produk->stok }}</small>
                @if(count($produk->Diskon) > 0)
                <small>Rp</small><span style="text-decoration: line-through; font-size:10px">{{ number_format($produk->harga,0,'.','.') }}</span>
                <small>Rp</small><h3 class="d-inline">{{ number_format($produk->harga-$produk->Diskon[0]->harga,0,'.','.') }}</h3>
                @else
                <span>
                    <small>Rp</small>{{ number_format($produk->harga,0,'.','.') }}
                </span>
                @endif
                <br>
                <br>
                <stong>Rincian : </stong>
                <p>{!! $produk->deskripsi !!}</p>
            </div>
            <div class="col-sm-4 pt-4">
                <div class="card">
                    <div class="card-body">
                        <form action="{{ route('keranjang.beli') }}" method="POST">
                            @csrf
                            <input type="hidden" name="produk_id" value="{{ $produk->id }}">
                            <h6>Atur Jumlah dan Catatan</h6>
                            <button id="minus" class="btn btn-sm" type="button">
                                <i class="fa fa-minus-circle" aria-hidden="true" style="color: gray;"></i>
                            </button>
                            <input type="text" name="jumlah" class="input-jumlah" id="text-jumlah" oninput="getHargaTotalOnInput()" onkeypress="return event.charCode >= 48 && event.charCode <=57">
                            <button id="plus" class="btn btn-sm" type="button">
                                <i class="fa fa-plus-circle" aria-hidden="true" style="color: green;"></i>
                            </button>
                            <br>
                            @if($produk->Kategori->is_color == true)
                            <div class="row">
                                <div class="col-sm-12">
                                    <label>Tersedia Warna : </label>
                                    <?php
                                    $warna = array_map(function($id){
                                        return \App\Models\Warna::where('id', $id)->first();
                                    }, explode(',',$produk->warna_id));
                                    ?>
                                    <select class="form-control" name="warna_id" data-placeholder="  Pilih Warna yang sesuai" id="warna_id" onchange="showWarna()">
                                        @if(count($warna) > 1)
                                            @foreach($warna as $row)
                                            <option value="{{ $row->id }}">{{ ucwords($row->nama) }}</option>
                                            @endforeach
                                        @endif
                                    </select>
                                    <div class="row">
                                        <div class="col-sm-5 mt-2 offset-3" style="display:none;" id="warna-pallet">
                                            <div class="card" style="background-color:#00a1ff" id="show-warna">
                                                <div class="card-body"></div>
                                            </div>
                                        </div>
                                    </div>
                                    <small style="color: red; font-size: 10px;"><i>*jika tidak diisi kami akan pilihkan secara random</i></small>
                                </div>
                            </div>
                            @endif
                            <label>Catatan : </label>
                            <textarea class="form-control" name="catatan" placeholder="Tambahkan catatan"></textarea>
                            <br>
                            <div class="row">
                                <div class="col-5">
                                    <small>Sub Total : </small>
                                </div>
                                <div class="col-7">
                                    <div class="float-right">
                                        @if(count($produk->Diskon) > 0)
                                        <span style="text-decoration: line-through; font-size:12px" id="total-original"></span>
                                        @endif
                                        <strong id="total"></strong>
                                    </div>
                                </div>
                                <div class="col-sm-12 mt-2">
                                    <div class="float-left" style="display: show;" id="keranjang">
                                        <button class="btn btn-warning btn-sm" name="status" value="keranjang"><i class="fa fa-plus" aria-hidden="true"></i> Keranjang</button>
                                    </div>
                                    <div class="float-right" style="display: none;" id="beli">
                                        <button class="btn btn-success btn-sm" name="status" value="beli"> Beli Langsung</button>
                                    </div>
                                </div>
                                <div class="col-sm-12 mt-2" id="alert" style="display: none;">
                                    <div class="alert alert-danger">Stok barang tidak mencukupi</div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="col-sm-12 mt-5">
                <h5>Ulasan : </h5>
                @if(count($produk->Testimoni) == 0)
                    <span>Belum ada ulasan yang tersedia</span>
                @endif
                @foreach($produk->Testimoni as $row)
                <div class="card mb-2">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-sm-1">
                                @if($row->User->foto)
                                <img src="{{ asset($row->User->foto) }}" class="image-cropper mb-2" width="50px" height="50px">
                                @else
                                <img src="{{ asset('default.png') }}" class="image-cropper mb-2" id="preview-foto" width="50px">
                                @endif
                            </div>
                            <div class="col-sm-11">
                                <b>{{ $row->User->nama }}</b> <br>
                                <small>{{ differentTime($row->created_at) }}</small> <br>
                                <input id="rating-input-{{ $row->id }}" type="text" title="" name="rate" disabled value="{{ $row->rate }}"/>
                                <small>{{ $row->keterangan }}</small> <br>
                                @if($row->gambar)
                                <div id="lihat-gambar">
                                    <strong class="btn text-muted" type="button" data-toggle="collapse" data-target="#collapseOne{{ $row->id }}" aria-expanded="true" aria-controls="collapseOne{{ $row->id }}">
                                        <i class="fa fa-eye" aria-hidden="true"></i><small> Lihat gambar</small>
                                    </strong>
                                    <div id="collapseOne{{ $row->id }}" class="collapse" aria-labelledby="headingOne" data-parent="#lihat-gambar">
                                        <div class="card-body">
                                            <a href="{{ asset($row->gambar) }}" target="_blank"><img src="{{ asset($row->gambar) }}" class="mb-2" width="200px"></a>
                                        </div>
                                    </div>
                                </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
</section>
<!-- end shop section -->

@endsection
@push('js')
<script type="text/javascript" src="{{ asset('rating/js/star-rating.js') }}"></script>
<script src="{{ asset('js/select2.full.min.js') }}"></script>
<script>
    var count = 1;
    var jumlah = document.getElementById("text-jumlah");
    var total = document.getElementById("total");
    var total_original = document.getElementById("total-original");
    total.innerHTML = 'Rp. {{ number_format($produk->harga, 0,'.','.') }}';
    jumlah.value = 1;

    $(document).ready(function(){
        @foreach($produk->Testimoni as $row)
        var $inp = $('#rating-input-{{ $row->id }}');

        //$inp.attr('value','4');

        $inp.rating({
                min: 0,
                max: 5,
                step: 1,
                size: 'sm',
                showClear: false
            });
        @endforeach
    });

    function plus(){
        count+=1;
        jumlah.value = count;
        getHargaTotal(count);
    }

    function minus(){
        if (count > 1) {
            count = $('#text-jumlah').val();
            count-=1;
            jumlah.value = count;
            getHargaTotal(count);
        }
    }

    function getHargaTotal(jumlah) {

        $.get("{{ route('get.harga.total') }}",
        {
            jumlah,
            produk_id : '{{ $produk->id }}'
        },
        function(res){
            // console.log('res', $('#text-jumlah').val() > res.jumlah);
            total.innerHTML = res.total;
            total_original.innerHTML = res.total_original;
            if ($('#text-jumlah').val() > res.stok) {
                $("#keranjang").hide();
                $("#alert").show();
            }else{
                $("#keranjang").show();
                $("#alert").hide();
            }
        },'json');

    }

    function getHargaTotalOnInput() {
        if ($('#text-jumlah').val() == '' || $('#text-jumlah').val() == 0) {
            jumlah.value = 1;
        }
        getHargaTotal($('#text-jumlah').val());
        count = parseInt($('#text-jumlah').val());
    }

    document.getElementById("plus").onclick = function(){
        plus()
    };

    document.getElementById("minus").onclick = function(){
        minus()
    };

    $(document).ready(function(){
        getHargaTotal($('#text-jumlah').val());
        @if($produk->kategori_id == 2)
            showWarna();
        @endif
    });

    function showWarna(){
        let warna_id = $('#warna_id').val();
        $.get("{{ route('get.warna') }}",
        {
            warna_id
        },
        function(res){
            $('#warna-pallet').show();
            document.getElementById("show-warna").style.backgroundColor = res.value;
        },'json');
    }
</script>
@endpush
