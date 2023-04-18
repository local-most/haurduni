{{ $promo->title }}
{{ $promo->description }}
Batas waktu promo hingga :
{{ $promo->end }}

Klik link dibawah ini untuk memesan :
{{ $promo->link }}
  
Daftar Produk Promo : 

@foreach ($promo->ProductPromos as $productPromo)
{{ $loop->iteration }}. {{ $productPromo->Produk->name }}
{{ \Str::limit(strip_tags($productPromo->Produk->description), 250) }}
Foto : {{ asset($productPromo->Produk->images[0]) }}

@endforeach


Terima kasih telah berlangganan

Daftar produk lain :

@foreach ($products as $p)
{{ $loop->iteration }}. {{ $p->name }}
{{ \Str::limit(strip_tags($p->description), 250) }}
Foto : {{ asset($p->images[0]) }}
Link : {{ route('product.show', $p->slug) }}

@endforeach


Copyright 2020. {{ config('app.name', 'NGP - Desain Interior') }}.
Berhenti berlangganan? Klik link dibawah untuk berhenti langganan : 
{{ route('subscribed.confirm', $rememberToken) . '?unsubscribe=true' }}
