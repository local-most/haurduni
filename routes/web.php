<?php

use Illuminate\Support\Facades\Route;

Route::get('/storage-link', function() {
	$exitCode = Artisan::call('storage:link');
});
Route::get('/clear', function() {
    $exitCode = Artisan::call('cache:clear');
    $exitCode = Artisan::call('view:clear');
    $exitCode = Artisan::call('config:clear');
    
    return 'cleared!';
});

/*
|--------------------------------------------------------------------------
| Auth Register Customer Routes
|--------------------------------------------------------------------------
|
*/

Route::get('/register', 'Customer\Auth\RegisterController@index')->name('register.customer');
Route::post('/register/proses', 'Customer\Auth\RegisterController@register')->name('register.customer.proses');
Route::get('/register/cek-username', 'Customer\Auth\RegisterController@cekUsername')->name('cek.username.customer');
Route::post('register/verifikasi', 'Customer\Auth\RegisterController@verifikasi')->name('register.customer.verifikasi');

Route::group(['middleware' => ['auth.customer.home']], function (){

    /*
    |--------------------------------------------------------------------------
    | HOME Customer Routes
    |--------------------------------------------------------------------------
    |
    */
    Route::get('/', 'Customer\HomeController@index')->name('home');
    Route::get('/kategori/{id}', 'Customer\HomeController@showProduk')->name('show.produk.by.kategori');
    Route::get('/produk/{id}', 'Customer\HomeController@showProdukSingle')->name('show.produk.single');
    Route::get('/get-harga-total', 'Customer\HomeController@getHargaTotal')->name('get.harga.total');
    Route::get('get-warna', 'Customer\PembelianController@getWarna')->name('get.warna');

    /*
    |--------------------------------------------------------------------------
    | Auth Login Customer Routes
    |--------------------------------------------------------------------------
    |
    */
    Route::get('/login', 'Customer\Auth\LoginController@showLoginForm')->name('login.customer');
    Route::get('customer/logout', 'Customer\Auth\LoginController@logout')->name('logout.customer');
    Route::post('customer/login/proses', 'Customer\Auth\LoginController@login')->name('login.customer.proses');

    Route::group(['middleware' => ['auth.customer']], function (){

        Route::get('profile', 'Customer\ProfileController@index')->name('profile');
        Route::put('profile/update/{id}', 'Customer\ProfileController@update')->name('profile.update');

        Route::get('keranjang', 'Customer\KeranjangController@index')->name('keranjang');
        Route::get('get-keranjang', 'Customer\KeranjangController@getKeranjang')->name('get.keranjang');
        Route::get('set-checked', 'Customer\KeranjangController@setChecked')->name('set.checked');
        Route::get('/get-harga-total-keranjang', 'Customer\KeranjangController@getHargaTotalKeranjang')->name('get.harga.total.keranjang');
        Route::post('keranjang/beli', 'Customer\KeranjangController@store')->name('keranjang.beli');
        Route::get('keranjang/{id}/delete', 'Customer\KeranjangController@delete')->name('keranjang.delete');

        Route::get('keranjang/checkout', 'Customer\KeranjangController@checkout')->name('keranjang.checkout');

        Route::post('pembelian/store', 'Customer\PembelianController@store')->name('pembelian.store');
        Route::get('pembelian/pembayaran', 'Customer\PembelianController@index')->name('pembelian.index');
        Route::get('pembelian', 'Customer\PembelianController@riwayat')->name('pembelian.riwayat');
        Route::post('pembelian/upload-bukti-pembayaran/{id}', 'Customer\PembelianController@uploadPembayaran')->name('pembelian.upload.pembayaran');
        Route::get('pembelian/pesanan-sampai', 'Customer\PembelianController@sampai')->name('pembelian.sampai');

        Route::get('testimoni/get-order-detail', 'Customer\TestimoniController@getOrderDetail')->name('testimoni.get.order.detail');
        Route::post('testimoni/store', 'Customer\TestimoniController@store')->name('testimoni.store');

    });

});

