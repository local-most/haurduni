<?php

namespace App\Providers;

use Carbon\Carbon;
use Illuminate\Support\ServiceProvider;
use App\Models\Order;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Carbon::setLocale('id');
        date_default_timezone_set('Asia/Jakarta');
        view()->composer('layouts.admin', function ($view){

            $order_baru = count(Order::where('status', statusOrder('baru'))->get());
            $order_diterima = count(Order::where('status', statusOrder('diterima'))->get());
            $order_diproses = count(Order::where('status', statusOrder('diproses'))->get());
            $order_pengiriman = count(Order::where('status', statusOrder('dikirim'))->get());
            $order_sampai = count(Order::where('status', statusOrder('sampai'))->get());

            $order_dibatalkan = count(Order::where('status', statusOrder('dibatalkan'))->get());

            $view->with('pesanan_baru_count', $order_baru);
            $view->with('pesanan_diterima_count', ($order_diterima + $order_diproses + $order_pengiriman + $order_sampai));
            $view->with('pesanan_dibatalkan_count', $order_dibatalkan);

        });
        view()->composer('layouts.home', function ($view){

            $social = \App\Models\Feature::getByName('social-media');
            $about = \App\Models\Feature::getByName('about-us');
            $kategori = \App\Models\Kategori::get();

            $view->with('kategori', $kategori);
            $view->with('social', $social);
            $view->with('about', $about);

        });
    }
}
