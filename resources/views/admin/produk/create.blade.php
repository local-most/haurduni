@extends('layouts.admin')
@section('title', 'Tambah Produk')
@push('css')
<link rel="stylesheet" href="{{ asset('css/select2.min.css') }}">
<link rel="stylesheet" href="{{ asset('css/select2-bootstrap4.min.css') }}">
<style type="text/css">
.select2-selection__choice {
   background-color: #007bff !important;
   color: black !important;
}
</style>
@endpush
@section('content')
<div class="row">
    <div class="col-12">
        <div class="card card-outline card-blue">
            <div class="card-header">
                <h3 class="card-title" id="card-title">Produk Baru</h3>
                <div class="card-tools">
                    <a href="{{ route('admin.produk') }}" class="btn btn-default"><i class="fas fa-reply"></i> Kembali</a>
                </div>
            </div>
            <div class="card-body">
                <form method="POST" action="{{ route('admin.produk.store') }}" enctype="multipart/form-data">
                    @csrf
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="row">
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label>Gambar<strong class="text-danger">*</strong></label>
                                        <img src="" class="img-fluid mb-2" id="preview-img-1">
                                        <input type="file" name="foto1" class="form-control" required accept="image/*" onchange="loadImage(event, 'preview-img-1')">
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label>Kategori<strong class="text-danger">*</strong></label>
                                <select class="form-control" name="kategori_id" required>
                                    @foreach($kategori as $row)
                                    <option value="{{ $row->id }}">{{ $row->nama }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label>Satuan<strong class="text-danger">*</strong></label>
                                <select class="form-control" name="satuan_id" required>
                                    @foreach($satuan as $row)
                                    <option value="{{ $row->id }}">{{ $row->nama }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label>Nama Produk<strong class="text-danger">*</strong></label>
                                <input type="text" name="nama" class="form-control" placeholder="Nama Produk" required>
                            </div>
                            <div class="form-group">
                                <label>Harga Satuan<strong class="text-danger">*</strong></label>
                                <input name="harga" id="harga" class="form-control" placeholder="Harga Produk" required id="rupiah" onkeypress="return hanyaAngka(event)">
                            </div>
                            <div class="form-group">
                                <label>Stok Produk<strong class="text-danger">*</strong></label>
                                <input type="text" name="stok" class="form-control" placeholder="Stok Produk" required onkeypress="return event.charCode >= 48 && event.charCode <=57">
                            </div>
                            <div class="form-group">
                                <label>Berat Produk<strong class="text-danger">*</strong></label>
                                <input type="text" name="berat" class="form-control" placeholder="Berat Produk" required onkeypress="return event.charCode >= 48 && event.charCode <=57">
                            </div>
                            <div class="form-group">
                                <label>Diskon %<strong class="text-danger"></strong></label>
                                <input type="text" id="diskon_persen" name="diskon_persen" oninput="generateDiskonRupiah()" class="form-control" placeholder="Diskon %" required onkeypress="return event.charCode >= 48 && event.charCode <=57">
                            </div>
                            <div class="form-group">
                                <label>Diskon Rupiah<strong class="text-danger"></strong></label>
                                <input type="text" id="diskon_rupiah" name="diskon_rupiah" class="form-control" placeholder="Rp. 0" required onkeypress="return event.charCode >= 48 && event.charCode <=57" readonly>
                            </div>
                            <!-- <div class="form-group">
                                <label>Warna<strong class="text-danger"></strong></label>
                                <select id="selectwarna" class="form-control select2" name="warna_id[]" multiple="multiple" data-placeholder="Pilih Warna">
                                    <option value="">-- Pilih Warna --</option>
                                    @foreach($warna as $row)
                                        <option value="{{ $row->id }}">{{ $row->nama }}</option>
                                    @endforeach
                                </select>
                            </div> -->
                            <div class="form-group">
                                <label>Deskripsi Produk<strong class="text-danger">*</strong></label>
                                <textarea id="content" name="deskripsi"></textarea>
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
<script src="{{ asset('js/select2.full.min.js') }}"></script>
<script type="text/javascript">
    ClassicEditor.create(document.querySelector('textarea#content'), {
        toolbar: {
            items: ['bold', 'italic', 'heading', '|', 'bulletedList', 'numberedList', '|', 'indent', 'outdent', '|', 'blockQuote', 'insertTable', 'undo', 'redo']
        },
        language: 'id',
        table: {
            contentToolbar: ['tableColumn', 'tableRow', 'mergeTableCells']
        }
    })
    .then(function(editor) {
        window.editor = editor;
    })
    .catch(function(error) {
        console.error(error);
    });

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

    var loadImage = function(e, targetPreview) {
        var output = document.getElementById(targetPreview);
        output.src = URL.createObjectURL(event.target.files[0]);
        output.onload = function() {
            URL.revokeObjectURL(output.src);
        }
    };

    function generateDiskonRupiah() {
        const hargaProduk = $('#harga').val()
        const diskon = $('#diskon_persen').val()

        const hasil = diskon/100*hargaProduk
        $('#diskon_rupiah').val(hasil)
    }

    $(document).ready(function(){
        $('#selectwarna').select2();
    });
</script>
@endpush
