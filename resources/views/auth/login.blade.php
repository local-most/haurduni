@extends('layouts.auth')
@section('title', 'Login')
@section('content')
<div class="login-box">
    <div class="card card-outline card-blue">
        <div class="card-body login-card-body">
            <div class="login-logo">
                <img src="{{ asset('images/logo.png') }}" alt="Logo Haurduni Motor" width="100px">
            </div>
            <p class="login-box-msg">Haurduni Motor | Administrator</p>
            @if( session('msg') )
            <?php
            $msg = session('msg');
            ?>
            <div class="alert alert-{{ $msg['type'] }} alert-remove">
                {!! $msg['text'] !!}
            </div>
            @endif
            <form id="form-login" action="{{ route('login.proses') }}" method="post">
                @csrf
                <div class="input-group">
                    <input type="text" name="username" id="username" class="form-control" placeholder="Username">
                    <div class="input-group-append">
                        <div class="input-group-text">
                            <span class="fas fa-user"></span>
                        </div>
                    </div>
                </div>
                <small class="text-danger" id="error-username"></small>
                <div class="input-group mt-3">
                    <input name="password" type="password" id="password" class="form-control" placeholder="Password">
                    <div class="input-group-append">
                        <div class="input-group-text">
                            <span class="fas fa-lock"></span>
                        </div>
                    </div>
                </div>
                <small class="text-danger" id="error-password"></small>
                <div class="row mt-3">
                    <div class="offset-md-8 col-sm-4">
                        <button type="submit" id="submit" class="btn btn-primary btn-block">Masuk</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
@section('js')
<script type="text/javascript">
    $(document).ready(function(){
        if ($(".alert-remove").length > 0) {
          let delay = $(".alert-remove").data('delay');
          setTimeout(function(){
            $(".alert-remove").slideUp(500);
        },typeof delay !== 'undefined' ? parseInt(delay) : 2000);
      }
  });
</script>
@endsection
