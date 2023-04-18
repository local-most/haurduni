@php $greeting = 'Selamat ' . ucwords(\App\Http\Helpers::greeting()) @endphp
Halo, {{ $greeting }}. 
Ada produk baru loh!.

{{ $product->nama }}

Deskripsi Produk :
{{ strip_tags($product->deskripsi) }} 

Terima kasih telah berlangganan

Daftar produk baru lain :


Copyright 2020. {{ config('app.name', 'Toko Harapan Mulya') }}.
Berhenti berlangganan? kunjungi link dibawah ini untuk berhenti berlangganan
