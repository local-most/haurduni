@extends('layouts.home')
@section('title', 'Keranjang')
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
<style type="text/css">
    .input-jumlah{
        border: 1px solid #ccc;
        border-radius: 4px;
        width: 80px;
        height: 27px;
        font-size: 12px;
        text-align: center;
    }
    /* The container */
    .container-chechbox {
        display: block;
        position: relative;
        padding-left: 35px;
        margin-bottom: 12px;
        cursor: pointer;
        font-size: 15px;
        -webkit-user-select: none;
        -moz-user-select: none;
        -ms-user-select: none;
        user-select: none;
    }

    /* Hide the browser's default checkbox */
    .container-chechbox input {
        position: absolute;
        opacity: 0;
        cursor: pointer;
        height: 0;
        width: 0;
    }

    /* Create a custom checkbox */
    .checkmark {
        position: absolute;
        top: 0;
        left: 0;
        height: 25px;
        width: 25px;
        background-color: #eee;
    }

    /* On mouse-over, add a grey background color */
    .container-chechbox:hover input ~ .checkmark {
        background-color: #ccc;
    }

    /* When the checkbox is checked, add a blue background */
    .container-chechbox input:checked ~ .checkmark {
        background-color: #2196F3;
    }

    /* Create the checkmark/indicator (hidden when not checked) */
    .checkmark:after {
        content: "";
        position: absolute;
        display: none;
    }

    /* Show the checkmark when checked */
    .container-chechbox input:checked ~ .checkmark:after {
        display: block;
    }

    /* Style the checkmark/indicator */
    .container-chechbox .checkmark:after {
        left: 10px;
        top: 6px;
        width: 5px;
        height: 10px;
        border: solid white;
        border-width: 0 3px 3px 0;
        -webkit-transform: rotate(45deg);
        -ms-transform: rotate(45deg);
        transform: rotate(45deg);
    }
    .coret-text{
        text-decoration: line-through;
    }
