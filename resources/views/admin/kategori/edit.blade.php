@extends('layouts.admin')
@section('title', 'Edit Kategori')

@section('content')
<div class="row">
    <div class="col-6">
        <div class="card card-outline card-blue">
            <div class="card-header">
                <h3 class="card-title" id="card-title">Perubahan Kategori</h3>
                <div class="card-tools">
                    <a href="{{ route('admin.kategori') }}" class="btn btn-default"><i class="fas fa-reply"></i> Kembali</a>
                </div>
            </div>
            <div class="card-body">
                <form method="POST" action="{{ route('admin.kategori.update', $kategori->id) }}">
                    @method('PUT')
                    @csrf
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label>Nama Kategori<strong class="text-danger">*</strong></label>
                                <input type="text" name="nama" class="form-control" placeholder="Nama Kategori" value="{{ old('nama') ? old('nama') : $kategori->nama }}" required>
                            </div>
                            <div class="form-group">
                                <label>Aktifkan Warna<strong class="text-danger">*</strong></label>
                                <select class="form-control" name="is_color" required>
                                    <option @if($kategori->is_color == true) selected @endif value="1">Ya</option>
                                    <option @if($kategori->is_color == false) selected @endif value="0">Tidak</option>
                                </select>
                            </div>
                            <div class="text-right pt-3">
                                <button type="reset" class="btn btn-danger">Reset</button>&nbsp;
                                <button type="submit" class="btn btn-primary" id="btn-store">Simpan</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@push('js')

<script type="text/javascript">
    var rupiah = document.getElementById('rupiah');
    rupiah.addEventListener('keyup', function(e){
        rupiah.value = formatRupiah(this.value, 'Rp.');
    });

    function formatRupiah(angka, prefix){
        var number_string = angka.replace(/[^,\d]/g, '').toString(),
        split           = number_string.split(','),
        sisa            = split[0].length % 3,
        rupiah          = split[0].substr(0, sisa),
        ribuan          = split[0].substr(sisa).match(/\d{3}/gi);

        if(ribuan){
            separator = sisa ? '.' : '';
            rupiah += separator + ribuan.join('.');
        }

        rupiah = split[1] != undefined ? rupiah + ',' + split[1] : rupiah;
        return prefix == undefined ? rupiah : (rupiah ? 'Rp.' + rupiah : '');
    }
</script>
@endpush
