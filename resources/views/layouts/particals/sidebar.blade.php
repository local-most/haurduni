<aside class="main-sidebar sidebar-dark-orange elevation-4">
    <a href="{{ route('dashboard') }}" class="brand-link navbar-orange">
        <strong>TZM</strong>
        <span class="brand-text font-weight-light text-light">Administrator</span>
    </a>

    <div class="sidebar">
        <nav class="mt-2">
            @php $adminPrefix = 'admin' @endphp
            <ul class="nav nav-pills nav-sidebar flex-column nav-legacy" data-widget="treeview" role="menu" data-accordion="false">
                <li class="nav-header">Menu Utama</li>
                <li class="nav-item">
                    <a href="{{ route('dashboard') }}" class="nav-link {{ request()->is('dashboard') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-tachometer-alt"></i>
                        <p>Dashboard</p>
                    </a>
                </li>
                @if(in_array(auth()->user()->role, [1]))
                <li class="nav-item">
                    <a href="{{ route('admin.kategori') }}" class="nav-link {{ request()->is($adminPrefix.'/kategori*') ? 'active' : '' }}">
                        <i class="nav-icon fa fa-microchip"></i>
                        <p>Kategori</p>
                    </a>
                </li>
                <!-- <li class="nav-item">
                    <a href="{{ route('admin.satuan') }}" class="nav-link {{ request()->is($adminPrefix.'/satuan*') ? 'active' : '' }}">
                        <i class="nav-icon fa fa-balance-scale"></i>
                        <p>Satuan</p>
                    </a>
                </li> -->
                <li class="nav-item">
                    <a href="{{ route('admin.produk') }}" class="nav-link {{ request()->is($adminPrefix.'/produk*') ? 'active' : '' }}">
                        <i class="nav-icon fa fa-home"></i>
                        <p>Produk</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('admin.wilayah') }}" class="nav-link {{ request()->is($adminPrefix.'/wilayah*') ? 'active' : '' }}">
                        <i class="nav-icon fa fa-map-marker"></i>
                        <p>Wilayah</p>
                    </a>
                </li>
                <!-- <li class="nav-item">
                    <a href="{{ route('admin.whatsapp') }}" class="nav-link {{ request()->is($adminPrefix.'/whatsapp*') ? 'active' : '' }}">
                        <i class="nav-icon fa fa-envelope-open"></i>
                        <p>Whatsapp</p>
                    </a>
                </li> -->
                <!-- <li class="nav-item">
                    <a href="{{ route('admin.warna') }}" class="nav-link {{ request()->is($adminPrefix.'/warna*') ? 'active' : '' }}">
                        <i class="nav-icon fa fa-flask"></i>
                        <p>Warna</p>
                    </a>
                </li> -->
                <li class="nav-item">
                    <a href="{{ route('admin.pengaturan') }}" class="nav-link {{ request()->is($adminPrefix.'/pengaturan*') ? 'active' : '' }}">
                        <i class="nav-icon fa fa-cogs"></i>
                        <p>Pengaturan</p>
                    </a>
                </li>
                <li class="nav-header">Akun</li>
                <li class="nav-item">
                    <a href="{{ route('admin.user') }}" class="nav-link {{ request()->is($adminPrefix.'/user*') ? 'active' : '' }}">
                        <i class="nav-icon fa fa-users"></i>
                        <p>User</p>
                    </a>
                </li>
                <li class="nav-header">Pesanan</li>
                <li class="nav-item">
                    <li class="nav-item">
                        <a href="{{ route('admin.daftar-pesanan') }}" class="nav-link {{ request()->is($adminPrefix.'/daftar-pesanan*') ? 'active' : '' }}">
                            <i class="fa fa-inbox nav-icon"></i>
                            <p>Pesanan Baru</p>
                            @if($pesanan_baru_count > 0)
                                <span class="badge badge-info right">{{ $pesanan_baru_count }}</span>
                            @endif
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('admin.pesanan-diterima') }}" class="nav-link {{ request()->is($adminPrefix.'/pesanan-diterima*') ? 'active' : '' }}">
                            <i class="fa fa-check-square nav-icon"></i>
                            <p>Pesanan Diterima</p>
                            @if($pesanan_diterima_count > 0)
                                <span class="badge badge-info right">{{ $pesanan_diterima_count }}</span>
                            @endif
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('admin.pesanan-dibatalkan') }}" class="nav-link {{ request()->is($adminPrefix.'/pesanan-dibatalkan*') ? 'active' : '' }}">
                            <i class="fa fa-exclamation-circle nav-icon"></i>
                            <p>Batal Pesanan</p>
                            @if($pesanan_dibatalkan_count > 0)
                                <span class="badge badge-info right">{{ $pesanan_dibatalkan_count }}</span>
                            @endif
                        </a>
                    </li>
                </li>
                @endif
                @if(in_array(auth()->user()->role, [1,3]))
                <li class="nav-header">Laporan</li>
                <li class="nav-item">
                    <li class="nav-item">
                        <a href="{{ route('laporan.transaksi') }}" class="nav-link {{ request()->is('laporan*') ? 'active' : '' }}">
                            <i class="fa fa-book nav-icon"></i>
                            <p>Transaksi</p>
                        </a>
                    </li>
                </li>
                @endif
            </ul>
        </nav>
    </div>
</aside>