Pengumuman berlangganan

Konfirmasi Telah Berhasil.
Selamat anda telah {{ $isSubscribed ? '' : 'Berhenti ' }}berlangganan di {{ config('app.name', 'NGP - Interior Design') }}. {{ $isSubscribed ? 'Nantikan informasi produk terbaru dari kami.' : '' }}

@if ($email)
Untuk pertanyaan, silahkan hubungi :
{{ $email }}
@endif

Copyright 2020. {{ config('app.name', 'NGP - Desain Interior') }}.
@if ($isSubscribed)
Berhenti berlangganan? silahkan klik link dibawah ini untuk berhenti berlangganan : 
{{ route('subscribed.confirm', $rememberToken) . '?unsubscribe=true' }}
@endif
