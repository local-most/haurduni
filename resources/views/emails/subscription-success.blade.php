<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>{{ config('app.name', 'NGP - Interior') }}</title>
</head>
<body>
  <div style="margin: 20px 0; padding: 28px 0; background: #ffe0b2">
    <div style="max-width: 840px; margin-right: auto; margin-left: auto; padding: 28px 15px 20px">
      <div style="padding: 27px 27px 34px; background: #fafafa">
        <div style="margin-bottom: 34px; text-align: center">
          <img src="{{ asset('images/logo/ngp-logo.png') }}" alt="Logo NGP Interios Design" style="height: 25px; margin: 20px 0 0">
        </div>
        <div>
          <p style="margin-bottom: 5px; font-weight: 600; color: #D9740B;">Pengumuman Berlangganan</p>
          <h2 style="margin-bottom: 20px; color: #0C0E3C;">Konfirmasi Telah Berhasil.</h2>
          <p style="margin: 20px 0 0; color: #575656">
            Selamat anda telah {{ $isSubscribed ? '' : 'Berhenti ' }}berlangganan di {{ config('app.name', 'NGP - Interior Design') }}. {{ $isSubscribed ? 'Nantikan informasi produk terbaru dari kami.' : '' }}
          </p>
          @if ($email)
          <p style="margin: 20px 0 0; color: #575656">
            Untuk pertanyaan, silahkan hubungi :<br>
            <a href="mailto:{{ $email }}" style="color: #D9740B">{{ $email }}</a>
          </p>
          @endif
        </div>
      </div>
    </div>

    <div style="padding: 60px 0 20px">
      <p style="color: #0C0E3C; text-align: center;">
        Copyright &copy; 2020<br>{{ config('app.name', 'NGP - Desain Interior') }}.<br>
        @if ($isSubscribed)
        <span style="font-size: 1em; color: grey;">Berhenti berlangganan? <a href="{{ route('subscribed.confirm', $rememberToken) . '?unsubscribe=true' }}" style="color: #D9740B;">Unsubscribe</a></span>
        @endif
      </p>
    </div>
  </div>
</body>
</html>