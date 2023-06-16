@extends('layouts.home')
@section('title', 'Daftar')
@push('css')
@section('content')
<style type="text/css">
    input,
    input::-webkit-input-placeholder {
        font-size: 12px;
        line-height: 3;
    }
</style>

<script type="text/javascript">
    function cekNamaLengkap(){
        var validasiHuruf = /^[a-zA-Z ']+$/;
        var nama = document.getElementById("nama");
        if (nama.value.match(validasiHuruf)) {
            document.getElementById('koreksi-nama').innerHTML = '';
            document.getElementById('daftar').disabled = false;
        } else {
            document.getElementById('koreksi-nama').innerHTML = 'Nama lengkap hanya boleh huruf';
            document.getElementById('daftar').disabled = true;
            nama.focus();
        }
    }

    function cekEmail() {
        var email = $('#email').val();
        var atps=email.indexOf("@");
        var dots=email.lastIndexOf(".");
        if (atps<1 || dots<atps+2 || dots+2>=email.length) {
            document.getElementById('koreksi-email').innerHTML = 'Email tidak valid';
            document.getElementById('daftar').disabled = true;
        } else {
            document.getElementById('koreksi-email').innerHTML = '';
            document.getElementById('daftar').disabled = false;
        }
    }

    function cekUsername() {
        console.log('res', 'ok');
        $.get("{{ route('cek.username.customer') }}",
        {
            username : $('#username').val()
        },
        function(res){
            console.log('res', res);
            if (res.status == false) {
                document.getElementById('koreksi-username').innerHTML = 'Username sudah digunakan';
                document.getElementById('daftar').disabled = true;
            }else{
                document.getElementById('koreksi-username').innerHTML = '';
                document.getElementById('daftar').disabled = false;
            }
        },'json');
    }

    function cekKarakterPassword() {
        if (parseInt($('#password').val().length) < 8) {
            document.getElementById('koreksi-password').innerHTML = 'Password minimal 8 karakter';
            document.getElementById('daftar').disabled = true;
        }else{
            document.getElementById('koreksi-password').innerHTML = '';
            document.getElementById('daftar').disabled = false;
        }

        if ($('#konfirmasi-password').val() != '') {
            if ($('#password').val() != $('#konfirmasi-password').val()) {
                document.getElementById('koreksi-password').innerHTML = 'Password tidak sama, mohon diisi dengan benar';
                document.getElementById('koreksi-konfirmasi-password').innerHTML = 'Password tidak sama, mohon diisi dengan benar';
                document.getElementById('daftar').disabled = true;
            }else{
                document.getElementById('koreksi-password').innerHTML = '';
                document.getElementById('koreksi-konfirmasi-password').innerHTML = '';
                document.getElementById('daftar').disabled = false;
            }
        }
    }

    function cekKonfirmasiPassword() {
        if ($('#password').val() != $('#konfirmasi-password').val()) {
            document.getElementById('koreksi-konfirmasi-password').innerHTML = 'Password tidak sama, mohon diisi dengan benar';
            document.getElementById('koreksi-password').innerHTML = 'Password tidak sama, mohon diisi dengan benar';
            document.getElementById('daftar').disabled = true;
        }else{
            document.getElementById('koreksi-password').innerHTML = '';
            document.getElementById('koreksi-konfirmasi-password').innerHTML = '';
            document.getElementById('daftar').disabled = false;
        }
    }

    function cekNoHP() {
        if (deteksiOperatorSeluler($('#nohp').val()) == true) {
            if ($('#nohp').val().length < 11) {
                document.getElementById('koreksi-nohp').innerHTML = 'No hp minimal 11 karakter';
                document.getElementById('daftar').disabled = true;
            }else if ($('#nohp').val().length > 13) {
                document.getElementById('koreksi-nohp').innerHTML = 'No hp maksimal 13 karakter';
                document.getElementById('daftar').disabled = true;
            }else{
                document.getElementById('koreksi-nohp').innerHTML = '';
                document.getElementById('daftar').disabled = false;
            }
        }else{
            document.getElementById('koreksi-nohp').innerHTML = 'No HP tidak valid';
            document.getElementById('daftar').disabled = true;
        }
    }

    function deteksiOperatorSeluler(phone) {
        const prefix = phone.slice(0, 4);
        // AXIS
        if (['0831', '0832', '0833', '0838'].includes(prefix)) return true;
        // Three
        if (['0895', '0896', '0897', '0898', '0899'].includes(prefix)) return true;
        // XL
        if (['0817', '0818', '0819', '0859', '0878', '0877'].includes(prefix)) return true;
        // INDOSAT
        if (['0814', '0815', '0816', '0855', '0856', '0857', '0858'].includes(prefix)) return true;
        // TELKOMSEL
        if (['0812', '0813', '0852', '0853', '0821', '0823', '0822', '0851', '0811'].includes(prefix)) return true;
        // SMARTFREN
        if (['0881', '0882', '0883', '0884', '0885', '0886', '0887', '0888', '0889'].includes(prefix)) return true;
        return false;
    }
</script>
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
                        <h6 class="pb-2"><b>Daftar</b></h6>
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
                        <form id="form-login" action="{{ route('register.customer.proses') }}" method="post">
                            @csrf
                            <div class="form-group">
                                <label><small>Nama Lengkap</small></label>
                                <input type="text" name="nama_lengkap" id="nama" class="form-control" required placeholder="Nama Lengkap" onkeypress="return event.charCode < 48 || event.charCode > 57" oninput="cekNamaLengkap()">
                                <small style="color: red; font-size: 0.7rem;" id="koreksi-nama"></small>
                            </div>
                            <div class="form-group">
                                <label><small>Email</small></label>
                                <input type="email" name="email" id="email" class="form-control" required placeholder="Contoh : habib@gmail.com" oninput="cekEmail()">
                                <small style="color: red; font-size: 0.7rem;" id="koreksi-email"></small>
                            </div>
                            <div class="form-group">
                                <label><small>No Hp</small></label>
                                <input type="text" name="nohp" class="form-control" id="nohp" required placeholder="Contoh : 08212996xxxx" onkeypress="return event.charCode >= 48 && event.charCode <=57" oninput="cekNoHP()">
                                <small style="color: red; font-size: 0.7rem;" id="koreksi-nohp"></small>
                            </div>
                            <div class="form-group">
                                <label><small>Username</small></label>
                                <input type="text" name="username" id="username" class="form-control" placeholder="Contoh : habib" required oninput="cekUsername()">
                                <small style="color: red; font-size: 0.7rem;" id="koreksi-username"></small>
                            </div>
                            <div class="form-group">
                                <label><small>Password</small></label>
                                <input type="password" name="password" id="password" class="form-control" placeholder="Masukan password" required oninput="cekKarakterPassword()">
                                <small style="color: red; font-size: 0.7rem;" id="koreksi-password"></small>
                            </div>
                            <div class="form-group">
                                <label><small>Konfirmasi Password</small></label>
                                <input type="password" name="konfirmasi_password" id="konfirmasi-password" class="form-control" placeholder="Masukan Konfirmasi password" required oninput="cekKonfirmasiPassword()">
                                <small style="color: red; font-size: 0.7rem;" id="koreksi-konfirmasi-password"></small>
                            </div>
                            <div class="form-group">
                                <button type="submit" class="btn btn-primary form-control" id="daftar">Daftar</button>
                            </div>
                        </form>
                        <div class="float-right pt-3">
                            <p class="d-inline" style="font-size: 0.9rem;">Sudah punya aku ?</p> <a href="{{ route('login.customer') }}" style="font-size: 0.9rem; color: #0069d9;">Masuk</a>
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
<script src="{{ asset('js/select2.full.min.js') }}"></script>
<script>
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
