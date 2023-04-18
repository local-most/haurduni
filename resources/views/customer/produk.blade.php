@extends('layouts.home')
@section('title', 'Home')
@section('content')
<!-- shop section -->
<section class="shop_section" style="padding-top: 20px; padding-bottom: 100px;">
    <div class="container">
        <!-- ================================================================ -->
        <!-- ==================== UNTUK SINGLE KATEGOIRi ==================== -->
        <!-- ================================================================ -->
        @if($status == 'single-kategori')
        <div class="heading_container heading_center">
            <h2>
                {{ $kategori->nama }}
            </h2>
        </div>
        <div class="row">
            @if(count($produk) > 0)
                @foreach($produk as $row)
                <div class="col-sm-6 col-xl-3">
                    <div class="box">
                        <a href="{{ route('show.produk.single', $row->id) }}">
                            <div class="img-box">
                                @if($row->foto)
                                    <img src="{{ asset($row->foto) }}" alt="">
                                @else
                                    <img src="{{ asset('timups/images/a.png') }}" alt="">
                                @endif
                            </div>
                            <div class="text-center">
                                <small>
                                    @if(strlen($row->nama) > 30)
                                        {{ substr($row->nama, 0, 28) }}..
                                    @else
                                        {{ $row->nama }}
                                    @endif
                                </small>
                                <h6>
                                    <br>
                                    <br>
                                    @if(count($row->Diskon) > 0)
                                    <small>Rp</small><span style="text-decoration: line-through; font-size:10px">{{ number_format($row->harga,0,'.','.') }}</span>
                                    <small>Rp</small>{{ number_format($row->harga-$row->Diskon[0]->harga,0,'.','.') }}
                                    @else
                                    <span>
                                        <small>Rp</small>{{ number_format($row->harga,0,'.','.') }}
                                    </span>
                                    @endif
                                </h6>
                            </div>
                            @if($row->created_at)
                                <div class="new">
                                    <span>
                                        Baru
                                    </span>
                                </div>
                            @endif
                        </a>
                    </div>
                </div>
                @endforeach
            @else
                <div class="row">
                    <div class="col-sm-12">
                        <div class="badge alert-danger">
                            Produk untuk saat ini masih kosong !
                        </div>
                    </div>
                </div>
            @endif
        </div>

        @else
        <!-- ================================================================ -->
        <!-- ==================== UNTUK MULTI KATEGOIRi ==================== -->
        <!-- ================================================================ -->

        @foreach($kategori as $row_kategori)
            @if(count($row_kategori->Produk) > 0)
            <div class="container" style="margin-top: 30px; padding-bottom: 0;">
                <div class="heading_container heading_center">
                    <h2>
                        {{ $row_kategori->nama }}
                    </h2>
                </div>
                <div class="row">
                        @foreach($row_kategori->Produk as $row)
                        <div class="col-sm-6 col-xl-3">
                            <div class="box">
                                <a href="{{ route('show.produk.single', $row->id) }}">
                                    <div class="img-box">
                                        @if($row->foto)
                                            <img src="{{ asset($row->foto) }}" alt="">
                                        @else
                                            <img src="{{ asset('timups/images/a.png') }}" alt="">
                                        @endif
                                    </div>
                                    <div class="text-center">
                                        <small>
                                            @if(strlen($row->nama) > 30)
                                                {{ substr($row->nama, 0, 28) }}..
                                            @else
                                                {{ $row->nama }}
                                            @endif
                                        </small>
                                        <h6>
                                            <br>
                                            <br>
                                            <span>
                                                <small class="d-inline">Rp</small><h5 class="d-inline">{{ number_format($row->harga, 0,'.','.') }}</h5>
                                            </span>
                                        </h6>
                                    </div>
                                    @if($row->created_at)
                                        <?php
                                            $tgl_create = date('Y-m-d', strtotime($row->created_at));
                                            $tgl_sekarang = date('Y-m-d', strtotime(date('Y-m-d') . ' +3 day'));
                                        ?>
                                    @if(strtotime($tgl_create) < strtotime($tgl_sekarang))
                                        <div class="new">
                                            <span>
                                                Baru
                                            </span>
                                        </div>
                                    @endif
                                    @endif
                                </a>
                            </div>
                        </div>
                        @endforeach
                </div>
            </div>
            @endif
        @endforeach

        @endif
    </div>
</section>
<!-- end shop section -->

@endsection