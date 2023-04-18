@extends('layouts.home')
@section('title', 'Home')
@section('content')

<style type="text/css">
    .image-produk{
        border-radius: 10%;
    }
</style>
<!-- shop section -->
<section class="shop_section layout_padding">
    <div class="container">
        <div class="heading_container heading_center">
            <h2>
                Produk Terbaru
            </h2>
        </div>
        <div class="row">
            <div class="col-md-6">
                <div class="box">
                    <a href="{{ route('show.produk.single', $produk_terbaru->id) }}">
                        <div class="img-box">
                            @if($produk_terbaru->foto)
                            <img src="{{ asset($produk_terbaru->foto) }}" width="200px" class="image-produk">
                            @else
                            <img src="{{ asset('no-foto.png') }}" width="200px" class="image-produk">
                            @endif
                        </div>
                        <div class="detail-box">
                            <h6>
                                <small>{{ ucwords(strtolower(substr($produk_terbaru->nama, 0, 15))) }}..</small>
                            </h6>
                            <h6>
                                @if(count($produk_terbaru->Diskon) > 0)
                                <small>Rp</small><span style="text-decoration: line-through; font-size:10px">{{ number_format($produk_terbaru->harga,0,'.','.') }}</span>
                                <small>Rp</small>{{ number_format($produk_terbaru->harga-$produk_terbaru->Diskon[0]->harga,0,'.','.') }}
                                @else
                                <span>
                                    <small>Rp</small>{{ number_format($produk_terbaru->harga,0,'.','.') }}
                                </span>
                                @endif
                            </h6>
                        </div>
                        <div class="new">
                            <span>
                                Baru
                            </span>
                        </div>
                    </a>
                </div>
            </div>
            @foreach($produk as $row)
            @if($row->id != $produk_terbaru->id)
            <div class="col-sm-6 col-xl-3">
                <div class="box">
                    <a href="{{ route('show.produk.single', $row->id) }}">
                        <div class="img-box">
                            @if($row->foto)
                            <img src="{{ asset($row->foto) }}" width="200px" class="image-produk">
                            @else
                            <img src="{{ asset('no-foto.png') }}" width="200px" class="image-produk">
                            @endif
                        </div>
                        <div class="detail-box">
                            <h6>
                                <small>{{ ucwords(strtolower(substr($row->nama, 0, 15))) }}..</small>
                            </h6>
                            <h6>
                                <span>
                                    <small>Rp</small>{{ number_format($row->harga,0,'.','.') }}
                                </span>
                            </h6>
                        </div>
                    </a>
                </div>
            </div>
            @endif
            @endforeach
        </div>
        <div class="btn-box">
            <a href="{{ route('show.produk.by.kategori', 'Ndca46jso') }}">
                Lihat Semua
            </a>
        </div>
    </div>
</section>
<!-- end shop section -->

<!-- about section -->
<section class="about_section layout_padding">
    <div class="container  ">
        <div class="row">
            <div class="col-md-6 col-lg-5 ">
                <div class="img-box">
                    @if($about)
                    <img src="{{ asset($about->value->images) }}" alt="">
                    @else
                    <img src="{{ asset('timups/images/b.png') }}" alt="">
                    @endif
                </div>
            </div>
            <div class="col-md-6 col-lg-7">
                <div class="detail-box">
                    <div class="heading_container">
                        <h2>
                            Tentang Kami
                        </h2>
                    </div>
                    <p>
                        @if($about)
                        {!! $about->value->description !!}
                        @else
                        Lorem ipsum, dolor sit amet consectetur adipisicing elit. Ipsam hic incidunt exercitationem, odit non dolorum repellat expedita atque tempore vero recusandae. Earum, voluptates amet porro commodi voluptatem ducimus explicabo doloribus? It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem Ipsum is that it has a more-or-less normal distribution of letters, as opposed to using Content here, content here, making it look like readable English. Many desktop publishing packages and web page editors now use Lorem Ipsum as their default model text, and a search for lorem ipsum will uncover many web sites still in their infancy. Various versions have evolved over the years, sometimes by accident, sometimes on purpose (injected humour and the like).
                        @endif
                    </p>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- end about section -->