Route::group(['middleware' => ['auth.admin.home']], function () {

    Route::get('/admin', 'Auth\LoginController@showLoginForm')->name('login.admin');
    Route::get('admin/logout', 'Auth\LoginController@logout')->name('logout.admin');
    Route::post('admin/login/proses', 'Auth\LoginController@login')->name('login.proses');

    Route::group(['middleware' => ['auth.admin']], function () {

        Route::get('admin/dashboard', 'Admin\DashboardController@index')->name('dashboard');

    	/*
    	|--------------------------------------------------------------------------
    	| Whatsapp Routes
    	|--------------------------------------------------------------------------
    	|
    	*/
        Route::get('admin/whatsapp', 'Admin\WhatsAppController@index')->name('admin.whatsapp');
        Route::get('admin/whatsapp/disconnect', 'Admin\WhatsAppController@disconnect')->name('admin.whatsapp.disconnect');
        Route::get('admin/whatsapp/testing', 'Admin\WhatsAppController@testing')->name('admin.whatsapp.testing');

        Route::get('admin/whatsapp/create', 'Admin\WhatsAppController@create')->name('admin.whatsapp.create');
        Route::post('admin/whatsapp/store', 'Admin\WhatsAppController@store')->name('admin.whatsapp.store');
        Route::get('admin/whatsapp/{id}/edit', 'Admin\WhatsAppController@edit')->name('admin.whatsapp.edit');
        Route::put('admin/whatsapp/{id}', 'Admin\WhatsAppController@update')->name('admin.whatsapp.update');
        Route::delete('admin/whatsapp/{id}', 'Admin\WhatsAppController@destroy')->name('admin.whatsapp.destroy');

        /*
        |--------------------------------------------------------------------------
        | Pengaturan Routes
        |--------------------------------------------------------------------------
        |
        */
        Route::get('admin/pengaturan', 'Admin\PengaturanController@index')->name('admin.pengaturan');
        Route::get('admin/tentang-get', 'Admin\PengaturanController@get')->name('admin.tentang.get');
        Route::post('admin/tentang', 'Admin\PengaturanController@upload')->name('admin.tentang.upload');
        Route::put('admin/tentang', 'Admin\PengaturanController@update')->name('admin.tentang.update');
        Route::delete('admin/tentang', 'Admin\PengaturanController@destroy')->name('admin.tentang.destroy');

        /*
        |--------------------------------------------------------------------------
        | User Routes
        |--------------------------------------------------------------------------
        |
        */
        Route::get('admin/user', 'Admin\UserController@index')->name('admin.user');
        Route::put('admin/user/{id}', 'Admin\UserController@terima')->name('admin.user.terima');
        Route::put('admin/user/{id}/{alasan}', 'Admin\UserController@tolak')->name('admin.user.tolak');
        Route::delete('admin/user/{id}', 'Admin\UserController@destroy')->name('admin.user.destroy');

        /*
        |--------------------------------------------------------------------------
        | Kategori Routes
        |--------------------------------------------------------------------------
        |
        */
        Route::get('admin/kategori', 'Admin\KategoriController@index')->name('admin.kategori');
        Route::get('admin/kategori/create', 'Admin\KategoriController@create')->name('admin.kategori.create');
        Route::post('admin/kategori/store', 'Admin\KategoriController@store')->name('admin.kategori.store');
        Route::get('admin/kategori/{id}/edit', 'Admin\KategoriController@edit')->name('admin.kategori.edit');
        Route::put('admin/kategori/{id}', 'Admin\KategoriController@update')->name('admin.kategori.update');
        Route::delete('admin/kategori/{id}', 'Admin\KategoriController@destroy')->name('admin.kategori.destroy');

        /*
        |--------------------------------------------------------------------------
        | Satuan Routes
        |--------------------------------------------------------------------------
        |
        */
        Route::get('admin/satuan', 'Admin\SatuanController@index')->name('admin.satuan');
        Route::get('admin/satuan/create', 'Admin\SatuanController@create')->name('admin.satuan.create');
        Route::post('admin/satuan/store', 'Admin\SatuanController@store')->name('admin.satuan.store');
        Route::get('admin/satuan/{id}/edit', 'Admin\SatuanController@edit')->name('admin.satuan.edit');
        Route::put('admin/satuan/{id}', 'Admin\SatuanController@update')->name('admin.satuan.update');
        Route::delete('admin/satuan/{id}', 'Admin\SatuanController@destroy')->name('admin.satuan.destroy');

        /*
        |--------------------------------------------------------------------------
        | Wilayah Routes
        |--------------------------------------------------------------------------
        |
        */
        Route::get('admin/wilayah', 'Admin\WilayahController@index')->name('admin.wilayah');
        Route::get('admin/wilayah/create', 'Admin\WilayahController@create')->name('admin.wilayah.create');
        Route::post('admin/wilayah/store', 'Admin\WilayahController@store')->name('admin.wilayah.store');
        Route::get('admin/wilayah/{id}/edit', 'Admin\WilayahController@edit')->name('admin.wilayah.edit');
        Route::put('admin/wilayah/{id}', 'Admin\WilayahController@update')->name('admin.wilayah.update');
        Route::delete('admin/wilayah/{id}', 'Admin\WilayahController@destroy')->name('admin.wilayah.destroy');

    	/*
    	|--------------------------------------------------------------------------
    	| Produk Routes
    	|--------------------------------------------------------------------------
    	|
    	*/
        Route::get('admin/produk', 'Admin\ProdukController@index')->name('admin.produk');
        Route::get('admin/produk/create', 'Admin\ProdukController@create')->name('admin.produk.create');
        Route::post('admin/produk/store', 'Admin\ProdukController@store')->name('admin.produk.store');
        Route::get('admin/produk/{id}/edit', 'Admin\ProdukController@edit')->name('admin.produk.edit');
        Route::get('admin/produk/{id}/kirim-email', 'Admin\ProdukController@resendProduk')->name('admin.produk.resend');
        Route::put('admin/produk/{id}', 'Admin\ProdukController@update')->name('admin.produk.update');
        Route::put('admin/produk/{id}/delete', 'Admin\ProdukController@delete')->name('admin.produk.delete');
        Route::delete('admin/produk/{id}/destroy', 'Admin\ProdukController@destroy')->name('admin.produk.destroy');
        Route::post('admin/produk/{id}/restore', 'Admin\ProdukController@restore')->name('admin.produk.restore');


        /*
        |--------------------------------------------------------------------------
        | Warna Routes
        |--------------------------------------------------------------------------
        |
        */
        Route::get('admin/warna', 'Admin\WarnaController@index')->name('admin.warna');
        Route::get('admin/warna/create', 'Admin\WarnaController@create')->name('admin.warna.create');
        Route::post('admin/warna/store', 'Admin\WarnaController@store')->name('admin.warna.store');
        Route::get('admin/warna/{id}/edit', 'Admin\WarnaController@edit')->name('admin.warna.edit');
        Route::put('admin/warna/{id}', 'Admin\WarnaController@update')->name('admin.warna.update');
        Route::put('admin/warna/{id}/delete', 'Admin\WarnaController@delete')->name('admin.warna.delete');
        Route::delete('admin/warna/{id}/destroy', 'Admin\WarnaController@destroy')->name('admin.warna.destroy');
        Route::post('admin/warna/{id}/restore', 'Admin\WarnaController@restore')->name('admin.warna.restore');

        /*
        |--------------------------------------------------------------------------
        | Daftar Pesanan Routes
        |--------------------------------------------------------------------------
        |
        */
        Route::get('admin/daftar-pesanan', 'Admin\DaftarPesananController@index')->name('admin.daftar-pesanan');
        Route::put('admin/daftar-pesanan/{id}/{alasan}', 'Admin\DaftarPesananController@batalkan')->name('admin.daftar-pesanan.batalkan');
        Route::put('admin/terima-pesanan/{id}', 'Admin\DaftarPesananController@terima')->name('admin.daftar-pesanan.terima');

        /*
        |--------------------------------------------------------------------------
        | Pesanan Diterima Routes
        |--------------------------------------------------------------------------
        |
        */
        Route::get('admin/pesanan-diterima', 'Admin\PesananDiterimaController@index')->name('admin.pesanan-diterima');
        Route::put('admin/pesanan-diterima/{id}/{alasan}', 'Admin\PesananDiterimaController@batalkan')->name('admin.pesanan-diterima.batalkan');
        Route::put('admin/proses-pesanan/{id}', 'Admin\PesananDiterimaController@proses')->name('admin.pesanan-diterima.proses');
        Route::put('admin/kirim-pesanan/{id}', 'Admin\PesananDiterimaController@kirim')->name('admin.pesanan-diterima.kirim');
        Route::put('admin/selesai-pesanan/{id}', 'Admin\PesananDiterimaController@selesai')->name('admin.pesanan-diterima.selesai');

        /*
        |--------------------------------------------------------------------------
        | Pesanan Dibatalkan Routes
        |--------------------------------------------------------------------------
        |
        */
        Route::get('admin/pesanan-dibatalkan', 'Admin\PesananDibatalkanController@index')->name('admin.pesanan-dibatalkan');
        Route::put('admin/pesanan-dibatalkan/{id}/{alasan}', 'Admin\PesananDibatalkanController@batalkan')->name('admin.pesanan-dibatalkan.batalkan');

        /*
        |--------------------------------------------------------------------------
        | Laporan Routes
        |--------------------------------------------------------------------------
        |
        */
        Route::get('laporan/transaksi', 'Admin\LaporanController@index')->name('laporan.transaksi');
        Route::get('laporan/cetak', 'Admin\LaporanController@cetakExcel')->name('laporan.cetak');
        Route::get('laporan/get', 'Admin\LaporanController@getChart')->name('laporan.get');
        Route::get('laporan/get-pelanggan', 'Admin\LaporanController@getChartPelanggan')->name('laporan.get.pelanggan');
        Route::get('laporan/get-produk', 'Admin\LaporanController@getChartProduk')->name('laporan.get.produk');


        Route::get('logout', 'Auth\LoginController@logout')->name('admin.auth.logout');
    });

});
