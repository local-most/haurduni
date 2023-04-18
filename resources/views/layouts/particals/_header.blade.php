<style>
    .dropdown {
        /*position: static !important;*/
    }

    .dropdown-menu {
        /*box-shadow: 0 .5rem 1rem rgba(0, 0, 0, .15)!important;*/
        /*margin-top: 0px !important;*/
        /*width: 100% !important;*/
    }
    .header_section {
        box-shadow: 0 .1rem 3rem rgba(0, 0, 0, .10)!important;
        width: 100% !important;
    }
    .image-cropper {
        position: relative;
        overflow: hidden;
        border-radius: 50%;
    }
</style>
<header class="header_section">
    <div class="container-fluid">
        <nav class="navbar navbar-expand-lg custom_nav-container ">
            <a class="navbar-brand" href="{{ route('home') }}">
                <span style="font-size: 20px;">
                    <img src="{{ asset('images/logo.png') }}" style="width: 250px;">
                </span>
            </a>

            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class=""> </span>
            </button>

            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a style="color: #3b4a6b;" class="nav-link" href="{{ route('home') }}"><small>
                            @if(request()->is('/'))
                            <b>Home</b>
                            @else
                            Home
                            @endif
                        </small></a>
                    </li>
                    <!-- <li class="nav-item">
                        <div class="dropdown">
                            <a style="color: #3b4a6b;" class="nav-link dropdown-toggle" href="watches.html" data-toggle="dropdown"> Belanja </a>
                            <span class="caret"></span></button>
                            <div class="dropdown-menu" aria-labelledby="navbarDropdown" style="max-width: 1366px; color: #3b4a6b;">
                                @foreach($kategori as $row)
                                <a class="dropdown-item" href="{{ route('show.produk.by.kategori', $row->id) }}">
                                    {{ $row->nama }}
                                </a>
                                @endforeach
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item" href="{{ route('show.produk.by.kategori', 'Ndca46jso') }}">
                                    Lihat Semua
                                </a>
                            </div>
                        </div>
                    </li> -->
                    @foreach($kategori as $row)
                    <li class="nav-item">
                        <a style="color: #3b4a6b;" class="nav-link" href="{{ route('show.produk.by.kategori', $row->id) }}">
                            <small>
                                @if(request()->is('kategori/'.$row->id))
                                <b>{{ $row->nama }}</b>
                                @else
                                {{ $row->nama }}
                                @endif
                            </small>
                        </a>
                    </li>
                    @endforeach
                </ul>
                <div class="user_option-box">
                    @if(auth()->user())
                    <?php
                    $keranjang = \App\Models\Keranjang::where('user_id', auth()->user()->id)->get();

                    $keranjangList = [];
                    foreach($keranjang as $ker){
                        $keranjangList[] = $ker->jumlah;
                    }

                    $keranjang_count = array_sum($keranjangList);

                    $status = [
                        statusOrder('selesai-order'),
                        statusOrder('dibatalkan'),
                        statusOrder('selesai-dibatalkan')
                    ];

                    $order = \App\Models\Order::where('user_id', auth()->user()->id);

                    $order_count = count($order->whereNotIn('status', $status)->get());

                    $pembayaran_count = count($order->where('status', statusOrder('baru'))->whereNull('bukti_pembayaran')->get());

                    $query = \App\Models\User::where('id', auth()->user()->id);

                    $verifikasi = $query->where('validate', 1)->first();

                    $profile = $query->first();

                    $alamat = $query->whereNull('alamat')->first();
                    // $ktp = $query->whereNull('ktp')->first();
                    $foto = $query->whereNull('foto')->first();

                    if($profile){
                        if ($profile->wilayah_id == NULL || $profile->alamat == NULL || $profile->foto == NULL) {
                            $status_profile = false;
                        }else{
                            $status_profile = true;
                        }
                    }else{
                            $status_profile = false;
                    }
                    ?>
                    <a href="{{ route('keranjang') }}" style="color: #3b4a6b;">
                        <i class="fa fa-cart-plus" aria-hidden="true"></i>
                        @if($keranjang_count > 0)
                        <sup style="margin-left: 0px; color: white; font-size: 11px; background-color: red; border-radius: 50px; height: 15px;" class="badge" id="keranjang_count">
                            {{ $keranjang_count }}
                        </sup>
                        @endif
                    </a>
                    <a class="nav-link" data-toggle="dropdown" href="#" style="color: #3b4a6b;">
                        <i class="fa fa-bell" aria-hidden="true"></i>
                        @if($order_count > 0)
                        <sup style="margin-left: 0px; color: white; font-size: 11px; background-color: red; border-radius: 50px; height: 15px;" class="badge">
                            {{ $order_count }}
                        </sup>
                        @endif
                    </a>
                    <div class="dropdown-menu dropdown-menu-right" style="width: 330px !important;">
                        <div class="container">
                            <div class="row">
                                <div class="col-sm-12" style="padding-top: 10px;">
                                    <strong>Notifikasi Transaksi</strong>
                                    <hr>
                                </div>
                                <div class="col-sm-12">
                                    <div class="float-left">
                                        <small>Pembelian</small>
                                    </div>
                                    <div class="float-right">
                                        <small><a href="{{ route('pembelian.riwayat') }}?status=all" style="text-transform: capitalize; font-size: 12px; color: #3b4a6b;">Lihat Semua</a></small>
                                    </div>
                                </div>
                                <div class="col-sm-12">
                                    <a href="{{ route('pembelian.riwayat') }}?status=menunggu" style="text-transform: capitalize; font-size: 16px; color: #3b4a6b;">
                                        <div class="float-left">
                                            <small>Menunggu Pembayaran</small>
                                        </div>
                                        <div class="float-right">
                                            @if($pembayaran_count > 0)
                                            <small class="badge btn-danger">{{ $pembayaran_count > 0 ? $pembayaran_count : ''  }}</small>
                                            @endif
                                        </div>
                                    </a>
                                </div>
                                <div class="col-sm-12">
                                    <div class="row">
                                        <div class="col-sm-3 text-center">
                                            <?php
                                            $transaksi = \App\Models\Order::where('user_id', auth()->user()->id);
                                            $menunggu = count($transaksi->where('status', statusOrder('baru'))->get());
                                            ?>
                                            <a href="{{ route('pembelian.riwayat') }}?status=menunggu-konfirmasi" class="text-center">
                                                <p style="font-size: 9px; color : {{ $menunggu > 0 ? '#3b4a6b' : '#cecece' }}">
                                                    <i class="fa fa-clock-o" style="font-size: 30px;" aria-hidden="true"></i>
                                                    Menunggu Konfirmasi <br>
                                                    <small style="font-size: 12px;" class="badge">{{ $menunggu > 0 ? $menunggu : '' }}</small>
                                                </p>
                                            </a>
                                        </div>
                                        <div class="col-sm-3 text-center">
                                            <?php
                                            $transaksi = \App\Models\Order::where('user_id', auth()->user()->id);
                                            $diproses = count($transaksi->where('status', statusOrder('diproses'))->get());
                                            ?>
                                            <a href="{{ route('pembelian.riwayat') }}?status=diproses" class="text-center">
                                                <p style="font-size: 9px; color : {{ $diproses > 0 ? '#3b4a6b' : '#cecece' }}">
                                                    <i class="fa fa-hourglass-end mt-1" style="font-size: 25px;" aria-hidden="true"></i>
                                                    Pesanan Diproses <br>
                                                    <small style="font-size: 12px;" class="badge">{{ $diproses > 0 ? $diproses : '' }}</small>
                                                </p>
                                            </a>
                                        </div>
                                        <div class="col-sm-3 text-center">
                                            <?php
                                            $transaksi = \App\Models\Order::where('user_id', auth()->user()->id);
                                            $dikirim = count($transaksi->where('status', statusOrder('dikirim'))->get());
                                            ?>
                                            <a href="{{ route('pembelian.riwayat') }}?status=dikirim" class="text-center">
                                                <p style="font-size: 9px; color : {{ $dikirim > 0 ? '#3b4a6b' : '#cecece' }}">
                                                    <i class="fa fa-truck" style="font-size: 30px;" aria-hidden="true"></i>
                                                    Sedang Dikirim <br>
                                                    <small style="font-size: 12px;" class="badge">{{ $dikirim > 0 ? $dikirim : '' }}</small>
                                                </p>
                                            </a>
                                        </div>
                                        <div class="col-sm-3 text-center">
                                            <?php
                                            $transaksi = \App\Models\Order::where('user_id', auth()->user()->id);
                                            $selesai_order = count($transaksi->where('status', statusOrder('sampai'))->get());
                                            ?>
                                            <a href="{{ route('pembelian.riwayat') }}?status=sampai" class="text-center">
                                                <p style="font-size: 9px; color : {{ $selesai_order > 0 ? '#3b4a6b' : '#cecece' }}">
                                                    <i class="fa fa-map-marker" style="font-size: 30px;" aria-hidden="true"></i>
                                                    Pesanan Sampai <br>
                                                    <small style="font-size: 12px;" class="badge">{{ $selesai_order > 0 ? $selesai_order : '' }}</small>
                                                </p>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <ul class="navbar-nav">
                            <li class="nav-item">

                            </li>
                        </ul>
                    </div>
                    <ul class="navbar-nav">
                        <li class="nav-item dropdown">
                            <a class="nav-link" data-toggle="dropdown" href="#" style="color: #3b4a6b;">
                                <small>{{ auth()->user()->nama }}</small>
                                @if(auth()->user()->foto)
                                <img src="{{ asset(auth()->user()->foto) }}" class="image-cropper mb-2" width="30px" height="30px">
                                @else
                                <i class="fa fa-user"></i>
                                @endif

                                @if($status_profile == false)
                                <sup style="margin-left: 0px; color: white; font-size: 11px; background-color: red; border-radius: 50px; height: 15px;" class="badge">!</sup>
                                @endif
                            </a>
                            <div class="dropdown-menu dropdown-menu-right" style="width: 230px !important;">
                                <ul class="navbar-nav">
                                    <li class="nav-item">
                                        <a href="{{ route('profile') }}" style="text-transform: capitalize;">
                                            Profile
                                            @if($status_profile == false)
                                            <small style="margin-left: 0px; color: red; font-size: 10px; border-radius: 50px; height: 15px;" class="badge">(lengkapi)</small>
                                            @endif

                                            @if($verifikasi)
                                            <small style="margin-left: 0px; color: green; font-size: 10px; border-radius: 50px; height: 15px;" class="badge">(Terverifikasi)</small>
                                            @else
                                            <small style="margin-left: 0px; color: orange; font-size: 10px; border-radius: 50px; height: 15px;" class="badge">(Belum Terverifikasi)</small>
                                            @endif
                                        </a>
                                    </li>
                                </ul>
                                <ul class="navbar-nav pt-2">
                                    <li class="nav-item"><a href="{{ route('logout.customer') }}" style="text-transform: capitalize;">Logout</a></li>
                                </ul>
                            </div>
                        </li>
                    </ul>
                    @else
                    <a href="{{ route('login.customer') }}">
                        <small>Masuk/Daftar  </small><i class="fa fa-user" aria-hidden="true"></i>
                    </a>
                    @endif
                </div>
            </div>
        </nav>
    </div>
</header>`
