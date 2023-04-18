<footer class="footer_section">
    <div class="container">
        <div class="row">
            <div class="col-md-6 col-lg-4 footer-col">
                <div class="footer_detail">
                    <h4>
                        Tentang
                    </h4>
                    <p>
                        @if($about)
                        {!! $about->value->description !!}
                        @else
                        Lorem ipsum, dolor sit amet consectetur adipisicing elit. Ipsam hic incidunt exercitationem, odit non dolorum repellat expedita atque tempore vero recusandae. Earum, voluptates amet porro commodi voluptatem ducimus explicabo doloribus? It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem Ipsum is that it has a more-or-less normal distribution of letters, as opposed to using Content here, content here, making it look like readable English. Many desktop publishing packages and web page editors now use Lorem Ipsum as their default model text, and a search for lorem ipsum will uncover many web sites still in their infancy. Various versions have evolved over the years, sometimes by accident, sometimes on purpose (injected humour and the like).
                        @endif
                    </p>
                    <div class="footer_social">
                        <a href="{{ $social->value->facebook->link }}">
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
                        </a>
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-lg-4 footer-col">
                <div class="footer_contact">
                    <h4>
                        Kontak Kami
                    </h4>
                    <div class="contact_link_box">
                        <a href="#">
                            <i class="fa fa-phone" aria-hidden="true"></i>
                            <span>
                                Call +62 82129960156
                            </span>
                        </a>
                        <a href="#">
                            <i class="fa fa-envelope" aria-hidden="true"></i>
                            <span>
                                tzm.tanjungzahramotor@gmail.com
                            </span>
                        </a>
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-lg-4 footer-col text-center">
                <div class="footer_contact">
                    <img src="{{ asset('icon-belanja.png') }}" width="300px"> <br>
                    <small>&copy; <span id="displayYear"></span> TZM Tanjung Zahra Motor</small>
                </div>
            </div>
        </div>
    </div>
</footer>