</style>
<!-- shop section -->
<section class="shop_section" style="margin-bottom: 200px; margin-top: 50px;">
    <div class="container">
        <div class="row">
            <div class="col-sm-8">
                <div class="card">
                    <div class="card-body">
                        @if( session('msg') )
                        <?php
                        $msg = session('msg');
                        ?>
                        <div class="row">
                            <div class="col-sm-12 text-center pb-3">
                                <div class="badge alert-{{ $msg['type'] }} alert-remove">
                                    {!! $msg['text'] !!}
                                </div>
                            </div>
                        </div>
                        @endif
                        <form action="" method="POST">
                            @csrf
                            <h6><b>Keranjang</b></h6>
                            @if(count($keranjang) > 0)
                            <div class="">
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <td width="15%" class="text-center">
                                                <label class="container-chechbox">Semua
                                                    <input type="checkbox" id="select_all_keranjang" onclick="selectAll()">
                                                    <span class="checkmark"></span>
                                                </label>
                                            </td>
                                            <td class="text-center">
                                                Pesanan
                                            </td>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($keranjang as $row)
                                        <tr style="display: show;" id="display-ada-{{ $row->id }}">
                                            <td class="text-center">
                                                <label class="container-chechbox">
                                                    <input type="checkbox" class="checked" name="id" value="{{ $row->id }}" id="cb-{{ $row->id }}" onclick="setChekedSingle('{{ $row->id }}', 'single')">
                                                    <span class="checkmark"></span>
                                                </label>
                                            </td>
                                            <td>
                                                <div class="row">
                                                    <div class="col-sm-3">
                                                        @if($row->Produk->foto)
                                                        <img src="{{ asset($row->Produk->foto) }}" width="100px">
                                                        @else
                                                        <img src="{{ asset('no-foto.png') }}" width="100px">
                                                        @endif
                                                    </div>
                                                    <div class="col-sm-9">
                                                        {{ $row->Produk->nama }} <br>
                                                        @if(count($row->Produk->Diskon) > 0)
                                                        <small>Rp</small><span style="text-decoration: line-through; font-size:10px">{{ number_format($row->Produk->harga,0,'.','.') }}</span>
                                                        <small>Rp</small><h3 class="d-inline">{{ number_format($row->Produk->harga-$row->Produk->Diskon[0]->harga,0,'.','.') }}</h3>
                                                        @else
                                                        <span>
                                                            <small>Rp</small>{{ number_format($row->Produk->harga,0,'.','.') }}
                                                        </span>
                                                        @endif
                                                        <br>
                                                        <small>
                                                            @if( $row->Produk->stok <= 0)
                                                                Stok Kosong
                                                            @else
                                                                Stok Tersedia : {{ $row->Produk->stok }} {{ $row->Produk->Kategori->satuan }}
                                                            @endif
                                                            <br>
                                                            @if($row->Produk->kategori_id == 2)
                                                                {{ $row->warna_id ? $row->Warna->nama : 'Warna Random' }}
                                                            @endif
                                                        </small>
                                                    </div>
                                                    <div class="col-sm-12">
                                                        <div class="float-left">
                                                            <small>Catatan : {{ $row->catatan }}</small>
                                                        </div>
                                                        <div class="float-right">
                                                            <a href="{{ route('keranjang.delete', $row->id) }}" class="mr-5 btn">
                                                                <i class="fa fa-trash-o" aria-hidden="true" style="color: gray;"></i>
                                                            </a>
                                                            <a id="minus" class="btn btn-sm" type="button" onclick="minus('{{ $row->id }}')">
                                                                <i class="fa fa-minus-circle" aria-hidden="true" style="color: gray;"></i>
                                                            </a>
                                                            <input type="text" name="jumlah" class="input-jumlah" id="text-jumlah-{{ $row->id }}" onkeypress="return event.charCode >= 48 && event.charCode <=57" oninput="getHargaTotalOnInput('{{ $row->id }}')">
                                                            <a id="plus" class="btn btn-sm" type="button" onclick="plus('{{ $row->id }}')">
                                                                <i class="fa fa-plus-circle" aria-hidden="true" style="color: green;"></i>
                                                            </a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                            @else
                            <div class="row">
                                <div class="col-sm-12 text-center">
                                    <img src="{{ asset('order.png') }}" width="300px"> <br><br>
                                    <h5>Keranjang Kosong !</h5> <a href="{{ route('show.produk.by.kategori', 'N42353ks') }}" class="btn btn-sm" style="background-color: #3b4a6b; color: white;">Belanja Sekarang</a>
                                </div>
                            </div>
                            @endif
                        </form>
                    </div>
                </div>
            </div>
            <div class="col-sm-4">
                <div class="card">
                    <div class="card-body">
                        <h6><b>Ringkasan Belanja</b></h6>
                        <!-- <form action="{{ route('pembelian.store') }}" method="POST"> -->
                            <!-- @csrf -->
                            <input type="hidden" name="sub_total" id="store-sub-total-harga">
                            <input type="hidden" name="total_bayar" id="store-total-harga">
                            <input type="hidden" name="total_ongkir" id="store-ongkir">
                            @foreach($keranjang as $row)
                                <div id="show-{{ $row->id }}" style="display: none;">
                                    <div class="float-left" style="font-size: 13px; color: #ccc;" id="nama-{{ $row->id }}">
                                        @if(strlen($row->Produk->nama) > 30)
                                        {{ substr(strtolower($row->Produk->nama), 0, 20) }}..
                                        @else
                                        {{ strtolower($row->Produk->nama) }}
                                        @endif
                                    </div>
                                    <div class="float-right" style="font-size: 13px; color: #ccc" id="harga-produk-{{ $row->id }}">Rp0</div>
                                    <br>
                                </div>
                            @endforeach
                            <br>
                            <div class="form-group d-block">
                                <div class="float-left" style="font-size: 14px; color: #000" id="sub_total_barang">Sub Total Harga (0 Barang)</div>
                                <div class="float-right" style="font-size: 14px; color: #000" id="sub_total">Rp0</div>
                            </div>
                            <div class="form-group d-block">
                                <div style="display: none;" id="ongkir">
                                    <div class="float-left" style="font-size: 14px; color: #000" id="ongkos_kirim">Ongkos Kirim</div>
                                    <div class="float-right" style="font-size: 14px; color: #000" id="total_ongkir">Rp0</div>
                                    <div class="float-right mr-2" style="font-size: 14px; color: #000" id="rp0">Rp0</div>
                                </div>
                                <div style="display: none;" id="onsite">
                                    <div class="float-left" style="font-size: 14px; color: #000" id="ongkos_kirim">Pengambilan Barang Langsung Ke Toko</div>
                                </div>
                            </div>
                            <br>
                            <hr style="margin-top: 10px;">
                            <div class="form-group d-block">
                                <div class="float-left"><strong id="total_barang">Total Harga (0 Barang)</strong></div>
                                <div class="float-right"><strong id="total">Rp0</strong></div>
                            </div>
                            <br>
                            <div class="form-group mt-3">
                                <div class="alert btn-info" style="font-size: 11px;">
                                    *gratis ongkir dengan minimal pembelian > Rp. 500.000,-
                                </div>
                            </div>
                            <div class="form-group mt-3">
                                <a href="{{ route('keranjang.checkout') }}" class="form-control btn btn-sm" style="background-color: #3b4a6b; color: white; display: none;" id="btn_total_beli">Beli (0)</a>
                            </div>
                        <!-- </form> -->
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- end shop section -->

