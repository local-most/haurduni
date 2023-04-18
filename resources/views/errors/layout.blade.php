@extends('layouts.home')
@section('content')
<div id="content">
  <div class="container">
    <div class="page-content">
      <div class="error-page">
        <h1>@yield('code')</h1>
        <h3>@yield('title')</h3>
        <p>@yield('message')</p>
        <div class="text-center"><a href="{{ route('home') }}" class="btn-system btn-large">Kembali ke Home</a></div>
        <br>
      </div>
    </div>
  </div>
</div>
@endsection
