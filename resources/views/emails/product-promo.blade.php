<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>{{ config('app.name', 'NGP - Interior') }}</title>
</head>
<body style="background: #fafafa">
  <div style="margin-right: auto; margin-left: auto; text-align: center">
    <img src="{{ asset('images/logo/ngp-logo.png') }}" alt="Logo NGP Interios Design" style="height: 25px; margin: 20px 0 0">
  </div>

  <div style="margin: 20px 0; padding: 28px 0; background: #0C0E3C">
    <div style="max-width: 840px; margin-left: auto; margin-right: auto; padding: 28px 27px 20px; text-align: center">
      <div>
        <h2 style="margin-bottom: 5px; color: #D9740B;">{{ $promo->title }}</h2>
        <p style="margin-bottom: 15px; font-weight: 600; color: #fff;">{{ $promo->description }}</p>
        <h2 style="margin-bottom: 20px; color: #fff;">
          {{ \Carbon\Carbon::parse($promo->end)->format('d M Y') }}
        </h2>
        <a href="{{ $promo->link }}" style="display: inline-block; font-size: 14px; padding: 10px 30px; width: auto; color: #fff; border-radius: 3px; text-tranform: uppercase; background-color: #D9740B; text-decoration: none;">Pesan</a>
      </div>
    </div>
  </div>
  
  <div style="margin: 20px 0; padding: 28px 0">
    <div style="max-width: 840px; margin-left: auto; margin-right: auto">
      <h4 style="margin: 10px 0 15px; text-align: center">Daftar Produk Promo :</h4>
      <div style="display: flex; flex-wrap: wrap; margin-left: -12px;">
        @foreach ($promo->ProductPromos as $productPromo)
          @if (count($promo->ProductPromos) > 1)
          <div style="width: calc(50% - 12px); box-sizing: border-box; margin-left: 12px; margin-bottom: 12px;">
          @else
          <div style="width: calc(100% - 12px); box-sizing: border-box; margin-left: 12px; margin-bottom: 12px;">
          @endif
            <img src="{{ asset($productPromo->Produk->images[0]) }}" style="object-position: center; object-fit: cover; width: 100%; height: 180px;" alt="Foto produk {{ $productPromo->Produk->name }}">
            <h5 style="margin: 10px 0 5px; color: #0C0E3C;">{{ $productPromo->Produk->name }}</h5>
            <a href="{{ route('product.show', $productPromo->Produk->slug) }}">Lihat Detail -></a>
          </div>
        @endforeach
      </div>
    </div>
  </div>

  <div style="max-width: 840px; margin-left: auto; margin-right: auto">
    <div style="margin-top: 40px">
      <h4 style="color: #0C0E3C; text-align: center;">Terima kasih telah berlangganan</h4>
      <p style="text-align: center; color: #575656; margin: 10px 0 15px">
        Daftar produk lain :
      </p>
      <div style="display: flex; flex-wrap: wrap; margin-left: -12px;">
        @foreach ($products as $p)
          @if (count($products) > 2)
          <div style="width: calc(33.333% - 12px); box-sizing: border-box; margin-left: 12px; margin-bottom: 12px;">
          @elseif (count($products) > 1)
          <div style="width: calc(50% - 12px); box-sizing: border-box; margin-left: 12px; margin-bottom: 12px;">
          @else
          <div style="width: calc(100% - 12px); box-sizing: border-box; margin-left: 12px; margin-bottom: 12px;">
          @endif
            <img src="{{ asset($p->images[0]) }}" style="object-position: center; object-fit: cover; width: 100%; height: 180px;" alt="Foto produk {{ $p->name }}">
            <h5 style="margin: 10px 0 5px; color: #0C0E3C;">{{ $p->name }}</h5>
            <a href="{{ route('product.show', $p->slug) }}" style="word-wrap: wrap">Lihat Detail -></a>
          </div>
        @endforeach
      </div>
    </div>
    <div style="padding: 60px 0 20px">
      <p style="text-align: center; color: #0C0E3C;">
        Copyright 2020.<br>{{ config('app.name', 'NGP - Desain Interior') }}.<br>
        <span style="font-size: 1em; color: #575656;">Berhenti berlangganan? <a href="{{ route('subscribed.confirm', $rememberToken) . '?unsubscribe=true' }}" style="color: #0C0E3C;">Unsubscribe</a></span>
      </p>
    </div>
  </div>
</body>
</html>
