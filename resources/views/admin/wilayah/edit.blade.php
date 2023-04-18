@extends('layouts.admin')
@section('title', 'Edit Wilayah')

@section('content')
<div class="row">
    <div class="col-6">
        <div class="card card-outline card-blue">
            <div class="card-header">
                <h3 class="card-title" id="card-title">Wilayah Baru</h3>
                <div class="card-tools">
                    <a href="{{ route('admin.wilayah') }}" class="btn btn-default"><i class="fas fa-reply"></i> Kembali</a>
                </div>
            </div>
            <div class="card-body">
                <form method="POST" action="{{ route('admin.wilayah.update', $wilayah->id) }}">
                    @method('PUT')
                    @csrf
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label>Nama Wilayah<strong class="text-danger">*</strong></label>
                                <input type="text" name="nama" class="form-control" placeholder="Nama Wilayah" required value="{{ $wilayah->nama }}">
                            </div>
                            <div class="form-group">
                                <label>Ongkos Kirim<strong class="text-danger">*</strong></label>
                                <input type="text" name="ongkir" class="form-control" placeholder="Ongkos Kirim" required onkeypress="return event.charCode >= 48 && event.charCode <=57" value="{{ $wilayah->ongkir }}">
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
@endpush
