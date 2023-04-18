Konfirmasi Berlangganan

Mohon untuk mengkonfirmasi bahwa anda ingin berlangganan.

Kunjungi link dibawah ini untuk konfirmasi :
{{ route('subscribed.confirm', $rememberToken) }}
            
Jika anda menerima email ini, dan anda merasa tidak ingin berlangganan, maka abaikan email ini. Apabila anda tidak menekan link diatas maka anda tidak akan berlangganan.
@if ($email)
Untuk pertanyaan, silahkan hubungi :
{{ $email }}
@endif

Copyright 2020. {{ config('app.name', 'NGP - Desain Interior') }}.