@endsection
@push('js')
<script src="{{ asset('js/select2.full.min.js') }}"></script>
<script>

    $(document).ready(function(){
        $('#selectwarna').select2();
        getKeranjang();
    });

    function plus(keranjang_id){
        let jumlah = parseInt($("#text-jumlah-"+keranjang_id).val())+1;
        generateHargaTotal(keranjang_id, jumlah);
    }

    function minus(keranjang_id){
        let jumlah = parseInt($("#text-jumlah-"+keranjang_id).val())-1;
        generateHargaTotal(keranjang_id, jumlah);
    }

    function generateHargaTotal(keranjang_id, jumlah) {

        $.get("{{ route('get.harga.total.keranjang') }}",
        {
            jumlah,
            keranjang_id : keranjang_id
        },
        function(res){
            getKeranjang();
        },'json');

    }

    function getHargaTotalOnInput(keranjang_id) {
        if ($("#text-jumlah-"+keranjang_id).val() == '') {
            $("#text-jumlah-"+keranjang_id).value = 1;
        }
        generateHargaTotal(keranjang_id, $("#text-jumlah-"+keranjang_id).val());
    }

    function getKeranjang() {
        $.get("{{ route('get.keranjang') }}",
        {
            id : null
        },
        function(res){
            let jumlah_checked = [];
            res.keranjang.forEach( function(row, index) {
                document.getElementById("text-jumlah-"+row.id).value = row.jumlah;
                if (row.status == 0) {
                    document.getElementById("cb-"+row.id).checked = false;
                    $('#show-'+row.id).hide();
                }else{
                    $('#show-'+row.id).show();
                    document.getElementById("cb-"+row.id).checked = true;
                    document.getElementById("harga-produk-"+row.id).innerHTML = row.harga;
                    jumlah_checked.push(row.id);
                }
            });

            if (res.jumlah_barang >= 1) {
                $('#btn_total_beli').show();
            }else{
                $('#btn_total_beli').hide();
            }

            if (jumlah_checked.length == res.keranjang.length) {
                document.getElementById("select_all_keranjang").checked = true;
            }else{
                document.getElementById("select_all_keranjang").checked = false;
            }

            if (res.produk_stok_kosong > 0 || res.jumlah_barang <= 0) {
                $('#btn_total_beli').hide();
                $('#onsite').hide();
                $('#ongkir').hide();
            }else{
                $('#btn_total_beli').show();

                if (res.total_harga >= 150000 && res.isOngkir == true)
                {
                    $('#ongkir').show();
                    $('#onsite').hide();
                    $('#rp0').hide();
                    document.getElementById("total_ongkir").classList.remove("coret-text");
                    document.getElementById('total_ongkir').innerHTML = res.total_ongkir_view;
                }
                else if(res.total_harga >= 150000 && res.isOngkir == false)
                {
                    $('#ongkir').show();
                    $('#onsite').hide();
                    $('#rp0').show();
                    document.getElementById("total_ongkir").classList.add("coret-text");
                    document.getElementById('total_ongkir').innerHTML = res.total_ongkir_view;
                }
                else{
                    document.getElementById("total_ongkir").classList.remove("coret-text");
                    document.getElementById('total_ongkir').innerHTML = res.total_ongkir_view;
                    $('#rp0').hide();
                    $('#ongkir').show();
                    $('#onsite').hide();
                }
            }

            document.getElementById("keranjang_count").innerHTML = res.keranjang_count;

            document.getElementById("sub_total_barang").innerHTML = 'Sub Total Harga ('+res.jumlah_barang+' Barang)';
            document.getElementById("sub_total").innerHTML = res.sub_total_view;
            document.getElementById("btn_total_beli").innerHTML = 'Beli ('+res.jumlah_barang+')';
            document.getElementById("total_barang").innerHTML = 'Total Bayar ('+res.jumlah_barang+' Barang)';
            document.getElementById("total").innerHTML = res.total_bayar_view;

            document.getElementById("store-sub-total-harga").value = res.total_harga;
            document.getElementById("store-sub-total-harga").value = res.total;
        },'json');
    }

    function setChekedSingle(keranjang_id, status) {

        let request = null;
        if (document.getElementById("cb-"+keranjang_id).checked) {
            request = true;
        }else{
            request = false;
        }

        $.get("{{ route('set.checked') }}",
        {
            keranjang_id : keranjang_id,
            status : status,
            is_checked : request
        },
        function(res){
            getKeranjang();
        },'json');
    }

    function setChekedAll(keranjang_id = null, status) {

        let request = null;
        if (document.getElementById("select_all_keranjang").checked) {
            request = 0;
        }else{
            request = 1;
        }

        console.log('request', request);

        $.get("{{ route('set.checked') }}",
        {
            keranjang_id : keranjang_id,
            status : status,
            is_checked : request
        },
        function(res){
            getKeranjang();
        },'json');
    }


    function selectAll() {
        var blnChecked = document.getElementById("select_all_keranjang").checked;
        var checked_keranjang = document.getElementsByClassName("checked");
        var intLength = checked_keranjang.length;
        for(var i = 0; i < intLength; i++) {
            var checked = checked_keranjang[i];
            checked.checked = blnChecked;
        }

        setChekedAll('all');
    }
</script>
@endpush
