@extends('layouts.home')
@section('title', 'Profile')
@push('css')
@section('content')
<style type="text/css">
    input,
    input::-webkit-input-placeholder {
        font-size: 12px;
        line-height: 3;
    }

    .image-cropper {
        position: relative;
        overflow: hidden;
        border-radius: 50%;
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
        $.get("{{ route('cek.username.customer') }}",
        {
            username : $('#username').val()
        },
        function(res){
            if ('{{ auth()->user()->username }}' == $('#username').val()) {
                document.getElementById('koreksi-username').innerHTML = '';
                document.getElementById('daftar').disabled = false;
            }else{
                if (res.status == false) {
                    document.getElementById('koreksi-username').innerHTML = 'Username sudah digunakan';
                    document.getElementById('daftar').disabled = true;
                }else{
                    document.getElementById('koreksi-username').innerHTML = '';
                    document.getElementById('daftar').disabled = false;
                }
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

    var loadImageKTP = function(e, targetPreview) {
        var output = document.getElementById(targetPreview);
        output.src = URL.createObjectURL(event.target.files[0]);
        output.onload = function() {
            URL.revokeObjectURL(output.src);
            $('#preview-ktp').show();
            $('#koreksi-ktp').hide();
        }
    };

    var loadImageFoto = function(e, targetPreview) {
        var output = document.getElementById(targetPreview);
        output.src = URL.createObjectURL(event.target.files[0]);
        output.onload = function() {
            URL.revokeObjectURL(output.src);
        }
    };
</script>
<section class="shop_section pb-5">
    <div class="heading_container">
        <div class="container">
            <h2>
                Profile
            </h2>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
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
            <div class="card" style="margin-right: 10%; margin-left: 10%;">
                <div class="card-body">
                    <form id="form-login" action="{{ route('profile.update', $user->id) }}" method="post" enctype="multipart/form-data">
                        @method('PUT')
                        @csrf
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="float-left">
                                    <h5>Lengkapi data dengan benar</h5>
                                </div>
                                <div class="float-right">
                                    <div class="form-group">
                                        <button type="submit" class="btn btn-primary form-control" id="daftar">Simpan Perubahan</button>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    @if($user->foto)
                                        <img src="{{ asset($user->foto) }}" class="image-cropper mb-2" width="100px" height="100px">
                                    @else
                                        <img src="{{ asset('default.png') }}" class="image-cropper mb-2" id="preview-foto" width="100px">
                                    @endif
                                    <input type="file" name="foto" class="form-control" onchange="loadImageFoto(event, 'preview-foto')">
                                </div>
                                <div class="form-group">
                                    <label><small>Nama Lengkap</small></label>
                                    <input type="text" name="nama_lengkap" id="nama" class="form-control" value="{{ old('nama_lengkap') ? old('nama_lengkap') : $user->nama }}" required placeholder="Contoh : Deyana Putri" onkeypress="return event.charCode < 48 || event.charCode > 57" oninput="cekNamaLengkap()">
                                    <small style="color: red; font-size: 0.7rem;" id="koreksi-nama"></small>
                                </div>
                                <div class="form-group">
                                    <label><small>Email</small></label>
                                    <input type="email" name="email" id="email" value="{{ old('email') ? old('email') : $user->email }}" class="form-control" required placeholder="Contoh : user@gmail.com" oninput="cekEmail()">
                                    <small style="color: red; font-size: 0.7rem;" id="koreksi-email"></small>
                                </div>
                                <div class="form-group">
                                    <label><small>No Hp</small></label>
                                    <input type="text" name="nohp" class="form-control" id="nohp" value="{{ old('nohp') ? old('nohp') : $user->nohp }}" required placeholder="Contoh : 08212996xxxx" onkeypress="return event.charCode >= 48 && event.charCode <=57" oninput="cekNoHP()">
                                    <small style="color: red; font-size: 0.7rem;" id="koreksi-nohp"></small>
                                </div>
                                <div class="form-group">
                                    <label><small>Username</small></label>
                                    <input type="text" name="username" id="username" class="form-control" value="{{ old('username') ? old('username') : $user->username }}" placeholder="Contoh : deyana" required oninput="cekUsername()">
                                    <small style="color: red; font-size: 0.7rem;" id="koreksi-username"></small>
                                </div>
                                <div class="form-group">
                                    <label><small>Password</small></label>
                                    <input type="password" name="password" id="password" class="form-control" placeholder="Masukan password" oninput="cekKarakterPassword()">
                                    <small style="color: red; font-size: 0.7rem;" id="koreksi-password"></small>
                                </div>
                                <div class="form-group">
                                    <label><small>Konfirmasi Password</small></label>
                                    <input type="password" name="konfirmasi_password" id="konfirmasi-password" class="form-control" placeholder="Masukan Konfirmasi password" oninput="cekKonfirmasiPassword()">
                                    <small style="color: red; font-size: 0.7rem;" id="koreksi-konfirmasi-password"></small>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <!-- <div class="form-group">
                                    <label><small>KTP</small></label>
                                    <div class="card" style="margin-bottom: 12px; width: 300px; height: 180px;">
                                        <div class="card-body">
                                            <div class="text-center">
                                                @if($user->ktp)
                                                <img src="{{ asset($user->ktp) }}" style="display: show; width: 250px; height: 140px;">
                                                @else
                                                <div class="text-center" style="margin-top: 60px; display: show;" id="koreksi-ktp">
                                                    KTP Kosong
                                                </div>
                                                <img src="" id="preview-ktp" style="display: none; width: 250px; height: 140px;">
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                    <input type="file" name="ktp" id="ktp" class="form-control" value="{{ old('ktp') ? old('ktp') : $user->ktp }}" accept="image/*" onchange="loadImageKTP(event, 'preview-ktp')">
                                    <small style="color: red; font-size: 0.7rem;" id="koreksi-ktp"></small>
                                </div> -->
                                <div class="form-group">
                                    <label><small>Wilayah</small></label>
                                    <select name="wilayah_id" class="form-control">
                                            <option value="">-- Pilih Wilayah --</option>
                                        @foreach($wilayah as $row)
                                            <option @if($user->wilayah_id == $row->id) selected @endif value="{{ $row->id }}">{{ $row->nama }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label><small>Alamat Lengkap</small></label>
                                    <textarea class="form-control" rows="5" name="alamat" placeholder="No Rumah/Blok, Rt dan Rw, Nama desa, Nama Kota">{{ old('alamat') ? old('alamat') : $user->alamat }}</textarea>
                                </div>
                            </div>
                        </div>
                    </form>
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
