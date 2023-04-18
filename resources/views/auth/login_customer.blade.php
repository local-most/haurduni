@extends('layouts.home')
@section('title', 'Login')

@section('content')
<style type="text/css">
    input,
    input::-webkit-input-placeholder {
        font-size: 12px;
        line-height: 3;
    }
</style>
<section class="shop_section pb-5">
    <div class="container">
        <div class="heading_container heading_center">
            <h2>
                Haurduni Motor
            </h2>
        </div>
        <div class="row">
            <div class="col-md-3">
            </div>
            <div class="col-md-6">
                <div class="card" style="margin-right: 10%; margin-left: 10%;">
                    <div class="card-body">
                        <h6 class="pb-2"><b>Masuk</b></h6>
                        @if( session('msg') )
                        <?php
                        $msg = session('msg');
                        ?>
                        <div class="row">
                            <div class="col-sm-12 text-center pb-3">
                                <div class="badge alert-{{ $msg['type'] }} alert-remove">
                                    {!! $msg['text'] !!}
                                </div>
                            </div>
                        </div>
                        @endif
                        <form id="form-login" action="{{ route('login.customer.proses') }}" method="post">
                            @csrf
                            <div class="input-group">
                                <input type="text" name="username" id="username" class="form-control" placeholder="Username">
                            </div>
                            <small class="text-danger" id="error-username"></small>
                            <div class="input-group mt-3">
                                <input name="password" type="password" id="password" class="form-control" placeholder="Password">
                            </div>
                            <small class="text-danger" id="error-password"></small>
                            <div class="row mt-3">
                                <div class="offset-md-7 col-sm-5">
                                    <button type="submit" id="submit" class="btn btn-primary btn-block">Masuk</button>
                                </div>
                            </div>
                        </form>
                        <div class="float-left pt-3">
                            <a href="{{ route('register.customer') }}" style="font-size: 0.9rem; color: #0069d9;">Daftar</a>
                        </div>
                        <div class="float-right pt-3">
                            <!-- <a href="{{ route('register.customer') }}" style="font-size: 0.9rem; color: #0069d9;">Lupa kata sandi ?</a> -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
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