<!-- feature section -->
<section class="feature_section layout_padding">
    <div class="container">
        <div class="heading_container">
            <h2>
                Pesan dari Sekarang
            </h2>
            <p>
                Belanja lebih dari Rp150.000, barang kami antar dengan ongkos kirim terjangkau
            </p>
        </div>
        <div class="row">
            <div class="col-sm-6 col-lg-3">
                <div class="box" style="height: 286px;">
                    <div class="img-box">
                        <i class="fa fa-clock-o" style="font-size: 80px;" aria-hidden="true"></i>
                    </div>
                    <div class="detail-box">
                        <h5>
                            Menunggu <br> Konfirmasi
                        </h5>
                        <p>
                            <small>Dengan melakukan pembayaran via tranfer, kami akan langsung melakukan konfirmasi pembayaran</small>
                        </p>
                    </div>
                </div>
            </div>
            <div class="col-sm-6 col-lg-3">
                <div class="box" style="height: 286px;">
                    <div class="img-box">
                        <i class="fa fa-hourglass-end mt-1" style="font-size: 77px;" aria-hidden="true"></i>
                    </div>
                    <div class="detail-box">
                        <h5>
                            Pesanan <br> Diproses
                        </h5>
                        <p>
                            <small>Pesanan akan kami proses dengan melakukan pengecekan barang terlebih dahulu.</small>
                        </p>
                    </div>
                </div>
            </div>
            <div class="col-sm-6 col-lg-3">
                <div class="box" style="height: 286px;">
                    <div class="img-box">
                        <i class="fa fa-truck" style="font-size: 80px;" aria-hidden="true"></i>
                    </div>
                    <div class="detail-box">
                        <h5>
                            Dikirim <br> Ke lokasi
                        </h5>
                        <p>
                            <small>Pesanan akan dikirimkan sampai ke tempat lokasi kamu berada</small>
                        </p>
                    </div>
                </div>
            </div>
            <div class="col-sm-6 col-lg-3">
                <div class="box" style="height: 286px;">
                    <div class="img-box">
                        <i class="fa fa-map-marker" style="font-size: 80px;" aria-hidden="true"></i>
                    </div>
                    <div class="detail-box">
                        <h5>
                            Sampai <br> Ke lokasi
                        </h5>
                        <p>
                            <small>Pesanan yakin sampai ke tujuan dengan selamat</small>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- end feature section -->

<!-- contact section -->
<!-- <section class="contact_section">
    <div class="container">
        <div class="row">
            <div class="col-md-6">
                <div class="form_container">
                    <div class="heading_container">
                        <h2>
                            Kontak Kami
                        </h2>
                    </div>
                    <form action="">
                        <div>
                            <input type="text" placeholder="Nama Lengkap"/>
                        </div>
                        <div>
                            <input type="email" placeholder="Email"/>
                        </div>
                        <div>
                            <input type="text" placeholder="No HP"/>
                        </div>
                        <div>
                            <input type="text" class="message-box" placeholder="Message"/>
                        </div>
                        <div class="d-flex">
                            <button>
                                Kirim
                            </button>
                        </div>
                    </form>
                </div>
            </div>
            <div class="col-md-6">
                <div class="img-box">
                    <img src="{{ asset('timups/images/contact-img.jpg') }}" alt="">
                </div>
            </div>
        </div>
    </div>
</section> -->
<!-- end contact section -->

<!-- client section -->
<!-- <section class="client_section layout_padding">
    <div class="container">
        <div class="heading_container heading_center">
            <h2>
                Testimonial
            </h2>
        </div>
        <div class="carousel-wrap">
            <div class="owl-carousel client_owl-carousel">
                <div class="item">
                    <div class="box">
                        <div class="img-box">
                            <img src="{{ asset('timups/images/c1.jpg') }}" alt="">
                        </div>
                        <div class="detail-box">
                            <div class="client_info">
                                <div class="client_name">
                                    <h5>
                                        Mark Thomas
                                    </h5>
                                    <h6>
                                        Customer
                                    </h6>
                                </div>
                                <i class="fa fa-quote-left" aria-hidden="true"></i>
                            </div>
                            <p>
                                Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut
                                labore
                                et
                                dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut
                                aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse
                                cillum
                                dolore eu fugia
                            </p>
                        </div>
                    </div>
                </div>
                <div class="item">
                    <div class="box">
                        <div class="img-box">
                            <img src="{{ asset('timups/images/c2.jpg') }}" alt="">
                        </div>
                        <div class="detail-box">
                            <div class="client_info">
                                <div class="client_name">
                                    <h5>
                                        Alina Hans
                                    </h5>
                                    <h6>
                                        Customer
                                    </h6>
                                </div>
                                <i class="fa fa-quote-left" aria-hidden="true"></i>
                            </div>
                            <p>
                                Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut
                                labore
                                et
                                dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut
                                aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse
                                cillum
                                dolore eu fugia
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section> -->
<!-- end client section -->
@endsection
