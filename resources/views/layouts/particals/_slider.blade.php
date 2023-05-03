<div class="hero_area">
    <div class="hero_social">
        <!-- <a href="{{ $social->value->facebook->link }}">
            <i class="fa fa-facebook" aria-hidden="true"></i>
        </a>
        <a href="{{ $social->value->twitter->link }}">
            <i class="fa fa-twitter" aria-hidden="true"></i>
        </a>
        <a href="{{ $social->value->youtube->link }}">
            <i class="fa fa-youtube" aria-hidden="true"></i>
        </a>
        <a href="{{ $social->value->instagram->link }}">
            <i class="fa fa-instagram" aria-hidden="true"></i>
        </a> -->
    </div>
    <!-- slider section -->
    <section class="slider_section">
        <div id="customCarousel1" class="carousel slide" data-ride="carousel">
            <div class="carousel-inner">
                <div class="carousel-item active">
                    <div class="container-fluid ">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="detail-box">
                                    <h1>
                                        Cari Speapart Original ?
                                    </h1>
                                    <p>
                                        @if($about)
                                        {!! $about->value->description !!}
                                        @else
                                        Lorem ipsum, dolor sit amet consectetur adipisicing elit. Ipsam hic incidunt exercitationem, odit non dolorum repellat
                                        expedita atque tempore vero recusandae.
                                        @endif
                                    </p>
                                    <div class="btn-box">
                                        <a href="https://wa.wizard.id/06e7e6" target="_blank" class="btn1">
                                            Hubungi Kami
                                        </a>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="img-box">
                                    <img src="{{ asset('timups/images/slide1.png') }}" alt="">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="carousel-item">
                    <div class="container-fluid ">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="detail-box">
                                    <h1>
                                        100% Sparepart Original
                                    </h1>
                                    <p>
                                        Lorem ipsum dolor sit amet consectetur adipisicing elit. Maxime id aspernatur repudiandae aut cupiditate error, earum corrupti illum omnis tenetur ipsa nemo, dolorem delectus consequatur nam tempora voluptate nisi suscipit!
                                    </p>
                                    <div class="btn-box">
                                        <a href="https://wa.wizard.id/06e7e6" target="_blank" class="btn1">
                                            Pesan Sekarang
                                        </a>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="img-box">
                                    <img src="{{ asset('timups/images/slide3.png') }}" alt="">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="carousel-item">
                    <div class="container-fluid ">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="detail-box">
                                    <h1>
                                        Haurduni Motor
                                    </h1>
                                    <p>
                                        Lorem, ipsum dolor sit amet consectetur adipisicing elit. Quibusdam voluptatum consequatur id voluptatibus at quis, natus, labore praesentium vel repudiandae incidunt minima quam atque quaerat eius possimus! Ab, excepturi incidunt?
                                    </p>
                                    <div class="btn-box">
                                        <a href="https://wa.wizard.id/06e7e6" target="_blank" class="btn1">
                                            WhatsApp
                                        </a>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="img-box">
                                    <img src="{{ asset('images/logo.png') }}" alt="">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <ol class="carousel-indicators">
                <li data-target="#customCarousel1" data-slide-to="0" class="active"></li>
                <li data-target="#customCarousel1" data-slide-to="1"></li>
                <li data-target="#customCarousel1" data-slide-to="2"></li>
            </ol>
        </div>
    </section>
    <!-- end slider section -->
</div>
